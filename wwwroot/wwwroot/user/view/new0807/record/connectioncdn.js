/**
 * dnsdun 连接 cdn 贝
 */
function main(){
	this.code = 0;
	this.siteret = [];
	this.product = []; //cdn产品
	this.domain = ''; //当前域名
	this.pname = '免费版'; //当前使用的产品
	this.init = function(){
		var that = this;
		that.getInfo();
	}
	this.getInfo = function(){
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
				that.getAllData();
			},
			error:function(e) {
				that.showError('后台数据出错'+e.responseText);
			}
		});
	}
	this.getAllData = function(){
		var that = this;
		$.ajax({
			url:'?c=cdn&a=getAllData',
			dataType:'json',
			success:function(a){
				if(a.status.code == 1){
					that.initData(a.product,a.siteret,a.siteretcode);
				}
			},
			error:function(a){
				alert("error");
			}
		});
	}
	this.initData = function(product,siteret,siteretcode){
		var that = this;
		for(var i in product){
			that.product.push(product[i]);
		}
		if(siteret != ""){
			for(var i in siteret){
				that.siteret.push(siteret[i]);
			}
		}
		that.code = siteretcode;
		that.showSiteOperation();
	}
	//显示站点操作
	this.showSiteOperation = function(){
		var that = this;
		var div = $("#site-operation");
		if(that.code == 0){
			var template = $("#cdn-site-operation-template").html();
			div.html(template);
			div.find("#add-site").bind('click',function(){
				//alert('增加站点');
				that.showProduct(that.product);
			});
			return;
		}
		if(that.code == 1){
			var template1 = $("#cdn-site-add-success-template").html();
			div.html(template1);
			that.showSiteOperation1(div);
		}
	}
	this.showSiteOperation1 = function(div){
		var div = div;
		div.find("#cdn-site-status").bind('click',function(){
			alert("站点状态");
			
		});
		div.find("#cdn-site-delete").bind('click',function(){
			alert("删除站点");
		});
		div.find("#cdn-site-edit-passwd").bind('click',function(){
			alert("修改站点密码");
		});
	}
	this.showProduct = function(product){
		var that = this;
		var template = $("#add-cdn-product-template").html();
		var option = [];
		option.product = that.createSelect(that.product);
		var el = Mustache.to_html(template,option);
		var div = $("#addsite");
		div.css("display","block");
		div.html(el);
		var span = $("#add-cdn-product-div");
		span.find("#enter").bind('click',function(){
			//var passwd = span.find("[name=passwd]").val();
			var product = span.find("[name=product]").val();
			//alert(passwd+'--'+product);
			that.isAudit(product);
		});
		span.find("#esc").bind('click',function(){
			div.css("display","none");
		});
	}
	//判断站点使用的产品是否需要审核
	this.isAudit = function(product){
		var that = this;
		//audit 为 1 不审核 0 审核
		var audit = that.product[product]['audit'];
		if(audit == 1){
			that.productNotAudit(product);
			return;
		}
		if(audit == 0){
			that.productAudit(product);
			return;
		}
	}
	this.productAudit = function(product){
		var that = this;
		var pid = that.product[product]['id'];
		var audit = that.product[product]['audit'];
		$.ajax({
			url:'?c=cdn&a=addCdnSite',
			data:{pid:pid,audit:audit},
			dataType:'json',
			success:function(a){
				if(a.status.code == 1){
					$("#addsite").css('display','none');
					$("#add-site").attr('disabled','disabled');
					that.showError(a.message,true);
					var div = $("#site-operation");
					var template1 = $("#cdn-site-add-success-template").html();
					div.append(template1);
					that.showSiteOperation1(div);
				}
			},
			error:function(a){
				alert("error");
			}
		});
	}
	//站点不审核
	this.productNotAudit = function(product){
		var that = this;
		var id = that.product[product]['id'];
		var audit = that.product[product]['audit'];
		$.ajax({
			url:'?c=cdn&a=addCdnSite',
			data:{pid:id,audit:audit},
			dataType:'json',
			success:function(a){
				if(a.status.code == 1){
					$("#addsite").css('display','none');
					$("#add-site").attr('disabled','disabled');
					that.showError(a.message,true);
					var div = $("#site-operation");
					var template1 = $("#cdn-site-add-success-template").html();
					div.append(template1);
					that.showSiteOperation1(div);
				}
			},
			error:function(a){
				alert('error');
			}
		});
	}
	this.createSelect = function(product){
		var that = this;
		var html = "<select name='product'>";
		for(var i in product){
			html +="<option value='"+i+"'>"+product[i]['name']+"</option>";
		}
		html +="</select>";
		return html;
	}
	this.renderLoginError = function() {
		var template = $("#site-nologin-template").html();
		$("#multi_div").append(template);
	}
	this.showError = function(message, clear) {
		var that = this;
		$("#error-message").html(message).append('&nbsp;&nbsp;<a href="javascript:;" id="closea"><i class="icon-remove"></i></a>').removeClass('alert-success').addClass('alert alert-success');
		if (clear) {
			setTimeout(function() {
				$("#error-message").html('').removeClass('alert alert-success alert-error');
			}, 6000);
		}
		$("#error-message").find('#closea').bind('click',function(){
			$("#error-message").html("").removeClass('alert alert-success').removeClass('alert-error');
		});
	}
}
$(document).ready(function(){
	$("#record-operat").find('#connectioncdn').addClass('active');
	var m = new main();
	m.init();
});
