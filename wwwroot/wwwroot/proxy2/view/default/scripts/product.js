function piao_product_edit(id)
{
	var name = $("#product_edit_name"+id).text();
	var rrl = $("#product_edit_rrl"+id).text();
	var description = $("#product_edit_description"+id).attr('title');
	var server = $("#product_edit_server"+id).text();
	var price = $("#product_edit_price"+id).text();
	var flags = $("#product_edit_flags"+id).text();
	var html = '';
		html += '<div class="piao_div">产品名称:<input name="name" id="product_edit_name" value="'+name+'"></div>';
		html += '<div class="piao_div">产品价格:<input name="name" id="product_edit_price" value="'+price+'">元/月</div>';
		html += '<div class="piao_div">产品 rrl:<input name="rrl" id="product_edit_rrl" value="'+rrl+'"></div>';
		html += '<div class="piao_div">产品flag:<input name="flags" id="product_edit_flags" value="'+flags+'"></div>';
		html += '<div class="piao_div">属server:<input name="server" id="product_edit_server" value="'+server+'"></div>';
		html += '<div class="piao_div">产品描述:<textarea name="description" rows=5 cols=50 id="product_edit_description">'+description+'</textarea>';
		html += '<div class="piao_div"><input type="button" value="修改" onclick="product_edit('+id+')"></div>';
		dia = art.dialog({id:'product_edit',lock:true,title:'修改产品'});
		dia.content(html);
}
function product_edit(id)
{
	var name = $("#product_edit_name").val();
	var rrl = $("#product_edit_rrl").val();
	var description = $("#product_edit_description").val();
	var server = $("#product_edit_server").val();
	var price = $("#product_edit_price").val();
	var flags = $("#product_edit_flags").val();
	dia.content('正在执行中....');
	$.ajax({
		url:'?c=product&a=edit',
		data:{id:id,name:name,rrl:rrl,server:server,description:description,price:price,flags:flags},
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
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
			$("#product_change_status_"+id).html(newcontent);
		},
		error:function(e) {
			alert('后出数据出错'+e.responseText);
		}
	});
}
function piao_product_add()
{
	var html = '';
		html += '<div class="piao_div"><img src="/style/dot.gif">必需定义一个免费产品(价格为0),注册的用户默认使用免费产品</div>';
		html += '<div class="piao_div">产品名称:<input name="name" id="product_add_name">*</div>';
		html += '<div class="piao_div">产品价格:<input name="price" id="product_add_price">元/月*</div>';
		html += '<div class="piao_div">产品 rrl:<input name="rrl" id="product_add_rrl"></div>';
		html += '<div class="piao_div">产品flag:<input name="flags" id="product_add_flags"></div>';
		html += '<div class="piao_div">产品描述:<textarea rows="5" cols="40" id="product_add_description" ></textarea>*支持html</div>';
		html += '<div class="piao_div"><input type="button" onclick="product_add()" value="增加"></div>';
	dia = art.dialog({id:'piao_product_add',lock:true,title:'增加新产品'});
	dia.content(html);
}
function product_add()
{
	var name = $("#product_add_name").val();
	var price = $("#product_add_price").val();
	var rrl = $("#product_add_rrl").val();
	var flags = $("#product_add_flags").val();
	var description = $("#product_add_description").val();
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
		data:{name:name,price:price,rrl:rrl,flags:flags,description:description},
		dataType:'json',
		async:false,
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