<?php /* Smarty version Smarty-3.0.5, created on 2015-10-23 23:54:52
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/groupview/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:1417495603562a584cba4b23-46232407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd8b0fc330a1e5bc0c37961e02906dc7aa31ab17' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/groupview/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1417495603562a584cba4b23-46232407',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<script type="text/template" id="piao-add-groupview-template">
<div id="add-groupview-div">
	<div><img src="/style/dot.gif">uid为0表示管理员</div>
	<p>组 id :<input name="id" id="line_id"></p>
	<p>名 称 :<input name="name" id="line_name"></p>
	<p>u i d :<input name="uid" value="0" id="line_uid"></p>
	<p>server:<input name="server" id="line_server" value={{server}}></p>
	<p><input type="button" id="enter" value="提交"></p>
</div>
</script>
<script type="text/template" id="piao-edit-groupview-template">
<div id="edit-groupview-div">
	<p>线路组名称:<input name="name" id="edit_name" value={{name}}>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;server:<input name="server" id="edit_server" value={{server}}></p>
	<input type="button" id="enter" value="提交"></p>
	</form>
</div>
</script>
<script type="text/template" id="piao-add-view-template">
<div id="add-view-div">
	<form action="?c=views&a=add&group_name={{groupid}}" method="post">
		<p>线路名称:</p><p><input name="name" placeholder="如:电信"></p>
		<p>IP段,一行一个,例:192.168.1.0/8:</p><p><textarea rows=5 cols=65 name="ips"></textarea></p>
		<p><input type="submit" value="提交"></p>
	</form>
</div>
</script>
<script type='text/javascript'>
	$(document).ready(function() {
		
	});
	var default_verver = '<?php echo $_smarty_tpl->getVariable('server')->value;?>
';
	function del_lines(id) {
		if (!confirm('确定要删除? 这将对所有已解析的域名产生影响.')) {
			return;
		}
		ajax('?c=groupview&a=del', 'id=' + id);
	}
	var dia;
	function piao_add_groupview()
	{
		var template = $("#piao-add-groupview-template").html();
		var option = [];
		option.server = default_verver;
		var el = Mustache.to_html(template,option);
		dia = art.dialog({id : 'id22',content : el,title : '增加线路组',lock:true});
		var div = $("#add-groupview-div");
		div.find('#enter').bind('click',function(){
			add_groupview();
		});
	}
	function add_groupview()
	{
		var id = $("#line_id").val();
		var uid = $("#line_uid").val();
		var name = $("#line_name").val();
		var server = $("#line_server").val();
		if (!id || !name) {
			alert('组id和名称不能为空');
			return ;
		}
		dia.content('正在执行中...');
		$.ajax({
			url:'?c=groupview&a=add',
			data:{name:name,id:id,uid:uid,server:server},
			dataType:'json',
			success:function(a) {
				dia.close();
				if (a.code != 200)  {
					alert(a.message);
					return ;
				}
				window.location = '?c=groupview&a=pagelist';
			},
			error:function(e) {
				dia.close();
				alert('后台数据出错'+e.responseText);
			}
		});
		
	}
	function piao_edit_groupview(id)
	{
		$.ajax({url:'?c=groupview&a=getById&id='+id,dataType:'json',success:function(ret) {
			var template = $("#piao-edit-groupview-template").html();
			var option = [];
			option.name = ret['info']['name'];
			option.server = ret['info']['server'];
			var el = Mustache.to_html(template,option);
			dia = art.dialog({id:'view_edit',content:el,title:'修改线路组名称'});
			var div = $("#edit-groupview-div");
			div.find("#enter").bind('click',function(){
				edit_groupview(id);
			});
		}});
	}
	function edit_groupview(id)
	{
		var name = $("#edit_name").val();
		var server = $("#edit_server").val();
		if (!name || !server) {
			alert('线路组和server不能为空');
			return ;
		}
		dia.content('正在执行...');
		$.ajax({
			url:'?c=groupview&a=edit',
			data:{id:id,name:name,server:server},
			dataType:'json',
			success:function(a) {
				dia.close();
				if (a.code != 200) {
					alert(a.message);
					return ;
				}
				window.location = '?c=groupview&a=pagelist';
			},
			error:function(e) {
				dia.close();
				alert('后台数据出错'+e.responseText);

			}			
		});
	}
	function piao_add_view(groupid)
	{
		var template = $("#piao-add-view-template").html();
		var option = [];
		option.groupid = groupid;
		var el = Mustache.to_html(template,option);
		var dia = art.dialog({id:'add_view'});
		dia.content(el);
	}
	function piao_import_ips(gvid)
	{
		var template = $("#import-ip-template").html();
		var option = [];
		option.group_name = gvid;
		var el = Mustache.to_html(template,option);
		dia = art.dialog({id:'piao-import-ip',content:el,lock:true});
		var div = $("#import-ip");
		div.find("[name=ips]").trigger('focus');
		div.find('#enter').bind({
			'click':function() {
				//import_ips(div.find('[name=ips]').val(),gvid,div.find('[name=zh]:checked').val(),div.find('[name=merger]:checked').val())
				showLineSplit(div,gvid)
				}
		});
	}
	function showLineSplit(div,gvid)
	{
		var zh = div.find('[name=zh]:checked').val();
		var url = '?c=views&a=getState';
		if (zh!=0) {
			url = '?c=views&a=getProvince';
		}
		$.ajax({
			url:url,
			dataType:'json'
		}).done(function(a) {
			var rows = 22;
			var line_str = a.state
			if (zh!=0) {
				rows = 5;
				line_str = a.province;
			}
			var html = "将增加以下线路:<textarea rows="+rows + " cols=70 name='line_str'>"+line_str + "</textarea>";
			$("#line-show-div").html(html);
			div.find("#enter").unbind();
			$.ajax({
				url:'?c=views&a=getIpFile',
				dataType:'json'
			}).done(function(a){
				var html = '使用IP库文件:<select name="filename">';
				for ( var i in a.list) {
					html += '<option value='+a.list[i] + '>'+a.list[i] + '</option>';
				}
				html += '</select>';
				$("#line-show-file-div").html(html);
				div.find('#enter').bind("click",function(){
					import_ips(div,gvid);
				});
			}).fail(function(e) {
				
			});
		}).fail(function(e) {
			
		});
	}
	var list = [];
	//ips_string,gvid,checkzh
	function import_ips(div,gvid)
	{
		list.length = 0;
		errormsg = '';
		var line_str = div.find('[name=line_str]').val();
		var lines = line_str.split(',');
		if (lines.length ==0) {
			alert('导入线路名称不能为空');
			return;
		}
		var filename = div.find('[name=filename]').val()
		for ( var i in lines) {
			var row = {line:lines[i],gvid:gvid,filename:filename};
			list.push(row);
		}
		$("#import-ip").find('#enter,#esc').text('正在执行').attr('disabled','disabled');
		deferredImportIps(0,div);
	}
	var errormsg = '';
	function deferredImportIps(key,div)
	{
		if (key == list.length) {
			if (errormsg != '') {
				dia.content("<textarea rows=5 cols=50 >"+ errormsg+"</textarea>");
			}else {
				var message = '成功导入'+list.length + '条线路';
				dia.content(message);
			}
			return;
		}
		importOne(key,div);
	}
	function importOne(key,div)
	{
		var row = list[key];
		var line = row.line;
		var gvid = row.gvid;
		var filename = row.filename;
		var diff = parseInt(list.length) - parseInt(key);
		div.html('正在导入第' + key + '条线路('+ line + ")还有" + diff + "条线路需要导入 <img src='/style/busy.gif'><br>");
		$.ajax({
			url:'?c=views&a=import',
			type:"POST",
			data:{line:line,group_name:gvid,filename:filename},
			dataType:'json',
			success:function(a) {
				if (a.status.code != 1) {
					errormsg += a.status.message +"\n<br>";
				}
				deferredImportIps(key+1,div);
			},
			error:function(e) {
				errormsg += line+"后台数据出错<br>";
				deferredImportIps(key+1,div);
			}
		});
	}
	function piao_empty_view(gvid)
	{
		if (confirm("确定要清空该线路组下所有线路吗")=== false) {
			return;
		}
		dia = art.dialog({id:'piao_empty_view',content:'正在执行中...',lock:true});
		$.ajax({
			url:"?c=groupview&a=clearView",
			data:{group_name:gvid},
			dataType:'json',
			success:function(a){
				dia.content('清除'+a.count+'条线路');
				dia.time(2);
			},
			error:function(e) {
				dia.close();
				alert(e.responseText);
			}
		}); 
	}
	function piao_importout_ips(gvid)
	{
		var template = $("#importout-ip-template").html();
		dia = art.dialog({id:'piao_importout_ip',content:template,top:'10%',lock:true});
		var div = $("#importout-ip");
		div.find("#esc").bind('click',function(){
			dia.close();
		});
		div.find('#enter').bind('click',function(){
			importout_ips(gvid,div.find('[name=searchname]').val());	
		});
		div.find('[name=searchname]').trigger('focus');
	}
	function importout_ips(gvid,searchname)
	{
		$.ajax({
			url:'?c=groupview&a=importout',
			data:{group_name:gvid,searchname:searchname},
			dataType:'json',
			success:function(a) {
				var content = '总记录数 '+a.count +' <br>';
				content += '合并记录数 '+a.searchcount + ' <br>';
				content += '<textarea rows="20" cols="50">'+ a.ips + '</textarea>';
				dia.content(content);
			},
			error:function(e) {
				alert(e.responseText);
			}
		});
	}
	function piao_import_ips_file(gvid)
	{
		var template = $("#import-ip-file-template").html();
		var el = Mustache.to_html(template,{gvid:gvid});
		dia = art.dialog({lock:true,content:el});
	}
</script>
<script type='text/template' id="import-ip-template">
<div id="import-ip">
	<div class="piao_div">线路组:<big>{{group_name}}</big></div>
	<div class="piao_div" id="line-split-div">线路区分:<input type='radio' name="zh" value=1 checked>国内分省<input type='radio' name="zh" value=0>全球国家</div>
	<div class="piao_div" id="line-show-div"></div>
	<div class="piao_div" id="line-show-file-div"></div>
	<!--
	
	<div class="piao_div">ip库txt:<textarea rows="20" cols="50" name="ips"></textarea></div>
	-->
	<div class="piao_div"><span class="pull-right" style="margin-right:160px;"><button class="btn" id="enter">确定</button></span></div>
</div>
</script>
<script type='text/template' id="importout-ip-template">
<div id="importout-ip">
	<div class="piao_div">导出线路关键字:<input type='text' name="searchname" > </div>
	<div class="piao_div"><span class="pull-right" style="margin-right:160px;"><button class="btn" id="enter">导出</button></span></div>
</div>
</script>
<script type='text/template' id="import-ip-file-template">
<div id="importout-ip">
	<div class="piao_div">
	<form action="?c=groupview&a=importIpsFile" method="post" enctype="multipart/form-data">
	<input type='hidden' name="gvid" value="{{gvid}}">
	请选择IP库文件:<input type='file' name="file" ><input type='submit' value="导入" class="btn"> 
	</form>
	</div>
</div>
</script>

	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：线路组 --> 列表</div>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="7" class="bg_main">[<a href='javascript:;piao_add_groupview()'><b>增加线路组</b></a>]</td>
				</tr>
				<tr id="bg_yellow">
					<td>操作</td>
					<td>线路组ID</td>
					<td>名称</td>
					<td>server</td>
					<td>用户ID</td>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr class='view_edit_tr' id='<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
'>
					<td>
					[<a href="javascript:del_lines('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">删除</a>]
					[<a href="javascript:piao_edit_groupview('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">修改</a>]
					<!-- [<a href="javascript:piao_add_view('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">增加线路</a>]
					[<a href="javascript:piao_import_ips('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">导入线路</a>] -->
					[<a href="javascript:piao_import_ips_file('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">文件导入</a>]
					<!--  [<a href="javascript:piao_importout_ips('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">导出</a>]-->
					</td>
					<td class="wid_general" title='<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php if ($_smarty_tpl->tpl_vars['row']->value['server']=='v'){?>[<a href="javascript:piao_empty_view('<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
')">清空线路</a>]<?php }?></td>
					<td class="wid_general" ><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
					<td class="wid_general" ><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['uid'];?>
</td>
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
