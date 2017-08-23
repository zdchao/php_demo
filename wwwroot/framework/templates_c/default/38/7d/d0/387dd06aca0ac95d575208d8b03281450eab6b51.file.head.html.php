<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 17:37:31
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/common/head.html" */ ?>
<?php /*%%SmartyHeaderCode:29314276155effddbe1b2b8-26872624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '387dd06aca0ac95d575208d8b03281450eab6b51' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/common/head.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29314276155effddbe1b2b8-26872624',
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
<link rel="stylesheet" rev="stylesheet" href="/style/piao.css" type="text/css"/>
<link rel="stylesheet" rev="stylesheet" href="/style/artdialog/skins/black.css" type="text/css"/>
<script language='javascript' src='/style/common/jq.js'></script>
<script language='javascript' src='/style/public.js'></script>
<script type='text/javascript' src="/style/artdialog/artDialog.js"></script>
<script type='text/javascript' src="/style/artdialog/artDialog.notice.js"></script>
<script type='text/javascript' src="/style/common/md5.js"></script>
<script type='text/javascript' src="/style/common/mustache/0.4.0/mustache.js"></script>
<!--  
<script type='text/javascript' src="/style/js/underscore/1.3.3/underscore.js"></script>
-->
<script type='text/javascript'>
function set_pagecount(count) {
	$.ajax({
		url : '?c=setting&a=setPagecount&value=' + count,
		success : function(ret) {
			window.location = window.location;
		}
	});
}
$(document).ready(function(){
	var msg = '<?php echo $_smarty_tpl->getVariable('msg')->value;?>
';
	if (msg != '') {
		art.dialog({content:msg,lock:true});
	}
});
</script>
</head>
<body></body>
