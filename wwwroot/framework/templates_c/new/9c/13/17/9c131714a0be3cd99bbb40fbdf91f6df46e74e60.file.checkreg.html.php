<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 20:22:28
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/checkreg.html" */ ?>
<?php /*%%SmartyHeaderCode:53413422355f6bc043f0a65-45725637%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c131714a0be3cd99bbb40fbdf91f6df46e74e60' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/checkreg.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '53413422355f6bc043f0a65-45725637',
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
			<legend>注册确认</legend>
		</fieldset>
	</div>
	<div class="row">
		<div class="span6">

			<?php if ($_smarty_tpl->getVariable('successmsg')->value){?>
			<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('successmsg')->value;?>
</div>
			<?php }else{ ?> 
				<?php if ($_smarty_tpl->getVariable('errormsg')->value){?>
				<div class="alert alert-error"><?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
</div>
				<?php }?>
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