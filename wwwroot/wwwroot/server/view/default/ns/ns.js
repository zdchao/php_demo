function edit_ip(ip,value)
{
	var r = confirm("确定要修改?");
	if (!r) {
		return;
	}
	$.ajax({url:'?c=ip&a=edit',data:{ip:ip,view:value},dataType:'json',success:function(ret) {
		if (ret['code'] != 200) {
			alert('修改失败');
		}else {
			window.location = window.location;
		}
	}})	;
}
function create_result_html(nic)
{
	var html='';
	if (typeof(nic)=='undefined') {
		return '-<br>';
	}
	if (nic.toString() =='false') {
		html = '获取失败<br>';
	} else {
		for (var i in nic) {
			html += '<ul>';
			for ( var j in nic[i]) {
				if (i=='delip') {
					html += '<li title="需到上级删除"><s>' + nic[i][j] + '</s></li>';
				}else {
					html += '<li title="需到本地添加"><i>' + nic[i][j] + '</i></li>';
				}
			}
			html += '</ul>';
		}
	}
	return html;
}
function check_ns(id,nodialog)
{
	if (nodialog !== 1) {
		var dialog = art.dialog({id:'check_ns',content:'正在查询...',icon:'',lock:true});
	}
	$.ajax({
		url:'?c=ns&a=checkNs',
		data:{id:id},
		dataType:'json',
		type:'POST',
		async:false,
		success:function (a) {
			var html = '<div>上级:' + create_result_html(a.nic);
			html += '本地:' + create_result_html(a.dig);
			html += '</div>';
			$("#checknsresult"+id).html(html);	
			if (nodialog != 1) {
				dialog.close();
			}
		}
	})
}
function check_all_ns()
{
	var dialog = art.dialog({id:'check_ns',content:'正在查询...',icon:'',lock:true});
	$(".checkns").each(function(){
		var id = $(this).text();
		dialog.content('正在查询id='+id);
		check_ns(id,1);
	});
	dialog.close();
}
function piao_add_ns()
{
	var template = $("#piao-add-ns-template").html();
	dia = art.dialog({id:'piao_add_ns',content:template,lock:true,top:'10%',width:'45em'});
	var div = $("#piao-add-ns");
	div.find("#enter").bind({
		'click':function(){
			add_ns.submit();
		}
	});
	
}
function check_status(id)
{
	alert(id);	
}