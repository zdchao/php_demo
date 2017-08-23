<?php
$session_id = $_POST ['session_id'];
if ($session_id) {
	session_id ( $session_id );
}
session_start ();
needRole ( 'user' );
/*
 * 中文域名解码参数
 */
define ( "punycode_TMIN", 1 );
define ( "punycode_TMAX", 26 );
define ( "punycode_BASE", 36 );
define ( "punycode_INITIAL_N", 128 );
define ( "punycode_INITIAL_BIAS", 72 );
define ( "punycode_DAMP", 700 );
define ( "punycode_SKEW", 38 );
define ( "punycode_DELIMITER", "-" );
define ( "punycode_MAXINT", 2147483647 );
class DomainControl extends Control {
	private $apiname = 'domains';
	private $domain;
	private $domaininfo;
	private $userinfo;
	public function __construct() {
		parent::__construct ();
		$this->userinfo = getRole ( 'user' );
	}
	public function editGroup() {
		$domain = checkString ( $_REQUEST ['domain'] );
		$newgid = intval ( $_REQUEST ['group_id'] );
		$ret = daocall ( 'domains', 'editGid', array (
				$domain,
				$newgid,
				$this->userinfo ['id'] 
		) );
		if ($ret) {
			api_exit ( 1 );
		}
		api_exit ( 10, $GLOBALS ['last_error'] );
	}
	/*
	 * 用户域名过期调整到免费版
	 */
	public function domainChangeFree() {
		$domaininfo = api_get_domain ();
		$ret = apicall ( 'domains', 'changeProductFree', array (
				$domaininfo 
		) );
		if ($ret) {
			api_exit ( 1 );
		}
		api_exit ( 10, $GLOBALS ['last_error'] );
	}
	public function changeCdnRecord() {
		$domaininfo = api_get_domain ();
		$domainName = $_REQUEST ['domain'];
		$cdn = $_REQUEST ['cdn'];
		$hostName = $_REQUEST ['hostName'];
		$analysisValue = $_REQUEST ['analysisValue'];
		$recordList = daocall ( 'records', 'getListByValue', array (
				$domainName,
				$hostName,
				$analysisValue 
		) );
		$count = count ( $recordList );
		$successcount = 0;
		$errorcount = 0;
		if ($count <= 0) {
			api_exit ( 2, '没有符合条件的记录' );
		}
		$flags = ($cdn < 1) ? "-2048" : "+2048";
		foreach ( $recordList as $row ) {
			if ($row ['t'] == "CNAME" || $row ['t'] == "DNAME" || $row ['t'] == "MX" || $row ['t'] == "NS" || $row ['t'] == "TXT" || $row ['t'] == "SRV" || $row ['t'] == "URL") {
				$count --;
				continue;
			}
			if ($cdn == 1) {
				if ($row ['flags'] == 2048) {
					$count --;
					continue;
				}
			} else {
				if ($row ['flags'] == 0) {
					$count --;
					continue;
				}
			}
			$recordsRet = apicall ( 'records', 'setRecordFlags', array (
					$row ['id'],
					$row ['domain'],
					$flags,
					$domaininfo ['server'] 
			) );
			if ($recordsRet ['result'] != 200) {
				$errorcount ++;
			}
			$successcount ++;
		}
		api_exit ( 1, array (
				'count' => $count,
				'successcount' => $successcount,
				'errorcount' => $errorcount 
		) );
	}
	/**
	 * 暂停恢复
	 */
	public function changeRecordStatus() {
		$domaininfo = api_get_domain ();
		$hostName = checkString ( $_REQUEST ['hostName'] );
		$analysisValue = $_REQUEST ['analysisValue'];
		$list = daocall ( 'records', 'getListByValue', array (
				$domaininfo ['name'],
				$hostName,
				$analysisValue 
		) );
		$count = count ( $list );
		if ($count <= 0) {
			api_exit ( 2, '没有符合的记录' );
		}
		$successcount = 0;
		$errorcount = 0;
		$status = $_REQUEST ['status'] == 1 ? 1 : 0;
		foreach ( $list as $key => $row ) {
			if ($row ['t'] == 'NS') {
				$count --;
				continue;
			}
			$ret = apicall ( 'records', 'changeStatus', array (
					$row ['id'],
					$domaininfo ['name'],
					$status,
					$domaininfo ['server'] 
			) );
			if ($ret ['result'] == 200) {
				$successcount ++;
			} else {
				$errorcount ++;
				$error [$row ['id']] = $ret ['errmsg'];
			}
		}
		api_exit ( 1, array (
				'count' => $count,
				'successcount' => $successcount,
				'errorcount' => $errorcount,
				'error' => $error 
		) );
	}
	public function delRecord() {
		$domaininfo = api_get_domain ();
		$hostName = checkString ( $_REQUEST ['hostName'] );
		$analysisValue = $_REQUEST ['analysisValue'];
		$list = daocall ( 'records', 'getListByValue', array (
				$domaininfo ['name'],
				$hostName,
				$analysisValue 
		) );
		$count = count ( $list );
		if ($count <= 0) {
			api_exit ( 2, '没有符合的记录' );
		}
		$successcount = 0;
		$errorcount = 0;
		foreach ( $list as $key => $row ) {
			if ($row ['t'] == 'NS') {
				$count --;
				continue;
			}
			$ret = apicall ( 'records', 'delRecord', array (
					$row ['id'],
					$domaininfo ['name'],
					$domaininfo ['server'] 
			) );
			if ($ret ['result'] == 200) {
				apicall ( 'monitor', 'delByDomainAndRecordid', array (
						$domaininfo ['name'],
						$row ['id'] 
				) );
				$successcount ++;
			} else {
				$errorcount ++;
				$error [$row ['id']] = $ret ['errmsg'];
			}
		}
		api_exit ( 1, array (
				'count' => $count,
				'successcount' => $successcount,
				'errorcount' => $errorcount,
				'error' => $error 
		) );
	}
	public function editRecord() {
		$domaininfo = api_get_domain ();
		$hostName = checkString ( $_REQUEST ['hostName'] );
		$analysisValue = $_REQUEST ['analysisValue'];
		$newvalue = checkString ( $_REQUEST ['newvalue'] );
		$newttl = intval ( $_REQUEST ['newttl'] );
		$newtype = checkString ( $_REQUEST ['newtype'] );
		if (! $newvalue && ! $newttl && ! $newtype) {
			api_exit ( 6, '必需要有修改的选项' );
		}
		if ($analysisValue == $newvalue) {
			api_exit ( 6, '新的解析值不能和旧的解析值相同' );
		}
		$list = daocall ( 'records', 'getListByValue', array (
				$domaininfo ['name'],
				$hostName,
				$analysisValue 
		) );
		$count = count ( $list );
		if ($count <= 0) {
			api_exit ( 2, '没有符合的记录' );
		}
		$successcount = 0;
		$errorcount = 0;
		foreach ( $list as $key => $row ) {
			if ($row ['t'] == 'NS') {
				$count --;
				continue;
			}
			$arr ['domain'] = $row ['domain'];
			$arr ['name'] = $row ['name'];
			$arr ['view'] = $row ['view'];
			$arr ['t'] = $newtype ? $newtype : $row ['t'];
			$arr ['ttl'] = $newttl > 0 ? $newttl : $row ['ttl'];
			$arr ['value'] = $newvalue ? $newvalue : $row ['value'];
			$ret = apicall ( 'records', 'changeRecord', array (
					$row ['id'],
					$arr,
					$domaininfo ['server'] 
			) );
			if ($ret ['result'] == 200) {
				$successcount ++;
			} else {
				$errorcount ++;
				$error [$row ['id']] = $ret ['errmsg'];
			}
		}
		api_exit ( 1, array (
				'count' => $count,
				'successcount' => $successcount,
				'errorcount' => $errorcount,
				'error' => $error 
		) );
	}
	
