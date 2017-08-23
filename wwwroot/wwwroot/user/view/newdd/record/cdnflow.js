var Main = function(){
	this.domain = '';
	this.pname = '免费版';
	this.days = [];
	this.months = [];
	this.flowDayData = [];
	this.cacheDayData = [];
	this.flowMontyData = [];
	this.cacheMonthData = [];
	this.getInfo = function() {
		var that = this;
		$.ajax({
			url : '/api/?c=record&a=getDomainInfo',
			dataType : 'json',
			success : function(a) {
				if (a.status.code != 1) {
					that.renderLoginError();
					return;
				}
				that.domain = a.domain.name;
				that.pname = a.domain.pname;
				$("#domain_name_show").html(that.domain);
				$("#domain_pname_show").html(that.pname).parent('a').attr('href','?c=product&a=index&domain='+that.domain);
				that.getFlow();
				//that.render();
				if(a.domain['cdn_id'] == 0){
					$("#popup").css('display','block');
					$("#msg").html("<a href='?c=cdn&a=index&domain="+that.domain+"' style='color:red'>请先增加CDN站点</a>");
					$("#msg").css("display","block");
				}
			},
			error : function(e) {
				that.showError('后台数据出错' + e.responseText);
			}
		});
	}
	this.getFlow = function(){
		var that = this;
		$.ajax({
			url:'/api/?c=record&a=getCdnFlow',
			dataType:'json',
			success:function(a){
				//alert('s');
				if(a.status.code == 1){
					that.days = a.days;
					that.months = a.months;
					that.render();
					return;
				}
				that.render();
				return;
			},
			error:function(a){
				alert('error');
			}
		});
	}
	this.render = function() {
		this.renderDay();
		this.renderMonth();
	}
	this.showError = function(msg){
		alert(msg);
	}
	this.getDayRatio = function(index) {
		flowval = this.flowDayData[index];
		cacheval = this.cacheDayData[index];
		return Highcharts.numberFormat(cacheval*100/flowval,2);
	}
	this.getMonthRatio = function(index) {
		flowval = this.flowMonthData[index];
		cacheval = this.cacheMonthData[index];
		return Highcharts.numberFormat(cacheval*100/flowval,2);
	}
	this.renderDay = function() {
		var that = this;
		var data = this.days;
		var flow = {};
		var cache = {};
		var options = {
			chart : {
				defaultSeriesType : 'line',
				renderTo : 'query_day',
				inverted : false
			},
			title : {
				text : '最近24小时流量(蓝色),缓存(绿色)统计图'
			},
			subtitle : {
				text : '',
				x : 80
			},
			xAxis : {
				categories : []
			},
			yAxis : {
				title : {
					text : '流量'
				}  
			},
			credits:{  
	            enabled: true,  
	            position: {  
	                align: 'right',  
	                x: -10,  
	                y: -10  
	            },  
	            href: "https://www.cdnbest.com",  
	            style: {  
	                color:'blue'  
	            },  
	            text: "CDN贝"  
	        },
			legend : {
				enabled : false
			},
			tooltip : {
				valueSuffix:'{value}m',
				formatter : function() {
					var str = '流量:' + Highcharts.numberFormat(this.y, 1) + ' byte<br/>当前时间:' + this.x + '点';
					str += ",缓存命中率:" + that.getDayRatio(this.point.x) + "%";
					return str
				}
			},
			series : []
		};
		
		flow.name = '流量';
		//线条颜色
		//flow.color = '#89A54E';
		//显示方式，柱子还是线条或其它
		//flow.type = 'spline';		
		flow.data = [];
		
		for ( var i in data.cate) {
			flow.data.push(data.nums[data.cate[i]]);
		}
		for ( var i in data.cate) {
			options.xAxis.categories.push(data.cate[i].substr(-2));
		}	
		this.flowDayData = flow.data;
		
		cache.name = "缓存";
		//cache.color = 'red',
		//cache.type = 'spline';
		cache.data = [];
		for ( var i in data.cate) {
			cache.data.push(data.cache[data.cate[i]]);
		}
		this.cacheDayData = cache.data;
		options.series.push(flow);
		options.series.push(cache);
		var chat = new Highcharts.Chart(options);
	}
	this.renderMonth = function() {
		var that = this;
		var data = this.months;
		var options = {
			chart : {
				defaultSeriesType : 'line',
				renderTo : 'query_month',
				inverted : false
			},
			title : {
				text : '最近30天流量(蓝色),缓存(绿色)统计图'
			},
			subtitle : {
				text : '',
				x : 80
			},
			credits:{ 
	            enabled: true,  
	            position: {  
	                align: 'right',  
	                x: -10,  
	                y: -10  
	            },  
	            href: "https://www.cdnbest.com",
	            style: {  
	                color:'blue'  
	            },  
	            text: "CDN贝"  
	        },
			xAxis : {
				categories : []
			},
			yAxis : {
				title : {
					text : '流量'
				}
			},
			legend : {
				enabled : false
			},
			tooltip : {
				formatter : function() {
					var str = '流量:' + Highcharts.numberFormat(this.y, 1) + ' byte<br/>当前时间:' + this.x + '日';
					str += ",缓存命中率:" + that.getMonthRatio(this.point.x) + "%";
					return str
				}
			},
			series : []
		};
		var flow = {};
		flow.name = '流量';
		flow.data = [];
		for ( var i in data.cate) {
			flow.data.push(data.nums[data.cate[i]]);
		}
		this.flowMonthData = flow.data;
		for ( var i in data.cate) {
			options.xAxis.categories.push(data.cate[i].substr(-2));
		}
		options.series.push(flow);
		var cache = {};
		cache.name = "缓存";
		cache.data = [];
		for ( var i in data.cate) {
			cache.data.push(data.cache[data.cate[i]]);
		}
		this.cacheMonthData = cache.data;
		options.series.push(cache);
		var chat = new Highcharts.Chart(options);
	}
	this.renderLoginError = function() {
		var template = $("#site-nologin-template").html();
		$("#h").append(template);
	}
}
$(document).ready(function(){
	$("#record-operat").find('#cdnflow').find('a').addClass('cur');
	var main = new Main();
	main.getInfo();
});