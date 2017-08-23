<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 17:40:56
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/message/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:95675293655effea8c84bc9-87279825%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1dbca8eb10ffc9e16dbae8a6b9d77ef6104bef46' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/message/pagelist.html',
      1 => 1441791637,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '95675293655effea8c84bc9-87279825',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/template" id="piao-monitorTable-template">
<div id="set-monitor-div">
	<table class="table_main2" cellpadding="0" cellspacing="1">
           <thead>
				<tr id="bg_yellow">
					<td>操作</td>
					<td>监控ID</td>
					<td>域名</td>
					<td>监控名称</td>
					<td>行为</td>
					<td>记录名称</td>
					<td>主机</td>
				</tr>
			</thead>
			<tbody>
            </tbody>
     </table>
      <div>
					<span  align="left">
 						<a href='#' onclick="getDomainList(1)">首页</a>
 						<a href='#' id="last">上一页</a>
						<a href='#' id="next">下一页</a> 
						<a href='#'  onclick="getDomainList({{total_page}})">尾页</a>
						 {{page}}/{{total_page}}共计{{count}}记录&nbsp;
					</span>
		</div>
    <div><input type="button" value="确定" id="enter"/><input type="button" value="取消" id="esc"/></div>
</div>
</script>
<script type="text/template" id="piao-monitorTr-template">
				<tr id="{{key}}">
					<td><input type="radio" name="box" value="{{key}}"></td>
					<td>{{monitor_id}}</td>
                   <td>{{domain}}</td>
					<td>{{monitor_name}}</td>
					<td>{{action}}</td>
					<td>{{record_name}}</td>
					<td>{{record_value}}</td>
				</tr>
