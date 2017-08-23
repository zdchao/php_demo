$(document).ready(function(){
	function dbClass(){
		this.dblist = [];
		this.messagediv = $("#message");
		this.dbsourcetd = $("#source");
		this.getInfo = function (){
			var that = this;
			 that.renderHead();
			$.ajax({
				url:"?c=containerdb&a=getList",
				data:{name:containername},
				dataType:'json',
				type:'get',
				success:function(a){
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					if(!a.rows){
						$("#del").hide();
						$("#editpasswd").hide();
						that.showMessage("没有数据库记录，请添加",true);
						return;
					}
						that.dblist = a.rows;
						   that.renderdb();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.renderdb = function(){
			this.getDbSize();
			$("#dbname").text(this.dblist.name);
			$("#size").text (this.dblist.dbquota+'(M)');
			$("#dbsize").text(this.dblist.dbsize);
			$("#add").hide();
			$("#del").show();
			$("#editpasswd").show();
		}
		this.getDbSize = function(){
			var that  = this;
			$.ajax({
				url:"?c=containerdb&a=getDbSize&name="+containername,
				dataType:'json',
				type:'post',
				success:function(a){
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.dblist.dbsize =(a.dbsize/1024/1024).toFixed(2);
					$("#dbsize").text(that.dblist.dbsize+"(M)");
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.renderHead = function(){
			var that = this;
			$("#add").bind('click',function(){
				that.piaoAdddb();
			});
			$("#del").bind('click',function(){
				that.del();
			});
			$("#editpasswd").bind('click',function(){
				that.piaoEditPasswd();
			});
		}
		this.piaoAdddb = function(){
			var that = this;
			if(this.dblist.name){
				that.showMessage('数据库记录只能有一条', true);
				return;
			}
			var tem = $("#add-db-template").html();
			$("tbody").prepend(tem);
			var div = $("tbody").find("tr").eq(0);
			div.find("#enter").bind('click',function(){
				that.submitdb(div);
			});
			div.find("#esc").bind('click',function(){
				div.remove();
			});
		}
		this.submitdb = function(div){
			var that = this;
			var passwd = div.find("input[name=passwd]").val();
			div.find("#enter").addClass("disabled");
			$.ajax({
				url:"?c=containerdb&a=add&name="+containername,
				dataType:'json',
				data:{passwd:passwd},
				type:'post',
				success:function(a){
				div.find("#enter").removeClass("disabled");
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("添加成功",true);
					that.dblist.name = a.row.name;
					that.dblist.dbquota = a.row.quota;
				    that.renderdb();
				    div.remove();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.del = function(){
			if(confirm("您确定要删除数据库记录吗？") === false){
				return;
			}
			var that = this;
			$.ajax({
				url:"?c=containerdb&a=del&name="+containername,
				dataType:'json',
				type:'post',
				success:function(a){
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("删除成功",true);
					window.location.reload();
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
		this.piaoEditPasswd = function(div,key){
			var that = this;
			var tem = $("#add-db-template").html();
			$("tbody").prepend(tem);
			var div = $("tbody").find("tr").eq(0);
			div.find("#enter").bind('click',function(){
				that.editPasswd(div);
			});
			div.find("#esc").bind('click',function(){
				div.remove();
			});
		}
		this.editPasswd = function(div,key){
			var that = this;
			var passwd = div.find("input[name=passwd]").val();
			div.find("#enter").addClass("disabled");
			$.ajax({
				url:"?c=containerdb&a=editPasswd&name="+containername,
				dataType:'json',
				data:{passwd:passwd},
				type:'post',
				success:function(a){
				div.find("#enter").removeClass("disabled");
					if(a.status.code!=1)
					{
						that.showMessage(a.status.message,true);
						return;
					}
					that.showMessage("修改成功",true);
					div.remove();
				},
				error:function(a){
					that.showMessage("error",true);
				}
			});
		}
		this.setRow = function(rowkey,key,value) {
			if (value == undefined) {
				for ( var i in key) {
					this.dblist[rowkey][i] = key[i];
				}
			}else {
				this.dblist[rowkey][key] = value;
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
			return this.dblist[key];
		}
		this.getRowByid = function(id){
			var that = this;
			for(var i in this.dblist){
				if(id == that.dblist[i]['id']){
					return that.dblist[i];
				}
				continue;
			}
		}
		this.selectAll = function(){
			var that = this;
			if($("#selectall").attr("checked"))
			{
				$("table").find("input[type=checkbox]").attr("checked","checked");
				for(var i in this.dblist){
						that.selectArr.push(that.dblist[i]['id']);
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
		this.getSource = function(){
			var that = this;
			$.ajax({
				url : "?c=container&a=getSourceCname" ,
				dataType:"json",
				data:{name:containername},
				success:function(a){
					if(a.status.code != 1){
						that.showMessage("get cname failed " + a.status.message);
						return;
					}
					that.dbsourcetd.html(a.ret);
				},
				error:function(){
					that.showMessage("http request has failed");
				}
			});
		}
	}
	var db = new dbClass();
	db.getInfo();
	$("#left").find("#db").addClass("active");
	db.getSource()

})
