<?php 
class MonitorAPI extends API
{
	protected $daoname = 'monitor';
	/**
	 *
	 * @param unknown $user
	 * @param string $status
	 *        	null|0|1
	 */
	public function addMinitorEmail($monitor,  $status = null)
	{
		$dir = dirname(dirname(__FILE__)).'/';
		$tpl = tpl::getClass($dir);
		$date = date('Y-m-d H:i:s',time());
		if (!is_array($monitor)) {
			$monitorinfo = apicall('monitor','getById',array($monitor));
		}else {
			$monitorinfo = $monitor;
		}
		$userinfo = apicall('users','getById',array($monitorinfo['user']));
		$webconfig = apicall('setting','getCpNameDomain',array($userinfo['server']));
		$web_domain  = $webconfig['web_domain'];
		$web_name = $webconfig['web_name'];
		$tpl->assign('web_domain',"http://".$web_domain);
		$tpl->assign('web_name',$web_name);
		
		$user = $userinfo['name'];
		$email = $userinfo['email'];
		$domain = $monitorinfo['domain'];
		$recordinfo = apicall('records','getByDomainAndId',array($monitorinfo['domain'],$monitorinfo['record_id']));
		$tpl->assign('domainip',$recordinfo['value']);
		if ($status === null) {
			$title = $domain.'开启监控成功';
		} else {
			if ($status == 1) {
				$title = $domain . ' 域名所在服务岩机';
			} else {
				$title = $domain . ' 域名所在服务器已恢复访问 ';
			}
		}
		$tpl->assign('domain',$domain);
		$tpl->assign('user',$user);
		$tpl->assign('status',$status);
		$tpl->assign('date',$date);
		$body = $tpl->fetch('templete/monitor.html');
		return apicall('mail','sendMail',array($email,$title,$body));
	}
	/**
	 * 增加通用api
	 * @param unknown $domain
	 * @param unknown $recordid
	 * @param unknown $user
	 * @param unknown $t
	 * @param unknown $value
	 * @param unknown $url
	 * @param unknown $content
	 * @param unknown $intver_time
	 * @param unknown $action
	 * @param unknown $server
	 * @return Ambigous <Mixed, boolean, unknown>
	 */
	public function addMonitor($domain,$recordid,$user,$t,$value,$url,$content,$intver_time,$action,$server,$name,$active,$notice_flags)
	{
		$arr['domain'] = $domain;
		$arr['record_id'] = $recordid;
		$arr['user'] = $user;
		$arr['t'] = $t;
		$arr['value'] = $value;
		$arr['url'] = $url;
		$arr['content'] = $content;
		$arr['interval_time'] = $intver_time;
		$arr['action'] = $action;
		$arr['server'] = $server;
		$arr['name'] = $name;
		$arr['active'] = $active;
		$arr['notice_flags'] = $notice_flags;
		return daocall($this->daoname,'add',array($arr));
	}
	/**
	 * 修改通用api
	 * @param unknown $id
	 * @param unknown $t
	 * @param unknown $value
	 * @param unknown $url
	 * @param unknown $content
	 * @param unknown $interval_time
	 * @param unknown $action
	 * @return Ambigous <Mixed, boolean, unknown>
	 */
	public function editMonitor($id,$t,$value,$url,$content,$interval_time,$action)
	{
		$arr['t'] = $t;
		$arr['value'] = $value;
		$arr['url'] = $url;
		$arr['content'] = $content;
		$arr['interval_time'] = $interval_time;
		$arr['action'] = $action;
		$where['id']  = $id;
		return daocall($this->daoname,'update',array($arr,$where));
	}
	public function editMonitor2($domain,$recordid,$t,$value,$url,$content,$interval_time,$action,$active,$name,$notice_flags)
	{
		$arr['t'] = $t;
		$arr['value'] = $value;
		$arr['url'] = $url;
		$arr['content'] = $content;
		$arr['interval_time'] = $interval_time;
		$arr['action'] = $action;
		$arr['active'] = $active;
		$arr['name'] = $name;
		$arr['notice_flags'] = $notice_flags;
		$where['domain']  = $domain;
		$where['record_id'] = $recordid;
		return daocall($this->daoname,'update',array($arr,$where));
	}
	public function editActive($domain,$recordid,$active)
	{
		return daocall($this->daoname,'changeActive',array($domain,$recordid,$active));
	}
	/**
	 * 删除通用api
	 */
	public function delMonitor($id)
	{
		$where['id'] = $id;
		return daocall($this->daoname,'del',array($where));
	}
	public function getByUser($user)
	{
		$arr['user'] = $user;
		return $this->get($arr,'rows');
	}
	public function getById($id)
	{
		$arr['id'] = $id;
		return $this->get($arr,'row');
	}
	public function getByDomainAndRecordid($domain,$recordid)
	{
		$arr['domain'] = $domain;
		$arr['record_id'] = $recordid;
		return $this->get($arr,'row');
	}
	public function delByDomainAndRecordid($domain,$recordid)
	{
		$arr['domain'] = $domain;
		$arr['record_id'] = $recordid;
		return $this->del($arr);
	}
	/**
	 * @param unknown_type $domain
	 * @param unknown_type $field
	 * @return Ambigous <Ambigous, Mixed, boolean, mixed>
	 *2013-8-23
	 */
	public function getByDomain($domain,$field=null)
	{
		$arr['domain'] = $domain;
		$field = array('record_id');
		return $this->get($arr,'rows',$field);
	}
	public function delById($id)
	{
		$arr['id'] = $id;
		return $this->del($arr);
	}
	public function setById($id,$arr)
	{
		$where['id'] = $id;
		return $this->set($arr, $where);
	}
	public function changeActive($id,$active)
	{
		$where['id'] = $id;
		$arr['active'] = $active;
		return $this->set($arr, $where);
	}
	public function changeActiveByRecordid($recordid,$active)
	{
		$arr['active'] = $active;
		$where['record_id'] = $recordid;
		return $this->set($arr,$where);
	}
	/**
	 * 用于域名修改了状态，同步修改监控的记录状态
	 * @param unknown_type $domain
	 * @param unknown_type $active
	 * @return Ambigous <Ambigous, Mixed, boolean, mixed>
	 *2013-8-23
	 */
	public function changeActiveByDomain($domain,$active)
	{
		$where['domain'] = $domain;
		$arr['active'] = $active;
		return $this->set($arr, $where);
	}
	/**
	 * 域名删除时需同步删除监控记录
	 * @param unknown_type $domain
	 * @return Ambigous <Ambigous, Mixed, boolean, mixed>
	 *2013-8-23
	 */
	public function delByDomain($domain)
	{
		$arr['domain'] = $domain;
		return $this->del($arr);
	}
	
	
	
	
}

