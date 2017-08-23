<?php /* Smarty version Smarty-3.0.5, created on 2016-04-19 15:53:52
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/head.html" */ ?>
<?php /*%%SmartyHeaderCode:19865584665715e41046f257-60215927%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78853c24f365c5524d84f833239dccfb06d6e7fd' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/head.html',
      1 => 1461052427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19865584665715e41046f257-60215927',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><!doctype html>
<html class="no-js"  lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<title><?php echo smarty_function_dispatch(array('c'=>"public",'a'=>"getTitle"),$_smarty_tpl);?>
</title>-->
<title>Aegins</title>
<!--[if lt IE 8]>
<script>
window.location = '?c=public&a=toIe6';
</script>
<![endif]-->
<link href="/style/common/bootstrap2/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">
<link href="/style/common/bootstrap2/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/style/common/user/css/common.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/css/public.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/css/index.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/css/piliangtianjia.css"/>
<script type='text/javascript' src="/style/common/jq.js"></script>
<script type="text/javascript" src="/style/common/html5shiv.js"></script>
<script type='text/javascript' src="/style/common/mustache/0.4.0/mustache.js"></script>
<script type="text/javascript" src="/style/common/bootstrap2/bootstrap.min.js"></script>
<script type='text/javascript' src="/style/common/ajaxfileupload.js"></script>
<script type='text/javascript' src="/style/common/user/js/response.ui.js"></script>
<!-- 
<script type='text/javascript' src="/style/js/zhdc-responsive.js"></script>
<script type='text/javascript' src="/style/js/z-r.js"></script>
 -->
<script type='text/javascript'>
if (typeof String.prototype.trim=='undefined') {
	String.prototype.trim = function() {
		return $.trim(this);
	}
}
if (typeof String.prototype.toInt == 'undefined') {
	String.prototype.toInt = function() {
		return parseInt(this);
	}
}
function compareMark(a,b) {
	if (a.is_mark=='yes') {
		return 1;
	}
	if (b.is_mark =='yes') {
		return -1;
	}
	return 0;
}
function compareDomain(a,b){
	if (a.name < b.name) {
		return 1;
	}
	if (a.name > b.name) {
		return -1;
	}
	return 0;
}
function compareDomainPname(a,b) {
	if (a.pname < b.pname) {
		return -1;
	}
	if (a.pname > b.pname) {
		return 1;
	}
	return 0;
}
function compareInt(a,b) {
	if (a < b) {
		return -1;
	}
	if (a > b) {
		return 1;
	}
	return 0;
}
function compareId(a,b) {
	if (a.id < b.id) {
		return -1;
	}
	if (a.id > b.id) {
		return 1;
	}		
	return 0;
}
function compareType(a,b)
{
	if (a.type < b.type) {
		return -1;
	}
	if (a.type > b.type) {
		return 1;
	}
	return 0;
}
function compareName(a,b) 
{
	if (a.name < b.name) {
		return -1;
	}
	if (a.name > b.name) {
		return 1;
	}
	return 0;
	
}
function compareLine(a,b)
{
	if (a.line < b.line) {
		return -1;
	}
	if (a.line > b.line) {
		return 1;
	}
	return 0;
}
function compareValue(a,b)
{
	if (a.value < b.value) {
		return -1;
	}
	if (a.value > b.value) {
		return 1;
	}
	return 0;
}
function compareTtl(a,b)
{
	if (a.ttl < b.ttl) {
		return -1;
	}
	if (a.ttl > b.ttl) {
		return 1;
	}
	return 0;
}

</script>
</head>
<body style="overflow-x:hidden;">
<div class="erp_xian1"></div>
<!-----top---
<div class="erp_top">-->
	<div class="erp_top_nr">
		<p><a href="#"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/logo.png" /></a></p>
		<!-----导航------>
		<div class="erp_daohang">
			<ul>
				<!--<li><a href="http://www.cloud.ph"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/shouye_hei.png" /><span>首页</span></a></li>-->
                                <?php if ($_smarty_tpl->getVariable('user')->value){?>
				<li id="nav_domain"><a href="?c=public&a=index"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/yuming_hei.png" /><span>域名管理</span></a></li>
                                <?php }?>
			</ul>
		</div>
		
		<!-----个人中心------>
		<div class="grzx">
			<!-----个人设置------>
			<div class="grsz" id="head-link"></div>
			<p style="margin-top:10px;margin-left:5px;" id="login_out"></p>
		</div>
		<!-----搜索------>
		<div class="sousuo">
			<p><span id="form-search"><input id="search-query" type="text" placeholder="域名搜索" class="paynum" style="width:300px; height:33px;background:url(<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/sousuo.png) no-repeat 280px 10px;border-radius:10px; border:1px solid #e6e6e6; padding-left:10px;"></span></p>
		</div>
	</div>
<!--
</div>
-->
<!-- 
<div class="nav_top">
    <div class="wrap">
        <nav class="menus_top fl">
        	<em onclick="rMenu()"></em>
            <a href="/">首页</a>
            <a href="?c=public&a=index" id="nav_domain">域名管理</a>
            <a id="nav_container" href="?c=public&a=container">容器管理</a>
            <a id="is_domain_register" href="/domain/">域名注册</a>
        </nav>
        <div class="account_box" id="head-link"></div>
    </div>
</div>
 -->
<script type="text/template" id="pop_bg_template">
<div class="pop_bg">
	<div class="loading"></div>
</div>
</script>
<script type='text/javascript'  src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
public/head.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
