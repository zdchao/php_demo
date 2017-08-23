<?php
class MailAPI extends API
{
	public function __construct()
	{
		load_lib('pub:beanstalk');
	}
	public function addUserEmail($user,  $mode = 'reg')
	{
		$dir = dirname(dirname(__FILE__)).'/';
		$tpl = tpl::getClass($dir);
		if (is_array($user)) {
			$userinfo = $user;
		}else {
			$userinfo = apicall('users','getByEmail',array($user));
		}
		$tpl->assign('user',$userinfo['email']);
		global $default_server_email;
		if ($userinfo['proxy']) {
			$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy'],$userinfo['server'],'cpsetting'));
		}else {
			$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		}
		$web_domain  = $webconfig['web_domain'];
		$httphost = $this->createHttpHost($web_domain);
		$tpl->assign('web_domain',$httphost);
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_name',$web_name);
		if ($mode == 'findpasswd') {
			$url = $httphost . '/user/?c=public&a=resetPasswd';
			$row['user'] = $user;
			$row['t'] = time();
			$row['s'] = md5($row['user'].$row['t'].$userinfo['passwd']);
			$info = base64_encode(json_encode($row));
			$url .= '&info='.$info;
			$tpl->assign('url',$url);
			$tpl->assign('server_email',$default_server_email);
			$body = $tpl->fetch('templete/findpasswd.html');
			$title = $web_name.'密码找回';
		} else {
			$url = $httphost . '/user/?c=public&a=checkReg&';
			$row['user'] = $userinfo['email'];
			$row['token'] = md5($userinfo['salt'].$row['user'].md5($row['user']));
			$info = base64_encode(json_encode($row));
			$url .= 'info='.$info;
			$tpl->assign('url',$url);
			$tpl->assign('server_email',$default_server_email);
			$body = $tpl->fetch('templete/reg.html');
			$title = '欢迎注册'.$web_name;
		}
		return $this->sendMail($userinfo['email'], $title, $body);
		//return apicall('mail','sendSyncMail',array($userinfo['email'],$title,$body,false));
	}
	//用户购买,升级,续费 邮件,购买cdn产品
	public function userBuyProduct($userinfo,$domaininfo,$newpinfo,$money,$month,$mem){
		$dir = dirname(dirname(__FILE__)).'/';
		$tpl = tpl::getClass($dir);
		$mail = $userinfo['email'];
		$userName = $userinfo['name'];//用户名
		$domain = $domaininfo['name'];//购买域名
		$product = $newpinfo['name'];//产品名称
		$tpl->assign('userName',$userName);
		$tpl->assign('domain',$domain);
		$tpl->assign('product',$product);
		$tpl->assign('money',$money);
		$tpl->assign('month',$month);
		$tpl->assign('mem',$mem);
		$body = $tpl->fetch('templete/buycdnproduct.html');
		return apicall('mail','sendMail',array($mail,$mem,$body));
	}
	//cdn发送邮件功能
	public function cdn($email,$title,$arr,$tname){
		$dir = dirname(dirname(__FILE__)).'/';
		$tpl = tpl::getClass($dir);
		$mail = $email;
		foreach ($arr as $key=>$value){
			$tpl->assign($key,$value);
		}
		$template = "templete/".$tname;
		$body = $tpl->fetch($template);
		return apicall('mail','sendMail',array($mail,$title,$body));
	}
	public function sendBlocknsNotice($domaininfo,$status,$time,$frombeanstalk)
	{
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		$tpl = tpl::getClass(TEMPLATE_DIR);
		$tpl->assign('status',$status);
		$tpl->assign('domain',$domaininfo['name']);
		$tpl->assign('time',$time);
		$tpl->assign('user',$userinfo['name']);
		$tpl->assign('email',$userinfo['email']);
		if ($userinfo['proxy']) {
			$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy'],$userinfo['server'],'cpsetting'));
		}else {
			$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		}
		//$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$web_domain  = $webconfig['web_domain'];
		$httphost = $this->createHttpHost($web_domain);
		$tpl->assign('web_domain',$httphost);
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_name',$web_name);
		$body = $tpl->fetch('domain_blockns.html');
		if ($status==0) {
			$title = '[' . $domain . ']开始攻击';
		}else{
			$title = '[' . $domain . ']已经停止攻击,持续[' . $time . ']秒';
		}
		if ($frombeanstalk) {
			//如果这条记录是从后台的自动脚本里发出的，则不能再发送到消息队列，必需要用同步发送
			apicall('mail','sendSyncMail',array($userinfo['email'],$title,$body));
		}else {
			apicall('mail','sendMail',array($userinfo['email'],$title,$body));
		}
		//插入信息到用户的消息中心
		daocall('notice','add',array($uid,$domaininfo['name'],$title,$body));
	
		$statusmsg = $status==0 ? '有攻击' : '攻击停止';
		$server_mail_title = $web_domain.'域名'.$statusmsg;
		$server_mail_body = $domaininfo['name'].$statusmsg;
		$this->sendToServerEmail($userinfo['server'], $server_mail_title, $server_mail_body,$frombeanstalk);
	}
	public function sendMovecitedNotice($domaininfo,$status)
	{
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		if (!$userinfo) {
			return false;
		}
		$tpl = tpl::getClass(TEMPLATE_DIR);
		$tpl->assign('status',$status);
		$tpl->assign('domain',$domaininfo['name']);
		$tpl->assign('user',$userinfo['name']);
		$tpl->assign('email',$userinfo['email']);
		if ($userinfo['proxy']) {
			$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy'],$userinfo['server'],'cpsetting'));
		}else {
			$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		}
		$web_domain  = $webconfig['web_domain'];
		$httphost = $this->createHttpHost($web_domain);
		$tpl->assign('web_domain',$httphost);
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_name',$web_name);
		$body = $tpl->fetch('domain_admin_movecited.html');
		$title = "域名攻击提示";
		apicall('mail','sendMail',array($userinfo['email'],$title,$body));
		daocall('notice','add',array($uid,$domaininfo['name'],$title,$body));
	
		$statusmsg = $status==0 ? '解除' : '进入';
		$server_mail_title = $web_domain.'域名'.$statusmsg.'迁引通知';
		$server_mail_body = $domaininfo['name'].$statusmsg.'迁引';
		$this->sendToServerEmail($userinfo['server'], $server_mail_title, $server_mail_body);
	}
	/**
	 * 发送禁用的通知，当前只发送邮件，以后做短信也在这里hook
	 * @param unknown $domaininfo
	 * @param unknown $status
	 */
	public function sendStatusNotice($domaininfo,$status)
	{
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		$tpl = tpl::getClass(TEMPLATE_DIR);
		$tpl->assign('status',$status);
		$tpl->assign('domain',$domaininfo['name']);
		$tpl->assign('user',$userinfo['name']);
		if ($userinfo['proxy']) {
			$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy'],$userinfo['server'],'cpsetting'));
		}else {
			$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		}
		//$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$web_domain  = $webconfig['web_domain'];
		$httphost = $this->createHttpHost($web_domain);
		$tpl->assign('web_domain',$httphost);
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_name',$web_name);
		$body = $tpl->fetch('domain_admin_status.html');
		$title = '域名管理提示';
		apicall('mail','sendMail',array($userinfo['email'],$title,$body));
		daocall('notice','add',array($uid,$domaininfo['name'],$title,$body));
	
		$statusmsg = $status==0 ? '恢复' : '禁止';
		$server_mail_title = $web_domain.'域名'.$statusmsg.'使用通知';
		$server_mail_body = $domaininfo['name'].$statusmsg.'使用';
		$this->sendToServerEmail($userinfo['server'], $server_mail_title, $server_mail_body);
	}
	private function sendToServerEmail($server,$title,$body,$frombeanstalk=false)
	{
		$serverinfo = daocall('server','getByName',array($server));
		if (!$serverinfo) {
			return false;
		}
		if (!$serverinfo['email']) {
			return false;
		}
		//如果这条记录是从后台的自动脚本里发出的，则不能再发送到消息队列，必需要用同步发送
		if ($frombeanstalk) {
			apicall('mail','sendSyncMail',array($serverinfo['email'],$title,$body));
		}else {
			apicall('mail','sendMail',array($serverinfo['email'],$title,$body));
		}
		return true;
	}
	/**
	 * 发送锁定的通知
	 * @param unknown $domaininfo
	 * @param unknown $status
	 */
	public function sendLockNotice($domaininfo,$status)
	{
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		$tpl = tpl::getClass(TEMPLATE_DIR);
		$tpl->assign('status',$status);
		$tpl->assign('domain',$domaininfo['name']);
		$tpl->assign('user',$userinfo['name']);
		if ($userinfo['proxy']) {
			$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy'],$userinfo['server'],'cpsetting'));
		}else {
			$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		}
		//$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$web_domain  = $webconfig['web_domain'];
		$httphost = $this->createHttpHost($web_domain);
		$tpl->assign('web_domain',$httphost);
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_name',$web_name);
		$body = $tpl->fetch('domain_admin_lock.html');
		$title = '域名管理提示';
		apicall('mail','sendMail',array($userinfo['email'],$title,$body));
		daocall('notice','add',array($uid,$domaininfo['name'],$title,$body));
	
		$statusmsg = $status==0 ? '解除锁定' : '被锁定';
		$server_mail_title = $web_domain.'域名'.$statusmsg.'通知';
		$server_mail_body = $domaininfo['name'].$statusmsg;
		$this->sendToServerEmail($userinfo['server'], $server_mail_title, $server_mail_body);
	}
	public function sendExpireMail($domain)
	{
		$domaininfo = apicall('domains','getByDomain',array($domain));
		$userinfo = apicall('users','getById',array($domaininfo['uid']));
		if (! $userinfo) {
			setLastError($domain . "的用户信息不存在");
			return false;
		}
		$pinfo = daocall('product','getById',array($domaininfo['pid']));
		$dir = dirname(dirname(__FILE__)) . '/';
		$tpl = tpl::getClass($dir);
		$tpl->assign('user',$userinfo['name']?$userinfo['name'] :$userinfo['email']);
		$tpl->assign('domain',$domain);
		$tpl->assign('pid_name',$pinfo['name']);
		$tpl->assign('money',$userinfo['money']/100);
		$pid_price = $domaininfo['pid_price']>0 ? $domaininfo['pid_price'] : $pinfo['price'];
		$tpl->assign('pid_price',$pid_price);
		$tpl->assign('pid_expire_time',$domaininfo['pid_expire_time']);
		global $default_server_email;
		$tpl->assign('server_email',$default_server_email);
		$body = $tpl->fetch('templete/domainexpire.html');
		$title = '域名即将过期';
		return apicall('mail','sendMail',array($userinfo['email'],$title,$body));
	}
	public function add($body, $tube = 'mail')
	{
		global $beanstalk_cfg;
		$beanstalk = new Beanstalk($beanstalk_cfg);
		if (! $beanstalk->connect()) {
			setLastError('can`t connent to fansd');
			return false;
		}
		$beanstalk->choose($tube);
		$resultid = $beanstalk->put(23,0,60,$body);
		$beanstalk->disconnect();
		return $resultid;
	}
	public function getQueueCount($server)
	{
		global $beanstalk_cfg;
		$b = $this->getBeanstalkConnect($beanstalk_cfg);
		$tubes = $b->listTubes();
		if ($tubes) {
			foreach ($tubes as $tube) {
				$arr  = $b->statsTube($tube);
				$ret[$tube]['name'] = $arr['name']; 
				$ret[$tube]['total'] = $arr['total-jobs'];
				$ret[$tube]['ready'] = $arr['current-jobs-ready'];
			}
		}
		return $ret ? $ret : false;
	}
	public function sendMultiMail($address,$title,$body)
	{
		$arr = $this->getMailSetting($address);
		$arr['title'] = $title;
		$arr['email'] = $address;
		$arr['body'] = $body;
		$body = json_encode($arr);
		return $this->add($body,'mail');
	}
	public function sendMail($to, $title, $body, $from = '')
	{
		$arr = $this->getMailSetting($to);
		$arr['title'] = $title;
		$arr['email'] = $to;
		$arr['body'] = $body;
		$body = json_encode($arr);
		return $this->add($body,'mail');
	}
	private function getMailSetting($email)
	{
		$userinfo = apicall('users','getByEmail',array($email));
		//如果没有获取到用户信息，则可能是批量的邮件。类如:aa@aacom,bb@bb.com
		$userend = false;
		$fromend = false;
		if ($userinfo) {
			$ret['host'] = '';
			$ret['port'] = "0";
			$server = $useinfo['server'];
			$proxysetting = daocall('proxysetting','get',array($server));
			if ($proxysetting['model'] != 'default') {
				$ret['model'] = $proxysetting['model'];
				if ($proxysetting['model'] == 'smtp') {
					if ($proxysetting['smtp_host'] && $proxysetting['smtp_user'] && $proxysetting['smtp_port'] && $proxysetting['smtp_passwd']) {
						$ret['host'] = $proxysetting['smtp_host'];
						$ret['port'] = (string)$proxysetting['smtp_port'];
						$ret['user'] = $proxysetting['smtp_user'];
						$ret['passwd'] = $proxysetting['smtp_passwd'];
						$userend = true;
					}
					if ($proxysetting['smtp_from'] && $proxysetting['smtp_fromname']) {
						$ret['from'] = $proxysetting['smtp_from'];
						$ret['fromname'] = $proxysetting['smtp_fromname'];
						$fromend  = true;
					}
				}else {
					if ($proxysetting['sendcloud_apiuser'] && $proxysetting['sendcloud_apikey']) {
						$ret['user'] = $proxysetting['sendcloud_apiuser'];
						$ret['passwd'] = $proxysetting['sendcloud_apikey'];
						$userend = true;
					}
					if ($proxysetting['sendcloud_from'] && $proxysetting['sendcloud_fromname']) {
						$ret['from'] = $proxysetting['sendcloud_from'];
						$ret['fromname'] = $proxysetting['sendcloud_fromname'];
						$fromend = true;
					}
				}
			}
			if ($userinfo['proxy']) {
				$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy'],$userinfo['server'],'cpsetting'));
				if ($webconfig['web_domain'] && $webconfig['web_name']) {
					$ret['fromname'] = $webconfig['web_name'];
				}
				if ($webconfig['web_mailfrom']) {
					$ret['from'] = $webconfig['web_mailfrom'];		
				}	
				if ($ret['from'] && $ret['fromname']) {
					$fromend = true;
				}
			}
		}
		if (!$fromend || !$userend) {
			$setting = daocall('setting','getAll',array());
			if (!$userend) {
				$ret['model'] = $setting['mail_model'];
				if ($ret['model'] == 'smtp') {
					$ret['host'] = $setting['mail_host'];
					//$ret['port'] = intval($setting['mail_port']);
					$ret['port'] = (string)$setting['mail_port'];
					$ret['user'] = $setting['mail_user'];
					$ret['passwd'] = $setting['mail_passwd'];
				} else {
					$ret['user'] = $setting['sendcloud_apiuser'];
					$ret['passwd'] = $setting['sendcloud_apikey'];
				}
			}
			if (!$fromend) {
				if ($ret['model'] == 'smtp') {
					$ret['from'] = $setting['mail_from'];
					$ret['fromname'] = $setting['mail_fromname'];
				}else {
					$ret['from'] = $setting['sendcloud_from'];
					$ret['fromname'] = $setting['sendcloud_fromname'];
				}
			}
		}
		return $ret;
	}
	public function getBeanstalkConnect($beanstalk_cfg)
	{
		$beanstalk = new Beanstalk($beanstalk_cfg);
		if (! $beanstalk->connect()) {
			return false;
		}
		return $beanstalk;
	}
	public function sendPhpMailer($host,$port,$user,$passwd,$form,$formname,$to,$title,$body)
	{
		global $mail_cfg;
		$host = $host ? $host : $mail_cfg['host'];
		$port = $port ? $port : $mail_cfg['port'];
		$passwd = $passwd ? $passwd : $mail_cfg['passwd'];
		$form = $form ? $form : $mail_cfg['form'];
		$formname = $formname ? $formname : $mail_cfg['formname'];
		if (!$_REQUEST) {
			echo "send by smtp from=".$form." fromname=".$formname."\n";
			echo "host=".$host." port=".$port."\n";
		}
		$phpmailfile = dirname(dirname(dirname(__FILE__))) . '/plugin/phpmailer/class.phpmailer.php';
		include_once $phpmailfile;
		$mail = new PHPMailer();
		$mail->CharSet = "utf-8";
		$mail->From = $form;
		$mail->FromName = $formname;
		$mail->ContentType = 'text/html';
		$mail->IsSMTP();
		if (substr($port,-1)=='s') {
			$mail->SMTPSecure = 'ssl';
			$port = intval($port);
		}
		$mail->SMTPDebug = 1;
		$mail->Host = $host;
		$mail->Username = $user;
		$mail->Password = $passwd;
		$mail->Port = $port;
		$mail->Subject = $title;
		$mail->Body = $body;
		$mail->SMTPAuth = true;
		$mails = explode(',', $to);
		foreach ($mails as $to) {
			$mail->AddAddress($to);
		}
		$result = $mail->Send();
		return $result;
	}
	public function sendCloud($sendcloud_apiuser,$sendcloud_apikey,$sendcloud_from,$sendcloud_fromname,$to,$title,$body)
	{
		$url = 'https://sendcloud.sohu.com/webapi/mail.send.json';
		$multi = false;
		if (strstr($to,',')) {
			$multi = true;
		}
		$to = str_replace(',', ';', $to);
		$param = array(
				'from'		=>$sendcloud_from,
				'to'		=>$to,
				'subject'	=>$title,
				'html'		=>$body,
				'fromname'	=>$sendcloud_fromname,
				'api_key'	=>$sendcloud_apikey,
				'api_user'	=>$sendcloud_apiuser,
		);
		if ($multi) {
			$param['use_maillist'] = true;
 		}
		$options['http'] = array('method'=>"POST",'content'=>http_build_query($param));
	
		$result = file_get_contents($url, false, stream_context_create($options));
		$result = json_decode($result,true);
		if ($result['message'] =='success') {
			return true;
		}
		//print_r($result);
		setLastError(implode(',', $result['errors']));
		return false;
	}
	/**
	 * 后台发送模拟邮件,
	 * 主测邮件,因sendcloud要求样本，后台经常配置不成功,所以在前台加模拟
	 * @param unknown $domain
	 * @param unknown $template
	 */
	public function sendSimulationMail($domain,$template)
	{
		$temp_file = array(
			"reg" 			=>'reg.html',
			"findpasswd"	=>'findpasswd.html',
			'yanzheng'		=>'domain_yanzheng.html',
			'monitor'		=>'monitor.html',
			'domainexpire'	=>'domainexpire.html',
			'deny'			=>'attack_event_deny.html',
			'undeny'		=>'attack_event_undeny.html',
			'start'			=>'attack_event_start.html',
			'stop'			=>'attack_event_stop.html',
			'notice'		=>'attack_event_monitor.html'
		);
		if (!$temp_file[$template]) {
			setLastError("未找到模板".$template);
			return false;
		}
		$domaininfo  = daocall('domains','getDomainByName',array($domain));
		if (!$domaininfo) {
			setLastError("未找到域名信息");
			return false;
		}
		$userinfo = daocall('users','getById',array($domaininfo['uid']));
		if (!$userinfo) {
			setLastError("未到找用户信息");
			return false;
		}
		$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$dir = dirname(dirname(__FILE__)).'/';
		$tpl = tpl::getClass($dir);
		
		switch ($template) {
			case "reg":
				$title = '欢迎注册'.$webconfig['web_name'];
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				$tpl->assign('url','http://127.0.0.1');
				break;
			case "findpasswd":
				$tpl->assign('url','http://127.0.0.1');
				$tpl->assign('pid_price',1000);
				$title = $webconfig['web_name'].'密码找回';
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				break;
			case "domainexpire":
				$tpl->assign('domain',$domain);
				$tpl->assign('pid_name',"测试版");
				$tpl->assign('pid_expire_time','2000-01-01 00:00:00');
				$tpl->assign('money',100);
				$tpl->assign('pid_price',1000);
				$title = "域名过期";
				break;
			case "yanzheng":
				$tpl->assign('domain',$domain);
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$title = "域名验证取回";
				break;
			case "start":
				$title = $domain."有攻击";
				$tpl->assign('qps',99999);
				$tpl->assign('domain',$domain);
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				break;
			case "stop":
				$title = $domain."自动暂停";
				$tpl->assign('domain',$domain);
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				break;
			case "deny":
				$title = $domain."自动拒绝解析";
				$tpl->assign('qps',99999);
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				break;
			case "undeny":
				$tpl->assign('domain',$domain);
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				$title = $domain."自动恢复解析";
				break;
			case "notice":
				$title = $domain."监控通知";
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$tpl->assign('monitor',array('user'=>($userinfo['name']? $userinfo['name'] : $userinfo['email']),'record_name'=>'www','domain'=>$domain,'src'=>'1.1.1.1',));
				break;
			case "monitor":
				$tpl->assign('domain',$domain);
				$tpl->assign('date',date('Y-m-d H:i:s',time()));
				$tpl->assign('user',$userinfo['name']? $userinfo['name'] : $userinfo['email']);
				$tpl->assign('domainip','127.0.0.1');
				$title = $domain."开启监控成功";
				break;				
				
		}
		$tpl->assign('web_name',$webconfig['web_name']);
		$tpl->assign('web_domain',$webconfig['web_domain']);
		$body = $tpl->fetch('templete/'.$temp_file[$template]);
		if (!$body) {
			setLastError("程序错误,未找到发送内容");
			return false;
		}
		return $this->sendSyncMail($userinfo['email'],$title,$body,false);
	}
	
	
	/**
	 * {"op":"notice_tel","monitor_id":96,"domain":"kanglesoft.com","record_id":1988,"action":0,"status":1,"total_time":202,"src":"websales.com.tw","dst":"15270933993","notice":"15270933993"}
	 * tube : mn_tel
	 */
	public function send()
	{
		global $beanstalk_cfg;
		$beanstalk = new Beanstalk($beanstalk_cfg);
		if (! $beanstalk->connect()) {
			die('connect error');
		}
		$this->runcmd = true;
		while ( true ) {
			$beanstalk->watch(EMAIL_TUBE);
			$job = $beanstalk->reserve();
			if ($job === false) {
				$beanstalk->connect();
				sleep(1);
				continue;
			}
			$arr = json_decode($job['body'],true);
			$email = $arr['to'] ? $arr['to'] : $arr['email'];
			if (!$email) {
				echo "mail is empty continue\n";
				echo implode(',', $arr)."\n";
				continue;
			}
			$result = $this->sendSyncMail($email, $arr['title'], $arr['body']);
			//如果不是多个邮件,则要查找proxy的邮件设置
			//多个邮件则使用admin设置的邮件参数发送,不启用proxy的设置
			if ($result) {
				$beanstalk->delete($job['id']);
				echo $job['id'] . '=' . $email . " yes.........\n";
			} else {
				$beanstalk->bury($job['id']);
				echo $email." error=". $GLOBALS['last_error']."\n";
				echo $job['id'] . '=' . $email . " NO..........\n";
			}
		}
	}
	private $runcmd = false;
	public function sendSyncMail($email,$title,$body,$frombeanstalk=true)
	{
		if ($frombeanstalk) {
			$this->runcmd = true;
		}
		$this->showMessage("send mail to ".$email);
		$mailfrom = '';
		$mailfromname = '';
		//如果不是批量的。则要取出用户的信息，进行资料收集
		if (!strstr($email,',')) {
			$userinfo = apicall('users','getByEmail',array($email));
			if (!$userinfo) {
				for($i=0;$i<2;$i++) {
					daocall('users','resetConnect',array());
					$userinfo = apicall('users','getByEmail',array($email));
					if ($userinfo) {
						break;
					}else {
						sleep(3);
					}
				}
				if (!$userinfo) {
					$this->showMessage($email.'账号信息不存在',true);
					return false;
				}
				//重连数据库
				
			}
			$server = $userinfo['server'];
			//如果是新的代理模式
			if ($userinfo['proxy']) {
				$webconfig = apicall('setting','getCpNameDomainByProxyuid',array($userinfo['proxy']));
				if ($webconfig && $webconfig['web_mailfrom']) {
					$mailfrom = $webconfig['web_mailfrom'];
				}
				if ($webconfig && $webconfig['web_name']) {
					$mailfromname = $webconfig['web_name'];
				}
			}
			if (!$mailfrom) {
				$proxysetting = daocall('proxysetting','get',array($server));
			}
		}
		$setting = daocall('setting','getAll2',array());
		//如果设置为默认,则启用我们admin后台设置的模式
		if ($proxysetting && $proxysetting['mail_model'] == 'default') {
			$mail_model = $setting['mail_model'];
		}else {
			$mail_model = $proxysetting['mail_model'] ? $proxysetting['mail_model'] : $setting['mail_model'];
		}
		if ($mail_model=='sendcloud') {
			$this->showMessage("send model from send cloud");
			//如果是批量的邮件发送,则使用admin设置的sendcloud批量域名发
			if (strstr($email,',')) {
				$apikey =  $setting['sendcloud_multi_apikey'];
				$apiuser = $setting['sendcloud_multi_apiuser'];
			}else{
				$apikey = $proxysetting['sendcloud_apikey'] ? $proxysetting['sendcloud_apikey'] : $setting['sendcloud_apikey'];
				$apiuser = $proxysetting['sendcloud_apiuser'] ? $proxysetting['sendcloud_apiuser'] : $setting['sendcloud_apiuser'];
			}
			if (!$mailfrom) {
				$mailfrom = $proxysetting['sendcloud_from'] ? $proxysetting['sendcloud_from'] : $setting['sendcloud_from'];
			}
			if (!$mailfromname) {
				$mailfromname = $proxysetting['sendcloud_fromname'] ? $proxysetting['sendcloud_fromname'] : $setting['sendcloud_fromname'];
			}
			$result = $this->sendCloud($apiuser,$apikey,$mailfrom,$mailfromname,$email, $title, $body);
		}else {
			$host = $proxysetting['smtp_host'] ? $proxysetting['smtp_host'] : $setting['mail_host'];
			$port = $proxysetting['smtp_port'] ? $proxysetting['smtp_port'] : $setting['mail_port'];
			$user = $proxysetting['smtp_user'] ? $proxysetting['smtp_user'] : $setting['mail_user'];
			$passwd = $proxysetting['smtp_passwd'] ? $proxysetting['smtp_passwd'] : $setting['mail_passwd'];
			if (!$mailfrom) { 
				$mailfrom = $proxysetting['smtp_from'] ? $proxysetting['smtp_from'] : $setting['mail_from'];
			}
			if (!$mailfromname) {
				$mailfromname = $proxysetting['smtp_fromname'] ? $proxysetting['smtp_fromname'] : $setting['mail_fromname'];
			}
			$this->showMessage("send model from smtp");
			$result = $this->sendPhpMailer($host,$port,$user,$passwd,$mailfrom,$mailfromname, $email, $title, $body);
		}
		return $result;
	}
	private function showMessage($msg,$error=false)
	{
		if ($this->runcmd) {
			echo $msg."\n";
		}else {
			if ($error) {
				setLastError($msg);
			}
		} 
	}
	
