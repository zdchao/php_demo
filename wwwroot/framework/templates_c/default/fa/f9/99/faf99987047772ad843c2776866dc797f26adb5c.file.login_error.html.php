<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 09:31:14
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/session/login_error.html" */ ?>
<?php /*%%SmartyHeaderCode:191075139455f6236295c226-48969021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'faf99987047772ad843c2776866dc797f26adb5c' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/session/login_error.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191075139455f6236295c226-48969021',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body>
<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/login.css" type="text/css" media="all" />
<div id="header"></div>

<div>
	<table height=500 cellSpacing=0 cellPadding=0 width=500 align=center background="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/style/error.gif" border=0>
	  <tr>
		<td height=330>&nbsp;</td>
	  </tr>
	  <tr>
		<td valign="top">
			<div class="font_1" align=center><strong>登陆错误:<b><?php echo $_smarty_tpl->getVariable('msg')->value;?>
</b><a href="javascript:history.go(-1);">[返回]</a></strong>
			</div>
		</td>
	  </tr>
	</table>
</div>
</body>
</html>
											