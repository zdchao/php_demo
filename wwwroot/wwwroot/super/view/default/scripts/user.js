function ns(){
	this.server = "";
	this.nslist = [];
	this.editUserNs = function(userId,server){
		var that = this;
		that.server = server;
		//alert(userId+'--'+server);
		$.ajax({
			url:'?c=ns&a=getServerNs',
			data:{server:server},
			dataType:'json',
			success:function(a){
				that.nslist = a.list;
				that.showNs(that.nslist,userId);
			},
			error:function(a){
				alert('error');
			}
		});
	}
	this.showNs = function(nslist,userId){
		var that = this;
		var template = $("#piao-edit-user-ns-template").html();
		var option = [];
		option.ns1 = that.createSelect(nslist,"ns1id",0,16);
		option.ns2 = that.createSelect(nslist,"ns2id",1,17);
		var el = Mustache.to_html(template,option);
		dia = art.dialog({id:'edituserns',title:'修改ns',content:el,lock:true,width:350});
		var div = $("#div-edit-user-ns-template");
		div.find("#enter").bind('click',function(){
			var ns1id = div.find("[name=ns1id]").val();
			var ns2id = div.find("[name=ns2id]").val();
			that.updateNs(userId,ns1id,ns2id);
			dia.close();
		});
		div.find("#esc").bind('click',function(){
			dia.close();
		});
	}
	this.createSelect = function(nslist,nsid,nstype1,nstype2){
		var length = nslist.length;
		var selectHtml = "<select id='"+nsid+"' name='"+nsid+"' style='width:200px;height:35px;'>";
		selectHtml += "<option value='0'>无</option>";
		for(var i=0;i<length;i++){
			if(nslist[i]['type'] == nstype1 || nslist[i]['type'] == nstype2){
				selectHtml += "<option value='"+nslist[i]['id']+"'>"+nslist[i]['name']+"</option>";
			}
		}
		selectHtml +="</select>";
		return selectHtml;
	}
	this.updateNs = function(userId,ns1id,ns2id){
		var that = this;
		$.ajax({
			url:'?c=users&a=editNs',
			data:{userId:userId,ns1id:ns1id,ns2id:ns2id},
			dataType:'json',
			success:function(a){
				if(a.status.code != 1){
					return;
				}
				var html = "[<a href='javascript:;' onclick=\"ns.editUserNs("+userId+",'"+that.server+"')\">"+ns1id+"</a>]";
				$("#tr"+userId).find("#ns1id"+userId).html(html);
				$("#tr"+userId).find("#ns2id"+userId).html(ns2id);
			},
			error:function(a){
				alert('error');
			}
		});
	}
}
var ns = new ns();
//设置用户ns
/*
var serverName = '';
function editUserNs(userId,server){
	serverName = server;
	var nslist = [];
	$.ajax({
		url:'?c=ns&a=getServerNs',
		data:{server:server},
		dataType:'json',
		success:function(a){
			nslist = a.list;
			showNs(nslist,userId);
		},
		error:function(a){
			alert('error');
		}
	});
}
function createSelect(nslist,nsid,nstype){
	var length = nslist.length;
	var selectHtml = "<select id='"+nsid+"' name='"+nsid+"' style='width:200px;'>";
	selectHtml += "<option value='0'>无</option>";
	for(var i=0;i<length;i++){
		if(nslist[i]['type'] % 2 == nstype){
			selectHtml += "<option value='"+nslist[i]['id']+"'>"+nslist[i]['name']+"</option>";
		}
	}
	selectHtml +="</select>";
	return selectHtml;
}
function showNs(nslist,userId){
	var template = $("#piao-edit-user-ns-template").html();
	var option = [];
	option.ns1 = createSelect(nslist,"ns1id",0);
	option.ns2 = createSelect(nslist,"ns2id",1);
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'edituserns',title:'修改ns',content:el,lock:true});
	var div = $("#div-edit-user-ns-template");
	div.find("#enter").bind('click',function(){
		var ns1id = div.find("[name=ns1id]").val();
		var ns2id = div.find("[name=ns2id]").val();
		updateNs(userId,ns1id,ns2id);
		dia.close();
	});
	div.find("#esc").bind('click',function(){
		dia.close();
	});
}
function updateNs(userId,ns1id,ns2id){
	$.ajax({
		url:'?c=users&a=editNs',
		data:{userId:userId,ns1id:ns1id,ns2id:ns2id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				return;
			}
			var html = "[<a href='javascript:;' onclick=\"editUserNs("+userId+",'"+serverName+"')\">"+ns1id+"</a>]";
			$("#tr"+userId).find("#ns1id"+userId).html(html);
			$("#tr"+userId).find("#ns2id"+userId).html(ns2id);
		},
		error:function(a){
			alert('error');
		}
	});
}
*/

