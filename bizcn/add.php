<?php
/*----------------------------------------
 * 域名注册
------------------------------------------*/
header("Content-Type: text/html; charset=UTF-8");
$hostname = "120.25.217.82";
$port = 8000;
$fp = fsockopen($hostname,$port,$errno, $errstr, 30);
if(!$fp){
	echo "$errstr ($errno)<br />\n";
	die();
}
$string = "domainname\r\n";
$string .="add\r\n";
$string .="entityname:domain\r\n";
$string .="domainname:zhudechao123.xyz\r\n";
$string .="term:1\r\n";
$string .="dns_host1:ns5.dnsdun.com\r\n";
$string .="dns_host2:ns5.dnsdun.net\r\n";
$string .="dom_ln:朱\r\n";
$string .="dom_fn:德\r\n";
$string .="dom_org:朱德\r\n";
$string .="dom_adr1:江西省南昌市\r\n";
$string .="dom_ct:南昌\r\n";
$string .="dom_st:江西\r\n";
$string .="dom_co:CN\r\n";
$string .="dom_ph:+86.18779175574\r\n";
$string .="dom_pc:330029\r\n";
$string .="dom_fax:+86.7502559\r\n";
$string .="dom_em:995949180@qq.com\r\n";
$string .="admi_ln:朱\r\n";
$string .="admi_fn:德\r\n";
$string .="admi_adr1:江西省南昌市\r\n";
$string .="admi_ct:南昌\r\n";
$string .="admi_st:江西\r\n";
$string .="admi_co:CN\r\n";
$string .="admi_ph:+86.18779175574\r\n";
$string .="admi_pc:330029\r\n";
$string .="admi_fax:+86.7502665\r\n";
$string .="admi_em:995949180@qq.com\r\n";
$string .="tech_ln:朱\r\n";
$string .="tech_fn:德\r\n";
$string .="tech_adr1:江西省南昌市\r\n";
$string .="tech_ct:南昌\r\n";
$string .="tech_st:江西\r\n";
$string .="tech_co:CN\r\n";
$string .="tech_ph:+86.18779175574\r\n";
$string .="tech_pc:330029\r\n";
$string .="tech_fax:+86.7502665\r\n";
$string .="tech_em:995949180@qq.com\r\n";
$string .="bill_ln:朱\r\n";
$string .="bill_fn:德\r\n";
$string .="bill_adr1:江西省南昌市\r\n";
$string .="bill_ct:南昌\r\n";
$string .="bill_st:江西\r\n";
$string .="bill_co:CN\r\n";
$string .="bill_ph:+86.18779175574\r\n";
$string .="bill_pc:330029\r\n";
$string .="bill_fax:+86.7502559\r\n";
$string .="bill_em:995949180@qq.com\r\n";
$string .= ".\r\n";
fputs($fp, $string);

$strReturn= "";
while (!feof($fp)){
	$strReturn .= fgets($fp,100);
	if(strstr($strReturn, "\r\n.\r\n")){
		break;
	}
}

fclose($fp);

print_r($strReturn);