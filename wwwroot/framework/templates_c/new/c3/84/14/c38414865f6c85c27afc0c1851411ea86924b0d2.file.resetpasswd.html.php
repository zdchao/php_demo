<?php /* Smarty version Smarty-3.0.5, created on 2015-10-28 15:10:25
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/resetpasswd.html" */ ?>
<?php /*%%SmartyHeaderCode:447125411563074e1248eb6-97478192%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c38414865f6c85c27afc0c1851411ea86924b0d2' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/resetpasswd.html',
      1 => 1438911674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '447125411563074e1248eb6-97478192',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<div class="container">
	<div class="row">
		<fieldset>
			<legend>重设密码</legend>
		</fieldset>
	</div>
	<div class="row">
		<div class="span6">
			<?php if ($_smarty_tpl->getVariable('errormsg')->value){?>
				<div class="alert alert-error"><?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
</div>
			<?php }elseif($_smarty_tpl->getVariable('successmsg')->value){?> 
				<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('successmsg')->value;?>
</div>
			<?php }else{ ?>
				<form action="?c=public&a=resetPasswd" method="post"	class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="inputEmail">新密码:</label>
						<div class="controls">
							<input type="text" name="passwd" placeholder="Email" style="height:30px;"  required>
							<input type="hidden"  value="<?php echo $_smarty_tpl->getVariable('info')->value;?>
"	name="info" >
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-primary">重置密码</button>
						</div>
					</div>
				</form>
			<?php }?>
		</div>
		<div class="span6"><?php $_template = new Smarty_Internal_Template('public/right.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?></div>
	</div>
	<fieldset>
		<legend>
			<!-- 一条线和foot分开 -->
		</legend>
	</fieldset>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
