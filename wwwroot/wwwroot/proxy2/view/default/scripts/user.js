function createNsSelect(rows,nsid,selectname)
{
	var html = '<select name="'+selectname+ '" style="width:160px">';
	html += '<option value=0>无</option>';
	for ( var i in rows) {
		html += '<option value='+i;
		if (i == nsid) {
			html += ' selected';
		}
		html += '>'+rows[i]+'</option>'; 
	}
	html += '</select>';
	return html;
}
var nslist = [];
function getNsList(callback)
{
	$.ajax({
		url:'?c=ns&a=getList',
		async:false,
		dataType:'json',
		success:function(a) {
			if (a.status.code != 1) {
				alert(a.status.message);
				return;
			}
			if (a.list != null) {
				nslist = a.list;
			}
			if (callback) {
				callback();
			}
		},
		error:function(e) {
		}
	});
}
function idToName(istwo)
{
	$(".nstd").each(function(){
		var name = getNsName($(this).attr('data-id'));
		if (name) {
			$(this).text(name);
		}
	});
}
function piao_custom_ns(id)
{
	var tr = $("#tr"+id);
	var template = $("#piao-edit-ns-template").html();
	var option = [];
	option.ns1html = createNsSelect(nslist,tr.find('#ns1id').attr('data-id'), 'ns1id');
	option.ns2html = createNsSelect(nslist,tr.find('#ns2id').attr('data-id'), 'ns2id');
	option.ns3html = createNsSelect(nslist,tr.find('#ns3id').attr('data-id'), 'ns3id');
	option.ns4html = createNsSelect(nslist,tr.find('#ns4id').attr('data-id'), 'ns4id');
	var el = Mustache.to_html(template,option);
	dia = art.dialog({id:'piao_edit_ns',lock:true,content:el,top:'10%',title:'修改用户默认NS'});
	var div = $("#piao-edit-ns");
	div.find('#esc').bind('click',function(){
		dia.close();
	});
	div.find('#enter').bind({
		'click':function(){
			custom_ns(id);
		}
	});
}
function getNsName(id)
{
	for (var i in nslist) {
		if (i == id) {
			return nslist[i];
		}
	}
	return '';
}
function custom_ns(id)
{
	var div = $("#piao-edit-ns");
	var tr = $("#tr"+id);
	
	var ns1 = div.find('[name=ns1id]').val();
	var ns2 = div.find('[name=ns2id]').val();
	var ns3 = div.find('[name=ns3id]').val();
	var ns4 = div.find('[name=ns4id]').val();
	
	dia.content("正在执行中......");
	$.ajax({
		url:'?c=users&a=editCustomNs',
		data:{uid:id,ns1:ns1,ns2:ns2,ns3:ns3,ns4:ns4},
		dataType:'json',
		success:function(a) {
			dia.close();
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			tr.find('#ns1id').attr('data-id',ns1).html(getNsName(ns1));
			tr.find('#ns2id').attr('data-id',ns2).html(getNsName(ns2));
			tr.find('#ns3id').attr('data-id',ns3).html(getNsName(ns3));
			tr.find('#ns4id').attr('data-id',ns4).html(getNsName(ns4));
		},
		error:function(e) {
			dia.close();
			alert('后台数据出错'+e.responseText);
		}
	});
}
function change_status(id)
{
	$.ajax({
		url:'?c=users&a=changeStatus&id='+id,
		dataType:'json',
		success:function(a) {
			if (a.code != 200) {
				alert(a.message);
				return ;
			}
			$("#edit_status"+id).html("已激活");
		},
		error:function(e) {
			alert('后台数据出错'+e.responseText);
		}
	});
}
function ban_add_domain(uid,status)
{
	var rowdiv = $("#tr"+uid);
	var fn = status==2 ? 'banAddDomain' :'nobanAddDomain';
	var html = status==2 ? '[<a href="javascript:ban_add_domain('+uid+',0)">不禁域名</a>]' : '[<a href="javascript:ban_add_domain('+uid+',2)">禁加域名</a>]';
	$.ajax({
		url:'?c=users&a='+fn+'&uid='+uid,
		dataType:'json',
		success:function(a) {
			if (a.code != 1) {
				alert(a.message);
				return;
			}
			rowdiv.find('#status').find('#ban').html(html);
		},
		error:function(e) {
			
		}
	});
}
$(document).ready(function(){
	getNsList();
	idToName();
});