<?php
define(CHECK_NS_TUBE,'check_ns');
class DomainsAPI extends API
{
	protected $daoname = 'domains';
	public function checkAllowCustomNs($server)
	{
		$domain = $server . '.customns.dnsdun.com';
		$ip = gethostbyname($domain);
		if ($ip == "127.0.0.1") {
			return true;
		}
		return false;
	}
	/**
	 * 采用将域名扔到消息队列的方式，去检测域名的NS是否已修改，解决在记录处调用一次检测不及时的问题。
	 * @param unknown $list
	 */
	public function addCheckNsToBeanstalk($list,$userinfo)
	{
		if ($list) {
			$fp = fopen(SYSROOT . "/../CHECK_NS.TXT","a");
			foreach ($list as $row) {
				
				//echo "aaa";
				//如果已经是NS正常的，则要等待3小时后再次检测
				if ($row['ns_select_time']) {
					$nstime = toTime($row['ns_select_time']);
					$difftime = time() - $nstime;
					//echo "difftime=".$difftime;
					//如果NS已修改，则三天检测一次。
					if ($row['flags'] & DOMAIN_NS) {
						if ($difftime < 3600 * 3) {
							continue;
						}
					}else {
						if (defined("CHECK_NS_NO_DELAY")) {
							if ($difftime < CHECK_NS_NO_DELAY) {
								continue;
							}
						}else {
							//否则NS没修改的，一小时检测一次
							if ($difftime < 3600 * 1) {
								continue;
							}
						}
					}
				}
				$this->addCheckNsOne($row,$userinfo);
				/*
				$arr['ns_select_time'] = 'NOW()';
				apicall('domains','setByName',array($row['name'],$arr));
				*/
			}
		}
	}
	/**
	 * 添加一条域名到消息队列，供autoCheckNs()函数调用
	 * @param unknown $domaininfo
	 * @param unknown $userinfo
	 */
	private function addCheckNsOne($domaininfo,$userinfo)
	{
		
		$body['domaininfo'] = $domaininfo;
		$body['userinfo'] = $userinfo;
		apicall('mail','add',array(json_encode($body),CHECK_NS_TUBE));
		
	}
	public function autoCheckNs()
	{
		
		global $beanstalk_cfg;
		$beanstalk = new Beanstalk($beanstalk_cfg);
		if (! $beanstalk->connect()) {
			echo "beanstalk connect error sleep 2 secend exit\n";
			sleep(2);
			exit(99);
		}
		$limit = 100;
		for ($i=0;$i<$limit;$i++) {
			if (!$this->autoCheckNsOne($beanstalk)) {
				echo "check ns one error os exit---\n";
				exit(99);
			}
		}
		echo "check ns limit success os exit...\n";
		exit(99);
	}
	
