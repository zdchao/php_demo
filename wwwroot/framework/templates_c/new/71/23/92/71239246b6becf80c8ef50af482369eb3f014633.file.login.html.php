<?php /* Smarty version Smarty-3.0.5, created on 2016-04-19 15:52:04
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/session/login.html" */ ?>
<?php /*%%SmartyHeaderCode:10932153975715e3a4e896a3-30256459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71239246b6becf80c8ef50af482369eb3f014633' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/session/login.html',
      1 => 1461052320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10932153975715e3a4e896a3-30256459',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aegins</title>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<style>
body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6,pre, form, fieldset, input, textarea, p, blockquote, th, td {padding:0; margin:0;}    
fieldset, img { border: 0; }    
table {border-collapse: collapse;  border-spacing: 0;}    
ol, ul {list-style: none; }    
address, caption, cite, code, dfn, em, strong, th, var { font-weight: normal; font-style: normal;}    
caption, th {text-align: left;}    
h1, h2, h3, h4, h5, h6 {font-weight: normal;font-size: 100%;}    
q:before, q:after {content: '';}    
abbr, acronym {border: 0;}

body{font:12px/1.8em Tahoma, Helvetica, Arial, sans-serif;background:#fff;font-family:"微软雅黑";}
.marginC{margin:0 auto;}
.borderN{border:none;}
.floatL{float:left;}
.floatR{float:right;}
.clearB{clear:both;}
a{text-decoration:none;}
img{border:none;}
.blank1{height:1px;clear:both;overflow:hidden;}
.blank5{height:5px;clear:both;overflow:hidden;}
.blank10{height:10px;clear:both;overflow:hidden;}
.blank3{height:2px;clear:both;overflow:hidden;}

body{width:100%; height:100%; margin:0px auto;}

.dl_top{width:900px; height:240px; margin:0px auto;}


.dl_bj{width:100%; height:395px; margin:0px auto; background:#333333;}
.dl_nr{width:900px; height:395px;display:block; margin:0px auto;}
.dl_nr h3{ width:435px; height:95px; margin:0px auto;}
.dl_nr p{width:488px; height:55px; margin:0px auto; display:block;}
.dl_nr p a{ padding:0px 30px 0px 10px; font-size:15px; line-height:55px; color:#fff; }
.dl_nr p a:hover{color:#ff6760;}
.dl_nr p span{ float:left;width:105px; height:auto; display:block; text-align:right; line-height:55px; font-size:15px; color:#fff;}
.dl_nr p input{ border:none;}
.dl_nr p input:focus {outline:none;}

.dl_nr ul{ width:488px; height:60px; margin:0px auto;}
.dl_nr ul li{width:240px; height:50px; display:block;}

.dl_bottom{width:1350px; height:100px; margin:0px auto; }
.dl_bottom p{text-align:center; color:#999999; line-height:100px; font-size:15px;}
</style>
</head>

<body style="overflow-x:hidden;"><!--<div class="dl_top">
	<p><a href="#"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
agies/img/login_logo.png" /></a></p>
</div>-->

<div class="dl_bj" style="margin-top:10%">
                <!--<style>
					.login_form_malupet{
						width: 107%;
						background-color: #333333;
						color: #ffffff;
						margin-top: 10%;
						margin-left: -7%;
						padding: 20px 0px;
					}
                    .navbar{
                        display:none;
                    }
					form#login-from{
						margin:20px auto;
						padding:10px;
						text-align:center;
						width:500px;
					}
					.form-horizontal .control-group{
						margin: 20px 0px;
					}
					input[type="text"]{
						height: 24px;
						line-height: 24px;
						padding-top: 4px;
						padding-bottom: 4px;
						font-size: 16px;
					}
					.control-group{
						margin-bottom: 10px;
    					padding: 5px;
					}
					input, button, select, textarea{
						font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
					}
					label, input, button, select, textarea{
						font-size: 14px;
						font-weight: normal;
						line-height: 20px;
					}
					button, input, select, textarea {
						margin: 0;
						font-size: 100%;
						vertical-align: middle;
					}
					a {
						color: #696969;
						text-decoration: none;
					}
                </style>

				<div class="login_form_malupet" style="margin-top:77px; height:355px;">-->
                
                <!--<h1>用户登陆</h1>-->
                <!--<center><img src="https://cdn.aegins.com/user/view/default/images/dl_top.png" style="margin-top:-20px;"></center>
                    <form action="?c=session&a=login" method="post" class="form-horizontal" id="login-from"  onsubmit="return check()">
                        <div class="control-group" style="border:1px solid #ffffff; width:470px; padding:8px; margin-top:-20px; text-align:left;">
                            <div class="controls">
                                <img src="https://cdn.aegins.com/proxy/view/default/session/yonghuming.png"><input type="text" name="user" placeholder="用户名" style="border:none; background-color:transparent; width:410px; color:#ffffff;">
                            </div>
                        </div>
                        <div class="control-group" style="border:1px solid #ffffff; width:470px; padding:8px; margin-top:20px; text-align:left;">
                            <div class="controls">
                                <img src="https://cdn.aegins.com/proxy/view/default/session/mima.png"><input type="password" name="passwd" placeholder="密码" style="border:none; background-color:transparent; width:410px; color:#ffffff;">
                            </div>
                        </div>
                        <a href="?c=public&a=findPasswdFrom" title="注册" style="color:#ffffff; float:left;">忘记密码？</a>
                        <?php if ($_smarty_tpl->getVariable('errormsg')->value){?>
                        	<span id="login_error"  style="width:200px; height:23px;color:red"><?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
</span>
                        <?php }?>
                        <br><br>
                        <button type="submit" onclick="btnUpdate_Click()" style="background-color:#ff6760; border:none; color:#ffffff; width:240px; height:50px; float:left;">登陆</button>
                        <a onclick="window.location.href='?c=public&a=registerForm'" title="注册">
                        	<div style="background-color:#e5e5e5; width:240px; height:35px; color:#ff6760; border:none; padding-top:15px; margin-right:12px; text-align:center; float:right;" class="clearfix">注册</div>
                        </a>
                    </form>
                </div>-->
<center>
<form  action="?c=session&a=login" method="post">
	<div class="dl_nr">
    	<h3><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
agies/img/dnslogin.png" /></h3>
        <div class="control-group" style="border:1px solid #ffffff;width: 488px;height: 32px;padding: 8px 0px; text-align:left;margin: 0px auto;">
        	<div class="controls">
            	<img src="https://cdn.aegins.com/proxy/view/default/session/yonghuming.png" style="float:left; margin-left: 10px;">
                <input type="text" name="user" placeholder="用户名" style="border:none;background-color:transparent;width: 410px;height: 32px;color:#ffffff;font-size: 16px;float:none;padding: 6px;" autocomplete="off">
			</div>
		</div>
		<div class="control-group" style="border:1px solid #ffffff;width: 488px;height: 32px;padding: 8px 0px; text-align:left;margin: 0px auto; margin-top:20px;">
			<div class="controls">
				<img src="https://cdn.aegins.com/proxy/view/default/session/mima.png" style="float:left; margin-left: 10px;">
                <input type="password" name="passwd" placeholder="密码" style="border:none;background-color:transparent;width: 410px;height: 32px;color:#ffffff;font-size: 16px;float:none;padding: 6px;" autocomplete="off">
			</div>
		</div>
                
        <!--<div class="blank10"></div> 
        
        	<p style="background:url(<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
agies/img/yonghuming.png) no-repeat;"><span>用户名</span><input type="text"  name="user" size=20 style="width:360px; float:left; background-color:transparent;height:53px;border:none; line-height:40px; padding:0px 10px; color:#fff;"/></p>
             <div class="blank10"></div>
       		 <div class="blank10"></div>
            <p style=" background:url(<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
agies/img/mima.png) no-repeat;">
            	<span>密&nbsp;&nbsp;&nbsp;&nbsp;码</span>
            	<input type="password"  name="passwd"size=20 style="width:360px; height:53px; border:none; background-color:transparent; color:#fff;line-height:40px; padding:0px 10px;"/>
             </p>-->
            <p align="left"><a href="?c=public&a=findPasswdFrom" style="margin-left:-10px;">忘记密码？</a>
            	<?php if ($_smarty_tpl->getVariable('errormsg')->value){?>
				<span id="login_error"  style="width:200px; height:23px;color:red"><?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
</span>
				<?php }?>
			</p>
        <ul style="margin:0px;">
            <li class="floatL"><input  type="submit"  onclick="btnUpdate_Click()" style="width:240px;height:50px;line-height:50px;background:#ff6760;color:#fff;border:none;font-size: 14px;" value="登陆" /></li>
            <li class="floatR"><input type="button" onclick="window.location.href='?c=public&a=registerForm'"  style="width:240px; height:50px; line-height:50px; background:#e5e5e5; color:#ff6760; border:none; font-size: 14px;" value="注册" /></li>
        </ul>
    </div>
       </form></center>
</div>

<!--<div class="dl_bottom clearB">-->
<center>
<p style="color: #333; font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; font-size: 16px; line-height: 40px;">© 2016 Aegins Technologies, Inc. All rights reserved.</p>
</center>
</body>
</html>