<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 17:37:31
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/main.html" */ ?>
<?php /*%%SmartyHeaderCode:146119009455effddbec8c13-21361108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '794b0341b4c34890197586b1c9ff9761ea7b8987' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/main.html',
      1 => 1440485580,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '146119009455effddbec8c13-21361108',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/template" id="main-add-slave-template">
<form action="?c=index&a=addSlave" method="POST">
<br><br>server:<input name="server" value={{s}}/>
服务器IP:<input name="ip" />
<br><br><input type="submit" value="确定">
</form>
</script>
<script type="text/template" id="list-server-node-template">
<tr id="{{key}}">
	<td>{{node}}</td>
	<td>{{serverip}}</td>
	<td>{{seq}}</td>
	<td>{{master}}{{sync}}</td>
	<td>{{time}}</td>
	<td>{{version}}</td>
	<td>{{{img}}}</td>
</tr>
</script>
<script type='text/javascript'>
	var promptmsg = "<?php echo $_smarty_tpl->getVariable('operatingmsg')->value;?>
";
	var queueinfo = eval("("+'<?php echo $_smarty_tpl->getVariable('queueinfo')->value;?>
'+")");
	$(document).ready(function() {
		if (promptmsg != '') {
			art.dialog({id : 'id23',content : promptmsg,title : '警告',icon : 'warning',top : '30%'});
		}
			var msg = '';
			if (queueinfo.check_ns != undefined){
				if (queueinfo.check_ns.ready != undefined && queueinfo.check_ns.ready>1000) {
					 msg += 'check_ns的数量超过1000';
				}
			}
			if(queueinfo.notice){
				if (queueinfo.notice.ready != undefined && queueinfo.notice.ready>200) {
					 msg += '<br>notice的数量超过200';
				}
			}
			if(queueinfo.send_ms){
				if (queueinfo.send_ms.ready != undefined && queueinfo.send_ms.ready>100) {
					 msg += '<br>send_ms的数量超过100';
				}
			}
			if (msg != '') {
				msg += "<br>请检查后台进程是否正常";
			}
			if(msg){
				art.dialog({id : 'id123',content :"<b style='color:red'>"+ msg + "</b>",title : '警告',icon : 'warning',top : '30%'});
			}
	
		//blocknsNotice();
	});
	function del_slave(ip, s, r) {
		if (confirm("确定要删除吗?")) {
			window.location = '?c=index&a=delSlave&ip=' + ip + '&server=' + s + "&remote=" + r;
		}
	}
	function add_slave(s) {
		var template = $("#main-add-slave-template").html();
		var option = [];
		option.s = s;
		var el = Mustache.to_html(template,option);
		art.dialog({
			id : 'add_slave',
			content : el,
			title : '增加辅节点'
		});
	}
	function blocknsNotice()
	{
		$.ajax({
			url:'?c=blockns&a=getInfo',
			dataType:'json',
			success:function(a) {
				if (a.status.code != 1) {
					return ;
				}
				var html = '阻断NS未添加';
				var icon = 'error';
				if (a.count > 0) {
					html = '阻断NS总数:'+a.count + '<br>';
					for ( var i in a.detail) {
						var use = a.detail[i]['use'];
						if (use==undefined){
							use = 0;
						}
						var nouse = a.detail[i]['nouse'];
						if (nouse==undefined){
							nouse = 0;
						}
						html += '<div ';
						if (nouse ==0) {
							html += ' class="red"';
						}
						html += '>';
						html += i + '总数:'+ a.detail[i]['count'] + ',已使用:'+use;
						html += ',未使用:'+nouse;
						html +=  '</div>';
					}
					icon = 'warning';
				}
				art.dialog.notice({title: '阻断NS信息提示',width: 260, content:"<br>"+ html + '<br>',  icon: icon});
			},
			error:function(e) {
				
			}
		});
		
	}
	function changeServer(server){
		$("#list_server_node").html("");
		var m = new main();
		m.init(server);
	}
</script>
<script type="text/javascript">
function main(){
	this.listservernode = [];
	this.listserver = [];
	this.serverall = []; //合并所有server
	this.seq = null;
	this.server = null;
	this.init = function(server){
		var that = this;
		that.server = server;
		that.getAllRet();
		this.showServerList(that.listserver);
		this.showServerNodeList(that.listservernode,that.serverall);
	}
	//显示server node 连接信息
	this.showServerNodeList = function(listnode,serverall){
		var that = this;
		var lengthnode = listnode.length;
		var lengthserver = serverall.length;
		var template = $("#list-server-node-template").html();
		var option = [];
		for(var i=0;i<lengthnode;i++){
			for(var j=0;j<lengthserver;j++){
				if(listnode[i] == serverall[j]['node'] && that.server == serverall[j]['server']){
					option.key = i;
					option.node = listnode[i];
					option.master = serverall[j]['master']+"-";
					option.serverip = serverall[j]['addr'];
					option.version = serverall[j]['version'];
					option.seq = serverall[j]['seq'];
					option.sync = serverall[j]['sync'];
					option.time = serverall[j]['time'];
					option.img = "<img src='/style/check_right.gif'>";
					var el = Mustache.to_html(template,option);
					$("#list_server_node").append(el);
					that.listservernode[i] = "@";
				}
			}
		}
		for(var i=0;i<lengthnode;i++){
			if(that.listservernode[i] == "@"){
				continue;
			}
			option.key = i;
			option.node = listnode[i];
			option.master = "";
			option.serverip = "";
			option.version = "";
			option.seq = "";
			option.sync = "";
			option.time = "";
			option.img = "<img src='/style/check_error.gif'>";
			var el = Mustache.to_html(template,option);
			$("#list_server_node").append(el);
		}
	}
	this.showServerList = function(ret){
		var that = this;
		$("#list_server").html("");
		var length = ret.length;
		var html = "";
		html += "server数:"+length;
		for(var i=0;i<length;i++){
			if(ret[i]['name'] == that.server){
				html += "<a style='color:red; href='javascript:;' onclick=\"changeServer('"+ret[i]['name']+"')\">["+ret[i]['name']+"]</a>";
				that.seq = ret[i]['serial'];
			}else{
				html += "<a href='javascript:;' onclick=\"changeServer('"+ret[i]['name']+"')\">["+ret[i]['name']+"]</a>";
			}			
		}
		$("#list_server").append(html);
		$("#serial_number").html("序列号:"+that.seq);
		$("#server_count").html("node数:"+that.listservernode.length);
	}
	this.getAllRet = function(){
		var that = this;
		$.ajax({
			url:'?c=index&a=ajaxGetServerAll',
			data:{server:that.server},
			dataType:'json',
			async:false,
			success:function(a){
				if(a.listServerNode['result'] == 200){
					that.getListServerNode(a.listServerNode['value']);
				}
				for(var i in a.serverlist){
					that.listserver.push(a.serverlist[i]);
				}
				if(a.master1['result'] == 200){
					var length1 = a.master1['value'].length;
					that.mergeServer(length1,a.master1['value'],1);
				}
				if(a.master0['result'] == 200){
					var length0 = a.master0['value'].length;
					that.mergeServer(length0,a.master0['value'],0);
				}
				$("#fansd_version").html(a.version);
			},
			error:function(a){
				alert('error');
			}
		});
	}
	//获得server 的节点
	this.getListServerNode = function(ret){
		var that = this;
		for(var i in ret){
			that.listservernode.push(ret[i]);
		}
	}
	//合并server信息
	this.mergeServer = function(length,ret,master){
		var that = this;
		for(var i=1;i<length;i++){
			ret[i]['master'] = master;
			that.serverall.push(ret[i]);
		}
	}
}
function checkProgram(){
	$.ajax({
		url:'?c=index&a=checkProgram',
		dataType:'json',
		success:function(a){
			alert(a.status.message);
		},
		error:function(a){
			alert('error');
		}
	});
}
$(document).ready(function(){
	var m = new main();
	m.init("<?php echo $_smarty_tpl->getVariable('server')->value;?>
");
});
</script>
<body text='#000000' leftmargin='0' topmargin='0'>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：帐号管理 --> 我的信息</div>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="2" class="bg_main"><b>我的信息</b><button onclick='checkProgram()' style="background-color:#ff6760; border:none; margin:3px; color:#ffffff; height:30px; border-radius:5px;">检测进程</button></td>
				</tr>
				<tr>
					<td class="wid_general">用户名:</td>
					<td><?php echo $_smarty_tpl->getVariable('role')->value['admin'];?>
</td>
				</tr>
				<?php if ($_smarty_tpl->getVariable('msg')->value){?>
				<tr>
					<td>提示:</td>
					<td class='red'><?php echo $_smarty_tpl->getVariable('msg')->value;?>
</td>
				</tr>

				<?php }?>

				<tr>
					<td>当前版本:</td>
					<td><?php echo $_smarty_tpl->getVariable('softversion')->value;?>
</td>
				</tr>
				<tr>
					<td>fansd:</td>
					<td id="fansd_version"></td>
				</tr>
				<!-- 
				<tr>
					<td>fansd版本</td>
					<td><?php echo $_smarty_tpl->getVariable('fansdversion')->value;?>
</td>
				</tr>
				 -->
				<tr>
					<td>消息队列:</td>
					<td>
					<?php if ($_smarty_tpl->getVariable('queue')->value){?>
					<img src="/style/check_right.gif">
						<?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('queue')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
?>
						<?php echo $_smarty_tpl->tpl_vars['r']->value['name'];?>
:数量:<?php echo $_smarty_tpl->tpl_vars['r']->value['ready'];?>

						<?php }} ?>
					<?php }else{ ?>
					<img src="/style/check_error.gif">
					<?php }?>
					</td>
				</tr>
				
			</table>
			<!-- server连接状态 -->
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="8" class="bg_main"><span id="list_server"></span></td>
				</tr>
				<tr>
					<td colspan="8"><span id="server_count"></span>&nbsp;&nbsp;<span id="serial_number"></span></td>
				</tr>
				<tr>
					<td>节点</td>
					<td>IP</td>
					<td>序列号</td>
					<td>sync</td>
					<td>连接时间</td>
					<td>版本</td>
					<td>状态</td>
				</tr>
				<tbody id="list_server_node">
				</tbody>
			</table>
			<?php  $_smarty_tpl->tpl_vars['rows'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['servername'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('slave')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rows']->key => $_smarty_tpl->tpl_vars['rows']->value){
 $_smarty_tpl->tpl_vars['servername']->value = $_smarty_tpl->tpl_vars['rows']->key;
?>
			<table class="table_main2" cellpadding="0" cellspacing="1">

				<tr>
					<td colspan="7" class="bg_main">

						<table width='100%'>
							<tr>
								<td class="bg_main"><?php echo $_smarty_tpl->tpl_vars['servername']->value;?>
辅节点信息
									序列号<?php echo $_smarty_tpl->tpl_vars['rows']->value['serial'];?>
&nbsp;引用:<?php echo $_smarty_tpl->tpl_vars['rows']->value['refs'];?>
</td>
								<td class="bg_main">

									<form action='?c=index&a=addSlave&server=<?php echo $_smarty_tpl->tpl_vars['servername']->value;?>
'
										method="POST">
										服务器IP:<input name="ip" /> <input type="submit" value="增加">
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php if (is_array($_smarty_tpl->tpl_vars['rows']->value)&&isset($_smarty_tpl->tpl_vars['rows']->value['server'])){?>
				<tr>
					<td>name</td>
					<td>ssl</td>
					<td>IP</td>
					<td>版本</td>
					<td>序列号</td>
					<td>已连时间</td>
					<td>状态</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rows']->value['server']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['peer'];?>
</td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['ssl']==1){?><img src="/style/check_right.gif"><?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['ip'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['version'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['serial'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
</td>
					<td><img
						src="/style/check_<?php if ($_smarty_tpl->tpl_vars['row']->value['connect']==1){?>right.gif<?php }else{ ?>error.gif<?php }?>">
						<a
						href="?c=index&a=rebuildSlave&ip=<?php echo $_smarty_tpl->tpl_vars['row']->value['peer'];?>
&server=<?php echo $_smarty_tpl->tpl_vars['servername']->value;?>
">重建</a>
						<a
						href="javascript:del_slave('<?php echo $_smarty_tpl->tpl_vars['row']->value['peer'];?>
','<?php echo $_smarty_tpl->tpl_vars['servername']->value;?>
',0)">删除</a>
						<a
						href="javascript:del_slave('<?php echo $_smarty_tpl->tpl_vars['row']->value['peer'];?>
','<?php echo $_smarty_tpl->tpl_vars['servername']->value;?>
',1)">删除数据</a>
					</td>
				</tr>
				<?php }} ?> <?php }else{ ?>
				<tr>
					<td colspan='5'><?php if ($_smarty_tpl->tpl_vars['rows']->value['result']){?>result=<?php echo $_smarty_tpl->tpl_vars['rows']->value['result'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['rows']->value;?>
<?php }?></td>
				</tr>
				<?php }?>
			</table>
			<?php }} ?>
		</div>
	</div>
	<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>