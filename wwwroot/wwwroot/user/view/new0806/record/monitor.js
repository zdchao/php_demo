var monitorlog = function() {
			this.listCount = 0;
			this.recordid = record_id;
			this.domain = '';
			this.pname = '免费版';
			this.pagecount = 13;  //分页条目
			this.page = 0;
			this.listdiv = $("#monitor-list");
			this.getInfo = function() {
				var that = this;
				$.ajax({
					url:'/api/?c=record&a=getDomainInfo',
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.renderLoginError();
							return;
						}
						that.domain = a.domain.name;
						that.pname = a.domain.pname;
						$("#domain_name_show").html(that.domain);
						$("#domain_pname_show").html(that.pname).parent('a').attr('href','?c=product&a=index&domain='+that.domain);
						that.getList(0);
					},
					error:function(e) {
						that.showError('后台数据出错'+e.responseText);
					}
				});
			}
			this.renderLoginError = function() {
				var template = $("#monitor-nologin-template").html();
				this.listdiv.html(template);
			}
			this.render = function(rows) {
				var that = this;
				if (!rows || rows.length < 1 ) {
					return;
				}
				var template = $("#monitor-row-template").html();
				for ( var i in rows) {
					var el = Mustache.to_html(template,rows[i]);
					this.listdiv.append(el);	
					$(document).scrollTop($(document).scrollTop()+40); 
				}
			}
			this.getList = function(page) {
				var that = this;
				this.page = page;
				this._offset = this.page==0 ? 0 : this.page*this.pagecount;
				$("#show-multi-operat").remove();
				$.ajax({
					url:'/api/?c=monitorlog&a=getList',
					data:{domain:that.domain,offset:that._offset,length:that.pagecount,recordid:that.recordid},
					dataType:'json',
					success:function(a) {
						if (a.count < 1) {
							return ;
						}
						that.render(a.list);
						if(a.list.length > 12){
							that.renderShowMutliOperat();
						}
						
						//如果后台获取的数量和前台指定的相符，则可以显示获取下次的操作
						if (a.count != that.pagecount) {
							
							$("#show-multi").remove();
						}
						if(a.count < 1){
							$("#show-multi-operat").remove();
						}
						that.listCount += a.count;
						if(that.listCount == a.count){
							$("#packup").remove();
						}
						//滚动条置底
						that.scrollToBottom();
					},
					error:function(e) {
					}
				});
			}
			/*
			 * 滚动条置底
			 */
			this.scrollToBottom = function(){
				window.scrollTo(0,document.body.scrollHeight);
			}
			this.renderShowMutliOperat = function() {
				var that = this;
				var template = $("#monitor-show-mutli-template").html();
				this.listdiv.append(template);
				$("#show-multi-operat").find('#show-multi').bind('click',function(){
					that.getList(that.page+1);
				});
				$("#packup").bind('click',function(){
					$("#monitor-list").slideUp(50,function(){
						that.launch();
					});
				});
			}
			/*
			 * 展开方法
			 */
			this.launch = function(){
				var templateLaunch = $("#monitor-launch-template").html();
				$("#list-launch").html(templateLaunch);
				$("#launch").bind('click',function(){
					//alert("展开");
					$("#launch1").remove();
					$("#monitor-list").slideDown(50);
				});
			}
			this.search = function(searchvalue) {
				if (!searchvalue) {
					this.render(this.monitorlist);
					return;
				}
				var searchlist = [];
				for ( var i in this.monitorlist) {
					var str = this.monitorlist[i]['src'] + '~' + this.monitorlist[i]['status'] + '~' + this.monitorlist[i]['status_msg'] + '~' + this.monitorlist[i]['total_time'];
					if (str.indexOf(searchvalue)>-1 ) {
						searchlist.push(this.monitorlist[i]);
					}
				}
				this.render(searchlist);
			}
		}
$(document).ready(function() {
	$("#record-operat").find('#monitor').find('a').addClass('cur');
	$("#nav_domain").addClass("nav_domain");
	var monitor = new monitorlog();
	monitor.getInfo();
});