	/**
	 * 只需每次取一条即可，执行完即退出，下次重新启动。保证程序的稳定。
	 * 自动从beanstalk中取出一条记录，检测用户的NS是否已修改,用于后台运行
	 */
	public function autoCheckNsOne($beanstalk)
	{
		$beanstalk->watch(CHECK_NS_TUBE);
		$job = $beanstalk->reserve();
		if ($job === false) {
			echo "reserve failed---\n";
			return false;
		}
		$beanstalk->delete($job['id']);
		$id = $job['id'];
		echo "id={$id}..";
		$json = json_decode($job['body'],true);
		$domaininfo = $json['domaininfo'];
		$userinfo = $json['userinfo'];
		$domain = $domaininfo['name'];
		$select_time = $domaininfo['ns_select_time'];
		$nsok = false;
		echo "D={$domain},T={$select_time}..";
		if (intval($select_time) > 0) {
			$nstime = toTime($select_time);
			$difftime = time() - $nstime;
			//如果NS已修改
			if ($domaininfo['flags'] & DOMAIN_NS) {
				$nsok = true;
				if ($difftime < 86400 * 3) {
					echo "ns is ok,diff time < 3 day skip..\n";
					return true;
				}
			}else {
				if (defined('CHECK_NS_NO_DELAY')) {
					if ($difftime < CHECK_NS_NO_DELAY) {
						echo "ns is not ok ,diff time < ".CHECK_NS_NO_DELAY." skip..\n";
						return true;
					}
				}else {
					//否则NS没修改的，一小时检测一次
					if ($difftime < 3600 * 1) {
						echo "ns is not ok ,diff time < 3600 skip..\n";
						return true;
					}
				}
			}
		}
		$nss = apicall('domains','query_ns',array($domain));
		$checkok = false;
		$queryok = true;
		if (!$nss) {
			echo "ns get error\n";
			return true;
		} 
		$newns = array();
		foreach ($nss as $key=>$ns) {
			array_push($newns, trim($ns,'.'));
		}
		$servers = apicall('server','getById2',array($domaininfo['server'],$domaininfo['ns1'],	$domaininfo['ns2']));
		if (!$servers) {
			echo "get dnsdun domain ns error\n";
			return true;
		}
		foreach ( $servers as $s ) {
			$s = trim($s,'.');
			if (in_array($s,$newns)) {
				$checkok = true;
			}
		}
		$arr['ns_select_time'] = 'NOW()';
		apicall('domains','setByName',array($domain,$arr));
		//如果域名本来NS就是OK的，并且检测结果也是OK，则不需要调用修改NS的接口，减少一次调用
		if ($nsok && $checkok ) {
			echo "ns ok (skip)\n";
			return true;
		}
		//如果域名本来NS就不是OK，并且检测结果也不是OK，则不需要调用修改NS的接口，减少一次调用
		if (!$nsok && !$checkok) {
			echo "ns not ok(skip)\n";
			return true;
		}
		//必需是查询到了NS。没有查询到NS，则保持原样不改动
		
		$flags = ($checkok == false) ? '-8' : '+8';
		echo "set flag ".$flags."\n";
		$ret = apicall('domains','setDomainFlags',array($domain,$flags,$domaininfo['server']));
		return true;
	}
	public function addBlockns($domain)
	{
		$domaininfo = $this->getByDomain($domain);
		if (!$domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		if ($domaininfo['blockns_id'] > 0) {
			setLastError("域名已存在阻断NS");
			return false;
		}
		$ret = $this->addAttackBlockNs($domaininfo);
		if (!$ret) {
			return false;
		}
		return true;
	}
	public function delBlockns($domain)
	{
		$domaininfo = $this->getByDomain($domain);
		if (!$domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		if ($domaininfo['blockns_id'] == 0) {
			setLastError("域名不存在阻断NS");
			return false;
		}
		$ret = $this->delAttackBlockNs($domaininfo);
		if ($ret) {
			return true;
		}
		return false;
	}
	public function changeBlocknsToStb($domain,$time=0,$frombeanstalk=false)
	{
		$domaininfo = $this->getByDomain($domain);
		if (!$domaininfo) {
			setLastError($domain."域名不存在");
			return false;
		}
		//$this->sendBlocknsNotice($domaininfo,0,$time,$frombeanstalk);
		apicall('mail','sendBlocknsNotice',array($domaininfo,0,$time,$frombeanstalk));
		//无法获取dns2005.net域名.
		$blocknsid = $domaininfo['blockns_id'];
		if ($blocknsid ==0) {
			setLastError($domain."域名没有阻断NS ID");
			return false;
		}
		$blocknsrow = daocall('blockns','getById',array($blocknsid));
		//必定存在
		$ret = apicall('blockns','changeToStb',array($blocknsid,$domaininfo));
		if ($ret) {
			return true;
		}
		return false;
	}
	private function sendBlocknsNotice($domaininfo,$status,$time,$frombeanstalk)
	{
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		$tpl = tpl::getClass(TEMPLATE_DIR);
		$tpl->assign('status',$status);
		$tpl->assign('domain',$domaininfo['name']);
		$tpl->assign('time',$time);
		$tpl->assign('user',$userinfo['name']);
		$tpl->assign('email',$userinfo['email']);
		$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$web_domain  = $webconfig['web_domain'];
		$httphost = $this->createHttpHost($web_domain);
		$tpl->assign('web_domain',$httphost);
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_name',$web_name);
		$body = $tpl->fetch('domain_blockns.html');
		$tel = $userinfo['tel'];
		if ($status==0) {
			$title = '[' . $domaininfo['name'] . ']已经停止攻击，持续[' . $time . ']秒';
		}else{
			$title = '[' . $domaininfo['name'] . ']开始攻击';
			if(!empty($tel)){
				if(date('G')>9 && date('G')<21){
					apicall('messages', 'sendMsg',array($tel,$title));
				}
			}
		}
		if ($frombeanstalk) {
			//如果这条记录是从后台的自动脚本里发出的，则不能再发送到消息队列，必需要用同步发送
			apicall('mail','sendSyncMail',array($userinfo['email'],$title,$body));
		}else {
			apicall('mail','sendMail',array($userinfo['email'],$title,$body));
		}
		//插入信息到用户的消息中心
		daocall('notice','add',array($uid,$domaininfo['name'],$title,$body));	
		$server_mail_title = $title;
		$server_mail_body = $body;
		$this->sendToServerEmail($userinfo['server'], $server_mail_title, $server_mail_body,$frombeanstalk);
	}
	/**
	 *
	 */
	public function changeBlocknsToAttack($domain,$time=0,$frombeanstalk=false)
	{
		$domaininfo = $this->getByDomain($domain);
		if (!$domaininfo) {
			setLastError($domain."域名不存在");
			return false;
		}
		//$this->sendBlocknsNotice($domaininfo,1,$time,$frombeanstalk);
		apicall('mail','sendBlocknsNotice',array($domaininfo,1,$time,$frombeanstalk));
		//无法获取如dns2005.net 阻断NS域名.
		$blocknsid = $domaininfo['blockns_id'];
		if ($blocknsid ==0) {
			setLastError($domain."域名没有阻断NS ID");
			return false;
		}
		$blocknsrow = daocall('blockns','getById',array($blocknsid));
		//必定存在
		$ret = apicall('blockns','changeToAtk',array($blocknsid,$domaininfo));
		if ($ret) {
			return true;
		}
		return false;
	}
	/**
	 * 给域名去除阻断NS
	 * @param unknown $domaininfo
	 * @param unknown $row
	 * @return boolean
	 */
	private function delAttackBlockNs($domaininfo)
	{
		$blocknsinfo = daocall('blockns','getById',array($domaininfo['blockns_id']));
		if (!$blocknsinfo) {
			setLastError("阻断NS记录信息".$domaininfo['blockns_id']."已不存在");
			return false;
		}
		$server = $domaininfo['server'];
		$domain = $domaininfo['name'];
		//删除阻断NS记录id=RECORD_BLOCKNS_ID
		$ret = apicall('records','delRecord',array(RECORD_BLOCKNS_ID,$domain,$server));
		if ($ret['result']== 200) {
			//将阻断NS更改为未使用
			apicall('blockns','changeUnuse',array($blocknsinfo,$domaininfo));
			return true;
		}
		setLastError($ret['errmsg']);
		return false;
	}
	/**
	 * 给域名增加攻击阻断NS,(id=9);
	 */
	private function addAttackBlockNs($domaininfo)
	{
		$server = $domaininfo['server'];
		$domain = $domaininfo['name'];
		$row = daocall('blockns','getRow',array($server));
		if (!$row) {
			setLastError("增加阻断NS失败,原因:未找到可以使用的记录");
			return false;
		}
		$arr['id'] = RECORD_BLOCKNS_ID;
		$arr['domain'] = $domain;
		$arr['name'] = '@';
		$arr['view'] = 0;
		$arr['t'] = 'NS';
		$arr['ttl'] = BLOCKNS_TTL;
		$arr['value'] = $row['ns'];
		if (substr($arr['value'],-1) != '.') {
			$arr['value'] .= '.';
		}
		$arr['flags'] = RECORD_HOLD;
		//$arr['replace'] = 1;
		$ret = apicall('records','addRecord',array($arr, $server));
		if ($ret['result']== 200) {
			//将阻断NS使用的这条记录修改为已使用，并更新是哪个域名使用的。
			return 	apicall('blockns','changeToStb',array($row['id'],$domaininfo));
		}
		setLastError($ret['errmsg']);
		return false;
	}
	/**
	 * 如果minute=0，则表示永久封掉，不产生迁引记录,只能由管理员手动解除，
	 * 但是会发送邮件，以及消息到用户信息中心
	 * @param unknown $domain
	 * @param unknown $minute
	 * @return boolean
	 */
	public function addMovecited($domain)
	{
		$domaininfo = $this->getByDomain($domain);
		$server = $domaininfo['server'];
		$flags = '+'.DOMAIN_IS_ATTACK;
		$ret = $this->setDomainFlags($domain, $flags, $server);
		if ($ret['result'] != 200) {
			setLastError($ret['errmsg']);
			return false;
		}
		/*
		if ($minute > 0) {
			$ret = daocall('attack','add',array($domain,$minute,$server,$remark));
			if (!$ret) {
				setLastError("数据库增加记录失败");
				return false;
			}
		}
		*/
		//$this->sendMovecitedNotice($domaininfo, 1);
		apicall('mail','sendMovecitedNotice',array($domaininfo,1));
		return true;
	}
	/**
	 * 用于后台运行调用
	 * @param unknown $attackid
	 * @return boolean|Ambigous <Mixed, boolean, mixed>
	 */
	public function delMovecitedById($attackid)
	{
		$row = daocall('attack','getById',array($attackid));
		if (!$row) {
			setLastError($domain."没有找到记录");
			return false;
		}
		$domain  = $row['domain'];
		$server = $row['server'];
		$flags = '-'.DOMAIN_IS_ATTACK;
		$ret = $this->setDomainFlags($domain, $flags, $server);
		if (!$ret){
			setLastError($ret['errmsg']);
			return false;
		}
		$domaininfo = $this->getByDomain($domain);
		//$this->sendMovecitedNotice($domaininfo, 0);
		apicall('mail','sendMovecitedNotice',array($domaininfo,0));
		return daocall('attack','changeStatus',array($row['id'],1));
	}
	public function checkAttack($attackid)
	{
		$row = daocall('attack','getById',array($attackid));
		if (!$row) {
			setLastError("记录不存在");
			return false;
		}
		$ret = apicall('proxy','queryAttack',array($row['server'],$row['domain']));
		if (count($ret['top']) > 0) {
			return true;
		}
		return false;
	}
	/**
	 * 用于面板调用
	 * @param unknown $domain
	 * @return boolean|Ambigous <Mixed, boolean, mixed>
	 */
	public function delMovecited($domain)
	{
		$domaininfo = $this->getByDomain($domain);
		$server = $domaininfo['server'];
		$flags = '-'.DOMAIN_IS_ATTACK;
		$ret = $this->setDomainFlags($domain, $flags, $server);
		if (!$ret){
			setLastError($ret['errmsg']);
			return false;
		}
		$row = daocall('attack','getRowByDomain',array($domain));
		if (!$row) {
			setLastError($domain."没有找到记录");
			return false;
		}
		//$this->sendMovecitedNotice($domaininfo, 0);
		apicall('mail','sendMovecitedNotice',array($domaininfo,0));
		return daocall('attack','changeStatus',array($row['id'],1));		
	}
	/**
	 * 禁用
	 * @param unknown $domain
	 * @param unknown $status
	 * @return boolean
	 */
	public function adminStatus($domain,$status)
	{
		$flags = $status==0 ? '-64' : '+64';
		$domaininfo = $this->getByDomain($domain);
		$server = $domaininfo['server'];
		$ret = $this->setDomainFlags($domain,$flags,$server);
		if ($ret['result']==200) {
			addLog(__METHOD__.' '.arrayToStr());
			apicall('mail','sendStatusNotice',array($domaininfo, $status));
			return true;
		}
		setLastError($ret['errmsg']);
		return false;
	}
	/**
	 * 锁定
	 * @param unknown $domain
	 * @param unknown $status
	 * @return boolean
	 */
	public function adminLock($domain,$status)
	{
		$flags = $status==0 ? '-256' : '+256';
		$domaininfo = $this->getByDomain($domain);
		$server = $domaininfo['server'];
		$ret = $this->setDomainFlags($domain,$flags,$server);
		if ($ret['result']==200) {
			addLog(__METHOD__.' '.arrayToStr());
			apicall('mail','sendLockNotice',array($domaininfo, $status));
			return true;
		}
		setLastError($ret['errmsg']);
		return false;
	}
	public function sendExpireMail($domain)
	{
		return apicall('mail','sendExpireMail',array($domain));
	}
	public function shiftDomain($olddomain, $newdomain)
	{
		$olddomaininfo = $this->getByDomain($olddomain);
		if (! $olddomaininfo) {
			setLastError($olddomain . "信息不存在");
			return false;
		}
		$newdomaininfo = $this->getByDomain($newdomain);
		if (! $newdomaininfo) {
			setLastError($newdomain . "信息不存在");
			return false;
		}
		if (intval($newdomaininfo['pid_expire_time'])>0 && $newdomaininfo['pid_expire_time']> date('Y-m-d H:i:s',time())) {
			setLastError($newdomain . "域名已存在套餐");
			return false;
		}
		if (! daocall('domains','begin',array())) {
			setLastError("事务开启失败");
			return false;
		}
		$newpinfo = daocall('product','getById',array($olddomaininfo['pid']));
		if (! $newpinfo) {
			daocall('domains','rollback',array());
			setLastError($olddomain . " PID=" . $olddomaininfo['pid'] . "信息不存在");
			return false;
		}
		// 缩减旧的域名套餐到期时间为2天
		if (! daocall('domains','decPidexpiretime',array($olddomain))) {
			daocall('domains','rollback',array());
			setLastError("缩减旧域名的时间失败");
			return false;
		}
		if (! daocall($this->daoname,'updatePid',array($newdomain,$newdomaininfo['server'],
			$olddomaininfo['pid']))) {
			daocall('domains','rollback',array());
			setLastError("更新新域名的pid失败");
			return false;
		}
		$adminremark = date('Y-m-d H:i:s',time()) . $olddomain . '转移套餐至';
		if (! daocall($this->daoname,'setPidPrice',array($newdomain,$olddomaininfo['pid_price'],$adminremark))) {
			daocall('domains','rollback',array());
			setLastError("更新新域名的套餐价格失败");
			return false;
		}
		// 更新新域名的过期时间
		if (! daocall('domains','editPidexpiretime',array($newdomain,$olddomaininfo['pid_expire_time']))) {
			daocall('domains','rollback',array());
			setLastError("增加新域名的套餐过期时间失败");
			return false;
		}
		if (! daocall('domains','commit',array())) {
			daocall('domains','rollback',array());
			setLastError("事务提交失败");
			return false;
		}
		//设置旧的域名为过期状态
		$this->setDomainFlags($olddomain, '+'.DOMAIN_IS_EXPIRE, $olddomaininfo['server']);
		addLog(__METHOD__ . ' ' . arrayToStr(func_get_args()));
		return $this->productParamToDomain($newdomaininfo,$newpinfo);
	}
	/**
	 * 续费所有域名。提前7天。后台执行
	 */
	public function renewAllDomain()
	{
		$list = daocall('domains','getRenewList',array(7));
		if (count($list) > 0) {
			foreach ( $list as $key => $row ) {
				if ($row['flags'] & DOMAIN_ADMIN_LOCK) {
					$this->showMsg($row['name']."域名被管理员锁定,不允许续费");
					continue;
				}
				if ($row['auto_renew'] == 1) {
					$ret = $this->renewProduct($row['name'],$row['uid'],1);
					if (! $ret) {
						$mem = '自动续费失败,错误' . $GLOBALS['last_error'];
						$status = 1; // 续费失败
						$this->showMsg($row['name'] . '续费失败:'.$mem);
					} else {
						$this->showMsg($row['name'] . '续费成功');
					}
				}
			}
		} else {
			$this->showMsg("nothing list need renew");
		}
		addLog(__METHOD__ . ' ' . arrayToStr(func_get_args()),0,'auto');
	}
	public function getExpireList($days=7)
	{
		$field = array('uid','name',"server",'admin_remark','created_on','pid_expire_time','group_view','flags',"pid",'pid_price','flags');
		if (defined('VIP_SERVER')) {
			$servernames = explode(',', VIP_SERVER);
			$server = array();
			foreach ($servernames as $name) {
				$row['name'] = $name;
				array_push($server, $row);
			}
		}else {
			$server  = daocall('server', 'getList',array());
		}
		$domainArr = array();
		foreach ($server as $value){
			if (defined('FREE_SERVER')) {
				if ($value['name'] == FREE_SERVER) {
					continue;
				}
			}
			$where['server'] = $value['name'];
			$list = daocall('domains','getExpireList',array($where,$field,$days));
			if ($list) {
				$domainArr = array_merge($list,$domainArr);
			}
		}
		return $domainArr;
	}
	public function expireAllDomain($stop)
	{
		//$list = daocall('domains','getExpireList',array());
		$filename = SYS_ROOT."/dnsdun_expire_domain".date("Y-m-d",time()).".out";
		$fp = fopen($filename, 'a');
		$stime = microtime(true);
		if ($fp) {
			fwrite($fp, "查询开始时间".$stime."\n");
		}
		$list = $this->getExpireList(0);
		$etime = microtime(true);
		if ($fp) {
			fwrite($fp, "查询结束时间".$etime."\n");
			fwrite($fp, "查询用时".($etime - $stime)."\n");
		}
		$count = count($list);
		if ($count > 0) {
			$this->showMsg($count . " domain need expire");
			foreach ( $list as $key => $row ) {
				if ($row['flags'] & DOMAIN_IS_EXPIRE) {
					if ($stop) {
						$ret = $this->stopDomain($row);
					}
					$this->showMsg($row['name']." expireing\n");
					continue;
				}
				$this->showMsg("expire domain " . $row['name'] . " begin");
				//默认是将域名的套餐改为免费版 ，但是server不变。
				//有用户需要暂停域名的，暂停后，域名访问将提示域名被暂停
				if ($stop) {
					$ret = $this->stopDomain($row);
				}else {
					$ret = $this->expireDomain($row);
					fwrite($fp, $row['name']." ".$row['pid']." ".$row['pid_expire_time']." ".$row['pid_price']."\n");
				}
				
				$this->showMsg("expire domain " . $row['name'] . " end");
			}
		} else {
			$this->showMsg("nothing list need expire");
		}
		fclose($fp);
	}
	private function stopDomain($domaininfo)
	{
		$ret = $this->setDomainFlags($domaininfo['name'], '+'.DOMAIN_AUDIT, $domaininfo['server']);
		if (defined("RENEW_DEL_ADMINLOCK")) {
			if ($domaininfo['flags'] & DOMAIN_ADMIN_LOCK) {
				$this->setDomainFlags($domaininfo['name'], '-'.DOMAIN_ADMIN_LOCK, $domaininfo['server']);
			}
		}
		return $ret;
	}
	private function expireDomain($domaininfo)
	{
		//TODO::当前使用硬编码,后续要改正
		$flags = '1';
		$ret = $this->setDomainFlags($domaininfo['name'], $flags, $domaininfo['server']);
		if ($ret['result'] == 200 || $ret === true) {
			$rrl = '{"qps":10000,"s":24}';
			$this->editRrl($domaininfo['name'], $rrl, $domaininfo['server']);
			if (! daocall('domains','begin',array())) {
				$this->showMsg("事务开启失败");
				return false;
			}
			if (! daocall('domains','updatePid',array($domaininfo['name'],$domaininfo['server'],0))) {
				daocall('domains','rollback',array());
				$this->showMsg("删除域名" . $domaininfo['name'] . ' pid失败');
				return false;
			}
			if ($domaininfo['pid_price']) {
				$adminremark = $domaininfo['admin_remark'] . " " . $this->getDate() . "停止套餐";
				if (! daocall('domains','setPidPrice',array($domaininfo['name'],0,$adminremark))) {
					daocall('domains','rollback',array());
					$this->showMsg("重置域名" . $domaininfo['name'] . ' pid_price失败');
					return false;
				}
			}
			if ($domaininfo['pid_expire_time']) {
				if (! daocall('domains','editPidexpiretime',array($domaininfo['name'],''))) {
					daocall('domains','rollback',array());
					setLastError("重置域名的过期时间失败");
					return false;
				}
			}
			if (! daocall('domains','commit',array())) {
				daocall('domains','rollback',array());
				$this->showMsg("事务提交失败");
				return false;
			}
			addLog(__METHOD__ . ' ' . arrayToStr($domaininfo));
			return true;
		}
		setLastError($ret['errmsg']);
		return false;
	}
	private function showMsg($msg)
	{
		if (! $_REQUEST) {
			echo date("Y-m-d H:i:s",time()) . ' ' . $msg . "\n";
		} else {
			setLastError($msg);
		}
	}
	/**
	 * 将sync_log里的op字段，对字段内容进行解析，得到中文解释
	 *
	 * @param unknown $json_str        	
	 * @param unknown $domain        	
	 * @return string
	 */
	public function createOperatlogMsg($json_str, $domain,$op)
	{
		$option = json_decode($json_str,true);
		$ops = array(20 => '增加域名',21 => '删除域名',22 => '更新域名',
			30 => '增加记录',31 => '删除记录',40 => '增加线路',32 => '更新记录');
		$param = array('view' => '线路','name' => '主机头','t' => '类型','value' => '值','group_name' => '线路组名称',
			'id' => '记录ID');
		$msg = '';
		$views = daocall('views','getByGroupname',array($domain));
		$issetView = false;
		if ($views) {
			foreach ( $views as $row ) {
				$newview[intval($row['id'])] = $row['name'];
			}
		}
		//$opstr = $ops[$option['op']];
		
		$opstr = $ops[$op];
		$paramstr = '';
		foreach ( $option as $key => $val ) {
			/*
			if ($key == 'op') {
				continue;
			}
			*/
			if (isset($param[$key])) {
				if ($paramstr != '') {
					$paramstr .= ' ';
				}
				$paramstr .= $param[$key] . ':';
				if ($key == 'view') {
					if (isset($newview[$val])) {
						$paramstr .= $newview[$val];
					} else {
						$paramstr .= '默认';
					}
				} else {
					$paramstr .= $val;
				}
			}
		}
		if($paramstr == ""){
			return $ops[$op];
		}
		/*
		if ($paramstr == '') {
			if ($option['op'] == 'add_domain') {
				return 'add_domain';
			}
			return '';
		}
		*/
		return $opstr . '(' . $paramstr . ')';
	}
	/**
	 * 查询一个域名的nameserver.
	 *
	 * @param 域名 $domain        	
	 * @return 成功返回ns的数组,失败返回false
	 */
	function query_record_from_top($domain,$type)
	{
		load_lib('pub:phpdns');
		$top = strstr($domain,'.');
		if ($top === FALSE) {
			return false;
		}
		$top_host = substr($top,1);
		if (substr($top_host,- 1) != '.') {
			$top_host .= '.';
		}
		$records = dns_get_record($top_host,DNS_NS);
		if (! is_array($records)) {
			return false;
		}
		foreach ($records as $row) {
			$ns = $row['target'];
			$dns = new DNSQuery($ns,53,5);
			$record = $dns->Query($domain,$type);
			if ($record === false) {
				continue;
			}
			$result = array();
			if ($record->count == 0) {
				$record = $dns->lastnameservers;
			}
			foreach ( $record->results as $v ) {
				$result[] = strtolower($v->data);
			}
			return $result;				
		}
		return false;
	}
	function query_ns($domain)
	{
		return $this->query_record_from_top($domain,"NS");
	}
	public function domainYangzheng($domain,$userinfo){
		$domaininfo = apicall('domains','getByName',array($domain));
		global $dns_cfg;
		if($domaininfo['server'] != $dns_cfg['server']){
			setLastError("域名为VIP用户");
			return false;
		}
		if($domaininfo['flags'] & DOMAIN_ADMIN_LOCK){
			setLastError("域名为禁用域名");
			return false;
		}
		if($domaininfo['local_register'] == 1){
			setLastError("此域名在dnsdun注册");
			return false;
		}
		$ret = dns_get_record("yanzheng.".$domain,DNS_TXT);
		if(!$ret){
			setLastError("找不到解析记录");
			return false;
		}
		$ok  =  false;
		$yanzhengkey = md5($userinfo['id'].$userinfo['email'].$userinfo['server'].DOMAIN_YAN_ZHENG);
		foreach ($ret as $key=>$value){
			if($value['txt'] == $yanzhengkey){
				$ok = true;
			}
		}
		if (!$ok) {
			setLastError("验证失败");
			return false;
		}
		$updateret = apicall('domains','updateUid',array($domain,$userinfo['id'],$domaininfo['soa'],$domaininfo['ttl'],$domaininfo['server']));
		if($updateret['result'] == 200){
			apicall('users', 'sendInfo',array($userinfo,$domain));
			setLastError("修改权限成功");
			return true;
		}
		setLastError("修改权限失败");
		return false;
	}
	//TODO::牵到vip2上后，需要对域名进行检查，是否有镕断NS,如果没有，则要添加记录ID为9的NS。如果是从vip2上牵到别的server,则要去除镩断NS记录
	public function editServer($domain, $newserver, $oldserver)
	{
		$fansd = $this->getFansd($oldserver);
		if(is_array($fansd) && isset($fansd['result'])) {
			// return $fansd;
			setLastError($fansd['result']);
			return false;
		}
		$ret = $fansd->migrate_domain($domain,$newserver);
		if($ret['result'] == 200) {
			$servers = apicall('server','getNameServer',array($newserver,$domain));
			$ns1 = $servers[0];
			$ns2 = $servers[1];
			$this->editNs($domain,$newserver,$ns1,$ns2);
			return true;
		}
		setLastError($ret['errmsg']);
		return false;
	}
	public function changeNsByProxy($domain,$server,$ns1,$ns2,$ns3,$ns4)
	{
		$domaininfo = $this->getByDomain($domain);
		if (!$domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		if ($domaininfo['server'] != $server) {
			setLastError("权限错误");
			return false;
		}
		$ret = daocall('domains','editNs',array($domain,$server,$ns1,$ns2,$ns3,$ns4));
		if (!$ret) {
			setLastError("数据库修改失败");
			return false;
		}
		$ns= apicall('server','getById2',array($server,$ns1,$ns2,$ns3,$ns4));
		$i = 1;
		foreach ($ns as $key=>$value) {
			$row['id'] = $i ++;
			$row['value'] = $value . '.';
			$row['domain'] = $domain;
			$row['name'] = '@';
			$row['server'] = $server;
			$row['ttl'] = 3600;
			$row['t'] = 'NS';
			// view=0，默认
			$row['view'] = 0;
			$row['flags'] = RECORD_HOLD;
			$row['replace'] = true;
			$ret = apicall('records','addRecord',array($row,$server));
			if (!$ret ) {
				setLastError("edit ns add record id=" . $row['id'] . "failed");
				return false;
			}
			// 将flags -8 ，修改了ns后，需要修改flags，让重新查询是否已修改ns
			$this->setDomainFlags($domain,'-8',$server);
			$row = null;
		}
		return true;
	}
	public function editNs($domain, $server, $ns1 = 0, $ns2 = 0, $nsoption = null)
	{
		if ($ns1 > 0 && $ns2 > 0) {
			$ret = daocall('domains','editNs',array($domain,$server,$ns1,$ns2));
			if (! $ret) {
				setLastError("edit ns to sql failed");
				return false;
			}
		}
		if ($nsoption) {
			$ns = $nsoption;
		} else {
			$ns = apicall('server','getById2',array($server,$ns1,$ns2));
		}
		$i = 1;
		foreach ( $ns as $value ) {
			//向product.ctl传递修改后的值出去
			$GLOBALS[$domain]['editns' . $i] = $value;
			$row['id'] = $i ++;
			$row['value'] = $value . '.';
			$row['domain'] = $domain;
			$row['name'] = '@';
			$row['server'] = $server;
			$row['ttl'] = 3600;
			$row['t'] = 'NS';
			// view=0，默认
			$row['view'] = 0;
			$row['flags'] = RECORD_HOLD;
			$row['replace'] = true;
			if (! apicall('records','addRecord',array($row,$server))) {
				setLastError("edit ns add record id=" . $row['id'] . "failed");
				return false;
			}
			// 将flags -8 ，修改了ns后，需要修改flags，让重新查询是否已修改ns
			$this->setDomainFlags($domain,'-8',$server);
			$row = null;
		}
		return true;
	}
	/**
	 * 判断是不是闰年
	 * @return boolean
	 */
	private function isLeapYear(){
		$year = date('Y');
		$time = mktime(20,20,20,4,20,$year);
		if (date("L",$time)==1){
			return true;
		}
		return false;
	}
	/**
	 * 如果相差的时间超过一个月，则按正常差价算，
	 * 少于一个月，则按一个月算，再给域名补足时间
	 * @param unknown $domaininfo
	 * @param unknown $oldpinfo
	 * @param unknown $newpinfo
	 * @param unknown $diffday 当不足一个月时，返回的相差天数,用于后续的补时间
	 * @return unknown|number
	 */
	public function getDiffPrice($domaininfo, $oldpinfo, $newpinfo,&$diffday)
	{
		$diffday = 0;
		$monthdays = $this->monthsDay();
		//得到当前是几月
		$thismonth = intval(date('m'));
		//得到当前月有多少天
		$thismonthday = $monthdays[$thismonth];
		//如果是闰年，当月只有28天
		$leapyear = false;
		if ($this->isLeapYear()) {
			$leapyear = true;
			if ($thismonth==2) {
				$thismonthday = 28;
			}
		}
		//如果有设置域名续费价格,则按域名续费价格算，否则按旧的产品价格算
		$oldprice = $domaininfo['pid_price'] ? $domaininfo['pid_price'] : $oldpinfo['price'];
		$diff = $this->getDiffMonth($domaininfo['pid_expire_time']);
		if ($diff  === false) {
			return $newpinfo['price'];
		}
		$month = $diff['year'] * 12 + $diff['month'] + number_format( $diff['day']/$thismonthday,2,".","");
		//如果不足一个月,要返回相差的天数
		if ($month < 1) {
			$diffday = $thismonthday - $diff['day'];
			//新产品的价格 - 剩余天数所剩的余额
			//如剩余15天时间，购买价为500元，那么剩下的时间换算成金额就是余下了250元。
			//因为会补足15天时间，那么等于重新购买了一个月新的套餐，所以他要付的钱就等于新的套餐价格 减掉他之前购买的时间余下的金额
			$diffprice =  floor($newpinfo['price']  - (number_format( $diff['day']/$thismonthday,2,".","") * $oldprice));
			if ($diffprice < 0) {
				return $newpinfo['price'];
			}
			return $diffprice;
		}
		//$diffprice = (($difftime / $oneyearsecond) * $newpinfo['price']) - (($difftime / $oneyearsecond) * $oldpinfo['price']);
		$diffprice = ($month * $newpinfo['price']) - ($month * $oldpinfo['price']);
		return floor($diffprice);
	}
	private function monthsDay(){
		return array(
				1	 	=>31,
				2		=>29,
				3		=>31,
				4		=>30,
				5		=>31,
				6		=>30,
				7		=>31,
				8		=>31,
				9		=>30,
				10		=>31,
				11		=>30,
				12		=>31
		);
	}
	/**
	 * 得到相差多少年，多少月，多少天
	 * @param unknown $expire_time
	 * @return boolean|number
	 */
	public function getDiffMonth($expire_time)
	{
		$monthdays = $this->monthsDay();
		//得到当前是几月
		$thismonth = intval(date('m',time()));
		//得到当前月有多少天
		$thismonthday = $monthdays[$thismonth];
		$year = date("Y");
		$month = date('m');
		$day = date('d');
		$et = $this->getYearMonthDay($expire_time);
		$diff['year'] = $et['year'] - $year;
		if ($diff['year'] < 0) {
			return false;
		}
		//如果没有年，则表示同年
		$diff['month'] = $et['month'] - $month;
		if ($diff['month'] < 0) {
			$diff['year']--;
			$diff['month'] = 12 + $diff['month'];
		}
		$diff['day'] = $et['day'] - $day;
		if ($diff['day'] < 0) {
			if ($diff['month']) {
				$diff['month']--;
			}else {
				if ($diff['year']) {
					$diff['year']--;
					$diff['month'] = 11;
				}else {
					return false;
				}
			}
			$diff['day'] = $thismonthday + $diff['day'];
		
		}
		if ($diff['year'] < 0 || $diff['month']< 0 || $diff['day'] < 0) {
			return false;
		}
		return $diff;
	}
	private function getYearMonthDay($time)
	{
		$ret['year'] = (int)substr($time,0,4);
		$ret['month'] = (int)substr($time,5,2);
		$ret['day'] = (int)substr($time,8,2);
		return $ret;
	}
	
	public function adminRenewDomain($domain,$month,$ispay,$pidprice,$remark)
	{
		if ($month < 1) {
			setLastError("购买时间不能小于一个月");
			return false;
		}
		$domaininfo = D('domains')->getDomainByName($domain);
		if (!$domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		//是否购买了套餐
		$pid = $domaininfo['pid'];
		if ($pid < 1) {
			setLastError("域名未购买套餐");
			return false;
		} 
		//检测购买的套餐信息是否存在
		$pinfo = D("product")->getById($pid);
		if (!$pinfo) {
			setLastError("域名购买的套餐已不存在");
			return false;
		}
		if (!D("users")->begin()) {
			setLastError("数据库连接失败");
			return false;
		}
		$money = $month * $pidprice;
		$uid = $domaininfo['uid'];
		//如果没有付款，则需要从用户信息里面扣款
		if (!$ispay) {
			$userinfo = D("users")->getById($uid);
			if (!$userinfo) {
				setLastError("域名的用户信息不存在");
				return false;
			}
			if (!D("users")->decMoney($uid,$money)) {
				D("users")->rollback();
				setLastError("用户余额不足".$money);
				return false;
			}
		}
		if (!D('domains')->updatePidExpiretime($domain,$uid,$month)) {
			setLastError("修改域名过期时间失败");
			D("users")->rollback();
			return false;
		}
		if (D("users")->commit()) {
			$mem = '续费' . $pinfo['name'] . ' ' . $month . '月';
			if ($ispay) {
				$mem .= ",未扣款";
			}else {
				$mem .= ";续费前用户余额:".$userinfo['money'] / 100 ."元";
			}
			$mem .= ";续费前过期时间:".$domaininfo['pid_expire_time'];
			if ($remark) {
				$mem .= "(管理员备注:".$remark.")";
			}
			daocall('moneylog','add',array($uid,$money*100,'moneyout',$domain,$mem,0,$domaininfo['server']));
			return true;
		}
		D("users")->rollback();
		return false;
	}
	/**
	 * 如果域名是定制产品，price > 0,则续费价格按定制的价格算。否则按套餐的算
	 *
	 * @param unknown $domain        	
	 * @param unknown $uid        	
	 * @param unknown $month        	
	 * @return boolean
	 */
	public function renewProduct($domain, $uid, $month,$keystr=null)
	{
		if ($month < 1) {
			setLastError("续费时间不能小于一个月");
			return false;
		}
		$domaininfo = daocall('domains','getByNameAndUid',array($domain,$uid));
		if (! $domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		
		if ($domaininfo['pid'] < 1) {
			setLastError("当前域名没有购买套餐");
			return false;
		}
		$pinfo = daocall('product','getById',array($domaininfo['pid']));
		if (! $pinfo) {
			setLastError("购买的产品已不存在,请升级套餐");
			return false;
		}
		// 如果域名是定制产品，pid_price > 0,则续费价格按定制的价格算。否则按套餐的算
		$monthmoney = $domaininfo['pid_price'] > 0 ? $domaininfo['pid_price'] : $pinfo['price'];
		$needmoney = $month * $monthmoney;
		if ($needmoney <= 0) {
			setLastError("续费价格错误" . $needmoney);
			return false;
		}
		$userinfo = daocall('users','getById',array($uid));
		if ($userinfo['money'] / 100 < $needmoney) {
			setLastError("账户余额不够&nbsp;余额:" . ($userinfo['money'] / 100) . "元,所需金额:" . $needmoney . "元&nbsp;<a href='?c=public&a=user'>现在充值</a>");
			return false;
		}
		if ($keystr) {
			$krow = apicall('promostr','checkKeystr',array($keystr,$userinfo));
			if ($krow === false) {
				setLastError($GLOBALS['last_error']);
				return false;
			}
			$needmoney = $needmoney - $krow['price'];
			$needmoney = $needmoney > 0 ? $needmoney : 0;
		}
		$mem = '续费' . $pinfo['name'] . ' ' . $month . '月';
		$mem .= ";续费前用户余额:".$userinfo['money'] / 100 ."元";
		$mem .= ";续费前过期时间:".$domaininfo['pid_expire_time'];
		if ($keystr) {
			$mem .= ' 优惠'.$krow['price'].' K='.$krow['id'];
		}
		if (! daocall('domains','begin',array())) {
			setLastError("数据库事务失败");
			return false;
		}
		$ret = daocall('users','decMoney',array($uid,$needmoney));
		if (! $ret) {
			daocall('domains','rollback',array());
			setLastError("扣费失败");
			return false;
		}
		if ($keystr) {
			//将优惠码状态改为已使用
			daocall('promostr','changeStatus',array($krow['id'],apicall('promostr','getUseStatus',array()),true,$userinfo['id'],$domain));
		}
		$ret = daocall('domains','updatePidExpiretime',array($domain,$uid,$month));
		if (! $ret) {
			daocall('domains','rollback',array());
			setLastError("更新时间失败");
			return false;
		}
		//元 为存储单位
		if($userinfo['proxy'] > 0){
			//给该用户的代码增加代理分成记录
			daocall('proxyrecord','buyProductRecord',array($userinfo,$domain,$needmoney,$mem));
		}
		
		if (! daocall('domains','commit',array())) {
			daocall('domains','rollback',array());
			setLastError("提交事务失败");
			return false;
		}
		//如果续费了，需要给用户关掉过期的提示
		if ($domaininfo['flags'] & DOMAIN_IS_EXPIRE) {
			$this->setDomainFlags($domaininfo['name'], '-'.DOMAIN_IS_EXPIRE, $domaininfo['server']);
		}
		//如果有审核状态(2015.7.3，独立用户需求使用过期提示暂停域名的功能，因65536这个flag已废弃，独立用户改为DOMAIN_AUDIT这个flag
		if ($domaininfo['flags'] & DOMAIN_AUDIT) {
			$this->setDomainFlags($domaininfo['name'], '-'.DOMAIN_AUDIT, $domaininfo['server']);
		}
		//元 为存储单位
		daocall('moneylog','add',array($uid,$needmoney*100,'moneyout',$domain,$mem,0,$domaininfo['server']));
		//续费邮件
		apicall('mail','userBuyProduct',array($userinfo,$domaininfo,$pinfo,$needmoney,$month,'续费'));
		return true;
	}
	public function updateProduct($domain, $uid, $newpid, $month,$keystr=null)
	{
		$domaininfo = daocall('domains','getByNameAndUid',array($domain,$uid));
		if (! $domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		$month = intval($month);
		if (defined("FREE_PID")) {
			//如果有定义免费的套餐ID,则转到购买操作
			if ($domaininfo['pid'] == FREE_PID) {
				return $this->buyProduct($domaininfo,$newpid,$month,$keystr);
			}
		}
		// 如果已经是购买过的。转为升级套餐，需检查新的套餐是不是价格更高,如果不是，则不允许降级
		// 
		if ($domaininfo['pid'] > 0 && 0 < intval($domaininfo['pid_expire_time'])) {
			return $this->changeProduct($domaininfo,$newpid,$month,$keystr);
		}
		return $this->buyProduct($domaininfo,$newpid,$month,$keystr);
	}
	/*
	 * 改为免费版
	 */
	public function changeProductFree($domaininfo) 
	{
		$freeproduct = daocall("product","getFreeRow",array());
		if (!$freeproduct) {
			setLastError("获取免费套餐失败,请联系管理员");
			return false;
		}
		if (! daocall('product','begin',array())) {
			setLastError("数据库执行事务失败");
			return false;
		}
		$ret = daocall($this->daoname,'updatePid',array($domaininfo['name'],$domaininfo["server"],0));
		if (!$ret) {
			daocall('product','rollback',array());
			setLastError("迁移至免费服务器失败");
			return false;
		}
		$ret = daocall($this->daoname,'editPidexpiretime',array($domaininfo['name'],0));
		if (!$ret) {
			daocall('product','rollback',array());
			setLastError("迁移至免费服务器失败!");
			return false;
		}
		daocall('product','commit',array());
		return $this->productParamToDomain($domaininfo,$freeproduct);
	}
	/**
	 * 前台购买套餐
	 */
	private function buyProduct($domaininfo, $newpid, $month,$keystr=null)
	{
		// 购买套餐
		if ($month < 1) {
			setLastError("购买时间不能小于一月");
			return false;
		}
		$domain = $domaininfo['name'];
		$newpinfo = daocall('product','getById',array($newpid));
		if (! $newpinfo) {
			setLastError("套餐信息不存在");
			return false;
		}
		$money = ($newpinfo['price']) * $month;
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		if (! $userinfo) {
			setLastError("用户信息不存在");
			return false;
		}
		$oldserver = $domaininfo['server'];
		if ($keystr) {
			$krow = apicall('promostr','checkKeystr',array($keystr,$userinfo));
			if ($krow === false) {
				setLastError($GLOBALS['last_error']);
				return false;
			}
			$keymoney = $krow['price'];
			$money = $money - $keymoney;
			//如果价格小于0，则为0
			$money = $money > 0 ? $money : 0;
		}
		if (($userinfo['money'] / 100) < $money) {
			if ($_REQUEST['jsonp']==1) {
				setLastError("账户余额不够,余额:" . ($userinfo['money'] / 100) . "元,所需金额:" . $money . "元");
			}else {
				setLastError("账户余额不够,余额:" . ($userinfo['money'] / 100) . "元,所需金额:" . $money . "元&nbsp;<a href='?c=user&a=index'>现在充值</a>");
			}
			return false;
		}
		if (! daocall('product','begin',array())) {
			setLastError("数据库执行事务失败");
			return false;
		}
		$ret = apicall('users','decMoney',array($uid,$money));
		if (! $ret) {
			daocall('product','rollback',array());
			setLastError("扣除费用失败");
			return false;
		}
		if ($keystr) {
			daocall('promostr','changeStatus',array($krow['id'],apicall('promostr','getUseStatus',array()),true,$userinfo['id'],$domain));
		}
		$ret = daocall($this->daoname,'updatePid',array($domain,$oldserver,$newpid));
		if (! $ret) {
			daocall('product','rollback',array());
			setLastError("修改新的产品失败");
			return false;
		}
		if (! daocall($this->daoname,'addPidExpiretime',array($domain,$uid,$month))) {
			daocall('product','rollback',array());
			setLastError("数据库更新产品时间失败");
			return false;
		}
		$mem = '购买套餐' . $newpinfo['name'] . ' ' . $month . '月';
		$mem .= "购买前余额:".($userinfo['money'] / 100);
		if ($keystr) {
			$mem .= ' 优惠'.$krow['price'].'元 K='.$krow['id'];
		}
		//按元存储
		if($userinfo['proxy'] > 0){
			daocall('proxyrecord','buyProductRecord',array($userinfo,$domain,$money,$mem));
		}
		daocall('product','commit',array());
		//按元存储
		daocall('moneylog','add',array($uid,$money*100,'moneyout',$domain,$mem,0,$newpinfo['server']));
		//购买成功发送邮件
		apicall('mail','userBuyProduct',array($userinfo,$domaininfo,$newpinfo,$money,$month,'域名购买套餐('.$newpinfo['name'].")成功"));
		return $this->productParamToDomain($domaininfo,$newpinfo);
	}
	private function processUserAgent($userinfo,$money,$domain)
	{
		if ($money <=0) {
			setLastError("购买价格小于0");
			return false;
		}
		if (!$userinfo['proxy']) {
			setLastError("该账户没有代理");
			return false;
		}
		$agentuserinfo = apicall('users','getById',array($userinfo['proxy']));
		if (!$agentuserinfo) {
			setLastError("代理账户不存在");
			return false;
		}
		if (!$agentuserinfo['divided']) {
			setLastError("代理利率未设置");
			return false;
		}
		$dividedmoney = ($agentuserinfo['divided'] /100 ) * $money;
		$ret = apicall('users','addMoney',array($agentuserinfo['id'],$dividedmoney*100));
		if (!$ret) {
			setLastError("更新账户金额失败");
			return false;
		}
		$mem = $domain.'购买套餐代理分成';
		daocall('moneylog','add',array($agentuserinfo['id'],$dividedmoney*100,'agent',null,$mem,0,$userinfo['server']));
		return true;
	}
	/**
	 * 前台升级套餐
	 */
	private function changeProduct($domaininfo, $newpid, $month,$keystr)
	{
		$domain = $domaininfo['name'];
		$newpinfo = daocall('product','getById',array($newpid));
		if (! $newpinfo) {
			setLastError("套餐信息不存在");
			return false;
		}
		$oldpinfo = daocall('product','getById',array($domaininfo['pid']));
		if (! $oldpinfo) {
			setLastError("已购买的套餐信息不存在,请联系管理员");
			return false;
		}
		if ($newpinfo['price'] < $oldpinfo['price']) {
			setLastError("套餐价格设置出错,请联系管理员");
			return false;
		}
		$diffday = 0;
		$money = $this->getDiffPrice($domaininfo,$oldpinfo,$newpinfo,$diffday);
		if ($money < 0) {
			setLastError("升级价格错误");
			return false;
		}
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		if (! $userinfo) {
			setLastError("用户信息不存在");
			return false;
		}
		$mem = $domain.'从'.$oldpinfo['name'].'升级到' . $newpinfo['name']." 升级前过期时间".$domaininfo['pid_expire_time'];
		$mem .= "升级前余额:".($userinfo['money'] / 100);
		if (($userinfo['money'] / 100) < $money) {
			if ($_REQUEST['jsonp']==1) {
				setLastError("账户余额不够,余额:" . ($userinfo['money'] / 100) . "元,所需金额:" . $money . "元");
			}else {
				setLastError("账户余额不够,余额:" . ($userinfo['money'] / 100) . "元,所需金额:" . $money . "元<a href='?c=user&a=index'>现在充值</a>");
			}
			return false;
		}
		// 事务开始
		if (! daocall('product','begin',array())) {
			setLastError("数据库执行事务失败");
			return false;
		}
		$ret = apicall('users','decMoney',array($uid,$money));
		if (! $ret) {
			daocall('product','rollback',array());
			setLastError("扣除费用失败");
			return false;
		}
		$oldserver = $domaininfo['server'];
		$ret = daocall($this->daoname,'updatePid',array($domain,$oldserver,$newpid));
		if (! $ret) {
			daocall('product','rollback',array());
			setLastError("修改新的产品失败");
			return false;
		}
		if ($diffday > 0) {
			$ret = daocall('domains','pidExpirtTimeAddDay',array($domain,$uid,$diffday));
			if (! $ret) {
				daocall('product','rollback',array());
				setLastError("域名增加时间失败");
				return false;
			}
		}
		//按元存储
		if($userinfo['proxy'] > 0){
			daocall('proxyrecord','buyProductRecord',array($userinfo,$domain,$money,$mem));
		}
		
		// 事务提交
		daocall('product','commit',array());
		//按元存储
		daocall('moneylog','add',array($uid,$money*100,'moneyout',$domain,$mem,0,$newpinfo['server']));
		//升级套餐发送邮件
		apicall('mail','userBuyProduct',array($userinfo,$domaininfo,$newpinfo,$money,$month,'域名升级套餐('.$newpinfo['name'].")成功"));
		return $this->productParamToDomain($domaininfo,$newpinfo);
	}
	/**
	 * 后台定制套餐
	 *
	 * @param unknown $domain        	
	 * @param unknown $oldserver        	
	 * @param unknown $newpid
	 *        	ispay 是否已支付
	 * @return boolean
	 */
	public function updateProductByAdmin($domain, $newpid, $month, $pidprice, $ispay = false)
	{
		$domaininfo = daocall('domains','getDomainByName',array($domain));
		if (! $domaininfo) {
			setLastError("域名信息不存在");
			return false;
		}
		$newpinfo = daocall('product','getById',array($newpid));
		if (! $newpinfo) {
			setLastError("套餐信息不存在");
			return false;
		}
		$uid = $domaininfo['uid'];
		$userinfo = apicall('users','getById',array($uid));
		if (! $userinfo) {
			setLastError("用户信息不存在");
			return false;
		}
		$month = intval($month);
		// 购买套餐
		if (! daocall('product','begin',array())) {
			setLastError("数据库执行事务失败");
			return false;
		}
		if ($month > 0 ) {
			$money = $pidprice * $month;
			if ($money <= 0) {
				setLastError("系统价格错误,请联系管理员");
				return false;
			}
			if (($userinfo['money'] / 100) < $money && ! $ispay) {
				setLastError("账户余额不够,余额:" . ($userinfo['money'] / 100) . "元,所需金额:" . $money . "元");
				return false;
			}
			if (! $ispay) {
				$ret = apicall('users','decMoney',array($uid,$money));
				if (! $ret) {
					daocall('product','rollback',array());
					setLastError("扣除费用失败");
					return false;
				}
			}
		}
		$oldserver = $domaininfo['server'];
		if ($newpid != $domaininfo['pid']) {
			$ret = daocall($this->daoname,'updatePid',array($domain,$oldserver,$newpid));
			if (! $ret) {
				daocall('product','rollback',array());
				setLastError("修改新的产品失败");
				return false;
			}
		}
		if ($month > 0) {
			if ($domaininfo['pid_expire_time'] > date('Y-m-d H:i:s',time())) {
				if (!daocall($this->daoname,'updatePidExpiretime',array($domain,$uid,$month))) {
					daocall('product','rollback',array());
					setLastError("数据库更新时间失败");
					return false;
				}
			}else {
				if (! daocall($this->daoname,'addPidExpiretime',array($domain,$uid,$month))) {
					daocall('product','rollback',array());
					setLastError("数据库更新时间失败");
					return false;
				}
			}
		}
		daocall('product','commit',array());
		//如果只是修改续费价格或备注
		if ($month > 0) {
			$mem = '购买套餐' . $newpinfo['name'] . ' ' . $month . '月';
			daocall('moneylog','add',array($uid,$money*100,'moneyout',$domain,$mem,0,$newpinfo['server']));
		}
		addLog(__METHOD__ . ' ' . arrayToStr(func_get_args()));
		return $this->productParamToDomain($domaininfo,$newpinfo);
	}
	public function productParamToDomain($domaininfo, $newpinfo,$change_server=true)
	{
		$oldserver = $domaininfo['server'];
		$newserver = $newpinfo['server'];
		$domain = $domaininfo['name'];
		if($change_server && $newserver != $oldserver) {
			if (! $this->editServer($domain,$newserver,$oldserver)) {
				setLastError("迁移至新的解析服务器失败,请联系管理员" . $GLOBALS['last_error']);
				return false;
			}
		}
		if($newpinfo['rrl'] != $domaininfo['rrl']) {
			$ret = $this->editRrl($domain,$newpinfo['rrl'],$newserver);
			if ($ret['result'] != 200) {
				setLastError("修改新的产品参数失败,请联系管理员" . $ret['errmsg']);
				return false;
			}
		}
		$oldpinfo = daocall('product','getById',array($domaininfo['pid']));//获取旧的的产品信息
		if($oldpinfo['flags'] != $newpinfo['flags']) {
			$ret = $this->setDomainFlags($domain,"-".$oldpinfo['flags'],$newserver);
			if ($ret['result'] != 200) {
				setLastError("设置旧的产品参数失败,请联系管理员" . $ret['errmsg']);
				return false;
			}
			$ret = $this->setDomainFlags($domain,"+".$newpinfo['flags'],$newserver);
			if ($ret['result'] != 200) {
				setLastError("设置新的产品参数失败,请联系管理员" . $ret['errmsg']);
				return false;
			}
		}
		if ($_SERVER['HTTP_HOST']!= "dnsdun.com" && $_SERVER['HTTP_HOST'] != "www.dnsdun.com") {
			if ($domaininfo['flags'] & DOMAIN_AUDIT) {
				$ret = $this->setDomainFlags($domain,sprintf("-%d",DOMAIN_AUDIT),$newserver);
				if ($ret['result'] != 200) {
					setLastError("设置旧的产品参数失败,请联系管理员" . $ret['errmsg']);
					return false;
				}
			}
		}
		/*
		if($newpinfo['groupview'] && $newpinfo['groupview'] != $domaininfo['groupview']) {
			$groupview = $newpinfo['groupview'];
			$ret = $this->updateGroupview($domain,$groupview,$newserver);
			if ($ret['result'] != 200) {
				setLastError("修改新的线路组失败,请联系管理员" . $ret['errmsg']);
				return false;
			}
		}
		
		//如果产品flags设置有阻断NS功能。
		if(($newpinfo['blockns']) > 0) {
			$this->addAttackBlockNs($domaininfo);
		}else {
			//否则就要删除记录id=9的解析
			$this->delAttackBlockNs($domaininfo);
		}
		*/
		return true;
	}
	public function editRrl($name, $rrl, $server)
	{
		$fansd = $this->getFansd($server);
		if(is_array($fansd) && isset($fansd['result'])) {
			setLastError($fansd['result']);
			return false;
		}
		return $fansd->update_domain_rrl($name,$rrl);
	}
	public function editDnssec($domain,$dnssec,$server){
		$fansd = $this->getFansd($server);
		if(is_array($fansd) && isset($fansd['result'])){
			setLastError($fansd['result']);
			return false;
		}
		return $fansd->update_domain_dnssec($domain, $dnssec);
	}
	public function adminAdd($domain, $userinfo, $server,$gid=0){
		$gid = $gid> 0 ? $gid : 0;
		return $this->insert($domain, $userinfo, $server, $gid);
	}
	/**
	 * 添加的域名默认使用免费的产品(价格为0)，没有则使用config.php默认定义的参数
	 * server使用用户账户上分配的server。不以产品上的server
	 * (non-PHPdoc)
	 *
	 * @see API::add()
	 */
	public function add($domain, $userinfo, $server,$gid=0)
	{
		$domain = trim($domain);
		if (!$this->checkDomainName($domain)) {
			$value['result'] = $domain.'域名格式有错误';
			return $value;
		}
		// 中文域名解码
		if (substr ( $domain, 0, 4 ) == "xn--") {
			$domain = $this->punycode_decode ( $domain, "utf8" );
		}
		// 判断是否为预留域名
		if (daocall ( 'domainreserved', 'getReservedDomain', array ($domain))){
			$value['result'] = $domain.'已存在';
			return $value;
		}
		if($this->getByName($domain)){
			$value['result'] = $domain.'已存在';
			return $value;
		}
		$gid = $gid> 0 ? $gid : 0;
		return $this->insert($domain, $userinfo, $server, $gid);
	}
	private function insert($domain, $userinfo, $server,$gid,$addflags=null) 
	{
		$dns_cfg = $this->getServerCfg($server);
		$soa = $dns_cfg[$server]['soa'];
		if (is_numeric($dns_cfg[$server]['ttl'])) {
			$ttl = $dns_cfg[$server]['ttl'];
		} else {
			$ttl = 600;
		}
		if (! is_array($userinfo)) {
			$userinfo = apicall('users','getById',array($userinfo));
		} else {
			$userinfo = apicall('users','getById',array($userinfo['id']));
		}
		$uid = $userinfo['id'];
		if ($uid <= 0) {
			$value['result'] = '用户信息不存在';
			return $value;
		}
		if ($userinfo['status']==2) {
			$value['result'] = '账户被锁定,禁止添加域名';
			return $value;
		}
		$fansd = $this->getFansd($server);
		if (is_array($fansd) && isset($fansd['result'])) {
			return $fansd;
		}
		$flags = $dns_cfg[$server]['flags'];
		$group_view = $dns_cfg[$server]['group_view'];
		$rrl = $dns_cfg[$server]['rrl'];
		$pid = 0;
		/*
		 * 如果server设置了默认产品，则参数选择为server上设置的产品参数 否则，选择免费的产品，如果都没有，则设置为config.php里面设置的
		*/
		$serverinfo = daocall('server','getByName',array($server));
		$pname = defined("FREE_PNAME") ? FREE_PNAME : '免费版';
	
		if ($serverinfo && $serverinfo['pid'] > 0) {
			$pinfo = daocall('product','getById',array($serverinfo['pid']));
		} else if (defined('FREE_PID')) {
			$pinfo = daocall('product','getById',array(FREE_PID));
		}else if (defined("DEFAULT_PID")) {
			$pinfo = daocall('product','getById',array(DEFAULT_PID));
		}else {
			$pinfo = daocall('product','getFreeRow',array());
		}
		if ($pinfo) {
			$flags = $pinfo['flags'];
			$rrl = $pinfo['rrl'];
			$group_view = $pinfo['groupview'];
			$pid = $pinfo['id'];
			$pname = $pinfo['name'];
		}
		//如果有后置添加的flags，比如标明是子域名的
		if ($addflags !==null) {
			$flags = $flags | $addflags;
		}
		$ret = $fansd->add_domain2($domain,$uid,$soa,$ttl,$flags,$group_view,$rrl);
		if ($ret['result'] != 200) {
			return $ret;
		}
		// $servers = apicall('server','getNameServer',array($server,$domain));
		
		// 自定义NS
		$nsarr = $this->getNsId($domain,$userinfo,$server);
		$arr['ns1'] = $nsarr[0];
		$arr['ns2'] = $nsarr[1];
		$arr['ns3'] = $nsarr[2];
		$arr['ns4'] = $nsarr[3];
		$nsoption = null;
		// TODO::如果指定的NS域名不存在时，如何处理?
		if ($userinfo['ns1_name'] && $userinfo['ns2_name']) {
			$nsoption = array($userinfo['ns1_name'],$userinfo['ns2_name']);
		}
		$arr['name'] = $domain;
		apicall('records','addNs',array($arr,$server,$nsoption));
		$setting = daocall('setting','getAll',array());
		
		$arr['created_on'] = 'NOW()';
		$arr['gid'] = $gid;
		$arr['pid'] = $pid;
		if ($setting['domain_free_day']) {
			$arr['domain_free_day'] = $setting['domain_free_day'];
		}
		daocall('domains','addAfterChange',array($domain,$arr));
		$ret['pid'] = $pid;
		$ret['pname'] = $pname;
		if ($setting['domain_free_day']) {
			$ret['pid_expire_time'] = date("Y-m-d",time()+($setting['domain_free_day']*86400));
		}
		$ret['flags'] = $flags;
		return $ret;
	}
	private function getNsId($domain, $userinfo, $server)
	{
		//load_conf('ns_' . $server);
		$servers = apicall('server','getNameServer',array($server,$domain));
		$isrand = false;
		//检查ns1是否为0，如果为0则要重新获取并更新user表里的ns2
		if ($userinfo['ns1_id']) {
			$ns1 = $userinfo['ns1_id'];
		} else {
			$ns1 = $servers[0];
			$isrand = true;
		}
		//检查ns2是否为0，如果为0则要重新获取并更新user表里的ns2
		if ($userinfo['ns2_id']) {
			$ns2 = $userinfo['ns2_id'];
		} else {
			$ns2 = $servers[1];
			$isrand = true;
		}
		//ns3和ns4原样更新
		$ns3 = intval($userinfo['ns3_id']);
		$ns4 = intval($userinfo['ns4_id']);
		// 如果重新随机了，需要更新user里的nsid
		if ($isrand) {
			if (!daocall('users','editNsId',array($userinfo['id'],$ns1,$ns2,$userinfo['server'],$ns3,$ns4))) {
				//TODO::
			}
		}
		return array($ns1,$ns2,$ns3,$ns4);
	}
	public function getFansdConnect($server)
	{
		return $this->getFansd($server);
	}
	public function delDomain($domain, $server)
	{
		$fansd = $this->getFansd($server);
		if (is_array($fansd) && isset($fansd['result'])) {
			return $fansd;
		}
		return $fansd->del_domain($domain);
	}
	public function addSubdomain($name,$domain,$server) 
	{
		if (!preg_match('/^[a-z0-9]([a-z0-9_-]{1,60})?$/',$name)) {
			file_put_contents("/home/kangle/2222.txt", $name);
			setLastError("子域名前缀不符合格式");
			return false;
		}
		$subdomain = $name.'.'.$domain;
		if (strlen($subdomain) > 255) {
			setLastError("域名总长度不能超过255字节");
			return false;
		}
		$domaininfo = $this->getByDomain($domain);
		if (($domaininfo['flags'] & DOMAIN_IS_SUBDOMAIN) > 0) {
			setLastError("当前域名已经是子域名，不可添加二级子域名");
			return false;
		}
		$userinfo = apicall('users','getById',array($domaininfo['uid']));
		
		//DOMAIN_IS_SUBDOMAIN发送flags=16384标明是子域名
		$ret = $this->insert($subdomain, $userinfo, $server,$domaininfo['gid'],DOMAIN_IS_SUBDOMAIN);
		if ($ret['result'] != 200) {
			setLastError($ret['errmsg']);
			return false;
		}
		return true;
	}
	public function changeStatus($domain, $status, $server)
	{
		$fansd = $this->getFansd($server);
		if (is_array($fansd) && isset($fansd['result'])) {
			return $fansd;
		}
		return $fansd->set_domain_status($domain,$status);
	}
	public function setDomainFlags($domain, $flags, $server)
	{
		$fansd = $this->getFansd($server);
		if(is_array($fansd) && isset($fansd['result'])) {
			setLastError($fansd['result']);
			return false;
		}
		return $fansd->set_domain_flags($domain,$flags);
	}
	public function setFlagsByProxy($proxyname,$domain,$flags)
	{
		//$proxyinfo = daocall('server','getByName',array($proxyname));
		$domaininfo = $this->getByDomain($domain);
		if (!$domaininfo) {
			setLastError('域名不存在');
			return false;
		}
		if ($domaininfo['server'] != $proxyname) {
			setLastError("权限错误");
			return false;
		}
		return $this->setDomainFlags($domain, $flags, $domaininfo['server']);
	}
	public function updateDomain($domain, $uid, $soa, $ttl = 0, $server)
	{
		$fansd = $this->getFansd($server);
		if (is_array($fansd) && isset($fansd['result'])) {
			return $fansd;
		}
		return $fansd->update_domain2($domain,$uid,$soa,$ttl);
	}
	public function updateUid($domain, $uid, $soa, $ttl, $server)
	{
		$fansd = $this->getFansd($server);
		if (is_array($fansd) && isset($fansd['result'])) {
			return $fansd;
		}
		return $fansd->update_domain2($domain,$uid,$soa,$ttl);
	}
	/****************************
	 * 增加功能
	 * 1:域名切换线路时,判断线路是否可以被免费用户使用
	 *****************************/
	public function updateGroupview($domain, $group_view, $server)
	{
		$group_view_ret = D("groupview")->getById($group_view);
		if(!$group_view_ret){
			setLastError("服务器繁忙,请重试");
			return false;
		}
		$use_power = $group_view_ret['use_power'];
		if ($use_power > 0){
			$domain_info = $this->getByDomain($domain);
			$pid = $domain_info['pid'];
			if (defined('FREE_PID') ){
				if ($pid == FREE_PID){
					setLastError("请升级套餐");
					return false;
				}
			}else {
				if ($pid <= 1){
					setLastError("请升级套餐");
					return false;
				}
			}
		}
		$fansd = $this->getFansd($server);
		if (is_array($fansd) && isset($fansd['result'])) {
			return $fansd;
		}
		return $fansd->update_domain_group_view($domain,$group_view);
	}
	public function getByDomain($domain)
	{
		return $this->getByName($domain);
	}
	public function getByName($name)
	{
		$arr['name'] = $name;
		return $this->get($arr,'row');
	}
	public function getByStatus($status)
	{
		$arr['status'] = $status;
		return $this->get($arr,'rows');
	}
	public function getByUid($uid)
	{
		$arr['uid'] = $uid;
		return $this->get($arr,'rows');
	}
	public function setByName($name, $arr)
	{
		$where['name'] = $name;
		return $this->set($arr,$where);
	}
	public function setByDomain($domain, $arr)
	{
		return $this->setByName($domain,$arr);
	}
	
	/**
	 * 修改created_on 和updated_on
	 *
	 * @param unknown_type $field        	
	 * @param unknown_type $domain        	
	 * @return Ambigous <Mixed, boolean, mixed>
	 *         2013-8-16
	 */
	public function changeDate($field, $domain)
	{
		return daocall($this->daoname,'changeDate',array($field,$domain));
	}
	/**
	 * 验证域名是否符合要求
	 *
	 * @param unknown_type $domain        	
	 * @return boolean number
	 */
	public function checkDomainName($domain)
	{
		load_conf('pub:tld');
		$domain = strtolower($domain);
		if (isset($GLOBALS['second_tld'][$domain])) {
			return false;
		}
		$tld_pos = strpos($domain,'.');
		if ($tld_pos === FALSE) {
			return false;
		}
		
		$subdomain = substr($domain,0,$tld_pos);
		$tld = substr($domain,$tld_pos + 1);
		if (isset($GLOBALS['second_tld'][$tld])) {
			if ($GLOBALS['second_tld'][$tld] != 1) {
				return false;
			}
		}
		$tld2_pos = strpos($tld,'.');
		if ($tld2_pos !== FALSE) {
			if (! isset($GLOBALS['second_tld'][$tld])) {
				return false;
			}
			if ($GLOBALS['second_tld'][$tld]!=1) {
				return false;
			}
		}
		return $this->checkSubDomain($subdomain);
	}
	private function checkSubDomain($domain)
	{
		if (strlen($domain) == 0) {
			return false;
		}
		return preg_match('/[\'"!#*()`~]/',$domain)==0;
	}
	/*
	 * 中文域名解码 punycode
	 */
	// punycode 解码
	private function punycode_decode($input, $code = "GBK") {
		$input = trim ( $input );
		$strarr = array ();
		$strarr = explode ( ".", $input );
		$output = "";
		for($i = 0; $i < count ( $strarr ); $i ++) {
			if (substr ( $strarr [$i], 0, 4 ) == "xn--") {
				$input = substr ( $strarr [$i], 4 );
				$outtmp = $this->punycode_decode2 ( $input, $code );
	
				if (! $outtmp || $outtmp < 0)
					return;
	
				$output .= $outtmp;
			} else {
				$output .= $strarr [$i];
			}
			if ($i != count ( $strarr ) - 1)
				$output .= ".";
		} // for
		return $output;
	}
	// 主要的解码转换工作
	private function punycode_decode2($input, $code = "GBK") {
		$n = punycode_INITIAL_N;
		$out = 0;
		$i = 0;
		$max_out = 256;
		$bias = punycode_INITIAL_BIAS;
		$inputlen = strlen ( $input );
		$outputa = array ();
	
		$b = 0;
		for($j = 0; $j < $inputlen; $j ++)
			if ($input {$j} == "-")
			$b = $j;
	
			for($j = 0; $j < $b; $j ++) {
			/* 不考虑大小写 */
				if (ord ( $input {$j} ) - 65 < 26)
				$case_flags [$out] = "1";
				else
			$case_flags [$out] = "0";
				
			if (ord ( $input {$j} ) > 128)
			return - 1;
			// $output.=$input{$j};
			$outputa [] = ord ( $input {$j} );
			$out ++;
			}
	
			for($in = $b > 0 ? $b + 1 : 0; $in < $inputlen; $out ++) {
			$oldi = $i;
			$w = 1;
			for($k = punycode_BASE;; $k += punycode_BASE) {
			if ($in >= $inputlen)
				return - 2;
				$digit = $this->punycode_decode_digit ( ord ( $input {$in ++} ) );
				if ($digit >= punycode_BASE)
					return - 3;
					if ($digit > (punycode_MAXINT - $i) / $w)
						return - 4;
					$i = $i + $digit * $w;
					$t = $k <= $bias ? punycode_TMIN : ($k >= ($bias + punycode_TMAX) ? punycode_TMAX : ($k - $bias));
					if ($digit < $t)
						break;
						if ($w > punycode_MAXINT / (punycode_BASE - $t))
							return - 5;
							$w = $w * (punycode_BASE - $t);
			}
				
			$bias = $this->punycode_adapt ( $i - $oldi, $out + 1, $oldi == 0 );
			if ($i / ($out + 1) > punycode_MAXINT - $n)
				return - 6;
				$n += ( int ) ($i / ($out + 1));
				$i = $i % ($out + 1);
					
				if ($out >= $max_out)
					return - 7;
	
					/*
				 * 不考虑大小写
				 * for ($q=0;$q<$out-$i;$i++) $case_flags[$i+1+$q]= $case_flags[$i+$q];
				 *
				 * if ($input[$in-1]-65<26)
				 	* $case_flags[$i]='1';
				 * else
				 	* $case_flags[$i]='0';
				 */
				 for($qq = 0; $qq < ($out - $i); $qq ++)
				 	$outputa [($i + $out) - $i - $qq] = $outputa [($i + $out) - $i - $qq - 1];
				 		
				 	$outputa [$i ++] = $n;
			}
	
			$outputstr = "";
				 	for($i = 0; $i < count ( $outputa ); $i ++) {
				 	if ($outputa [$i] < 128)
				 		$outputstr .= chr ( $outputa [$i] );
				 		else {
				 		$hx = dechex ( $outputa [$i] );
				 		$gaowei = substr ( $hx, 2, 2 );
				 		$diwei = substr ( $hx, 0, 2 );
				 		$tmp_output = chr ( hexdec ( $gaowei ) ) . chr ( hexdec ( $diwei ) );
				 		$tmp_output = iconv ( "Unicode", $code, $tmp_output );
				 		$outputstr .= $tmp_output;
				 		}
				 		}
				 		return $outputstr;
			}
			// 编码的参数
			private function punycode_adapt($delta, $numpoints, $firsttime) {
			if ($firsttime)
				$delta = ( int ) ($delta / punycode_DAMP);
				else
					$delta = ( int ) ($delta / 2);
	
				$delta += ( int ) ($delta / $numpoints);
	
				for($k = 0; $delta > ( int ) (((punycode_BASE - punycode_TMIN) * punycode_TMAX) / 2); $k += punycode_BASE) {
				$delta = ( int ) ($delta / (punycode_BASE - punycode_TMIN));
			}
				 return $k + ( int ) (((punycode_BASE - punycode_TMIN + 1) * $delta) / ($delta + punycode_SKEW));
			}
			// 处理数字,大小写字母
			private function punycode_decode_digit($c) {
			if (($c - 48) < 10)
				return ($c - 22);
				if (($c - 65) < 26)
					return ($c - 65);
					if (($c - 97) < 26)
						return ($c - 97);
			return punycode_BASE;
		}
		public function buyFlow($uid,$domain,$flow){
			$userinfo =  daocall('users','getById',array($uid));
			if (!$userinfo){
				setLastError("该用户不存在");
				return false;
			}
			$domaininfo = daocall('domains','getByNameAndUid',array($domain,$uid));
			if(!$domaininfo){
				setLastError("域名不存在");
				return false;
			}
			$cdnproduct = daocall('cdnproduct','getProductRow',array($domaininfo['cdn_id']));
			if(!$cdnproduct)
			{
				setLastError("产品不存在");
				return false;
			}
			$sum = $cdnproduct['flow_price']*$flow;
			if($sum>$userinfo['money']){
				setLastError("余额不足");
				return false;
			}
			if (!daocall('users','begin',array())){
				setLastError("事务开启失败");
				return false;
			}
			$ret = daocall('users', 'editMoney',array($uid,$sum,'-'));
			if(!$ret){
				daocall('users','rollback',array());
				setLastError("扣除费用失败");
				return false;
			}
			$mem = "购买流量{$flow}G,"." 流量价格 ".$cdnproduct['flow_price']/100;
			$ret = daocall('moneylog','add',array($uid,$sum,"购买流量",$domain,$mem));
			if(!$ret){
				daocall('users','rollback',array());
				setLastError("产生消费记录失败");
				return false;
			}
			$ret =  daocall('domains','updateFlowLimitByDomain',array($uid,$domain,$flow*FLOW_M_G));
			if(!$ret){
				daocall('users','rollback',array());
				setLastError("修改站点流量失败");
				return false;
			}
			if (!daocall('users','commit',array())){
				setLastError("提交失败");
				return false;
			}
			return true;
		}
		
		public function getRemark($domain){
			$ret = D("domains")->getRemark($domain);
			return $ret;
		}
}

