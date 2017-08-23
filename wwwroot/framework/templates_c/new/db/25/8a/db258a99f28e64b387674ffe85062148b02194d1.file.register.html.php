<?php /* Smarty version Smarty-3.0.5, created on 2016-01-24 18:01:14
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/index/register.html" */ ?>
<?php /*%%SmartyHeaderCode:23184412256a4a0ea3eafd7-48358513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db258a99f28e64b387674ffe85062148b02194d1' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/index/register.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23184412256a4a0ea3eafd7-48358513',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo smarty_function_dispatch(array('c'=>"public",'a'=>"getTitle"),$_smarty_tpl);?>
</title>
<meta name="Keywords" content="<?php echo $_smarty_tpl->getVariable('seo')->value['keywords'];?>
">
<meta name="Description" content="<?php echo $_smarty_tpl->getVariable('seo')->value['description'];?>
">
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/css/head.css" rel="stylesheet">
<link href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/css/register.css" rel="stylesheet">
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/js/jquery-2.1.3.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/bootstrap/js/bootstrap.min.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/javascript' src="/style/js/mustache/0.4.0/mustache.js"></script>
</head>
<body>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="col-lg-3 col-lg-offset-4">
		<?php if ($_smarty_tpl->getVariable('successmsg')->value){?>
			<div><?php echo $_smarty_tpl->getVariable('successmsg')->value;?>
</div>
		<?php }else{ ?>
			<?php echo $_smarty_tpl->getVariable('errormsg')->value;?>

		<?php }?>
		
		</div>
		<div class="col-lg-3 col-lg-offset-4">
			<form action="?c=public&a=register" method="POST" class="form-horizontal" role="form" id="my_form">
				<div class="form-group">
					<label>邮箱:</label>
					<input type="text" name="email" placeholder="Email" class="form-control"/>
				</div>
				<div class="form-group">
					<label>密码</label>
					<input type="password" name="passwd" placeholder="password" class="form-control"/>
				</div>
				<div class="form-group">
					<label>姓名</label>
					<input type="text" name="name" class="form-control"/>
				</div>
				<div class="form-group">
					<input type="checkbox" name="agreement"  checked value=1/>
					&nbsp; <spanstyle="padding-buttom: 0px;"><a href="/user/?c=public&a=pact" target="_blank">我已阅读并同意此协议</a></span>
				</div>
				<div class="form-group">
					<button class="btn btn-success col-lg-offset-10" onclick="userRegister()">注册</button>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
function userRegister(){
	$("#my_form").submit();
}

</script>