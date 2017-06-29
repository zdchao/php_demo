<?php
/*----------------------------------------
 商务中国,查询域名是否可以注册
-----------------------------------------*/
$hostname = "120.25.217.82";
$port = 8000;
$fp = fsockopen($hostname,$port,$errno, $errstr, 30);
if(!$fp){
	echo "$errstr ($errno)<br />\n";
	die();
}

$string = "domainname\r\n";
$string .= "check\r\n";
$string .= "entityname:domain\r\n";
$string .= "domainname:zhudechao123.xyz\r\n";
$string .=".\r\n";
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