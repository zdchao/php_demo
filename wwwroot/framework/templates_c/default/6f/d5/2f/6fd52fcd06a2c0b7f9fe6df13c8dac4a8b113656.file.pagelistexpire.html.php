<?php /* Smarty version Smarty-3.0.5, created on 2015-09-15 01:14:18
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domains/pagelistexpire.html" */ ?>
<?php /*%%SmartyHeaderCode:188255698155f7006a342df7-03320150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6fd52fcd06a2c0b7f9fe6df13c8dac4a8b113656' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domains/pagelistexpire.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188255698155f7006a342df7-03320150',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<script type='text/javascript'>
var default_rrl = '<?php echo $_smarty_tpl->getVariable('default_rrl')->value;?>
';
var dia;
var plist;
$(document).ready(function() {
	$.ajax({
		url:'?c=product&a=getList',
		dataType:'json',
		success:function(a){
			var rows = a.rows;
			plist = a.rows;
			$(".show_pid_name").each(function(){
				var id = $.trim($(this).text());
				if (!id || id==0) {
					$(this).html('免费版');
				}else {
					$(this).html('<b class="green">'+rows[parseInt(id)]['name'] +'</b>');
				}
			});
		},
		error:function(e){
			alert('后台数据出错'+e.responseText);
		}
	});
});
function send_expire_mail(domain)
{
	$.ajax({
		url:'?c=domains&a=sendExpireMail',
		data:{domain:domain},
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.message);
				return 
			}
			$("#row_send_mail"+MD5_hexhash(domain)).html('发送通知成功');
		},
		error:function(e){
			
		}
	});
	
}
</script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
scripts/domains.js?v=1"></script>

	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：域名列表</div>
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
				</div>
			</form>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="15" class="bg_main"><b>域名列表</b></td>
				</tr>
				<tr id="bg_yellow">
					<td>域名</td>
					<td>UID</td>
					<td>用户</td>
					<td>套餐(月)</td>
					<td>价格</td>
					<td>备注</td>
					<td>server</td>
					<td>创建时间</td>
					<td>过期</td>
					<td>线路组</td>
					<td>状态</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr>
					<td title="<?php echo $_smarty_tpl->tpl_vars['row']->value['soa'];?>
">
						<a href="?c=domains&a=loginDomain&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" target=_blank><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a>
					</td>
					<td title='点击可过户'>
						<a href='javascript:;edit_uid("<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
","<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
")'><?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
</a>
					</td>
					<td>
						<a href="?c=users&a=impLogin&user=<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
" target=_blank title='点击登录'><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</a>
						[<span id="row_send_mail<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
"><a href="javascript:;send_expire_mail('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">发送邮件</a></span>]
					</td>
					<td >
						<?php if ($_smarty_tpl->tpl_vars['row']->value['pid']){?>
						<span >[<a href="javascript:;piao_shift_pid('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
',<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
)">转移</a>]</span>
						<?php }?>
						[<a href="javascript:;piao_set_pid('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
',<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
)"><span class="show_pid_name" id="pid_<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
" data-pid="<?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
</span></a>]
					</td>
					<td >
						<span id="pid_price_<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['pid_price'];?>
</span>
					</td>
					<td >
						<span>[<a href="javascript:;piao_set_adminremark('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">备注</a>]</span>
						<span id="row_admin_remark<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['admin_remark'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['row']->value['admin_remark'],16);?>
</span>
					</td>
					<td title="点击可修改" id="server_<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
">
						<a href="javascript:;piao_edit_server('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
')"><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</a>
					</td>
					<td ><?php echo $_smarty_tpl->tpl_vars['row']->value['created_on'];?>
</td>
					<td >
						<?php if ($_smarty_tpl->tpl_vars['row']->value['pid_expire_time']<$_smarty_tpl->getVariable('thistime')->value){?>
						<a href="javascript:;piao_set_pidexpiretime('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">
						<span style="color:red; " id="pidexpiretime_<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['pid_expire_time'];?>
" ><?php echo substr($_smarty_tpl->tpl_vars['row']->value['pid_expire_time'],0,10);?>
</span> 
						<?php }else{ ?>
						<span id="pidexpiretime_<?php echo md5($_smarty_tpl->tpl_vars['row']->value['name']);?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['pid_expire_time'];?>
"><?php echo substr($_smarty_tpl->tpl_vars['row']->value['pid_expire_time'],0,10);?>
</span> 
						<?php }?>
						</a>
						</td>
					<td title="点击可修改">
						<a href='javascript:;piao_edit_groupview("<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
","<?php echo $_smarty_tpl->tpl_vars['row']->value['group_view'];?>
","<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
")'><?php echo $_smarty_tpl->tpl_vars['row']->value['group_view'];?>
</a>
					</td>
					<td title="co:1 ci:2 ru:4 ns已修改:8 st:16 diyview:32 notdel:64 ns防劫持128">
						<form action='?c=domains&a=setFlags&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
' method='POST'>
							<input name='flags' size=5 value="<?php echo $_smarty_tpl->tpl_vars['row']->value['flags'];?>
">
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&1)==1){?>co<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&2)==2){?>ci<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&4)==4){?>ru<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&8)==8){?>ns<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&16)==16){?>st<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&32)==32){?>dv<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&64)==64){?>nd<?php }?>
						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&128)==128){?>tc<?php }?>
						</form>
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