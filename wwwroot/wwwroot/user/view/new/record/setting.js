var domainsetting = function() {
		this.domain = '';
		this.pname = '免费版';
		this.autorenew = 0;
		this.passwd = '';
		this.domainkey = '';
		this.ttl = 0;
		this.linegroup = '';
		this.linegrouplist = [];
		this.weixin = '';
		this.sms = '';
		this.email = '';
		this.tbody = $("#setting_tbody");
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
					that.autorenew = a.domain.auto_renew;
					that.passwd = a.domain.passwd;
					that.domainkey = a.domain.domain_key;
					that.ttl = a.domain.ttl;
					that.linegroup = a.domain.group_view;
					that.selfcdn = a.selfcdn;
					that.weixin = a.domain.weixin;
					that.email = a.domain.email;
					that.sms =a.domain.sms;
					that.render();
				},
				error:function(e) {
					that.showError('后台数据出错'+e.responseText);
				}
			});
		}
		this.renderLoginError = function() {
			var template = $("#domainsetting-nologin-template").html();
			this.tbody.append(template);
		}
		this.render = function() {
			$("#domain_name_show").html(this.domain);
			$("#domain_pname_show").html(this.pname).parent('a').attr('href','?c=product&a=index&domain='+this.domain);
			this.renderDomainkey();
			this.renderPasswd();
			this.renderAutorenew();
			this.renderTtl();
			this.renderWeixin();
			this.getLinegroupList();
		}
		this.renderWeixin = function() {
			var that = this;
			var template = $("#weixin-show-template").html();
			var update = false;
			if ($("#weixin-row").html()) {
				update = true;
				template = $("#weixin-refresh-template").html();
			}
			var option = [];
			option.message = '';
			if (this.weixin==''&&this.sms==''&&this.email=='') {
				option.message = '<span class="text-error">已关闭</span> ';
			}
			if (this.weixin=='yes') {
				option.message += '<span class="text-success">微信已开启</span>&nbsp;&nbsp; ';
			}
			 if (this.sms=='yes'){
					option.message += '<span class="text-success">短信已开启</span>&nbsp;&nbsp; ';
			}
		   if (this.email=='yes'){
				option.message += '<span class="text-success">邮件已开启</span>&nbsp;&nbsp; ';
		   }
				
			
			var el = Mustache.to_html(template,option);
			if (update) {
				$("#weixin-row").html(el);
			}else {
				this.tbody.append(el);
			}
			var div = $("#weixin-row");
			div.find("#weixin").bind('click',function() {
				that.renderEditWeixin();
			});
		}
		this.renderEditWeixin = function() {
			var that = this;
			var template = $("#weixin-edit-template").html();
			var div = $("#weixin-row");
			var data = [];
			if(that.weixin =="yes"){
				data['notice_weixin'] = 'checked';
			}else{
				data['notice_weixin'] = '';
			}
			if(that.sms =="yes"){
				data['notice_sms'] = 'checked';
			}else{
				data['notice_sms'] = '';
			}
			if(that.email=="yes"){
				data['notice_email'] = 'checked';
			}else{
				data['notice_email']	= '';
			}
			var el = Mustache.to_html(template,data);
			div.html(el);
			div.find('#enter').bind('click',function() {
				that.editWeixin();
			});
			div.find('#esc').bind('click',function(){
				that.renderWeixin();
			});
		}
		this.editWeixin = function() {
			var that = this;
			var div = $("#weixin-row");
			var weixin = div.find('[name=weixin]:checked').val();
			var sms = div.find('[name=sms]:checked').val();
			var email = div.find('[name=email]:checked').val();
			var weixinattr = div.find('[name=weixin]').attr("checked");
			var smsattr = div.find('[name=sms]').attr("checked");
			var emailattr = div.find('[name=email]').attr("checked");
			
			$.ajax({
				url:'/api/?c=record&a=changeWeixin',
				data:{
					weixin:weixin,
					sms:sms,
					email:email
				},
				dataType:'json',
				success:function(a) {
					if (a.status.code != 1) {
						that.showError(a.status.message, true);
						return;
					}
					that.showMessage(a.status.message,true);
					that.weixin = weixin=="weixin"?'yes':'';
					that.sms = sms=="sms"?'yes':'';
					that.email = email=="email"?'yes':'';
					that.renderWeixin();
				},
				error:function(e) {
					
				}
				
			});
			
			
		}
		this.showError = function(message, clear) {
			$("#error-message").html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass('alert-success').addClass('alert alert-error');
			if (clear) {
				setTimeout(function() {
					$("#error-message").html('').removeClass('alert alert-success alert-error');
				}, 4000);
			}
			$("#error-message").find('a').bind('click',function(){
				$("#error-message").html("").removeClass('alert alert-success').removeClass('alert-error');
			});
		}
		this.showMessage = function(message, clear) {
			$("#error-message").html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass('alert-error').addClass('alert alert-success');;
			if (clear) {
				setTimeout(function() {
					$("#error-message").html('').removeClass('alert alert-success alert-error');
				}, 4000);
			}
			$("#error-message").find('a').bind('click',function(){
				$("#error-message").html("").removeClass('alert alert-success alert-error');
			});
		}
		this.renderDomainkey = function() {
			var that = this;
			if ($("#domainkey-row").html()) {
				var template = $("#domainkey-refresh-template").html();
			}else {
				var template = $("#domainkey-show-template").html();
			}
			var data = [];
			if (this.domainkey) {
				data.message = '已设置';
			}else {
				data.message = '未设置'
			}
			var el = Mustache.to_html(template,data);
			if ($("#domainkey-row").html()) {
				$("#domainkey-row").html(el);
			}else {
				this.tbody.append(el);
			}
			$("#domainkey-row").find('a').bind('click',function(){
				that.renderDomainkeyEdit();
			});
		}
		this.renderDomainkeyEdit = function() {
			var that = this;
			var template = $("#domainkey-edit-template").html();
			var data = [];
			data.setmessage = this.domainkey ? '已设置' :'未设置';
			var el = Mustache.to_html(template,data);
			$("#domainkey-row").html(el);
			$("#domainkey-row").find('input').trigger('focus');
			$("#domainkey-row").find('button').eq(0).bind('click',function(){
				that.saveDomainkey($("#domainkey-row").find('input').val());
			});
			$("#domainkey-row").find('button').eq(1).bind('click',function(){
				that.renderDomainkey();
			});
			
		}
		this.saveDomainkey = function(newdomainkey){
			var that = this;
			$.ajax({
				url:'/api/?c=record&a=setDomainkey',
				data:{domainkey:newdomainkey,domain:that.domain},
				dataType:'json',
				success:function(a) {
					if (parseInt(a.status.code) != 1) {
						that.showError(a.status.message,true);
						return;
					}
					that.domainkey = newdomainkey;
					that.renderDomainkey();
				},
				error:function(e) {
				}
			});
		}
		this.renderPasswd = function() {
			var that = this;
			if ($("#passwd-row").html()) {
				var template = $("#passwd-refresh-template").html();
			}else {
				var template = $("#passwd-show-template").html();
			}
			var data = [];
			if (this.passwd) {
				data.message = '已设置';
			}else {
				data.message = '未设置'
			}
			var el = Mustache.to_html(template,data);
			if ($("#passwd-row").html()) {
				$("#passwd-row").html(el);
			}else {
				this.tbody.append(el);
			}
			$("#passwd-row").find('a').bind('click',function(){
				that.renderPasswdEdit();
			});
		}
		this.renderPasswdEdit = function() {
			var that = this;
			var template = $("#passwd-edit-template").html();
			var data = [];
			data.setmessage = this.passwd ? '已设置' :'未设置';
			var el = Mustache.to_html(template,data);
			$("#passwd-row").html(el);
			$("#passwd-row").find('input').trigger('focus');
			$("#passwd-row").find('button').eq(0).bind('click',function(){
				that.savePasswd($("#passwd-row").find('input').val());
			});
			$("#passwd-row").find('button').eq(1).bind('click',function(){
				that.renderPasswd();
			});
		}
		this.savePasswd = function(newpasswd) {
			var that = this;
			$.ajax({
				url:'/api/?c=record&a=setPasswd',
				data:{domain:that.domain,passwd:newpasswd},
				dataType:'json',
				success:function(a) {
					if (parseInt(a.status.code) != 1) {
						that.showError(a.status.message,true);
						return;
					}
					that.passwd = newpasswd;
					that.renderPasswd();
				},
				error:function(e) {
					
				}
			});
		}
		this.renderAutorenew = function() {
			var that = this;
			if ($("#autorenew-row").html()) {
				var template = $("#autorenew-refresh-template").html();
			}else {
				var template = $("#autorenew-show-template").html();
			}
			var data = [];
			if (this.autorenew==1) {
				data.message = '已开启';
			}else {
				data.message = '已关闭'
			}
			var el = Mustache.to_html(template,data);
			if ($("#autorenew-row").html()) {
				$("#autorenew-row").html(el);
			}else {
				this.tbody.append(el);
			}
			$("#autorenew-row").find('a').bind('click',function(){
				that.renderAutorenewEdit();
			});
		}
		this.renderAutorenewEdit = function() {
			var that = this;
			var template = $("#autorenew-edit-template").html();
			var data = [];
			data.autorenew = this.autorenew==1 ? 'yes' :'';
			var el = Mustache.to_html(template,data);
			$("#autorenew-row").html(el);
			$("#autorenew-row").find('input').trigger('focus');
			$("#autorenew-row").find('button').eq(0).bind('click',function(){
				that.saveAutorenew($("#autorenew-row").find(':radio:checked').val());
			});
			$("#autorenew-row").find('button').eq(1).bind('click',function(){
				that.renderAutorenew();
			});
		}
		this.saveAutorenew = function(val) {
			var that = this;
			if (parseInt(val)==this.autorenew) {
				that.renderAutorenew();
				return;
			}
			$.ajax({
				url:'/api/?c=record&a=setAutorenew',
				data:{autorenew:val,domain:that.domain},
				dataType:'json',
				success:function(a) {
					if (parseInt(a.status.code) != 1) {
						that.showError(a.status.message,true);
						return;
					}
					that.autorenew = val;
					that.renderAutorenew();
				},
				error:function(e) {
				}
			});
		}
		this.renderTtl = function() {
			var that = this;
			if ($("#ttl-row").html()) {
				var template = $("#ttl-refresh-template").html();
			}else {
				var template = $("#ttl-show-template").html();
			}
			var data = [];
			if (this.ttl < 3600) {
				data.message = this.ttl/60 + '分钟';
			}else {
				data.message = this.ttl /3600 + '小时';
			}
			var el = Mustache.to_html(template,data);
			if ($("#ttl-row").html()) {
				$("#ttl-row").html(el);
			}else {
				this.tbody.append(el);
			}
			$("#ttl-row").find('a').bind('click',function(){
				that.renderTtlEdit();
			});
		}
		this.renderTtlEdit = function() {
			var that = this;
			var template = $("#ttl-edit-template").html();
			var data = [];
			data['ttl'+this.ttl] = 'checked';
			var el = Mustache.to_html(template,data);
			$("#ttl-row").html(el);
			$("#ttl-row").find('input').trigger('focus');
			$("#ttl-row").find('button').eq(0).bind('click',function(){
				that.saveTtl($("#ttl-row").find(':radio:checked').val());
			});
			$("#ttl-row").find('button').eq(1).bind('click',function(){
				that.renderTtl();
			});
		}
		this.saveTtl = function(val) {
			if (typeof val == 'undefined') {
				that.renderTtl();
				return;
			}
			var that = this;
			$.ajax({
				url:'/api/?c=record&a=changeTtl',
				data:{domain:that.domain,ttl:val},
				dataType:'json',
				success:function(a) {
					if (a.status.code != 1) {
						that.showError(a.status.message,true);
						return;
					}
					that.ttl = val;
					that.renderTtl();
				},
				error:function(e) {
				}
			});
		}
		this.getLinegroupList = function() {
			var that = this;
			$.ajax({
				url:'/api/?c=line&a=getLinegroupList',
				data:{domain:that.domain},
				dataType:'json',
				success:function(a) {
					if (a.count==0) {
						that.linegrouplist.push(['.0.0','默认']);
					}else {
						that.linegrouplist = a.linegroups;
					}
					that.renderLinegroup();
				},
				error:function(e) {
					that.linegrouplist.puah(['.0.0','默认']);
					that.renderLinegroup();
				}
			});
		}
		this.getLinegroupHtml = function(checkedvalue) {
			var html = '&nbsp;';
			for ( var i in this.linegrouplist) {
				html += '<input type="radio" name="linegroup" value="'+this.linegrouplist[i][0]+'"';
				if (this.linegrouplist[i][0]==checkedvalue) {
					html += ' checked';
				}
				html += '>'+this.linegrouplist[i][1];	
				html += '&nbsp;&nbsp;'
			}
			return html;
		}
		this.renderLinegroup = function() {
			var that = this;
			if ($("#linegroup-row").html()) {
				var template = $("#linegroup-refresh-template").html();
			}else {
				var template = $("#linegroup-show-template").html();
			}
			var option = [];
			option.message = this.getThisLinGroupName();
			var el = Mustache.to_html(template,option);
			if ($("#linegroup-row").html()) {
				$("#linegroup-row").html(el);
			}else {
				this.tbody.append(el);
			}
			$("#linegroup-row").find('a').bind('click',function(){
				that.renderLinegroupEdit();
			});
		}
		this.getThisLinGroupName = function() {
			for ( var i in this.linegrouplist) {
				if (this.linegrouplist[i][0]==this.linegroup) {
					return this.linegrouplist[i][1];
				}
			}
			return '默认';
		}
		this.renderLinegroupEdit = function() {
			var that = this;
			var template = $("#linegroup-edit-template").html();
			var data = [];
			var option = [];
			option.linegrouphtml = this.getLinegroupHtml(this.linegroup);
			var el = Mustache.to_html(template,option);
			var div = $("#linegroup-row")
			div.html(el);
			div.find('input').trigger('focus');
			div.find('button').eq(0).bind('click',function(){
				that.saveLinegroup(div.find(':radio:checked').val());
			});
			div.find('button').eq(1).bind('click',function(){
				that.renderLinegroup();
			});
		}
		this.saveLinegroup = function(linegroup) {
			var that = this;
			if (linegroup == this.linegroup) {
				this.renderLinegroup();
				return;
			}
			$.ajax({
				url:'/api/?c=line&a=changeGroupview',
				data:{domain:that.domain,groupview:linegroup},
				dataType:'json',
				success:function(a) {
					if (a.status.code != 1) {
						that.showError(a.status.message,true);
						return;
					}
					that.linegroup = linegroup;
					that.renderLinegroup();
				},
				error:function(e) {
				}
			});
		}
	}

$(document).ready(function() {
		var setting = new domainsetting();
		setting.getInfo();
		$("#record-operat").find('#setting').find('a').addClass('cur');
		$("#nav_domain").addClass("nav_domain");
		$("#form-search").find("#search-query").remove();
});