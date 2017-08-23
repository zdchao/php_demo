rqs = []

$(document).ready(function(){
	$("#record-operat").find('li').removeClass("active");
	$("#record-operat").find('#connection').addClass('active');
	var Connection = function(){
		this.messagediv = $("#msg");//信息显示
		this.listdiv = $("#record-list")

		this.tbody = $("#connection_items")

		this.getConnection = function(){
			var that =this;
			that.loading();
			$.ajax({
				url:'?c=container&a=get_connection&name='+containername,
				dataType:'json',
				type:'POST',
				success:function(a){
				   that.loadComplete();
					if (a.status.code!= 1) {
						that.showMessage(a.status.message,2);
						return;
					}
					eval(a.ret);	
					that.sort(1);
					return 
				},
				error:function(e){
					that.showMessage('后台数据出错'+e.responseText,2);
				}
			});
		}
		this.show_url = function(url,len) {
			var s='<a href=\''+url+'\' title=\'' + url + '\' target=_blank>';
			if(url.length>len) { s += url.substr(0,len) + '...';} else { s += url;} 
			s += '</a>';return s;
		}
		
		this.getRow = function(s,index) {
			if (index==5 || index==7) {
				return this.show_url(s,50);
			}
			return s;
		}
		this.renderConncections = function(obj_orig,first){
			
			var obj = {}
			for(var pro in obj_orig){
				obj[pro] = obj_orig[pro]
			}
			obj[5] = this.show_url(obj[5],50)
			obj[7] = this.show_url(obj[7],50)
			obj[1] = "<a title='加入黑名单' href='javascript:addBlackIp(\""+obj[1]+"\");'><i class='icon-ban-circle'></i></a> "+obj[1]
			if(first){
				obj[sortIndex]  = "(<strong  style='color:red'>"+obj["priority"]+"</strong>)" + obj[sortIndex] 
			}
			var str = "<tr><td>"+obj[1]+"</td><td>"+obj[2]+"</td><td>"+obj[3]+"</td><td>"+obj[4]+"</td><td>"+obj[5]+"</td><td>"+obj[7]+"</td></tr>";
			this.tbody.append(str)
		}
		this.loadComplete = function(){
			this.messagediv.html('');
			this.messagediv.css("display","none");
		}
		this.loading = function() {
			this.messagediv.html('正在载入...<img src="/style/busy.gif">');
			this.messagediv.css("display","block");
		}
		this.showMessage = function(msg,code){	
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
		this.sort = function (index){
			sortIndex = index
			reverve = !reverve
			this.tbody.find("tr").remove()
			var start_time  = (new Date).getTime()
			isfirst = {}  //reset variable
			rqs.sort(sortRequest);
			makePriority(rqs)
			appendR(rqs,max_priority,reverve)
			var sort_time =( (new Date()).getTime() - start_time )  /1000
			$("#sort_time").find("strong").html(sort_time)
			$("#total").find("strong").html(rqs.length)
			if(this.tbody.find("tr").size()==0){
				this.tbody.append("<tr><td colspan='6' style='color:red; font-style:italic'>无数据</td></tr>");
			}
		}
	}
	$("#left").find("#connection").addClass("active");
	$("#left_group_list").find('div').eq(1).addClass('cur');
	
	connections = new Connection();
	connections.getConnection();
})
reverve = true

function addBlackIp(ip){
	$.ajax({
		url : "?c=vhost&a=addBlackIp",
		data :{ip:ip},
		dataType :"json",
		type:"POST",
		success :function(a){
			if(a.status.code!=1){
				connections.showMessage(a.status.message,2);
				return;
			}
			connections.showMessage("操作成功", 1)
		},
		error:function(e){
			connections.showMessage("请求异常", 2)
		}
	});
}

function sort(index){
	sortDesc = !sortDesc
	connections.sort(index);
}



sortDesc = true
sortIndex = 1;

function sortRequest(a,b)
{	
	if (sortIndex==2) 
	{		
			if (sortDesc) 
			{			
					return b[sortIndex] - a[sortIndex];		
			}else {
					return a[sortIndex] - b[sortIndex];		
			}	
	}	
	if(sortDesc){
		return b[sortIndex].localeCompare(a[sortIndex]);	
	}else{
		return a[sortIndex].localeCompare(b[sortIndex]);	
	}
}


function makePriority(arr){
	var len = arr.length
	var last_pried_index = 0
	var times = 1;
	max_priority = 1;
	for(var i =0;i<len;i++){
		if(arr[i+1] == undefined || arr[i+1][sortIndex] != arr[i][sortIndex]){  // last index or i not equal i+1 compare by sort index
			for(var j=last_pried_index;j<=i;j++){
				arr[j]["priority"] = times
			}
			last_pried_index = i+1
			if(times>max_priority){
				max_priority = times
			}
			times = 1;
		}else{
			times++
		}
	}
}

isfirst = {}
function appendR(arr,priority,reverve){
	if(priority == 0){
		return 
	}
	var len = arr.length
	if(!reverve){
		for(var i =0;i<len;i++){
			if(arr[i]["priority"] == priority){
				if(isfirst[arr[i][sortIndex]] == undefined){
					connections.renderConncections(arr[i],true)
					isfirst[arr[i][sortIndex]] =1
				}else{
					connections.renderConncections(arr[i],false)
				}
			}
		}
		appendR(arr,priority-1,reverve)
	}else{
		appendR(arr,priority-1,reverve)
		for(var i =0;i<len;i++){
			if(arr[i]["priority"] == priority){
				if(isfirst[arr[i][sortIndex]] == undefined){
					connections.renderConncections(arr[i],true)
					isfirst[arr[i][sortIndex]] =1
				}else{
					connections.renderConncections(arr[i],false)
				}
			}
		}
	}
}


