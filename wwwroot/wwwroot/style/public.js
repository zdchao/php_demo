function go_to(url)
{
	window.location = url;
}
function success_msg(msg)
{
	art.dialog({id:'success',time:2,content:msg,icon:'succeed'});
}
function error_msg(msg)
{
	art.dialog({id:'error',time:2,content:msg,icon:'error'});
}
function warning_msg(msg)
{
	art.dialog({id:'warning',time:2,content:msg,icon:'warning'});
}
function loadscript(url) 
{
    var script = document.createElement("script");
    script.type = 'text/javascript';
    script.src = url;
    document.body.appendChild(script);
}
function ajax(url,data,locationurl)
{
	jQuery.ajax({
		url : url +'&ajax=1',
		type:'get',
		data:data,
		dataType : 'json',
		success : function(ret) {
			if (ret['code'] != 200) {
				var msg = ret['msg'] ? ret['msg'] : '操作失败';
				art.dialog({id:'id22',content:msg});
				return;
			}
			window.location = locationurl ? locationurl : window.location;
		}
	});
}
function myAjax(url,data,successfunction)
{
	$.ajax({
		url : url +'&ajax=1',
		type:'get',
		data:data,
		dataType : 'json',
		success : function(ret) {
			successfunction(ret);
		},
		error:function(e){
			alert('后台数据出错'+e.responseText);
		}
	});
	
}

