$(document).ready(function(){
	function domainClass(){
		this.domainlist = [];
		this.messagediv = $("#message");
		this.mirro = "";
		this.selectArr = [];//被选中的
		this.multiresult = [];
		this.multiresult.success= [];
		this.multiresult.error= [];
		this.cnamediv = $("#cname");
		this.cname = "";
		this.tipsdiv =  $("#record-tips");
		this.advanced = false;
		this.getInfo = function (){
			var that = this;
			$.ajax({
				url:"?c=containerdomain&a=getList",
				data:{name:containername},
				dataType:'json',
				type:'get',
				success:function(a){
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					if(a.rows){
						that.domainlist = a.rows;
						that.mirro = a.mirro;
						that.renderDomain();
					}
					that.renderHead();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.renderHead = function(){
			var that = this;
			$("#add").bind('click',function(){
				that.piaoAddDomain();
			});
			$("#selectall").bind('click',function(){
				that.selectAll();
			});
			$("#del").bind('click',function(){
				that.piaoDelMulti();
			});
		}
		this.piaoDelMulti = function(){
			var that = this;
			if(this.selectArr.length <=0){
				that.showMessage("您没有选中记录",true);
				return;
			}
			this.derferDelMulti(0);
		}
		this.piaoAddDomain = function(){
			if(this.advanced !== false){
				this.addDomain();
				return;
			}
			var that = this;
			$.ajax({
				url:"?c=container&a=getImagesByName&name="+that.mirro,
				dataType:'json',
				type:'get',
				success:function(a){
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.advanced = a.ret.advanced;
					that.addDomain();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.addDomain = function(){
			var that = this;
			var tem = $("#add-domain-template").html();
			$("tbody").prepend(tem);
			var div = $("tbody").find("tr").eq(0);
			if(this.advanced !=1){
				div.find("[name=dir]").remove();
			}
			div.find("#enter").bind('click',function(){
				that.submitDomain(div);
			});
			div.find("#esc").bind('click',function(){
				div.remove();
			});
		}
		this.submitDomain = function(div){
			var that = this;
			var domain = div.find("input[name=domain]").val();
			var dir = div.find("input[name=dir]").val();
			div.find("#enter").addClass("disabled");
			$.ajax({
				url:"?c=containerdomain&a=add&name="+containername,
				dataType:'json',
				data:{domain:domain,dir:dir},
				type:'post',
				success:function(a){
				div.find("#enter").removeClass('disabled');
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("添加域名成功",true);
					var row = [];
					row.id = a.id;
					row.domain = domain;
					row.dir = dir;
					that.arrPush(row);
					div.remove();
					//that.confirmBind(domain);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.confirmBind = function(domain){
			var that = this;
			var html = $("#confirm-bind-template").html();
			var option = [];
			option.domain  =domain;
			html = Mustache.to_html(html,option);
			$("tbody").prepend(html);
			var div = $("tbody").find("tr").eq(0);
			div.find("#enter").bind('click',function(){
				div.remove();
				that.tipsShow(domain);
			});
			div.find("#esc").bind('click',function(){
				div.remove();
			});
		}
		this.tipsShow = function(domain){
			var that = this;
			var html = $("#record-tips-template").html();
			var option = [];
			option.domain = domain;
			option.cname = this.cname;
			html = Mustache.to_html(html,option);
			this.tipsdiv.html(html);
			this.tipsdiv.slideDown("slow");
			this.tipsdiv.find('#esc').bind('click',function(){
				that.tipsdiv.find("#tips-content").remove();
			});
			//this.checkDomain(domain);
		}
		this.checkDomain = function(domain){
			var that = this;
			this.tipsdiv.find('ul').find('li').eq(0).find('i').removeClass().addClass('icon_loading');
			this.tipsdiv.find('ul').find('li').removeClass('action_error');
			$.ajax({
				url:"?c=containerdomain&a=checkDomain",
				dataType:'json',
				data:{domain:domain},
				type:'post',
				success:function(a){
					that.tipsdiv.find('ul').find('li').eq(0).find('i').removeClass().addClass('yun_4');
					if(a.status.code!=1)//有domain这条记录，则添加解析值。
					{
						that.addDomainNext(domain);//没有domian这条记录，这添加
						return;
					}
					that.tipsdiv.find('ul').find('li').eq(1).find('i').removeClass().addClass('yun_4');
					that.addDomainRecord(domain);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.addDomainNext = function(domain){
			var that = this;
			this.tipsdiv.find('ul').find('li').eq(1).find('i').removeClass().addClass('icon_loading');
			this.tipsdiv.find('ul').find('li').removeClass('action_error');
			$.ajax({
				url:"/api/?c=domain&a=domainAdd",
				dataType:'json',
				data:{domain:domain,group_id:-1},
				type:'post',
				success:function(a){
					if(a.status.code!=1)
					{
						that.tipsdiv.find('ul').find('li').eq(1).html("<i class='yun_3'></i>"+a.status.message+",请手动在域名管理添加一条域名，该域名名称为："+domain,true);
						return;
					}
					that.tipsdiv.find('ul').find('li').eq(1).find('i').removeClass('icon_loading').addClass('yun_4');
					that.addDomainRecord(domain);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.addDomainRecord = function(domain){
			var that = this;
			this.tipsdiv.find('ul').find('li').eq(2).find('i').removeClass().addClass('icon_loading');
			this.tipsdiv.find('ul').find('li').removeClass('action_error');
			$.ajax({
				url:"/api/?c=record&a=add",
				dataType:'json',
				data:{
					domain:domain,
					record_type:'CNAME',
					record_line:'默认',
					sub_domain:'www',
					ttl:600,
					value:this.cname+'.'
				},
				type:'post',
				success:function(a){
					if(a.status.code!=1)
					{
						that.tipsdiv.find('ul').find('li').eq(2).html("<i class='yun_3'></i>"+a.status.message+",请手动在"+domain+"域名下添加一条CNAME域名记录，解析值为"+that.cname,true);
						return;
					}
					that.tipsdiv.find('ul').find('li').eq(2).find('i').removeClass('icon_loading').addClass('yun_4');
					that.queryNs(domain);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.queryNs = function(domain){
			var that = this;
			this.tipsdiv.find('ul').find('li').eq(3).find('i').removeClass().addClass('icon_loading');
			this.tipsdiv.find('ul').find('li').removeClass('action_error');
			$.ajax({
				url:"?c=containerdomain&a=queryNs",
				dataType:'json',
				data:{
					domain:domain,
					record_type:'CNAME',
					record_line:'默认',
					sub_domain:'www',
					ttl:600,
					value:this.cname+'.'
				},
				type:'post',
				success:function(a){
					if (a.status=='ok') {
						that.tipsdiv.find('ul').find('li').eq(3).find('i').removeClass().addClass('yun_4');
						that.tipsdiv.find('ul').find('li').eq(4).find('i').removeClass().addClass('yun_4');
						return;
					}
					that.tipsdiv.find('ul').find('li').eq(3).html('<i class="yun_3"></i>请手动修改'+domain+'域名下2条NS类型解析记录，解析值分别修改为：'+a.ns[0]+","+a.ns[1]);
					setTimeout(function(){
						window.open('?c=public&a=record&groupid=-1&domain='+domain);
					},3000);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.arrPush = function(row){
			this.domainlist.push(row);
			var length = this.domainlist.length;
			this.renderOne(length-1);
		}
		this.derferDelMulti = function(key){
			var that = this;
			if(key == this.selectArr.length){
				that.showMultiResult();
				return;
			}
			this.delMulti(key);
		}
		this.delMulti = function(key){
			var that = this;
			var id = this.selectArr[key];
			$.ajax({
				url:"?c=containerdomain&a=del&name="+containername,
				dataType:'json',
				data:{id:id},
				type:'post',
				success:function(a){
					var row = that.getRowByid(id);
					if(a.status.code!=1)
					{
						that.multiresult.error.push(row['domain']+"--"+a.status.message);
						that.derferDelMulti(key+1);
						return;
					}
					that.multiresult.success.push(row['domain']+"--"+"删除成功");
					that.derferDelMulti(key+1);
					$("tbody").find("#"+id).remove();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.del = function(id){
			var that = this;
			var row = this.getRowByid(id);
			$.ajax({
				url:"?c=containerdomain&a=del&name="+containername,
				dataType:'json',
				data:{id:id},
				type:'post',
				success:function(a){
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("删除成功",true);
					$("tbody").find("#"+id).remove();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.showMultiResult = function() {
			var message = '';
			message += '成功: '+this.multiresult.success.length + ' 个';
			message += '&nbsp;';
			message += '失败:' + this.multiresult.error.length + ' 个';
			message += '&nbsp;';
			message += '<a href="javascript:;" id="show_multia">详细</a>';
			this.selectArr.length = 0;
			this.showMessage(message,false);
		}
		this.renderDomain = function(){
			for (var i in this.domainlist){
				this.renderOne(i);
			}
		}
		this.renderOne = function(key){
			var that = this;
			var row = this.getRow(key);
			var tem = $("#domaintr-template").html();
			var el = Mustache.to_html(tem,row);
			$('tbody').append(el);
			var div = $('tbody').find("#"+row['id']);
			div.find('#del').bind("click",function(){
				that.del(row['id']);
			})
			div.find('input[type=checkbox]').bind('click',function(){
				that.selectOne(div,row['id']);
			});
		}
		this.selectOne = function(div,id){
			var that = this;
		   if(div.find('input[type=checkbox]').attr("checked")){
			   that.selectArr.push(id);
		   }else{
			   that.selectArr.splice($.inArray(id,that.selectArr),1);//从数组中删除这个id
		   }
		}
		this.getRow = function(key){
			return this.domainlist[key];
		}
		this.getRowByid = function(id){
			var that = this;
			for(var i in this.domainlist){
				if(id == that.domainlist[i]['id']){
					return that.domainlist[i];
				}
				continue;
			}
		}
		this.selectAll = function(){
			var that = this;
			if($("#selectall").attr("checked"))
			{
				$("table").find("input[type=checkbox]").attr("checked","checked");
				for(var i in this.domainlist){
						that.selectArr.push(that.domainlist[i]['id']);
				}
			}else{
				$("table").find("input[type=checkbox]").attr("checked",false);
				that.selectArr.length= 0;
			}
		}
		this.showMessage = function(message,clear){
			var that = this;
			this.messagediv.html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass('alert-error').addClass('alert alert-success');
			if (clear) {
				that.messagediv.html(message).addClass('alert alert-success');
				setTimeout(function() {
					that.messagediv.html('').removeClass();
				},10000);
			}
			this.messagediv.find('a').bind('click',function(){
				that.messagediv.html("").removeClass('alert alert-success alert-error');
			});
			that.messagediv.find('#show_multia').bind('click',function(){
				that.showAllMultiMessage();
			});
		}
		this.showAllMultiMessage = function(){
			var that = this;
			var message = '';
			var s = this.multiresult.success;
			for (var i in s ) {
				message += s[i]+'<br/>';
			}
			var e = this.multiresult.error;
			for ( var i in e) {
				message += e[i]+'<br/>';
			}
			var option = [];
			option.title = '信息';
			option.content = message;
			var template = $("#piao-modal-template").html();
			var el = Mustache.to_html(template,option);
			$("body").append(el);
			$("#piao-modal").modal();
			this.multiresult.success.length = 0;
			this.multiresult.error.length = 0;
		}
		this.getCname = function(){
			var that = this;
			$.ajax({
				url : "?c=container&a=getVhostCname" ,
				dataType:"json",
				data:{name:containername},
				success:function(a){
					if(a.status.code != 1){
						that.showMessage("get cname failed " + a.status.message)
						return 
					}
					that.cname = a.ret;
					that.cnamediv.html("<code>"+a.ret + "</code>");
				},
				error:function(){
					that.showMessage("http request has failed")
				}
			});
		}
	}
	var domain = new domainClass();
	domain.getInfo();
	$("#left").find("#domain").addClass("active");
	domain.getCname();
	$("#left_group_list").find('div').eq(1).addClass('cur');
})



