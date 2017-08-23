var headlink = function(){
	this.userlogin = 0;
	this.domainlogin = 0;
	this.useremail = [];
	this.unread = 0;
	this.container = 0;
	this.getInfo = function() {
		var that = this;
		$.ajax({
			url:'/api/?c=public&a=getLoginInfo',
			dataType:"json",
			success:function(a) {
				if (a.status.code != 1) {
					openCloseBg('close');
					return;
				}
				if (a.user) {
					that.useremail = a.user.username;
					that.userlogin = a.user.login;
					that.unread = a.user.unread;
				}
				if (a.domain) {
					that.domainlogin = a.domain.login;
				}
				that.container = a.container;
				that.renderLink(a.is_domain_register);
				//that.getIsDomainRegister();
			},
			error:function(e) {
				
			}
		});
	}
	this.renderLink = function(is_domain_register) {
		var that = this;
		if(is_domain_register != 1){
			$("#is_domain_register").remove();
		}
		if(that.container != 1){
			$("#nav_container").remove();
		}
		var div = $("#head-link");
		if (this.userlogin != 0) {
//			var link = '<a href="?c=public&a=notice" title="还有'+ this.unread + '封信息未读"><img src="/style/img/mail';
//			if (this.unread == 0) {
//				link += '-white'
//			}	
//			link += '.png" style="width:25px;height:20px;"></a>';
//			link += "<a href='?c=public&a=user'>"+this.useremail+"</a>";
			var link = '<h3><a href="?c=public&a=user"><strong style="padding:0 5px 0 0;"><img src="/style/agies/img/touxiang.jpg" style="border-radius:50%;" /></strong>'+this.useremail+'<span><img src="/style/agies/img/xiala.png" /></span></a></h3>';
			div.append(link);
		}
		if (this.domainlogin!=0 || this.userlogin != 0) {
			//var link = '<a href="?c=session&a=logout">退出</a>';
			//div.append(link);
			$("#login_out").html('<a href="?c=session&a=logout"><img src="/style/agies/img/login_out.png" /></a>');
		}
		$("#drop").bind('mouseover',function(){
			$("#drop").addClass('open');
		});
		$("#drop").bind('mouseout',function(){
			$("#drop").removeClass('open');
		});
		/*
		var that = this;
		var div = $("#head-link").find("ul");
		if (this.userlogin != 0) {
			var link = '<li class=""><a href="?c=public&a=index">域名管理</a></li>';
			if(is_domain_register == 1){
				link += '<li class="" title="域名注册"><a href="/domain/">域名注册</a></li>';
			}
			if(that.container == 1)
			{
				link += '<li title="产品管理"><a href="?c=public&a=container">'+'容器管理'+'</a></li>';
			}
			link += '<li class="" title="账户管理"><a href="?c=public&a=user">'+this.useremail+'</a></li>';
			link += '<li class="" title="还有'+ this.unread + '封信息未读">';
			link += '<a href="?c=public&a=notice"><img src="/style/img/mail';
			if (this.unread == 0) {
				link += '-white'
			}	
			link += '.png" style="width:25px;height:20px;">';
			link += '<span id="head-unread"></span></a></li>';
			div.append(link);
			if (this.unread > 0) {
				div.find('#head-unread').text(this.unread).addClass('badge badge-important');
			}
		}
		if (this.domainlogin!=0 || this.userlogin != 0) {
			var link = '<li class=""><a href="?c=session&a=logout">退出</a></li>';
			div.append(link);
		}
		if (this.userlogin==0) {
			$("#go_home").attr('href','');
		}
		*/
	}
	this.getIsDomainRegister = function(){
		var that = this;
		$.ajax({
			url:'?c=public&a=getIsDomainRegister',
			dataType:'json',
			success:function(a){
				if(a.status.code == 1){
					that.is_domain_register = a.ret;
					that.container = a.container;
					that.renderLink();
				}
			},
			error:function(a){
				alert("网络出错");
			}
		});
	}
}
$(document).ready(function(){
	var _link = new headlink();
	_link.getInfo();
});
var m_i = 0;
function rMenu(){
	if(m_i == 0){
		$(".menus_top").find("a").css("display","block");
		m_i = m_i+1;
	}else{
		$(".menus_top").find("a").css("display","none");
		m_i = m_i - 1;
	}
	
}
function openCloseBg(oc){
	if(oc == 'open'){
		var template = $("#pop_bg_template").html();
		$("#div-bg").html(template);
		return;
	}
	if(oc == 'close'){
		$("#div-bg").html("");
		return;
	}
}
