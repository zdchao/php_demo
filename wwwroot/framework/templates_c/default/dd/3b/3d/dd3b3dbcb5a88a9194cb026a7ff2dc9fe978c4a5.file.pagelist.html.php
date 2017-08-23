<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 17:43:36
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/adminlog/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:212036215655f150c8cd17e0-02466246%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd3b3dbcb5a88a9194cb026a7ff2dc9fe978c4a5' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/adminlog/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212036215655f150c8cd17e0-02466246',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type='text/javascript'>
	$(document).ready(function() {
		
	});
</script>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：管理日志 --> 列表</div>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="7" class="bg_main"><b>列表</b></td>
				</tr>
				<tr id="bg_yellow">
					<td>时间</td>
					<td>来源</td>
					<td>级别</td>
					<td>内容</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr class='view_edit_tr' id='<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
'>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['operate_time'];?>
</td>
					<td class="wid_general"><?php echo $_smarty_tpl->tpl_vars['row']->value['source'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['log_level']==0){?>正常<?php }else{ ?>错误<?php }?></td>
					
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['mem'];?>
</td>
				</tr>
				<?php }} ?>
				<tr>
					<td colspan="15" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=0&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>首页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value-1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>上一页</a>
						<?php }else{ ?> 首页 上一页 <?php }?> <?php if ($_smarty_tpl->getVariable('page')->value!=$_smarty_tpl->getVariable('total_page')->value){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value+1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>下一页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>尾页</a>
						<?php }else{ ?>下一页 尾页 <?php }?> <?php echo $_smarty_tpl->getVariable('page')->value;?>
/<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&nbsp;
						共计<?php echo $_smarty_tpl->getVariable('count')->value;?>
记录&nbsp;
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>
