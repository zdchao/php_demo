<?php 
needRole('admin');
class MessageControl extends Control
{
	private $daoname = 'operatelog';
	public function __construct()
	{
		parent::__construct();
	}
	public function pagelist()
	{
		return	$this->_tpl->display('message/pagelist.html');
	}
	public function sendOneMail()
	{
		$domain = $_REQUEST['domain'];
		if (!$domain) {
			api_exit(5);
		}
		$template = $_REQUEST['template'];
		if (!$template) {
			api_exit(6);
		}
		$ret = A('mail')->sendSimulationMail($domain,$template);
		if (!$ret) {
			api_exit(10,array('result'=>$GLOBALS['last_error']));
		}
		api_exit(1);		
	}
	public function send(){
		$arr['domain'] = trim($_REQUEST['domain']);
		if ($_REQUEST['s']=='attack') {
			$arr['source'] = 'attack';
			$arr['e'] = trim($_REQUEST['e']);
			$arr['t'] = time();
			$arr['qc'] = trim($_REQUEST['qc']);
		}else {
			$arr['monitor_id'] = $_REQUEST['id'];
			$arr['source'] = 'monitor';
			$arr['action'] = intval($_REQUEST['action']);
			$arr['status'] = intval($_REQUEST['status']);
			$arr['src'] =trim($_REQUEST['src']);
			/*$weixin = $_REQUEST['weixin']=="weixin" ? '+' : '-';
			$sms = $_REQUEST['sms']=="sms" ? '+' : '-';
			$email = $_REQUEST['email']=="email" ? '+' : '-';*/
			$ret = daocall("monitor", "getById",array($arr['monitor_id']));
			$arr['notice_flags'] = $ret[0]['notice_flags'];
			$arr['name'] = $_REQUEST['name'];
			$arr['record_name'] = $_REQUEST['record_name'];
		}
		//$body=json_encode($arr);
		//$ret=apicall('mail', 'add',array($body,'notice'));
		$ret = apicall('mail', 'check',array($arr));
		if($ret){
			api_exit(1,$ret);
		}
		api_exit(10);
	}
	public function getNoticeFlags(){
		$monitor_id = intval($_REQUEST['monitor_id']);
		$ret = daocall("monitor", "getById",array($monitor_id));
		if(!$ret){
			api_exit(10,"监控ID不存在");
		}
		$info['weixin'] = ($ret[0]['notice_flags'] & MONITOR_IS_WEIXIN) ? 'yes' :'';
		$info['email'] = ($ret[0]['notice_flags'] & MONITOR_IS_EMAIL) ? 'yes' :'';
		$info['sms'] = ($ret[0]['notice_flags'] & MONITOR_IS_SMS) ? 'yes' :'';
		$info['monitor_name'] = $ret[0]['name'];
		$info['domain'] = $ret[0]['domain'];
		$info['action'] = $ret[0]['action'];
		$record = daocall("records", "getRecordById",array($ret[0]['domain'],$ret[0]['record_id']));
		$info['record_name'] = $record['name'];
		$info['src'] = $record['value'];
		api_exit(1,array("row"=>$info));
		
	}
	public function getDomainList(){
		$where['domain'] = trim($_REQUEST['domain']);
	    $page = intval($_REQUEST['page']);
		if ($page <= 0) {
			$page = 1;
		}
		$pagecount = 15;
		$count = 0;
		$record = daocall("monitor","getMonitor2",array($page,$pagecount,&$count,$where));
		$total_page = ceil($count/$pagecount);
		if ($page >= $total_page) {
			$page = $total_page;
		}
		if($record){
			api_exit(1,array("row"=>$record,"count"=>$count,"total_page"=>$total_page));
		}
		api_exit(10,"该域名下没有监控记录");
	}
}
