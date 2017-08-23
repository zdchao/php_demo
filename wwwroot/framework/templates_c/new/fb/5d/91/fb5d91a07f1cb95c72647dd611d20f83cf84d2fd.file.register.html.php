<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 19:00:14
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/register.html" */ ?>
<?php /*%%SmartyHeaderCode:134051099455f0113ee21461-14959088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb5d91a07f1cb95c72647dd611d20f83cf84d2fd' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/register.html',
      1 => 1439287320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134051099455f0113ee21461-14959088',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?>﻿<?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<script type='text/javascript'>
$(document).ready(function(){
	var from = $("#register-from");
	$("#form-search").find("#search-query").remove();
});
	
</script>
<div class="wrap">
<div class="contain" style="padding:10px 15px;">
	<div>
		<fieldset>
			<legend>用户注册</legend>
		</fieldset>
	</div>
	<div class="row">
		<div class="span6">

			<?php if ($_smarty_tpl->getVariable('successmsg')->value){?>
			<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('successmsg')->value;?>
</div>
			<?php }else{ ?> <?php if ($_smarty_tpl->getVariable('errormsg')->value){?>
			<div class="alert alert-error"><?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
</div>
			<?php }?>
			<form action="?c=public&a=register" method="post" id="register-from" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputEmail">邮箱:</label>
					<div class="controls">
						<input type="text" name="email" placeholder="Email" style="height:30px;" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">密码:</label>
					<div class="controls">
						<input type="password" name="passwd" style="height:30px;"  placeholder="password" required>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">姓名:</label>
					<div class="controls">
						<input type="text" name="name" style="height:30px;" >
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">注册协议:</label>
					<div class="controls">
						<input type="checkbox" name="agreement"  checked value=1>&nbsp; <span
							style="padding-buttom: 0px;"><a href="?c=public&a=pact"
							target="_blank">我已阅读并同意此协议</a></span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btns btn-success">注册</button>
					</div>
				</div>
			</form>
			<?php }?>
		</div>
		<div class="span6"><?php $_template = new Smarty_Internal_Template('public/right.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?></div>
	</div>
</div>
</div>

<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
