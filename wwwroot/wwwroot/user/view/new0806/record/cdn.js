var cdnMain = function(){
	this.domain = "";
	this.pname = "";
	this.getInfo = function(){
		var that = this;
		$.ajax({
			url:'/api/?c=record&a=getDomainInfo',
			dataType:'json',
			success:function(a){
				if(a.status.code != 1){
					that.renderLoginError();
					return;
				}
				that.domain = a.domain['name'];
				that.pname = a.domain['pname'];
				that.headTab();
				if(a.domain['cdn_id'] == 0){
					$("#row_popup").find("#popup").css('display','block');
					$("#msg").html("<a href='?c=cdn&a=index&domain="+that.domain+"' style='color:red'>请先增加CDN站点</a>");
					$("#msg").css("display","block");
				}
			},
			error:function(a){
				alert('error');
			}
		});
	}
	this.renderLoginError = function() {
		var template = $("#site-nologin-template").html();
		$("#multi_div").append(template);
	}
	this.headTab = function(){
		$("#domain_name_show").html(this.domain);
		$("#domain_pname_show").html(this.pname).parent('a').attr('href','?c=product&a=index&domain='+this.domain);
	}
}
$(document).ready(function(){
	
	$("#record-operat").find('#cdn').find('a').addClass('cur');
	var cdnmain = new cdnMain();
	cdnmain.getInfo(popup);
	renderLable();
	renderStatus();
    renderFlow();
});
function showFLow(){
	$(".progress").tooltip('show');
}
function renderFlow(){
	var div = $("#flow");
	 div.trigger("focus");
	 div.keypress(function(event){  
		    var keycode = (event.keyCode ? event.keyCode : event.which);  
		    if(keycode == '32'){  
		    	var flow=div.val();
		    	if(flow<=0){
		    		alert("流量必须大于0");
		    	}
		    	var sum = flow*flow_price;
		    	$("#sum").text("￥"+sum);
		    }  
	});  
}
function buyFlow(key){
	var flow= $("#flow").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		url : "/api/?c=record&a=buyFlow",
		data:{flow:flow},
		success:function(a){
			renderLoading(false);
			if (a.status.code!=1){
				showMsg("购买失败,"+a.status.message,2);
				return ;
			}
			showMsg("购买成功",1);
			renderStatus();
			renderMore(key,false);
			window.location.reload();
		return ;
	},
	error:function(){
		renderLoading(false);
		showMsg("请求失败",2);
	}
});
}
function renderLable(){
	$(".show").on("click",function(){
		$(".show").removeClass("lable_checked");
		$(this).addClass("lable_checked");
	});
}
function renderMore(key,show){
	var div = $(".lable").eq(key);
	var moreObj = div.find(".more");
	if (show){
		switch(key){
			case 1: //https
				moreObj.find("textarea[name=certificate]").val(div.attr("data-certificate"));
				moreObj.find("textarea[name=key]").val(div.attr("data-key"));
				moreObj.find("input[name=cipher]").val(div.attr("data-cipher"));
				moreObj.find("input[name=protocols]").val(div.attr("data-protocols"));
				break;
			case 3:
				moreObj.find("input[name=second]").val(div.attr("data-second"));
				break;
			case 4:
				break;
		}
		div.find("input[name=open]").val("收起");
		div.find("input[name=open]").attr("onclick","renderMore("+key+",false)");
		div.find("input[name=modify]").val("收起");
		div.find("input[name=modify]").attr("onclick","renderMore("+key+",false)");
		moreObj.slideDown();
		return 
	}
	div.find("input[name=open]").val("打开");
	div.find("input[name=modify]").val("设置");
	div.find("input[name=open]").attr("onclick","renderMore("+key+",true)");
	div.find("input[name=modify]").attr("onclick","renderMore("+key+",true)");
	moreObj.slideUp();
}
var loading_status = false;
function renderLoading(show){
	if (show == undefined){
		return  loading_status;
	}
	if (show){
		$("#loading").css("display","block");
		loading_status = true;
	}else{
		$("#loading").css("display","none");
		loading_status = false;
	}
}
function deleteConfig(key,type,id){
	if(!confirm("您确定要关闭这项功能吗？")) return ;
	renderLoading(true);
	//alert(type+'--'+id+'--'+key);
	//return;
	$.ajax({
		url : "/api/?c=record&a=shutCdnHttps",
		data:{type:type,id:id},
		dataType :"json",
		success:function(a){
			renderLoading(false);
			if (a.status.code!=1){
				showMsg("修改失败"+a.status.message,2);
				return ;
			}
			showMsg("修改成功",1);
			switch(key){
			case 4:  //cache config：多条记录需要特殊处理
				renderCacheDelete(key);
				break;
			case 2:
				renderCcDelete(key);
				break;
			case 8:
				deleteFlowLimit(key);
				break;
			default:
				$(".lable").eq(key).find(".oprate").attr("data-status",0);
				renderStatus();
				renderMore(key,false);
		}
		return ;
	},
	error:function(){
		renderLoading(false);
		showMsg("请求失败",2);
	}
});
}
function deleteFlowLimit(key){
	var deletes = $(".lable").eq(key).find(".items").find("div[delete-flag=1]").remove();
}


