/*
 * 	domainsearch.js
 *    是域名搜索列表
 *    未注册域名列表
 *    购买域名
 *    的js文件
 */
function Init(){
	this.suffix = [];
	this.domain = "";
	this.mainInit = function(){
		//this.bindEvent();
		this.domainDetection();
		this.getShopCart();
	}
	this.bindEvent = function(){
		$("#domain_all").bind('click',function(){
			$("#ul_tab").find("li").eq(1).attr("class","");
			$("#ul_tab").find("li").eq(0).attr("class","active");
			var template = $("#domain-all-list-template").html();
			$("#table_html").html(template);
		});
		$("#domain_register").bind('click',function(){
			$("#ul_tab").find("li").eq(0).attr("class","");
			$("#ul_tab").find("li").eq(1).attr("class","active");
			var template = $("#domain-register-list-template").html();
			$("#table_html").html(template);
		});
	}
	this.domainDetection = function(){
		var that = this;
		var domain = $("#domain").val();
		$.ajax({
			url:'?c=register&a=domainDetection',
			data:{domain:domain},
			dataType:'json',
			success:function(a){
				var html = $("#domain-serach-init-template").html();
				var option = [];
				that.suffix = a.suffix;
				that.domain = a.domain;
				if(a.status.code == 10){
					alert(a.ret);
					return;
				}
				if(a.status.code == 2){
					option.key = 0;
					option.domain = that.domain + that.suffix['suffix'];
					option.price = that.suffix['first_price'] / 100;
					var el = Mustache.to_html(html,option);
					$("#table_html").append(el);
					that.asyncSearchIsRegister(0,that.domain,that.suffix['suffix'],that.suffix['suffix_type']);
					return;
				}
				for(var i in that.suffix){
					option.key = i;
					option.domain = that.domain+that.suffix[i]['suffix'];
					option.price = that.suffix[i]['first_price'] / 100;
					var el = Mustache.to_html(html,option);
					$("#table_html").append(el);
				}
				for(var i in that.suffix){
					that.asyncSearchIsRegister(i,that.domain,that.suffix[i]['suffix'],that.suffix[i]['suffix_type']);
				}
			},
			error:function(a){
				alert("error");
			}
		});
	}
	//异步查询域名是否可注册
	this.asyncSearchIsRegister = function(key,domain,suffix,suffix_type){
		$.ajax({
			url:'?c=register&a=getRegisterDomainStatus',
			type:'POST',
			data:{domain:domain,suffix:suffix},
			dataType:'json',
			success:function(a){
				if(a.status.code != 1){
					$("#table_html").find("#tr"+key).find("td").eq(1).html("已注册");
					$("#table_html").find("#tr"+key).find("td").eq(2).html("/");
					return;
				}
				//$("#table_html").find("#tr"+key).find("td").eq(2).html("<button class='btn btns btn-success btn-xs' onclick=\"domainAddShopCart('"+a.name+"',"+suffix_type+",'"+suffix+"')\">加入购物车</button>");
				$("#table_html").find("#tr"+key).find("td").eq(2).html("<em class='icon_6' onclick=\"domainAddShopCart('"+a.name+"',"+suffix_type+",'"+suffix+"')\"></em>");
			},
			error:function(a){
				//alert("error");
			}
		});
	}
	this.getShopCart = function(){
		var that = this;
		$.ajax({
			url:'?c=register&a=getShopCart',
			dataType:'json',
			success:function(a){
				if(a.status.code != 1){
					return;
				}
				$("#shop_cart_tip").remove();
				var template = $("#shop-cart-list-template").html();
				var option = [];
				for(var i in a.ret){
					option.domain = a.ret[i]['name'];
					option.key = i;
					var el = 	Mustache.to_html(template,option);
					$("#shop_cart_ul").append(el);
				}
				$("#shop_cart_ul").append($("#shop-cart-btn-template").html());
			},
			error:function(a){
				alert("error");
			}
		});
	}
}
$(document).ready(function(){
	$("#ul_tab").find("li").eq(0).attr("class","active");
	$("#nav_domain_register").addClass('cur');
	var ini = new Init();
	ini.mainInit();
});


var showSuffix = function(){
	$("#domain_suffix").show();
	$("#suffix_btn").html("<a href='javascript:heidSuffix()'>隐藏更多后缀</a>");
}
var heidSuffix = function(){
	$("#domain_suffix").hide();
	$("#suffix_btn").html("<a href='javascript:showSuffix()'>显示更多后缀</a>");
}
var domainAddShopCart = function(domain,suffix_type,suffix){
	$.ajax({
		url:'?c=register&a=domainAddShopCart',
		type:'POST',
		data:{domain:domain,suffix_type:suffix_type,suffix:suffix},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.ret);
				return;
			}
			$("#shop_cart_tip").remove();
			var template = $("#shop-cart-list-template").html();
			var option = [];
			option.domain = a.ret['name'];
			option.key = a.key;
			var el = Mustache.to_html(template,option);
			if($("#enter_buy").html()){
				$("#enter_buy").before(el);
				return;
			}
			$("#shop_cart_ul").append(el);
			$("#shop_cart_ul").append($("#shop-cart-btn-template").html());
		},
		error:function(a){
			alert("error");
		}
	});
}
var delShopCart = function(key){
	$.ajax({
		url:'?c=register&a=delShopCart',
		data:{key:key},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				$("#enter_buy").remove();
				$("#shop_cart_ul").append('<li id="shop_cart_tip" class="list-group-item">请选择域名</li>');
			}
			$("#shop_cart_ul").find("#"+key).remove();
		},
		error:function(a){
			alert("error");
		}
	});
}
var buyDomainEnter = function(){
	window.location.href = "?c=buyprocess&a=shopCartList";
}