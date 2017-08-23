$(document).ready(function(){
	function FtpClass(){
		this.ftplist = [];
		this.messagediv = $("#message");
		this.mirro = "";
		this.selectArr = [];//被选中的
		this.multiresult = [];
		this.multiresult.success= [];
		this.ftp_host = $("#ftp_host")
		this.multiresult.error= [];
		this.getInfo = function (){
			var that = this;
			$.ajax({
				url:"?c=containerftp&a=getList",
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
						that.ftplist = a.rows;
						that.mirro = a.mirro;
						that.renderFtp();
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
				that.piaoAddFtp();
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
		this.derferDelMulti = function(key){
			var that  = this;
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
				url:"?c=containerftp&a=del&name="+containername,
				dataType:'json',
				data:{id:id},
				type:'post',
				success:function(a){
					var row = that.getRowByid(id);
					if(a.status.code!=1)
					{
						that.multiresult.error.push(row['name']+"--"+a.status.message);
						that.derferDelMulti(key+1);
						return;
					}
					that.multiresult.success.push(row['name']+"--"+"删除成功");
					that.derferDelMulti(key+1);
					$("tbody").find("#tr"+id).remove();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.piaoAddFtp = function(){
			var that = this;
			var tem = $("#add-ftp-template").html();
			var div = $("#piao-modal");
			div.find(".modal-body").html(tem);
			div.modal();
			div.find("#enter").bind('click',function(){
				that.submitFtp(div);
			});
		}
		this.submitFtp = function(div){
			var that = this;
			var name = div.find("input[name=name]").val();
			var subdir = div.find("input[name=subdir]").val();
			var passwd = div.find("input[name=passwd]").val();
			var permission  = "";
			div.find("input[name=permission]:checked").each(function(){
				permission += ',' + this["value"];
			});
			permission = permission.substr(1);
			div.find("#enter").addClass("disabled");
			$.ajax({
				url:"?c=containerftp&a=add&name="+containername,
				dataType:'json',
				data:{account:name,subdir:subdir,passwd:passwd,permission:permission},
				type:'post',
				success:function(a){
				div.find("#enter").removeClass("disabled");
				div.modal("hide");
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("添加成功",true);
					var row = [];
					row.id = a.id;
					row.name = name;
					row.subdir = subdir;
					row.passwd=passwd;
					that.arrPush(row);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.arrPush = function(row){
			this.ftplist.push(row);
			var length = this.ftplist.length;
			this.renderOne(length-1);
		}
		this.del = function(id){
			var that = this;
			$.ajax({
				url:"?c=containerftp&a=del&name="+containername,
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
					$("tbody").find("#tr"+id).remove();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.showMultiResult = function() {
			var that = this;
			var message = '';
			message += '成功: '+this.multiresult.success.length + ' 个';
			message += '&nbsp;';
			message += '失败:' + this.multiresult.error.length + ' 个';
			message += '&nbsp;';
			message += '<a href="javascript:;" id="show_multia">详细</a>';
			this.selectArr.length = 0;
			this.showMessage(message,false);
		}
		this.renderFtp = function(){
			for (var i in this.ftplist){
				var permission = "";
				var pers =  this.ftplist[i]["permission"].split(",")
				for(var p in pers){
					if(pers[p] == "file"){
						permission += ',' + '在线文件管理';
						continue
					}
					if(pers[p] == "ssh"){
						permission += ',' + 'SSH远程登陆';
						continue
					}
				}
				permission = permission.substr(1);
				 this.ftplist[i]["permission"] = permission;
				this.renderOne(i);
			}
		}
		this.renderOne = function(key){
			var that = this;
			var row = this.getRow(key);
			var tem = $("#ftptr-template").html();
			var tr = $("#tr"+row['id']);
			if (tr.html()) {
				tem = $("#refresh-ftptr-template").html();
			}
			var el = Mustache.to_html(tem,row);
			if(tr.html()){
				tr.html(el);
			}else{
				$('tbody').append(el);
			}
			var div =$('tbody').find("#tr"+row['id']);
			div.find('#deltr').bind("click",function(){
				that.del(row['id']);
			})
			div.find('input[type=checkbox]').bind('click',function(){
				that.selectOne(div,row['id']);
			});
			div.find("#editPasswd").bind('click',function(){
				that.piaoEditPasswd(div,key);
			});
		}
		this.piaoEditPasswd = function(div,key){
			var that = this;
			var row = this.getRow(key);
			var tem = $("#edit-passwd-template").html();
			div.html(tem);
			div.find("#enter").bind('click',function(){
				that.editPasswd(div,key);
			});
			div.find("#esc").bind('click',function(){
				that.renderOne(key);
			})
		}
		this.editPasswd = function(div,key){
			var that = this;
			var row = this.getRow(key);
			var subdir = div.find("input[name=subdir]").val();
			var passwd = div.find("input[name=passwd]").val();
			div.find("#enter").addClass("disabled");
			$.ajax({
				url:"?c=containerftp&a=editPasswd&name="+containername,
				dataType:'json',
				data:{id:row['id'],subdir:subdir,passwd:passwd},
				type:'post',
				success:function(a){
				div.find("#enter").removeClass("disabled");
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("修改成功",true);
					that.setRow(key, 'subdir', subdir);
					that.setRow(key, 'passwd', passwd);
					that.renderOne(key);
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.setRow = function(rowkey,key,value) {
			if (value == undefined) {
				for ( var i in key) {
					this.ftplist[rowkey][i] = key[i];
				}
			}else {
				this.ftplist[rowkey][key] = value;
			}
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
			return this.ftplist[key];
		}
		this.getRowByid = function(id){
			var that = this;
			for(var i in this.ftplist){
				if(id == that.ftplist[i]['id']){
					return that.ftplist[i];
				}
				continue;
			}
		}
		this.selectAll = function(){
			var that = this;
			if($("#selectall").attr("checked"))
			{
				$("table").find("input[type=checkbox]").attr("checked","checked");
				for(var i in this.ftplist){
						that.selectArr.push(that.ftplist[i]['id']);
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
				}, 5000);
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
			var div = $("piao-modal");
			div.find("h3").text("详细信息");
			div.find(".modal-body").html(message);
			div.modal('show');
			this.multiresult.success.length = 0;
			this.multiresult.error.length = 0;
		}
		this.getFtpHost = function(){
			var that = this;
			$.ajax({
				url : "?c=container&a=getSourceCname" ,
				dataType:"json",
				data:{name:containername},
				success:function(a){
					if(a.status.code != 1){
						that.showMessage("get cname failed " + a.status.message)
						return 
					}
					that.ftp_host.html(a.ret);
				},
				error:function(){
					that.showMessage("http request has failed")
				}
			});
		
		}
	}
	var Ftp = new FtpClass();
	Ftp.getInfo();
	$("#left").find("#ftp").addClass("active");
	Ftp.getFtpHost();
	$("#left_group_list").find('div').eq(1).addClass('cur');
})
