<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:28
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/index/index.html" */ ?>
<?php /*%%SmartyHeaderCode:148504380856786bb46c5623-93393626%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b25e3836aa0d74a19521d1b9c77361b3f7fb941' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/index/index.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148504380856786bb46c5623-93393626',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('public/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<div class="wrap">
<div class="contain">
	<!-- 标题语开始 -->
	<div style="padding:100px 0 200px 0;">
		<div class="title1">域名注册服务</div>
		<div class="title2">DNS盾&bull;CDN加速</div>
		<div class="title2">强势打造  值得信赖</div>
		
		<!-- 标题语结束 -->
		<!-- 搜索框开始 -->
		<div>
			<div class="domain_search">
				<input type="text" name="domain" class="" placeholder="输入搜索域名"/>
				<input type="button" value="搜索" onclick="submit()"/>
			</div>
			<div class="domain_money_btn"><a href="?c=public&a=showSuffixMoney" target="_Blank">价格列表</a></div>
		</div>
		<!-- 搜索框结束 -->
	</div>
</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/javascript">
$(document).ready(function(){
	$("#nav_domain_register").addClass('cur');
});
function submit(){
	var domain = $("[name=domain]").val();
	window.location.href = "?c=public&a=domainRegister&domain="+domain;
}
document.onkeydown = function(event_e){
    if(window.event)
     event_e = window.event;
     var int_keycode = event_e.charCode||event_e.keyCode;
     if(int_keycode ==13){
    	 submit();
    }
}
</script>