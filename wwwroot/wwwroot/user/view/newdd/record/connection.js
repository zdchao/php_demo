rqs = []

$(document).ready(function(){
	//$("#record-operat").find('li').removeClass("active");
	$("#record-operat").find('#connection').find('a').addClass('cur');
	var Connection = function(){
		this.messagediv = $("#msg");//信息显示
		this.listdiv = $("#record-list")
		this.getConnection = function(){
			var that =this;
			that.loading();
			$.ajax({
				url:'/api/?c=record&a=get_connection',
				dataType:'json',
				type:'POST',
				success:function(a){
				   that.loadComplete();
					if (a.status.code == 6) {
						that.renderLoginError();
						return;
					}
					if(a.status.code != 1)
					{
						that.showMessage(a.status.message,2);
						return;
					}
					for(var i in a.nodes){
						eval(a.nodes[i]["msg"]);	
					}
					that.sort(1);
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
		this.renderLoginError = function() {
			var template = $("#site-nologin-template").html();
			$("#table").append(template);
		}
		this.getRow = function(s,index) {
			if (index==5 || index==7) {
				return this.show_url(s,50);
			}
			return s;
		}
		this.renderConncections = function(){
			var tbody = $("#connection_items");
			var times = 1;
			for (var i in rqs){
				var a = [];
				for(var j in rqs[i]){
					a[j] = this.getRow(rqs[i][j],j);
				}
				i_next  = (parseInt(i)+1).toString()				
				if(parseInt(i)<rqs.length-1 && rqs[i][sortIndex] == rqs[i_next][sortIndex] ){				
					times++;
				} else {
					a[sortIndex] = "<strong style='color:red'>(" + times + ")</strong>" + a[sortIndex];
					times = 1;
				}
				tbody.append("<tr><td><a href='javascript:addBlackIp(\""+rqs[i][1]+"\");'><i class='icon-ban-circle'></i></a> "+a[1]+"</td><td>"+a[2]+"</td><td>"+a[3]+"</td><td>"+a[4]+"</td><td>"+a[5]+"</td><td>"+a[7]+"</td></tr>");
			}
			$("#total").html("连接总数:"+rqs.length)
			if(tbody.find("tr").size()==0){
				tbody.append("<tr><td colspan='6' style='color:red; font-style:italic'>无数据</td></tr>");
			}
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
			rqs.sort(sortRequest);
			$("#connection_items").find("tr").remove();
			this.renderConncections()
		}
		
	}
	connections = new Connection();
	connections.getConnection();
})

function addBlackIp(ip){
	$.ajax({
		url : "/api/?c=record&a=addBlackIp",
		data :{ip:ip},
		dataType :"json",
		type:"POST",
		success :function(a){
			if(a.status.code!=1){
				alert(a.status.message);
				return;
			}
			alert("操作成功！");
		},
		error:function(e){
			alert("请求发生异常！");
		}
	});
}

function sort(index){
	sortDesc = !sortDesc
	connections.sort(index);
}



sortDesc = true
sortIndex = 0;

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
