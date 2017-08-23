function getTrObj(key)
{
	return $("#tr"+key);
}
function piao_del_domain(key)
{
	var tr = getTrObj(key);
	var name = tr.attr('data-name');
	
	var temp = $("#confirm-template").html();
	var option = [];
	option['tip'] = "确定要删除域名"+name + '吗?';
	html = Mustache.to_html(temp,option);
	dia = art.dialog({id:'del_domain',lock:true,content:html});
	var div = $("#confirm-div");
	div.find("#enter").bind('click',function(){
		var server = tr.attr('data-server');
		$.ajax({
			url:'?c=domains&a=del',
			data:{
				domain:name,
				server:server
			},
			dataType:"json",
			success:function(a) {
				dia.close();
				if (a.code != 200) {
					alert(a.message);
					return;
				}
				tr.remove();
			}
		});
	});
}
function piao_shift_pid(key)
{
	var tr = getTrObj(key);
	var name = tr.attr('data-name');
	var html = '';
		html += '<div id="shift-pid-div">迁移至域名:<input id="piao_shift_domain" type="text" name="domain"><input type="button" id="enter" class="btn" value="转移" ></div>';
		dia = art.dialog({id:'piao_shift_pid_dia',lock:true,content:html});
	var div = $("#shift-pid-div");
	div.find("#enter").bind('click',function(){
		var newdomain = div.find('[name=domain]').val();
		if (!newdomain) {
			return;
		}
		dia.content('正在执行中...');
		$.ajax({
			url:'?c=domains&a=shiftPid',
			data:{olddomain:name,newdomain:newdomain},
			dataType:'json',
			success:function(a) {
				dia.close();
				if (a.code != 200) {
					alert(a.message);
					return ;
				}
				window.location = '?c=domains&a=pagelist';
			},
			error:function(e) {
				dia.close();
				alert('后台数据出错'+e.responseText);
			}
		});
	});
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
function piao_edit_server(key)
{
	var tr = getTrObj(key);
	var domain = tr.attr('data-name');
	//var html ='<div id="edit-server-div"><p><img src="/style/dot.gif">请确认新的server是已存在的</p>';
		//html += '<p style="margin-top:20px">新的server:<input name="new_server"  type="text"><input type=button value="修改" class="btn" id="enter"></p></div>';
	var oldserver = tr.attr('data-server');
	var select_html = getServerList(oldserver);
	var html = $("#piao-edit-server-template").html();
	var option = [];
	option.select = select_html;
	var el = Mustache.to_html(html,option);
		var dialog = art.dialog({id:'edit_server',lock:true,top:'10%'});
		dialog.content(el);
		var div = $("#edit-server-div");
		div.find("#enter").bind('click',function(){
			//var newserver =div.find("[name=new_server]").val();
			var newserver = div.find("#newserver").val();
			if (!newserver) {
				alert('新的server不能为空');
				return ;
			}
			
			if (oldserver == newserver) {
				alert('新的server不能和旧的server相同');
				return ;
			}
			dialog.close();
			
			var d = art.dialog({id:'show_edit_server_msg',content:'正在执行中...',lock:true});
			$.ajax({
				url:'?c=domains&a=editServer',
				data:{domain:domain,newserver:newserver,oldserver:oldserver},
				dataType:'json',
				success:function(a) {
					d.close();
					if (a.code != 200) {
						alert(a.msg ? a.msg :'操作失败');
						return ;
					}
					tr.attr('data-server',newserver).find('#server').html(newserver);
				}
			});
		});
}
function piao_edit_groupview(key)
{
	var tr = getTrObj(key);
	
	var template = $("#piao-edit-groupview-template").html();
	var option = [];
	option.domain = tr.attr('data-name');
	option.groupview = tr.attr('data-groupview');;
	option.server = tr.attr('data-server');;
	var el = Mustache.to_html(template,option);
	art.dialog({id:'domain_edit',title:'域名修改线路组',content:el,lock:true,top:'10%'});
}

function edit_uid(key)
{
	var uid = prompt("输入新的uid");	
	if (!uid) {
		return;
	}
	var tr = getTrObj(key);
	var name = tr.attr('data-name');
	var server = tr.attr('data-server');
	$.ajax({
		url:'?c=domains&a=editUid',
		data:{name:name,uid:uid,server:server},
		dataType:'json',
		type:"POST",
		success:function(a) {
			if (a.code != 200) {
				alert(a.msg);
				return 
			}
			tr.attr('data-uid',uid).find("#uid").html(uid);
		},
		error:function(){
			alert('有错误');
		}
	});
}
function piao_edit_rrl(key)
{
	var tr = getTrObj(key);
	var rrl = tr.attr("data-rrl");
	if (!rrl) {
		rrl = default_rrl;
	}
	var template = $("#piao-edit-rrl-template").html();
	var option = [];
	option.rrl = rrl;
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'domain_rrl_edit',lock:true,top:'10%'});
	dia.content(el);
	var div = $("#edit-rrl-div");
	div.find("#enter").bind('click',function(){
		edit_rrl(tr,div);
	});
}
function edit_rrl(tr,div)
{
	var rrl = div.find('[name=rrl]').val();
	var name = tr.attr('data-name');
	var server = tr.attr('data-server');
	$.ajax({
		url:'?c=domains&a=editRrl',
		type:'POST',
		data:{name:name,server:server,rrl:rrl},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.msg);
				return;
			}
			tr.attr('data-rrl',rrl).find("#rrl").html(rrl);
		},
		error:function(e) {
			dia.close();
			alert('有错误');
		}
	});
}