function piao_multi_domain(id)
{
	var template = $("#multi-domain-template").html();
	var option = [];
	option.email = $("#tr"+id).find('#email').text();
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_multi_domain',content:el,lock:true,top:'10%'});
	var div = $("#multi-domain-div");
	div.find('#lock').bind('click',function(){
		if (confirm('确定要锁定该账户下的所有域名吗?')) {
			multi_domain_manage(id,true,undefined);
		}
	});
	div.find('#unlock').bind('click',function(){
		if (confirm('确定要对该账户下的所有域名解锁吗?')) {
			multi_domain_manage(id,false,undefined);
		}
	});
	div.find('#disable').bind('click',function(){
		if (confirm('确定要禁用该账户下的所有域名吗?')) {
			multi_domain_manage(id,undefined,true);
		}
	});
	div.find('#undisable').bind('click',function(){
		if (confirm('确定要对该账户下的所有域名恢复使用吗?')) {
			multi_domain_manage(id,undefined,false);
		}
	});
}
function multi_domain_manage(id,lock,disable)
{
	if (disable==undefined) {
		var url = lock ? '?c=users&a=lockAllDomain' : '?c=users&a=unlockAllDomain';
	}else {
		var url = disable ? '?c=users&a=disableAllDomain' :'?c=users&a=undisableAllDomain';
	}
	dia.content('正在执行中...');
	$.ajax({
		url:url,
		data:{id:id},
		dataType:'json',
		success:function(a) {
			if (a.status.code != 1) {
				dia.content(a.status.message);
				return;
			}
			var html = '域名总数'+a.count + '<br>成功'+a.success + '<br>失败'+a.error + '<br>跳过'+a.continues;
			html += '<br>';
			for ( var i in a.errormsg) {
				html += i + ' '+ a.errormsg[i] + '<br>';
			}
			dia.content(html);
			//dia.time(3);
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piao_edit_divided(id)
{
	var template = $("#edit-divided-template").html();
	var option = [];
	option.email = $("#tr"+id).find("#email").text();
	option.divided = $("#tr"+id).find('#divided').text();
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_edit_divided',content:el,lock:true,top:'10%'});
	var div = $("#edit-divided");
	div.find("[name=divided]").trigger('focus');
	div.find("#enter").bind({
		'click':function() {edit_divided(id);}
	});
	div.find('#esc').bind('click',function(){
		dia.close();
	});
}
function edit_divided(id)
{
	var div = $("#edit-divided");
	var divided = div.find('[name=divided]').val();
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=users&a=setDivided',
		data:{id:id,divided:divided},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 1) {
				alert(a.message);
				return;
			}
			$("#tr"+id).find('#divided').text(divided+'%');
		},
		error:function(e) {
			dia.close();
			alert(e.responseText);
		}
	});
}
function sendRegMail(email,id) 
{
	$.ajax({
		url:'?c=users&a=sendRegMail&email='+email,
		dataType:'json',
		success:function(a) {
			if (a.code != 1) {
				alert(a.message);
				return;
			}
			$("#tr"+id).find('td').eq(8).html('已发送邮件');
		},
		error:function(e) {
			
		}
	});
}
function clear_login_error(id) 
{
	$.ajax({
		url:'?c=users&a=clearLoginError&id='+id,
		dataType:'json',
		success:function(a) {
			if (a.code != 1) {
				alert("清除失败"+a.message);
				return;
			}
			alert('清除成功');
		}
	});
}
function changePasswd(user)
{
	if (confirm("确定要重置密码吗") === false) {
		return ;
	}
	$.ajax({url:'?c=users&a=changePasswd&user='+user,dataType:'json',success:function(ret) {
		if (ret['code'] != 200) {
			alert(ret['msg']);
			return;
		}
		alert(ret['passwd']);
	}});	
}
//获取server列表
function getServerList(server){
	var that = this;
	var html = "";
	$.ajax({
		url:'?c=server&a=getServerNameList',
		async : false,
		dataType:'json',
		success:function(a){
			if(a.list.length > 1){
				html += "<select id='newserver'>";
				for(var i in a.list){
					if(a.list[i]['name'] == server){
						continue;
					}
					html += "<option value='"+a.list[i]['name']+"'>"+a.list[i]['name']+"</option>";
				}
				html += "</select>";
				html += "<input type='button' id='enter' value='修改' class='btn'>";
			}else{
				html += "<span>当前没有可修改的 server</span>";
			}
			
		},
		error:function(a){
			
		}
	});
	return html;
}
function piao_edit_server(email,id,server)
{
	var that = this;
	var select_html = getServerList(server);
	var template = $("#piao-edit-server-template").html();
	var option = [];
	option.select_html = select_html;
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'edit_server',lock:true});
	dia.title('修改'+email+ 'server');
	dia.content(el);
	var div = $("#edit-server-div");
	div.find("#enter").bind('click',function(){
		edit_server(email,id);
	});
}
function edit_server(email,id)
{
	var newserver = $("#newserver").val();
	if (!newserver) {
		alert('新的server不能为空');
		return ;
	}
	dia.content("正在提行中...");
	$.ajax({
		url:'?c=users&a=editServer',
		data:{email:email,id:id,newserver:newserver},
		dataType:'json',
		type:'POST',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.msg ? a.msg : '操作失败');
				return ;
			}
			var ser_html = "<a href=\"javascript:piao_edit_server('"+email+"',"+id+",'"+newserver+"')\">"+newserver+"</a>&nbsp;";
			$("#server"+id).html(ser_html);
			//var html = "[<a href='?c=server&a=login&name="+newserver+"' target='_blank'>登陆</a>]";
			//$("#server"+id).append(html);
		},
		error:function(e) {
			dia.close();
			alert(e.responseText);
		}
	});
} 
function change_status(email)
{
	if (!confirm("确定要激活吗")) {
		return;
	}	
	$.ajax({
		url:'?c=users&a=changeStatus',
		data:{email:email},
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.msg);
				return;
			}
			location = location;
		}
	});
}
function piao_custom_ns(email,id)
{
	var template = $("#piao-custom-ns-template").html();
	dia = art.dialog({id:'custom_ns',lock:true});
	dia.title('修改账户'+email+'默认ns');
	dia.content(template);
	var div = $("#custom-ns-div");
	div.find("#enter").bind('click',function(){
		custom_ns(email,id);
	});
	$.ajax({
		url:'?c=users&a=getInfo',
		data:{email:email},
		dataType:'json',
		success:function(a) {
			if (a.code == 200) {
				$("#ns1id").val(a.info.ns1_id);
				$("#ns2id").val(a.info.ns2_id);
				$("#ns1name").val(a.info.ns1_name);
				$("#ns2name").val(a.info.ns2_name);
				$("#soaemail").val(a.info.soa_email);
			}
				
		}
	});
}
function custom_ns(email,id)
{
	if (!email) {
		alert('数据出错');
		return ;
	}
	var ns1id = $("#ns1id").val();
	var ns1name = $("#ns1name").val();
	var ns2id = $("#ns2id").val();
	var ns2name = $("#ns2name").val();
	var soaemail = $("#soaemail").val();
	if (!ns1id || !ns2id) {
		alert('ns1 id 和ns2 id不能为空');
		return ;
	}
	dia.title('提示');
	dia.content('正在执行...');
	$.ajax({
		url:'?c=users&a=editCustomNs',
		type:'POST',
		data:{ns1id:ns1id,ns1name:ns1name,ns2id:ns2id,ns2name:ns2name,soaemail:soaemail,email:email},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.msg ? a.msg : '操作失败');
				return ;
			}
			$("#ns1id"+id).html(ns1id);
			$("#ns1name"+id).html(ns1name);
			$("#ns2id"+id).html(ns2id);
			$("#ns2name"+id).html(ns2name);
			$("#soaemail"+id).html(soaemail);
		},
		error:function(e){
			dia.close();
			alert(e.responseText);
		}
	});
}
function piao_set_adminremark(id)
{
	var template = $("#piao-set-adminremark-template").html();
	dia = art.dialog({id:'piao_set_pid',lock:true,content:template,top:'10%'});
	$("#piao_admin_remark").val($("#adminremark_"+id).attr('title'));
	var div = $("#set-adminremark-div");
	div.find("#enter").bind('click',function(){
		set_adminremark(id);
	});
}
function set_adminremark(id)
{
	var admin_remark = $("#piao_admin_remark").val();
	dia.content('正在执行...');
	$.ajax({
		url:'?c=users&a=setAdminremark',
		data:{id:id,admin_remark:admin_remark},
		dataType:'json',
		type:"POST",
		success:function(a){
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			$("#adminremark_"+id).html(admin_remark.substr(0,16)).attr('title',admin_remark);
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piaoAdd(){
	var template = $("#add-user-template").html();
	dia = art.dialog({id:'piao_add',lock:true,content:template,top:'10%'});
	var div = $("#add-user");
	div.find("#enter").bind('click',function(){
		add(div);
	});
}
function add(div){
	var name = div.find("input[name=name]").val();
	var passwd = div.find("input[name=passwd]").val();
	var email = div.find("input[name=email]").val();
	dia.content('正在执行...');
	$.ajax({
		url:'?c=users&a=add',
		data:{passwd:passwd,name:name,email:email},
		dataType:'json',
		type:"POST",
		success:function(a){
			dia.close();
			if (a.status.code !=1) {
				alert(a.status.message);
				return ;
			}
			window.location.reload();
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function del(id){
	if(confirm("您确定要删除这条记录吗?") ===false){
		return;
	}
	var tr = $("#tr"+id);
	var email = tr.attr('data-email');
	$.ajax({
		url:'?c=users&a=del_admin',
		data:{email:email},
		dataType:'json',
		type:"POST",
		success:function(a){
			if (a.status.code !=1) {
				alert(a.status.message);
				return ;
			}
			tr.remove();
		},
		error:function(e) {
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piaoEditPass(id){
	var template = $("#editpass-user-template").html();
	dia = art.dialog({id:'piao_edit',lock:true,content:template,top:'10%'});
	var div = $("#editpass-user");
	div.find("#enter").bind('click',function(){
		editPasswd(div,id);
	});
}
function editPasswd(div,id){
	var tr = $("#tr"+id);
	var email = tr.attr('data-email');
	var passwd = div.find("input[name=passwd]").val();
	dia.content('正在执行...');
	$.ajax({
		url:'?c=users&a=editpasswd',
		data:{passwd:passwd,email:email},
		dataType:'json',
		type:"POST",
		success:function(a){
			dia.close();
			if (a.status.code !=1) {
				alert(a.status.message);
				return ;
			}
			//window.location.reload();
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}