$(document).ready(function(){
	$("#left_ul").find("li").eq(0).attr("class",'active');
	$("#nav_my_domain").addClass('cur');
	$("#search_domain").bind('keypress', function(e) {
		var keycode;
		if(window.event){
			keycode = e.keyCode; //IE
		}
		else if(e.which){keycode = e.which;}
		if(keycode != 13){return;}
		searchDomain();
	});
});
var domain_arr = [];
function domainStatus(name){
	$.ajax({
		url:'?c=managedomain&a=domainStatus',
		data:{name:name},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				return;
			}
			alert(a.ret);
		},
		error:function(a){
			alert("error");
		}
	});
}
//全选checkbox
function allCheckbox(){
	var check = $("[name=checkbox_all]").is(":checked");
	if(check){
		eachInputCheckbox(true);
	}else{
		eachInputCheckbox(false);
	}
}
function eachInputCheckbox(val){
	$("input[name=name_domain]").each(function(){
			this["checked"] =  val ? "checked" : "";
	});
}
//获得checkbox选中数据
function obtainData(){
	var a = $("[name=name_domain]");
	var list_length = 0;
	domain_arr.length = 0;
	for(var i in a){
		if(a[i].checked){
			list_length++;
			domain_arr.push(a[i].value);
		}
	}
	if(list_length < 1){
		return false;
	}
	return true;
}
//打开修改dns模态框
function openModifyDnsModal(){
	var ret = obtainData();
	if(ret == false){
		$("#modal_tip").modal({
			keyborad:true
		});
		$("#modal_tip").find("#modal_tip_content").html("请选择域名");
		return;
	}
	$("#myModal").modal({
		keyboard: true
	});
	/*
	$.ajax({
		url:'?c=managedomain&a=getDns',
		dataType:'json',
		success:function(a){
			$("#myModal").find("[name=dns1]").val(a.dns1);
			$("#myModal").find("[name=dns2]").val(a.dns2);
		},
		error:function(a){
			alert("error");
		}
	});
	*/
}
function modifyDnsEnter(){
	var html = '<div id="modify_result" style="height:100px;margin:10px 0 0 0;overflow-y:scroll"><div id="loading" style="margin:50px 0 0 20%">正在努力加载</div></div>';
	$(".modal-body").append(html);
	var radio_value = $("[name=modify-dns]:checked").val();
	if(radio_value == 1){
		var dns1 = "";
		var dns2 = "";
	}
	if(radio_value == 2){
		var dns1 = $("[name=user-defined-dns1]").val();
		var dns2 = $("[name=user-defined-dns2]").val();
	}
	$("#myModal").find("#btn-modify_dns").attr("disabled","disabled");
	for(var i in domain_arr){
		modifyDns(domain_arr[i],dns1,dns2,radio_value);
	}
}
function modifyDns(domain,dns1,dns2,dns_status){
	$.ajax({
		url:'?c=managedomain&a=modifyDns',
		type:'POST',
		data:{domain:domain,dns1:dns1,dns2:dns2,status:dns_status},
		dataType:'json',
		success:function(a){
			$("#loading").remove();
			var html = "<div style='margin:0 0 0 25%'>"+domain+"--"+a.ret+"</div>";
			$("#modify_result").append(html);
		},
		error:function(a){
			alert("error");
		}
	});
}
//域名转入模态框
function showDomainShiftToModal(){
	$("#domain_shift_to").modal({
		keyboard:true
	});
}
//域名转入
function domainShisfTo(){
	var html = '<div id="shift_to_result" style="height:15px;"><div id="loading" style="margin:20px 0 0 20%">正在提交转入申请...</div></div>';
	var div = $("#domain_shift_to");
	div.find("#shift_to").attr("disabled","disabled");
	div.find("#shift_to_tip").append(html);
	var domain = div.find("[name=domain]").val();
	var passw = div.find("[name=passw]").val();
	$.ajax({
		url:'?c=managedomain&a=domainShiftTo',
		type:'POST',
		data:{domain:domain,passw:passw},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				div.find("#shift_to_result").find("#loading").html(a.ret);
				return;
			}
			div.find("#shift_to_result").find("#loading").html("申请提交成功");
		},
		error:function(a){
			alert("error");
		}
	});
}
/*域名解析
 * 
 */
function domainResolution(domain){
	$.ajax({
		url:'?c=managedomain&a=domainResolution',
		type:'POST',
		data:{domain:domain},
		dataType:'json',
		success:function(a){
			if(a.status.code == 5){
				window.location.href="?c=session&a=loginForm";
				return;
			}
			if(a.status.code != 1){
				alert(a.ret);
				return;
			}
			window.location.href = "/user/?c=public&a=record&domain="+domain+"&groupid=-1";
		},
		error:function(a){
			
		}
	});
}
/*
 * 续费
 */
function domainRenewal(){
	var ret = obtainData();
	if(ret == false){
		$("#modal_tip").modal({
			keyborad:true
		});
		$("#modal_tip").find("#modal_tip_content").html("请选择域名");
		return;
	}
	$.ajax({
		url:'?c=renewal&a=setRenewalSession',
		type:'POST',
		data:{arr:domain_arr},
		dataType:'json',
		success:function(a){
			window.location.href="?c=renewal&a=domainRenewalPage";
		},
		error:function(a){
			
		}
	});
}
/*
 * 修改域名信息
 */
function modifyDomaininfo(){
	var ret = obtainData();
	if(!ret){
		showTipModal();
		return;
	}
	$.ajax({
		url:'?c=managedomain&a=setDomainSession',
		type:'POST',
		data:{list:domain_arr},
		dataType:'json',
		success:function(a){
			window.location.href = "?c=managedomain&a=modifyDomaininfoHtml";
		},
		error:function(a){
		}
	});
}
/*
 * 公用方法
 */
function showTipModal(){
	$("#modal_tip").modal({
		keyborad:true
	});
	$("#modal_tip").find("#modal_tip_content").html("请选择域名");
	return;
}
//搜索域名
function searchDomain(){
	var domain = $("#search_domain").val();
	window.location.href = "?c=managedomain&a=domainManagement&domain="+domain;
}
