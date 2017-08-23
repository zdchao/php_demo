<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 16:59:03
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/moneylog/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:116727444155f146579bc6a2-51670865%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c53f6e7183e0811b8397ddfe8227849950b68fbb' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/moneylog/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '116727444155f146579bc6a2-51670865',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/template" id="add-remark-template">
<div id="add-remark-div" style="width:500px">
	<div class="piao_div">
		<span class="piao_left">入账原因:</span>
		<span class="piao_right">
			<textarea name="remark" rows=5 cols=40></textarea>
		</span>
	</div>
	<div class="piao_div">
		<span class="pull-right">
			<button class="btn" id="enter">确定</button>
		</span>
	</div>
</div>
</div>
</script>
<script type="text/template" id="fackage-template">
<div id="package-div">
	<div><span style="font-size:20px;">确定要进行退费操作吗?</span></div>
	<div><input type="button" id="enter" value="确定"/><input type="button" id="esc" value="取消"/></div>
</div>
</script>
<script type='text/javascript'>
var default_rrl = '<?php echo $_smarty_tpl->getVariable('default_rrl')->value;?>
';
$(document).ready(function() {
	
});
var dia;
function confirm_money(id)
{
	var template = $("#add-remark-template").html();
	dia = art.dialog({id:'piao_add_remark',content:template,lock:true,top:'10%'});
	var div = $("#add-remark-div");
	div.find('[name=remark]').trigger('focus');
	div.find("#enter").bind('click',function(){
		var remark = div.find('[name=remark]').val();
		if(remark=="" || remark==null){
			alert("入账原因不能为空！！");
			return false;
		}
		var money = $("#tr"+id).find("#money").text();
		$.ajax({
			url:'?c=moneylog&a=confirmMoney',
			data:{id:id,money:money,remark:remark},
			dataType:'json',
			success:function(a) {
				if (a.code != 200) {
					alert(a.message);
					return ;
				}
				window.location = '?c=moneylog&a=pagelist';
			},
			error:function(e) {
				alert("后台数据出错"+e.responseText);
			}
		});
	});
	div.find('[name=server]').trigger('focus');
	/*
	$.ajax({
		url:'?c=moneylog&a=confirmMoney',
		data:{id:id},
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			$("#moneylog_confirm"+id).html("已确认");
			$("#moneylog_status"+id).html("已入账");
		},
		error:function(e) {
			alert("后台数据出错"+e.responseText);
		}
	});
	*/
}
//受理退费
function fackage(id){
	var template = $("#fackage-template").html();
	var dia = art.dialog({
		id:'fackage',
		title:'退费操作',
		content:template,
		lock:true
	});
	var div = $("#package-div");
	div.find("#esc").bind("click",function(){
		dia.close();
	});
	div.find("#enter").bind("click",function(){
		dia.close();
		fackageEnter(id);
	});
}
function fackageEnter(id){
	$.ajax({
		url:'?c=moneylog&a=domainRegisterFackage',
		type:'POST',
		data:{id:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.ret);
				return;
			}
			$("#tr"+id).find("#moneylog_confirm"+id).html("");
			$("#tr"+id).find("#moneylog_remark"+id).html("退费成功");
		},
		error:function(a){
			alert("网络响应失败");
		}
	});
}
</script>

<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：金额列表</div>
			
				<div style='padding-top: 10px;'>
					<span style="float:left"> 
					<form name="form1" action='<?php echo $_smarty_tpl->getVariable('action')->value;?>
' method='post'>
					uid:<input name='uid' size=8>
					server:<input name='server' size=10>
					订单号/备注:<input name='mem' size=14>
						<input type='submit' value='搜索'>
					</form>
					</span>
					<span style="float:right"> 选择显示:<select name='page_count'
						onchange='set_pagecount(this.value)'> <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 10;
  if ($_smarty_tpl->getVariable('i')->value<=100){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<=100; $_smarty_tpl->tpl_vars['i']->value++){
?> <?php if ($_smarty_tpl->tpl_vars['i']->value%5==0){?>
							<option value='<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' <?php if ($_smarty_tpl->getVariable('page_count')->value==$_smarty_tpl->tpl_vars['i']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option>
							<?php }?> <?php }} ?>
					</select> 行
					</span>
				</div>
			
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr id="bg_yellow">
					<td style="width:80px">操作</td>
					<td style="width:60px">会员ID</td>
					<td style="width:80px">server</td>
					<td style="width:200px">域名</td>
					<td style="width:70px">类型</td>
					<td style="width:70px">金额(元)</td>
					<td style="width:140px">时间</td>
					<td style="width:420px">备注/订单号</td>
					<td style="width:60px">状态</td>
					<td style="width:auto">备注</td>
				</tr>
				
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<?php if ($_smarty_tpl->tpl_vars['row']->value['money']){?>
				<tr id='tr<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
'>
					<td id="moneylog_confirm<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
					<?php if ($_smarty_tpl->tpl_vars['row']->value['status']!=0&&$_smarty_tpl->tpl_vars['row']->value['type']=='moneyin'){?>
						<?php if ((totime()-totime($_smarty_tpl->tpl_vars['row']->value['create_time']))<86400){?>
							[<a href="#" onclick="confirm_money(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">确认入账</a>]
						<?php }?>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['row']->value['remark']!='注册成功'&&$_smarty_tpl->tpl_vars['row']->value['remark']!='退费成功'&&$_smarty_tpl->tpl_vars['row']->value['type']=="domain_r"&&$_smarty_tpl->tpl_vars['row']->value['remark']!='续费成功'&&$_smarty_tpl->tpl_vars['row']->value['remark']!='转入成功'){?>
						[<a href="javascript:fackage(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">退费</a>]
					<?php }?>
					</td>
					<td><a href="?c=users&a=pagelist&uid=<?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
</a></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</td>
					<td><a href="?c=domains&a=pagelist&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
</a></td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['type']=='moneyin'){?>充值<?php }elseif($_smarty_tpl->tpl_vars['row']->value['type']=='domain_r'){?>域名注册<?php }else{ ?>消费<?php }?></td>
					<td id="money">
					<?php if ($_smarty_tpl->tpl_vars['row']->value['type']=='moneyout'){?>
						<?php if (totime($_smarty_tpl->tpl_vars['row']->value['create_time'])>totime('2015-01-12 12:00:00')){?>
							<?php echo $_smarty_tpl->tpl_vars['row']->value['money']/100;?>

						<?php }else{ ?>
							<?php echo $_smarty_tpl->tpl_vars['row']->value['money'];?>

						<?php }?>
					<?php }else{ ?>
						<?php echo $_smarty_tpl->tpl_vars['row']->value['money']/100;?>

					<?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['create_time'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['mem'];?>
</td>
					<td id="moneylog_status<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==0){?>正常<?php }else{ ?><b class='red'>充值中</b><?php }?></td>
					<td id="moneylog_remark<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['remark'];?>
</td>
				</tr>
				<?php }?>
				<?php }} ?>
				<tr>
					<td colspan="12" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=0'>首页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value-1;?>
'>上一页</a>
						<?php }else{ ?> 首页 上一页 <?php }?> <?php if ($_smarty_tpl->getVariable('page')->value!=$_smarty_tpl->getVariable('total_page')->value){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value+1;?>
'>下一页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
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