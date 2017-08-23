 $(document).ready(function(){
	 $("#left").find("#containerSetting").addClass("active");
	 $("#left_group_list").find('div').eq(1).addClass('cur');
 });
 function piaoModifyRenew(key){
	 var tr = $("#tr"+key);
	 var beforeHtml = tr.html();
	 var html = $("#renew-setting-template").html();
	 var option = [];
	 option.renew = containerinfo.auto_renew==0?"":"yes";
	 html = Mustache.to_html(html,option);
	 tr.html(html);
	 tr.find("#enter").bind('click',function(){
		 submit(tr);
	 })
	  tr.find("#esc").bind('click',function(){
		tr.html(beforeHtml);
	 })
 }
 function submit(div){
	 var value = div.find('input[name=renew]:checked').val();
	 div.find("#enter").addClass("disabled");
	 showMessage("正在执行中...");
	 $.ajax({
			url:"?c=containersetting&a=modifyRenew",
			dataType:'json',
			data:{auto_renew:value,name:containername},
			type:'post',
			success:function(a){
			div.find("#enter").removeClass("disabled");
				if(a.status.code!=1)
				{
					showMessage(a.status.message,true);
					return;
				}
				window.location.reload();
			},
			error:function(a){
				showMessage("error",true);
			}
		});
 }
var showMessage = function(message,clear){
	   var messagediv = $("#message");
		messagediv.html(message).addClass('alert alert-success');
		if (clear) {
			messagediv.html(message).addClass('alert alert-success');
			setTimeout(function() {
				messagediv.html('').removeClass();
			}, 5000);
		}
}

function getOnlineFileManage(){
	$.ajax({
		url:'?c=containersetting&a=onlineFileStatus',
		dataType:"json",
		data:{name:containername},
		success:function(a){
			if(a.status.code != 1){
				showMessage(a.status.message,true);
				return ;
			}
			var status = parseInt( a.ret);
			$("#online_file").attr("data-status",status);
			
			renderOnlineFile();
		},
		error:function(){
			showMessage("请求失败",true);
		}
	});
}
function renderOnlineFile(){
	var status = $("#online_file").attr("data-status");
	var status_div = $("#online_file").find("#status");
	var str = '';
	if(status == 0){
		str = '<span class="label label-important">已关闭</span>';
	}else{
		str = '<span class="label label-info">已开启</span>';
	}
	status_div.html(str);
}

function piaoModifyOnlineFile(){
	var tr = $("#online_file");
	var esc_html = tr.html();
	var  status= tr.attr("data-status");
	status = status == '0' ? false : true;
	var template = $("#onlinefile-modify-template").html();
	var option = [];
	option["status"] = status;
	var html = Mustache.to_html(template,option);
	tr.html(html);
	tr.find("#enter").on("click",function(){
		var new_status = tr.find("input[name=status]:checked").val();
		if (status == new_status){
			showMessage("状态无变化",true);
			return ;
		}
		modifyOnlineFile(new_status);
	});
	tr.find("#esc").on("click",function(){
		tr.html(esc_html);
	});
}

function modifyOnlineFile(new_status){
	$.ajax({
		url:"?c=containersetting&a=changeOnlineFile",
		dataType:"json",
		type:"POST",
		data:{status:new_status,name:containername},
		success:function(a){
			if(a.status.code != 1){
				showMessage(a.status.message,true);
				return ;
			}
			//TODO DOM操作
			window.location.reload()
		},
		error:function(){
			showMessage("请求失败",true);
		},
	});
}

$(function(){
	getOnlineFileManage();
});
