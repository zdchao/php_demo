<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:28
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/public/head.html" */ ?>
<?php /*%%SmartyHeaderCode:136766347856786bb4757dd8-85897845%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a977bc7d6cf73129dd4cf0594e63ab7d70f78be3' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/public/head.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136766347856786bb4757dd8-85897845',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--  <link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">-->
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/css/bootstrap.css" rel="stylesheet">
<!--  <link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/css/head.css" rel="stylesheet">-->
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/css/bootstrap-extending.css" rel="stylesheet">
<link href="/style/common/user/css/common.css" rel="stylesheet">
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/css/register.css" rel="stylesheet">
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/js/jquery-2.1.3.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/js/bootstrap.min.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/javascript' src="/style/common/mustache/0.4.0/mustache.js"></script>
<title>域名注册</title>
</head>
<body>
<div class="nav_top">
	<div class="wrap">
		<nav class="menus_top fl">
			<em onclick="rMenu()"></em>
			<a href="/">首页</a>
			<a href="/user/?c=public&a=index">域名管理</a>
			
			<?php if ($_smarty_tpl->getVariable('container')->value==1){?>
			<a href="/user/?c=public&a=container">容器管理</a>
			<?php }?>
			<a href="/domain/" id="nav_domain_register">域名注册</a>
			<a href="?c=managedomain&a=domainManagement" id="nav_my_domain">我的域名</a>
		</nav>
		<div class="account_box" id="head-link"></div>
	</div>
</div>
<script type="text/javascript">
var headlink = function(){
	this.userlogin = 0;
	this.domainlogin = 0;
	this.useremail = [];
	this.unread = 0;
	this.container = 0;
	this.getInfo = function() {
		var that = this;
		$.ajax({
			url:'/api/?c=public&a=getLoginInfo',
			dataType:"json",
			success:function(a) {
				if (a.status.code != 1) {
					openCloseBg('close');
					return;
				}
				if (a.user) {
					that.useremail = a.user.username;
					that.userlogin = a.user.login;
					that.unread = a.user.unread;
				}
				if (a.domain) {
					that.domainlogin = a.domain.login;
				}
				that.container = a.container;
				that.renderLink(a.is_domain_register);
				//that.getIsDomainRegister();
			},
			error:function(e) {
				
			}
		});
	}
	this.renderLink = function(is_domain_register) {
		var that = this;
		var div = $("#head-link");
		if (this.userlogin != 0) {
			var link = '<a href="/user/?c=public&a=notice" title="还有'+ this.unread + '封信息未读"><img src="/style/img/mail';
			if (this.unread == 0) {
				link += '-white'
			}	
			link += '.png" style="width:25px;height:20px;">';
			link += "<a href='/user/?c=public&a=user'>"+this.useremail+"</a>";
			div.append(link);
		}
		if (this.domainlogin!=0 || this.userlogin != 0) {
			var link = '<a href="/user/?c=session&a=logout">退出</a>';
			div.append(link);
		}
		/*
		var that = this;
		var div = $("#head-link").find("ul");
		if (this.userlogin != 0) {
			var link = '<li class=""><a href="?c=public&a=index">域名管理</a></li>';
			if(is_domain_register == 1){
				link += '<li class="" title="域名注册"><a href="/domain/">域名注册</a></li>';
			}
			if(that.container == 1)
			{
				link += '<li title="产品管理"><a href="?c=public&a=container">'+'容器管理'+'</a></li>';
			}
			link += '<li class="" title="账户管理"><a href="?c=public&a=user">'+this.useremail+'</a></li>';
			link += '<li class="" title="还有'+ this.unread + '封信息未读">';
			link += '<a href="?c=public&a=notice"><img src="/style/img/mail';
			if (this.unread == 0) {
				link += '-white'
			}	
			link += '.png" style="width:25px;height:20px;">';
			link += '<span id="head-unread"></span></a></li>';
			div.append(link);
			if (this.unread > 0) {
				div.find('#head-unread').text(this.unread).addClass('badge badge-important');
			}
		}
		if (this.domainlogin!=0 || this.userlogin != 0) {
			var link = '<li class=""><a href="?c=session&a=logout">退出</a></li>';
			div.append(link);
		}
		if (this.userlogin==0) {
			$("#go_home").attr('href','');
		}
		*/
	}
	this.getIsDomainRegister = function(){
		var that = this;
		$.ajax({
			url:'?c=public&a=getIsDomainRegister',
			dataType:'json',
			success:function(a){
				if(a.status.code == 1){
					that.is_domain_register = a.ret;
					that.container = a.container;
					that.renderLink();
				}
			},
			error:function(a){
				alert("网络出错");
			}
		});
	}
}
$(document).ready(function(){
	var _link = new headlink();
	_link.getInfo();
});
var m_i = 0;
function rMenu(){
	if(m_i == 0){
		$(".menus_top").find("a").css("display","block");
		m_i = m_i+1;
	}else{
		$(".menus_top").find("a").css("display","none");
		m_i = m_i - 1;
	}
	
}
function openCloseBg(oc){
	if(oc == 'open'){
		var template = $("#pop_bg_template").html();
		$("#div-bg").html(template);
		return;
	}
	if(oc == 'close'){
		$("#div-bg").html("");
		return;
	}
}