</script>
<script type='text/javascript'>
	$(document).ready(function() {
		$("#yes").bind('click', function(){
			$("#monitor").hide();
			$("#attack").show();
			$("#meaasge").hide();
		})
		$("#no").bind('click', function(){
			$("#attack").hide();
			$("#monitor").show();
			$("#message").show();
		})
		$("#mtab").find("input[name=domain]").keydown(function(event){
			if($("input[name=s]:checked").val() == "attack"){
				return;
			}
			 if(event.which == 13)       //13等于回车键(Enter)键值,ctrlKey 等于 Ctrl
			    {
				   domain = $("#mtab").find("input[name=domain]").val();
				  getDomainList(1);
			    }
		})
	});
	var monitorArr = [];//监控信息数组
	var dia;
	var domain = "";//当前域名
	function  getDomainList(page){
		$.ajax({
			url: "?c=message&a=getDomainList",
			data:{
						domain:domain,
						page:page
			},
			type:"POST",
			dataType:"json",
			success:function(a){
				if(a.status.code != 1){
					alert(a.status.message ? a.status.message : "操作失败");
					return ;
				}
				monitorArr = a.row;
				renderhead(a.count,a.total_page,page);
				renderMonitor();
			},
			error:function(){
				alert("请求异常");
			}
		});
	}
	function renderhead(count,total_page,page){
		var html = $("#piao-monitorTable-template").html();
		var option = [];
		option.count = count;
		option.total_page = total_page;
		option.page = page;
		var el = Mustache.to_html(html,option);
		dia = art.dialog({id : 'monitor',content : el,title : '监控信息'});
		var div = $("#set-monitor-div");
		div.find("#enter").bind("click",function(){
			var id = $("input[name=box]:checked").val();
			dia.close();
			getNoticeFlags(monitorArr[id]['monitor_id']);
		});
		div.find("#esc").bind("click",function(){
			dia.close();
		})
		div.find("#last").unbind();
		div.find("#last").bind("click",function(){
			var nowpage = page>=2?page-1:1;
			 getDomainList(nowpage);
		});
		div.find("#next").unbind();
		div.find("#next").bind("click",function(){
			var nowpage = page<total_page?page+1:total_page;
			 getDomainList(nowpage);
		});
	}
	function renderMonitor(){
		$("#set-monitor-div").find("tbody").html("");//点击下一页之前先清空原来的数据
		for(var i in monitorArr){
			renderMonitorOne(i);
		}
	}
	function renderMonitorOne(i){
		var row = monitorArr[i];
		row.key = i;
		var template = $("#piao-monitorTr-template").html();
		var el = Mustache.to_html(template,row);
		$("#set-monitor-div").find("tbody").append(el);
	}
	function  getNoticeFlags(monitor_id){
		$("input[name=id]").attr('value',monitor_id);
		$.ajax({
			url: "?c=message&a=getNoticeFlags",
			data:{monitor_id:monitor_id},
			dataType:"json",
			success:function(a){
				if(a.status.code != 1){
					alert(a.status.message ? a.status.message : "操作失败");
					return ;
				}
				var message = a.row;
				if(message['weixin'] == 'yes'){
					$("input[name=weixin]").attr('checked',true);
				}
				if(message['sms'] == 'yes'){
					$("input[name=sms]").attr('checked',true);
				}
				if(message['email'] == 'yes'){
					$("input[name=email]").attr('checked',true);
				}
				$("input[name=name]").attr('value',message['monitor_name']);
				$("input[name=domain]").attr('value',message['domain']);
				$("input[name=record_name]").attr('value',message['record_name']);
				$("input[name=src]").attr('value',message['src']);
				$("input[name=action]").attr('value',message['action']);
			},
			error:function(){
				alert("请求异常");
			}
		});
	}
	function submit(){
		var domain = $("#mtab").find("input[name=domain]").val();
		var e = $("input[name=e]").val();
		var qc = $("input[name=qc]").val();
		var s = $("input[name=s]:checked").val();
		var id = $("input[name=id]").val();
		var name = $("input[name=name]").val();
		var src = $("input[name=src]").val();
		var action = $("input[name=action]").val();
		var status = $("input[name=status]:checked").val();
		var record_name = $("input[name=record_name]").val();
		$.ajax({
			url: "?c=message&a=send",
			data:{
						domain:domain,
						e:e,
						qc:qc,
						s:s,
						id:id,
						src:src,
						name:name,
						action:action,
						status:status,
						record_name:record_name,
			},
			dataType:"json",
			success:function(a){
				if(a.status.code != 1){
					alert(a.status.message ? a.status.message : "操作失败");
					return ;
				}
				alert("操作成功");
			},
			error:function(e){
				alert("请求异常"+e.responseText);
			}
		});
	}
	var action = [];
	action['reg'] = "域名注册";
	action['findpasswd'] = "找回密码";
	action['yanzheng'] = "域名验证取回";
	action['domainexpire'] = "域名过期";
	action['monitor'] = "开启监控";
	action['start'] = "攻击开始";
	action['notice'] = "攻击通知";
	action['stop'] = "攻击结束";
	action['deny'] = "攻击拒绝";
	action['undeny'] = "恢复解析";
	function send()
	{
		var tab = $("#send");
		var domain = tab.find("[name=domain]").val();
		if (!domain) {
			alert('域名不能为空');
			return;
		}
		var checked = [];
		tab.find("#action-td").find(':checked').each(function(){
			var val = $(this).attr('name');
			checked.push(val);
		});
		if (checked.length > 0) {
			$("#result").html("");
			showMsg("正在发送")
			deferrSend(0,checked);
			return;
		}
		alert('未选中');
	}
	function showMsg(msg) {
		var result = $("#result");
		result.append("<p>" + msg + "</p>");
	}
	function deferrSend(key,checked) {
		if (key >= checked.length ) {
			showMsg("发送完成");
			return;
		}
		showMsg("正在发送" + action[checked[key]] + ' 邮件');
		sendOne(key,checked);
	}
	function sendOne(key,checked)
	{
		var tab = $("#send");
		var domain = tab.find("[name=domain]").val();
		$.ajax({
			url:"?c=message&a=sendOneMail",
			data:{template:checked[key],domain:domain},
			dataType:'json',
			success:function(a) {
				if (a.status.code != 1) {
					showMsg("发送失败,error="+a.result);
				}else {
					showMsg('发送成功');
				}
				deferrSend(key+1,checked);
			},
			error:function(e) {
				showMsg("发送错误"+e.responseText);
				deferrSend(key+1,checked);
			}
		});
		
	}
	
