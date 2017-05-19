<?php
$userinfo =array(
		"email_control"=>"1495089999,1,100,0"
);
function sendControl($userinfo){
	$time = time();
	$email_control_arr = preg_split("/,/",$userinfo["email_control"]);
	
	$eca0 = intval($email_control_arr[0]);//时间戳
	$eca1 = intval($email_control_arr[1]) * 3600;//间隔秒数
	$eca2 = intval($email_control_arr[2]);//间隔时间内可以发送多少封邮件
	$eca3 = intval($email_control_arr[3]);//已发送邮件数
	
	if(($time-$eca0)<=$eca1){
		if($eca3 <= $eca2){
			//更新数据，可以发送邮件
			return true;
		}
		return false;
	}
	//重置发送数据,可以发送邮件
	return true;
}

sendControl($userinfo);