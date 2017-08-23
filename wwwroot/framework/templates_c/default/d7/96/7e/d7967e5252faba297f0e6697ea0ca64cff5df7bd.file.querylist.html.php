<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 20:26:06
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/records/querylist.html" */ ?>
<?php /*%%SmartyHeaderCode:179183031155f6bcde78e431-09455934%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7967e5252faba297f0e6697ea0ca64cff5df7bd' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/records/querylist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179183031155f6bcde78e431-09455934',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type='text/javascript'>
$(document).ready(function(){
});
var i=0;
/*
 * 迁引操作
 */
 var contentList = [];
 var moveLed = function(domain,t,c)
 {
	//alert(domain);
	 $.ajax({
			url:'?c=records&a=getDomainMoveLedSta',
			data:{domain:domain},
			dataType:'json',
			success:function(a){
				var description = "";
				for(i in a.list){
					if((a.list[i]['flags'] & 8448) > 0){
						alert("迁引中");
						return;
					}else{
						piao_add_movecited(domain,t,c);
					}
				}
			},
			error:function(e){
				alert('后台数据出错'+e.responseText);
			}
		});
}
 function piao_add_movecited(domain,t,c)
 {
 	var template = $("#domain-add-movecited-template").html();
 	var option = [];
 	option.name = domain;
 	var el = Mustache.to_html(template,option);
 	dia = art.dialog({id:'piao_add_movecited',content:el,lock:true,lock:'10%'});
 	var div = $("#domain-add-movecited-div");
 	div.find('[name=minute]').trigger('focus');
 	div.find('[name=remark]').trigger('focus');
 	div.find('#enter').bind('click',function(){
 		add_movecited(domain,t,c);
 	});
 }
 function add_movecited(domain,t,c)
 {
 	var div = $("#domain-add-movecited-div");
 	var minute = div.find("[name=minute]").val();
 	var remark = div.find("[name=remark]").val();
 	if (!minute) {
 		alert('解除时间不能为空');
 		return;
 	}
 	if (!remark) {
 		alert('请填写迁引的原因');
 		return;
 	}
 	dia.close();
 	$.ajax({
 		url:'?c=domains&a=addMovecited',
 		data:{domain:domain,minute:minute,remark:remark},
 		dataType:'json',
 		success:function(a) {
 			if (a.status.code != 1) {
 				dia.content(a.status.message);
 				return;
 			}
 			//alert('迁引成功');
 			var tr = $("#tr"+t+c);
 			tr.find("#moveLed").html("<span class='red'>[迁引成功]</span>");
 		},
 		error:function(e) {
 			alert("迁引失败");
 		}
 	});
 }
</script>
<script type='text/template' id="domain-add-movecited-template">
<div id="domain-add-movecited-div" style="width:400px">
	<div class="piao_div">当前域名:<big class="green"><b>{{name}}</b></big></div>
	<div class="piao_div"><input type='text' name="minute" size="8" value=5>分钟解除,为0则管理员手动解除(不会产生迁引记录)</div>
	<div class="piao_div">迁引备注:<input type='text' name="remark" size="30" value="攻击过大"/></div>
	<div class="piao_div"><span class="pull-right"><button class="btn" id="enter">迁引</button></span></div>
</div>
</script>

<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：解析量排名</div>
			
					<div>
					往前&nbsp;
					<a href="<?php echo $_smarty_tpl->getVariable('action')->value;?>
&d=qchour&t=0"><b >当前</b></a>&nbsp;
					<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<24){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<24; $_smarty_tpl->tpl_vars['i']->value++){
?>
						<a href="<?php echo $_smarty_tpl->getVariable('action')->value;?>
&d=qchour&t=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><b ><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</b></a>&nbsp;
					<?php }} ?>
					小时
				</div>
				<br>
				<div >
				往前&nbsp;
				<a href="<?php echo $_smarty_tpl->getVariable('action')->value;?>
&d=qcday&t=0"><b > 当天</b></a>&nbsp;
				<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<31){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<31; $_smarty_tpl->tpl_vars['i']->value++){
?>
						<a href="<?php echo $_smarty_tpl->getVariable('action')->value;?>
&d=qcday&t=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><b > <?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</b></a>&nbsp;
					<?php }} ?>
					天
				</div>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="12" class="bg_main"><b>解析量列表</b>
						<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>
						 选择显示:<select name='page_count'
							onchange='set_pagecount(this.value)'> <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 10;
  if ($_smarty_tpl->getVariable('i')->value<=60){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=60; $_smarty_tpl->tpl_vars['i']->value++){
?> <?php if ($_smarty_tpl->tpl_vars['i']->value%5==0){?>
								<option value='<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' <?php if ($_smarty_tpl->getVariable('page_count')->value==$_smarty_tpl->tpl_vars['i']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option>
								<?php }?> <?php }} ?>
						</select>
						</form>
					</td>
				</tr>
				<tr id="bg_yellow">
					<td>时间</td>
					<td>域名</td>
					<td>解析量</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr id='tr<?php echo $_smarty_tpl->tpl_vars['row']->value['t'];?>
<?php echo $_smarty_tpl->tpl_vars['row']->value['c'];?>
'>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['t'];?>
</td>
					<td>
						<a href="?c=domains&a=pagelist&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
">[查看域名信息]</a>
						<a id='moveLed' href="javascript:;" onclick="moveLed('<?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['t'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['c'];?>
');">[迁引]</a>
						<a href="?c=domains&a=loginDomain&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
" target=_blank><?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
</a>
						
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['c'];?>
</td>
				</tr>
				<?php }} else { ?>
				<tr><td>&nbsp;<td colspan=2 class='red'>没有&nbsp;<b><?php echo $_smarty_tpl->getVariable('date')->value;?>
</b>&nbsp;的数据</td></tr>
				
				<?php } ?>
				<tr>
					<td colspan="12" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=0&d=<?php echo $_smarty_tpl->getVariable('d')->value;?>
&t=<?php echo $_smarty_tpl->getVariable('t')->value;?>
'>首页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value-1;?>
&d=<?php echo $_smarty_tpl->getVariable('d')->value;?>
&t=<?php echo $_smarty_tpl->getVariable('t')->value;?>
'>上一页</a>
						<?php }else{ ?> 首页 上一页 <?php }?> <?php if ($_smarty_tpl->getVariable('page')->value!=$_smarty_tpl->getVariable('total_page')->value){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value+1;?>
&d=<?php echo $_smarty_tpl->getVariable('d')->value;?>
&t=<?php echo $_smarty_tpl->getVariable('t')->value;?>
'>下一页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&d=<?php echo $_smarty_tpl->getVariable('d')->value;?>
&t=<?php echo $_smarty_tpl->getVariable('t')->value;?>
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