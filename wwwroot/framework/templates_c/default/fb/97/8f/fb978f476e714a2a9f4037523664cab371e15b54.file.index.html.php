<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 17:43:32
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/mail/index.html" */ ?>
<?php /*%%SmartyHeaderCode:214280429055f150c4d87aa9-59275235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb978f476e714a2a9f4037523664cab371e15b54' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/mail/index.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214280429055f150c4d87aa9-59275235',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
	<script type='text/javascript'>
		
	</script>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：邮件推送</div>
			<form action="?c=mail&a=send" method='post' name='setfrom'>
				<table class="table_main2" cellpadding="0" cellspacing="1">

					<tr>
						<td colspan="2" class="bg_main hg_main"><b>邮件设置</b></td>
					</tr>
					<!--  
					<tr>
						<td class="pull-right">发送方式:</td>
						<td><input type='radio' name="send_model" value="back" checked>后台发送
							<input type='radio' name="send_model" value="online">在线发送
						</td>
					</tr>
					-->
					<tr>
						<td class="pull-right">发送对象:</td>
						<td><textarea name="send_address" rows="10" cols="60" placeholder="接收邮件的邮箱,多个逗号,分割"></textarea></td>
					</tr>
					<tr>
						<td class="pull-right">发送标题:</td>
						<td><input type='text' name="send_title" size="48"></td>
					</tr>
					<tr>
						<td class="pull-right">发送内容:</td>
						<td><textarea name="send_body" rows="10" cols="60"></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td><input type='submit' value='确定'></td>
					</tr>
				</table>
			</form>
		</div>
	</div>