</script>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：信息模拟 --> 列表</div>
			
			  <table class="table_main2" cellpadding="0" cellspacing="1" id="send">
			  	<tr>
			  		<td>测试邮件</td>
			  		<td id="action-td">
			  			<input type='checkbox' name="reg"  checked="checked">账户注册
			  			<input type='checkbox' name="findpasswd"  checked="checked">账户找回密码
			  			<input type='checkbox' name="yanzheng"  checked="checked">域名验证取回
			  			<input type='checkbox' name="domainexpire"  checked="checked">域名过期
			  			<input type='checkbox' name="monitor" checked="checked">开启监控
			  			<input type='checkbox' name="start" checked="checked">攻击开始
			  			<input type='checkbox' name="notice" checked="checked">监控通知
			  			<input type='checkbox' name="stop" checked="checked">攻击结束
			  			<input type='checkbox' name="deny" checked="checked">攻击拒绝
			  			<input type='checkbox' name="undeny" checked="checked">恢复解析
			  		</td>
			  	</tr>
			  	<tr>
			  		<td>测试域名</td>
			  		<td>
			  			<input name="domain"  type='text'>
			  		</td>
			  	</tr>
			   <tr>
			        <td>&nbsp;</td>
			        <td><button  value='确定' class="btn" onclick="send()">提交&nbsp;&nbsp;</button></td>
		       </tr>
		       <tr>
			  		<td>发送返回信息</td>
			  		<td id="result">
			  			
			  		</td>
			  	</tr>
			  </table>
			  <table class="table_main2" cellpadding="0" cellspacing="1" id="mtab">
		           <tr>
			            <td class="wid_general">模拟来源</td>
			            <td><input id="yes"name='s' type='radio' value="attack" checked>攻击
			                <input id="no" name='s' type='radio' value="monitor">监控
			            </td>
		          </tr>
		             <tr>
			            <td class="wid_general">模拟域名</td>
			            <td>
			                <input name='domain' type='text'><span id="message" style="display:none">请按下"回车"键</span>
			            </td>
		          </tr>
		          <tr id="attack">
			            <td class="wid_general"></td>
			            <td>
			                  处理方式: <input name='e' type='text' value="deny">
			                  QPS:<input name='qc' type='text' value="1000">
			            </td>
		          </tr>
		          
		          <tr  id="monitor" style="display:none">
			            <td class="wid_general"></td>
			            <td>
			                   监控ID&nbsp;<input name='id' type='text'  /><br>
			                   监控名称<input name="name" type='text' ><br>
			                   记录名称 <input name='record_name' type='text' /><br>
			                   主机&nbsp;&nbsp;<input name="src" type='text' ><br>
			                   行为&nbsp;&nbsp;<input name='action' type='text' ><br>
			                   状态&nbsp;&nbsp;<input name='status' type='radio' value="0" checked>正常<input name='status' type='radio' value="1">异常<br>
			                    通知方式<input name='email' type='checkbox' value="email" checked/>邮件
			                    <input name='weixin' type='checkbox' value=“weixin” checked/>微信
			                    <input name='sms' type='checkbox' value="sms" checked/>短信
			            </td>
		          </tr>
		          <tr>
			            <td>&nbsp;</td>
			            <td><button  value='确定' class="btn" onclick="submit()">提交&nbsp;&nbsp;</button></td>
		          </tr>
		          
			  </table>
		</div>
	</div>
</body>
</html>
