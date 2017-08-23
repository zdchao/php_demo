<?php /* Smarty version Smarty-3.0.5, created on 2015-10-28 15:19:38
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/database/index.html" */ ?>
<?php /*%%SmartyHeaderCode:9981931725630770a553119-54147718%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0b83ce15db1a0a67601b2be8ff43ffd42b8eb87f' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/database/index.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9981931725630770a553119-54147718',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：数据库检测</div>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="16" class="bg_main"><b>dao文件数:<?php echo $_smarty_tpl->getVariable('count')->value;?>
</b></td>
				</tr>
				<tr>
					<td>序列</td>
					<td>数据表</td>
					<td>状态</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['key'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['mysql_err']==''){?><b style='color:green'>正常</b><?php }else{ ?><b style="color:red"><?php echo $_smarty_tpl->tpl_vars['row']->value['mysql_err'];?>
</b><?php }?></td>
				</tr>
				<?php }} ?>
			</table>
		</div>
	</div>
</body>
</html>