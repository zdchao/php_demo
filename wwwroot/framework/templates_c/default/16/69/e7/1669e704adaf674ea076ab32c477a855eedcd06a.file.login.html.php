<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 18:59:10
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/session/login.html" */ ?>
<?php /*%%SmartyHeaderCode:51032868555f010fececfb5-03635371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1669e704adaf674ea076ab32c477a855eedcd06a' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/session/login.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51032868555f010fececfb5-03635371',
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
		<div id="logo">管理员控制面板</div>

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
				<?php if ($_smarty_tpl->getVariable('gd_exist')->value){?>
			<div class="input_title">验证码</div>
			<div class="input_box">
				<input type="text" name="code"  size="6" style="width:120px;float:left;margin:0px 4px"/>
				<img id="code" src="?c=session&a=create_code" alt="看不清楚，换一张" style="cursor: pointer; vertical-align:middle;float:left;margin:0px 4px" onClick="create_code()"/>
			</div>
			<?php }?>
			<script type='text/javascript' >
				function create_code(){
					 document.getElementById("code").src="?c=session&a=create_code&"+Math.random();
				}
			</script>
				<div class="login_button">
					<input type="submit" value="登 录" style="margin-top:5px" />
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
