<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 18:39:32
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/ns/nslist.html" */ ?>
<?php /*%%SmartyHeaderCode:120693987755f6a3e4258141-58637659%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3538e10c2f3c889f8692576f8412f2cbdf40a8b4' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/ns/nslist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120693987755f6a3e4258141-58637659',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<script type='text/javascript'>
$(document).ready(function(){
});
function edit_ip(ip,value)
{
	var r = confirm("确定要修改?");
	if (!r) {
		return;
	}
	$.ajax({url:'?c=ip&a=edit',data:{ip:ip,view:value},dataType:'json',success:function(ret) {
		if (ret['code'] != 200) {
			alert('修改失败');
		}else {
			window.location = window.location;
		}
	}})	;
}
function create_result_html(nic)
{
	var html='';
	if (typeof(nic)=='undefined') {
		return '-<br>';
	}
	if (nic.toString() =='false') {
		html = '获取失败<br>';
	} else {
		for (var i in nic) {
			html += '<ul>';
			for ( var j in nic[i]) {
				if (i=='delip') {
					html += '<li title="需到上级删除"><s>' + nic[i][j] + '</s></li>';
				}else {
					html += '<li title="需到本地添加"><i>' + nic[i][j] + '</i></li>';
				}
			}
			html += '</ul>';
		}
	}
	return html;
}
function check_ns(id,sync)
{
	$("#checknsresult"+id).html('<img src="/style/busy.gif">');
	var async = sync? false:true;
	$.ajax({
		url:'?c=ns&a=checkNs',
		data:{id:id},
		dataType:'json',
		type:'POST',
		async:async,
		success:function (a) {
			query_one(id);
			var html = '<div>上级:' + create_result_html(a.nic);
			html += '本地:' + create_result_html(a.dig);
			html += '</div>';
			$("#checknsresult"+id).html(html);	
		},
		error:function(e){
			query_one(id);
		}
	})
}
var queryids = [];
var allid = [];
var dia;
function check_all_ns()
{
	$(".checkns").each(function(){
		var id = $(this).text();
		allid.push(id);
	});
	if (allid.length <=0){
		return ;
	}
	dia = art.dialog({id:'piao_query_ns'});
	dia.content('<div>正在查询中...</div><div id="list_msg"></div>');
	$("#list_msg").append('<div>总查询个数'+allid.length+'</div>');
	query_one();
}
function query_one(id)
{
	if (id) {
		for ( var k in queryids) {
			if (queryids[k]==id) {
				queryids.splice(k,1);
			}
		}
	}
	if (allid.length > 0 && queryids.length<2) {
		for( var i in allid) {
			check_ns(allid[i],false);
			allid.splice(i,1);
			$("#list_msg").append('<div>当前还有查询个数'+allid.length+'</div>');
			if (allid.length <= 0){
				dia.close();
				break;
			} 
			if (queryids.length >1) {
				break;
			}
		}
	}
}
function piao_add_ns()
{
	var html = '<form name="add_ns" action="?c=ns&a=add" method="POST"> ';
		html +='<p>ns名称:<input name="name"></p>';
		html +='<p title="多个请用,或|分割">IP段:<input name="ip" size=72></p>';
		html +='<p>分属:<input name="type" type=radio value=16 checked>ns1<input name="type" type=radio value=17>ns2</p>';
		html +='<p><input type="submit" value="提交" ></p>';
		html += '</form>';
		var dia = art.dialog({id:'piao_add_ns'});
		dia.title("增加NS");
		dia.content(html);
}
function check_status(id)
{
	alert(id);	
	
	
}
function piao_set_proxyuid(id)
{
	var template = $("#set-proxyuid-template").html();
	var option = [];
	option.proxyuid = $("#ns"+id).find('#proxyuid').text();
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_set_proxyuid',content:el,lock:true,top:'10%',title:"设置NS的代理用户ID"});
	var div = $("#set-proxyuid-div");
	div.find("#enter").bind('click',function() {
		set_proxyuid(id);
	});
}
function set_proxyuid(id)
{
	var div = $("#set-proxyuid-div");
	var proxyuid = div.find('[name=proxy_uid]').val();
	$.ajax({url:'?c=ns&a=changeProxyuid',
			data:{id:id,proxy_uid:proxyuid},
			dataType:'json'
	}).done(function(a) {
		if (a.status.code != 1) {
			dia.close();
			alert(a.status.message);
			return;
		}
		var template = $("#show-userinfo-template").html();
		var option = a.userinfo||[];
		option.message = '<img src="/style/img/success.png">设置成功';
		var el = Mustache.to_html(template,option);
		dia.size("300px","300px");
		dia.content(el);
		$("#ns"+id).find('#proxyuid').text(proxyuid);
		$("#show-userinf-div").find("#esc").bind('click',function(){
			dia.close();
		});
	}).fail(function(e) {
		dia.close();
		alert(e.responseText);
	});
	
}
function changeNsFlag(id,flag)
{
	if(flag==0){
		if(!confirm("确定要禁用ns吗?")){
			return;
		}
	}else{
		if(!confirm("确定要启用ns吗?")){
			return;
		}
	}
	$.ajax({
		url:'?c=ns&a=changeNsFlag',
		data:{id:id,flag:flag},
		type:'post',
		dataType:'json',
		success:function(a){
			if(a.status.code!=1){
				alert('error');
			}
			window.location = '?c=ns&a=nslist';
		},
		error:function(e){
			alert(e);
		}
	});
}
</script>
<script type='text/template' id="set-proxyuid-template">
<div id="set-proxyuid-div">
	<div ><span class="piao_left">用户ID</span><span><input type='text' name="proxy_uid" value={{proxyuid}}><button class="btn" id="enter">设置</button></span></div>
</div>
</script>
<script type='text/template' id="show-userinfo-template">
<div id="show-userinf-div">
	<div class="piao_div">{{{message}}}</div>
	{{#email}}<div class="piao_div">用户账号:{{email}}</div>{{/email}}
	{{#name}}<div class="piao_div">用户姓名:{{name}}</div>{{/name}}
	{{#tel}}<div class="piao_div">用户电话:{{tel}}</div>{{/tel}}
	<div class="piao_div"><span class="pull-right"><button class="btn" id="esc">我已知道了</button></span></div>
</div>
</script>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：ns列表</div>
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
					<td colspan="9" class="bg_main">
					<b>[<a href='?c=ns&a=nslist'>查看全部ns</a>]
					[<a href='?c=ns&a=nslist&delete_flag=1'>删除标记</a>]
					[<a href='?c=ns&a=ns_sync_config'>同步ns配置文件</a>]
					[<a href='#' onclick='check_all_ns()'>检测所有NS</a>]
					[<a href='#' onclick='piao_add_ns()'>增加NS</a>]
					</b>
					</td>
				</tr>
				<tr id="bg_yellow">
				<td>操作</td>
					<td >id</td>
					<td>名字</td>
					<td>类型</td>
					<td>ip</td>
					<td>代理UID</td>
					<td>删除标记</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr id="ns<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
				    <td>
				    	[<a href='?c=ns&a=nsdel&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
&type=<?php echo $_smarty_tpl->getVariable('type')->value;?>
' onclick="return confirm('确定要删除么？');">删除</a>]
				    	[<a href='?c=ns&a=nseditform&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
&type=<?php echo $_smarty_tpl->getVariable('type')->value;?>
'>修改</a>]
				    	[<a href='#' onclick='check_ns(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,0)'>检查NS</a>]
				    	<span id='checknsresult<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
'></span>
				    </td>
					<td class='checkns'><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
					<td ><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['ip'];?>
</td>
					<td>[<a href="javascript:;" onclick="piao_set_proxyuid(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)" >设置代理UID</a>]&nbsp;<span id="proxyuid"><?php echo $_smarty_tpl->tpl_vars['row']->value['proxy_uid'];?>
</span></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['delete_flag'];?>
<?php if ($_smarty_tpl->tpl_vars['row']->value['delete_flag']==1){?><a href="#" onclick='changeNsFlag(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,0)'>[禁用ns]</a><?php }else{ ?><a href="#" onclick='changeNsFlag(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,1)'><font color="red">[启用ns]</font></a><?php }?></td>
				</tr>
				<?php }} ?>
				<tr>
					<td colspan="9" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=0&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
&<?php echo $_smarty_tpl->getVariable('where')->value;?>
'>首页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value-1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
&<?php echo $_smarty_tpl->getVariable('where')->value;?>
'>上一页</a>
						<?php }else{ ?> 首页 上一页 <?php }?> <?php if ($_smarty_tpl->getVariable('page')->value!=$_smarty_tpl->getVariable('total_page')->value){?> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('page')->value+1;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
&<?php echo $_smarty_tpl->getVariable('where')->value;?>
'>下一页</a> <a
						href='<?php echo $_smarty_tpl->getVariable('action')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('total_page')->value;?>
&search=<?php echo $_smarty_tpl->getVariable('search')->value;?>
&<?php echo $_smarty_tpl->getVariable('where')->value;?>
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