<?php
/*--------------------------------------
 * 修改域名的DNS(解析服务器)
--------------------------------------*/
$hostname = "120.25.217.82";
$port = 8000;
$fp = fsockopen($hostname,$port,$errno, $errstr, 30);
if(!$fp){
	echo "$errstr ($errno)<br />\n";
	die();
}

$string = "";
$string .="domainname\r\n";
$string .="mod\r\n";
$string .="entityname:domain-dns\r\n";
$string .="domainname:zhudechao123.xyz\r\n";
$string .="dns_host:ns1.dnsdun.com\r\n";
$string .="dns_host:ns1.dnsdun.net\r\n";
$string .=".\r\n";
fputs($fp,$string);

$strReturn = "";
while (!feof($fp)){
	$strReturn .= fgets($fp,100);
	if(strstr($strReturn, "\r\n.\r\n")){
		break;
	}
}
fclose($fp);
print_r($strReturn);