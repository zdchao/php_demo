<?php
header("content-Type: text/html; charset=utf8"); 
/*----------------------------------------
 商务中国,修改域名所有者信息
 -----------------------------------------*/
$hostname = "120.25.217.82";
$port = 8000;
$fp = fsockopen($hostname,$port,$errno, $errstr, 30);
if(!$fp){
	echo "$errstr ($errno)<br />\n";
	die();
}

$string = "domainname\r\n";
$string .="mod\r\n";
$string .="entityname:domain-owner\r\n";
$string .="domainname:zhudechaobbq.com\r\n";
$string .="dom_org_m:朱德超\r\n";//中文
$string .="dom_org:zhu de chao\r\n";//英文
$string .="dom_ln_m:朱\r\n";//姓中文
$string .="dom_ln:zhuu\r\n";//姓英文
$string .="dom_fn_m:名\r\n";//名中文
$string .="dom_fn:min\r\n";//名英文
$string .="dom_adr1:addr1\r\n";//地址英文
$string .="dom_ct:nanchang\r\n";//城市英文
$string .="dom_st:jingxi\r\n";//省份英文
$string .="dom_adr_m:江西省萍乡市\r\n";//地址中文
$string .="dom_ct_m:萍乡\r\n";//城市中文
$string .="dom_st_m:江西\r\n";//省份中文
$string .="dom_co:CN\r\n";//国家
$string .="dom_pc:330028\r\n";
$string .="dom_ph:+86.18779175574\r\n";
$string .="dom_fax:+86.7917502886\r\n";
$string .="dom_em:1474083407@qq.com\r\n";
$string .="confirm_new_registrant:1\r\n";
$string .="confirm_old_registrant:1\r\n";
$string .="request_transferlock:0\r\n";
$string .=".\r\n";
$string = mb_convert_encoding($string, "GBK", "UTF-8"); 
//print_r($string);
//die();
fputs($fp, $string);

$strReturn = "";
while (!feof($fp)){
	$strReturn .= fgets($fp, 100);
	if(strstr($strReturn, "\r\n.\r\n")){
		break;
	}
}
fclose($fp);
print_r($strReturn);