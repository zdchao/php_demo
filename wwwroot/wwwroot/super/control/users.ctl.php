<?php
needRole('admin');
class UsersControl extends Control
{
	private $apiname = 'users';
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function send()
	{
		//$ret = apicall('mail','sendCloud',array('13062849@qq.com','邮件测试','send cloud邮件测试','admin@dnsdun.com'));
		
		
		
	}
	public function lockAllDomain()
	{
		$id = intval($_REQUEST['id']);
		$ret = apicall('users','lockAllDomain',array($id));
		@addLog('锁定用户所有域名'.$email,0,getRole('admin'));
		api_exit(1,$ret);
	}
	public function unlockAllDomain()
	{
		$id = intval($_REQUEST['id']);
		$ret = apicall('users','unlockAllDomain',array($id));
		@addLog('解锁用户所有域名'.$email,0,getRole('admin'));
		api_exit(1,$ret);
	}
	public function disableAllDomain()
	{
		$id = intval($_REQUEST['id']);
		$ret = apicall('users','disableAllDomain',array($id));
		@addLog('解锁用户所有域名'.$email,0,getRole('admin'));
		api_exit(1,$ret);
	}
	public function undisableAllDomain()
	{
		$id = intval($_REQUEST['id']);
		$ret = apicall('users','undisableAllDomain',array($id));
		@addLog('解锁用户所有域名'.$email,0,getRole('admin'));
		api_exit(1,$ret);
	}
	public function setAdminremark()
	{
		$id = $_REQUEST['id'];
		$adminremark = trim($_REQUEST['admin_remark']);
		$ret = daocall('users','setAdminremark',array($id,$adminremark));
		if ($ret) {
			@addLog(__METHOD__.' '.arrayToStr());
			apiReturn(200);
		}
		apiReturn(10);
	}
	public function setDivided()
	{
		$id = intval($_REQUEST['id']);
		$divided = intval($_REQUEST['divided']);
		$ret = daocall('users','changeDivided',array($id,$divided));
		if ($ret) {
			@addLog(sprintf('修改用户%s代理分成%d',$email,$divided),0,getRole('admin'));
			apiReturn(1);
		}
		apiReturn(10);
	}
	public function clearLoginError()
	{
		$id = intval($_REQUEST['id']);
		$ret = daocall('users','changeErrorCount',array($id));
		if ($ret) {
			apiReturn(1);
		}
		apiReturn(10);
	}
	public function sendRegMail()
	{
		$email = $_REQUEST['email'];
		$userinfo = apicall('users','getByEmail',array($email));
		if (apicall('users','addUserEmail',array($userinfo))) {
			apiReturn(1);
		}
		apiReturn(10,$GLOBALS['last_error']);
	}
	public function getInfo()
	{
		$email = trim($_REQUEST['email']);
		$info = apicall($this->apiname,'getByEmail',array($email));
		$json['code'] = 400;
		if (!$info) {
			$json['msg'] = '没有该账户';
			die(json_encode($json));
		}
		$json['code'] = 200;
		$json['info'] = $info;
		die(json_encode($json));
	}
	public function editCustomNs()
	{
		$json['code'] = 400;
		$ns1id = intval($_REQUEST['ns1id']);
		$ns2id = intval($_REQUEST['ns2id']);
		$ns1name = trim($_REQUEST['ns1name']);
		$ns2name = trim($_REQUEST['ns2name']);
		$soaemail = trim($_REQUEST['soaemail']);
		$email = trim($_REQUEST['email']);
		if (!$email) {
			$json['msg'] = '参数错误';
			die(json_encode($json));
		}
		$server = $_SESSION['admin_server'];
		if (!apicall('domains','checkAllowCustomNs',array($server))) {
			//$json['msg'] = '暂不支持';
			//die(json_encode($json));
		}
		$ret = daocall('users','editCustomNs',array($email,$server,$ns1id,$ns2id,$ns1name,$ns2name,$soaemail));
		if ($ret) {
			@addLog(__METHOD__.' '.arrayToStr());
			$json['code'] = 200;
		}else {
			$json['msg'] = $GLOBALS['last_error'];
		}
		die(json_encode($json));
	}
	public function editServer()
	{
		$json['code'] = 400;
		$email = trim($_REQUEST['email']);
		if (!$email) {
			$json['msg'] = '参数错误';
			die(json_encode($json));
		}
		$newserver = trim($_REQUEST['newserver']);
		$userinfo = apicall('users','getByEmail',array($email));
		$oldserver = $userinfo['server'];
		if ($newserver == $oldserver) {
			$json['msg'] = '新的和当前的相同';
			die(json_encode($json));
		}
		$ret = daocall('users','editServer',array($email,$newserver,$oldserver));
		$userinfoNew = apicall('users','getByEmail',array($email));
		$ns = apicall('ns','getUserNs',array($userinfoNew));
		daocall('users','editNsId',array($userinfoNew['id'],$ns[0],$ns[1]));
		if ($ret) {
			@addLog(__METHOD__.' '.arrayToStr());
			$json['code'] = 200;
		}else {
			$json['msg'] = $GLOBALS['last_error'];
		}
		die(json_encode($json));
	}
	public function pagelist()
	{
		if (!empty($_REQUEST['email'])) {
			if(is_numeric($_REQUEST['email'])){
				$where['id'] = trim($_REQUEST['email']);
			}else {
				$where['email'] = trim($_REQUEST['email']);
			}
		}
		if (!empty($_REQUEST['uid'])) {
			$where['id'] = $_REQUEST['uid'];
		}
		$page = intval($_REQUEST['page']);
		if ($page <= 0) {
			$page = 1;
		}
		$page_count = $_SESSION['page_count'] ? $_SESSION['page_count'] : 25;
		$count = 0;
		$list = daocall('users','pageList',array($page,$page_count,&$count,$where));
		if (is_array($list)) {
			foreach ($list as $key=>$row) {
				$row['name'] = klencode($row['name']);
				$newlist[$key] = $row;
			}
		}
		$total_page = ceil($count/$page_count);
		if ($page >= $total_page) {
			$page = $total_page;
		}
		//if (apicall('domains','checkAllowCustomNs',array($server))) {
			$this->_tpl->assign('allowcustomns',1);
		//}
		$user_function = 0;
		if(defined("USER_ALLOW_DEL")){
			$user_function = 1;
		}
		$this->_tpl->assign('user_function',$user_function);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$newlist);
		$this->_tpl->assign('action','?c=users&a=pagelist');
		return $this->_tpl->display('user/pagelist.html');
	}
	public function changeStatus()
	{
		$json['code'] = 400;
		$email = $_REQUEST['email'];
		if (!apicall('users','checkEmail',array($email))) {
			$json['msg'] = '用户名格式不正确';
			die(json_encode($json));
		}
		$ret = apicall('users','changeStatus',array($email,0));
		if ($ret) {
			@addLog('修改用户状态'.$email,0,getRole('admin'));
			$json['code'] = 200;
		}else {
			$json['msg'] = isset($GLOBALS['last_error']) ? $GLOBALS['last_error'] :'操作失败';
		}
		die(json_encode($json));
	}
	public function changePasswd()
	{
		die();
		$user = $_REQUEST['user'];
		$passwd = getRandPasswd(8);
		$json['code'] = 400;
		if (apicall($this->apiname,'resetPasswd',array($user,$passwd))) {
			$json['passwd'] = $passwd; 
			$json['code'] = 200;
		}else {
			$json['msg'] = '修改密码失败'.$GLOBALS['last_error']?$GLOBALS['last_error'] : '';
		}
		die(json_encode($json));
	}
	
	/**
	 * date:20130430
	 * 会员删除,
	 */
	public function del()
	{
		die();
		$name = trim($_REQUEST['name']);
		$json['code'] = 400;
		if (apicall($this->apiname,'delByName',array($name))) {
			vhmsLog();
			if ($_REQUEST['ajax']) {
				$json['code'] = 200;
			}else {
				header("Location:?c=users&a=pagelist");
				die();
			}
		}else {
			if ($GLOBALS['last_error']) {
				$json['msg'] = $GLOBALS['last_error'];
			}
		}
		die(json_encode($json));
	}
	/**
	 * edit to json
	 *2013-5-14
	 */
	public function editMoney()
	{
		die();
		$json['code'] = 400;
		$money = 100 * intval($_REQUEST['money']);
		if ($money > 0) {
			daocall('user','addMoney', array($_REQUEST['username'],abs($money)));
			/*100管理员操作*/
			daocall('moneyin','add',array($_REQUEST['username'],$money,100));
		}else{
			daocall('user','decMoney', array($_REQUEST['username'],abs($money)));
			daocall('moneyin','add',array($_REQUEST['username'],$money,100));
		}
		vhmsLog();
		$json['code'] = 200;
		die(json_encode($json));
	}
	public function impLogin()
	{
		//$fields = array('id','email','server');
		$fields = null;
		$user = daocall('users','getUserByEmail',array($_REQUEST['user'],$fields));
		if (!$user) {
			die('获取不到user信息');
		}
		//@addLog(__METHOD__.' '.arrayToStr());
		registerRole('user',$user);
		header("Location: /user/?c=public&a=index");
		die();
	}
	public function proxyLogin()
	{
		$proxyinfo = daocall('users','getById',array($_REQUEST['id']));
		if (!$proxyinfo) {
			die('获取不到proxy信息');
		}
		//@addLog(__METHOD__.' '.arrayToStr());
		registerRole('proxy2',$proxyinfo);
		header("Location: /proxy2/index.php");
		die();
	}
	public function getById(){
		$uid = $_REQUEST['uid'];
		$ret = apicall('users','getById',array($uid));
		if($ret){
			api_exit(1,array('row'=>$ret));
		}
	}
	//编辑ns
	public function editNs(){
		$userId = intval($_REQUEST['userId']);
		$ns1id = intval($_REQUEST['ns1id']);
		$ns2id = intval($_REQUEST['ns2id']);
		$ret = daocall('users','editNsId',array($userId,$ns1id,$ns2id));
		if($ret){
			api_exit(1);
		}
		api_exit(10);
	}
	public function add(){
		$passwd = trim($_REQUEST['passwd']);
		$email = trim($_REQUEST['email']);
		if(!$email||!$passwd){
			api_exit(6,"参数错误");
		}
		if (!apicall('users','checkEmail',array($email))) {
			api_exit(7,"邮箱格式不正确");
		}
		if (apicall('users','getByEmail',array($email))) {
			api_exit(7,"账号已经存在");
		}
		$arr['email'] = $email;
		$arr['salt'] = getRandPasswd(16);
		$arr['passwd'] = md5_password($passwd, $arr['salt']);
		$arr['name'] = klencode($_POST['name']);
		$arr['server'] = apicall('server','getServer',array());
		if ($_SESSION['agent_user']) {
			$arr['proxy'] = $_SESSION['agent_user'];
		}else {
			$proxyuid = apicall('setting','getProxyuid',array($_SERVER['HTTP_HOST']));
			$arr['proxy'] = $proxyuid;
		}
		if(defined("FREE_MESSAGE")){
			$arr['free_message'] = FREE_MESSAGE;
		}
		else{
			$arr['free_message'] = 0;
		}
		$uid = apicall('users','add',array($arr));
		if (!$uid) {
			api_exit(10,"注册意外失败");
		}
		api_exit(1);
	}
	public function del_admin()
	{
		$email = trim($_REQUEST['email']);
		if(!$email){
			api_exit(5,"参数错误");
		}
		if (!defined('USER_ALLOW_DEL')) {
			api_exit(5,"不允许删除");
		}
		$ret = daocall('users', 'delByEmail',array($email));
		if($ret){
			@addLog('删除用户'.$email,0,getRole('admin'));
			api_exit(1);
		}
		api_exit(10);
	}
	public function editpasswd(){
		$email = trim($_REQUEST['email']);
		$passwd = trim($_REQUEST['passwd']);
		if(!$email||!$passwd){
			api_exit(5,"参数错误");
		}
		if (!apicall('users','getByEmail',array($email))) {
			api_exit(7,"账号不存在");
		}
		if(!apicall('users','resetPasswd',array($email,$passwd))){
			api_exit(10);
		}
		api_exit(1);
	}
}
?>