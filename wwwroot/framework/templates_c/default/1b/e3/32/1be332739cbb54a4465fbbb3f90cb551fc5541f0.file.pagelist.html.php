<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 17:43:29
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domaintld/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:60467038655f150c157d134-84970932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1be332739cbb54a4465fbbb3f90cb551fc5541f0' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domaintld/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60467038655f150c157d134-84970932',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<script type='text/javascript' src="/style/js/mustache/0.4.0/mustache.js"></script>
<script type='text/javascript'>

function edit(){
	tld = $("textarea[name=tld]").val()
	$.ajax({
		url:"?c=domaintld&a=edit",
		data:{tld:tld},
		dataType:"json",
		type:"POST",
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return 
			}
			alert("修改成功");
			return 
		},
		error:function(){
			alert("请求异常");
		}
		
	});
}
$(document).ready(function(){
	
});
</script>
<div align="center">
  	<div class="wid_main mar_main" align="left">
		<div class="block_top" align="left">当前位置：tld管理</div>
<textarea style="width:200px;min-height:300px" name='tld'><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['tld'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['tld']->value = $_smarty_tpl->tpl_vars['row']->key;
?><?php echo $_smarty_tpl->tpl_vars['tld']->value;?>

<?php }} ?>
</textarea>
	<br/><input value="确定" onclick="edit()" type="button"/>
  	</div>
</div>
</body>
</html>
