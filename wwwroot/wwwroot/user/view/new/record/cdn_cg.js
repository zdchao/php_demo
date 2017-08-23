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
					$(".part_shield").css("display","block");
					that.renderLoginError();
					return;
				}
				that.domain = a.domain['name'];
				that.pname = a.domain['pname'];
				that.headTab();
				if(a.domain['cdn_id'] == 0){
					//$("#row_popup").find("#popup").css('display','block');
					$(".part_shield").css("display","block");
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
	
	$("#record-operat").find('#cdn_cg').find('a').addClass('cur');
	$("#nav_domain").addClass('cur');
	var cdnmain = new cdnMain();
	cdnmain.getInfo();
	renderLable();
	renderStatus();
   renderFlow();
});
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
function renderLable(){
	$(".show").on("click",function(){
		$(".show").removeClass("lable_checked");
		$(this).addClass("lable_checked");
	});
}
function renderStatus(){
	$(".lable").find(".oprate").each(function(){
		var status = $(this).attr("data-status");
		$(this).find("input").css("display","none");
		$(this).find("input[name=always-show]").css("display","inline");
		if(status==1){
			$(this).find("input[name=modify]").css("display","inline");
			//$(this).find("input[name=close]").css("display","inline");
			$(this).parent().find(".status").html("<img src='/style/check_right.gif'/>");
		}else if(status==0){
			$(this).find("input[name=open]").css("display","inline");
			$(this).parent().find(".status").html("<img src='/style/check_error.gif'/>");
		}
	});
}
function renderMore(key,show){
	var div = $("#"+key);
	var moreObj = div.find(".more");
	if (show){
		switch(key){
			case 'https':
				moreObj.find("textarea[name=certificate]").val(div.attr("data-certificate"));
				moreObj.find("textarea[name=key]").val(div.attr("data-key"));
				moreObj.find("input[name=cipher]").val(div.attr("data-cipher"));
				moreObj.find("input[name=protocols]").val(div.attr("data-protocols"));
				break;
			case 'firewall':
//				moreObj.find("input[name=frcquency]").attr("checked",false);
//				moreObj.find("input[value="+div.attr("data-frcquency")+"]").attr("checked",true);
//				moreObj.find("input[name=model]").attr("checked",false);
//				moreObj.find("input[value="+div.attr("data-model")+"]").attr("checked",true);
				break;
			case 'long':
				moreObj.find("input[name=second]").val(div.attr("data-second"));
				break;
			case 'cache':
				break;
		}
		div.find("input[name=open]").val("收起");
		div.find("input[name=open]").attr("onclick","renderMore('"+key+"',false)");
		div.find("input[name=modify]").val("收起");
		div.find("input[name=modify]").attr("onclick","renderMore('"+key+"',false)");
		moreObj.slideDown();
		return 
	}
	div.find("input[name=open]").val("打开");
	div.find("input[name=modify]").val("设置");
	div.find("input[name=open]").attr("onclick","renderMore('"+key+"',true)");
	div.find("input[name=modify]").attr("onclick","renderMore('"+key+"',true)");
	moreObj.slideUp();
}
function emptyForm(id){
	var div = $("#"+id);
	div.find(".more").find("textarea").val("");
	div.find(".more").find("input[type=text]").val("");
}
function addHttpsConfig(id){
	if(renderLoading()){
		showMsg("上次的操作还在进行中，请稍候",3);
		return ;
	}
	var div = $("#"+id);
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
		type:"POST",
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code==1){
				div.attr("data-certificate",certificate);
				div.attr("data-key",https_key);
				div.attr("data-cipher",cipher);
				div.attr("data-protocols",protocols);
				modifyStatus(id,1);
				renderStatus();
				renderMore(id,false);
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
function modifyStatus(id,value){
	$("#"+id).find(".oprate").attr("data-status",value);
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
function renderCustomFrequency(key){
	var div = $(".lable").eq(key).find(".cc_normal");
	var ischecked = div.find("input[value=custom]").attr("checked");
	if(ischecked){
		div.find(".margin_left").css("display","block");
	}else{
		div.find(".margin_left").css("display","none");
	}
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
function addCcConfig(id){
	if(renderLoading()){
		showMsg("上次的操作还在进行中，请稍候",3);
		return ;
	}
	var div = $("#"+id).find(".cc_normal");
	var frcquency = div.find("input[name=frequency]:checked").val();
	if(frcquency == "off"){
		deleteConfig(id,'anticc');
		return;
	}
	var model = div.find("input[name=model]:checked").val();
	var custom_model_value = div.find("textarea[name=custom-model-textarea]").val();
	var custom_request=div.find('input[name=request]').val();
	var custom_second = div.find('input[name=second]').val();
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=addCcConfig",
		dataType:"json",
		type:"POST",
		data:{	
					frcquency:frcquency,
					model:model,
					custom_model_value:custom_model_value,
					request:custom_request,
					second:custom_second
			},
		success:function(a){
			renderLoading(false);
			if (a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return ;
			}
			div.attr("data-frcquency",frcquency);
			div.attr("data-model",model);
			modifyStatus(id,1);
			renderStatus();
//			renderMore(key,false);
			showMsg("修改成功",1);
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求异常",2);
		}
	});
}
function deleteConfig(divid,type,id){
	//if(!confirm("您确定要关闭这项功能吗？")) return ;
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=deleteConfig",
		type:"POST",
		data:{type:type,id:id},
		dataType :"json",
		success:function(a){
			renderLoading(false);
			if (a.status.code!=1){
				showMsg("修改失败"+a.status.message,2);
				return ;
			}
			showMsg("修改成功",1);
			switch(divid){
				case 'cache':  //cache config：多条记录需要特殊处理
					renderCacheDelete(divid);
					break;
				case 'firewall':
					renderCcDelete(divid);
					break;
				case 7:
					deleteblackipdiv(key,id);
					break;
				case 'rate-limit':
					deleteFlowLimit(divid);
					break;
				default:
					$("#"+divid).find(".oprate").attr("data-status",0);
					renderStatus();
					renderMore(divid,false);
			}
			return ;
		},
		error:function(){
			renderLoading(false);
			showMsg("请求失败",2);
		}
	});
}
function ipFrequency(){
	var div = $("#firewall").find(".cc_ip_frequency");
	var type = div.find("[name=type]:checked").val();
	if(type == "off"){
		ipFrequencyDel();
		return;
	}
	var time = div.find("[name=time]").val();
	var second = div.find("[name=second]").val();
	var exist_second = div.find("[name=exist_second]").val();
	if(exist_second == ""){
		exist_second = 300;
	}
	$.ajax({
		url:'/api/?c=record&a=ipFrequencyAddConfig',
		type:'POST',
		data:{type:type,time:time,second:second,exist_second:exist_second},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				showMsg("操作失败",1);
				return;
			}
			showMsg("操作成功",1);
		},
		error:function(a){
			
		}
	});
}
function ipFrequencyDel(){
	$.ajax({
		url:'/api/?c=record&a=ipFrequencyDel',
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				showMsg("操作失败",1);
				return;
			}
			showMsg("操作成功",1);
		},
		error:function(a){
			
		}
	});
}
function addCcWhiteUrlItem(divid){
	var div = $("#"+divid).find(".cc_white_urls");
	var id = div.find(".cc_white_url_item").size();
	id++;
	var template = $("#cc-white-url-add-template").html();
	var option = [];
	option.id = id;
	var html = Mustache.to_html(template,option);
	div.append(html);
}
function delCcWhiteUrlItem(id,divid){
	var div = $("#"+id).find(".cc_white_urls");
	div.find("#div" + divid).remove();
}
function addCcWhiteUrlsConfig(divid,item_num){
	var div = $("#"+divid);
	var item = div.find(".cc_white_urls").find("#div" +item_num );
	var url = item.find("input[name=url]").val();
	var id = item.attr("data-id");
	$.ajax({
		url : "/api/?c=record&a=addCcWhiteUrlsConfig",
		type:"POST",
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
				item.find("[name=submit]").attr("onclick","addCcWhiteUrlsConfig('"+divid+"',"+item_num+")");
				item.find("[name=del]").attr("onclick","updateCcWhiteUrlDeleteFlag('"+divid+"',"+item_num+");deleteConfig('firewall','cc-white-url',"+a.id+")");
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
function updateCcWhiteUrlDeleteFlag(id,divid){
	var div = $("#"+id).find(".cc_white_urls");
	div.find("#div" + divid).attr("delete-flag",1);
}
function renderCcDelete(divid){
	var deletes = $("#"+divid).find(".cc_white_url_item[delete-flag=1]");
	if(deletes.size() ==0){
		renderMore(divid,true);
		$("#"+divid).find(".oprate").attr("data-status",0);
		//renderStatus();
	}else{
		deletes.remove();
	}
}
function addCcWhiteConfig(id){
	var div = $("#"+id);
	if(div.find(".oprate").attr("data-status")==0){
		showMsg("防cc功能未开启，cc白名单不可用",2);
		return ;
	}
	var ips = div.find("input[name=ips]").val();
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=addCcWhiteIpConfig",
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
function piaoAddBlackIP(){
	//var div = $(".lable").eq(key).find(".cc_white_urls");
	var div = $(".cc_black_ips").find("#list");
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
		escConfig(divid);
	});
}
function escConfig(divid){
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
				delConfig1(id);
			});
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function delConfig1(id){
	//var div = $(".lable").eq(key).find(".cc_white_urls");
	var div = $(".cc_black_ips").find("#list");
	var divid = div.find("#div"+id);
	ipId = divid.attr("data-id");
	type = divid.attr("data-name");
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=deleteConfig",
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
function addLifeTimeConfig(id){
	renderLoading(true);
	var div = $("#"+id);
	var second = div.find("input[name=second]").val();
	$.ajax({
		url : "/api/?c=record&a=addLifeTimeConfig",
		type:'POST',
		data :{second:second},
		dataType :"json",
		success :function(a){
			renderLoading(false);
			if(a.status.code!=1){
				showMsg(a.status.message ? a.status.message : "操作失败",2);
				return;
			}
			modifyStatus(id,1);
			renderStatus();
			div.attr("data-second",second);
			renderMore(id,false);
			showMsg("修改成功",1);
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
		url : "/api/?c=record&a=cacheFlushTime",
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
function AddDefaultCacheConfig(id){
	var div = $("#"+id);
	var model = div.find("input[name=model]:checked").val();
	var second = div.find("input[name=second]").val();
	var force = div.find("input[name=force]").attr("checked") =="checked"? 1 : 0;
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=AddDefaultCacheConfig",
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
function renderAddCacheConfig(id){
	var sets_div = $("#"+id).find(".sets");
	var template = $("#cache-add-template").html();
	var option = [];
	option.divid = sets_div.find("div").size();
	template = Mustache.to_html(template,option);
	sets_div.prepend(template); 
}
function removeRenderDiv(id,div_num){
	$("#"+id).find("#div"+div_num).remove();
}
function addCacheConfig(divid,div_num,id){
	var div = $("#"+divid).find("#div"+div_num);
	var model = div.find("input[name=model]:checked").val();
	var value = div.find("input[name=value]").val();
	var second = div.find("input[name=second]").val();
	var force = div.find("input[name=force]").attr("checked") ? 1 : 0;
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=addCacheConfig",
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
				div.find(".add-button").attr("onclick","addCacheConfig("+divid+","+div_num+","+a.id+")");
				div.find(".close-button").attr("onclick","javascript:modify_cache_div_delete(this);deleteConfig('"+divid+"','cache',"+a.id+");");
				div.find(".close-button").attr("value","关闭")
			}
			modifyStatus(divid,1);
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
function modify_cache_div_delete(obj){
	$(obj).parent().parent().attr("delete-flag",1);
}
function renderCacheDelete(key){
	$("#"+key).find("div[delete-flag=1]").remove();
}
function addGzipConfig(id){
	var div = $("#"+id);
	var gzip = "";
	div.find("input[name=gzip]").each(function(){
		if($(this).attr("checked")){
			gzip += $(this).val()+",";
		}
	});
	gzip = gzip.substr(0,gzip.length-1);
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=addGzipConfig",
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
			renderMore(id,false);
			return ;
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function piaoAddRedirect(key){
	var div = $("#"+key).find(".cc_white_urls");
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
		url : "/api/?c=record&a=setCdnDomainRedirect",
		type:'POST',
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
				delConfig(id,'domain-location');
			});
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function delConfig(id,key){
	var div = $("#"+key).find(".cc_white_urls");
	var divid = div.find("#div"+id);
	ipId = divid.attr("data-id");
	type = divid.attr("data-name");
	renderLoading(true);
	$.ajax({
		url : "/api/?c=record&a=deleteConfig",
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
	var div = $("#"+key).find(".cc_white_urls");
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
	if(key == 'hotlink'){
		divid.find("#url").bind('click',function(){
			editInputTip(divid,'url');
		});
		divid.find("#domain").bind('click',function(){
			editInputTip(divid,'domain');
		});
		divid.find("#key").bind('click',function(){
			editInputTip(divid,'key');
		});
	}
}
function addChainConfig(divid,id){
	var referer = divid.find("input[name=referer]").val();
	var target = divid.find("input[name=target]").val();
	var type = divid.find("[name=type]:checked").val();
	$.ajax({
		url : "/api/?c=record&a=addAntiReferer",
		data :{referer:referer,target:target,id:id,type:type},
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
				delConfig(id,'hotlink');
			});
		},
		error:function(e){
			renderLoading(false);
			showMsg("请求发生异常！",2);
		}
	});
}
function editInputTip(divid,name){
	var tip = "";
	if(name == 'url'){
		tip = "URL正则表达式";
	}
	if(name == 'domain'){
		tip = "a.com|*.a.com";
	}
	if(name == 'key'){
		tip = "签名秘钥";
	}
	divid.find("[name=referer]").attr("placeholder",tip);
}
function editChain(id,key){
	var div = $("#"+key).find(".cc_white_urls");
	var divid=div.find("#div"+id);
	id =divid.attr("data-id");
	addChainConfig(divid,id);
}
//增加RTMP规则(朱德朝)
function addRtmpInput(){
	var template = $("#add-rtmp-input-template").html();
	var div = $("#rtmp");
	var divid = time = (new Date()).valueOf();
	var media_type_val = 0;
	var option = [];
	option.id = divid;
	var html = Mustache.to_html(template,option);
	div.find("#list").append(html);
	div.find("#list").find("#"+divid).find("[name=media]").bind('click',function(){
		media_type_val = selectMediaType(divid);
	});
	div.find("#list").find("#"+divid).find("#esc").bind('click',function(){
		removeRtmpTemplate(divid);
	});
	div.find("#list").find("#"+divid).find("#enter").bind('click',function(){
		var url = div.find("#list").find("#"+divid).find("[name=url]").val();
		var rtmp = div.find("#list").find("#"+divid).find("[name=rtmp]").val();
		var div_id = divid;
		submitRtmpSet(url,rtmp,div_id,media_type_val);
	});
}
//获取媒体类型
function selectMediaType(id){
	var val = $("#rtmp").find("#"+id).find("[name=media]:checked").val();
	if(val == 1){
		$("#rtmp").find("#"+id).find("#rtmp_text").show();
	}else{
		$("#rtmp").find("#"+id).find("#rtmp_text").hide();
		$("#rtmp").find("#"+id).find("#rtmp_text").find("[name=rtmp]").val("");
	}
	return val;
}
//移除RTMP  模板(朱德朝)
function removeRtmpTemplate(key){
	var div = $("#rtmp");
	div.find("#list").find("#"+key).remove();
}
//提交RTMP 设置(朱德朝)
function submitRtmpSet(url,rtmp,divid,type){
	//alert(url+'--'+rtmp+'--'+divid+'--'+type);
	//return;
	$.ajax({
		url:'/api/?c=record&a=rtmpSet',
		type:'POST',
		data:{url:url,rtmp:rtmp,type:type},
		dataType:'json',
		success:function(a){
			if(a.status.code == 1){
				showMsg("添加成功",1)
				$("#"+divid).find("#esc").remove();
				$("#"+divid).find("#enter").remove();
				$("#"+divid).find("#delete").show();
				$("#"+divid).find("#edit").show();
				$("#"+divid).find("#delete").bind('click',function(){
					//removeRtmpSet(id);
					var id = a.id;
					deleteRtmpSet(id,divid);
				});
				$("#"+divid).find("#edit").bind('click',function(){
					editRtmpSet(a.id,divid);
				});
				return;
			}
			alert("RTMP设置失败");
			return;
		},
		error:function(a){
			
		}
	});
}
//修改rtmp配置(朱德朝)
function editRtmpSet(id,divid){
	if(divid > 0){
		var url = $("#"+divid).find("[name=url]").val();
		var rtmp = $("#"+divid).find("[name=rtmp]").val();
		var type = $("#"+divid).find("[name=media]:checked").val();
	}else{
		var url = $("#rtmp").find("#"+id).find("[name=url]").val();
		var rtmp = $("#rtmp").find("#"+id).find("[name=rtmp]").val();
		var type = $("#rtmp").find("#"+id).find("[name=media]:checked").val();
	}
	$.ajax({
		url:'/api/?c=record&a=editRtmp',
		type:'POST',
		data:{url:url,rtmp:rtmp,type:type,rid:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert("操作失败");
				return;
			}
			showMsg("添加成功",1)
		},
		error:function(a){
			
		}
	});
}
//删除rtmp设置
function deleteRtmpSet(id,divid){
	$.ajax({
		url:'/api/?c=record&a=deleteRtmp',
		type:'POST',
		data:{id:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert("删除失败");
				return;
			}
			showMsg("删除成功",1);
			$("#rtmp").find("#list").find("#"+divid).remove();
		},
		error:function(a){
			
		}
	});
}
function addOnlineTemplate(){
	$("#online").find("#config").show();
	var template = $("#online-input-template").html();
	var div = $("#online");
	var list_html = div.find("#config").find("#list").find("div").html();
	if(list_html){
		return;
	}
	var divid = time = (new Date()).valueOf();
	var option = [];
	option.id = divid;
	var html = Mustache.to_html(template,option);
	$("#online").find("#config").find("#list").append(html);
	div.find("#config").find("#list").find("#enter").bind('click',function(){
		var url = div.find("#config").find("#list").find("[name=url]").val();
		var type = div.find("[name=online_type]:checked").val();
		onlineSet(url,type,divid);
	});
	div.find("#config").find("#list").find("#esc").bind('click',function(){
		removeOnlineTemplate(divid);
	});
}
function removeOnlineTemplate(id){
	$("#online").find("#config").find("#list").find("#div"+id).remove();
}
function onlineSet(url,type,divid){
	$.ajax({
		url:'/api/?c=record&a=onlineAddConfig',
		type:'POST',
		data:{url:url,type:type},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert("URL提交失败");
				return;
			}
			if(type == 1){
				showMsg("操作成功",1);
				$("#online").find("#config").find("#list").find("#div"+divid).find("#esc").remove();
				/*
				var html = "<button type='button' class='btn' id='delete'>删除</button>";
				$("#online").find("#config").find("#list").find("#div"+divid).append(html);
				$("#online").find("#config").find("#list").find("#div"+divid).find("#delete").bind('click',function(){
					onlineDel(a.id,divid);
				});
				*/
			}
			showMsg("操作成功",1);
		},
		error:function(a){
			
		}
	});
}
function editOnline(id){
	var div = $("#online");
	var url = div.find("#config").find("#list").find("[name=url]").val();
	var type = div.find("[name=online_type]:checked").val();
	onlineSet(url,type,id);
}
function addFlowLImitInput(key){
	var div = $("#"+key).find(".items");
	var option = [];
	option.divid = div.find(".item").size()
	var tem = $("#add-url-speed-limit-template").html();
	var html = Mustache.to_html(tem,option)
	div.append(html);
}
function addFlowLimit(key,divid){
	var div = $("#"+key).find(".items").find("#div" + divid);
	var url = div.find("input[name=url]").val();
	var speed = div.find("input[name=speed]").val()
	var model = div.find("input[name=model]:checked").val()
	var id = div.attr("data-id");
	$.ajax({
		type:"POST",
		dataType:"json",
		url : "/api/?c=record&a=rate_limit",
		data:{url:url,speed:speed,model:model,id:id},
		success:function(a){
			if(a.status.code != 1){
				showMsg(a.status.message,1)
				return 
			}
			showMsg("添加成功",1)
			div.attr("data-id",a.id)
			cancel_button = div.find("input[name=cancel]");
			cancel_button.attr("value","关闭");
			cancel_button.attr("onclick","updateDelFlowLimitFlag('"+key+"',"+divid+");deleteConfig('"+key+"','flow-limit',"+a.id+")")
		},
		error:function(e){
			showMsg("请求异常",2)
		}
	});
}
function updateDelFlowLimitFlag(key,divid){
	var div = $("#"+key).find(".items").find("#div" + divid).attr("delete-flag",1);
}
function deleteFlowLimit(key){
	var deletes = $("#"+key).find(".items").find("div[delete-flag=1]").remove();
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