//删除
function renderCcDelete(key){
var deletes = $(".lable").eq(key).find(".cc_white_url_item[delete-flag=1]");
if(deletes.size() ==0){
	renderMore(key,false);
	$(".lable").eq(key).find(".oprate").attr("data-status",0);
	renderStatus();
}else{
	deletes.remove();
}
}
function renderCacheDelete(key){
	$(".lable").eq(key).find("div[delete-flag=1]").remove();
}
function modify_cache_div_delete(obj){
	$(obj).parent().parent().attr("delete-flag",1);
}


function showMsg(msg,code){
	
	// num为1 代表正确 2 代表错误 3 代表警告  4 busy代表忙碌
	var html = '';
	switch (code){
		case 1:
			html +="<img src='/style/check_right.gif'/>";
			break;
		case 2:
			html +="<img src='/style/check_error.gif'/>";
			break;
		case 3:
			html +="<img src='/style/warning.gif'/>";
			break;
		case 4:
			html +="<img src='/style/busy.gif'/>";
			break;
	}
	html += msg;
	$("#msg").html(html);
	$("#msg").css("display","block");
	setTimeout(function(){
		$("#msg").html("");
		$("#msg").css("display","none");
	},4000);
}
function addCcConfig(key){
	if(renderLoading()){
		showMsg("上次的操作还在进行中，请稍候",3);
		return ;
	}
	var div = $(".lable").eq(key).find(".cc_normal");
	var frcquency = div.find("input[name=frequency]:checked").val();
	var model = div.find("input[name=model]:checked").val();
	var custom_model_value = div.find("textarea[name=custom-model-textarea]").val();
	var custom_request=div.find('input[name=request]').val();
	var custom_second = div.find('input[name=second]').val();
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=preventCc",
		type:'POST',
		data:
		{
			frcquency:frcquency,
			model:model,
			custom_model_value:custom_model_value,
			custom_request:custom_request,
			custom_second:custom_second
		},
		dataType:"json",
		success:function(a){
			renderLoading(false);
			if (a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return ;
			}
			div.attr("data-frcquency",frcquency);
			div.attr("data-model",model);
			modifyStatus(key,1);
			renderStatus();
			renderMore(key,false);
			showMsg("修改成功",1);
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求异常",2);
		}
	});
}
function emptyForm(key){
	var div = $(".lable").eq(key);
	div.find(".more").find("textarea").val("");
	div.find(".more").find("input[type=text]").val("");
}
function renderStatus(){
	$(".lable").find(".oprate").each(function(){
		var status = $(this).attr("data-status");
		$(this).find("input").css("display","none");
		$(this).find("input[name=always-show]").css("display","inline");
		if(status==1){
			$(this).find("input[name=modify]").css("display","inline");
			$(this).find("input[name=close]").css("display","inline");
			$(this).parent().find(".status").html("<img src='/style/check_right.gif'/>");
		}else if(status==0){
			$(this).find("input[name=open]").css("display","inline");
			$(this).parent().find(".status").html("<img src='/style/check_error.gif'/>");
		}
	});
}
function addHttpsConfig(key){
	if(renderLoading()){
		showMsg("上次的操作还在进行中，请稍候",3);
		return ;
	}
	var div = $(".lable").eq(key);
	var certificate = div.find("textarea[name=certificate]").val();
	var https_key = div.find("textarea[name=key]").val();
	var cipher = div.find("input[name=cipher]").val();
	var protocols = div.find("input[name=protocols]").val();
	if (certificate=="" || https_key==""){
		showMsg("您没有输入任何内容",2);
		return ;
	}
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=setHttps",
		data :{certificate:certificate,key:https_key,cipher:cipher,protocols:protocols},
		type:'POST',
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code==1){
				div.attr("data-certificate",certificate);
				div.attr("data-key",https_key);
				div.attr("data-cipher",cipher);
				div.attr("data-protocols",protocols);
				modifyStatus(key,1);
				renderStatus();
				renderMore(key,false);
				showMsg("修改成功",1);
				return ;
			}
			showMsg(a.status.message ? a.status.message : "操作失败",2);
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function modifyStatus(key,value){
	$(".lable").eq(key).find(".oprate").attr("data-status",value);
}

