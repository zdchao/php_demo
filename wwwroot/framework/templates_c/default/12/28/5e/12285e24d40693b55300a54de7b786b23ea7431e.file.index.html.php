<?php /* Smarty version Smarty-3.0.5, created on 2015-11-04 12:32:07
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domainreserved/index.html" */ ?>
<?php /*%%SmartyHeaderCode:99142612156398a474ed6e1-93401739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12285e24d40693b55300a54de7b786b23ea7431e' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domainreserved/index.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99142612156398a474ed6e1-93401739',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：预留域名</div>
			<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>
				<div style='padding-top: 10px;'>
					<span> 域名搜索: <input name='name' size=32>
						<input type='submit' value='搜索'>

					</span> <span> 选择显示:<select name='page_count'
						onchange='set_pagecount(this.value)'> <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 10;
  if ($_smarty_tpl->getVariable('i')->value<=60){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=60; $_smarty_tpl->tpl_vars['i']->value++){
?> <?php if ($_smarty_tpl->tpl_vars['i']->value%5==0){?>
							<option value='<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' <?php if ($_smarty_tpl->getVariable('page_count')->value==$_smarty_tpl->tpl_vars['i']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option>
							<?php }?> <?php }} ?>
					</select> 行
					</span>
					<span><input id="addDomainAdmin" type="button" onclick="addReservedDomain()" value="添加预留域名"/></span>
				</div>
			</form>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="16" class="bg_main">预留域名</td>
				</tr>
				<tr>
					<td>操作</td>
					<td>域名</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr id="tr<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
					<td><a href="javascript:delReservedDomain(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">[删除]</a></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
</td>
				</tr>
				<?php }} ?>
			</table>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
function addReservedDomain(){
	var html = "域名:<input type='text' name='domain'/>";
	html += "<input type='button' id='enter' value='确定'>";
	var dia = art.dialog({
		id:'addreserved',
		title:'增加预留域名',
		content:html,
		lock:true
	});
	$("#enter").bind('click',function(){
		var domain = $("[name=domain]").val();
		dia.close();
		addReservedDomainEnter(domain);
	});
}
function addReservedDomainEnter(domain){
	$.ajax({
		url:'?c=domainreserved&a=addReservedDomain',
		data:{domain:domain},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.ret);
				return;
			}
			window.location.href = "?c=domainreserved&a=pagelist";
		},
		error:function(a){
			alert("error");
		}
	});
}
function delReservedDomain(id){
	var html = "<div><span style='font-size:20px;'>您确定要删除此域名</span></div><br/>";
	html += "<div><button type='button' class='btn btn-success' id='enter'>确定</button><button type='button' class='btn btn-default' id='esc'>取消</button></div>";
	var dia = art.dialog({
		id:'delreserved',
		title:'删除预留域名',
		content:html,
		lock:true
	});
	$("#enter").bind('click',function(){
		delReservedDomainAjax(id);
	});
	$("#esc").bind('click',function(){
		dia.close();
	});
}
function delReservedDomainAjax(id){
	$.ajax({
		url:'?c=domainreserved&a=delReservedDomain',
		data:{id:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert("删除预留域名失败");
				return;
			}
			window.location.href = "?c=domainreserved&a=pagelist";
		},
		error:function(a){
			alert("error");
		}
	});
}
</script>