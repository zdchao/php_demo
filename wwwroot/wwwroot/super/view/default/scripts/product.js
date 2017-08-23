function piao_product_edit(id)
{
	var tr = $("#tr"+id);
	var option = [];
	option.name = tr.find('#name').text();
	option.rrl = tr.find('#rrl').text();
	option.description = tr.find("#description").attr('title');
	//option.server = tr.find("#server").text();
	option.serverHtml = buildServerSelect(tr.find("#server").text());
	option.price = tr.find("#price").text();
	option.flags = tr.find("#flags").text();
	option.groupview = tr.find("#groupview").text();
	option.blockns = tr.find('#blockns').attr('data-value')==1 ? 'checked' :'';
	var template = $("#edit-product-template").html();
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'product_edit',lock:true,title:'修改产品',content:el});
	var div = $("#edit-product-div");
	div.find("#enter").bind('click',function(){
		product_edit(id);
	});
}


function product_edit(id)
{
	var div = $("#edit-product-div");
	var name = div.find('[name=name]').val();
	var rrl = div.find("[name=rrl]").val();
	var description = div.find("[name=description]").val();
	var server = div.find("[name=server]").val();
	var price = div.find("[name=price]").val();
	var flags = resetFlags(div.find("[name=flags]").val());
	var groupview = div.find("[name=groupview]").val();
	var blockns = div.find("[name=blockns]:checked").val();
	dia.content('正在执行中....');
	$.ajax({
		url:'?c=product&a=edit',
		data:{id:id,name:name,rrl:rrl,server:server,description:description,price:price,flags:flags,groupview:groupview,blockns:blockns},
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				dia.close();
				alert(a.messgage);
				return ;
			}
			window.location = '?c=product&a=pagelist';
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function product_change_status(id,status)
{
	var confirmmsg = '';
	if (status > 0) {
		confirmmsg = '确定要将id='+id+'的产品禁售吗';
	}else {
		confirmmsg = '确定要将id='+id+'的产品恢复出售吗';
	}
	if (confirm(confirmmsg)=== false) {
		return ;
	}
	$.ajax({
		url:'?c=product&a=changeStatus',
		data:{id:id,status:status},
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			var newcontent = '';
			if (status < 1) {
				newcontent = '<a href="#" onclick="product_change_status('+id+',1)" title="点击可禁售"><b class="green">出售</b></a>';
			}else {
				newcontent = '<a href="#" onclick="product_change_status('+id+',0)" title="点击可恢复出售"><b class="red">禁售</b></a>';
			}
			$("#tr"+id).find('#status').html(newcontent);
		},
		error:function(e) {
			alert('后出数据出错'+e.responseText);
		}
	});
}
var ServerList = [];
function getServerList(callback)
{
	if (ServerList.length > 0 ) {
		return ServerList;
	}
	$.ajax({
		url:'?c=server&a=getList',
		dataType:'json',
		success:function(a) {
			if (a.status.code != 1) {
				alert('获取server失败，请先增加');
				return;
			}
			for ( var i in a.list) {
				ServerList[a.list[i]['name']] = a.list[i];
			}
			if (typeof callback == 'function') {
				callback();
			}
		}
	});
}
function buildServerSelect(server)
{
	var html = '<select name="server">';
	for ( var name in ServerList) {
		html += '<option value="' + name + '"';
		if (server && server == name) {
			html += ' selected';
		}
		html += '>' + name + "</option>";
	}
	html += '</select>';
	return html ;
}
function piao_product_add()
{
	var template = $("#add-product-template").html();
	dia = art.dialog({id:'piao_product_add',content:template,top:'10%',lock:true,title:'增加新产品'});
	show_groupview("show_add_groupview");
	var div = $("#add-product-div");
	div.find('#enter').bind('click',function(){
		product_add();
	});
}
function show_product_id()
{
	$("#add-product-div").find('#product_add_id_span').html("<input name='id' placeholder='10000以上'>");
}
function show_groupview(domid)
{
	$.ajax({
		url:'?c=groupview&a=lists',
		dataType:'json',
		success:function(a) {
			var html = '<select name="groupview" id="product_add_groupview">';
			for ( var i in a.list) {
				html += '<option value="'+a.list[i]['id'] + '">'+a.list[i]['name'] + '</option>';
			}
			html += '</select>';
			$("#"+domid).html(html);
		},
		error:function(e) {
			alert('后台数据出错'+e.responseText);
		}
	});
}
function resetFlags(flags)
{
	var option = flags.split('+');
	if (option.length>1) {
		var newflags = 1;
		for ( var i in option) {
			newflags = newflags | option[i];
		}
		return newflags;
	}
	return flags;
}
function product_add()
{
	var div = $("#add-product-div");
	var name = div.find("[name=name]").val();
	var price = div.find("[name=price]").val();
	var rrl = div.find("[name=rrl]").val();
	var flags =resetFlags(div.find("[name=flags]").val());
	var description = div.find("[name=description]").val();
	var groupview = div.find("[name=groupview]").val();
	var blockns = div.find("[name=blockns]:checked").val();
	if (!groupview) {
		alert('线路组不能为空');
		return;
	}
	var id = div.find("[name=id]").val();
	if (!name) {
		alert('产品名称不能为空');
		return ;
	}
	if (price=='') {
		alert('产品价格不能为空');
		return ;
	}
	if (!description) {
		alert('产品描述不能为空');
		return ;
	}
	dia.content('正在执行中...');
	$.ajax({
		url:'?c=product&a=add',
		data:{name:name,price:price,rrl:rrl,flags:flags,description:description,groupview:groupview,id:id,blockns:blockns},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.status.message);
				return ;
			}
			window.location = '?c=product&a=pagelist';
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
//产品排序
function productOrder(orderid,key){
	var html = "<input id='"+key+"' style='width:30px;' type='text' value='"+orderid+"'/>";
	html += "<input style='width:25px;' type='button' value='Y' onclick='saveProductOrder("+orderid+","+key+")'/>";
	html +="<input style='width:25px;' type='button' value='N' onclick='closeChangeProductOrder("+orderid+","+key+")'/>";
	$("#order"+key).html(html);
}
function closeChangeProductOrder(orderid,key){
	var html = "<a href=\"javascript:productOrder('"+orderid+"','"+key+"')\">"+orderid+"</a>";
	$("#order"+key).html(html);
}
function saveProductOrder(orderid,key){
	var ordervalue = $("#order"+key).find("#"+key).val();
	if(ordervalue > 127 || ordervalue < 0 || ordervalue == ""){
		return;
	}
	$.ajax({
		url:'?c=product&a=changeProductOrder',
		data:{ordervalue:ordervalue,id:key},
		dataType:'json',
		success:function(a){
			//console.log(a);
			if(a.ret == 1){
				var html = "<a href=\"javascript:productOrder('"+ordervalue+"','"+key+"')\">"+ordervalue+"</a>";
				$("#order"+key).html(html);
			}
		},
		error:function(a){
			alert('error');
		}
	});
}
