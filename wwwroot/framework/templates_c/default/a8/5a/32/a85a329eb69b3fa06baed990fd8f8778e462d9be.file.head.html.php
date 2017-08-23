<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:51
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/head.html" */ ?>
<?php /*%%SmartyHeaderCode:99722285656786bcbf27234-69272878%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a85a329eb69b3fa06baed990fd8f8778e462d9be' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/head.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99722285656786bcbf27234-69272878',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $_smarty_tpl->getVariable('seo')->value['title'];?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Keywords" content="<?php echo $_smarty_tpl->getVariable('seo')->value['keywords'];?>
">
<meta name="Description" content="<?php echo $_smarty_tpl->getVariable('seo')->value['description'];?>
">
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
css/css.css" rel="stylesheet" type="text/css">
</head>
<body id="nav_btn01">
<div class="header"><dl class="header">
<dd>
<?php if ($_smarty_tpl->getVariable('user')->value){?><span><a href="/user/?c=public&a=index">域名管理</a><a title="账户管理" href="/user/?c=public&a=user"><?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
</a>

<a href="/user/?c=session&a=logout">退出</a></span>
<?php }else{ ?>
<span><a href="?c=public&a=login" class="<?php echo $_smarty_tpl->getVariable('login_active')->value;?>
">登陆</a></span>
<a href="?c=public&a=reg" class="<?php echo $_smarty_tpl->getVariable('reg_active')->value;?>
">注册</a>
<?php }?>
</dd>
</dl></div>
<!--end头文件-->
<div class="header_c">
<div class="header_c_w">
<div class="logo"><a href="/"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/logo.png" alt="dns"></a></div>
<!--end标志-->
		<div class="nav th">
			<ul class="nav last_list">
				<li id="nav_hover01" class="<?php echo $_smarty_tpl->getVariable('index_active')->value;?>
"><a href="/" id="nav1">首页</a></li>
				<li id="nav_hover02" class="<?php echo $_smarty_tpl->getVariable('product_active')->value;?>
"><a href="?c=public&a=products" id="nav2">产品介绍</a></li>
				<li id="nav_hover03" class="<?php echo $_smarty_tpl->getVariable('priceper_active')->value;?>
"><a href="?c=public&a=buy" id="nav3">购买套餐</a></li>
				<!--<li id="nav_hover04" class="<?php echo $_smarty_tpl->getVariable('server_active')->value;?>
"><a href="?c=public&a=server" id="nav4">企业服务</a></li>-->
				<!--<li id="nav_hover05" class="<?php echo $_smarty_tpl->getVariable('help_active')->value;?>
"><a href="?c=help&a=help" id="nav5">帮助页面</a></li>-->
				<!--<li id="nav_hover06" class="<?php echo $_smarty_tpl->getVariable('content_active')->value;?>
"><a href="?c=public&a=content" id="nav6">联系我们</a></li>-->
			</ul>
		</div>
<!--end导航-->
</div>
<!--end头文件宽度-->
</div>
<!--end头文件中-->
<script language='javascript'>
if (document.location.protocol=="http:" && 
		(document.location.hostname=='dnsdun.com' || document.location.hostname=='www.dnsdun.com')) {
	//http redirect to https
	//var new_url = "https://" + document.location.hostname + document.location.pathname + document.location.search;
	//document.location = new_url;
}
var li_length = document.getElementsByTagName("li").length;
if(li_length > 6){
	for(var i=1;i <= li_length;i++){
		document.getElementById("nav"+i).style.padding="0 18px";
	}
}
</script>