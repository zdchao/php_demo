<?php
function curlPost($url, $data = NULL,$method="POST",$timeout = 30){
	$ch = curl_init($url);
	if (substr($url,0,5)=='https') {
		//如果是https，则要加上这两个参数
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,"1");
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	}
	curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_HEADER, false);//不打印head信息
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type:text/xml; charset=utf-8"));
	//加上这个，否则会把源数据也打印出来
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	//数据发送方式
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	curl_close($ch);
	return $response;
}

$data = array(
		"name"=>"keengo"
);
$ret = curlPost("https://www.bizcn.com/rrpservices/?wsdl",$data);
print_r($ret);
die();