</script>
<!-- 顶部菜单开始 >=940px
<div class="container-fluid dns_head_main">
	<div class="navbar navbar-inner dns_head_div visible-extend" id="head-link">
		<ul class="dns_head_ul" id="is-login">
			<li><a href="/" title="首页"><span class="iconic home"></span></a></li>
			<li><a href="javascript:dnsdun()">域名管理</a></li>
			<li><a href="?c=managedomain&a=domainManagement">我的域名</a></li>
			<li><a href="/user/?c=public&a=user" id="user_name"></a></li>
			<li><a href="javascript:loginOut()">退出</a></li>
		</ul>
	</div>
</div>
-->
<!-- 顶部菜单结束 
<nav class="navbar navbar-default hidden-940" role="navigation">
	<div class="container-fluid">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="head-login" style="padding-top:6px;">
			<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6">
				<a href="/user/?c=public&a=index"><img alt="图片" src="/public/view/default/images/logo.png" style="width:30px;height:30px;"></a>
				<span style="margin-left:10px;font-size:20px;"><a href="/domain"><strong>域名注册</strong></a></span>
			</div>
		</div>
	</div>
</nav>

<script type="text/javascript">
function Login(){
	this.init = function(){
		this.getLoginStatus();
	}
	this.getLoginStatus = function(){
		var that = this;
		$.ajax({
			url:'?c=public&a=getSession',
			dataType:'json',
			success:function(a){
				if(a.status.code != 1){
					var template = $("#user-login-error-template").html();
					$("#head-login").append(template);
					$("#is-login").html("");
					var template = $("#user-login-error-template2").html();
					$("#is-login").html(template);
					return;
				}
				$("#user_name").html(a.user['name']);
				var template = $("#user-login-success-template").html();
				var option = [];
				option.name = a.user['name'].substr(0,6);
				var el = Mustache.to_html(template,option);
				$("#head-login").append(el);
			},
			error:function(a){
				alert("error");
			}
		});
	}
}
$(document).ready(function(){
	var login = new Login();
	login.init();
});

function loginOut(){
	$.ajax({
		url:'?c=session&a=loginOut',
		dataType:'json',
		success:function(a){
			window.location.href = "/domain/?c=public&a=index";
		},
		error:function(a){
			alert("error");
		}
	});
}
function dnsdun(){
	window.location.href = "/user/?c=public&a=index";
}
function userLogin(){
	window.location.href = "/public/?c=public&a=login";
}
function registerForm(){
	window.location.href = "?c=public&a=registerForm";
}
</script>
<script type="text/template" id="user-login-success-template">
<div class="col-xs-6 col-sm-3 col-md-2">
				<div class="dropdown">
   					<button type="button" class="btn btn-default dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">
      			   		{{name}}
      					<span class="caret"></span>
   					</button>
   					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
   						<li role="presentation">
   							<a role="menuitem" tabindex="-1" href="?c=managedomain&a=domainManagement">我的域名</a>
   						</li>
      					<li role="presentation">
         					<a role="menuitem" tabindex="-1" href="javascript:dnsdun()">域名管理</a>
      					</li>
						<li role="presentation">
							<a role="menuitem" tabindex="-1" href="/user/?c=public&a=user">账户设置</a>
						</li>
      					<li role="presentation">
         					<a role="menuitem" tabindex="-1" href="javascript:loginOut()">退出</a>
      					</li>
   					</ul>
				</div>
			</div>
</script>
<script type="text/template" id="user-login-error-template">
<div class="col-xs-6 col-sm-3 col-md-2">
				<button type="button" class="btn btn-success" onclick="userLogin()">登录</button>
				<button type="button" class="btn btn-success" onclick="registerForm()">注册</button>
			</div>
</script>
<script type="text/template" id="user-login-error-template2">
<li><a href="/" title="首页"><span class="iconic home"></span></a></li>
<li><a href="javascript:userLogin()">登录</a></li>
<li><a href="javascript:registerForm()">注册</a></li>
</script>
-->