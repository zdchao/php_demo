<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 18:59:43
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/user/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:74623175455f0111f3396e3-14936675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1213c1f6a7be3047e3cfce9fe9c476f11272dfd3' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/user/pagelist.html',
      1 => 1440579915,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74623175455f0111f3396e3-14936675',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>

<script type="text/template" id="piao-edit-user-ns-template">

<div id="div-edit-user-ns-template">

	<div>ns1:{{{ns1}}}<br/></div>

	<div>ns2:{{{ns2}}}<br/></div>

	<div><br/><button id="esc">取消</button><button id='enter'>确定</button></div>

</div>

</script>

<script type="text/template" id="piao-set-adminremark-template">

<div id="set-adminremark-div">

	<div class="piao_div">&nbsp; 备 注 :<textarea id="piao_admin_remark" rows=2 cols=44></textarea></div>

	<div class="piao_div"><span class="pull-right"><input id="enter" type="button" value="设置" class="btn"></span></div>

</div>

</script>

<script type="text/template" id="piao-custom-ns-template">

<div id="custom-ns-div">

	<p>ns1 i d :<input id="ns1id" placeholder="数字">*id可在ns列表里查看</p>

	<p>ns2 i d :<input id="ns2id" placeholder="数字">*id可在ns列表里查看</p>

	<p>ns1name :<input id="ns1name" size=24 placeholder="域名">*优先级大于ID,指定后不可更改，如无必要,不要指定,指定ID即可</p>

	<p>ns2name :<input id="ns2name" size=24 placeholder="域名">*优先级大于ID,指定后不可更改，如无必要,不要指定,指定ID即可</p>

	<p>soaemail:<input id="soaemail" size=24 placeholder="如:admin@dnsdun.com"></p>

	<p><input type="button" id="enter" value="设置" class="btn">

</div>

</script>

<script type="text/template" id="piao-edit-server-template">

<div id="edit-server-div">

<!--<p><img src="/style/dot.gif">请确认新的server已存在</p>-->

<p>server:

<!--<input name="newserver" id="newserver">--> {{{select_html}}}

<!--<input type="button" id="enter" value="修改" class="btn">-->

</p>

</div>

</script>

<script type='text/javascript'>

var dia;

var allowcustomns = '1';

</script>

<script type='text/template' id="edit-divided-template">

	<div class="piao_div" id="edit-divided">

		<div class="piao_div">当前设置账号:<big>{{email}}</big></div>

		<div class="piao_div">当前账号分成:<big>{{divided}}</big></div>

		<div class="piao_div">新分成百分比:<input type="text" name="divided" style="width:50px;"><big>%</big>&nbsp;&nbsp;<button class="btn" id="enter">设置</button><button class="btn" id="esc">取消</button></div>

	</div>

</script>

<script type='text/template' id="multi-domain-template">

<div id="multi-domain-div">

	<div class="piao_div"><big>当前操作账号:{{email}}</big></div>

	<div class="piao_div">

		<span ><button class="btn-red" id="lock">锁定所有域名(软锁)</button><button class="btn" id="unlock">解锁所有域名(软锁)</button></span>

	</div>

	<div class="piao_div">

		<span ><button class="btn-red" id="disable">禁用所有域名(硬锁)</button><button class="btn" id="undisable">恢复所有域名(硬锁)</button></span>

	</div>

</div>

</script>

<script type='text/template' id="add-user-template">

	<div class="piao_div" id="add-user">

       <div class="piao_div"><span class="piao_left">邮箱:</span><input type="text" name="email"></div>

		<div class="piao_div"><span class="piao_left">密码:</span><input type="text" name="passwd"></div>

        <div class="piao_div"><span class="piao_left">姓名:</span><input type="text" name="name"></div>

		<div class="piao_div"><span class="pull-right"><button class="btn" id="enter">确定</button></span></div>

	</div>

</script>

<script type='text/template' id="editpass-user-template">

	<div class="piao_div" id="editpass-user">

		<div class="piao_div">密码:<input type="text" name="passwd"></div>

		<div class="piao_div"><button class="btn" id="enter">确定</button></div>

	</div>

</script>

<script type='text/javascript' src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
scripts/user.js?v=11'></script>

	<div align="center">

		<div class="wid_main mar_main" align="left">

			<div class="block_top" align="left">当前位置：用户管理 --> 用户列表</div>

			<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>

				<div style='padding-top: 10px;'>

					<span> 用户名搜索: <input name='email' placeholder="uid或用户名" size=32>

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

					<td colspan="16" class="bg_main">

						<b>用户列表</b>

					<?php if ($_smarty_tpl->getVariable('user_function')->value==1){?>		<button onClick="piaoAdd()">增加</button><?php }?>

					</td>

				</tr>

				<tr id="bg_yellow">

					<td>uid</td>

					<td>用户名</td>

					<td>姓名</td>

					<td>注册时间</td>

					<td>登陆时间</td>

					<td>状态</td>

					<td>server</td>

					<td>备注</td>

					<td>ns1</td>

					<td>ns2</td>

					<td>ns3</td>

					<td>ns4</td>

				</tr>

				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>

				<tr id="tr<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" data-email="<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
">

					<td>

					    

						<span class="pull-left1"><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</span>

						<span class="pull-right1">

							[<a href="javascript:;" onClick="piao_multi_domain(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">批量域名</a>]

						<?php if ($_smarty_tpl->getVariable('user_function')->value==1){?>	

							[<a href="javascript:;" onClick="del(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">删除</a>]

							[<a href="javascript:;" onClick="piaoEditPass(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">修改密码</a>]

						<?php }?>

						</span>

					</td>

					<td id="email"><a href="?c=users&a=impLogin&user=<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
" target=_blank title='点击登录'><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</a></td>

					<td title="<?php echo $_smarty_tpl->tpl_vars['row']->value['openid'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php if ($_smarty_tpl->tpl_vars['row']->value['openid']){?>已绑微信<?php }?></td>

					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['createtime'];?>
</td>

					<td>

					<?php echo $_smarty_tpl->tpl_vars['row']->value['last_login_date'];?>
&nbsp;

					<?php if ($_smarty_tpl->tpl_vars['row']->value['error_count']>0){?>[<a href="javascript:clear_login_error(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)" title="清理登陆错误次数">清错</a>]<?php }?>

					</td>

					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==0){?>已激活<?php }else{ ?><a href="javascript:change_status('<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
')"><b class='red'>未激活</b></a>&nbsp;<a href="javascript:sendRegMail('<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
',<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">发送邮件</a><?php }?></td>

					<td id='server<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
' >

						<a href="javascript:piao_edit_server('<?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
',<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
')" title='点击可修改'><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</a> &nbsp;

					</td>

					<td><span >[<a href="javascript:piao_set_adminremark(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">备注</a>]</span>&nbsp;<span id="adminremark_<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['admin_remark'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['row']->value['admin_remark'],16);?>
</span></td>

					<td title="点击可设置" id="ns1id<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><a href="javascript:;" onClick="ns.editUserNs(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
')">[<?php if (is_numeric($_smarty_tpl->tpl_vars['row']->value['ns1_id'])){?><?php echo $_smarty_tpl->tpl_vars['row']->value['ns1_id'];?>
<?php }else{ ?>无<?php }?>]</a></td>

					<td id="ns2id<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['ns2_id'];?>
</td>

					<td id="ns3id<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['ns3_id'];?>
</td>

					<td id="ns4id<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['ns4_id'];?>
</td>

				</tr>

				<?php }} ?>

				<tr>

					<td colspan="16" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a

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