	/**
	 * 域名批量导入,有域名则添加记录，域名不存在，则增加域名
	 */
	public function addRecord() {
		$value = klencode ( trim ( $_REQUEST ['value'] ) );
		$domain = $_REQUEST ['domain'] ? trim ( $_REQUEST ['domain'] ) : trim ( $_REQUEST ['domain_id'] );
		if (! $domain) {
			api_exit ( 5, '域名不能为空' );
		}
		$domaininfo = apicall ( $this->apiname, 'getByDomain', array (
				$domain 
		) );
		if (! $domaininfo) {
			$uid = $this->userinfo ['id'];
			$server = $this->userinfo ['server'];
			$ret = apicall ( $this->apiname, 'add', array (
					$domain,
					$this->userinfo,
					$server 
			) );
			if ($ret ['result'] != 200) {
				api_exit ( 10, '增加域名失败,请重试,code=' . $ret ['result'] );
			}
			$dns_cfg = $this->getServerCfg ( $server );
			$domaininfo ['server'] = $server;
			$domaininfo ['group_view'] = $dns_cfg [$server] ['group_view'];
		} else {
			if ($domaininfo ['uid'] != $this->userinfo ['id']) {
				api_exit ( 5, '域名不是你的' );
			}
		}
		if (! $value) {
			api_exit ( 5, '解析值不能为空' );
		}
		$server = $domaininfo ['server'];
		$arr ['name'] = klencode ( $_REQUEST ['sub_domain'] );
		$arr ['ttl'] = intval ( $_REQUEST ['ttl'] );
		$arr ['replace'] = intval ( $_REQUEST ['replace'] );
		$arr ['t'] = klencode ( $_REQUEST ['record_type'] );
		$arr ['value'] = $value;
		$arr ['domain'] = $domain;
		$groupview [] = $domaininfo ['group_view'];
		$record_line = $_REQUEST ['record_line'] ? $_REQUEST ['record_line'] : '默认';
		$arr ['view'] = apicall ( 'views', 'getViewId', array (
				$record_line,
				$groupview 
		) );
		$addto = true;
		if ($arr ['replace'] > 0) {
			$recordinfo = daocall ( 'records', 'getRow', array (
					$arr ['domain'],
					$arr ['name'],
					$arr ['t'],
					$arr ['view'] 
			) );
			if ($recordinfo) {
				$id = $recordinfo ['id'];
				$addto = false;
				$ret = apicall ( 'records', 'changeRecord', array (
						$id,
						$arr,
						$server 
				) );
			}
		}
		if ($addto) {
			$arr ['id'] = 0;
			$ret = apicall ( 'records', 'addRecord', array (
					$arr,
					$server 
			) );
		}
		if ($ret ['result'] != 200) {
			api_exit ( 10, '操作意外失败,请重试,code=' . $ret ['result'] );
		}
		$record ['id'] = $ret ['value'];
		$record ['name'] = $arr ['name'];
		$record ['status'] = 'enable';
		// 允许添加监控的记录类型
		$monitor_line = array (
				'A',
				'AAAA',
				'CNAME' 
		);
		if (! in_array ( $arr ['t'], $monitor_line )) {
			$record ['monitor_enable'] = '';
		} else {
			$record ['monitor_enable'] = 'yes';
		}
		api_exit ( 1, array (
				'record' => $record 
		) );
	}
	/**
	 * 用于批量增加域名和记录。
	 * 因批量时没有指定域名。所以，不能用record.ctl里的getLine
	 */
	public function getPublicLine() {
		$server = $this->userinfo ['server'];
		$dns_cfg = $this->getServerCfg ( $server );
		$status ['code'] = '1';
		$group_view = $dns_cfg [$server] ['group_view'];
		if (! $group_view) {
			$group_view = '.0.0';
		}
		$views = apicall ( 'views', 'getIdMapName', array (
				$group_view 
		) );
		if (is_array ( $views )) {
			foreach ( $views as $v ) {
				$vi [] = $v;
			}
		}
		$status ['message'] = 'successflu';
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$value ['lines'] = $vi;
		$value ['status'] = $status;
		api_return ( $value );
	}
	/**
	 * 从数据库取最新的数据，因购买套餐的时候会修改pid，而修改后不能更新上级的数据.所以需要从数据库去取
	 */
	public function getInfo() {
		$domain = trim ( $_REQUEST ['domain'] );
		$domaininfo = daocall ( 'domains', 'getByNameAndUid', array (
				$domain,
				$this->userinfo ['id'] 
		) );
		unset ( $domaininfo ['passwd'], $domaininfo ['domain_key'] );
		if (! $domaininfo) {
			api_exit ( 6 );
		}
		// $domaininfo['pid'] = $domaininfo['pid'] > 0 ? $domaininfo['pid'] : '';
		api_exit ( 1, array (
				'info' => $domaininfo 
		) );
	}
	public function getList() {
		global $site_remark;
		$status ['code'] = 1;
		$status ['message'] = '操作成功完成';
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$email = $this->userinfo ['email'];
		$offset = intval ( $_REQUEST ['offset'] );
		$length = intval ( $_REQUEST ['length'] );
		$keyword = $_REQUEST ['keyword'];
		$group_id = intval ( $_REQUEST ['group_id'] );
		$uid = $this->userinfo ['id'];
		$domains = daocall ( 'domains', 'listByUid', array (
				$uid,
				$keyword,
				$offset,
				$length,
				null,
				&$domaincount,
				$group_id 
		) );
		// 获取产品
		// $cdnproduct = daocall('cdnproduct','getProduct',array());
		$info ['domain_total'] = $domaincount;
		$info ['all_total'] = $domaincount;
		$info ['mine_total'] = $domaincount;
		if ($domaincount > 0) {
			// 将用户提取的域名列表，扔入消息队列中检测NS
			apicall ( 'domains', 'addCheckNsToBeanstalk', array (
					$domains,
					$this->userinfo 
			) );
			$pinfos = daocall('product','getAll',array());
			$pinfoList = array();
			if ($pinfos) {
				foreach ($pinfos as $key=>$row) {
					$pinfoList[$row['id']] = $row;
				}
			}
			foreach ( $domains as $d ) {
				$ds ['server'] = $d ['server'];
				$ds ['rrl'] = $d ['rrl'];
				$ds ['flags'] = $d ['flags'];
				$ds ['groupview'] = $d ['group_view'];
				$ds ['id'] = $d ['name'];
				$ds ['name'] = $d ['name'];
				if ($d ['cdn_id'] > 0) {
					$ds ['sitestatus'] = 1;
				} else {
					$ds ['sitestatus'] = $d ['cdn_status'];
					$ds ['siteremark'] = $site_remark [$d ['cdn_status'] ['status']];
				}
				
				$ds ['domain'] = $d ['name'];
				$grade = "1";
				if ($d ['flags'] & DOMAIN_DIY_VIEW) {
					// diy view
					$grade = $d ['name'];
				}
				$grade .= $d ['group_view'];
				$ds ['grade'] = $grade;
				$ds ['grade_title'] = '';
				$ds ['record'] = 0;
				$ds ['group_id'] = $d ['gid'];
				$ds ['is_mark'] = $d ['mark'] == 1 ? 'yes' : '';
				if ($ds ['is_mark'] == 'yes') {
					$info ['ismark_total'] ++;
				}
				$ds ['remark'] = $d ['remark'];
				$ds ['is_vip'] = 'no';
				$ds ['searchengine_push'] = 'yes';
				$ds ['beian'] = 'no';
				$ds ['status'] = ($d ['flags'] & DOMAIN_STATUS) > 0 ? 'pause' : 'enable';
				$ds ['diy_view'] = ($d ['flags'] & DOMAIN_DIY_VIEW) > 0 ? 'yes' : '';
				// $ds['ext_status']=''表示未有任何错误
				if ((($d ['flags'] & DOMAIN_ADMIN_LOCK) > 0) || (($d ['flags'] & DOMAIN_ADMIN_SOFTLOCK) > 0 || ($d['flags'] & DOMAIN_AUDIT))) {
					$ds ['ext_status'] = 'adminlock';
					if ($d ['flags'] & DOMAIN_IS_EXPIRE) {
						$ds ['ext_status'] = 'expire';
					}
				} else if (($d ['flags'] & DOMAIN_IS_ATTACK)) {
					$ds ['ext_status'] = 'movecited';
				} else if (($d ['flags'] & DOMAIN_IS_EXPIRE)) {
					$ds ['ext_status'] = 'expire';
				} else {
					$ds ['ext_status'] = ($d ['flags'] & DOMAIN_NS) > 0 ? '' : 'dnserror';
				}
				// 时间为空，则会触发网络推送
				$ds ['created_on'] = $d ['created_on'];
				$ds ['updated_on'] = $d ['updated_on'];
				$ds ['ttl'] = $d ['ttl'] > 0 ? $d ['ttl'] : 600;
				$ds ['owner'] = $email;
				$ds ['pid'] = $d ['pid'] > 0 ? $d ['pid'] : '';
				$ds ['pname'] = '未购买';
				if ($d ['pid'] > 0 && isset($pinfoList[$d['pid']])) {
					$ds ['pname'] = $pinfoList[$d['pid']]['name'];
				}
				$ds ['pid_expire_time'] = $d ['pid_expire_time'] ? substr ( $d ['pid_expire_time'], 0, 10 ) : '';
				$ds ['pid_price'] = $d ['pid_price'] > 0 ? $d ['pid_price'] : '';
				$ds ['auto_renew'] = $d ['auto_renew'];
				$ds ['passwd'] = $d ['passwd'] ? 1 : '';
				$ds ['record_ns_protection'] = ($d ['flags'] & DOMAIN_RECORD_TCP) > 0 ? 'yes' : '';
				$ds ['ns_protection'] = ($d ['flags'] & DOMAIN_NS_PROTECTION) > 0 ? 'yes' : '';
				$value ['domains'] [] = $ds;
			}
		}
		$value ['status'] = $status;
		$value ['info'] = $info;
		// $value['cdnproduct'] = $cdnproduct;
		api_return ( $value );
	}
	/**
	 * //TODO::有问题，域名单独登陆出现权限错误,已于2014.04.28在record.ctl里复制了一份，
	 */
	public function getTips() {
		$status ['status'] = 'error';
		$user_group = 'free';
		$domain = _F ( $_REQUEST ['domain'] );
		$this->domaininfo = apicall ( $this->apiname, 'getByName', array (
				$domain 
		) );
		//检测的结果
		$ok = false;
		$servers = apicall ( 'server', 'getById2', array (
				$this->domaininfo ['server'],
				$this->domaininfo ['ns1'],
				$this->domaininfo ['ns2'] 
		) );
		if ($this->domaininfo) {
			$nstime = toTime ( $this->domaininfo ['ns_select_time'] );
			$difftime = time () - $nstime;
			$flag = testFlags ( $this->domaininfo ['flags'], DOMAIN_NS );
			// 如果flags不正常，则一小时后查询
			if (! $flag && $difftime < 3600 && $this->domaininfo ['ns_select_time']) {
				$ok = false;
				// 如果flags已为正常，则2天后再查询
			} else if (($flag && $difftime < 86400 * 2)) {
				$ok = true;
			} else {
				$nss = apicall ( $this->apiname, 'query_ns', array ($domain ) );
				if ($nss && count($nss) > 0) {
					//把后面的.去掉，防止有一边有.造成不匹配
					$newNsList = array();
					foreach ($nss as $ns) {
						array_push($newNsList, trim($ns,'.'));
					}
					//只要有一个NS匹配了，就表示成功
					foreach ( $servers as $s ) {
						if (in_array ( trim($s,'.'), $newNsList )) {
							$ok = true;
						}
					}
				}
				$arr ['ns_select_time'] = 'NOW()';
				apicall ( $this->apiname, 'setByName', array ($this->domaininfo ['name'],$arr ) );
				//如果是检测Ok但是本身不可以，或者检测不可以本来可以的才修改这个flags
				if ((!$flag && $ok) || ($flag && !$ok)) {
					$flags = $ok == false ? '-8' : '+8';
					$ret = apicall ( $this->apiname, 'setDomainFlags', array ($this->domaininfo ['name'],$flags,$this->domaininfo ['server']) );
				}
			}
		}
		if ($ok) {
			$status ['status'] = 'ok';
		} else {
			$status ['string'] = "<p>请将域名的NS记录修改为<ul><li>";
			$status ['string'] .= $servers [0] . "</li> <li>" . $servers [1] . "</li> </ul>即可使用dnsdun的服务 </p>";
			$status ['string'] .= "<p>注意不能同时和其他 DNS 混用，会导致解析混乱哦～</p> <p>修改 DNS 服务器需要最长 72 小时的全球生效时间，请耐心等待</p>";
		}
		api_return ( $status );
	}
	public function add() {
		$domain = trim ($_REQUEST ['domain']);
		// 判断是否为预留域名
// 		if (daocall ( 'domainreserved', 'getReservedDomain', array ($domain))) {
// 			api_exit ( 7, array ('ret' => $domain,'mess' => '域名以存在'));
// 		}
// 		if (apicall ( $this->apiname, 'getByName', array ($domain))) {
// 			api_exit ( 7, array ('ret' => $domain,'mess' => '域名以存在'));
// 		}
		$arr ['email'] = $this->userinfo ['email'];
		$domain = klencode ( $domain );
		// 中文域名解码
// 		if (substr ( $domain, 0, 4 ) == "xn--") {
// 			$domain = $this->punycode_decode ( $domain, "utf8" );
// 		}
		$arr ['name'] = $domain;
		$servername = $this->userinfo ['server'];
		if (! $servername) {
			api_exit ( 8, '用户信息s不存在,请联系管理员' );
		}
		// 调用dnsdun的PHP接口，非是直接调用SQL插入
		$ret = apicall ( $this->apiname, 'add', array (
				$arr ['name'],
				$this->userinfo,
				$servername,
				$_REQUEST ['group_id']
		) );
		if ($ret ['result'] !== 200) {
			//api_exit ( 10, '增加意外失败:code=' . $ret ['result']);
			api_exit ( 10,array('ret'=>'增加意外失败:code=' . $ret ['result'],'domain'=>$domain));
		}
		//$domainRet = apicall ( $this->apiname, 'getByName', array ($domain));
		//$productinfo = daocall('product', "getById",array($domainRet['pid']));
		$domains ['id'] = $arr ['name'];
		$domains ['punycode'] = $arr ['name'];
		$domains ['domain'] = $arr ['name'];
		$domains ['flags'] = ($ret ['flags'] & 8) > 0 ? 'yes' : null;
		$domains['pid'] = $ret['pid'];
		$domains['pname'] = $ret['pname'];
		$domains['pid_expire_time'] = $ret['pid_expire_time'];
		api_exit ( 1, array ('domain' => $domains,'ret' => $domain));
	}
	public function domainAdd() {
		$this->add();
	}
	public function buyProduct() {
		$status ['code'] = 1;
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$this->check ();
		$ret = apicall ( $this->apiname, 'updateProduct', array (
				$this->domaininfo ['name'],
				$this->domaininfo ['uid'],
				$this->domaininfo ['server'],
				$_REQUEST ['pid'] 
		) );
		if (! $ret) {
			$status ['code'] = 5;
			$status ['message'] = $GLOBALS ['last_error'];
		}
		$value ['status'] = $status;
		api_return ( $value );
	}
	public function log() {
	}
	public function changeTtl() {
		$arr ['ttl'] = intval ( $_REQUEST ['ttl'] );
		$status ['code'] = '1';
		$status ['message'] = '操作成功完成';
		$this->check ( $status );
		$this->domain = $this->domaininfo ['name'];
		$ret = apicall ( $this->apiname, 'setByName', array (
				$this->domain,
				$arr 
		) );
		if (! $ret) {
			$status ['code'] = '10';
			$status ['message'] = '操作意外失败';
		} else {
			$_SESSION ['janbao_role'] ['domain'] ['ttl'] = $arr ['ttl'];
		}
		$value ['status'] = $status;
		api_return ( $value );
	}
	public function mark() {
		$status ['code'] = '1';
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$status ['message'] = '操作成功完成';
		$arr ['mark'] = $_REQUEST ['is_mark'] == 'yes' ? 1 : 0;
		$this->check ();
		$this->domain = $this->domaininfo ['name'];
		$ret = apicall ( $this->apiname, 'setByName', array (
				$this->domain,
				$arr 
		) );
		if (! $ret) {
			$status ['code'] = '10';
			$status ['message'] = '操作意外失败';
		}
		$value ['status'] = $status;
		api_return ( $value );
	}
	public function remark() {
		$status ['code'] = '1';
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$status ['message'] = '操作成功完成';
		$this->check ();
		$this->domain = $this->domaininfo ['name'];
		$arr ['remark'] = klencode ( $_REQUEST ['remark'] );
		$ret = apicall ( $this->apiname, 'setByName', array (
				$this->domain,
				$arr 
		) );
		if (! $ret) {
			$status ['code'] = '10';
			$status ['message'] = '操作意外失败';
		} else {
			$_SESSION ['janbao_role'] ['domain'] ['remark'] = $arr ['remark'];
		}
		apicall ( $this->apiname, 'changeDate', array (
				'updated_on',
				$this->domain 
		) );
		$value ['status'] = $status;
		api_return ( $value );
	}
	private function check() {
		$this->domaininfo = api_get_domain ();
	}
	public function del() {
		$status ['code'] = '1';
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$status ['message'] = '操作成功完成';
		$this->check ();
		$this->domain = $this->domaininfo ['name'];
		$ret = apicall ( $this->apiname, 'delDomain', array (
				$this->domain,
				$this->domaininfo ['server']
		) );
		if ($ret ['result'] != 200) {
			$status ['code'] = '10';
			$status ['message'] = '域名删除意外失败,code=' . $ret ['result'];
		}
		$value ['status'] = $status;
		api_return ( $value );
	}
	public function domainDel() {
		$this->del();
	}
	public function getGroup() {
		$json = '{"status":{"code":"1","message":"\u64cd\u4f5c\u5df2\u7ecf\u6210\u529f\u5b8c\u6210","created_at":"2013-08-14 15:44:55"},"groups":[]}';
		die ( $json );
	}
	public function changeStatus() {
		$status ['code'] = '1';
		$status ['created_at'] = date ( "Y-m-d H:i:s", time () );
		$status ['message'] = '操作成功完成';
		$this->check ();
		$this->domain = $this->domaininfo ['name'];
		$s = $_REQUEST ['status'] == 'disable' ? 1 : 0;
		$this->domaininfo = apicall ( $this->apiname, 'getByDomain', array (
				$this->domain 
		) );
		$ret = apicall ( $this->apiname, 'changeStatus', array (
				$this->domain,
				$s,
				$this->domaininfo ['server'] 
		) );
		if ($ret ['result'] != 200) {
			$status ['code'] = '10';
			$status ['message'] = '操作意外失败，请重试,code=' . $ret ['result'];
		} else {
			// 同步修改监控的状态
			apicall ( 'monitor', 'changeActiveByDomain', array (
					$this->domain,
					$s == 0 ? 1 : 0 
			) );
		}
		$value ['status'] = $status;
		api_return ( $value );
	}
	public function getRecordValue(){
		//对domain uid,email,server,常量 进行md5加密
		$domain = $_POST['domain'];
		$domaininfo = daocall('domains','getDomainByName',array($domain));
		if($domaininfo['local_register'] == 1){
			api_exit(10,array('ret'=>'域名受保护请联系管理员'));
		}
		if($domaininfo['flags'] & DOMAIN_ADMIN_LOCK){
			api_exit(10,array('ret'=>'域名被禁用'));
		}
		global $dns_cfg;
		if($domaininfo['server'] != $dns_cfg['server']){
			api_exit(10,array('ret'=>'此域名为VIP'));
		}
		if($domaininfo){
			$key = md5($this->userinfo['id'].$this->userinfo['email'].$this->userinfo['server'].DOMAIN_YAN_ZHENG);
			api_exit(1,array('key'=>$key));
		}
		api_exit(10,array('ret'=>'获取记录值失败'));
	}
	public function domainYanzheng(){
		$domain = $_POST['domain'];
		$userinfo = $this->userinfo;
		$ret = apicall('domains','domainYangzheng',array($domain,$userinfo));
		if($ret){
			api_exit(1,array('ret'=>getLastError()));
		}
		api_exit(10,array('ret'=>getLastError()));
	}
	// 中文域名解码
	// punycode 解码
// 	private function punycode_decode($input, $code = "GBK") {
// 		$input = trim ( $input );
// 		$strarr = array ();
// 		$strarr = explode ( ".", $input );
// 		$output = "";
// 		for($i = 0; $i < count ( $strarr ); $i ++) {
// 			if (substr ( $strarr [$i], 0, 4 ) == "xn--") {
// 				$input = substr ( $strarr [$i], 4 );
// 				$outtmp = $this->punycode_decode2 ( $input, $code );
				
// 				if (! $outtmp || $outtmp < 0)
// 					return;
				
// 				$output .= $outtmp;
// 			} else {
// 				$output .= $strarr [$i];
// 			}
// 			if ($i != count ( $strarr ) - 1)
// 				$output .= ".";
// 		} // for
// 		return $output;
// 	}
// 	// 主要的解码转换工作
// 	private function punycode_decode2($input, $code = "GBK") {
// 		$n = punycode_INITIAL_N;
// 		$out = 0;
// 		$i = 0;
// 		$max_out = 256;
// 		$bias = punycode_INITIAL_BIAS;
// 		$inputlen = strlen ( $input );
// 		$outputa = array ();
		
// 		$b = 0;
// 		for($j = 0; $j < $inputlen; $j ++)
// 			if ($input {$j} == "-")
// 				$b = $j;
		
// 		for($j = 0; $j < $b; $j ++) {
// 			/* 不考虑大小写 */
// 			if (ord ( $input {$j} ) - 65 < 26)
// 				$case_flags [$out] = "1";
// 			else
// 				$case_flags [$out] = "0";
			
// 			if (ord ( $input {$j} ) > 128)
// 				return - 1;
// 				// $output.=$input{$j};
// 			$outputa [] = ord ( $input {$j} );
// 			$out ++;
// 		}
		
// 		for($in = $b > 0 ? $b + 1 : 0; $in < $inputlen; $out ++) {
// 			$oldi = $i;
// 			$w = 1;
// 			for($k = punycode_BASE;; $k += punycode_BASE) {
// 				if ($in >= $inputlen)
// 					return - 2;
// 				$digit = $this->punycode_decode_digit ( ord ( $input {$in ++} ) );
// 				if ($digit >= punycode_BASE)
// 					return - 3;
// 				if ($digit > (punycode_MAXINT - $i) / $w)
// 					return - 4;
// 				$i = $i + $digit * $w;
// 				$t = $k <= $bias ? punycode_TMIN : ($k >= ($bias + punycode_TMAX) ? punycode_TMAX : ($k - $bias));
// 				if ($digit < $t)
// 					break;
// 				if ($w > punycode_MAXINT / (punycode_BASE - $t))
// 					return - 5;
// 				$w = $w * (punycode_BASE - $t);
// 			}
			
// 			$bias = $this->punycode_adapt ( $i - $oldi, $out + 1, $oldi == 0 );
// 			if ($i / ($out + 1) > punycode_MAXINT - $n)
// 				return - 6;
// 			$n += ( int ) ($i / ($out + 1));
// 			$i = $i % ($out + 1);
			
// 			if ($out >= $max_out)
// 				return - 7;
				
// 				/*
// 			 * 不考虑大小写
// 			 * for ($q=0;$q<$out-$i;$i++) $case_flags[$i+1+$q]= $case_flags[$i+$q];
// 			 *
// 			 * if ($input[$in-1]-65<26)
// 			 * $case_flags[$i]='1';
// 			 * else
// 			 * $case_flags[$i]='0';
// 			 */
// 			for($qq = 0; $qq < ($out - $i); $qq ++)
// 				$outputa [($i + $out) - $i - $qq] = $outputa [($i + $out) - $i - $qq - 1];
			
// 			$outputa [$i ++] = $n;
// 		}
		
// 		$outputstr = "";
// 		for($i = 0; $i < count ( $outputa ); $i ++) {
// 			if ($outputa [$i] < 128)
// 				$outputstr .= chr ( $outputa [$i] );
// 			else {
// 				$hx = dechex ( $outputa [$i] );
// 				$gaowei = substr ( $hx, 2, 2 );
// 				$diwei = substr ( $hx, 0, 2 );
// 				$tmp_output = chr ( hexdec ( $gaowei ) ) . chr ( hexdec ( $diwei ) );
// 				$tmp_output = iconv ( "Unicode", $code, $tmp_output );
// 				$outputstr .= $tmp_output;
// 			}
// 		}
// 		return $outputstr;
// 	}
// 	// 编码的参数
// 	private function punycode_adapt($delta, $numpoints, $firsttime) {
// 		if ($firsttime)
// 			$delta = ( int ) ($delta / punycode_DAMP);
// 		else
// 			$delta = ( int ) ($delta / 2);
		
// 		$delta += ( int ) ($delta / $numpoints);
		
// 		for($k = 0; $delta > ( int ) (((punycode_BASE - punycode_TMIN) * punycode_TMAX) / 2); $k += punycode_BASE) {
// 			$delta = ( int ) ($delta / (punycode_BASE - punycode_TMIN));
// 		}
// 		return $k + ( int ) (((punycode_BASE - punycode_TMIN + 1) * $delta) / ($delta + punycode_SKEW));
// 	}
// 	// 处理数字,大小写字母
// 	private function punycode_decode_digit($c) {
// 		if (($c - 48) < 10)
// 			return ($c - 22);
// 		if (($c - 65) < 26)
// 			return ($c - 65);
// 		if (($c - 97) < 26)
// 			return ($c - 97);
// 		return punycode_BASE;
// 	}
	//
}
