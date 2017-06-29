<?php
//header("Content-Type: text/html; charset=UTF-8");

define("NOTICE_SEND_COUNT",20);
$sqlite_cfg = array(
	"type"=>"sqlite",
	"dbname"=>"C:/zhdc/zhdcmm.db"
);

include_once 'send_notice_control.php';
$snc = new SendNoticeControl();
var_dump($snc->check("r",10));
echo "bottom";
//$snc->flush();