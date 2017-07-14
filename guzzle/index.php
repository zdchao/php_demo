<?php
/*
 * https 调用配置
 * 
 * php.ini
 * curl.cainfo ="C:\zhdc\UPUPW_K2.1_64\PHPX\PHP56\extras\ssl\ca-bundle.crt"
 * 目前配置curl.cainfo就可以啦
 * openssl.cafile="C:\zhdc\UPUPW_K2.1_64\PHPX\PHP56\extras\ssl\ca-bundle.crt"
 * 
 * 证书下载地址
 * 下载地址:https://curl.haxx.se/docs/caextract.html
 * 
 * */
date_default_timezone_set("Asia/Shanghai");
ini_set("display_errors","On");
error_reporting(E_ALL);
include_once "vendor/autoload.php";

$client = new \GuzzleHttp\Client();
/*
 [
		"headers"=>[
				"Content-Type"=>"application/x-www-form-urlencoded"
		],
		"form_params"=>[
				"uid"=>"5599"
		]
]
 * */
$t = time();
$sign = md5(md5("5614"."pD34nzFa583CAb4c").$t);
echo $t."<br/>";
echo $sign."<br/>";
die();
$apiRequest = $client->request('POST', 'https://www.cdnbest.com/api2/user/index.php/token',[
		"headers"=>[
				"Content-Type"=>"application/x-www-form-urlencoded"
		],
		"form_params"=>[
				"uid"=>"5614",
				"t"=>$t,
				"sign"=>md5(md5("5614"."pD34nzFa583CAb4c").$t)
		]
]);
//请求信息
$headers = $apiRequest->getHeaders();
echo "请求头信息<br/>";
foreach ($headers as $key=>$value){
	echo $key . ': ' . implode(', ', $value) . "<br/>";
}


//响应信息
echo "<br/><br/>";
echo "响应信息<br/>";
$status_code = $apiRequest->getStatusCode();
echo "状态码：".$status_code."<br/>";
$reason_phrase = $apiRequest->getReasonPhrase();
echo "状态码说明：".$reason_phrase."<br/>";
$version = $apiRequest->getProtocolVersion();
echo "http版本：".$version."<br/>";
//获取返回body信息
$json = $apiRequest->getBody();
$arr = json_decode($json,true);
print_r($arr);
die();