function get_product_list()
{
	if (plist) {
		return plist;
	}	
	$.ajax({
		url:'?c=product&a=getList',
		dataType:'json',
		async:false,
		success:function(a) {
			plist = a.rows;
		},
		error:function(e) {
			
		}
	});
	
}
function show_pid_msg(oldprice)
{
	var id = $("#set_pid").val();
	for ( var i in plist) {
		if (i ==id) {
			var newprice = plist[i]['price'];
			if (oldprice < newprice) {
				$("#piao_pid_price").val(newprice);
			}
			var thispidmsg = '<b class="red">server:'+plist[i]['server']+',rrl:'+plist[i]['rrl'] +',flags:'+plist[i]['flags'] +'</b>';
			$("#this_pid_msg").html(thispidmsg);
			break;
		}
	}
	
}
function piao_set_pid(key)
{
	var tr = getTrObj(key);
	var pid_price = tr.attr('data-pirprice');
	var name = tr.attr('data-name');
	//get_product_list();
	var template = $("#domain-set-pid-template").html();
	var option = [];
	option.pid_price = pid_price;
	option.name = name;
	var payid = tr.attr('data-pid');
	var producthtml = '';
	for ( var i in plist) {
		producthtml += '<option value='+i;
		if (i== payid) {
			producthtml += ' selected';
		}
		producthtml += '>'+plist[i]['name']+'</option>';
	}
	option.producthtml = producthtml;
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_set_pid',lock:true,content:el,top:'10%'});
	var div = $("#domain-set-pid-div");
	div.find("#enter").bind('click',function(){
		set_pid(tr,div);
	});
	div.find("[name=pid]").bind('change',function(){
		show_pid_msg(pid_price);
	});
}
function get_pid_name(id)
{
	return plist[id]['name'];
}
function set_pid(tr,div)
{
	var pid = div.find('[name=pid]').val();
	var pid_price = div.find('[name=pid_price]').val();
	var admin_remark = div.find('[name=admin_remark]').val();
	var month = div.find('[name=month]').val();
	var ispay = div.find("#piao_ispay").attr('checked');
	var name = tr.attr('data-name');
	var uid = tr.attr('data-uid');
	ispay = ispay ? 1 : 0;
	dia.content('正在执行......');
	$.ajax({
		url:'?c=domains&a=setPidPrice',
		data:{
			pid:pid,
			pid_price:pid_price,
			name:name,
			admin_remark:admin_remark,
			month:month,
			ispay:ispay,
			uid:uid
		},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			tr.attr('data-pid',pid);
			tr.attr('data-pidprice',pid_price);
			tr.find("#admin_remark_span").attr('title',admin_remark).html(admin_remark.substr(0,8));
			tr.find("#pid").html('<b class="green">'+get_pid_name(pid)+'</b>');
			tr.find("#pid_price").html(pid_price);
			
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piao_set_adminremark(key)
{
	var tr = getTrObj(key);
	var template = $("#piao-set-adminremark-template").html();
	dia = art.dialog({id:'piao_set_pid',lock:true,content:template,top:'10%'});
	var div = $("#set-adminremark-div");
	div.find("[name=admin_remark]").val(tr.find('#admin_remark_span').attr('title'));
	div.find("#enter").bind('click',function(){
		set_adminremark(tr,div);
	});
}
function set_adminremark(tr,div)
{
	var admin_remark = div.find("[name=admin_remark]").val();
	var name = tr.attr('data-name');
	dia.content('正在执行...');
	$.ajax({
		url:'?c=domains&a=setAdminremark',
		data:{name:name,admin_remark:admin_remark},
		dataType:'json',
		type:"POST",
		success:function(a){
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			tr.find('#admin_remark_span').attr('title',admin_remark).html(admin_remark.substr(0,8));
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
/**
 * 修改域名的过期时间
 */
function piao_set_pidexpiretime(key)
{
	var tr = getTrObj(key);
	var template = $("#piao-set-pidexpiretime-template").html();
	var option = [];
	option.name = tr.attr('data-name');
	option.pidexpiretime = tr.attr('data-pidexpiretime');
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:"piao_set_pidexpiretime",content:el});
	var div = $("#set-pidexpiretime-div");
	div.find("#enter").bind('click',function(){
		set_pidexpiretime(tr,div);
	});
	$(".jcDate").jcDate({					       
		IcoClass : "jcDateIco",
		Event : "click",
		Speed : 100,
		Left : 0,
		Top : 70,
		format : "-",
		Timeout : 100
	});
}
function set_pidexpiretime(tr,div)
{
	var newpidexpiretime = div.find("[name=pid_expire_time]").val();
	var name = tr.attr('data-name');
	dia.content("正在执行...");
	$.ajax({
		url:'?c=domains&a=editPidexpiretime',
		data:{name:name,pid_expire_time:newpidexpiretime},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			tr.find('#pidexpiretime_span').html(newpidexpiretime);
			tr.attr('data-pidexpiretime',newpidexpiretime);
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
		
	});
}
/*
 * 添加域名
 */
function AdminAddDomain(){
	var that = this;
	var template = $("#admin-add-domain-template").html();
	dia = art.dialog({
		id:'AdminAddDomain',
		title:'添加域名',
		content:template,
		top:'15%'
	});
	var div = $("#admin-add-domain-div");
	div.find("#enter").bind('click',function(){
		var domain = $("#domainName").val();
		var userID = $("#userID").val();
		var server = $("#server").val();
		if(domain == "" || userID == "" || server == ""){
			art.dialog({content:'域名，UID或server不能为空',top:'15%'});
			return;
		}
		dia.close();
		$.ajax({
			url:'?c=domains&a=adminAddDomain',
			data:{domain:domain,userID:userID,server:server},
			dataType:'json',
			success:function(a){
				if (a.status.code !=1) {
					alert(a.status.message);
					return;
				}
				window.location = '?c=domains&a=pagelist';
			},
			error:function(a){
				alert(a.status.message);
			}
		});
	});
}
//域名回源
function domainBackSource(key,flags){
	var tr = getTrObj(key);
	var domain = tr.attr('data-name');
	$.ajax({
		url:'?c=domains&a=domainBackSource',
		data:{domain:domain,flags:flags},
		dataType:'json',
		success:function(a){
			if(a.status.code == 1){
				window.location = '?c=domains&a=pagelist';
			}
		},
		error:function(a){
			alert("error");
		}
	});
}
//cdn状态
function cdnStatus(key){
	var template = $("#confirm-template").html();
	var option = [];
	option.tip = "确定要此域名重新申请CDN吗?";
	var el = Mustache.to_html(template,option);
	var dia = art.dialog({
		id:'cdnstatus',
		title:'域名解除提示',
		lock:true,
		content:el
	});
	var div = $("#confirm-div");
	div.find("#esc").bind('click',function(){
		dia.close();
	});
	div.find("#enter").bind('click',function(){
		dia.close();
		cdnStatusEnter(key);
	});
}
function cdnStatusEnter(key){
	var tr = getTrObj(key);
	var domain = tr.attr('data-name');
	$.ajax({
		url:'?c=domains&a=cdnStatus',
		type:'POST',
		data:{domain:domain},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert("修改失败");
				return;
			}
			tr.find("#cdn_status").html("");
		},
		error:function(a){
			alert("数据出错");
		}
	});
}
function search(){
	var pid = $("#pid_expire_time_span").find('[name=pid]').val();
	var day = $("#pid_expire_time_span").find('[name=day]').val();
	window.location.href = "{[$action]}"+'&pid_expire_time=1&pid='+pid + '&day='+day;
}


/***************************废弃功能**************************************/
function piao_custom_ns(domain)
{
	var template = $("#piao-custom-ns-template").html();
	dia = art.dialog({id:'custom_ns',lock:true,top:'10%'});
	dia.title('自定义域名 '+domain +' NS');
	dia.content(template);
	var div = $("#custom-ns-div");
	div.find("#enter").bind('click',function(){
		custom_ns(domain);
	});
}
function custom_ns(domain)
{
	var ns1 = $("#custom_ns1").val();
	var ns2 = $("#custom_ns2").val();
	var soaemail = $("#custom_email").val();
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=domains&a=customNs',
		data:{domain:domain,ns1:ns1,ns2:ns2,soaemail:soaemail},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.msg ? a.msg : '操作失败');
				return ;
			}
			art.dialog({id:'show_custom_ns_msg',icon:'succeed',time:1,content:'自定义成功'});
		},
		error:function(e) {
			dia.close();
			alert(e.responseText);
		}
	});
	
}

