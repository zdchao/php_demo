<?php /* Smarty version Smarty-3.0.5, created on 2016-01-24 18:00:52
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/notice.html" */ ?>
<?php /*%%SmartyHeaderCode:61768052056a4a0d4c71922-73581011%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d3517a10f517c7e2d50ae96def2f42b2dc1f36f' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/notice.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '61768052056a4a0d4c71922-73581011',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<?php $_template = new Smarty_Internal_Template('user/noticetemplate.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<link href="/style/user/css/notice.css" rel="stylesheet">

<script type='text/javascript'
	src="/style/bootstrap/bootstrap-tooltip.js"></script>
<script type='text/javascript'
	src="/style/bootstrap/bootstrap-popover.js"></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
user/notice.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>

<div class="wrap">
	<div class="contain">
		<div style="width:93.3333333333%;margin:0 auto;padding:0 0 50px 0;">
			<div id="show_error" style="width:30px;">&nbsp;</div>
			<div id="list-header-div"></div>
			<div id="list-header"></div>
			<div id="list-div"></div>
			<div id="list-launch"></div>
		</div>
	</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
