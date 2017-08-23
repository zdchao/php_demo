function MainRenewal(){
	this.domain_list = {};
	this.renewalInit = function(){
		this.getRenewalDomain();
		var that = this;
	}
	this.getRenewalDomain = function(){
		var that = this;
		$.ajax({
			url:'?c=renewal&a=getRenewalSession',
			dataType:'json',
			success:function(a){
				that.domain_list = a.domain;
				if(that.domain_list != null){
					that.render(that.domain_list);
				}else{
					$("tbody").html($("#renewal-tip-template").html());
					$("#agreement_checkbox").attr("disabled","disabled");
				}
			},
			error:function(){
				
			}
		});
	}
	this.render = function(domains){
		var that = this;
		for(var i in domains){
			that.renderTemp(i,domains[i]['name']);
		}
		$("#renewal_count").html(that.domain_list.length);
		that.getRenewalAllPrice();
		that.getUserMoney();
	}
	this.getUserMoney = function(){
		$.ajax({
			url:'?c=renewal&a=getUserMoney',
			dataType:'json',
			success:function(a){
				$("#user_money").html(a.ret);
			},
			error:function(a){
				
			}
		});
	}
	this.getRenewalAllPrice = function(){
		var that = this;
		$.ajax({
			url:'?c=renewal&a=getRenewalAllPrice',
			dataType:'json',
			success:function(a){
				$("#all_price").html(a.ret);
			},
			error:function(a){
				
			}
		});
	}
	this.renderTemp = function(key,domain){
		var that = this;
		var template = $("#domain-renewal-template").html();
		var option = [];
		$.ajax({
			url:'?c=renewal&a=getRenewalInfo',
			type:'POST',
			data:{domain:domain,key:key},
			dataType:'json',
			success:function(a){
				option.key = key;
				option.domain = domain;
				option.renew_time = a.ret['renew_time'];
				option.renew_price = a.ret['renew_price'];
				option.select = that.getSelect(key);
				var el = Mustache.to_html(template,option);
				$("tbody").append(el);
				if($("tbody").find("#tr"+key).html()){
					$("[name="+key+"]").bind("change",function(){
						that.changeSelect(key);
					});
					$("#tr"+key).find("#del").bind("click",function(){
						that.delRenewalDomain(key);
					});
				}
			},
			error:function(a){
				
			}
		});
	}
	this.getSelect = function(key){
		var that = this;
		var html = "<select name='"+key+"'>";
		var period = that.domain_list[key]['years'];
		html += "<option>"+period+"</option>";
		for(var i=1;i <= 3;i++){
			if(i == period){
				continue;
			}
			html += "<option>"+i+"</option>";
		}
		return html;
	}
	this.changeSelect = function(key){
		var that = this;
		var period = $("[name="+key+"]").val();
		$.ajax({
			url:'?c=renewal&a=changeRenewalPeriod',
			type:'POST',
			data:{key:key,period:period},
			dataType:'json',
			success:function(a){
				$("tbody").find("#tr"+key).find("td").eq(3).html(a.ret);
				that.getRenewalAllPrice();
			},
			error:function(a){
				
			}
		});
	}
	this.delRenewalDomain = function(key){
		var that = this;
		$.ajax({
			url:'?c=renewal&a=delRenewalDomain',
			type:'POST',
			data:{key:key},
			dataType:'json',
			success:function(a){
				$("#tr"+key).remove();
				$("#renewal_count").html(a.count);
				that.getRenewalAllPrice();
				if(a.count == 0){
					$("tbody").html($("#renewal-tip-template").html());
					$("#agreement_checkbox").attr("disabled","disabled");
				}
			},
			error:function(a){
				
			}
		});
	}
}
$(document).ready(function(){
	$("#left_ul").find("li").eq(0).attr("class","active");
	$("#nav_my_domain").addClass("cur");
	var mr = new MainRenewal();
	mr.renewalInit();
});
function openRegisterAgreement(){
	$("#register_agreement").modal({
		keyboard:true
	});
}
function agreementCheck(){
	var val = $("#agreement_checkbox").is(":checked");
	if(val){
		$("#btn_renewal").attr("disabled",false);
	}else{
		$("#btn_renewal").attr("disabled",true);
	}
}
function renewalEnter(){
	window.location.href = "?c=renewal&a=renewalPage";
}