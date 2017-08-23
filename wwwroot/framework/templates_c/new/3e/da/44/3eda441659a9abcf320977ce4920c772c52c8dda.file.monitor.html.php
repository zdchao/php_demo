<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 09:57:30
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/monitor.html" */ ?>
<?php /*%%SmartyHeaderCode:120231048355f6298acd1701-29682004%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3eda441659a9abcf320977ce4920c772c52c8dda' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/monitor.html',
      1 => 1438911674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120231048355f6298acd1701-29682004',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<script type='text/javascript'>
var record_id = '<?php echo $_smarty_tpl->getVariable('record_id')->value;?>
';
</script>
<link href="/style/user/css/monitor.css" rel="stylesheet">
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
record/monitor.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/template' id="monitor-row-template">
<tr>
	<td class="record-ip">{{src}}</td>
	<td class="record-status">{{status}}</td>
	<td class="record-message">{{status_msg}}</td>
	<td class="record-time">{{log_time}}</td>
	<td class="record-auto">{{total_time}}</td>
</tr>
</script>
<script type='text/template' id="monitor-show-mutli-template">
<tr id="show-multi-operat"  style="margin-top:8px;">
<td colspan="5">
	<span class="record-time"><h5></h5></span>
	<span class="record-title">
		<h5>
			<a href="javascript:;" id="packup">收起</a>
			<a href="javascript:;" id="show-multi">查看更多>></a>
		</h5>
	</span>
 </td>
</tr>
</script>
<script type="text/template" id="monitor-launch-template">
<tr id="launch1" style="margin-top:8px;">
<td colspan="5">
	<span class="record-time"><h5></h5></span>
	<span class="record-title">
		<h5>
			<a href="javascript:;" id="launch">展开</a>
		</h5>
	</span>
</td>
</tr>
</script>
<script type='text/template' id="monitor-nologin-template">
<tr class="clearfix record">
	<a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a>
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
								<td style="width:15%;">主机</td>
								<td style="width:15%;">状态</td>
								<td style="width:25%;">处理</td>
								<td style="width:15%;">处理时间</td>
								<td style="width:auto;">持续时间</td>
							</tr>
						</thead>
						<tbody  id="monitor-list"></tbody>
						<tbody id="list-launch"></tbody>
					</table>
			</div>			
		</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
