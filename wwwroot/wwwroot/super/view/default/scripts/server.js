function edit_allowpid(name)
{
	var div = $("#edit-allowpid-div");
	var pidstr = '';
	div.find('[name=pid]:checked').each(function(){
		if (pidstr != '') {
			pidstr += ',';
		}
		pidstr += $(this).val();
	});
	$.ajax({
		url:'?c=server&a=setAllowbuypid',
		data:{name:name,pid:pidstr},
		dataType:'json',
		success:function(a) {
			if (a.status.code != 1) {
				alert(a.status.message);
				return;
			}
			window.location = '?c=server&a=pagelist';
		},
		error:function(e) {
			
		}
	});
}
function piao_edit_allowpid(name,allowpid)
{
	allowpid = allowpid ? allowpid.split(',') : '';
	$.ajax({
		url:'?c=product&a=getListName',
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.message);
				return;
			}
			var template = $("#edit-allowpid-template").html();
			var option = [];
			option.pid_radio_html = create_edit_allowpid_html(a.rows,allowpid);
			option.name = name;
			var el = Mustache.to_html(template,option);
			dia = art.dialog({id:'piao_edit_allowpid',content:el,top:'10%',lock:true});
			var div = $("#edit-allowpid-div");
			div.find('#esc').bind('click',function(){
				dia.close();
			});
			div.find('#enter').bind('click',function(){
				edit_allowpid(name);
			});
		},
		error:function(e) {
			
		}
	});
}
function create_edit_allowpid_html(plist,allowpid)
{
	var html = '';
	var c = 0;
	for ( var i in plist) {
		if (c%4==0 || c==0) {
			html += '<div class="piao_div">';
		}
		html +='<input type="checkbox" name="pid" value="'+i + '"';
		if (allowpid) {
			for (var p in allowpid) {
				if (allowpid[p] == i) {
					html += ' checked';
				}
			}
		}
		html += '>'+ plist[i] ;
		if ((c%4==0 && c!=0)) {
			html += '</div>';
		}
		c++;
	}
	return html;
}
function piao_add_server()
{
	var template = $("#piao-add-server-template").html();
	dia = art.dialog({id:'piao_add_server',lock:true,title:'增加server',content:template});
	var div = $("#add-server-div");
	div.find("#enter").bind('click',function(){
		add_server();
	});
}
function add_server()
{
	var name = $("#add_server_name").val();
	var skey = $("#add_server_skey").val();
	if (!name || !skey) {
		alert('名字和skey不能为空');
		return ;
	}
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=server&a=add',
		data:{name:name,skey:skey},
		dataType:'json',
		async:false,
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			window.location = '?c=server&a=pagelist';
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piao_del_server(name)
{
	var template = $("#piao-del-server-template").html();
	var option = [];
	option.name = name;
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_del_server',content:el,lock:true});
	var div = $("#del-server-div");
	div.find("#enter").bind('click',function(){
		del_server(name);
	});
	div.find("#enterDia").bind('click',function(){
		dia.close();
	});
}
function del_server(name)
{
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=server&a=del',
		data:{name:name},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			window.location = '?c=server&a=pagelist';
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piao_edit_passwd(name)
{
	var template = $("#piao-edit-passwd-template").html();
	dia = art.dialog({id:'edit_passwd',lock:true,title:'修改密码',content:template});
	$("#piao_edit_passwd").trigger('focus');
	var div = $("#edit-passwd-div");
	div.find("#enter").bind('click',function(){
		edit_passwd(name);
	});
}
function edit_passwd(name)
{
	var passwd = $.trim($("#piao_edit_passwd").val());
	if (!passwd) {
		alert('新密码不能为空');
		return ;
	}
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=server&a=editPasswd',
		data:{name:name,passwd:passwd},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			show_success();
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function show_success()
{
	$("#show_msg").html('操作执行成功');
	setTimeout(function(){
		$("#show_msg").html("");
	},4000);
}
function piao_edit_pid(name,pid)
{
	var html = '';
	$.ajax({
		url:'?c=product&a=getListName',
		dataType:'json',
		async:false,
		success:function(a) {
			html += '选择产品:<select name="pid" id="edit_pid">';
			for ( var i in a.rows) {
				html += '<option value='+i;
				if (i==pid) {
					html += ' selected ';
				}
				html += '>'+ a.rows[i] + '</option>';
			}
			html += '</select>';
			html += '<input type="button" value="修改" onclick="edit_pid(\''+name+'\')"/>';
		},
		error:function(e) {
			
		}
	});
	dia = art.dialog({id:'piao_edit_pid',lock:true,title:'修改server产品',content:html});
}
function edit_pid(name)
{
	var newpid = $("#edit_pid").val();
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=server&a=editPid',
		dataType:'json',
		data:{name:name,pid:newpid},
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			window.location = '?c=server&a=pagelist';
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function switch_server(name)
{
	$.ajax({
		url:'?c=server&a=switchLogin&server='+name,
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			$("#show_msg").html(a.message);
		},
		error:function(e) {
		}
	});	
}
function piao_remark(name)
{
	
	$.ajax({
		url:'?c=server&a=getInfo',
		data:{name:name},
		dataType:'json',
		success:function(a) {
			var template = $("#piao-remark-template").html();
			var option = [];
			option.remark = a.info.remark;
			var el = Mustache.to_html(template,option);
			dia = art.dialog({id:'dia_remark',content:el,title:'添加备注',lock:true});
			var div = $("#piao-remark-div");
			div.find("#enter").bind('click',function(){
				remark(name);
			});
		},
		error:function(e) {
			
		}
	});
}
function remark(name)
{
	var remark = $("#piao_remark").val();
	$.ajax({
		url:'?c=server&a=remark',
		data:{name:name,remark:remark},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			window.location = '?c=server&a=pagelist';
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
/*
function piao_edit_soa(name,soa)
{
	var html = '';
		html += '新的SOA:<input id="piao_soa" size=64 value="'+soa+'"><input type="button" class="btn" onclick="edit_soa(\''+name+'\')" value="修改">';
		art.dialog({id:'piao_edit_soa',content:html,lock:true});
}
function edit_soa(name)
{
	var newsoa = $("#piao_soa").val();
	
	myAjax('?c=server&a=editSoa',{name:name,soa:newsoa},function(a){
		if (a.code != 200) {
				alert(a.message);
				return ;
			}
			window.location = '?c=server&a=pagelist';
	});
}
function show_groupview_select()
{
	$.ajax({
		url:'?c=groupview&a=lists',
		dataType:'json',
		success:function(a) {
			var html = '线路组:<select name="groupview" id="add_server_groupview">';
			for ( var i in a.list) {
				html += '<option value='+a.list[i]['id'] + '>'+a.list[i]['name']+'</option>';
			}
			html +='</select>';
			$("#show_groupview_select").html(html);
		},
		error:function(e) {
		}
	});
}
function show_pid_select()
{
	$.ajax({
		url:'?c=product&a=getListName',
		dataType:'json',
		success:function(a) {
			var html = '默认产品:<select name="pid" id="add_server_pid">';
				for ( var i in a.rows) {
					html += '<option value='+i + '>'+a.rows[i]+'</option>';
				}
				html +='</select>';
				$("#show_pid_select").html(html);
		},
		error:function(e) {
		}
	});
}
*/