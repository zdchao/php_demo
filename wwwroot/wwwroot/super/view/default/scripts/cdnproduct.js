function getProductData(id){
	$.ajax({
		url:'?c=cdnproduct&a=getCdnProduct',
		data:{id:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				return;
			}
			piao_product_edit(id,a.ret);
		},
		error:function(a){
			alert('error');
		}
	});
}
function piao_product_edit(id,ret){
	var tr = $("#tr"+id);
	var template = $("#edit-product-template").html();
	var html = '<select name="audit" style="width:60px;height:25px">';
	if(ret['audit'] == 0){
		html += '<option value="0">是</option>';
		html += '<option value="1">否</option>';
	}else{
		html += '<option value="1">否</option>';
		html += '<option value="0">是</option>';
	}
	html += '</select>';
	var view = '<select name="view" style="width:60px;height:25px">';
	if(ret['cp_switch'] == 0){
		view += '<option value="0">关闭</option>';
		view += '<option value="1">开启</option>';
	}else{
		view += '<option value="1">开启</option>';
		view += '<option value="0">关闭</option>';
	}
	view += '</select>';
	var option = [];
	option.cbuid = ret['cb_uid'];
	option.uid = ret['uid'];
	option.cbpid = ret['cb_pid'];
	option.name = ret['name'];
	option.cbkey = ret['cb_key'];
	option.cbdomain = ret['cb_domain'];
	option.cbbs = ret['cb_bs'];
	option.cbhost = ret['cb_host'];
	option.select = html;
	option.server = ret['server'];
	option.viewselect = view;
	option.flow = ret['flow']/conversion;
	option.flow_price = ret['flow_price']/100;
	var el = Mustache.to_html(template,option);
	dia = art.dialog({
		id:"changeproduct",
		title:'修改产品',
		content:el
	});
	var div = $("#edit-product-div");
	div.find("#enter").bind('click',function(){
		var cbuid = div.find("[name=cbuid]").val();
		var uid = div.find("[name=uid]").val();
		var cbpid = div.find("[name=cbpid]").val();
		var name = div.find("[name=name]").val();
		var cbdomain = div.find("[name=cbdomain]").val();
		var cbkey = div.find("[name=cbkey]").val();
		var audit = div.find("[name=audit]").val();
		var cbbs = div.find("[name=cbbs]").val();
		var cbhost = div.find("[name=cbhost]").val();
		var server = div.find("[name=server]").val();
		var view = div.find("[name=view]").val();
		var flow = div.find("[name=flow]").val();
		var flow_price = div.find("[name=flow_price]").val();
		dia.close();
		$.ajax({
			url:'?c=cdnproduct&a=editCdnProduct',
			type:'POST',
			data:{
				cbuid:cbuid,
				uid:uid,
				cbpid:cbpid,
				name:name,
				cbdomain:cbdomain,
				cbkey:cbkey,
				audit:audit,
				id:id,
				cbbs:cbbs,
				cbhost:cbhost,
				server:server,
				view:view,
				flow:flow,
				flow_price:flow_price
			},
			dataType:'json',
			success:function(a){
				if(a.status.code == 1){
					window.location.href="?c=cdnproduct&a=pagelist";
				}
			},
			error:function(a){
				alert('error');
			}
		});
	});
}
function piao_product_delete(id){
	$.ajax({
		url:'?c=cdnproduct&a=deleteCdnProduct',
		data:{id:id},
		dataType:'json',
		success:function(a){
			//alert('success');
			if(a.status.code == 1){
				window.location.href = "?c=cdnproduct&a=pagelist";
			}
		},
		error:function(a){
			alert('error');
		}
	});
}
function piao_product_add()
{
	var template = $("#add-cdn-product-template").html();
	dia = art.dialog({id:'piao_product_add',lock:true,title:'增加新产品'});
	dia.content(template);
	var div = $("#add-cdn-product-div");
	div.find("#enter").bind('click',function(){
		var cbuid = div.find("[name=cbuid]").val();
		var uid = div.find("[name=uid]").val();
		var cbpid = div.find("[name=cbpid]").val();
		var name = div.find("[name=name]").val();
		var cbdomain = div.find("[name=cbdomain]").val();
		var cbkey = div.find("[name=cbkey]").val();
		var audit = div.find("[name=audit]").val();
		var cbbs = div.find("[name=cbbs]").val();
		var cbhost = div.find("[name=cbhost]").val();
		var server = div.find("[name=server]").val();
		var view = div.find("[name=view]").val();
		var flow = div.find("[name=flow]").val();
		var flow_price = div.find("[name=flow_price]").val();
		enterAddProduct(cbuid,uid,cbpid,name,cbdomain,cbkey,audit,cbbs,cbhost,server,view,flow,flow_price);
	});
}
function enterAddProduct(cbuid,uid,cbpid,name,cbdomain,cbkey,audit,cbbs,cbhost,server,view,flow,flow_price){
	//alert(uid);
	dia.close();
	$.ajax({
		url:'?c=cdnproduct&a=addCdnProduct',
		type:'POST',
		data:{
			cbuid:cbuid,
			uid:uid,
			cbpid:cbpid,
			name:name,
			cbdomain:cbdomain,
			cbkey:cbkey,
			audit:audit,
			cbbs:cbbs,
			cbhost:cbhost,
			server:server,
			view:view,
			flow:flow,
			flow_price:flow_price
		},
		dataType:"json",
		success:function(a){
			if(a.status.code != 1){
				alert(a.ret);
				return;
			}
			if(a.status.code == 1){
				window.location.href = "?c=cdnproduct&a=pagelist";
			}
		},
		error:function(a){
			alert("error");
		}
	});
}
//产品检测
function productDetectionData(id){
	$.ajax({
		url:'?c=cdnproduct&a=getCdnProduct',
		data:{id:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				return;
			}
			productDetection(id,a.ret['cb_uid'],a.ret['cb_pid'],a.ret['cb_host'],a.ret['cb_key']);
		},
		error:function(a){
		}
	});
}
function productDetection(id,cb_uid,cb_pid,cb_host,cb_key){
	$.ajax({
		url:'?c=cdnproduct&a=productDetection',
		data:{cb_uid:cb_uid,cb_pid:cb_pid,cb_host:cb_host,cb_key:cb_key},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				$("#tr"+id).find("#op").find("span").html("<img src='/style/check_error.gif'/>");
				return;
			}
			$("#tr"+id).find("#op").find("span").html("<img src='/style/check_right.gif'/>");
		},
		error:function(a){
			alert('error');
		}
	});
}