<?php /* Smarty version Smarty-3.0.5, created on 2015-10-16 17:41:53
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domains/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:3753002035620c661450d53-06236055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cc56f75cf3ed550f36890512f72750caf29ab65' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domains/pagelist.html',
      1 => 1444988503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3753002035620c661450d53-06236055',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<link href="/style/date_time/jcDate.css" rel="stylesheet">

<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>

<?php $_template = new Smarty_Internal_Template('domains/temp.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<script type='text/javascript'>

var default_rrl = '<?php echo $_smarty_tpl->getVariable('default_rrl')->value;?>
';

var dia;

var plist;

var blocknslist = [];

var wherename = '<?php echo $_smarty_tpl->getVariable('name')->value;?>
';

$(document).ready(function() {

	var msg = '<?php echo $_smarty_tpl->getVariable('msg')->value;?>
';

	var success = '<?php echo $_smarty_tpl->getVariable('success')->value;?>
';

	if (msg != '') {

		if (success != '') {

			art.dialog({id : '222',content : msg,title : '提示',time : 2,icon : 'succeed'});

		} else {

			art.dialog({id : '222',content : msg,title : '提示',time : 2,icon : 'error'});

		}

	}

	$.ajax({

		url:'?c=product&a=getList',

		dataType:'json',

		success:function(a){

			var rows = a.rows;

			plist = a.rows;

			$(".show_pid_name").each(function(){

				var id = $.trim($(this).text());

				if (!id || id==0) {

					$(this).html('未购买');

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



</script>

<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
scripts/domains.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>

<script type="text/javascript" src="/style/date_time/jQuery-jcDate.js"></script>

	<div align="center">

		<div class="wid_main mar_main" align="left">

			<div class="block_top" align="left">当前位置：域名列表</div>

			<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>

				<div style='padding-top: 10px;'>

					<span> 域名搜索: <input name='name' size=22><input type='submit' value='搜索'></span> 

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

					<span class="pull-right"><input id="addDomainAdmin" type="button" class="btn" onClick="AdminAddDomain()" value="添加域名"/></span>

				</div>

			</form>

			<table class="table_main2" cellpadding="0" cellspacing="1">

				<tr>

					<td colspan="15" class="bg_main"><b>域名列表<?php echo $_smarty_tpl->getVariable('name')->value;?>
</b></td>

				</tr>

				<tr id="bg_yellow">

					<td>操作</td>

					<td>域名</td>

					<td style="width:100px;">UID</td>

					<td>套餐</td>

					<td>价格</td>

					<td>备注</td>

					<td>rrl</td>

					<td>CDN</td>

					<td>server</td>

					<td>创建</td>

					<td>过期</td>

					<td>线路</td>

					<td>状态</td>

				</tr>

				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>

				<tr id="tr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"  

				data-name='<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
' 

				data-server='<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
' 

				data-uid="<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
" 

				data-pid="<?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
" 

				data-rrl="<?php echo $_smarty_tpl->tpl_vars['row']->value['rrl'];?>
"

				data-groupview='<?php echo $_smarty_tpl->tpl_vars['row']->value['group_view'];?>
'

				data-pidprice='<?php echo $_smarty_tpl->tpl_vars['row']->value['pid_price'];?>
'

				data-pidexpiretime='<?php echo $_smarty_tpl->tpl_vars['row']->value['pid_expire_time'];?>
'

				<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&8448)>0){?>

				style="background-color:#FFB6C1"

				<?php }else{ ?>

					<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&64)>0||($_smarty_tpl->tpl_vars['row']->value['flags']&256)>0){?>

						style=" background-color:gray"

					<?php }?>

				<?php }?>				

				>

					<td id="operat">						

						<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&64)>0){?>

						[<a href='?c=domains&a=adminStatus&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
&server=<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
&status=0' onClick="return confirm('确定要启用么？');">启用</a>]

						<?php }else{ ?>

						[<a href='?c=domains&a=adminStatus&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
&server=<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
&status=1' onClick="return confirm('确定要禁用么？');">禁用</a>]

						<?php }?>

						<?php if ($_smarty_tpl->getVariable('allow_del')->value){?>

						[<a href='javascript:;' onClick="piao_del_domain(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)">删除</a>]

						<?php }?>

					</td>

					<td title="<?php echo $_smarty_tpl->tpl_vars['row']->value['soa'];?>
">

						<a href="?c=domains&a=loginDomain&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" target=_blank><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a>

					</td>

					<td  id="uid">

						<span title="只看该用户域名">[<a href="<?php echo $_smarty_tpl->getVariable('action')->value;?>
&uid=<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
</a>]</span>

						<span title="查看域名用户信息">[<a href='?c=users&a=pagelist&uid=<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
'>信息</a>]</span>

						<span title='点击可过户'>[<a href='javascript:edit_uid(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)'>过户</a>]</span>

					</td>

					<td id="pid">

						<?php if ($_smarty_tpl->tpl_vars['row']->value['pid']){?>

						<span >[<a href="javascript:piao_shift_pid(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)">转移</a>]</span>

						<?php }?>

						[<a href="javascript:piao_set_pid(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)"><span class="show_pid_name" id="pid_span" data-pid="<?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
</span></a>]

					</td>

					

					<td ><span id="pid_price"><?php echo $_smarty_tpl->tpl_vars['row']->value['pid_price'];?>
</span></td>

					

					<td id="admin_remark">

						<span>[<a href="javascript:piao_set_adminremark(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)">备注</a>]</span>

						<span id="admin_remark_span" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['admin_remark'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['row']->value['admin_remark'],8);?>
</span>

					</td>

					

					<td id="rrl" data-rrl='<?php echo $_smarty_tpl->tpl_vars['row']->value['rrl'];?>
' title='点击可修改'>

						<a href='javascript:piao_edit_rrl(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)'><?php if ($_smarty_tpl->tpl_vars['row']->value['rrl']){?><?php echo $_smarty_tpl->tpl_vars['row']->value['rrl'];?>
<?php }else{ ?>无<?php }?></a>

					</td>

					

					<td id="cdn_status">

						<?php if ($_smarty_tpl->tpl_vars['row']->value['cdn_id']==0){?>

							<?php if ($_smarty_tpl->tpl_vars['row']->value['cdn_status']!=2){?>

								<a href="javascript:cdnStatus(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)">[解除]</a>

							<?php }?>

						<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['row']->value['cdn_id']>0){?>

							<?php echo $_smarty_tpl->tpl_vars['row']->value['cdn_product'];?>


							<?php if (($_smarty_tpl->tpl_vars['row']->value['flags']&32768)==32768){?>

								<a href='javascript:domainBackSource(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,"-32768");'>[回源]</a>

							<?php }else{ ?>

								<a href='javascript:domainBackSource(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,"+32768")'>[启用]</a>

							<?php }?>

						<?php }?>

					</td>

					<td title="点击可修改" id="server">

						<a href="javascript:piao_edit_server(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)"><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</a>

					</td>

					<td class="created-on" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['created_on'];?>
"><?php echo substr($_smarty_tpl->tpl_vars['row']->value['created_on'],0,13);?>
</td>

					<td id="pidexpiretime">

						<a href="javascript:piao_set_pidexpiretime(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)">

						<span id="pidexpiretime_span" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['pid_expire_time'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['pid_expire_time']){?><?php echo substr($_smarty_tpl->tpl_vars['row']->value['pid_expire_time'],0,10);?>
<?php }else{ ?>无<?php }?></span>

						</a>

						</td>

					<td title="点击可修改">

						<a href='javascript:piao_edit_groupview(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)'><?php echo $_smarty_tpl->tpl_vars['row']->value['group_view'];?>
</a>

					</td>

					<td title="<?php echo $_smarty_tpl->tpl_vars['row']->value['flags'];?>
">

						<form action='?c=domains&a=setFlags&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
&name=<?php echo $_smarty_tpl->getVariable('name')->value;?>
' method='POST'>

							<input name='flags' size=5 value="<?php echo $_smarty_tpl->tpl_vars['row']->value['flags'];?>
">					

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