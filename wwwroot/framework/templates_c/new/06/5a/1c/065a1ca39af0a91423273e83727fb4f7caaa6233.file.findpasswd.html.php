<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 00:47:27
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/findpasswd.html" */ ?>
<?php /*%%SmartyHeaderCode:96442533855f0629fb6fb41-95441924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '065a1ca39af0a91423273e83727fb4f7caaa6233' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/public/findpasswd.html',
      1 => 1439287651,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96442533855f0629fb6fb41-95441924',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?>﻿<?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<script type='text/javascript' >
var html;
function find_passwd()
{
	var email = $("#inputEmail").val();
	if (!email) {
		return alert('邮箱不能为空');
	}
	html = $("#find_passwd_td").html();
	
	$.ajax({url:'?c=public&a=findPasswd',data:'email='+email,dataType:'json',success:function(ret) {
		var content;
		if (ret['code'] != 200) {
			content = ret['msg']+'<a href="javascript:reset_html()">我要重来</a>';
		}else {
			content = ret['msg'];
		}
		$("#find_passwd_td").html(content);
	}});
}
function reset_html()
{
	$("#find_passwd_td").html(html);
}
$("#form-search").find("#search-query").remove();
</script>
<div class="wrap">
<div class="contain" style="padding:10px 15px;">
	<div>
		<fieldset>
			<legend>找回密码</legend>
		</fieldset>
	</div>
	<div class="row">
		<div class="span6">

			<?php if ($_smarty_tpl->getVariable('successmsg')->value){?>
			<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('successmsg')->value;?>
</div>
			<?php }else{ ?> <?php if ($_smarty_tpl->getVariable('errormsg')->value){?>
			<div class="alert alert-error"><?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
</div>
			<?php }?>
			<form action="?c=public&a=findPasswd" method="post"
				class="form-horizontal">


				<div class="control-group">
					<label class="control-label" for="inputEmail">账号:</label>
					<div class="controls">
						<input type="text" name="email" placeholder="Email" style="height:30px;"  required>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn btns btn-success">找回</button>
					</div>
				</div>
			</form>
			<?php }?>
		</div>
		<div class="span6"><?php $_template = new Smarty_Internal_Template('public/right.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?></div>
	</div>
</div>
</div>

<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
		
