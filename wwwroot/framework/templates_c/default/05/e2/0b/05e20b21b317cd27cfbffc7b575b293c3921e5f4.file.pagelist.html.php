<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 18:39:42
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/server/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:162298902155f6a3ee96be01-87405695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05e20b21b317cd27cfbffc7b575b293c3921e5f4' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/server/pagelist.html',
      1 => 1440576524,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '162298902155f6a3ee96be01-87405695',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>

<script type="text/template" id="piao-remark-template">

<div id="piao-remark-div">

	<div>备注:<textarea rows=10 cols=50 id="piao_remark">{{remark}}</textarea></div>

	<div><input type="button" id="enter" value="备注"></div>

</div>

</script>

<script type="text/template" id="piao-edit-passwd-template">

<div id="edit-passwd-div">

	新密码:<input id="piao_edit_passwd"><input type="button" id="enter" class="btn" value="修改">

</div>

</script>

<script type="text/template" id="piao-del-server-template">

<div id="del-server-div">

	确定要删除{{name}}吗?

	<input type=button value="确定" id="enter" class="btn green">

	<input type=button value="取消" id="enterDia" class="btn">

</div>

</script>

<script type="text/template" id="piao-add-server-template">

<div id="add-server-div">

	<div class="piao_div">名称:<input id="add_server_name" ></div>

	<div class="piao_div">skey:<input id="add_server_skey"></div>

	<div class="piao_div"><input type="button" id="enter" value="增加">

</div>

</script>

<script type='text/template' id="edit-allowpid-template">

<div id="edit-allowpid-div">

	<div class="">

		<span class="piao_left">server名称:</span>

		<span class="piao_right">{{name}}</span>

	</div>

	<div class="piao_div">

		{{{pid_radio_html}}}

	</div>

	<div class="piao_div">

		<span class="pull-right">

			<button class="btn" id='esc'>取消</button>

			<button class="btn" id='enter'>确定</button>

		</span>

	</div>

</div>

</script>

<script type='text/javascript'>

	$(document).ready(function() {

	});

var dia;

</script>

<script type='text/javascript' src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
scripts/server.js'></script>

	<div align="center">

		<div class="wid_main mar_main" align="left">

			<div class="block_top" align="left">当前位置：server列表<span class="red" id="show_msg"></span></div>

			<table class="table_main2" cellpadding="0" cellspacing="1">

				<tr>

					<td colspan="7" class="bg_main">

					<?php if ($_smarty_tpl->getVariable('operataccess')->value){?>

					<a href="javascript:piao_add_server();" target='main'><b>[增加server]</b></a>

					<?php }?>

					<span id="show_msg"></span>

					</td>

				</tr>

				<tr id="bg_yellow">

					<td>操作</td>

					<td>名称</td>

					<td>产品ID</td>

					<td>允许产品</td>

					<td>管理邮箱</td>

					<td>备注</td>

				</tr>

				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>

				<tr class='view_edit_tr' id='<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
'>

					<td>

						<?php if ($_smarty_tpl->getVariable('operataccess')->value){?>

						[<a href="javascript:piao_edit_passwd('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">修改密码</a>]

						[<a href="javascript:piao_del_server('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">删除</a>]

						<?php }?>

					</td>

					<td width="200px">

						<!--<a href="?c=server&a=login&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" target=_blank><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a>-->

						<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>


						<div style="float:right; margin-right:20px;">

							[<a href="javascript:switch_server('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">切换登陆</a>]
                        
                        </div>

					</td>

					<td id="edit_pid<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">

						<a href="?c=product&a=pagelist&pid=<?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
" title="点击查看套餐内容"><?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
</a>

						&nbsp;

						<span class="pull-right">

						[<a href="javascript:piao_edit_pid('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
',<?php echo $_smarty_tpl->tpl_vars['row']->value['pid'];?>
)">修改</a>]

						</span>

					</td>

					<td ><?php echo $_smarty_tpl->tpl_vars['row']->value['allow_buy_pid'];?>
<span class="pull-right">[<a href="javascript:piao_edit_allowpid('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['allow_buy_pid'];?>
')">设置</a>]</span></td>

					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</td>

					<td><span>[<a href="javascript:piao_remark('<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
')">备注</a>]</span>&nbsp;<span title="<?php echo $_smarty_tpl->tpl_vars['row']->value['remark'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['row']->value['remark'],48);?>
</span></td>

				</tr>

				<?php }} ?>

				<tr>

					<td colspan="7" id="bg_yellow" align="right">共计 <?php echo $_smarty_tpl->getVariable('count')->value;?>
 条记录&nbsp;</td>

				</tr>

			</table>

		</div>

	</div>

</body>

</html>

