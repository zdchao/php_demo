<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 17:37:31
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/top.html" */ ?>
<?php /*%%SmartyHeaderCode:65706272955effddbb12097-06953650%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0bb222346fbb5ba349bd0325cbf58f379a829cd4' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/top.html',
      1 => 1440481660,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65706272955effddbb12097-06953650',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- html标识扩展，定义名字空间 -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>
<title>登陆页面</title>
<!-- 定义语言编码 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="utf-8" />
<!-- 定义链接样式表 -->
<link rel="stylesheet" rev="stylesheet"	href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/style/style.css" type="text/css" media="all" />
<link rel="stylesheet" rev="stylesheet"	href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/style/header.css" type="text/css" media="all" />
<base target="content" />
</head>
<body>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
	      <td bgcolor="#ffffff" valign="top" align="left" style="padding:0 0 0 0;">
	      	<table border="0" cellspacing="0" cellpadding="0">
				<tr>
			 	 <td align="left" valign="top"><img src="/style/img/logo.jpg" border="0" /></td>
				</tr>
		 	 </table>
    	   </td>           
			<td bgcolor="#ffffff" align="center">
				<table width="100%" height="100%" border="0" cellpadding="0"
					cellspacing="0">
					<tr>
						<td style="text-align:center;"><font face="Segoe UI" size="3px" color="#353535">
						<b>
							欢迎您,<?php echo $_smarty_tpl->getVariable('login_admin')->value;?>
</b></font></td>
						<td>
							<a href="?c=session&amp;a=logout" target="_top"><img src="/user/view/new/agies/img/login_out.png"></a>
						</td>

					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>