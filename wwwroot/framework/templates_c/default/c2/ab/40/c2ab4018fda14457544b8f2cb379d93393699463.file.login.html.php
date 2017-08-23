<?php /* Smarty version Smarty-3.0.5, created on 2016-01-19 12:50:06
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/server/view/default/session/login.html" */ ?>
<?php /*%%SmartyHeaderCode:1001435593569dc07ea41e30-27773737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2ab4018fda14457544b8f2cb379d93393699463' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/server/view/default/session/login.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1001435593569dc07ea41e30-27773737',
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

	<div id="login">
		<div id="logo">合作商控制面板</div>

		<div id="warning"></div>
		<div id="login_top"></div>
		<div id="login_main">
			<form action="index.php?c=session&a=login" method=post name="form1" onSubmit='return ValidateForm()'>
				<div class="input_title">用户名</div>
				<div class="input_box" style="margin-bottom: 10px;">
					<input type="text" name="name" />
				</div>
				<div class="input_title">密码</div>
				<div class="input_box">
					<input type="password" name="passwd" />
				</div>
				<div class="login_button">
					<input type="submit" value="登 录" />
				</div>
				<?php if ($_smarty_tpl->getVariable('msg')->value){?>
				<div class="red blink"><?php echo $_smarty_tpl->getVariable('msg')->value;?>
</div>
				<?php }?>

			</form>
		</div>
		<div id="login_bottom"></div>
	</div>
</body>

<SCRIPT>
	function ValidateForm() {
		if (document.form1.LoginName.value == "" || document.form1.LoginPass.value == "" || document.form1.CheckCode.value == "") {
			alert("please enter ur name and passwd and checkcode!");
			return false;
		} else {
			return true;
		}
	}
</SCRIPT>

</html>
