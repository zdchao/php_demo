<?php /* Smarty version Smarty-3.0.5, created on 2017-08-14 14:32:54
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/container/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:10056880595991441657cdf4-00711410%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7720c4a310663234f7a0693291b1e6e9f8cea37' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/container/pagelist.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10056880595991441657cdf4-00711410',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<script type="text/template" id="buy-template">
月数：<i class="icon-minus" id="minus"></i><input type="text" name="months"class="input-mini" value="1"/><i class="icon-plus" id="add"></i>
<button id="enter" class="btn btns btn-success" data-loading-text="正在执行...">提交</button>
<button id="esc"  class="btn">取消</button>
</script>
<script type="text/template" id="buy-success-template">
<div style="background:F5F5F5">
	<image src="/style/img/buy_success.png" style="margin:5% 40%;">
    <div class="buy_message">您的产品已经购买成功！</div>
     <div class="buy_message"> 您可以在<a href="?c=containerproduct&a=usercontainer">我的容器-->未使用</a>查看您购买的产品</div>
    <div class="buy_button" style="margin-left:20%">该页面会在<span id="time">10</span>秒之后自动跳转</div>
</div>
</script>

<script type="text/javascript">
$(function(){
	$("#left_group_list").find('div').eq(0).addClass('cur');
	$("#nav_container").addClass('cur');
});

</script>
<link href="/style/user/css/container.css" rel="stylesheet">
<link href="/style/user/css/domain.css" rel="stylesheet">
<div class="row-fluid" style="height:30px;">
		<span id="domain_error" class="offset3"></span>
</div>
<div class="wrap" id="left">
    <div class="cl mtb20">
		<?php $_template = new Smarty_Internal_Template('container/containerleft.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
 		<div class="cont_main">
 			<div class="buycontainer">
	 			 <ul>
	 			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rows')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
	 				<li>
	 					<p class="container_price"><span class="yuan">￥</span><span class="strong"><?php echo $_smarty_tpl->tpl_vars['row']->value['price']/100;?>
</span>元/月</p>
	 					<p class="container_p container_name"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</p>
	 					<p class="container_p">MYSQL数据库</p>
	 					<p  class="container_p"><span class="store"><?php echo $_smarty_tpl->tpl_vars['row']->value['memory'];?>
M</span>内存</p>
	 					<p  class="container_p"><span class="store"><?php echo $_smarty_tpl->tpl_vars['row']->value['disk_space'];?>
G</span>硬盘</p>
	 					<a class="btn btn-success btns" href="?c=containerproduct&a=buyProduct&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" style="margin:15px 0px;">立即购买</a>
	 				</li>
				<?php }} ?>
				</ul>
 			</div>
 		</div>
  </div>
</div>
<!--
<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rows')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
 				 <div id="tr<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" data-price="<?php echo $_smarty_tpl->tpl_vars['row']->value['price']/100;?>
"  style="width:40%;float:left;margin:15px 10px;">
	 				<table class="domain_table" style="width:100%">
						 <caption class="alert-danger"><h5><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<h5></caption>
						 	<tr><td>价格</td><td id="price"><em><?php echo $_smarty_tpl->tpl_vars['row']->value['price']/100;?>
元(月)</em></td></tr>
						 	<tr><td>MYSQL</td><td>支持</td></tr>	  
						 	<tr><td>内存</td><td><?php echo $_smarty_tpl->tpl_vars['row']->value['memory'];?>
M</td></tr>    
							<tr><td>硬盘</td><td><?php echo $_smarty_tpl->tpl_vars['row']->value['disk_space'];?>
G</td></tr>
							 <tr><td colspan="2"> <div id="buy"><a class="btn btn-success btns" href="?c=containerproduct&a=buyProduct&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">立即购买</a></div></td></tr>	      
					</table>
				</div>
			<?php }} ?>
 -->
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>