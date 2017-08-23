var operating = function() {
	this.listCount = 0;
	this.domain = '';
	this.pname = '免费版';
	this.page = 0;//数据分页
	this.length = 16; //数据分页的条目
	this.operatList = [];//存放操作日志
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
				that.render(0);
			},
			error:function(e) {
				that.showError('后台数据出错'+e.responseText);
			}
		});
	}
	this.renderLoginError = function() {
		var template = $("#operat-nologin-template").html();
		$("#list-content").html(template);
	}
	this.render = function(page) {
		var that = this;
		that.page = page;
		that._offset = that.page == 0 ? 0 : that.page*that.length;
		$("#packuptr").remove();
		$("#domain_name_show").html(that.domain);
		$("#domain_pname_show").html(that.pname).parent('a').attr('href','?c=product&a=index&domain='+that.domain);
		$.ajax({
			url : '/api/?c=domainlog&a=operatlog',
			data : {
				domain : that.domain,offset:that._offset,length:that.length
			},
			dataType : 'json',
			success : function(a) {
				for(var i in a.rows){
					that.operatList.push(a.rows[i]);
				}
				that.packup(a.rows);
				if(a.count != that.length){
					$("#more").remove();
				}
				that.listCount += a.count;
				if(a.count == that.listCount){
					$("#packup").remove();
				}
				//滚动条置底
				that.scrollToBottom();
			},
			error : function(e) {
			}
		});
	}
	/*
	 * 滚动条置底
	 */
	this.scrollToBottom = function(){
		window.scrollTo(0,document.body.scrollHeight);
	}
	/*
	 * 收起，查询更多
	 */
	this.packup = function(rows){
		var that = this;
		var template = $("#operat-row-template").html();
		for(var i in rows){
			var el = Mustache.to_html(template,rows[i]);
			$("#list-content").append(el);
		}
		var packupTemplate = $("#operat-packup-template").html();
		$("#list-content").append(packupTemplate);
		$("#packup").bind('click',function(){
			//alert('收起');
			$("#list-content").slideUp(50,function(){
				that.launch();
			});
			
		});
		$("#more").bind('click',function(){
			//alert('显示更多');
			that.render(that.page+1);
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
			$("#launch").remove();
			$("#list-content").slideDown("slow");
		});
	}
}
$(document).ready(function() {
	var operat = new operating();
	operat.getInfo();
	$("#record-operat").find('#operat').find('a').addClass('cur');
	$("#nav_domain").addClass("nav_domain");
	$("#form-search").find("#search-query").remove();
});