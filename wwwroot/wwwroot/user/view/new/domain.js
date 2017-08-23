$(document).ready(function() {
		function domain() {
			this.temp = [];
			this.iscdn = 0;
			this.productId = 0;
			//this.buyMonth = 0;
			this.cdnproduct = [];
			this.domainGroupId = 0;
			this.domainlist = [];
			this.userinfo = [];
			this.grouplist = [];
			this.searchlist = [];
			this.message = '';
			this.keyword = '';
			this.group_id = -1;
			this.page = 0;
			this.total = 0;
			this.all_total = 0;
			this.pagecount = 500;
			this._offset = 0;
			this.timeout = null;
			this.multidiv = $("#multi_div");
			this.errordiv = $("#domain_error");
			this.selectarr = [];
			this.addarr = [];
			this.importarr = [];
			this.defaultTtl = 3600;
			this.noTurnMultiMessage = 0;
			this.getInfo = function(gid,iscdn) {
				var that = this;
				openCloseBg('open');
				if (gid != "") {
					this.group_id = gid;
				}
				that.iscdn = iscdn;
				var that = this;
				$.ajax({
					url:'/api/?c=user&a=getInfo',
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.renderLoginError();
							return;
						}
						that.userinfo = a.user;
						that.bindPublicEvent(); 
						that.getDomainList(0);
					},
					error:function(e) {
					}
				});
			}
			this.isGoHome = function(){
				var that = this;
				for ( var i in that.domainlist) {
					if (data[i] ==undefined) {
						continue;
					}
					if (parseInt(data[i]['group_id']) == 0) {
						continue;
					}
					this.renderOne(i);
				}
			}
			this.renderLoginError = function() {
				window.location = '?c=session&a=loginForm';
			}
			this.getDomainList = function(page,group_id) {
				var that = this;
				this.page = (typeof page != 'undefined') ? parseInt(page) : this.page;
				this._offset = this.page==0 ? 0 : (parseInt(this.page))*this.pagecount;
				this.group_id = typeof group_id != 'undefined' ? group_id : this.group_id;
				if (!this.noTurnMultiMessage) {
					this.loading(0);
				}
				$.ajax({
					url : '/api/?c=domain&a=getList',
					data : {group_id:that.group_id,offset:that._offset,length:that.pagecount,keyword:that.keyword},
					dataType : 'json',
					success : function(a) {
						if (parseInt(a.status.code) == 1) {
							that.total = parseInt(a.info.domain_total);
							if (that.all_total==0) {
								that.all_total = that.total;
							}
							if (a.domains !=undefined) {
								that.domainlist = a.domains;
							}
							if(a.cdnproduct != undefined){
								that.cdnproduct = a.cdnproduct;
							}
							that.render(that.domainlist);
							that.getGroupList();
							that.renderPage();
							that.loadComplete();
							that.noTurnMultiMessage = 0;
							openCloseBg('close');
							return;
						} else {
							that.showError(a.status.message);
						}
					},
					error : function(e) {
						that.loadComplete();
						alert("获取数据出错" + e.responseText);
					}
				});
			}
			this.getRow = function(rowkey) {
				return this.domainlist[rowkey];
			}
			this.getRowId = function(rowkey) {
				return 'tr'+rowkey;
			}
			this.delRow = function(rowkey) {
				this.domainlist[rowkey] = undefined;
			}
			this.setRow = function(rowkey,key,value) {
				if (value == undefined) {
					for ( var i in key) {
						this.domainlist[rowkey][i] = key[i];
					}
				}else {
					this.domainlist[rowkey][key] = value;
				}
			}
			this.addRow = function(row){
				if (this.domainlist ==undefined) {
					this.domainlist = [];
				}
				this.domainlist.push(row);
				return this.domainlist.length-1;
			}
			//反排
			this.sortName = function() {
				var that = this;
				this.render(this.domainlist.sort(compareDomain));
			}
			this.sortPname = function() {
				var that = this;
				this.render(this.domainlist.sort(compareDomainPname));
			}
			this.loadComplete = function() {
				if (this.noTurnMultiMessage) {
					return
				}
				this.errordiv.html("");
			}
			this.loading = function(width) {
				this.errordiv.html('<img src="/style/busy.gif">').removeClass('alert alert-success alert-error');
			}
			this.showError = function(message, clear) {
				var that = this;
				this.errordiv.html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass('alert-success').addClass('alert alert-error');
				if (clear) {
					setTimeout(function() {
						that.errordiv.html('').removeClass('alert alert-success alert-error');
					}, 4000);
				}
				this.errordiv.find('a').bind('click',function(){
					that.errordiv.html("").removeClass('alert alert-success alert-error');
				});
			}
			this.showMessage = function(message, clear) {
				var that = this;
				this.errordiv.html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass('alert-error').addClass('alert alert-success');;
				if (clear) {
					setTimeout(function() {
						that.errordiv.html('').removeClass('alert alert-success alert-error');
					}, 4000);
				}
				this.errordiv.find('a').bind('click',function(){
					that.errordiv.html("").removeClass('alert alert-success alert-error');
				});
				that.errordiv.find('#show_multia').bind('click',function(){
					that.showAllMultiMessage();
				});
			}
			this.bindPublicEvent = function() {
				var that = this;
				$("#select_all").bind('click', function() {
					that.selectAll($("#select_all").attr('checked'));
					//console.log(that.domainlist);
				});
				$("#add_domain").bind('click', function() {
					that.piaoAddDomain();
				});
				$("#add_multi_domain").bind('click', function() {
					that.piaoAddMultiDomain();
				});
				//$('.dropdown-toggle').dropdown();
				$("#dropdown_operating").find('#del').bind('click', function() {
					var template = $("#del-domain-modal-template").html();
					$('body').append(template);
					$('#del-domain-modal').modal('show')
					$("#del-domain-modal").find("#enter").unbind();
					$("#del-domain-modal").find("#enter").bind('click',function(){
						$('#del-domain-modal').modal('hide')
						that.piaoDelDomain();
					});
					
				});
				$("#dropdown_operating").find('#restor').bind('click', function() {
					that.piaoRestorDomain();
				});
				$("#dropdown_operating").find('#stop').bind('click', function() {
					that.piaoStopDomain();
				});
				$("#dropdown_operating").find("#cdn").bind('click',function(){
					that.domainMultiBuyCdn();
				});
				$("#dropdown_operating").find("#del_cdn").bind('click',function(){
					that.selectDelCdn();
				});
				$("#dropdown_multi_operating").find('#edit').bind('click', function() {
					that.piaoEditMultiRecord();
				});
				$("#dropdown_multi_operating").find('#add').bind('click', function() {
					that.piaoAddMultiRecord();
				});
				$("#dropdown_multi_operating").find('#import').bind('click', function() {
					that.piaoImportMultiRecord();
				});
				$("#form-search").find('#search-query').bind('keypress', function(e) {
					var keycode;
					if(window.event){
						keycode = e.keyCode; //IE
					}
					else if(e.which){
						keycode = e.which;
					}
					if (keycode != 13) {
						return;
					}
					that.search();
					e.stopPropagation();
					return false;
				});
				$("#domain_error_span").bind('click',function(){
					that.closeError();
				});
				$("#dropdown_group").find('#create').bind('click',function(){
					that.piaoAddGroup();
				});
				$("#domain-list").find("#name-sort").bind('click',function(){
					that.sortName();
				});
				$("#domain-list").find("#pname-sort").bind('click',function(){
					that.sortPname();
				});
			}
			this.domainMultiBuyCdn = function(){
				var that = this;
				that.selectarr.length = 0;
				for(var i in that.domainlist){
					if(that.domainlist[i] == undefined){
						continue;
					}
					if(that.domainlist[i]['sitestatus'] == 0 || that.domainlist[i]['sitestatus'] == 1 ||  that.domainlist[i]['sitestatus']  >2){
						continue;
					}
					if(that.domainlist[i]['checked'] == undefined || that.domainlist[i]['checked'] == ""){
						continue;
					}
					/*
					if(that.domainlist[i]['cdn_expire_time'] < 0){
						continue;
					}
					*/
					that.selectarr.push(i);
				}
				if(that.selectarr.length == 0){
					that.showError('请选择域名',true);
					return;
				}
				$.ajax({
					//url:'?c=cdn&a=getCdnProductList',
					url:'/api/?c=cdn&a=getCdnProductList',
					data:{uid:that.userinfo['id'],domain:that.domainlist[that.selectarr[0]]['domain']},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							return;
						}
						that.cdnProductSelect(a.ret,'multi');
					},
					error:function(a){
						alert('error');
					}
				});
			}
			this.filterMultiDomainBuyCdnData = function(){
				var that = this;
				that.selectarr.length = 0;
				for(var i in that.domainlist){
					if(that.domainlist[i] == undefined){
						continue;
					}
					if(that.domainlist[i]['sitestatus'] == 0 || that.domainlist[i]['sitestatus'] == 1 || that.domainlist[i]['sitestatus'] > 2){
						continue;
					}
					if(that.domainlist[i]['checked'] == undefined || that.domainlist[i]['checked'] == ""){
						continue;
					}
					that.selectarr.push(i);
				}
				this.multidiv.find("#enter").button('loading').attr('disabled','disabled');
				this.multidiv.find("#esc").attr('disabled','disabled');
				that.productId = that.multidiv.find("[name=product]").val();
				that.multiresult.empty();
				that.deferredMultiDomainAddCdnSite(0);
			}
			this.deferredMultiDomainAddCdnSite = function(key){
				var that = this;
				if(key == that.selectarr.length){
					that.showMultiResult();
					return;
				}
				that.multiAddCdnSite(key,true);
			}
			this.multiAddCdnSite = function(key,multi){
				var that = this;
				var domain = that.domainlist[that.selectarr[key]]['name'];
				$.ajax({
					url:'/api/?c=cdn&a=buyCdnProduct',
					type:'POST',
					data:{domain:domain,productId:that.productId},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.multiresult.error.push(domain+"--"+a.ret);
							that.deferredMultiDomainAddCdnSite(key+1);
							return;
						}
						if(multi){
							that.multiresult.success.push(domain+'--'+"增加cdn站点成功");
							that.domainlist[that.selectarr[key]]['checked'] = "";
							that.domainlist[that.selectarr[key]]['sitestatus'] = a.ret;
							that.renderOne(that.selectarr[key]);
							that.deferredMultiDomainAddCdnSite(key+1);
						}
					},
					error:function(a){
						that.multiresult.error.push(domain+"--增加cdn站点失败网络异常");
						that.deferredMultiDomainAddCdnSite(key+1);
						return;
					}
				});
			}
			this.render = function(data) {
				var that = this;
				$("table").find('tbody').html("");
				data = data.sort(compareMark);
				for ( var i in data) {
					if (data[i] ==undefined) {
						continue;
					}
					if (that.group_id != -1 && parseInt(data[i]['group_id']) != that.group_id) {
						continue;
					}
					this.renderOne(i);
				}
			}
			this.selectAll = function(checked,norender) {
				if (this.searchlist.length > 0) {
					for ( var i in this.searchlist) {
						var row = this.getRow(this.searchlist[i]);
						if (row == undefined) {
							continue;
						}
						if (row['ext_status']=='' || row['ext_status']!='') {
							continue;
						}
						row['checked'] = checked;
					}
					this.renderSearch(this.searchlist);
					return;
				}
				for ( var i in this.domainlist) {
					if (this.domainlist[i]==undefined) {
						continue;
					}
					if (this.domainlist[i]['hold']) {
						continue;
					}
					this.domainlist[i]['checked'] = checked;
				}
				if (norender) {
					return;
				}
				this.render(this.domainlist);
			}
			this.renderOne = function(rowkey) {
				var that = this;
				var row = this.getRow(rowkey);
				row['groupid'] = this.group_id;
			
				if (parseInt(row['pid_expire_time'])==0||!row['pid_expire_time']) {//当domain_free_day为0，后台返回row['pid_expire_time']为null
					row['pid_expire_time'] = "";
				}
				row.domainname = row['name'] ? row['name'] : row['domain'];
				var divid = this.getRowId(rowkey);
				row.divid = divid;
				if (!row['ext_status']) {
					if (row['status']=='enable') {
						row.status_message = '<i class="icon-ok" title="域名正常"></i>';
					}else {
						row.status_message = "<i class='icon-pause' title='域名被暂停'></i>";
					}
				}else {
					if(row.pid ==0){
						row.trclass = 'class="back-gray"';
					}
					var msg = '';
					var tclass="icon-off";
					switch (row['ext_status']) {
						case 'adminlock':
							tclass="icon-lock";
							msg = '域名已过期';
							break;
						case 'movecited':
							tclass="icon-lock";
							msg = '域名迁引中';
							break;
						case 'expire':
							tclass="icon-lock";
							msg = '域名已过期';
							break;
						case 'setflags':
							msg = '<i class="icon-ok" title="域名正常"></i>';
							break;
						default:
							msg = '域名dns还未修改';
							break;
					}
					row.status_message = msg;
				}
				
				if ($("#"+divid).html()) {
					var template = $("#domain-row-refresh-template").html();
				}else {
					var template = $("#domain-row-template").html();
				}
				if (row['group_id'] > 0) {
					row['is_group'] = 'yes';
					row['group_name'] = this.getGroupname(row['group_id']);
				}else {
					row['is_group'] = '';
				}
				if(that.iscdn == 1){
					row['iscdn'] = that.iscdn;
				}else{
					row['iscdn'] = "";
				}
				row.domainaudit = '';
				if (row.server == '0.aegins') {
					row.domainaudit = 'yes';
					row.status_message = "域名审核中";
				}
				var rowhtml = Mustache.to_html(template, row);
				if ($("#"+divid).html()) {
					$("#"+divid).html(rowhtml);
				}else {
					if ($("table").find('tbody').find('tr').length > 0) {
						$("table").find('tbody').find('tr').eq(0).before(rowhtml);
					}else {
						$("table").find('tbody').append(rowhtml);
					}
				}
				var rowdiv = $("#" + divid);
				rowdiv.find("#remark").bind({
					'click':function() {that.piaoRemark(rowkey);},
					'mouseover':function() {$(this).tooltip('show');}
				});
				rowdiv.find(':checkbox').bind('click', function() {
					that.selectOne(rowkey);
				});
				if (row['pid'] > 0) {
					rowdiv.find('#shopping').remove();
					var date=new Date();
		            var nowTime = date.getTime();
		            var pidTime = Date.parse(row['pid_expire_time'].replace(/-/g,"/"));
		          
		            var timeSpan = 168*3600*1000;
					if (nowTime- pidTime < timeSpan ) {
						rowdiv.find("#pid").addClass('font-green');
					}else {
						rowdiv.find("#pid").addClass('font-red').attr('title','套餐即将到期');
					}
				}else {
					rowdiv.find('#upgrade').remove();
					rowdiv.find('#renew').remove();
				}
				if(row['ext_status'] != "expire"){
					rowdiv.find("#free").remove();
				}else{
					if(row['pid'] == 0){
						rowdiv.find("#free").remove();
						rowdiv.find("#renew").remove();
					}
					rowdiv.find("#free").bind({
						'click':function(){that.piaoChangeFree(rowkey);},
						'mouseover':function() {$(this).tooltip('show');}});
				}
				if (row['status']=='enable') {
					rowdiv.find("#stop").remove();
					rowdiv.find("#restor").bind({
						'click':function(){that.stopDomain(rowkey);},
						'mouseover':function() {$(this).tooltip('show');}
					});
				}else {
					rowdiv.find("#restor").remove();
					rowdiv.find("#stop").bind({
						'click':function(){	
							that.restorDomain(rowkey);
						},
						'mouseover':function() {$(this).tooltip('show');}
					});
				}
				//cdn 操作
				if(row['sitestatus'] == 2){
					rowdiv.find("#cdn_td").find("span").not('#sitestatus').remove();
					rowdiv.find("#sitestatus").bind({
						'click':function(){
							//that.addCdnSite(rowkey);
							that.singleDomainBuyCdn(rowkey);
						},
						'mouseover':function(){$(this).tooltip('show')}
					});
				}
				if(row['sitestatus'] == 0){
					rowdiv.find("#cdn_td").find("span").not('#sitestatus0').remove();
					rowdiv.find("#sitestatus0").bind({
						'click':function(){},
						'mouseover':function(){$(this).tooltip('show')}
					});
				}
				if(row['sitestatus'] == 1){
					rowdiv.find("#cdn_td").find("span").not('#siteexpiretip').remove();
					rowdiv.find("#siteexpiretip").bind({
						'click':function(){},
						'mouseover':function(){$(this).tooltip('show')}
					});
				}
				if(row['sitestatus'] >2){
					rowdiv.find("#cdn_td").find("span").not('#sitestatus3').remove();
					rowdiv.find("#sitestatus3").bind({
						'click':function(){},
						'mouseover':function(){
							rowdiv.find("#sitestatus3").attr("data-original-title","CDN站点审核不通过:"+row['siteremark']);
							$(this).tooltip('show')
						}
					});
				}
				rowdiv.find('#shopping,#upgrade,#renew,#mark').bind({
					'mouseover':function() {$(this).tooltip('show');}
				});
				rowdiv.find('#mark').bind('click',function(){
					that.mark(rowkey);
				});
				rowdiv.find('#is_group').bind({
					'mouseover':function() {$(this).tooltip('show');}
				});
			}
			this.piaoChangeFree = function(rowkey) {
				var that = this;
				var row = that.getRow(rowkey);
				var template = $("#domain-change-free-template").html();
				var el = Mustache.to_html(template,row);
				var div = $("#"+this.getRowId(rowkey));
				div.html(el);
				div.find("#esc").bind('click',function(){
					that.renderOne(rowkey);
				});
				div.find("#enter").bind('click',function(){
					that.domainChangeFree(rowkey);
				});
			}
			this.mark = function(rowkey) {
				var that = this;
				var row = this.getRow(rowkey);
				var is_mark = row['is_mark'] ? '' : 'yes';
				$.ajax({
					url:'/api/?c=domain&a=mark',
					data:{domain:row['name'],is_mark:is_mark},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.setRow(rowkey,'is_mark',is_mark);
						that.renderOne(rowkey);
						that.showMessage(a.status.message, true);
					},
					error:function(e) {
						
					}
				});
			}
			this.selectOne = function(rowkey) {
				var divid = this.getRowId(rowkey);
				var checked = $("#" + divid).find(':checkbox').attr('checked');
				if (checked) {
					checked = 'checked';
				} else {
					checked = "";
				}
				this.setRow(rowkey, 'checked', checked);
				this.renderOne(rowkey);
			}
			this.piaoRemark = function(rowkey) {
				var that = this;
				var row = this.getRow(rowkey);
				var divid = this.getRowId(rowkey);
				var template = $("#domain-row-remark-template").html();
				var el = Mustache.to_html(template, row);
				$("#"+divid).html(el);
				$("#"+divid).find("#esc").bind('click', function() {
					that.renderOne(rowkey);
				});
				$("#"+divid).find("#enter").bind('click', function() {
					that.remark(rowkey);
				});
				$("#"+divid).find('[name=remark]').trigger('focus');
			}
			this.remarkAfter = function(rowkey, remark) {
				this.setRow(rowkey,'remark',remark);
				this.renderOne(rowkey);
			}
			this.remark = function(rowkey) {
				var that = this;
				var divid = this.getRowId(rowkey);
				var row = this.getRow(rowkey);
				var newremark = $("#"+divid).find('[name=remark]').val();
				$.ajax({
					url : '/api/?c=domain&a=remark',
					data : {
						domain : row['name'],
						remark : newremark
					},
					dataType : 'json',
					success : function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return;
						}
						that.remarkAfter(rowkey, newremark);
						that.showMessage(a.status.message, true);
					},
					error : function(e) {
						that.showError("数据出错");
					}
				});
			}
			this.piaoDelDomain = function() {
				var that = this;
				this.multiresult.empty();
				var selectdomain = [];
				for ( var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['checked']) {
						selectdomain.push(i);
					}
				}
				if (selectdomain.length < 1) {
					that.showError("没有选中域名", true);
					return;
				}
				this.selectarr.length = 0;
				this.selectarr = selectdomain;
				openCloseBg('open');
				this.deferredDelDomain(0);
			}
			this.deferredDelDomain  = function(selectkey,complete) {
				if (this.selectarr.length == selectkey || complete) {
					openCloseBg('close');
					this.showMultiResult();
					return ;
				}
				this.delDomain(selectkey,true);
			}
			this.delDomain = function(key,multi) {
				var that = this;
				var rowkey = key;
				if (multi) {
					rowkey = this.selectarr[key];
				}
				var row = this.getRow(rowkey);
				if (row==undefined) {
					if (multi) {
						that.deferredDelDomain(key+1);
					}
					return;
				}
				$.ajax({
					url : '/api/?c=domain&a=domainDel',
					type:'POST',
					data : {
						domain : row['name']
					},
					dataType : "json",
					async : true,
					success : function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							if (multi) {
								that.multiresult.error.push(row['name'] + ':' + a.status.message);
							}
							
						}else {
							if (!multi) {
								that.showMessage(a.status.message,true);
							}else {
								that.multiresult.success.push(row['name'] + ':' + a.status.message);
							}
							that.removeDomain(rowkey);
						}
						that.deferredDelDomain(key+1);
					},
					error : function(e) {
						that.deferredDelDomain(key+1);
						//that.showError("数据出错");
					}
				});
			}
			this.removeDomain = function(rowkey) {
				//域名删除成功后，从当前的domainlist里面删除这条域名，防止重新render的时候又显示出来了。
				var divid = this.getRowId(rowkey)
				//从tbody里面删除显示
				$("#" + divid).remove();
				var row = this.getRow(rowkey);
				var gid = parseInt(row['group_id']);
				this.delRow(rowkey);
				this.total -=1;
				this.all_total -=1;
				this.setGroupRowByGroupid(-1, 'size', '-1');
				if (gid <= 0) {
					this.setGroupRowByGroupid(0, 'size', '-1');
				}else {
					this.setGroupRowByGroupid(gid, 'size', '-1');
				}
				this.renderGroup();
			}
			this.piaoStopDomain = function() {
				this.showLog('stop domain');
				var that = this;
				this.multiresult.empty();
				var select = [];
				var status = 'disable';
				for ( var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['checked'] && this.domainlist[i]['status'] != status) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					that.showError("没有选中域名或选中的域名已暂停", true);
					return;
				}
				this.selectarr.length = 0;
				this.selectarr = select;
				this.deferredStopDomain(0);
			}
			this.deferredStopDomain = function(selectkey,complete) {
				if (this.selectarr.length == selectkey || complete) {
					this.showMultiResult();
					return false;
				} 
				this.stopDomain(selectkey,true);
			}
			this.stopDomain = function(key,multi) {
				var that = this;
				var rowkey = key;
				if (multi) {
					rowkey = this.selectarr[key];
				}
				var row = this.getRow(rowkey);
				if (row==undefined) {
					if (multi) {
						that.deferredStopDomain(key+1);
					}
					return;
				}
				var status = 'disable';
				$.ajax({
					url : "/api/?c=domain&a=changeStatus",
					type:'POST',
					data : {domain : row['name'],status : status},
					dataType : 'json',
					async : true,
					success : function(a) {
						if (a.status.code != 1) {
							if (multi) {
								that.multiresult.error.push(row['name'] + ':' + a.status.message);
								that.deferredStopDomain(key+1);
							}else {
								that.showError(a.status.message);
							}
						}else {
							if (multi) {
								that.multiresult.success.push(row['name'] + ':' + a.status.message);
								that.deferredStopDomain(key+1);
							}else {
								that.showMessage(a.status.message,true);
							}
							that.changeStatus(rowkey, status);
						}
					},
					error : function(e) {
						if (multi) {
							that.deferredStopDomain(key+1);
						}else {
							that.showError("数据出错");
						}
					}
				});
			}
			this.changeStatus = function(rowkey, status) {
				this.setRow(rowkey,'status',status);
				this.renderOne(rowkey);
			}
			this.piaoRestorDomain = function() {
				var that = this;
				this.multiresult.empty();
				var select = [];
				var status = 'enable';
				for ( var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['checked'] && this.domainlist[i]['status'] != status) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					that.showError("没有选中域名或选中的域名已恢复", true);
					return;
				}
				this.selectarr.length = 0;
				this.selectarr = select;
				this.deferredRestorDomain(0);
			}
			this.deferredRestorDomain = function(selectkey,complete){
				if (this.selectarr.length == selectkey || complete) {
					this.showMultiResult();
					return;
				} 
				this.restorDomain(selectkey,true);
			}
			this.restorDomain = function(key,multi) {
				var that = this;
				var rowkey = key;
				if (multi) {
					rowkey = this.selectarr[key];
				}
				var row = this.getRow(rowkey);
				if (row==undefined) {
					if (multi) {
						that.deferredRestorDomain(key+1);
					}
					return;
				}
				var status = 'enable';
				$.ajax({
					url : '/api/?c=domain&a=changeStatus',
					type:'POST',
					data : {
						domain : row['name'],
						status : status
					},
					dataType : 'json',
					async : true,
					success : function(a) {
						if (a.status.code != 1) {
							if (multi) {
								that.multiresult.error.push(row['name'] + ':' + a.status.message);
								that.deferredRestorDomain(key+1);
							}else {
								that.showError(a.status.message);
							}
						}else {
							that.changeStatus(rowkey, status);
							if (multi) {
								that.multiresult.success.push(row['name'] + ':' + a.status.message);
								that.deferredRestorDomain(key+1);
							}else {
								that.showMessage(a.status.message,true);
							}
						}
						
					},
					error : function(e) {
						if (multi) {
							that.deferredRestorDomain(key+1);
						}else {
						   that.showError("数据出错");
						}
					}
				});
			}
			this.piaoAddDomain = function() {
				var that = this;
				var template = $("#domain-add-template").html();
				var el = Mustache.to_html(template);
				if ($("table").find('tbody').find('tr').length==0) {
					$("table").find('tbody').append(el);
				}else {
					$("table").find('tbody').find('tr').eq(0).before(el);
				}
				$("#domain_add_row").find('button').eq(0).bind('click', function() {
					var domainname = $("#domain_add_row").find('[name=domainname]').val();
					that.addDomain(domainname);
				});
				$("#domain_add_row").bind('keyup',function(event){
					var keycode = event.which;
					if (keycode == 13) {
						var domainname = $("#domain_add_row").find('[name=domainname]').val();
						that.addDomain(domainname);
					}
				});
				$("#domain_add_row").find('button').eq(1).bind('click', function() {
					$("#domain_add_row").remove();
				});
				$("#domain_add_row").find('[name=domainname]').trigger('focus');
			}
			this.addDomain = function(domain,multi) {
				//往后台发送增加的api
				var that = this;
				if (multi) {
					var addkey = domain;
					var domain = this.addarr[addkey];
				}
				$("#domain_add_row").remove();
				$.ajax({
					url : '/api/?c=domain&a=domainAdd',
					type:'POST',
					data : {
						domain : domain,
						group_id:that.group_id
					},
					dataType : 'json',
					async : true,
					success : function(a) {
						if (a.status.code != 1) {
							if (multi) {
								that.temp.push(a.domain);
								that.multiresult.error.push(a.ret);
								that.deferredAddMultiDomain(addkey+1);
							}else {
								that.showError(a.status.message);
							}
						}else {
							that.insertDomain(a.ret,a.domain);
							if (multi) {
								that.multiresult.success.push(a.ret + ':'+a.status.message);
								that.deferredAddMultiDomain(addkey+1);
							}else {
								that.showMessage(a.status.message, true);
							}
						}
						
					},
					error : function(e) {
						that.deferredAddMultiDomain(addkey+1);
						//that.showError('数据出错');
					}
				});
			}
			this.insertDomain = function(domain,flags) {
				//增加域名后，需要往domainlist里面添加进去，否则重新render的时候会不显示
				var row = [];
				row=flags;
				row.name = domain;
				row.pname = "未购买";
				row.status = 'enable';
				row.sitestatus = 2;  // 添加域名 没有向cdn添加站点
				//刚添加的域名dns都设为未接入
				if(flags['flags']){
					row.ext_status = 'setflags';
				}else{
					row.ext_status = 'dnserror';
				}
				var rowkey = this.addRow(row);
				this.renderOne(rowkey);
				this.total += 1;
				this.all_total += 1;
				this.setGroupRowByGroupid(0, 'size', '+1');
				if (this.group_id != 0) {
					this.setGroupRowByGroupid(this.group_id, 'size', '+1');
				}
				this.renderGroup();
			}
			this.piaoAddMultiDomain = function() {
				var that = this;
				if (that.multidiv.html()) {
					return;
				}
				var that = this;
				var template = $("#domain-add-multi-template").html();
				var option = [];
				//option.placeholder = window.location.host;
				if (window.location.host.match(/./g).length > 1) {
					//判断是否为IP还是域名
					var ip = function(str){
						if (/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/.test(str)){
							return true;
						}
						return false;
					}(window.location.host)
					if (ip) {
						option.placeholder = "dnsdun.com";
					}else{
						//当为二级域名转换成主域名
						option.placeholder = window.location.host.substr(window.location.host.indexOf('.')+1);
					}
					
				}
				var el = Mustache.to_html(template,option);
				that.multidiv.html(el).show();
				this.multidiv.find("#enter").bind('click', function() {
					that.addMultiDomain();
				});
				this.multidiv.find("#sec").bind('click', function() {
					that.secMulti();
				});
			}
			//取消批量添加域名
			this.secMulti = function() {
				var that = this;
				that.multidiv.html("").hide();
			}
			this.addMultiDomain = function() {
				var that = this;
				this.multiresult.empty();
				var domains_string = $("#domain-add-multi").find('[name=add_domains]').val();
				if (!domains_string) {
					this.showError('域名不能为空',true);
					return;
				}
				var rows = domains_string.split("\n");
				for ( var i in rows) {
					if (rows[i].trim() =='') {
						break;
					}
					this.addarr.push(rows[i]);
				}
				if (this.addarr.length < 1) {
					this.showError('域名不能为空',true);
					return;
				}
				this.multidiv.find("#enter").button('loading').attr('disabled','disabled');
				openCloseBg('open');
				this.deferredAddMultiDomain(0);
			}
			this.deferredAddMultiDomain = function(selectkey) {
				if (this.addarr.length == selectkey) {
					openCloseBg('close');
					this.addarr.length = 0;
					this.showMultiResult();
					return;
				}
				this.addDomain(selectkey,true);
			}
			this.piaoEditMultiRecord = function() {
				var that = this;
				var select = [];
				for (var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					this.showError("请先选中域名.",true);
					return ;
				}
				this.selectarr = select;
				var template = $("#domain-edit-multi-record-template").html();
				var el = Mustache.to_html(template);
				that.multidiv.html(el).show();
				that.multidiv.find('#enter').bind('click', function() {
					that.editMultiRecord();
				});
				that.multidiv.find('#esc').bind('click', function() {
					that.secMulti();
				});
				that.multidiv.find("#del").bind('click',function(){
					that.multidiv.find("#newvalue_param").hide();
				});
				that.multidiv.find("#stop").bind('click',function(){
					that.multidiv.find("#newvalue_param").hide();
				});
				that.multidiv.find("#restor").bind('click',function(){
					that.multidiv.find("#newvalue_param").hide();
				});
				that.multidiv.find("#cdn_up").bind('click',function(){
					that.multidiv.find("#newvalue_param").hide();
				});
				that.multidiv.find("#cdn_down").bind('click',function(){
					that.multidiv.find("#newvalue_param").hide();
				});
				that.multidiv.find("#edit").bind('click',function(){
					that.multidiv.find("#newvalue_param").show();
				});
			}
			this.editMultiRecord = function() {
				var that = this;
				var hostName = that.multidiv.find('[name=hostName]').val();
				var analysisValue = that.multidiv.find('[name=analysisValue]').val();
				this.multidiv.find("#enter").button('loading').attr('disabled','disabled');
				var action = that.multidiv.find('[name=operating]:checked').val();
				if (action == 'del') {
					this.delMultiRecord(hostName,analysisValue);
					return ;
				}
				if (action == 'stop') {
					this.stopMultiRecord(hostName,analysisValue);
					return ;
				}
				if (action == 'restor') {
					this.restorMultiRecord(hostName,analysisValue);
					return ;
				}
				if(action == 'cdn_up'){
					this.changeCdnMultiRecord(1,hostName,analysisValue);
					return;
				}
				if(action == 'cdn_down'){
					this.changeCdnMultiRecord(0, hostName, analysisValue);
					return;
				}
				this.multiresult.empty();
				var newvalue = that.multidiv.find('[name=edit_record_newvalue]').val();
				var newttl = that.multidiv.find('[name=edit_record_newttl]').val();
				var newtype = that.multidiv.find('[name=edit_record_newtype]').val();
				if(hostName == "" && analysisValue == ""){
					this.showError("主机名和解析值最少一个不能为空",true);
					return;
				}
				if (!newvalue && !newttl && !newtype) {
					this.showError("必需要有一个修改的选项",true);
					return ;
				}
				this.deferredEditMultiRecord(0,hostName,analysisValue,newvalue,newttl,newtype);
			}
			this.changeCdnMultiRecord = function(cdn,hostName,analysisValue){
				var that = this;
				if(hostName == "" && analysisValue == ""){
					that.showError('主机名或解析值不能为空',true);
					return ;
				}
				that.selectarr.length = 0;
				for(var i in that.domainlist){
					if(that.domainlist[i] == undefined){
						continue;
					}
					if(that.domainlist[i]['checked'] == "" || that.domainlist[i]['checked'] == undefined){
						continue;
					}
					if(that.domainlist[i]['sitestatus'] == 0 || that.domainlist[i]['sitestatus'] > 2){
						continue;
					}
					that.selectarr.push(i);
				}
				if(that.selectarr.length == 0){
					that.showError('请选择域名',true);
					return;
				}
				that.deferredChangeCdnMultiRecord(0,cdn,hostName,analysisValue);
			}
			this.deferredChangeCdnMultiRecord = function(key,cdn,hostName,analysisValue){
				var that = this;
				if(key == that.selectarr.length){
					that.showMultiResult();
					return;
				}
				that.changeCdnRecord(key,cdn,hostName,analysisValue);
			}
			this.changeCdnRecord = function(key,cdn,hostName,analysisValue){
				var that = this;
				var domainKey = that.selectarr[key];
				var domainName = that.domainlist[domainKey]['name'];
				$.ajax({
					url:'/api/?c=domain&a=changeCdnRecord',
					type:'POST',
					data:{domain:domainName,cdn:cdn,hostName:hostName,analysisValue:analysisValue},
					dataType:'json',
					success:function(a){
						if(a.status.code == 2){
							that.multiresult.error.push("域名:"+domainName+a.status.message);
							that.deferredChangeCdnMultiRecord(key+1, cdn, hostName, analysisValue);
							return;
						}
						that.multiresult.success.push("域名:"+domainName+"总记录数:"+a.count+"成功:"+a.successcount+"失败:"+a.errorcount);
						that.deferredChangeCdnMultiRecord(key+1, cdn, hostName, analysisValue);
					},
					error:function(a){
						that.deferredChangeCdnMultiRecord(key+1, cdn, hostName, analysisValue);
					}
				});
			}
			this.deferredEditMultiRecord = function(selectkey,hostName,analysisValue,newvalue,newttl,newtype) {
				if (this.selectarr.length ==selectkey) {
					this.showMultiResult();
					return ;
				}
				this.editOneRecord(selectkey,hostName,analysisValue,newvalue,newttl,newtype);
			}
			this.editOneRecord = function(key,hostName,analysisValue,newvalue,newttl,newtype) {
				var that = this;
				var row = this.getRow(this.selectarr[key]);
				newvalue = that.checkValue(newtype,newvalue);
				var domain = row['name'];
				$.ajax({
					url:'/api/?c=domain&a=editRecord',
					data:{domain:domain,hostName:hostName,analysisValue:analysisValue,newvalue:newvalue,newttl:newttl,newtype:newtype},
					dataType:'json',
					async:true,
					success:function(a) {
						switch (a.status.code) {
						case 2:
							that.multiresult.error.push(domain + a.status.message);
							break;
						case 1:
						case '1':
							var msg = domain + '修改解析成功,总记录数:'+a.count+',成功记录数:'+a.successcount+"<br>";
							if (a.errorcount >0) {
								msg += '失败记录数:'+a.errorcount;
							}
							that.multiresult.success.push(msg);
							break;
						default:
							that.multiresult.error.push(domain + '修改解析失败,错误信息:'+a.status.message);
							break;
						}
						that.deferredEditMultiRecord(key+1,hostName,analysisValue,newvalue,newttl,newtype) ;
					},
					error:function(e) {
						that.deferredEditMultiRecord(key+1,hostName,analysisValue,newvalue,newttl,newtype) ;
					}
				});
			}
			this.delMultiRecord = function(hostName,analysisValue) {
				this.multiresult.empty();
				this.deferredDelMultiRecord(0,hostName,analysisValue);
			}
			this.deferredDelMultiRecord = function(selectkey,hostName,analysisValue) {
				if (this.selectarr.length ==selectkey) {
					this.showMultiResult();
					return ;
				}
				this.delOneRecord(selectkey,hostName,analysisValue);
			}
			this.delOneRecord = function(key,hostName,analysisValue) {
				var that = this;
				var row = this.getRow(this.selectarr[key]);
				$.ajax({
					url:'/api/?c=domain&a=delRecord',
					data:{domain:row['name'],hostName:hostName,analysisValue:analysisValue},
					dataType:'json',
					async:true,
					success:function(a) {
						switch (a.status.code) {
						case 2:
							that.multiresult.error.push(row['name'] + a.status.message);
							break;
						case 1:
						case '1':
							var msg = row['name'] + ' 删除解析成功,总记录数:'+a.count+',成功记录数:'+a.successcount;
							if (a.errorcount >0) {
								msg += '失败记录数:'+a.errorcount;
							}
							that.multiresult.success.push(msg);
							break;
						default:
							that.multiresult.error.push(row['name'] + '删除解析失败,错误信息:'+a.status.message);
							break;
						}
						that.deferredDelMultiRecord(key+1,hostName,analysisValue);
					},
					error:function(e) {
						that.deferredDelMultiRecord(key+1,hostName,analysisValue);
					}
				});
			}
			this.stopMultiRecord = function(hostName,analysisValue) {
				this.multiresult.empty();
				this.deferredStopMultiRecord(0,hostName,analysisValue);
			}
			this.deferredStopMultiRecord = function(selectkey,hostName,analysisValue){
				if (this.selectarr.length ==selectkey) {
					this.showMultiResult();
					return ;
				}
				this.stopOneRecord(selectkey,hostName,analysisValue);
			}
			this.stopOneRecord = function(key,hostName,analysisValue) {
				var that = this;
				var row = this.getRow(this.selectarr[key]);
				var domain = row['name'];
				$.ajax({
					url:'/api/?c=domain&a=changeRecordStatus',
					data:{domain:domain,hostName:hostName,analysisValue:analysisValue,status:1},
					dataType:'json',
					async:true,
					success:function(a) {
						switch (a.status.code) {
						case 2:
							that.multiresult.error.push( domain + a.status.message);
							break;
						case 1:
						case '1':
							var msg = domain + '暂停解析成功<br>总记录数:'+a.count+',成功记录数:'+a.successcount+"<br>";
							if (a.errorcount >0) {
								msg += '失败记录数:'+a.errorcount;
							}
							that.multiresult.success.push(msg);
							break;
						default:
							that.multiresult.error.push(  domain + '暂停解析失败,错误信息:'+a.status.message);
							break;
						}
						that.deferredStopMultiRecord(key+1,hostName,analysisValue);
					},
					error:function(e) {
						that.deferredStopMultiRecord(key+1,hostName,analysisValue);
					}
				});
			}
			this.restorMultiRecord = function(hostName,analysisValue) {
				this.multiresult.empty();
				this.deferredRestorMultiRecord(0,hostName,analysisValue);
			}
			this.deferredRestorMultiRecord = function(selectkey,hostName,analysisValue){
				if (this.selectarr.length ==selectkey) {
					this.showMultiResult();
					return ;
				}
				this.restorOneRecord(selectkey,hostName,analysisValue);
			}
			this.restorOneRecord = function(key,hostName,analysisValue) {
				var that = this;
				var row = this.getRow(this.selectarr[key]);
				var domain = row['name'];
				$.ajax({
					url:'/api/?c=domain&a=changeRecordStatus',
					data:{domain:domain,hostName:hostName,analysisValue:analysisValue,status:0},
					dataType:'json',
					async:true,
					success:function(a) {
						switch (a.status.code) {
						case 2:
							that.multiresult.error.push( domain + a.status.message);
							break;
						case 1:
						case '1':
							var msg =  domain + '恢复解析成功<br>总记录数:'+a.count+',成功记录数:'+a.successcount+"<br>"
							if (a.errorcount >0) {
								msg += '失败记录数:'+a.errorcount+'';
							}
							that.multiresult.success.push(msg);
							break;
						default:
							that.multiresult.error.push(  domain + '恢复解析失败,错误信息:'+a.status.message);
							break;
						}
						that.deferredRestorMultiRecord(key+1,hostName,analysisValue);
					},
					error:function(e) {
						that.deferredRestorMultiRecord(key+1,hostName,analysisValue);
					}
				});
			}
			this.getTypeHtml = function() {
				var html = '' ;
				html += '<p>类型：</p><select name="add_multi_record_type">';
				html += '<option value="A">A</option>';
				html += '<option value="AAAA">AAAA</option>';
				html += '<option value="CNAME">CNAME</option>';
				html += '<option value="DNAME">DNAME</option>';
				html += '<option value="MX">MX</option>';
				html += '<option value="NS">NS</option>';
				html += '<option value="TXT">TXT</option>';
				html += '<option value="SRV">SRV</option>';
				html += '<option value="URL">URL</option>';
				html += '</select>';
				return html;
			}
			this.getLineHtml = function(domid) {
				var html = '';
				html += '<p>线路：</p><input name="add_multi_record_line" value="默认" type="text" class="paynum" style="width:400px; height:33px;border:1px solid #e6e6e6; padding-left:10px;">';
				/*
				html += '线&nbsp;&nbsp;&nbsp;路:<select name="add_multi_record_line">';
				html += '<option value="默认">默认</option>';
				html += '<option value="电信">电信</option>';
				html += '<option value="网通">网通</option>';
				html += '<option value="移动">移动</option>';
				html += '<option value="搜索引擎">搜索引擎</option>';
				//TODO::添加第一个域名自定义的线路				
				html += '</select>';
				*/
				return html;
			}
			this.piaoAddMultiRecord = function() {
				var that = this;
				var select = [];
				for (var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					this.showError('请先选中域名.',true);
					return ;
				}
				this.selectarr = select;
				var el = Mustache.to_html($("#domain-add-multi-record-template").html());
				that.multidiv.html(el).show();
				that.multidiv.find('#record_type').html(this.getTypeHtml());
				that.multidiv.find('#record_line').html(this.getLineHtml());
				that.multidiv.find('button').eq(1).bind('click', function() {
					openCloseBg('open');
					that.addMultiRecord();
				});
				that.multidiv.find('button').eq(0).bind('click', function() {
					that.secMulti();
				});
			}
			this.addMultiRecord = function() {
				var that = this;
				this.multiresult.empty();
				var type = that.multidiv.find('[name=add_multi_record_type]').val();
				var line = that.multidiv.find('[name=add_multi_record_line]').val();
				var ttl = parseInt(that.multidiv.find('[name=add_multi_record_ttl]').val()) || that.defaultTtl;
				var sub_domain = that.multidiv.find('[name=add_multi_record_subdomain]').val();
				var value = $.trim(that.multidiv.find('[name=add_multi_record_value]').val());
				if (!value) {
					this.showError('记录值不能为空',true);
					return ;
				}
				this.multidiv.find("#enter").button('loading').attr('disabled','disabled');
				this.deferredAddMultiRecord(0,sub_domain,ttl,type,line,value);
			}
			this.deferredAddMultiRecord = function(selectkey,sub_domain,ttl,type,line,value) {
				if (this.selectarr.length == selectkey) {
					openCloseBg('close');
					this.showMultiResult();
					return;
				}
				this.addOneRecord(selectkey,sub_domain,ttl,type,line,value);
			}
			this.addOneRecord = function(key,sub_domain,ttl,type,line,value) {
				var that = this;
				var row = this.getRow(this.selectarr[key]);
				value = that.checkValue(type, value);
				var domain = row['name'];
				if (!this.checkName(type,sub_domain)) {
					that.multiresult.error.push( domain + '增加解析 ' + sub_domain +' 失败,错误信息,主机名称错误');
					that.deferredAddMultiRecord(key+1,sub_domain,ttl,type,line,value);
					return ;
				}
				$.ajax({
					url:'/api/?c=record&a=add',
					data:{domain:domain,sub_domain:sub_domain,ttl:ttl,record_type:type,record_line:line,value:value},
					dataType:'json',
					async:true,
					success:function(a) {
						switch(a.status.code) {
							case '1':
							case 1:
								that.multiresult.success.push( domain + '增加解析 ' + sub_domain +' 成功');
							break;
							default:
								that.multiresult.error.push( domain + '增加解析 ' + sub_domain +' 失败,错误信息:'+a.status.message);
								break;
						}
						that.deferredAddMultiRecord(key+1,sub_domain,ttl,type,line,value);
					},
					error:function(e) {
						that.deferredAddMultiRecord(key+1,sub_domain,ttl,type,line,value);
					}
				});
			}
			this.piaoImportMultiRecord = function() {
				var that = this;
				var template = $("#domain-import-record-template").html();
				var el =  Mustache.to_html(template);
				this.multidiv.html(el).show();
				this.multidiv.find('#record-type').html(this.getTypeHtml());
				this.multidiv.find('#record-line').html(this.getLineHtml());
				this.multidiv.find('#enter').bind('click',function(){
					var checked = that.multidiv.find('[name=replace]').attr('checked');
					var replace = checked ? 1 :0;
					var type = that.multidiv.find('[name=add_multi_record_type]').val();
					var line = that.multidiv.find('[name=add_multi_record_line]').val();
					var ttl = that.multidiv.find('[name=record-ttl]').val();
					var importvalue = "";
					if (that.multidiv.find("#split").html()) {
						importvalue = that.multidiv.find('[name=import-value]').val();
					}else {
						importvalue = that.turnImportValue();
					}
					that.importMultiRecord(replace,type,line,ttl,importvalue);
				});
				this.multidiv.find("#split").bind('click',function() {
					that.multidiv.find("#split").remove();
					that.multidiv.find('#value-div').html('<textarea name="import-domain" style="width:180px;height:200px;" placeholder="域名"></textarea><textarea name="import-host" style="width:180px;height:200px;" placeholder="ip/解析值"></textarea>')
				});
				this.multidiv.find('#esc').bind('click',function(){
					that.multidiv.html("").hide();
				});
			}
			this.turnImportValue = function() {
				var domainstr = this.multidiv.find("[name=import-domain]").val();
				if (!domainstr) {
					return "";
				}
				var hoststr = this.multidiv.find('[name=import-host]').val();
				if (!hoststr) {
					return "";
				}
				domainlist = domainstr.split("\n");
				hostlist = hoststr.split("\n");
				var valuestr = "";
				for( var i in domainlist) {
					var opt = domainlist[i].split('.');
					if (opt.length==1) {
						continue;
					}
					//如果是主域名，则要多添加一条没有解析值的
					if (opt.length ==2) {
						valuestr += domainlist[i]+ "\n";
						valuestr += '@.';
					}
					valuestr += domainlist[i] + ' '+hostlist[i] + "\n";;
				}
				return valuestr;
			}
			this.checkValue = function(type,value) {
				value = value.trim();
				if (value.substr(-1) != '.') {
					if (type=='CNAME' || type=='MX' || type=='NS' || type=='SRV' || type=='DNAME') {
						if (value.indexOf('.') > 0) {
							value += '.';
						}
					}
				}
				if (type=='MX' && value.indexOf(' ') <0) {
					value  = '5 '+ value;
				}
				return value;
			}
			this.checkName = function(type,name){
				if (type=='DNAME') {
					if (name.indexOf('*') >= 0) {
						return false;
					}
				}
				return true;
			}
			this.importMultiRecord = function(replace,type,line,ttl,import_values) {
				var that = this;
				if (!import_values) {
					this.showError('解析值不能为空',true);
					return;
				}
				this.multiresult.empty();
				this.importarr.length = 0;
				var rows = import_values.split("\n");
				for ( var i in rows) {
					var rowline = $.trim(rows[i]);
					if (rowline == '') {
						continue;
					}
					var option = rowline.split(' ');
					if (!option[1]) {
						//主域名,如果没有解析值，则当域名添加
						that.importarr.push(rowline);
					}else {
						var len = rowline.indexOf(' ');
						var option0 = rowline.substr(0,len);
						var option1 = rowline.substr(len+1);
						var index = option0.indexOf('.');
						var sub_domain = option0.substr(0,index);
						var domain = option0.substr(index+1);
						var row = [];
						row['domain'] = domain;
						row['sub_domain'] = sub_domain;
						row['line'] = line;
						row['type'] = type;
						row['replace'] = replace;
						row['ttl'] = ttl;
						row['value'] = option1;
						that.importarr.push(row);
					}
				}
				this.multidiv.find("#enter").button('loading').attr('disabled','disabled');
				this.deferredImportMultiRecord(0);
			}
			this.deferredImportMultiRecord = function(arrkey) {
				if (this.importarr.length == arrkey) {
					this.showMultiResult("");
					this.importarr.length = 0;
					//重载数据
					this.noTurnMultiMessage = 1;
					this.getDomainList(0,this.group_id);
					return;
				}
				var row = this.importarr[arrkey];
				if (typeof row =='string') {
					this.importOneDomain(arrkey);
					return;
				}
				this.importOneRecord(arrkey);
			}
			this.importOneDomain = function(arrkey) {
				var that = this;
				var domain = this.importarr[arrkey];
				$.ajax({
					url : '/api/?c=domain&a=domainAdd',
					type:'POST',
					data : {
						domain : domain,
						group_id:that.group_id
					},
					dataType : 'json',
					async : true,
					success : function(a) {
						if (a.status.code != 1) {
							that.multiresult.error.push(domain + ':'+a.status.message);
						}else {
							that.multiresult.success.push(domain + ':'+a.status.message);
						}
						that.deferredImportMultiRecord(arrkey+1);
					},
					error : function(e) {
						that.deferredImportMultiRecord(arrkey+1);
					}
				});
			}
			this.importOneRecord = function(arrkey) {
				var that = this;
				var row = this.importarr[arrkey];
				var domain,sub_domain,ttl,type,line,replace,value;
				domain = row['domain'];
				sub_domain = row['sub_domain'];
				type = row['type'];
				line = row['line'];
				value = this.checkValue(type,row['value']);
				if (!this.checkName(type,sub_domain)) {
					that.multiresult.error.push(row['sub_domain'] + '.'+ row['domain'] + '失败,错误.主机名称错误');
					that.deferredImportMultiRecord(arrkey+1);
					return;
				}
				replace = row['replace'];
				ttl = row['ttl'];
				$.ajax({
					url:'/api/?c=domain&a=addRecord',
					type:'POST',
					data:{
						domain:domain,
						sub_domain:sub_domain,
						ttl:ttl,
						record_type:type,
						record_line:line,
						replace:replace,
						value:value
					},
					dataType:'json',
					async:true,
					success:function(a) {
						switch(a.status.code) {
							case '1':
							case 1:
								that.multiresult.success.push(row['sub_domain']+ '.'+ row['domain'] + '成功');
							break;
							default:
								that.multiresult.error.push(row['sub_domain'] + '.'+ row['domain'] + '失败,错误:'+a.status.message);
								break;
						}
						that.deferredImportMultiRecord(arrkey+1);
					},
					error:function(e) {
						that.deferredImportMultiRecord(arrkey+1);
					}
				});
			}
			
			this.search = function() {
				this.searchlist.length = 0;
				$("#select_all").attr('checked',false);
				var val = $("#form-search").find('input').val();
				if (this.keyword != val && this.keyword != '') {
					this.keyword = val;
					this.getDomainList(0, this.group_id);
					return;
				}
				if (this.total > this.pagecount) {
					this.keyword = val;
					this.getDomainList(0, this.group_id);
					return;
				}
				this.keyword = '';
				if (!val) {
					if ($("#search_list").html()) {
						this.emptySearchMessage();
					}
					this.render(this.domainlist);
					return ;
				}
				var searchkeys = [];
				for ( var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['name'].substr(0,val.length) == val) {
						searchkeys.push(i);
					}
				}
				if (searchkeys.length < 1) {
					this.showSearchMessage('没有找到记录','alert-error');
					return ;
				}else {
					this.showSearchMessage('找到'+searchkeys.length+'条记录','alert-success');
				}
				this.renderSearch(searchkeys);
			}
			this.renderSearch = function(keys) {
				$("table").find('tbody').html("");
				this.searchlist = keys;
				for ( var i in keys) {
					this.renderOne(keys[i]);
				}
			}
			this.emptySearchMessage = function() {
				this.errordiv.html("");
			}
			this.showSearchMessage = function(message,cssname) {
				var option = [];
				option.message = message;
				option.cssname = cssname;
				var el = Mustache.to_html($("#domain-search-row-template").html(),option);
				this.errordiv.html(el);
			}
			this.closeError = function() {
				this.errordiv.html("");
				$("#domain_error_span").hide();
			}
			this.getDomainListByGroup = function(group_id) 
			{   
				var that = this;
				var gid = parseInt(group_id);
				this.group_id = group_id;
				this.getDomainList(0,gid);
			}
			this.getOtherGroupCount = function(group_id) {
				var c = parseInt(this.all_total);
				for ( var i in this.grouplist) {
					if (this.grouplist[i]['group_id']<=0) {
						continue;
					}
					c = c - parseInt(this.grouplist[i]['size']);
				}
				return c;
			}
			this.showLog = function(message) {
				if (typeof console != 'undefined') {
					console.log(message);
				}
			}
			this.getGroupList = function() {
				var that = this;
				if (this.grouplist.length > 0) {
					that.renderGroup();
					return ;
				}
				$.ajax({
					url:'/api/?c=domaingroup&a=getList',
					dataType:'json',
					async:false,
					success:function(a) {
						if (a.status.code == 1) {
							for ( var i in a.groups) {
								that.grouplist.push(a.groups[i]);
							}
						}
						var all = [];
						all['group_id'] = -1;
						all['group_name'] = '全部域名';
						all['size'] = that.all_total;
						all['id'] = 0;
						that.grouplist.push(all);
						var other = [];
						other['group_id'] = 0;
						other['group_name'] = '未分组';
						other['size'] = that.getOtherGroupCount(0);
						other['id'] = 0.1;
						that.grouplist.push(other);
						that.renderGroup();
					},
					error:function(e) {
					}
				});
			}
			this.renderGroup = function() {
				//TOTDO::右侧的分组需要显示有多少个域名
				var that = this;
				var template = $("#domain-group-li-template").html();
				if (that.grouplist.length >0) {
					//清空只保留增加组的li列
					this.emptyGroupList();
					this.emptyLeftGroupList();
					that.grouplist.sort(compareId);
					for ( var i in that.grouplist) {
						//去除全部域名
						if (that.grouplist[i]['group_id'] >=0) {
							that.grouplist[i]['rowkey'] = i;
							var el =  Mustache.to_html(template,that.grouplist[i]);
							$("#dropdown_group").append(el);
						}
						that.renderOneLeftGroup(i);
					}
					$("#dropdown_group").find('a').not("#createa").bind('click',function(){
						that.changeGroup($(this).attr('data-key'));
					});
				}
				$("#left_group_"+this.group_id).addClass("cur");
			}
			this.getGroupRow = function(gkey) {
				return this.grouplist[gkey];
			}
			this.setGroupRow = function(gkey,key,value) {
				if (value == undefined) {
					for ( var i in key) {
						this.grouplist[gkey][i] = key[i];
					}
				}else {
					if (key=='size') {
						this.grouplist[gkey][key] = parseInt(this.grouplist[gkey][key]) + value;
					}else {
						this.grouplist[gkey][key] = value;
					}
				}
			}
			this.getGroupname = function(gid) {
				for ( var i in this.grouplist) {
					if (this.grouplist[i]['group_id'] == gid) {
						return this.grouplist[i]['group_name'];
					}
				}
				return '';
			}
			this.setGroupRowByGroupid = function(gid,key,value) {
				for ( var i in this.grouplist) {
					if (this.grouplist[i]['group_id']==gid) {
						if (value.substr(0,1)=='-') {
							this.grouplist[i][key] = parseInt(this.grouplist[i][key]) - parseInt(value.substr(1));
						}else if (value.substr(0,1) =='+') {
							this.grouplist[i][key] = parseInt(this.grouplist[i][key]) + parseInt(value.substr(1));
						}else {
							this.grouplist[i][key] = value;
						}
						break;
					}
				}
			}
			this.addGroupRow = function(data) {
				this.grouplist.push(data);
				return this.grouplist.length-1;
			}
			this.renderOneLeftGroup = function(gkey) {
				var that = this;
				var row = this.getGroupRow(gkey);
				var template = $("#domain-left-group-li-template").html();
				row['domid'] = 'left_group_'+row['group_id'];
				if (!row['size']) {
					row['size'] = 0;
				}
				var el = Mustache.to_html(template,row);
				if ($("#"+row['domid']).html()) {
					$("#"+row['domid']).html(el);
				}else {
					$("#left_group_list").append(el);
				}
			
				$("#"+row['domid']).find("#lista").bind('click',function(){
					that.getDomainListByGroup($(this).attr('data-id'));
				});
				$("#"+row['domid']).find("#edita").bind('click',function(){
					that.piaoEditGroupName(gkey);
				});
			}
			this.piaoEditGroupName = function(gkey) {
				var row = this.getGroupRow(gkey);
				if (row['group_id'] <=0) {
					return;
				}
				var that = this;
				var template = $("#domain-left-group-li-edit-template").html();
				var el = Mustache.to_html(template,row);
				$("#"+row['domid']).unbind('click');
				$("#"+row['domid']).html(el);
				$("#"+row['domid']).find('#edit').bind('click',function(){
					that.editGroupName(gkey);
				});
			}
			this.editGroupName = function(gkey) {
				var row = this.getGroupRow(gkey);
				var that = this;
				var newgroupname = $("#"+row['domid']).find('input').val();
				if (newgroupname == row['group_name']) {
					that.renderOneLeftGroup(gkey);
					return;
				}
				$.ajax({
					url:'/api/?c=domaingroup&a=edit',
					type:'POST',
					data:{group_name:newgroupname,group_id:row['group_id']},
					dataType:'json',
					success:function(a) {
						if (a.status.code  != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.setGroupRow(gkey,'group_name',a.group_name);
						that.renderOneLeftGroup(gkey);
					},
					error:function(e) {
					}
				});
			}
			this.changeGroup = function(gkey) {
				var row = this.getGroupRow(gkey);
				var select = [];
				this.multiresult.empty();
				var that = this;
				for (var i in this.domainlist) {
					if (this.domainlist[i] == undefined) {
						continue;
					}
					if (this.domainlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					that.showError("请先选中域名.",true);
					return;
				}
				var gid = row['group_id'];
				if (gid < 0) {
					return ;
				}
				for ( var i in select) {
					this.changeOneGroup(select[i],gkey);
				}
				this.showMultiResult();
			}
			this.changeOneGroup = function(rowkey,gkey) {
				var that = this;
				var row = this.getRow(rowkey);
				var grow = this.getGroupRow(gkey);
				if (row['group_id'] == grow['group_id']) {
					return;
				}
				$.ajax({
					url:'/api/?c=domain&a=editGroup',
					type:'POST',
					data:{domain:row['name'],group_id:grow['group_id']},
					dataType:'json',
					async:true,
					success:function(a) {
						if (a.status.code != 1) {
							that.multiresult.error.push(row['name'] + '更改分组失败');
						}else {
							that.multiresult.success.push( row['name'] + '更改分组成功');
							that.changeGroupSuccess(rowkey,gkey);
						}
					},
					error:function(e) {
						
					}
				});
			}
			this.changeGroupSuccess = function(rowkey,gkey) {
				var row = this.getRow(rowkey);
				var grow = this.getGroupRow(gkey);
				$("#"+this.getRowId(rowkey)).remove();
				this.delRow(rowkey);
				var newgid = grow['group_id'];
				var oldgid = row['group_id'];
				this.setGroupRow(gkey,'size',1);
				if (oldgid != -1) {
					this.setGroupRowByGroupid(oldgid,'size','-1');
				}else {
					this.setGroupRowByGroupid(0,'size','-1');
				}
				this.renderGroup();
			}
			this.emptyLeftGroupList = function() {
				$("#left_group_list").html("");
			}
			this.emptyGroupList = function() {
				$("#dropdown_group").find('li').not('#create').remove();
			}
			this.piaoAddGroup = function() {
				var that = this;
				var template = $("#domain-add-group-template").html();
				var option = [];
				var el = Mustache.to_html(template,option);
				$("table").find('tbody').find('tr').eq(0).before(el);
				$("#domain_add_group").find('button').eq(0).bind('click',function(){
					that.addGroup($("#domain_add_group").find('input').val());
				});
				$("#domain_add_group").find('button').eq(1).bind('click',function(){
					$("#domain_add_group").remove();
				});
				$("#domain_add_group").find('[name=group_name]').trigger('focus');
			}
			this.addGroup = function(groupname) {
				$("#domain_add_group").remove();
				if ($.trim(groupname)=='') {
					return ;
				}
				var that = this;
				$.ajax({
					url:'/api/?c=domaingroup&a=add',
					type:'POST',
					data:{group_name:groupname},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return ;
						}
						var row = [];
						row.group_name = groupname;
						row.group_id = a.groups.id;
						that.renderGroup(that.addGroupRow(row));	
					},
					error:function(e) {
					}
				});
			}
			this.renderPage = function() {
				this.renderPageCount();
				var that = this;
				var template = $("#domain-page-li-template").html();
				$("#domain-page-div").find('li').remove();
				var pages = this.getPages();
				if ($(pages).length ==0) {
					return;
				}
				for ( var i in pages) {
					var option = [];
					option['pagename'] = i;
					option['page'] = pages[i];
					var el = Mustache.to_html(template,option);
					$("#domain-page-div").find('ul').append(el);
				}
				$("#domain-page-div").find('a').bind('click',function() {
					that.changePage($(this).attr('data-page'));
				});
			}
			this.getPages = function() {
				var page = new Page(this.total,this.pagecount);
				return page.getPagecount(this.page);
			}
			this.changePage = function(page) {
				var that = this;
				that.page = page;
				that.getDomainList(that.page);
				that.renderPage();
			}
			this.renderPageCount = function() {
				$("#domain-pagecount-div").html("");
				var that = this;
				if ($(this.domainlist).length < 1) {
					this.showLog('domain list length < 1');
					return;
				}
				var pagecounts = this.getPageCount();
				var template = $("#domain-page-count-template").html();
				var option = [];
				option.countstart = (this.page) * this.pagecount + 1;
				option.countend = (this.page +1) * this.pagecount;
				option.total = this.total;
				var el = Mustache.to_html(template,option);
				$("#domain-pagecount-div").html(el);
				var litemplate = $("#domain-page-count-li-template").html();
				for ( var i in pagecounts){
					var data = [];
					data.pagecount = pagecounts[i];
					var el =  Mustache.to_html(litemplate,data);
					$("#domain-pagecount-ul").append(el);
				}
				$("#domain-pagecount-ul").find('a').bind('click',function(){
					openCloseBg('open');
					that.changePagecount($(this).attr('data-pagecount'));
				});
			}
			this.changePagecount = function(pagecount) {
				var that = this;
				that.pagecount = pagecount;
				that.getDomainList(this.page);
			}
			this.getPageCount = function() {
				var pagecount = [50,500,1000,2000];
				var returnpagecount = [];
				for ( var i in pagecount) {
					if (this.pagecount == pagecount[i]) {
						continue;
					}
					returnpagecount.push(pagecount[i]);
				}
				return returnpagecount;
			}
			this.showMultiResult = function(joinmsg) {
				var that = this;
				this.secMulti();
				this.selectarr.length = 0;
				this.addarr.length = 0;
				var message = '';
				message += '成功: '+ this.multiresult.get('success').length + ' 个';
				message += '&nbsp;';
				message += '失败:' + this.multiresult.get('error').length + ' 个';
				message += '&nbsp;';
				if (joinmsg) {
					message += "&nbsp;"+joinmsg + '&nbsp;';
				}
				message += '<a href="javascript:;" id="show_multia">详细</a>';
				this.showMessage(message);
			}
			/*
			 * 域名过期切换到免费版本
			 */
			this.domainChangeFree = function(rowkey){
				var that = this;
				var row = this.getRow(rowkey);
				$.ajax({
					url:'/api/?c=domain&a=domainChangeFree',
					type:'POST',
					data:{domain:row['name']},
					dataType:'json',
					success:function(a) { 
						 if (a.status.code != 1) {
							that.showError(a.status.message, true);
							return;
						 }
						 that.showMessage("迁移成功,请注意NS已经修改.",true);
						 that.setRow(rowkey, 'pid', '0');
						 that.setRow(rowkey, 'pname', '未购买');
						 that.setRow(rowkey, 'pid_expire_time', '');
						 that.setRow(rowkey, 'ext_status', 'dns_error');
						 that.renderOne(rowkey);
					},
					error:function(e) {
						that.showError(e.responseText, true);
						
					}
				});
			}
			
			this.showAllMultiMessage = function() {
				var that = this;
				var message = '';
				var s = this.multiresult.get('success');
				for (var i in s ) {
					message += s[i]+'<br/>';
				}
				var e = this.multiresult.get('error');
				for ( var i in e) {
					message += e[i]+'<br/>';
				}
				var option = [];
				option.title = '信息';
				option.content = message;
				var template = $("#piao-modal-template").html();
				var el = Mustache.to_html(template,option);
				$("body").append(el);
				$("#piao-modal").modal();
				$("#piao-modal").find('#closea').bind('click',function(){
					$("#piao-modal").modal('hide');
					$("#piao-modal").modal('removeBackdrop');
				});
				$("#piao-modal").find("#domain_yanzheng").bind('click',function(){
					$("#piao-modal").modal('hide');
					if(that.temp.length == 0){
						return;
					}
					that.showDomainYanzhengDiv();
				});
			}
			this.showDomainYanzhengDiv = function(){
				var that = this;
				var template = $("#domain-yanzheng-template").html();
				var option = [];
				var html = "";
				html = that.getYanzhengDomainHtml(that.temp);
				option.list = html;
				var el = Mustache.to_html(template,option);
				that.multidiv.html(el).show();
				$("#domain-yanzheng-esc").bind("click",function(){
					that.temp.length = 0;
					that.secMulti();
				});
			}
			this.getYanzhengDomainHtml = function(list){
				var that = this;
				var html = "";
				for(var i in list){
					html += "<tr>";
					html += "<td class='span3'>&nbsp;</td>";
					html += "<td>域名:</td>";
					html += "<td>"+list[i]+"</td>";
					html += "<td><a href='javascript:;' onclick=\"showDomainYanzhengModal('"+list[i]+"')\">验证</a></td>";
					html += "</tr>";
				}
				return html;
			}
			this.multiresult = {};
			this.multiresult.error = [];
			this.multiresult.success = [];
			this.multiresult.get = function(type) {
				if (type =='error') {
					return this.error;
				}
				return this.success;
			}
			this.multiresult.empty = function() {
				this.error.length = 0;
				this.success.length = 0;
			}
			//单域名购买cdn产品
			this.singleDomainBuyCdn = function(key){
				var that = this;
				var domain = that.domainlist[key]['domain'];
				$.ajax({
					url:'/api/?c=cdn&a=getCdnProductList',
					data:{domain:domain},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.showError(a.ret,false);
							return;
						}
						that.cdnProductSelect(a.ret,key);
					},
					error:function(a){
						alert('error');
					}
				});
			}
			this.cdnProductSelect = function(product,key){
				var that = this;
				var count = 1;
				if(key == "multi"){
					count = that.selectarr.length;
				}
				var template = $("#multi-domain-to-cdn-template").html();
				var selectHtml = "<select name='product' id='changeProduct'>";
				for(var i in product){
					selectHtml += "<option value='"+product[i]['id']+"'>"+product[i]['name']+"</option>";
				}
				selectHtml += "</select>";
				that.multidiv.html(template).show();
				that.multidiv.find("#select").append(selectHtml);
				that.multidiv.find("#enter").bind('click',function(){
					if(key == "multi"){
						that.filterMultiDomainBuyCdnData();
						return;
					}
					that.enterSingleDomainBuyCdn(key);
				});
				that.multidiv.find("#esc").bind('click',function(){
					that.multidiv.html("").hide();
				});
			}
			this.monthChange = function(multi){
				var that = this;
				var count = 1;
				if(multi == "multi"){
					that.selectarr.length = 0;
					for(var i in that.domainlist){
						if(that.domainlist[i] == undefined){
							continue;
						}
						if(that.domainlist[i]['sitestatus'] == 0 || that.domainlist[i]['sitestatus'] == 1 || that.domainlist[i]['sitestatus'] == 3){
							continue;
						}
						if(that.domainlist[i]['checked'] == undefined || that.domainlist[i]['checked'] == ""){
							continue;
						}
						that.selectarr.push(i);
					}
					count = that.selectarr.length;
				}
				
				
				var div = that.multidiv;
				var productId = div.find("[name=product]").val();
				$.ajax({
					url:'?c=cdn&a=getCdnProduct',
					data:{id:productId},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							return;
						}
						div.find("#money").html(a.ret['price'] / 100);
						var allMoney = (a.ret['price'] * div.find("[name=month]:checked").val()) / 100 * count;
						div.find("#allMoney").html(allMoney);
						if(parseInt(div.find("#remaining").text()) < allMoney){
							div.find("#top-up").html("<a href='/user/?c=user&a=index' style='color:red'>充值</a>");
						}
					},
					error:function(a){
						alert('error');
					}
				});
			}
			this.cdnProductChange = function(multi){
				var that = this;
				var count = 1;
				if(multi == "multi"){
					that.selectarr.length = 0;
					for(var i in that.domainlist){
						if(that.domainlist[i] == undefined){
							continue;
						}
						if(that.domainlist[i]['sitestatus'] == 0 || that.domainlist[i]['sitestatus'] == 1 || that.domainlist[i]['sitestatus'] == 3){
							continue;
						}
						if(that.domainlist[i]['checked'] == undefined || that.domainlist[i]['checked'] == ""){
							continue;
						}
						that.selectarr.push(i);
					}
					count = that.selectarr.length;
				}
				var div = that.multidiv;
				var productId = div.find("[name=product]").val();
				$.ajax({
					url:'?c=cdn&a=getCdnProduct',
					data:{id:productId},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							return;
						}
						div.find("#money").html(a.ret['price'] / 100);
						var allMoney = (a.ret['price'] * div.find("[name=month]:checked").val()) / 100 * count;
						div.find("#allMoney").html(allMoney);
						if(parseInt(div.find("#remaining").text()) < allMoney){
							div.find("#top-up").html("<a href='/user/?c=user&a=index' style='color:red'>充值</a>");
						}
					},
					error:function(a){
						alert('error');
					}
				});
			}
			this.enterSingleDomainBuyCdn = function(key){
				var that = this;
				var div = that.multidiv;
				var domain = that.domainlist[key]['name'];
				var productId = div.find("[name=product]").val();
				$.ajax({
					url:'/api/?c=cdn&a=buyCdnProduct',
					data:{domain:domain,productId:productId},
					dataType:'json',
					success:function(a){
						that.multidiv.hide();
						if(a.status.code != 1){
							that.showError(a.ret,false);
							return;
						}
						if(a.status.code == 1){
							that.domainlist[key]['sitestatus'] = a.ret;
							that.domainlist[key]['cdn_expire_time'] = 100;
							that.renderOne(key);
							that.showMessage('购买产品成功',true);
							return;
						}
					},
					error:function(a){
						that.showError('网络异常',true);
					}
				});
			}
			//删除cdn
			this.selectDelCdn = function(){
				var that = this;
				that.selectarr.length = 0;
				for(var i in that.domainlist){
					if(that.domainlist[i] == undefined){
						continue;
					}
					if(that.domainlist[i]['checked'] == undefined || that.domainlist[i]['checked'] == ""){
						continue;
					}
					if(that.domainlist[i]['sitestatus'] > 1 || that.domainlist[i]['sitestatus'] == 0){
						continue;
					}
					that.selectarr.push(i);
				}
				if(that.selectarr.length == 0){
					that.showError('请选择符合条件的域名',true);
					return;
				}
				that.multiresult.empty();
				that.deferredDelCdn(0);
			}
			this.deferredDelCdn = function(key){
				var that = this;
				if(key == that.selectarr.length){
					that.showMultiResult();
					return;
				}
				that.delCdn(key,true);
			}
			this.delCdn = function(key,multi){
				var that = this;
				var domainKey = that.selectarr[key];
				var domain = that.domainlist[domainKey]['name'];
				$.ajax({
					url:'/api/?c=cdn&a=delCdn',
					type:'POST',
					data:{domain:domain},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.multiresult.error.push(domain+":"+a.ret);
							if(multi){
								that.deferredDelCdn(key+1);
							}
							return;
						}
						if(multi){
							that.multiresult.success.push(domain+":"+"CDN站点删除成功");
							that.domainlist[domainKey]['sitestatus'] = 2;
							that.renderOne(domainKey);
							that.deferredDelCdn(key+1);
						}
					},
					error:function(a){
						that.multiresult.error.push("网络异常删除CDN站点:"+domain+" 失败");
						that.deferredDelCdn(key+1);
					}
				});
			}
		}
		$("#nav_domain").addClass('nav_domain');
		var domain = new domain();
		domain.getInfo(groupid,iscdn);
	});
