<?php /* Smarty version Smarty-3.0.5, created on 2016-02-23 17:44:56
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/attack/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:3285653656cc2a183b5336-80360800%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6ce23abda51b77c16d50241793373b0d2f2089c' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/attack/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3285653656cc2a183b5336-80360800',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor="#ffffff" text="#000000" leftmargin='0' topmargin='0'>
<script type='text/javascript' >
function del_attack(id)
{
	if (confirm('确定要给该记录解除迁引状态')) {
		$.ajax({
			url:'?c=attack&a=delMovecited&id='+id,
			dataType:'json',
			success:function(a) {
				if (a.status.code != 1) {
					alert(a.status.message);
					return;
				}
				var tr = $("#tr"+id);
				tr.find('#status').html('已解封');
				tr.css('background-color','');
			},
			error:function(e) {
				alert(e.responseText);
			}
		});
	}
}
/*
 * ************************* 域名搜索 ********************
 */
function domainQuery(){
	var domain = $("#domainName").val();
	window.location = '?c=attack&a=pagelist&domain='+domain;
}

</script>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：阻断列表</div>
			
			<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>
				<div style='padding-top: 10px;'>
					<span> 域名搜索: <input id="domainName" name='domain' size=32>
						<input type='button' onclick="domainQuery();" value='搜索'>
					</span>  
					<span> 选择显示:<select name='page_count'
						onchange='set_pagecount(this.value)'> <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 10;
  if ($_smarty_tpl->getVariable('i')->value<=60){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=60; $_smarty_tpl->tpl_vars['i']->value++){
?> <?php if ($_smarty_tpl->tpl_vars['i']->value%5==0){?>
							<option value='<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' <?php if ($_smarty_tpl->getVariable('page_count')->value==$_smarty_tpl->tpl_vars['i']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option>
							<?php }?> <?php }} ?>
					</select> 行
					</span>
					<span>
						<input type="button" onclick="window.location='?c=attack&a=getStatus&status=0'" value="未解封域名"/>
					</span>
				</div>
			</form>

			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="15" class="bg_main"><b><?php echo $_smarty_tpl->getVariable('name')->value;?>
阻断列表</b></td>
				</tr>
				<tr id="bg_yellow">
					<td>操作</td>
					<td>域名</td>
					<td>server</td>
					<td>创建时间</td>
					<td>解封时间</td>
					<td>解除剩余/状态</td>
					<td>备注</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr id="tr<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['status']==0){?>style="background-color:#FFB6C1"<?php }?>>
					<td>&nbsp;</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['createtime'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['unlocktime'];?>
</td>
					<td id="status">
					<?php if ($_smarty_tpl->tpl_vars['row']->value['status']!=1){?>
					<?php echo $_smarty_tpl->tpl_vars['row']->value['time_val'];?>
分钟后解封/[<a href="javascript:del_attack(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">解除迁引</a>]
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['status']==1&&$_smarty_tpl->tpl_vars['row']->value['time_val']>0){?>已解封<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['time_val']==0){?>永久<?php }?>
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['remark'];?>
</td>

				</tr>
				<?php }} ?>
				<tr>
					<td colspan="15" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=0&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>首页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value-1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>上一页</a>
						<?php }else{ ?>首页 上一页<?php }?> <?php if ($_smarty_tpl->getVariable('page')->value!=$_smarty_tpl->getVariable('total_page')->value){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value+1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>下一页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>尾页</a>
						<?php }else{ ?>下一页 尾页<?php }?> <?php echo $_smarty_tpl->getVariable('page')->value;?>
/<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&nbsp;
						共计<?php echo $_smarty_tpl->getVariable('count')->value;?>
记录&nbsp;
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>