	public function check($data){
		$domain =$data['domain'];
		$domaininfo = daocall('domains','getDomainByName',array($domain));
		if (!$domaininfo) {
		    setLastError("没有域名信息");
			return false;
		}
		$userinfo = daocall('users','getById',array($domaininfo['uid']));
		if (!$userinfo) {
			setLastError("用户不存在");
			return false;
		}
		$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$tpl = tpl::getClass(SYS_ROOT);
		$tpl->assign('user',$userinfo['name'] ? $userinfo['name'] : $userinfo['email']);
		$tpl->assign('domain',$domain);
		if ($data['t']) {
			$tpl->assign('date',date('Y-m-d H:i:s',$data['t']));
		}else {
			$tpl->assign('date',date('Y-m-d H:i:s',time()));
		}
		$tpl->assign('web_name',$webconfig['web_name']);
		$url = 'http';
		if (strtolower($_SERVER['HTTPS']) == 'on') {
			$url .= 's';
		}
		$url .= '://'.$webconfig['web_domain'];
		$tpl->assign('web_domain',$url);
		if ($data['source']== 'monitor') {
			$tpl->assign('monitor',$data);
			$content = $tpl->fetch('templete/attack_event_monitor.html');
			$title = $domain ."监控";
			return $this->sendSyncMail($userinfo['email'], $title, $content,false);
		}
		if($data['source'] == "attack"){
			$attack = array("stop","start","deny","undeny");
			foreach ($attack as $value){
				$tpl->assign('qps',intval($data['qc']/300));
				switch ($value) {
					case "stop":
						$content = $tpl->fetch('templete/attack_event_stop.html');
						$title = $domain."自动暂停";
						break;
					case "start":
						$content = $tpl->fetch('templete/attack_event_start.html');
						$title = $domain."有攻击";
						break;
					case "deny":
						$content = $tpl->fetch('templete/attack_event_deny.html');
						$title = $domain."自动拒绝解析";
						break;
					case "undeny":
						$content = $tpl->fetch('templete/attack_event_undeny.html');
						$title = $domain."自动恢复解析";
						break;
				}
				$this->sendSyncMail($userinfo['email'], $title, $content,false);
			}
		}
		/*if ($data['source'] == 'attack') {
			        $tpl->assign('qps',intval($data['qc']/300));
					$content = $tpl->fetch('templete/attack_event_stop.html');
					$title = $domain."自动暂停";
					$content = $tpl->fetch('templete/attack_event_start.html');
					$title = $domain."有攻击";
					$content = $tpl->fetch('templete/attack_event_deny.html');
					$title = $domain."自动拒绝解析";
					$content = $tpl->fetch('templete/attack_event_undeny.html');
					$title = $domain."自动恢复解析";
			}
			return 	apicall('messages','sendNotice',array($userinfo,$title,$content,$domaininfo['setting_flags']));*/
	}
}

