<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 17:43:39
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/admins/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:163623341755f150cbd02386-65940816%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '099a8c3cba67673d7f6bd783ff2f29aa3ca13b53' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/admins/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163623341755f150cbd02386-65940816',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/template" id="pagelist-change-passwd-template">
<form  action="?c=admins&a=changePassword&admin={{adminname}}" method="post">
<!--	原来密码:<input name="oldpasswd"><br><br>-->
	新的密码:<input name="passwd" type="password"><br><br>
	确认密码:<input name="passwd2" type="password"><br><br>
	<input type="submit" value="提交">
</form>
</script>
<script type="text/template" id="pagelist-del-admin-template">
	<a href="?c=admins&a=del&name={{adminname}}"><font color=red>点击删除</font></a>
</script>

<script type="text/template" id="pagelist-add-admin-template">
<div id="add-div">
	管理账号:<input name="name"><br><br>
	管理密码:<input name="passwd" type="text"><br><br>
	确定密码:<input name="passwd2" type="text"><br><br>
	管理权限:<input name="super" type="radio" value="super2">super2
				<input name="super" type="radio" value="super3">super3(不选表示超级账号)<br><br>

	<input name="action_list"  type="hidden" value="del_admin0,server_config0,product_config0,money_config0,user_config0,analysis_config0,drag_config0,line_config0,ns_config0">
	<button id="enter">提交</button>
</div>
</script>
<script type='text/javascript'>
function del_admin(adminname)
{
		var html = $("#pagelist-del-admin-template").html();
		var option = [];
		option.adminname = adminname;
		var el = Mustache.to_html(html,option);
		art.dialog({id:'222',content:el,title:'确定删除管理员'+ adminname+'吗？'});
}
function add_admin()
{
	var html = $("#pagelist-add-admin-template").html();
	art.dialog({id:'222',content:html,title:'增加管理员'});
	var div = $("#add-div");
	div.find("#enter").unbind();
	div.find("#enter").bind('click',function(){
		add(div);
	});
}
function add(div){
	var name = div.find('input[name=name]').val();
	var passwd = div.find('input[name=passwd]').val();
	var passwd2 = div.find('input[name=passwd2]').val();
	var passwd = div.find('input[name=passwd]').val();
	if(passwd !=passwd2){
		alert("两次输入密码不一致");
		return;
	}
	var panel =div.find("input[name=super]:checked").val();
	$.ajax({
		url : "?c=admins&a=add",
		type:'POST',
		data :{name:name,passwd:passwd,panel:panel},
		dataType :"json",
		success :function(a){
			if(a.status.code!=1){
				alert(a.status.message ? a.status.message : "操作失败");
				return;
			}
			window.location.reload();
		},
		error:function(e){
			alert("error");
		}
	});
}
function change_passwd(adminname) 
{
	var template = $("#pagelist-change-passwd-template").html();
	var option = [];
	option.adminname = adminname;
	var el = Mustache.to_html(template,option);
	art.dialog({id:'222',content:el,title:'修改管理员'+ adminname+ '密码'});
}

$(document).ready(function(){
	var msg = '<?php echo $_smarty_tpl->getVariable('msg')->value;?>
';
	if (msg != '') {
		art.dialog({id:'222',content:msg,title:'提示',time:2});
	}
})
</script>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div align="center">
  	<div class="wid_main mar_main" align="left">
		<div class="block_top" align="left">当前位置：帐号管理 --> 管理员</div>
		<table class="table_main2" cellpadding="0" cellspacing="1">
			<tr>
				<td colspan="5" class="bg_main"><a href="javascript:add_admin()" target='main'><b>[增加管理员]</b></a></td>
			</tr>
			<tr id="bg_yellow">
				<td>操作</td><td>用户名</td><td>上次登陆时间</td><td>上次登陆IP</td><td>登陆权限</td>
			</tr>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
			<tr>
				<td>
				[<a href="javascript:change_passwd('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')" >修改密码</a>]
				[<a href="javascript:del_admin('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')" >删除管理员</a>]
				</td>
				
				<td class="wid_general"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
				<td class="wid_general"><?php echo $_smarty_tpl->tpl_vars['row']->value['last_login'];?>
</td>
				<td class="wid_general"><?php echo $_smarty_tpl->tpl_vars['row']->value['last_ip'];?>
</td>
				<td class="wid_general"><?php if ($_smarty_tpl->tpl_vars['row']->value['panel']){?><a href="?c=admins&a=importlogin&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" target=_blank><?php echo $_smarty_tpl->tpl_vars['row']->value['panel'];?>
</a><?php }?></td>
			</tr>
			<?php }} ?>
			<tr>
				<td colspan="5" id="bg_yellow" align="right">共计 <?php echo $_smarty_tpl->getVariable('count')->value;?>
 条记录&nbsp;</td>
			</tr>
		</table>
  	</div>
</div>
</body>
</html>