function addIpConfig(key,type){
	if(renderLoading()){
		showMsg("上次的操作还在进行中，请稍候",3);
		return ;
	}
	renderLoading(true);
	var div = $(".lable").eq(key);
	var ip = div.find("textarea[name=ip]").val();
	$.ajax({
		url : "?c=vhost&a=addIpConfig",
		data :{ip:ip,name:type},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code==1){
				div.attr("data-ip",ip);
				modifyStatus(key,1);
				renderStatus();
				$(".lable").eq(key).find(".more").slideUp();
				showMsg("修改成功",1);
				return ;
			}
			showMsg(a.status.message ? a.status.message : "操作失败",2);
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}

function addLifeTimeConfig(key){
	renderLoading(true);
	var div = $(".lable").eq(key);
	var second = div.find("input[name=second]").val();
	$.ajax({
		url : "/api/?c=record&a=longConnection",
		type:'POST',
		data :{second:second},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			modifyStatus(key,1);
			renderStatus();
			div.attr("data-second",second);
			renderMore(key,false);
			showMsg("修改成功",1);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}

function renderAddCacheConfig(key){
	var sets_div = $(".lable").eq(key).find(".sets");
	var template = $("#cache-add-template").html();
	var option = [];
	option.divid = sets_div.find("div").size();
	template = Mustache.to_html(template,option);
	sets_div.prepend(template); 
}

function addCacheConfig(key,div_num,id){
	var div = $(".lable").eq(key).find("#div"+div_num);
	var model = div.find("input[name=model]:checked").val();
	var value = div.find("input[name=value]").val();
	var second = div.find("input[name=second]").val();
	var force = div.find("input[name=force]").attr("checked") ? 1 : 0;
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=setSeniorCache",
		type:'POST',
		data :{model:model,value:value,second:second,id:id,force:force},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			if (id==undefined){  //说明是新添加的config    添加完成后需要把id写入onclick属性
				div.find(".add-button").attr("onclick","addCacheConfig(4,"+div_num+","+a.id+")");
				div.find(".close-button").attr("onclick","javascript:modify_cache_div_delete(this);deleteConfig(4,'cache',"+a.id+");");
				div.find(".close-button").attr("value","关闭")
			}
			modifyStatus(key,1);
			renderStatus();
			showMsg("操作成功",1);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function removeRenderDiv(key,div_num){
	$(".lable").eq(key).find("#div"+div_num).remove();
}
function AddDefaultCacheConfig(key){
	var div = $(".lable").eq(key);
	var model = div.find("input[name=model]:checked").val();
	var second = div.find("input[name=second]").val();
	var force = div.find("input[name=force]").attr("checked") =="checked"? 1 : 0;
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=setCdnCache",
		type:'POST',
		data :{model:model,second:second,force:force},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功",1);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function addGzipConfig(key){
	var div = $(".lable").eq(key);
	var gzip = "";
	div.find("input[name=gzip]").each(function(){
		if($(this).attr("checked")){
			gzip += $(this).val()+",";
		}
	});
	gzip = gzip.substr(0,gzip.length-1);
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=setCdnGzip",
		type:'POST',
		data :{gzip:gzip},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功",1);
			renderMore(key,false);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function cacheFlushTime()
{
	$.ajax({
		url : "/api/?c=record&a=refreshCdnCache",
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功",1);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}

function addRedirectConfig(key){
	var div = $(".lable").eq(key);
	var host = div.find("input[name=host]").val();
	var target  = div.find("input[name=target]").val();
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=setCdnDomainRedirect",
		type:'POST',
		data :{host:host,target:target},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功",1);
			renderMore(key,false);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}

function addCcWhiteConfig(key){
	var div = $(".lable").eq(key);
	var ips = div.find("textarea[name=ips]").val();
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=addCcWhiteConfig",
		type:'POST',
		data :{ips:ips},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功",1);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function addCcWhiteUrlItem(key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var id = div.find(".cc_white_url_item").size();
	id++;
	var template = $("#cc-white-url-add-template").html();
	var option = [];
	option.id = id;
	var html = Mustache.to_html(template,option);
	div.append(html);
}
function delCcWhiteUrlItem(key,divid){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	div.find("#div" + divid).remove();
}
function updateCcWhiteUrlDeleteFlag(key,divid){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	div.find("#div" + divid).attr("delete-flag",1);
}

function addCcWhiteUrlsConfig(key,item_num){
	var div = $(".lable").eq(key);
	var item = div.find(".cc_white_urls").find("#div" +item_num );
	var url = item.find("input[name=url]").val();
	var id = item.attr("data-id");
	$.ajax({
		url : "/api/?c=record&a=addCcWhiteUrlsConfig",
		type:'POST',
		data :{url:url,id:id},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			if(!id){
				item.attr("data-id",a.id);
				item.find("[name=submit]").attr("onclick","addCcWhiteUrlsConfig(2,"+item_num+")");
				item.find("[name=del]").attr("onclick","updateCcWhiteUrlDeleteFlag("+key+","+item_num+");deleteConfig(2,'cc-white-url',"+a.id+")");
				item.find("[name=del]").attr("value","关闭");
			}
			showMsg("操作成功",1);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function renderCcCustomModeTextarea(key){
	var div = $(".lable").eq(key).find(".cc_normal");
	var ischecked = div.find(".custom-model").attr("checked");
	if(ischecked){
		div.find(".custom-model-textarea").css("display","block");
	}else{
		div.find(".custom-model-textarea").css("display","none");
	}
}
function piaoAddBlackIP(key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var id = div.find("input[name=ip]").size();
	id++;
	var template = $("#blackIP-add-template").html();
	var option = [];
	option.id = id;
	var html = Mustache.to_html(template,option);
	div.append(html);
	var divid = div.find("#div"+id);
	divid.find("#enter").bind('click',function(){
		addBlackIP(divid,id);
	});
	divid.find("#esc").bind('click',function(){
		escBlackIP(divid);
	});
}
function escBlackIP(divid){
	divid.remove();
}
function addBlackIP(divid,id){
	var ip = divid.find("input[name=ip]").val();
	$.ajax({
		url : "/api/?c=record&a=addBlackIp",
		data :{ip:ip,id:id},
		dataType :"json",
		type:"post",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功！",1);
			divid.attr("data-id",a.id);
			divid.attr("data-name",'blackip');
			divid.find("[id=esc]").attr("value","删除");
			divid.find("[id=enter]").attr("value","修改");
			divid.find("[id=esc]").unbind();
			divid.find("#esc").bind('click',function(){
				delConfig(id,7);
			});
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function editBlackIP(id,key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var divid=div.find("#div"+id);
	id =divid.attr("data-id");
	addBlackIP(divid,id);
}
function delConfig(id,key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var divid = div.find("#div"+id);
	ipId = divid.attr("data-id");
	type = divid.attr("data-name");
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=shutCdnHttps",
		type:"POST",
		data:{type:type,id:ipId},
		dataType :"json",
		success:function(a){
			renderLoading(false);
			if (a.status.code!=1){
				showMsg("删除失败"+a.status.message,2);
				return ;
			}
			showMsg("删除成功",1);
			divid.remove();
		},
		error:function(){
			renderLoading(false);
			showMsg("请求失败",2);
		}
	});
}

function piaoAddChain(key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var id = div.find("input[name=target]").size();
	id++;
	var html = $("#chain-add-template").html();
	var option = [];
	option.id = id;
	var el = Mustache.to_html(html,option);
	div.append(el);
	var divid = div.find("#div"+id);
	divid.find("#enter").bind('click',function(){
		addChainConfig(divid,id);
	});
	divid.find("#esc").bind('click',function(){
		escConfig(divid);
	});
}

function addChainConfig(divid,id){
	var referer = divid.find("input[name=referer]").val();
	var target = divid.find("input[name=target]").val();
	$.ajax({
		url : "/api/?c=record&a=addAntiReferer",
		data :{referer:referer,target:target,id:id},
		dataType :"json",
		type:"post",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功！",1);
			divid.attr("data-id",a.id);
			divid.attr("data-name",'anti-referer');
			divid.find("[id=esc]").attr("value","删除");
			divid.find("[id=enter]").attr("value","修改");
			divid.find("[id=esc]").unbind();
			divid.find("#esc").bind('click',function(){
				delConfig(id,8);
			});
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function editChain(id,key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var divid=div.find("#div"+id);
	id =divid.attr("data-id");
	addChainConfig(divid,id);
}
function escConfig(divid){
	divid.remove();
}


function addFlowLImitInput(key){
	var div = $(".lable").eq(key).find(".items");
	var option = [];
	option.divid = div.find(".item").size()
	var tem = $("#add-url-speed-limit-template").html();
	var html = Mustache.to_html(tem,option)
	div.append(html);
}
function delFlowLImitInput(key,divid){
	var div = $(".lable").eq(key).find(".items");
	div.find("#div" + divid).remove()
}
function addFlowLimit(key,divid){
	var div = $(".lable").eq(key).find(".items").find("#div" + divid);
	var url = div.find("input[name=url]").val();
	var speed = div.find("input[name=speed]").val()
	var model = div.find("input[name=model]:checked").val()
	var id = div.attr("data-id");
	$.ajax({
		type:"POST",
		dataType:"json",
		url : "/api/?c=record&a=addFlowLimit",
		data:{url:url,speed:speed,model:model,id:id},
		success:function(a){
			if(a.status.code != 1){
				showMsg(a.status.message,1)
				return 
			}
			showMsg("添加成功",1)
			div.attr("data-id",a.id)
			cancel_button = div.find("input[name=cancel]");
			cancel_button.attr("value","关闭")
			cancel_button.attr("onclick","updateDelFlowLimitFlag(9,"+divid+");deleteConfig(9,'flow-limit',"+a.id+")")
		},
		error:function(e){
			showMsg("请求异常",2)
		}
	});
}
function updateDelFlowLimitFlag(key,divid){
	var div = $(".lable").eq(key).find(".items").find("#div" + divid).attr("delete-flag",1);
}
function renderCustomFrequency(key){
	var div = $(".lable").eq(key).find(".cc_normal");
	var ischecked = div.find("input[value=custom]").attr("checked");
	if(ischecked){
		div.find(".margin_left").css("display","block");
	}else{
		div.find(".margin_left").css("display","none");
	}
}
function piaoAddRedirect(key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var id = div.find("input[name=host]").size();
    id++;
	var template = $("#Redirect-add-template").html();
	var option = [];
	option.id = id;
	var html = Mustache.to_html(template,option);
	div.append(html);
	var divid = div.find("#div"+id);
	divid.find("#enter").bind('click',function(){
		addRedirectConfig(divid,id);
	});
	divid.find("#esc").bind('click',function(){
		escConfig(divid);
	});
}
function addRedirectConfig(divid,id){
	var host = divid.find("input[name=host]").val();
	var target = divid.find("input[name=target]").val();
	var code = divid.find("input[name=code]:checked").val()
	$.ajax({
		url : "/api/?c=record&a=addRedirectConfig",
		data :{host:host,target:target,id:id,code:code},
		dataType :"json",
		type:"post",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			showMsg("操作成功！",1);
			divid.attr("data-id",a.id);
			divid.attr("data-name",'redirect');
			divid.find("[id=esc]").attr("value","删除");
			divid.find("[id=enter]").attr("value","修改");
			divid.find("[id=esc]").unbind();
			divid.find("#esc").bind('click',function(){
				delConfig(id,6);
			});
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function editRedirectConfig(id,key){
	var div = $(".lable").eq(key).find(".cc_white_urls");
	var divid=div.find("#div"+id);
	id =divid.attr("data-id");
	addRedirectConfig(divid,id);
}