function piao_add_movecited(key)
{
	var tr = getTrObj(key);
	
	var template = $("#domain-add-movecited-template").html();
	var option = [];
	option.name = tr.attr('data-name');
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_add_movecited',content:el,lock:true,lock:'10%'});
	var div = $("#domain-add-movecited-div");
	//div.find('[name=minute]').trigger('focus');
	//div.find('[name=remark]').trigger('focus');
	div.find('#enter').bind('click',function(){
		add_movecited(tr);
	});
}
function add_movecited(tr)
{
	var domain = tr.attr('data-name');
	$.ajax({
		url:'?c=domains&a=addMovecited',
		data:{domain:domain},
		dataType:'json',
		success:function(a) {
			if (a.status.code != 1) {
				dia.content(a.status.message);
				return;
			}
			window.location = '?c=domains&a=pagelist';
		},
		error:function(e) {
			dia.close();
		}
	});
}

function block_ns(name,status)
{
	getBlockns();
	if (status == 0) {
		if (!confirm('确定要清除该域名的阻断NS吗?')) {
			return ;
		}
		del_block_ns(name);
		return;
	}
	var template = $("#domain-add-blockns-template").html();
	var option = [];
	option.name = name;
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:"piao-block-ns-art",content:el,title:'给域名'+name+ '设置阻断NS',lock:true,top:'10%'});
	var div = $("#domain-add-blockns-div");
	div.find('#enter').bind('click',function() {
		add_block_ns(name,div.find('[name=blockns_id]').val());
	});
}
/**
 * -----------
 */
