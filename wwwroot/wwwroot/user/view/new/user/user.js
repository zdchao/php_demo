	$(document).ready(function(){
		var user = function() {
			this.apiKey = "";
			this.ips = "";
			this.cdnProduct = [];
			this.selfcdn = 1;
			this.cb_uid = 0;
			this.close = 0;
			this.cdnConfig = false;
			// this.offset = 0;
			this.length = 10;
			this.page = 0;
			this.userpage = 0;
			this.ns1 = '';
			this.ns2 = '';
			this.money = 0;
			// 电话
			this.tel = 0;
			// 姓名
			this.name = '';
			this.passwd = '';
			this.email = '';
			this.uid = '';
			this.openid='';
			this.divided = 0;
			this.last_login_date = '';
			this.moneyloglist = [];
			this.listdiv = $("#list-content");
			this.proxylistdiv = $("#proxy-row");
			this.proxylistarr = [];
			this.pageCount = 0;
			this.issetWeiXin = true;
			this.InterValObj=0; //timer变量，控制时间
		    this.count = 5; //间隔函数，1秒执行
            this.smsMoney= 0;//短信收费
            this.sms = 0;
            this.adminSmsReady = false;
            this.tbody = $("#content_tbody");
            this.flags = '';
            this.free_message = 0;
			this.getInfo = function() {
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=getInfo',
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.renderLoginError();
							return;
						}
						that.ns1 = a.user.ns1name;
						that.ns2 = a.user.ns2name;
						that.money = parseInt(a.user.money)/100;
						that.tel = a.user.tel;
						that.name = a.user.name;
						that.passwd = a.user.passwd;
						that.email = a.user.email;
						that.uid = a.user.id;
						that.openid=a.user.openid;
						that.divided = a.user.divided;
						that.last_login_date = a.user.last_login_date;
						that.selfcdn = a.selfcdn;
						that.cb_uid = a.cb_uid;
						that.cdnConfig = a.cdnConfig;
						that.issetWeiXin = a.issetWeiXin;
						that.smsMoney = parseInt(a.smsMoney)/100;
						that.sms = a.user.sms;
						that.flags = a.user.flags;
						that.free_message = a.user.free_message;
						that.adminSmsReady = a.adminSmsReady;
						that.apiKey = a.user.api_key;
						that.ips = a.user.api_ips;
						that.render(a.iscdn);
						that.getMoneylogList(0);
					},
					error:function(e) {
						that.showError('后台数据出错' + e.responseText);
					}
				});
			}
			this.render = function(iscdn) {
				this.tbody.html("");
				this.renderMoney();
				this.renderNs();
				//api设置
				this.userApiManager();
				this.renderTel();
				this.renderName();
				this.renderPasswd();	
				this.renderMoneylog();
				this.renderProxy();
				if(iscdn == 1){
					this.renderCdn();
				}
				if(this.issetWeiXin){
						this.renderWeiXin();
			    }
				this.renderDisturb();
			}
			this.userApiManager = function(){
				var that = this;
				if(that.apiKey == null || that.apiKey == ""){
					var api_edit = "";
				}else{
					var api_edit = true;
				}
				var template = $("#api-manager-template").html();
				var option = [];
				option.api_edit = api_edit;
				var el = Mustache.to_html(template,option);
				this.tbody.append(el);
				var tr = $("#api-manager-tr");
				if(that.apiKey == null || that.apiKey == ""){
					tr.find("#set").bind("click",function(){
						that.showApiSetBox(that.uid,"","");
					});
					return;
				}else{
					tr.find("#edit").bind("click",function(){
						that.showApiSetBox(that.uid,that.apiKey,that.ips);
					});
				}
			}
			this.showApiSetBox = function(uid,key,ips){
				var that = this;
				var edit_template = $("#api-edit-template").html();
				if($("#api-edit-tr").html()){
					return;
				}
				var option = [];
				option.uid = uid;
				option.key = key;
				option.ips = ips;
				var edit_el = Mustache.to_html(edit_template,option);
				$("#api-manager-tr").after(edit_el);
				var edit_tr = $("#api-edit-tr");
				edit_tr.find("#generate").bind("click",function(){
					var api_key = that.generateKey(16);
					edit_tr.find("[name=key]").val(api_key);
				});
				edit_tr.find("#empty").bind("click",function(){
					edit_tr.find("[name=key]").val("");
				});
				edit_tr.find("#drop").bind('click',function(){
					edit_tr.remove();
				});
				edit_tr.find("#set").bind('click',function(){
					var key = edit_tr.find("[name=key]").val();
					var ip = edit_tr.find("[name=ip]").val();
					if(key == ""){
						ip = "";
					}
					that.userApiSet(that.uid, key, ip);
				});
			}
			this.userApiSet = function(uid,key,ip){
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=apiKeySet',
					type:'POST',
					data:{uid:uid,key:key,ip:ip},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.showError('API设置失败',false);
							return;
						}
						that.apiKey = key;
						that.showError("API设置成功",true);
						window.location.href = "?c=public&a=user";
					},
					error:function(a){
						alert("error");
					}
				});
			}
			 this.generateKey = function(length) {
				var pwchars = "abcdefhjmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWYXZ";
				var passwordlength = length ? length : 8; 
				var key="";
				for (i = 0; i < passwordlength; i++) {
					key += pwchars.charAt(Math.floor(Math.random() * pwchars.length))
				}
				return key;
			}
			this.renderLoginError = function() {
				var template = $("#user-nologin-template").html();
				this.tbody.append(template);
			}
			this.renderName = function() {
				var that = this;
				var data = [];
				data.name = this.name;
				if ($("#name-row").html()) {
					var template = $("#name-refresh-template").html();
				}else {
					var template = $("#name-show-template").html();
				}
				var el = Mustache.to_html(template,data);
				if ($("#name-row").html()) {
					$("#name-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#name-row").find('a').bind('click',function(){
					that.renderNameEdit();
				});
			}
			this.renderNameEdit = function() {
				var that = this;
				var template = $("#name-edit-template").html();
				var data = [];
				data.name = this.name;
				var el = Mustache.to_html(template,data);
				$("#name-row").html(el);
				$("#name-row").find('input').trigger('focus');
				$("#name-row").find('button').eq(0).bind('click',function() {
					that.nameSave($("#name-row").find('input').val());
				});
				$("#name-row").find('button').eq(1).bind('click',function() {
					that.renderName();
				});
			}
			this.nameSave = function(newname) {
				var that = this;
				if (newname == this.name) {
					that.renderName();
					return;
				}
				$.ajax({
					url:'/api/?c=user&a=modifyName',
					data:{name:newname},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.name = newname;
						that.renderName();
					},
					error:function(e) {
					}
				});
			}
			this.renderMoney = function() {
				var that = this;
				var template = $("#money-show-template").html();
				if($("#money-row").html()) {
					template = $("#money-refresh-template").html();
				}
				var data = [];
				data.money = this.money;
				var el = Mustache.to_html(template,data);
				if($("#money-row").html()) {
					$("#money-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#money-row").find('#money').bind('click',function(){
					that.renderMoneyEdit();
				});
			}
			this.renderMoneyEdit = function() {
				var that = this;
				var template = $("#money-edit-template").html();
				var el = Mustache.to_html(template);
				$("#money-row").html(el);
				$("#money-row").find('input').trigger('focus');
				$("#money-row").find('button').eq(0).bind('click',function() {
					that.moneySave($("#money-row").find('input').val());
				});
				$("#money-row").find('button').eq(1).bind('click',function() {
					that.renderMoney();
				});
			}
			this.moneySave = function(money) {
				if (money <= 0 || !money) {
					this.showError('价格错误',true);
					return;
				}
				window.open('/user/?c=user&a=addMoneySelect&money=' + money);
			}
			this.renderNs = function() {
				var that = this;
				var template = $("#ns-show-template").html();
				var data = [];
				data.ns1 = this.ns1;
				data.ns2 = this.ns2;
				var el = Mustache.to_html(template,data);
				this.tbody.append(el);
			}
			this.renderTel = function() {
				var that = this;
				if ($("#tel-row").html()) {
					var template = $("#tel-refresh-template").html();
				}else {
					var template = $("#tel-show-template").html();
				}
				var data = [];
				data.tel = this.tel;
				data.adminSmsReady=this.adminSmsReady;
				var el = Mustache.to_html(template,data);
				if ($("#tel-row").html()) {
					$("#tel-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#tel-row").find("#sms").bind('click',function(){
					that.renderSmsEdit();
				});
				$("#tel-row").find('#modify').bind('click',function(){
					if(that.sms==1)
					{
						that.renderTelEdit();
					}
					else{
						that.renderTelEditWithoutCode();
					}
				});
			}
			this.renderTelEditWithoutCode = function(){
				var that = this;
				var template = $("#tel-editWithoutCode-template").html();
				var el = Mustache.to_html(template);
				$("#tel-row").html(el);		
				$("#tel-row").find('#new-tel').trigger('focus');	
				$("#tel-row").find('button').eq(0).bind('click',function() {
					that.telSaveWithoutCode($("#tel-row").find('input').val());
				});
				$("#tel-row").find('button').eq(1).bind('click',function() {
					that.renderTel();
				});	
			}
			this.telSaveWithoutCode = function(newtel){
				var that = this;
				var patt = /^1[3458][0-9]{9}$/; // 1开头,跟着3|4|5|8,再来9位数字
				if(patt.test(newtel)){
					if (newtel == that.tel) {
						that.renderTel();
						return;
					}
				}else{
					//alert('请输入正确的手机号');
					that.showError('请输入正确的手机号',true);
					return;
				}
				$.ajax({
					url:'/api/?c=user&a=modifyTel2',
					data:{telephone:newtel},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.showError("修改成功",true);
						that.tel = newtel;
						that.renderTel();
					},
					error:function(e) {
					}
				});
			}
			
			this.renderSmsEdit = function(){
				var that = this;
				var template = $("#sms-edit-template").html();
				var option=[];
			    option.smsMoney = that.smsMoney;
			    option.sms=that.sms==1?1:'';
			    option.tel = that.tel;
			    option.free_message = that.free_message;
				var el = Mustache.to_html(template,option);
				$("#tel-row").html(el);
				$("#tel-row").find('#new-tel').trigger('focus');	
				$("#get-code").bind('click',function(){
					var new_tel = $("#new-tel").val();
					var patt = /^1[3458][0-9]{9}$/; // 1开头,跟着3|4|5|8,再来9位数字
					if(patt.test(new_tel)){
					}else{
						//alert('请输入正确的手机号');
						that.showError('请输入正确的手机号',true);
						return;
					}
					$.ajax({
						url:'/api/?c=user&a=getTelVerifiedCode',
						data:{telephone:new_tel},
						dataType:'json',
						success:function(a) {
							/** api_exit()* */
							if (a.status.code != 1) {
								that.showError(a.status.message,true);
								return;
							}
							that.showError(a.status.message,true);
							that.free_message = a.free_message;
							that.money = a.money/100;
							that.renderMoney();
							if(curCount == 0){
								  curCount=a.curCount;
							}
							$("#tel-row").find('#get-code').attr("disabled", "true");		
							$("#tel-row").find('#get-code').html("在" + curCount + "秒内可重新操作"); 
							$("#tel-row").find('#clock').html("验证码发送成功，该验证码在10分钟内有效，请勿泄露！").css('color','green');					
							window.clearTimeout(that.InterValObj);
							that.InterValObj = window.setInterval(that.SetRemainTime, 1000); //启动计时器，1秒执行一次
						},
						error:function(e) {
						}
					});			
				});				
				$("#tel-row").find('#enter').bind('click',function() {
					 $("#tel-row").find('#get-code').removeAttr("disabled");
	 	             $("#tel-row").find('#get-code').html("重新获取验证码"); 
		             $("#tel-row").find('#clock').html("");    
					if(that.sms == 0){     
			             that.telCheck($("#tel-row").find('input').val(),$('#code').val());
					}
					else{    
						that.smsEdit();
					}
				});
				$("#tel-row").find("#esc").bind('click',function() {
					that.renderTel();
				});	
			}
			this.smsEdit = function(){
				var that = this;
				var sms=this.sms==1?0:1;
				$.ajax({
					url:'/api/?c=user&a=modifySms',
					data:{sms:sms},
					dataType:'json',
					success:function(a){
							if(a.status.code!=1){
								that.showError(a.status.message,true);
								return;
							}
							if(that.money<10 && sms!=1){
								alert("您的余额已不足，请尽快充值！");
							}
							that.showError("操作成功",true);
							that.sms = sms;
							that.renderTel();
					}
				});	
			}
			this.renderTelEdit = function() {
				var that = this;
				var option = [];
				option.smsMoney = this.smsMoney;
				option.free_message = this.free_message;
				var template = $("#tel-edit-template").html();
				var el = Mustache.to_html(template,option);
				$("#tel-row").html(el);		
				$("#tel-row").find('#new-tel').trigger('focus');	
				$("#get-code").bind('click',function(){
					var new_tel = $("#new-tel").val();
					var patt = /^1[3458][0-9]{9}$/; // 1开头,跟着3|4|5|8,再来9位数字
					if(patt.test(new_tel)){
					}else{
						//alert('请输入正确的手机号');
						that.showError('请输入正确的手机号',true);
						return;
					}
					$.ajax({
						url:'/api/?c=user&a=getTelVerifiedCode',
						data:{telephone:new_tel},
						dataType:'json',
						success:function(a) {
							/** api_exit()* */
							if (a.status.code != 1) {
								that.showError(a.status.message,true);
								return;
							}
							that.showError(a.status.message,true);
							that.free_message = a.free_message;
							that.money = a.money/100;
							that.renderMoney();
							if(curCount == 0){
								  curCount=a.curCount;
							}
							$("#tel-row").find('#get-code').attr("disabled", "true");		
						    $("#tel-row").find('#get-code').html("在" + curCount + "秒内可重新操作"); 
							$("#tel-row").find('#clock').html("验证码发送成功，该验证码在10分钟内有效，请勿泄露！").css('color','green');				
							window.clearTimeout(that.InterValObj);
							that.InterValObj = window.setInterval(that.SetRemainTime, 1000); //启动计时器，1秒执行一次
						},
						error:function(e) {
						}
					});			
				})
				$("#tel-row").find('#enter').bind('click',function() {
					  $("#tel-row").find('#get-code').removeAttr("disabled");
	 	              $("#tel-row").find('#get-code').html("重新获取验证码"); 
		              $("#tel-row").find('#clock').html("");   
					that.telSave($("#tel-row").find('input').val(),$('#code').val());
				});
				$("#tel-row").find('#esc').bind('click',function() {
					that.renderTel();
				});	
			}
			this.SetRemainTime = function() 
			{
				 var that = this;      
	            if (curCount == 0) {                
	                window.clearInterval(that.InterValObj);//停止计时器 
	                $("#tel-row").find('#get-code').removeAttr("disabled");
 	                $("#tel-row").find('#get-code').html("重新获取验证码"); 
	                $("#tel-row").find('#clock').html("");      
	            }
	            else {
	                curCount = parseInt(curCount)-1;
	                $("#tel-row").find('#get-code').html("在" + curCount + "秒内可重新操作"); 
	            }
		  }
			this.showError = function(message,clear) {
				$("#show_error").show();
				$("#show_error").html(message);
				if (clear) {
					setTimeout(function(){
						$("#show_error").html("");
						$("#show_error").hide();
					},4000);
				}
			}
			this.showMessage = function(message, clear) {
				var that = this;
				that.errordiv.html(message).append('&nbsp;&nbsp;<a href="javascript:;" id="closea"><i class="icon-remove"></i></a>').removeClass('alert-error').addClass('alert alert-success');;
				if (clear) {
					setTimeout(function() {
						that.errordiv.html('').removeClass('alert alert-success alert-error');
					}, 4000);
				}
				that.errordiv.find('#closea').bind('click',function(){
					that.errordiv.html("").removeClass('alert alert-success alert-error');
				});
				that.errordiv.find('#show_multia').bind('click',function(){
					that.showAllMultiMessage();
				});
			}
			this.telSave = function(newtel,code) {
				var that = this;
				if (newtel == this.tel) {
					that.renderTel();
					return;
				}
				$.ajax({
					url:'/api/?c=user&a=modifyTel',
					data:{telephone:newtel,code:code},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.showError("修改成功",true);
						that.tel = newtel;
						that.renderTel();
					},
					error:function(e) {
					}
				});
			}
			
			this.telCheck = function(newtel,code) {
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=modifyTel',
					data:{telephone:newtel,code:code},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.money = parseInt(a.money)/100;
						that.smsEdit();
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
				var el = Mustache.to_html(template);
				$("#passwd-row").html(el);
				$("#passwd-row").find('[name=oldpasswd]').trigger('focus');
				$("#passwd-row").find('button').eq(0).bind('click',function() {
					that.passwdSave($("#passwd-row").find('[name=newpasswd]').val(),$("#passwd-row").find('[name=oldpasswd]').val());
				});
				$("#passwd-row").find('button').eq(1).bind('click',function() {
					that.renderPasswd();
				});
			}
			this.passwdSave = function(newpasswd,oldpasswd) {
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=changePassword',
					data:{old_password:oldpasswd,new_password:newpasswd},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						} 
						that.renderPasswd();
					},
					error:function(e) {
					}
				});
			}
			this.renderMoneylog = function() {
				var that = this;
				var flag = true;
				$("header").slideDown("slow");
				if ($("#moneylog-row").html()) {
					var template = $("#moneylog-refresh-template").html();
					$("#moneylog-row").find('.span12').slideUp("slow");
				}else {
					var template = $("#moneylog-show-template").html();
				}
				var el =  Mustache.to_html(template);
				if ($("#moneylog-row").html()) {
					$("#moneylog-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#moneylog-row").bind('click',function()
				{
					if(flag==true)
					{
					     flag = false;
				         that.renderMoneylogList(that.close);
					}
					else{
						 flag = true;
						 that.renderMoneylog();
					}
			    });
				}
			
			
			this.renderMoneyList2 = function(rows)
			{
				var div = $("#list-content");
				var template =  $("#moneylog-list-row-template").html();
				
				for ( var i in rows) {
					if(rows[i]['type'] == "其它"){
						continue;
					}
					var el = Mustache.to_html(template,rows[i]);
					div.append(el);
				}
			}
			this.renderMoneylogList = function(close) {
				$("header").slideUp("slow");
				var that = this; 
				if (that.moneyloglist.length < 1) {
					this.getMoneylogList(0);
					return;
				} 
				
				var listtemplate = $("#moneylog-list-show-template").html();
				var div = $("#moneylog-row");
				div.html(listtemplate);
				var template = $("#moneylog-list-row-template").html();
				for ( var i in this.moneyloglist) {
					var el = Mustache.to_html(template,this.moneyloglist[i]);
					div.find("#list-content").append(el);
				}
				
				/*var closelist = $("#moneylog-list-close-template").html();
				div.find("#list-content").append(closelist);*/
				if(close == 1){
					$("#button1").html("");
				}
				div.find('#button').bind('click',function(){
					that.renderMoneylog();
				});
				div.find("#button1").bind('click',function(){
					that.getMoneylogList(that.page+1);
				});
				
			}
			this.getMoneylogList = function(page){
				var that = this;
				$("#td1").remove();
				$("#zhdc").remove();
				$.ajax({
					url : '/api/?c=moneylog&a=getList',
					dataType : 'json',
					async:false,
					success : function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						for(var i in a.rows) {
							if(a.rows[i]['type'] == "其它"){
								continue;
							}
							that.moneyloglist.push(a.rows[i]);
						}
						that.renderMoneyList2(a.rows);
						
						var closelist = $("#moneylog-list-close-template").html();
						$("#list-content").append(closelist);
						$('#button').bind('click',function(){
							that.renderMoneylog();
						});
						$("#button1").bind('click',function(){
							that.getMoneylogList(that.page+1);
						});
						if(a.count != that.length){
							 $("#button1").html("");
							 that.close = 1;
						}
						// 滚动条置底
						that.scrollToBottom();
						
					},
					error : function(e) {
						that.showError('后台数据出错' + e.responseText);
					}
				});
			}
			/*
			 * 滚动条置底操作
			 */
			this.scrollToBottom = function(){
				window.scrollTo(0,document.body.scrollHeight);
			}
			this.renderProxy = function() {
				if (this.divided==0) {
					return;
				}
				var that = this;
				$("header").slideDown("slow");
				if ($("#proxy-row").html()) {
					var template = $("#proxy-refresh-template").html();
					$("#proxy-row").find('.span12').slideUp("slow");
				}else {
					var template = $("#proxy-show-template").html();
				}
				var option = [];
				option.divided = this.divided;
				var el =  Mustache.to_html(template,option);
				if ($("#proxy-row").html()) {
					$("#proxy-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#proxy-row").find('a').bind('click',function(){
					that.renderProxyList();
				});
			}
			this.proxylist = [];
			this.renderProxyList = function() {
				var that = this;
				if (this.proxylist.length == 0) {
					this.getProxylist();
					return;
				}
				
				var listtemplate = $("#proxy-list-show-template").html();
				var div = $("#proxy-row");
				div.html(listtemplate);
				var rowtemplate = $("#proxy-list-row-template").html();
				var arr = that.proxylistarr.slice(that.userpage * that.length,that.userpage * that.length + that.length);
 				for ( var i in arr) {
					var el = Mustache.to_html(rowtemplate,that.proxylist[arr[i]]);
					$("#proxy_user_rows").append(el);
				}
 				if(that.proxylist.length < that.length){
 					$("#more_proxy").find("#next").remove();
 				}
				div.find('#closed').bind({
					'click':function() {that.renderProxy();}
				});
				div.find('#next').bind('click',function(){
					that.userpage = that.userpage + 1;
					var arr = that.proxylistarr.slice(that.userpage * that.length,that.userpage * that.length + that.length);
					var rowtemplate = $("#proxy-list-row-template").html();
					for ( var i in arr) {
						var el = Mustache.to_html(rowtemplate,that.proxylist[arr[i]]);
						$("#proxy_user_rows").append(el);
					}
					if(((that.userpage * that.length) + that.length) >= that.proxylist.length){
						$("#more_proxy").find("#next").remove();
					}
				});
			}
			this.getProxylist = function() {
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=getProxyRecord',
					dataType:'json',
					success:function(a) {
						if (a.count >0) {
							that.proxylist = a.list;
							for(var i in that.proxylist){
								that.proxylistarr.push(i);
							}
							that.renderProxyList();
						}
					},
					error:function(e) {
					}
				});
			}
			this.renderCdn = function(){
				var that = this;
				if(!that.cdnConfig){
					//var template = $("#cdn-self-config-template").html();
					//$("tbody").append(template);
					return;
				}
				var template = $("#cdn-row-tempalte").html();
				var update = false;
				if($("#cdnproduct-row").html()){
					update = true;
					template  = $("#cdn-row-refresh-tempalte").html();
				}
				if (update) {
					$("#cdnproduct-row").html(template);
				}else {
					this.tbody.append(template);
				}
				$("#cdnproduct-row").find("#edit").bind('click',function(){
					that.renderCdnEdit();
				});
			}
			this.renderCdnProduct = function(data){
				if (data.length) {
					var html = 'cdn:<select name="cdn_pid"> '
					for ( var i in  data) {
						html += '<option value=' + data[i]['id'] + '>' + data[i]['name'] + "</option>";
					}
					html += '</select>';
					$("#cdnproduct-row").find("[name=cdn_key]").after(html);
				}
			}
			this.renderCdnEdit = function(){
				var that = this;
				var template = $("#cdn-edit-template").html();
				var option = [];
				option.cb_uid = this.cb_uid;
				if(that.selfcdn){
					option.title = "更改CDN";
				}else{
					option.title = "设置CDN";
				}
				var el = Mustache.to_html(template,option);
				var div  = $("#cdnproduct-row");
				div.html(el);
				if(that.selfcdn){
					div.find("[name=cdn_uid]").attr('disabled','disabled');
				}
				div.find("#enter").bind('click',function(){
					var cdn_uid = div.find("[name=cdn_uid]").val();
					var cdn_key = div.find("[name=cdn_key]").val();
					if(cdn_uid == "" || cdn_key == ""){
						that.showError('uid或秘钥不能为空',true);
						return;
					}
					that.getYouselfCdnProduct(cdn_uid,cdn_key);
				});
				div.find("#esc").bind('click',function(){
					that.renderCdn();
				});
			}
			this.getYouselfCdnProduct = function(cbuid,cbkey){
				var that = this;
				var cdn_uid = cbuid;
				var cdn_key = cbkey;
				that.cb_uid = cdn_uid;
				$.ajax({
					url:'/api/?c=user&a=getYouselfCdnProduct',
					type:'POST',
					data:{cdn_uid:cdn_uid,cdn_key:cdn_key},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.showError('验证出错可能uid或秘钥错误',true)
							return;
						}
						that.cdnSelfProductSelect(a.ret);
					},
					error:function(a){
						alert("error");
					}
				});
			}
			this.cdnSelfProductSelect = function(data){
				var that = this;
				var div = $("#cdnproduct-row");
				var template = $("#cdn-self-select-template").html();
				var option = [];
				option.select = that.selfCdnProductSelect(data);
				var el = Mustache.to_html(template,option);
				div.find("#operat").html(el);
				div.find("#enter").bind('click',function(){
					var cbuid = div.find('[name=cdn_uid]').val();
					var cbkey = div.find("[name=cdn_key]").val();
					var product = div.find("[name=product]").val();
					if(that.selfcdn){
						that.updatSelfCdnProduct(cbuid,cbkey,product);
						return;
					}
					that.addSelfCdnproduct(cbuid,cbkey,product);
				});
				div.find("#esc").bind('click',function(){
					that.renderCdn();
				});
			}
			this.selfCdnProductSelect = function(data){
				var that = this;
				that.cdnProduct.length = 0;
				var html = "<select name='product' style='width:100px;'>";
				for(var i in data){
					that.cdnProduct.push(data[i]);
					if(data[i] == ""){
						continue;
					}
					html += "<option value='"+i+"'>"+data[i]['name']+"</option>";
				}
				html += "</select>";
				return html;
			}
			this.addSelfCdnproduct = function(cbuid,cbkey,product){
				var that = this;
				var cbpid = that.cdnProduct[product]['cb_pid'];
				var name = that.cdnProduct[product]['name'];
				var cbdomain = that.cdnProduct[product]['cb_domain'];
				$.ajax({
					url:'/api/?c=user&a=addSelfCdnProduct',
					type:'POST',
					data:{cbuid:cbuid,cbkey:cbkey,cbpid:cbpid,name:name,cbdomain:cbdomain},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.showError('增加自用cdn产品失败',true);
							return;
						}
						that.showError('增加自用cdn产品成功',true);
						that.selfcdn = true;
						that.renderCdn();
					},
					error:function(a){
						alert('error');
					}
				});
			}
			this.updatSelfCdnProduct = function(cbuid,cbkey,product){
				var that = this;
				var cdn_pid = that.cdnProduct[product]['cb_pid'];
				var name = that.cdnProduct[product]['name'];
				var cdn_domain = that.cdnProduct[product]['cb_domain'];
				$.ajax({
					url:'/api/?c=user&a=updateSelfCdnProduct',
					type:'POST',
					data:{cdn_key:cbkey,cdn_pid:cdn_pid,name:name,cdn_domain:cdn_domain},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.showError('修改自用cdn产品失败',true);
							return;
						}
						that.showError('修改自用cdn产品成功',true);
						that.renderCdn();
					},
					error:function(a){
						alert('error');
					}
				});
			}
			this.renderWeiXin = function(){
				var that = this;
				if ($("#weixin-row").html()){
					var template = $("#weixin-refesh-template").html();
				}else {
					var template = $("#weixin-show-template").html();
				}
				var data=[];
			    data.openid = this.openid;
				var el = Mustache.to_html(template,data);
				if ($("#weixin-row").html()) {
					$("#weixin-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#weixin-row").find('a').bind('click',function(){
					if(!(that.openid)){
						that.renderWeiXinBind();
					}
					else{
						that.renderWeiXinUnbind();
					}
				});
			}
			
			this.renderWeiXinBind = function(){
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=createQrcode',
					dataType:'json',
					success:function(a){	
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						var data=[];
					    data.weixin_url=a.QrcodeUrl;  
						var template = $("#weixin-Qrcode-template").html();
						var el = Mustache.to_html(template,data);
						var div = $("#piao-modal");
						div.find(".modal-body").html(el);
						div.modal('show');
						//that.dia = art.dialog({id:"edit-weixin-dia",title:"微信绑定",content:el,lock:true,top:'10%'});
						that.checkWeiXinComplate(div);
					}
				});
			}
			this.checkWeiXinComplate = function(div) {
				var that = this;
				function check() {
					setTimeout(function(){
						$.ajax({
							url:'/api/?c=user&a=checkComplate',
							dataType:'json',
							success:function(a) {
								if (a.status.code !=1 ) {
									check();
									return;
								}
			                    that.openid=a.openid;
			                    //that.dia.close();
			                    div.modal('hide');
								that.renderWeiXin();
							},
							error:function(e){
							}
						});
					},2000);
				}	
				check();
			}
		
			this.renderWeiXinUnbind = function(){
				var that = this;
				var data=[];
			    data.openid=this.openid;  
				var template = $("#weixin-unbinding-template").html();
				var el = Mustache.to_html(template,data);
				$("#weixin-row").html(el);
				$("#weixin-row").find('input').trigger('focus');
				$("#weixin-row").find('button').eq(0).bind('click',function() {
					that.weixinUnbind();
				});
				$("#weixin-row").find('button').eq(1).bind('click',function() {
					that.renderWeiXin();
				});
			}
			this.weixinUnbind = function(){
				var that = this;
				if (confirm("您确定要解绑该微信号码吗？解绑后将无法用微信接收DNS盾发送的通知") === false) {
					return;
				}
				$.ajax({
					url:'/api/?c=user&a=unbind',
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							alert(a.status.message);
							return;
						}
						that.openid = '';
						that.renderWeiXin();
					}
				});
			}
			
			this.renderDisturb = function(){
				var that = this;
				if ($("#disturb-row").html()){
					var template = $("#disturb-refesh-template").html();
				}else {
					var template = $("#disturb-show-template").html();
				}
				var el = Mustache.to_html(template);
				if ($("#disturb-row").html()) {
					$("#disturb-row").html(el);
				}else {
					this.tbody.append(el);
				}
				$("#disturb-row").find('a').bind('click',function(){	
						that.renderDisturbEdit();
				});
			}
			
			this.renderDisturbEdit = function(){
				var that = this;
				var template = $("#disturb-edit-template").html();
				var option = [];
				option.flags = this.flags;
				var el = Mustache.to_html(template,option);
				$("#disturb-row").html(el);		
				$("#disturb-row").trigger('focus');	
				$("#disturb-row").find('button').eq(0).bind('click',function(){
					that.disturbEdit();
				});
				$("#disturb-row").find('button').eq(1).bind('click',function(){
					that.renderDisturb();
				});
			}
			this.disturbEdit = function(){
				var that = this;
				var div = $("#disturb-row");
				var flags = div.find('[name=flags]:checked').val();
				$.ajax({
					url:'/api/?c=user&a=flagsEdit',
					dataType:'json',
					data:{flags:flags},
					success:function(a) {
						if (a.status.code != 1) {
							alert(a.status.message);
							return;
						}
						that.flags = flags==0 ? 'yes' : '';
						that.renderDisturb();
					}
				});
			}
		}
		var u = new user();
		u.getInfo();
		curCount=60;//当前剩余秒数
	})
	
	