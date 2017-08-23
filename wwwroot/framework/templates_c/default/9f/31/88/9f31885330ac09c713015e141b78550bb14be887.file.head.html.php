<?php /* Smarty version Smarty-3.0.5, created on 2016-01-19 12:50:06
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/server/view/default/common/head.html" */ ?>
<?php /*%%SmartyHeaderCode:864026583569dc07eaedfc3-80644201%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f31885330ac09c713015e141b78550bb14be887' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/server/view/default/common/head.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '864026583569dc07eaedfc3-80644201',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>
<title><?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
<!-- 定义语言编码 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 定义链接样式表 -->
<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/style.css" type="text/css"/>
<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('PSTATIC')->value;?>
/style/style2.css" type="text/css"/>
<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('PSTATIC')->value;?>
/style/piao.css" type="text/css"/>
<link rel="stylesheet" rev="stylesheet" href="/style/artdialog/skins/black.css" type="text/css"/>
<script language='javascript' src='/style/common/jq.js'></script>
<script language='javascript' src='/style/public.js'></script>
<script type='text/javascript' src="/style/artdialog/artDialog.js"></script>
<script type='text/javascript' src="/style/common/md5.js"></script>
<script type='text/javascript' src="/style/common/mustache/0.4.0/mustache.js"></script>
<script type='text/javascript'>
function set_pagecount(count) {
	$.ajax({
		url : '?c=setting&a=setPagecount&value=' + count,
		success : function(ret) {
			window.location = window.location;
		}
	});
}
</script>
</head>