var showDomainYanzhengModal = function(domain){
	var that = this;
	$.ajax({
		url:'/api/?c=domain&a=getRecordValue',
		type:'POST',
		data:{domain:domain},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				var key = a.ret;
			}else{
				var key = a.key;
			}
			var template = $("#domain-yanzheng-modal-template").html();
			var option = [];
			option.key = key;
			option.domain = domain;
			var el = Mustache.to_html(template,option);
			$("body").append(el);
			$("#domain-yanzheng-div").modal({
				keyboard: true
			});
			$("#domain-yanzheng-div").find("#next").removeAttr("disabled");
		},
		error:function(a){
			
		}
	});
}
var domainYanzhengNext = function(domain){
	$("#domain-yanzheng-div").modal("hide");
	var template = $("#domain-yanzheng-next-template").html();
	$("body").append(template);
	$("#domain-yanzheng-next-div").modal('show');
	$("#domain-yanzheng-next-div").find("#enter").bind('click',function(){
		domainYanzhengEnter(domain);
	});
}
var domainYanzhengEnter = function(domain){
	$.ajax({
		url:'/api/?c=domain&a=domainYanzheng',
		type:'POST',
		data:{domain:domain},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				var ret = a.ret;
			}else{
				var ret = a.ret;
			}
			$("#domain-yanzheng-next-div").find("#mem").html(ret);
			$("#domain-yanzheng-next-div").find("#enter").attr("disabled","disabled");
		},
		error:function(a){
		}
	});
}