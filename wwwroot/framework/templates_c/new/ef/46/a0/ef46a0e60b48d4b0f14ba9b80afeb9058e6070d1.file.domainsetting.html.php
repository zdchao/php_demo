<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 09:21:52
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/domainsetting.html" */ ?>
<?php /*%%SmartyHeaderCode:158740110155f621301856d4-02860157%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef46a0e60b48d4b0f14ba9b80afeb9058e6070d1' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/domainsetting.html',
      1 => 1440639251,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '158740110155f621301856d4-02860157',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<link href="/style/user/css/domainsetting.css" rel="stylesheet">
<?php $_template = new Smarty_Internal_Template('record/domainsettingtemplate.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type='text/javascript'>
var wx_flag = '<?php echo $_smarty_tpl->getVariable('weixin_flag')->value;?>
';
</script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
record/setting.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<div class="erp_nr clearB">
			<?php $_template = new Smarty_Internal_Template('record/right-operat.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
			<div id="nr_right">
				<div id="operat-content">				<style>					.tbl tr{height:50px}					.tbl tr h5{line-height:50px}				</style>
					<table class="table tbl" width="100%">
						<tbody  id="setting_tbody"></tbody>
					</table>
			</div>			
		</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
