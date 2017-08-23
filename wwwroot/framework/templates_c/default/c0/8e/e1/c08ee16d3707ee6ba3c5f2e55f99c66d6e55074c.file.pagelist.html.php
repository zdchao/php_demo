<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 20:26:31
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/views/pagelist.html" */ ?>
<?php /*%%SmartyHeaderCode:135641021055f6bcf7b8a861-31294077%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c08ee16d3707ee6ba3c5f2e55f99c66d6e55074c' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/views/pagelist.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135641021055f6bcf7b8a861-31294077',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<script type="text/template" id="piao-add-lines-template">
<div id="add-lines-div">
	<form action="?c=views&a=add" method="post">
		<p>线路组:</p><p id="group_id"></p>
		<p>中文名称:</p><p><input name="name" placeholder="如:电信"></p>
		<p>IP段,一行一个,例:192.168.1.0/8:</p><p><textarea rows=5 cols=65 name="ips"></textarea></p>
		<p><input type="submit" value="提交"></p>
	</form>
<div>
</script>
<script type='text/javascript'>
	$(document).ready(function() {
		var msg = '<?php echo $_smarty_tpl->getVariable('msg')->value;?>
';
		var success = '<?php echo $_smarty_tpl->getVariable('success')->value;?>
';
		if (msg != '') {
			if (success != '') {
				art.dialog({id : '222',	content : msg,title : '提示',time : 2,icon : 'succeed'});
			} else {
				art.dialog({id : '222',content : msg,title : '提示',time : 2,icon : 'error'});
			}
		}
	});
	function del_lines(id,group_name,server) 
	{
		if (!confirm('确定要删除? 这将对所有已解析的域名产生影响.')) {
			return;
		}
		ajax('?c=views&a=del', 'id=' + id + '&group_name='+group_name + '&server='+ server);
	}
	var groupview = [];
	function piao_add_lines() 
	{
		getGroupList();
		$.ajax({
			url : '?c=views&a=get',
			dataType : 'json',
			success : function(ret) {
				var html = $("#piao-add-lines-template").html();
				art.dialog({
					id : 'id22',
					content : html,
					title : '增加线路',
					icon : ''
				});
				
				if (groupview.length > 0) {
					var html = getGroupviewHtml();
				}else {
					html = '<input name="group_name"><b class="red">警告:未添加线路组</b>';
				}
				$("#group_id").html(html);
			}
		});
	}
	function ip_version_change() {
		if (confirm("确定要对IP的版本进行升级?请确认IP已经变更.") === false) {
			return;
		}
		$.ajax({
			url : '?c=views&a=change_ip_version',
			dataType : 'json',
			success : function(ret) {
				if (ret['code'] != 200) {
					alert(ret['msg']);
				}
				setTimeout(function(){
					window.location = window.location;
				},2000);
			}
		});
	}
	function piao_edit(id,server,groupname)
	{
		$.ajax({url:'?c=views&a=getById&id='+id+'&groupname='+groupname ,dataType:'json',success:function(ret) {
			var html = '<form action="?c=views&a=editParent&id='+ id  + '&server='+server + '" method="post"> ';
				html += '<p>上级线路:<select name="parent">';
				for (var i in ret['views']) {
					if (ret['views'][i]['id']==id) {
						continue;
					}
					html += '<option value='+ret['views'][i]['id'] ;
					if (ret['info']['parent'] == ret['views'][i]['id']) {
						html += ' selected ';
					}
					html +=  '>'+ ret['views'][i]['name']+ '</option>';
				}
				html += '</select></p>';
				html += '<p>线路名称:<input name="name" value="'+ ret['info']['name'] + '"></p>';
				html += '<input name="group_name" type="hidden" value="'+ ret['info']['group_name'] + '">';
				html += '<p><input type="submit" value="提交"></p>';
				html += '</form>';
				art.dialog({id:'view_edit',content:html,title:'修改线路'});
		}});
	}
	function piao_edit_ips(id)
	{
		$.ajax({url:'?c=views&a=getInfo&id='+id, dataType:'json',success:function(ret) {
			if (ret['code']  != 200) {
				alert('获取信息有误，请检查');
				return;
			}
			var html = '<form action="?c=views&a=editIps&id='+ id + '&group_name=' + ret['info']['group_name'] + '&server=' + ret['info']['server'] + '" method="post"> ';
				html += '<p>IP段:<textarea rows=25 cols=65 name="ips">'+ret['info']['ips']+'</textarea>';
				html += '<p><input type="submit" value="提交"></p>';
				html += '</form>';
				art.dialog({id:'view_edit',content:html,title:'更新IP段'});
		}
		});
	}
	
	function getGroupList()
	{
		if (groupview.length > 0) {
			return ;
		}
		$.ajax({
			url:'?c=groupview&a=lists',
			dataType:'json',
			async:false,
			success:function(ret){
				if (ret.count > 0) {
					groupview = ret.list;
				}
			} 
		});
	}
	function getGroupviewHtml()
	{
		var html = '<select name="group_name">';
		for ( var i in groupview) {
			html += '<option value="'+ groupview[i]['id']+ '">'+groupview[i]['name']+'</option>';
		}
		html += '</select>';
		return html;
	}
	function piao_import_line()
	{
		getGroupList();
		var template = $("#import-line-template").html();
		var option = [];
		option.groupviewhtml = getGroupviewHtml();
		var el = Mustache.to_html(template,option);
		dia = art.dialog({id:'piao_import_line',content:el,lock:true,top:'10%',title:'增加线路',width:'660px'});
		var div = $("#piao-import-line");
		div.find('#esc').bind('click',function(){
			dia.close();
		});
		div.find('#enter').bind('click',function(){
			import_line();
		});
		div.find('[name=linename]').trigger('focus');
	}
	function import_line()
	{
		var div = $("#piao-import-line");
		var linename = div.find('[name=linename]').val();
		var group_name = div.find('[name=group_name]').val();
		var ips_string = div.find('[name=ips]').val();
		var searchname = div.find('[name=searchname]').val();
		if (!linename || !group_name || !searchname) {
			alert('请检查是否还有必填的项目未输入');
			return;
		}
		if (ips_string) {
			var rows = ips_string.split("\n");
			var line = 'add';
			var ips = '';
			$("#button").find('#enter,#esc').text('正在执行').attr('disabled','disabled');
			for ( var i in rows) {
				//是线路名称
				if (rows[i].substr(0,1)=='*') {
					if (rows[i].indexOf(searchname) >= 0 ) {
						line = 'add';	
					}else {
						line = 'del';
					}
				}else {//是ip段
					if (line=='add') {
						if ($.trim(rows[i])!='') {
							ips += rows[i] + "\n";
						}
					}
				}
			}
			addLine(linename,group_name,ips);
		}else {
			//没有库txt
			var filename = div.find("[name=filename]").val();
			if (!filename) {
				alert("没有选择ip库文件");
				return;
			}
			$.ajax({
				url:"?c=views&a=getSearchIps",
				data:{filename:filename,searchname:searchname},
				dataType:'json'
			}).done(function(a) {
				if (a.status.code != 1) {
					alert(a.status.message);
					return;
				}
				//addLine(linename,group_name,a.ips);
				var ips = a.ips.replace("\r\n\n","\n");
				ips = ips.replace("\r\n","\n");
				ips = ips.replace("\n\n","\n");
				var html = '<div class="piao_div" id="ip-txt-div"><span class="piao_left">IP库txt:</span><span class="piao_right"><textarea name="ips" cols="40" rows="16">'+ips+'</textarea></span></div>'
				div.find("#ip-select-div").append(html);
				
			}).fail(function(e) {
				alert('后端数据出错');
			});
		}
	}
	function addLine(linename,group_name,ips)
	{
		var template = $("#import-addline-template").html();
		var option = [];
		option.name = linename;
		option.group_id = group_name;
		option.ips = ips;
		var el = Mustache.to_html(template,option);
		var div = $("#piao-import-line");
		div.html(el);
		import_add_line.submit();
	}
	var ip_files = null;
	function getIpFiles()
	{
		$("#ip-txt-div").remove();
		$.ajax({
			url:'?c=views&a=getIpFile',
			dataType:'json'
		}).done(function(a){
			if (a.list.length ==0) {
				alert('获取所有ip文件失败');
				return;
			}
			ip_files = a.list;
			var html = createIpFileSelect(ip_files);
			$("#add-span").html(html);
		}).fail(function(e){
			alert('后端数据出错');
		});
	}
	function createIpFileSelect(rows)
	{
		var html = '<select name="filename">';
		for (var i in rows) {
			html += '<option value="'+rows[i] + '">'+rows[i] + '</option>';
		}
		html += '</select>';
		return html;
	}
	function cerateZhCitySelect()
	{
		var str = "北京,天津,上海,重庆,河北,河南,云南,辽宁,黑龙江,湖南,安徽,山东,新疆,江苏,浙江,江西,湖北,广西,甘肃,山西,内蒙,陕西,吉林,福建,贵州,广东,青海,西藏,四川,宁夏,海南,台湾,香港,澳门"
		var rows = str.split(',');
		var html = '<select name="linename">';
		for ( var i in rows) {
			html += "<option value='"+rows[i] + "'>"+rows[i] + '</option>';
		}
		html += '</select>';
		var div = $("#piao-import-line");
		div.find('#linename-span').html(html);
		div.find("[name=searchname]").val(div.find("[name=linename]").val());
		div.find('[name=linename]').bind('change',function(){
			div.find("[name=searchname]").val(div.find("[name=linename]").val());
		});
	}
</script>
<script type='text/template' id="import-addline-template">
	<div id="import-addline">
		<form action="?c=views&a=add" method="post" name="import_add_line">
		<input name="name" value="{{name}}" type='hidden'>
		<input name="group_name" value="{{group_id}}" type='hidden'>
		<input name="ips" type='hidden' value='{{ips}}'>
		<div >正在执行中....</div>
	</div>
</script>
<script type='text/template' id="import-line-template">
	<div id="piao-import-line">
		<div class="piao_div">本操作可以将ip库txt里的数据，按照搜索名称将所有搜索到的IP合并为一个线路</div>
		<div class="piao_div">
			<span class="piao_left">线路组:</span>
			<span class="piao_right" id="linegroup">{{{groupviewhtml}}}</span>
		</div>
		<div class="piao_div">
			<span class="piao_left">线路名:</span>
			<span class="" id="linename-span"><input type="text" name="linename" placeholder="增加的线路名,如:中国">*&nbsp;<a href="javascript:cerateZhCitySelect()">选择省份</a></span>
		</div>
		<div class="piao_div">
			<span class="piao_left">搜索名称:</span>
			<span class=""><input type="text" name="searchname">*</span>
		</div>

		<div class="piao_div" id="ip-select-div">
			<span class="piao_left">使用ip库文件:</span>
			<span class="" id="add-span"><a href="javascript:getIpFiles()">查看文件</a></span>
		</div>
		
		<div class="piao_div" id="ip-txt-div">
			<span class="piao_left">IP库txt:</span>
			<span class="piao_right"><textarea name="ips" cols="40" rows="16"></textarea></span>
		</div>
		<div class="piao_div">
			<span class="piao_left">&nbsp;</span>
			<span class="piao_right" id="button"><button id="enter" class="btn">确定</button></span>
		</div>
	</div>
</script>
	<div align="center">
		<div class="wid_main mar_main" align="left">
			<div class="block_top" align="left">当前位置：解析线路 --> 列表</div>
			<table class="table_main2" cellpadding="0" cellspacing="1">
				<tr>
					<td colspan="7" class="bg_main">
						<a href="javascript:;" onclick="piao_add_lines()" target='main'><b>[增加线路]</b></a>
						<!--  <a href="javascript:;" onclick="piao_import_line()" target='main'><b>[导入线路]</b></a>-->
					</td>
				</tr>
				<tr id="bg_yellow">
					<td>操作</td>
					<td>线路ID</td>
					<td>线路组</td>
					<td>server</td>
					<td>上层线路</td>
					<td>线路名称</td>
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
','<?php echo $_smarty_tpl->tpl_vars['row']->value['group_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
')">删除</a>]
					[<a href="javascript:piao_edit(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['group_name'];?>
')">修改</a>]
					[<a href="javascript:piao_edit_ips(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
)">修改IP段</a>]
					</td>
					<td class="wid_general"><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['group_name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['server'];?>
</td>
					<td <?php if ($_smarty_tpl->tpl_vars['row']->value['id']!=0){?>class="view_row"<?php }?>><?php echo $_smarty_tpl->tpl_vars['row']->value['parent'];?>
</td>
					<td class="wid_general"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
				</tr>
				<?php }} ?>
				<tr>
					<td colspan="7" id="bg_yellow" align="right"><?php if ($_smarty_tpl->getVariable('page')->value>1){?> <a
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
