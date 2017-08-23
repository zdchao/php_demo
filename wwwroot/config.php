<?php
$db_cfg['default']=array(

		'driver'=>'mysql',

		'host'=>'localhost',

		'port'=>'3306',

		'user'=>'dnsdun',

		'passwd'=>'CrH5RYvnc7',

		'dbname'=>'dnsdun'
);
$dns_cfg = array(
	
		"host"	=>'127.0.0.1',
		'port' 	=>2013,
		'key'	=>'f2PEoCZaf2PEoCZa',
		'monitor'=>'vip.aegins',
		'soa'	=>'ns1.dnsdun.com. admin.dnsdun.com. 1 3600 180 1209600 180',
		'rrl'  	=>'',
		'flags' => 33,
		'group_view'=>'.0.0',
		'server'=>'0.aegins'
);
$dns_server_cfg = array(
	'dnsdun.com'		=>'test',
	'www.dnsdun.com'	=>'test',
	'kddos.cp.dnsdun.com'=>'kddos'
);
$beanstalk_cfg =  array(
		'persistent' => true,
		'host' => 'localhost',
		'port' => 11300,
		'timeout' => 5
);

date_default_timezone_set('Asia/Shanghai');
define('WEB_DOMAIN','dns.aegins.com');
define("WEB_NAME","Aegins");
$default_server_email = 'admin@dns.aegins.com';
define('DOMAIN_RNAME','admin.dnsdun.com.');
define('DOMAIN_MNAME','ns1.dnsdun.com.');
//define('ISCDN',1);
define('USER_ALLOW_DEL',1);   //用户的添加，删除,修改密码
define('DOMAIN_ALLOW_DEL',1);  //域名的删除
define("FREE_PNAME","未购买");
define("CHECK_NS_NO_DELAY",300);
