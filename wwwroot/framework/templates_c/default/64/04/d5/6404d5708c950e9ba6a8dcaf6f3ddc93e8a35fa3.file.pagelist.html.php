<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 09:19:44
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/product/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:109326792155f0dab01f31b1-12014350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6404d5708c950e9ba6a8dcaf6f3ddc93e8a35fa3' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/product/pagelist.html',
      1 => 1439178280,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109326792155f0dab01f31b1-12014350',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<script type='text/template' id="add-product-template">
<div id="add-product-div">
	<div class="piao_div"><img src="/style/dot.gif">必需定义一个免费产品(价格为0),注册的用户默认使用免费产品</div>
	<div class="piao_div"><span class='piao_left'>产品ID:</span><span id="product_add_id_span" ><a href="javascript:;show_product_id()">定制产品</a></span></div>
	<div class="piao_div"><span class="piao_left">产品名称:</span><span ><input name="name" >*</span></div>
	<div class="piao_div"><span class="piao_left">产品价格:</span><span ><input name="price" >元/月*</span></div>
	<div class="piao_div"><span class="piao_left">产品 rrl:</span><span ><input name="rrl" ></span></div>
	<div class="piao_div"><span class="piao_left">产品flag:</span><span ><input name="flags" >可以输入格式:1+16384</span></div>
	<div class="piao_div"><span class="piao_left">线 路 组:</span><span ><span id="show_add_groupview"></span></div>
	<div class="piao_div"><span class="piao_left">阻断NS:</span><span ><input type="checkbox" name="blockns" value=1 ></span></div>
	<div class="piao_div"><span class="piao_left">产品描述:</span><span ><textarea rows="5" name="description" cols="40"></textarea>*支持html</span></div>
	<div class="piao_div"><span class="pull-right"><input type="button" class="btn" id="enter" value="增加"></span></div>
</div>
</script>
<script type='text/template' id="edit-product-template">
<div id="edit-product-div">
	<div class="piao_div"><span class="piao_left">产品名称:</span><span ><input name="name" value="{{name}}">*</span></div>
	<div class="piao_div"><span class="piao_left">产品价格:</span><span ><input name="price" value="{{price}}">元/月*</span></div>
	<div class="piao_div"><span class="piao_left">产品 rrl:</span><span ><input name="rrl" value="{{rrl}}"></span></div>
	<div class="piao_div"><span class="piao_left">server:</span><span id="server-span">{{{serverHtml}}}<!--<input name="server" value="{{server}}">--></span></div>
	<div class="piao_div"><span class="piao_left">产品flag:</span><span ><input name="flags" value="{{flags}}">可以输入格式:1+16384</span></div>
	<div class="piao_div"><span class="piao_left">线 路 组:</span><span ><input name="groupview" value="{{groupview}}"></div>
	<!--<div class="piao_div"><span class="piao_left">阻断NS:</span><span ><input type="checkbox" name="blockns" value=1 {{blockns}} ></span></div>-->
	<div class="piao_div"><span class="piao_left">产品描述:</span><span ><textarea rows="5" name="description" cols="40">{{description}}</textarea>*支持html</span></div>
	<div class="piao_div"><span class="pull-right"><input type="button" class="btn" id="enter" value="修改"></span></div>
</div>
</script>
<script type="text/template" id="product-order-template">
<tr id="{{id}}">
	<td><span id="name">{{name}}</span></td>
	<td><span><input type="button" onclick="productOrderMoveup('{{id}}')" value="上移"/></span></td>
	<td><span><input type="button" onclick="productOrderMovedown('{{id}}')" value="下移"/></span></td>
</tr>
</script>
<script type='text/javascript'>
var default_rrl = '<?php echo $_smarty_tpl->getVariable('default_rrl')->value;?>
';
var dia;
</script>
<script type='text/javascript' src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
scripts/product.js?v=222'></script>
<script type="text/javascript">
$(document).ready(function() {
	var msg = '<?php echo $_smarty_tpl->getVariable('msg')->value;?>
';
	var success = '<?php echo $_smarty_tpl->getVariable('success')->value;?>
';
	getServerList();
});
</script>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：域名列表</div>
			<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>
				<div style='padding-top: 10px;'>
					<span> 产品名称搜索: <input name='name' size=20>
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
					<span ><input type='button' onclick="piao_product_add()" value="增加产品"></span>
					<!--  
					<span><input type='button' onclick="productOrder()" value='产品排序'/></span>
					-->
				</div>
			</form>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="13" class="bg_main"><b>产品列表</b></td>
				</tr>
				<tr id="bg_yellow">
					<td>操作</td>
					<td>排序</td>
					<td>产品ID</td>
					<td>产品名称</td>
					<td>产品价格</td>
					<td>产品描述</td>
					<td>rrl</td>
					<td>所属服务器</td>
					<td>创建时间</td>
					<td>状态</td>
					<td>flags</td>
					<td>线路组</td>
					<td>阻断NS</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr id="tr<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
					<td>
					[<a href='javascript:piao_product_edit(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)'>修改</a>]
					</td>
					<td id="order<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><a href="javascript:productOrder('<?php echo $_smarty_tpl->tpl_vars['row']->value['product_order'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')"><?php echo $_smarty_tpl->tpl_vars['row']->value['product_order'];?>
</a></td>
					<td ><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
					<td id="name"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
					<td id="price"><?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
</td>
					<td id="description" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['description'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['row']->value['description'],16,"...");?>
</td>
					<td id="rrl"><?php echo $_smarty_tpl->tpl_vars['row']->value['rrl'];?>
</td>
					<td id="server"><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</td>
					<td ><?php echo $_smarty_tpl->tpl_vars['row']->value['create_time'];?>
</td>
					<td id="status" data-value='<?php echo $_smarty_tpl->tpl_vars['row']->value['status'];?>
'>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['status']>0){?>
					<a href="#" onclick="product_change_status(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,0)" title="点击可恢复出售"><b class="red">禁售</b></a>
					<?php }else{ ?>
					<a href="#" onclick="product_change_status(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,1)" title="点击可禁售"><b class="green">出售</b></a>
					<?php }?>
					</td>
					<td id="flags"><?php echo $_smarty_tpl->tpl_vars['row']->value['flags'];?>
</td>
					<td id="groupview"><?php echo $_smarty_tpl->tpl_vars['row']->value['groupview'];?>
</td>
					<td id="blockns" data-value="<?php echo $_smarty_tpl->tpl_vars['row']->value['blockns'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['blockns']==1){?>是<?php }else{ ?>否<?php }?></td>
				</tr>
				<?php }} ?>
				<tr>
					<td colspan="13" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
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