function createBlockNsHtml()
{
	var html = '<select name="blockns_id">';
	if (blocknslist.length > 0) {
		for ( var i in blocknslist) {
			html += '<option value='+blocknslist[i]['id'] + '>'+blocknslist[i]['ns'] + '</option>';
		}
	}
	
	html += '</select>';
	return html;
}
function del_block_ns(name)
{
	$.ajax({
		url:'?c=domains&a=delBlockns',
		data:{name:name},
		dataType:'json'
	}).done(function(a){
		if (a.status.code != 1) {
			alert(a.status.message);
			return;
		}
		window.location = '?c=domains&a=pagelist&domain='+name;
		
	}).fail(function(e){
		alert(e.responseText);
	});
}
/**
 * --------------------
 */
function getBlockns()
{
	if (blocknslist.length ==0) {
		$.ajax({
			url:'?c=blockns&a=getList',
			data:{},
			async:false,
			dataType:'json'
		}).done(function(a){
			if (a.count > 0) {
				blocknslist = a.rows;
			}
		}).fail(function(e){
			alert('获取数据出错'+e.responseText);
		});
	}
}
function add_block_ns(name,blocknsid)
{
	$.ajax({
		url:'?c=domains&a=addBlockns',
		data:{name:name,blocknsid:blocknsid},
		dataType:'json'
	}).done(function(a){
		dia.close();
		if (a.status.code != 1) {
			alert(a.status.message);
			return;
		}
		window.location = '?c=domains&a=pagelist&domain='+name;
		
	}).fail(function(e){
		dia.close();
		alert(e.responseText);
	});
}
function add_record(domain,server)
{
	var name = $("#piao_record_name").val();
	var value = $("#piao_record_value").val();
	var type = $("#piao_record_type").val();
	var line = $("#piao_record_line").val();
	var ttl = $("#piao_record_ttl").val();
	if (!name) {
		name = '@';
	}
	if (!value) {
		alert('解析值不能为空');
		$("#piao_record_value").trigger('focus');
		return ;
	}
	dia.content('正在执行...');
	$.ajax({
		url:'?c=domains&a=addRecord',
		data:{name:name,value:value,t:type,line:line,ttl:ttl,domain:domain,server:server},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function piao_edit_ns(name,server)
{
	var template = $("#piao-edit-ns-template").html();
	var dia = art.dialog({id:'domain_ns_edit',lock:true});
	dia.title("修改 " +name + ' ns');
	dia.content(template);
	var div = $("edit-ns-div");
	div.find("#enter").bind('click',function(){
		edit_ns(name,server);
	});
}
function edit_ns(name,server)
{
	var ns1 = $("#edit_ns1").val();
	var ns2 = $("#edit_ns2").val();
	$.ajax({
		url:'?c=domains&a=editNs',
		type:'GET',
		data:{name:name,server:server,ns1:ns1,ns2:ns2},
		dataType:'json',
		success:function(a)  {
			if (a.code != 200) {
				return alert(a.msg ? a.msg :'修改失败');
			}
			art.dialog({id:'edit_ns',content:'修改成功',icon:'succeed',time:1,top:'10%'});
			setTimeout(function(){
				window.location = window.location;
			},1000);
		},
		error:function(a){
			alert("有错误" + a.responseText);
		}
	});
}
function domain_admin_lock(domain,server,status){
	var url = '?c=domains&a=adminLock&domain='+domain + '&server='+server + '&status='+status;
	if (wherename) {
		url += '&name='+wherename;
	}
	window.location = url;
}
function domain_admin_status(domain,server,status)
{
	var url = "?c=domains&a=adminStatus&status=" + status+ '&domain='+domain+ '&server='+server;
	if (wherename) {
		url += '&name='+wherename;
	}
	window.location = url;
}