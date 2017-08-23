<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 20:26:15
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/monitor/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:186527706555f6bce76c9532-43607415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ce674c81b7781d2709b51f1e99fc65a7cf7c768' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/monitor/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186527706555f6bce76c9532-43607415',
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
			<div class="block_top" align="left">当前位置：监控记录</div>
			<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>
				<div style='padding-top: 10px;'>
					<span> 搜索: <input name='search' value='<?php echo $_smarty_tpl->getVariable('search')->value;?>
' size=32>
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
				</div>
			</form>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="9" class="bg_main"><b>用户列表</b></td>
				</tr>
				<tr id="bg_yellow">
					<td>域名</td>
					<td>会员</td>
					<td>记录ID</td>
					
					<td>频率</td>
					<td>最后状态</td>
					<td>处理</td>
					<td>激活</td>
					<td>server</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['user'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['record_id'];?>
</td>
					
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['interval_time'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['last_status']!=1){?>正常<?php }else{ ?><b class='red'>异常</b><?php }?></td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['action']!=1){?>切换<?php }else{ ?>暂停<?php }?></td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['active']!=0){?>监控中<?php }else{ ?><b class='red'>暂停监控</b><?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</td>
				</tr>
				<?php }} ?>
				<tr>
					<td colspan="9" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=0&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>首页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value-1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>上一页</a>
						<?php }else{ ?> 首页 上一页 <?php }?> <?php if ($_smarty_tpl->getVariable('page')->value!=$_smarty_tpl->getVariable('total_page')->value){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value+1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>下一页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
'>尾页</a>
						<?php }else{ ?>下一页 尾页 <?php }?> <?php echo $_smarty_tpl->getVariable('page')->value;?>
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