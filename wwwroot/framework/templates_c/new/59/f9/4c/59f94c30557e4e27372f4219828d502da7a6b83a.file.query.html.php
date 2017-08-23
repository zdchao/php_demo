<?php /* Smarty version Smarty-3.0.5, created on 2015-09-11 13:16:07
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/query.html" */ ?>
<?php /*%%SmartyHeaderCode:70228892055f263972f1bf7-02587047%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59f94c30557e4e27372f4219828d502da7a6b83a' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/query.html',
      1 => 1438911674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70228892055f263972f1bf7-02587047',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<script type='text/javascript' src='/style/js/highcharts/highcharts.js'></script>
<script type='text/javascript' src='/style/js/highcharts/modules/exporting.js'></script>
<script type='text/javascript' src='/style/js/highcharts/themes/grid.js'></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
record/query.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/template' id="query-nologin-template">
	<a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a>
</script>
<div class="erp_nr clearB">
			<?php $_template = new Smarty_Internal_Template('record/right-operat.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
			<div id="nr_right">
					<div id="recordquery_hours" style="margin-top:20px;"></div>
					 <div class="blank10"></div>
					  <div class="blank10"></div>
			      <div id="recordquery_days" ></div>
		</div>		
		</div>
</div>

<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
