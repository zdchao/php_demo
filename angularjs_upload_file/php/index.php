<?php
sleep(10);
die();
ini_set("display_errors","On");
error_reporting(E_ALL);
$path = dirname(dirname(__FILE__))."/user_information/img/";
$uid = "1";
$files = $_FILES;
if(isset($files["file"])){
	$files["shengfengzheng"] = $files["file"];
}
if ($files['shengfengzheng']['type'] != "image/jpeg"){
	die(json_encode(array("ret"=>"图片格式错误,请上传.jpg图片","file"=>$files)));
}
if(($files['shengfengzheng']['size']/1000) > 1024){
	die(json_encode(array("ret"=>"身份证图片不能大于1M")));
}

if(!file_exists($path.$uid)){
	mkdir($path.$uid);
}
$img_name = basename($path.$uid."/".$files['shengfengzheng']['name']);
$extpos = strrpos($img_name,'.');
$ext = substr($img_name,$extpos+1);
move_uploaded_file($files['shengfengzheng']['tmp_name'],$path.$uid."/identity_card.".$ext);
die(json_encode(array("ret"=>"身份证照片上传成功")));