var recordquery = function() {
	this.domain = '';
	this.pname = '免费版';
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
				that.render();
			},
			error : function(e) {
				that.showError('后台数据出错' + e.responseText);
			}
		});
	}
	this.renderLoginError = function() {
		var template = $("#query-nologin-template").html();
		$("#recordquery_hours").html(template);
	}
	this.render = function() {
		var that = this;
		$.ajax({
			url : '/api/?c=recordquery&a=getList',
			type : 'POST',
			dataType : 'json',
			data : {
				domain : that.domain
			},
			success : function(a) {
				switch (a.status.code) {
				case 1:
				case '1':
					that.renderDay(a.days);
					that.renderHour(a.hour);
					break;
				default:
					break;
				}
			},
			error : function() {
			}
		});
	}
	this.renderDay = function(data) {
		var options = {
			chart : {
				defaultSeriesType : 'line',
				renderTo : 'recordquery_days',
				inverted : false
			},
			title : {
				text : '最近30天统计图'
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
					text : '请求次数'
				}
			},
			legend : {
				enabled : false
			},
			tooltip : {
				formatter : function() {
					return '解析数:' + Highcharts.numberFormat(this.y, 1) + ' 个<br/>当前时间:' + this.x;
				}
			},
			series : []
		};
		var series = {};
		series.name = '个数';
		series.data = [];
		for ( var i in data.cate) {
			series.data.push(data.nums[data.cate[i]]);
		}
		for ( var i in data.cate) {
			options.xAxis.categories.push(data.cate[i].substr(-2));
		}
		options.series.push(series);
		var chat = new Highcharts.Chart(options);
	}
	this.renderHour = function(data) {
		var options = {
			chart : {
				defaultSeriesType : 'line',
				renderTo : 'recordquery_hours',
				inverted : false
			},
			title : {
				text : '最近24小时统计图'
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
					text : '请求次数'
				}
			},
			legend : {
				enabled : false
			},
			tooltip : {
				formatter : function() {
					return '解析数:' + Highcharts.numberFormat(this.y, 1) + ' 个<br/>当前时间:' + this.x;
				}
			},
			series : []
		};
		var series = {};
		series.name = '个数';
		series.data = [];
		for ( var i in data.cate) {
			series.data.push(data.nums[data.cate[i]]);
		}
		for ( var i in data.cate) {
			options.xAxis.categories.push(data.cate[i].substr(-2));
		}
		options.series.push(series);
		var chat = new Highcharts.Chart(options);
	}
}
$(document).ready(function() {
	var query = new recordquery();
	query.getInfo();
	$("#record-operat").find('#query').find('a').addClass('cur');
});