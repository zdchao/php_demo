$(document).ready(function() {
	var Notice = function() {
		this.listCount = 0;//记录查询的总条数
		this.list = [];
		this.pagecount = 10;
		this.page = 0;
		this.listdiv = $("#list-div");
		this.listheard = $("#list-header");
		this.getInfo = function() {
			var that = this;
			$.ajax({
				url : '/api/?c=user&a=getInfo',
				dataType : 'json',
				success : function(a) {
					if (a.status.code != 1) {
						that.renderLoginError();
						return;
					}
					that.renderHeader();
					that.getList(0);
				},
				error : function(e) {
					that.showError('后台数据出错' + e.responseText);
				}
			});
		}
		this.getList = function(page) {
			var that = this;
			this.page = page;
			this._offset = this.page==0 ? 0 : this.page*this.pagecount;
			$("#show-multi-operat").remove();
			$.ajax({
				url:'/api/?c=notice&a=getList',
				data:{offset:that._offset,length:that.pagecount},
				dataType:'json',
				success:function(a) {
					if (a.status.code != 1) {
						that.showError(a.status.message);
						return ;
					}
					that.render(a.list);
					//如果后台获取的数量和前台指定的相符，则可以显示获取下次的操作
					that.renderShowMutliOperat(a.count);
					window.scrollTo(0,document.body.scrollHeight);
					
				},
				error:function(e){
					that.showError("后台数据出错"+e.responseText);
				}
			}); 
		}
		this.renderHeader = function(){
			var template = $("#notice-row-header-template").html();
			this.listheard.html(template);
		}
		this.render = function(rows) {
			for ( var i in rows) {
				this.renderOne(this.addRow(rows[i]));
			}
		}
		this.getRowId = function(key) {
			return 'tr'+key;
		}
		this.addRow = function(row) {
			this.list.push(row);
			return this.list.length-1;
		}
		this.getRow = function(rowkey) {
			return this.list[rowkey];
		}
		this.setRow = function(rowkey,key,value) {
			this.list[rowkey][key] = value;
			return this.list[rowkey];
		}
		this.renderShowMutliOperat = function(count) {
			var that = this;
			that.listCount += count;
			var template = $("#notice-show-mutli-template").html();
			this.listdiv.append(template);
			if(count == that.listCount){
				$("#show-multi-operat").find("#packup").remove();
			}
			if(count < that.pagecount){
				$("#show-multi-operat").find("#show-multi").remove();
			}
			$("#show-multi-operat").find('#show-multi').bind('click',function(){
				that.getList(that.page+1);
			});
			$("#show-multi-operat").find("#packup").bind('click',function(){
				$("#list-div").slideUp(50,function(){
					that.launch();
				});
			});
		}
		/*
		 * 展开方法
		 */
		this.launch = function(){
			var templateLaunch = $("#operat-launch-template").html();
			$("#list-launch").html(templateLaunch);
			$("#launch").bind('click',function(){
				//alert("展开");
				
				$("#list-div").slideDown(50);
				$("#show-launch").remove();
			});
		}
		this.renderOne = function(rowkey) {
			var that = this;
			var row = this.getRow(rowkey);
			var template = $("#notice-row-template").html();
			row.rowid = this.getRowId(rowkey);
			if (row['status'] !=0) {
				row.rowclass="back-gray2";
			}
			var refresh = false;
			if ($("#"+row.rowid).html()) {
				template = $("#notice-row-refresh-template").html();
				refresh = true;
			}
			row['statusmsg'] = row['status']==0 ? '新消息':'已读';
			var el  = Mustache.to_html(template,row);
			if ($("#"+row.rowid).html()) {
				$("#"+row.rowid).html(el);
			}else {
				this.listdiv.append(el);
			}
			var div = $("#"+row.rowid);
			div.bind('click',function(){
				that.showNoticeBody(rowkey);
			});
			if (refresh) {
				div.addClass('back-gray2');
			}
			$(document).scrollTop($(document).scrollTop()+40); 
		}
		this.changeStatus = function(rowkey) {
			var that = this;
			var row = this.getRow(rowkey);
			$.ajax({
				url:'/api/?c=notice&a=changeStatus',
				data:{id:row['id']},
				dataType:'json',
				success:function(a) {
					that.setRow(rowkey,'status', 1)
					that.renderOne(rowkey);
				},
				error:function(e) {
				}
			});
		}
		this.showNoticeBody = function(rowkey) {
			var that = this;
			var row = this.getRow(rowkey);
			if (row['status']==0) {
				this.changeStatus(rowkey);
			}
			var rowid = this.getRowId(rowkey);
			var div = $("#"+rowid);
			var template = $("#notice-show-body-template").html();
			var option = [];
			option.body = row['body'];
			var el = Mustache.to_html(template,option);
			div.html(el);
			div.bind('click',function(){
				that.renderOne(rowkey);
			});
			div.removeClass('back-gray2');
			div.find('span').css('height','auto');
		}
		this.getRowBodyId = function(rowkey) {
			return 'showbody' + rowkey;
		}
		this.renderLoginError = function() {
			var template = $("#user-nologin-template").html();
			this.listdiv.append(template);
		}
		this.showError = function(message, clear) {
			$("#show_error").html(message);
			if (clear) {
				setTimeout(function() {
					$("#show_error").html("");
				}, 4000);
			}
		}
	}
	var notice = new Notice();
	notice.getInfo();
})
