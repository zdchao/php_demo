<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 09:57:39
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/operat.html" */ ?>
<?php /*%%SmartyHeaderCode:161646629255f62993baec04-31725459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9b106468c2d588378e33613b09c5aec2e99e2a5' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/operat.html',
      1 => 1438911674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161646629255f62993baec04-31725459',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<link href="/style/user/css/operat.css" rel="stylesheet">
<script type='text/javascript'  src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
record/operat.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/template' id="operat-row-template">
<tr id="operat-row">
	<td style="width:160px;">{{op_time}}</td><td style="width:100px;">{{op_ip}}</td><td>{{msg}}</td>
</tr>
</script>

<script type='text/template' id="operat-nologin-template">
<tr>
	<td colspan=3><a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a></td>
</tr>
</script>
<script type="text/template" id="operat-packup-template">
	<tr id="packuptr">
		<td id="td1"  colspan="3">
			<a id="packup" href="javascript:;">收起</a>
			<a id="more" href="javascript:;">显示更多>></a>
		</td>
	</tr>
</script>
<script type="text/template" id="operat-launch-template">
	<tr>
		<td colspan="3">
			<a id="launch" href="javascript:;">展开</a>
		</td>
	</tr>
</script>
<div class="erp_nr clearB">
			<?php $_template = new Smarty_Internal_Template('record/right-operat.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
			<div id="nr_right">
				<div id="operat-content">
					<table class="table" width="100%">
						<thead>
							<tr>
								<td style="width:25%;">操作时间</td>
								<td style="width:25%;">操作IP</td>
								<td style="width:auto;">操作内容</td>
							</tr>
						</thead>
						<tbody id="list-content"></tbody>
						<tbody id="list-launch"></tbody>
					</table>
			</div>			
		</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
