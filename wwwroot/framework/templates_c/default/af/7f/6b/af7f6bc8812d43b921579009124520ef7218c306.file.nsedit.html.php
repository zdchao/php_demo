<?php /* Smarty version Smarty-3.0.5, created on 2015-12-18 13:42:33
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/ns/nsedit.html" */ ?>
<?php /*%%SmartyHeaderCode:29717544556739cc9702222-55479020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'af7f6bc8812d43b921579009124520ef7218c306' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/ns/nsedit.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29717544556739cc9702222-55479020',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<form action='?c=ns&a=nsedit&id=<?php echo $_smarty_tpl->getVariable('id')->value;?>
&type=<?php echo $_REQUEST['type'];?>
'
	method='POST'>
	<table>
		<tr>
			<td>名字</td>
			<td><input name='name' value='<?php echo $_smarty_tpl->getVariable('row')->value['name'];?>
'></td>
		</tr>
		<tr>
			<td>IP</td>
			<td><input name='ip' value='<?php echo $_smarty_tpl->getVariable('row')->value['ip'];?>
' size=72>*多个用,或|分割</td>
		</tr>
		<tr>
		<td colspan=2>
		<input type='submit' value='修改'>
		</td>
		</tr>
	</table>
</form>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
