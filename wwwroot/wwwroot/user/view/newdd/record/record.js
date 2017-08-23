	$(document).ready(function() {
		$("#record-operat").find('#record').find('a').addClass('cur');
		$("#nav_domain").addClass("cur");
		var RecordClass = function() {
			this.isadmin = 0;
			this.iscdn = 0;
			this.cdn_site_status = false;
			this.recordlist = [];
			//searchlist只存this.recordlist里面的key
			this.searchlist = [];
			this.message = '';
			this.page = 0;
			this.total = 0;
			this.all_total = 0;
			this.pagecount = 5000;
			this._offset = 0;
			this.cdn_id = 0;
			this.cdn_status = 2;
			this.domain = '';
			this.keyword = '';
			this.lines = [];
			this.multidiv = $("#multi_div");
			this.listdiv = $("#record-list");
			this.errordiv = $("#error-message");
			this.importdiv = $("#import_multi_record");
			this.multidelli = $("#dropdown_operating").find("#del");
			this.multistopli = $("#dropdown_operating").find("#stop");
			this.multirestorli = $("#dropdown_operating").find("#restor");
			//this.cdn_multiaddli = $("#cdn_dropdown_operation").find("#add"); //cdn批量增加站点域名
			this.multiarr = [];
			this.selectarr = [];
			this.addarr = [];
			this.piaoarr = [];
			this.pname = '';
			this.defaultTtl = 3600;
			this.nsname = '';
			this.panelname = 'DNSDUN';
			this.success = [];
			this.error = [];
			this.getInfo = function(iscdn,isadmin) {
				var that = this;
				openCloseBg('open');
				that.iscdn = iscdn;
				that.isadmin = isadmin;
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
							that.cdn_id = a.domain.cdn_id;
							that.cdn_status = a.domain.cdn_status;			
							if (a.domain.panelname) {
								that.panelname = a.domain.panelname;
							}
							that.defaultTtl = a.domain.ttl;
							that.renderTips();
							that.renderHeader();
							that.getRecordList();
						},
						error:function(e) {
							that.showError('后台数据出错'+e.responseText);
						}
					});
			};
			this.renderLoginError = function() {
				var template = $("#record-nologin-template").html();
				this.listdiv.append(template);
			};
			/*增加记录分类查询参数
			 * classify 记录类型参数
			 * */
			this.getRecordList = function(page) {
				var that = this;
				this.page = (typeof page != 'undefined') ? parseInt(page) : this.page;
				this._offset = this.page==0 ? 0 : (parseInt(this.page))*this.pagecount;
				//this.loading(0);
				$.ajax({
					url : '/api/?c=record&a=list',
					data : {
						domain : that.domain,
						offset : that._offset,
						length : that.pagecount,
						keyword: that.keyword
					},
					dataType : 'json',
					success : function(a) {
						that.loadComplete();
						if (parseInt(a.status.code) != 1) {
							return;
						}
						that.total = parseInt(a.info.record_total);
						if (that.all_total==0) {
							that.all_total = parseInt(a.info.record_total);
						}
						that.recordlist = a.records;
						that.render(that.recordlist);
						that.renderPage();
					},
					error : function(e) {
						that.loadComplete();
					}
				});
			};
			this.getRow = function(key) {
				return this.recordlist[key];
			};
			this.getRowId = function(key){
				return 'tr'+key;
			};
			this.setRow = function(key,option,optionval) {
				if (optionval == undefined) {
					for ( var i in option) {
						this.recordlist[key][i] = option[i];
					}
				}else {
					this.recordlist[key][option] = optionval;
				}
			};
			this.delRow = function(key) {
				
			};
			this.addRow = function(data){
				if (this.recordlist==null) {
					this.recordlist = [];
				}
				this.recordlist.push(data);
				return this.recordlist.length-1;
			};
			this.sortName = function() {
				this._sort(compareName);
			};
			this.sortType = function() {
				this._sort(compareType);
			};
			this._sort = function(fn) {
				if (this.searchlist.length > 0) {
					var list = [];
					for ( var i in this.searchlist) {
						this.recordlist[this.searchlist[i]]['key'] = this.searchlist[i];
						list.push( this.recordlist[this.searchlist[i]]);
					}
					this.renderSort(list.sort(fn));
				}else {
					this.render(this.recordlist.sort(fn));
				}
			}; 
			this.renderSort = function(list) {
				this.listdiv.html("");
				for (var i in list) {
					this.renderOne(list[i]['key']);
				}
			};
			this.sortLine = function() {
				this._sort(compareLine);
			};
			this.sortValue = function() {
				this._sort(compareValue);
			};
			this.sortTtl = function() {
				this._sort(compareTtl);
			};
			this.renderHeader = function() {
				var that = this;
				$("#domain_name_show").html(this.domain);
				$("#domain_pname_show").html(this.pname).parent('a').attr('href','?c=product&a=index&domain='+this.domain);
				$("#record-list-header").remove();
				var template = $("#record-list-header-template").html();
				this.listdiv.before(Mustache.to_html(template));
				$('#record-select-all').bind('click',function(){
					that.selectAll($("#record-select-all").attr('checked'));
				});
				$("#import_multi_record").attr('disabled',false);
				$("#record-list-header").find('#name-sort').bind({
					'click':function(){that.sortName();},
					'mouseover':function() {$(this).tooltip('show');}
				});
				$("#record-list-header").find('#type-sort').bind({
					'click':function() {that.sortType();},
					'mouseover':function() {$(this).tooltip('show');}
				});
				$("#record-list-header").find('#line-sort').bind({
					'click':function(){	that.sortLine();},
					'mouseover':function() {$(this).tooltip('show');}
				});
				$("#record-list-header").find('#value-sort').bind({
					'click':function(){that.sortValue();},
					'mouseover':function() {$(this).tooltip('show');}
				});
				$("#record-list-header").find('#ttl-sort').bind({
					'click':function(){	that.sortTtl();},
					'mouseover':function() {$(this).tooltip('show');}
				});
				$("#add-record").bind('click',function() {
					that.piaoAddRecord();
				});
				$("#add_sub_domain").bind('click',function(){
					that.piaoAddSubdomain();
				});
				$("#export_content").bind('click',function(){
					that.piaoExportContent();
				});
				$("#recoverData").bind('click',function(){
					that.recoverData();
				});
				$("#fileSubmit").bind('click',function(){
					$("form").submit();
				});
				$("#fileUpload").bind('click',function(){
					$("#file").click();
				});
				$("#from-search").find('#search-input').bind('keypress',function(e){
					var keycode = 0;
					if(window.event){
						keycode = e.keyCode; //IE
					}else if(e.which){
						keycode = e.which;
					}
					if (keycode != 13) {
						return;
					}
					that.search(e);
				});
				$("#add_multi_record").bind('click',function(){
					that.piaoAddMultiRecord();
				});
				$("#import_multi_record").bind('click',function(){
					that.piaoImportRecord();
				});
				$("#dropdown_operating").find('#del').bind('click',function(){
					//record.delMultiRecord();
					that.piaoMultiDelConfrim();
				});
				$("#dropdown_operating").find('#restor').bind('click',function(){
					that.restorMultiRecord();
				});
				$("#dropdown_operating").find('#stop').bind('click',function(){
					that.stopMultiRecord();
				});
				//批量操作cdn站点域名
				$("#dropdown_operating").find("#cdn_add").bind('click',function(){
					that.cdnMultiAddDomainConfrim();
				});
				$("#dropdown_operating").find("#cdn_del").bind("click",function(){
					that.cdnMultiDelDomainConfrim();
				});
				//记录分类查询
				$("#dropdown-classify-opera").find("#all").bind('click',function(){
					//alert('查询所有');
					that.recordClassify('');
				});
				$("#dropdown-classify-opera").find("#a_record").bind('click',function(){
					that.recordClassify('A');
				});
				$("#dropdown-classify-opera").find("#cname_record").bind('click',function(){
					that.recordClassify('CNAME');
				});
				$("#dropdown-classify-opera").find("#unite").bind('click',function(){
					//alert('unite');
					that.recordClassify('unite');
				});
				$("#dropdown-classify-opera").find("#analyses_start").bind('click',function(){
					//alert('解析启用');
					that.recordClassify('analyses_start');
				});
				$("#dropdown-classify-opera").find("#analyses_pause").bind('click',function(){
					//alert('解析暂停');
					that.recordClassify('analyses_pause');
				});
				$("#dropdown-classify-opera").find("#start").bind('click',function(){
					//alert('启用');
					that.recordClassify('start');
				});
				$("#dropdown-classify-opera").find("#standby").bind('click',function(){
					//alert('备用');
					that.recordClassify('standby');
				});
				$("#dropdown-classify-opera").find("#standby_record").bind('click',function(){
					//alert('备注记录');
					that.recordClassify('standby_record');
				});
			};
			//批量删除站点域名
			this.cdnMultiDelDomainConfrim = function(){
				var that = this;
				that.error.length = 0;
				that.success.length = 0;
				var select = [];
				for(var i in that.recordlist){
					if(that.recordlist[i] == undefined){
						continue;
					}
					if(that.recordlist[i]['checked'] && (that.recordlist[i]['type'] == "A" || that.recordlist[i]['type'] == "AAAA") && that.recordlist[i]['cdn'] != 0){
						select.push(i);
					}
				}
				if(select.length < 1){
					that.showError("请选择符合条件的记录!",true);
					return;
				}
				var template = $("#multi-del-confirm-template").html();
				var option = [];
				option.content = '目前支持类型为 "A" "AAAA" 的记录 <br/>符合删除条件的记录有 '+select.length + ' 条';
				option.title = "批量增加确认";
				var el = Mustache.to_html(template,option);
				$("body").append(el);
				var piao = $("#confirm-modal");
				var modal = piao.modal(option);
				piao.find("#esc").bind("click",function(){
					piao.modal('hide');
					piao.modal('removeBackdrop');
				});
				piao.find("#enter").bind("click",function(){
					piao.modal("hide");
					piao.modal("removeBackdrop");
					that.selectarr = select;
					that.deferredMultiDelCdnSiteDomain(0);
				});
			};
			this.deferredMultiDelCdnSiteDomain = function(key){
				var that = this;
				if(key == that.selectarr.length){
					$("#progress_success").css("width","100%");
					that.showMessage("批量操作完成!  成功:"+that.success.length+"  失败:"+that.error.length+"  共计:"+that.selectarr.length,true);
					setTimeout(function(){
						$("#progress_main").css("display","none");
					},5000);
					return;
				}
				var progress = (key / that.selectarr.length) * 100 + "%";
				$("#progress_main").css("display","");
				$("#progress_success").css("width",progress);
				that.cdnDomainMultiDel(key,true);
			};
			this.cdnDomainMultiDel = function(key,multi){
				var that = this;
				var rowkey = key;
				var row ;
				if(multi){
					rowkey = that.selectarr[key];
					 row = that.recordlist[rowkey];
				}else{
					 row = that.recordlist[rowkey];
				}
				$.ajax({
					url:'/api/?c=record&a=changeCdn',
					data:{record_id:row['id'],cdn:0},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.error.push(a.status.code);
							that.deferredMultiDelCdnSiteDomain(key+1);
						}else{
							that.success.push(a.status.code);
							that.recordlist[rowkey]['checked'] = undefined;
							that.recordlist[rowkey]['cdn'] = 0;
							that.renderOne(rowkey);
							that.deferredMultiDelCdnSiteDomain(key+1);
						}
					},
					error:function(a){
						that.error.push(a.status.code);
						that.deferredMultiDelCdnSiteDomain(key+1);
					}
				});
			};
			//批量增加站点域名
			this.cdnMultiAddDomainConfrim = function(){
				var that = this;
				that.error.length = 0;
				that.success.length = 0;
				var select = [];
				for(var i in that.recordlist){
					if(that.recordlist[i] == undefined){
						continue;
					}
					if(that.recordlist[i]['checked'] && (that.recordlist[i]['type'] == "A" || that.recordlist[i]['type'] == "AAAA") && that.recordlist[i]['cdn'] == 0){
						select.push(i);
					}
				}
				if(select.length < 1){
					that.showError("请选择符合条件的记录!",true);
					return;
				}
				var template = $("#multi-del-confirm-template").html();
				var option = [];
				option.content = '目前支持类型为 "A" "AAAA" 的记录 <br/>符合增加条件的记录有 '+select.length + ' 条';
				option.title = '批量增加确认';
				var el =  Mustache.to_html(template,option);
				$("body").append(el);
				var piao = $("#confirm-modal");
				var modal = piao.modal(option);
				piao.find('#esc').bind('click',function(){
					piao.modal('hide');
					piao.modal('removeBackdrop');
				});
				piao.find('#enter').bind('click',function(){
					piao.modal('hide');
					piao.modal('removeBackdrop');
					that.selectarr = select;
					that.deferredMultiAddCdnSiteDomain(0);
				});
			};
			this.deferredMultiAddCdnSiteDomain = function(key){
				var that = this;
				if(key == that.selectarr.length){
					$("#progress_success").css({"width":"100%"});
					that.showMessage("批量操作完成!  成功:"+that.success.length+"  失败:"+that.error.length+"  共计:"+that.selectarr.length,true);
					setTimeout(function(){
						$("#progress_main").css("display","none");
					},5000);
					return;
				}
				var progress = (key / that.selectarr.length) * 100 + "%";
				$("#progress_main").css("display","");
				$("#progress_success").css("width",progress);
				that.cdnDomainMultiAdd(key,true);
			};
			this.cdnDomainMultiAdd = function(key,multi){
				var that = this;
				var rowkey = key;
				var row ;
				if(multi){
					rowkey = that.selectarr[key];
					 row = that.getRow(rowkey);
				}else{
					 row = that.getRow(rowkey);
				}
				$.ajax({
					url:'/api/?c=record&a=changeCdn',
					data:{cdn:1,record_id:row['id']},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.error.push(a.status.code);
							that.deferredMultiAddCdnSiteDomain(key+1);
						}else{
							that.success.push(a.status.code);
							that.recordlist[rowkey]['cdn'] = 1;
							that.recordlist[rowkey]['checked'] = undefined;
							that.renderOne(rowkey);
							that.deferredMultiAddCdnSiteDomain(key+1);
						}
					},
					error:function(a){
						that.error.push(a.status.code);
						that.deferredMultiAddCdnSiteDomain(key+1);
					}
				});
			};
			this.recoverData = function(){
				var that = this;
				var template = $("#file-upload-template").html();
				var el = Mustache.to_html(template);
				this.multidiv.html(el).show();
				var div = $("#file-upload-div");
				div.find("#submit").bind('click',function(){
					if (!div.find("#fileToUpload").val()) {
						div.remove();
						return;
					}
					openCloseBg('open');
					$.ajaxFileUpload({
							url:'/api/?c=record&a=recoverData',
							secureuri:false,
							fileElementId:'fileToUpload',
							dataType: 'json',
							success: function (a){
								openCloseBg('close');
								if(a.status.code!= 1){
									that.showError(a.status.message);
									return;
								}
								var temp = $("#file-prompt-template").html();
								var option = [];
								option.content = "数据导入完成,成功数:"+a.successcount + ' 失败数:'+a.errorcount;
								var el = Mustache.to_html(temp,option);
								that.multidiv.html(el).show();
								$("#imggif").remove();
								setTimeout(function(){
									$("#file-prompt-div").hide(1000);
									that.getRecordList(0);
								},2000);
							},
							error: function (e){
								openCloseBg('close');
								that.showError('响应失败',true);
							}
						}
					);
				});
			};
			this.render = function(recordlist) {
				this.searchlist.length = 0;
				this.listdiv.html("");
				for ( var i in recordlist) {
					this.renderOne(i);
				}
				openCloseBg('close');
			};
			this.renderSearch = function(keys) {
				this.listdiv.html("");
				this.searchlist = keys;
				for ( var i in keys) {
					this.renderOne(keys[i]);
				}
			};
			this.renderTips = function() {
				var that = this;
				$.ajax({
					url:'/api/?c=record&a=getTips',
					data:{
						domain:that.domain,
					},
					dataType:'json',
					success:function(a) {
						if (a.status=='ok') {
							return;
						}
						/*
						if ($.cookie(that.domain+'_record-tips')) {
							//弹出一次后不需要再次弹出,用户已经看过提示了.但是api请求还是要发出,查询域名的NS是否已修改
							return;
						}
						*/
						var tips = '<div id="tips-content"><p ><button type="button" class="tip_close" data-dismiss="modal" aria-hidder="true"><i class="icon-remove"></i></button></p>';
						tips += a.string + '</div>';
						$("#record-tips").html(tips);
						$("#record-tips").slideDown("slow");
						$("#record-tips").find('#tips-content').addClass('alert alert-success');
						$("#record-tips").find('button').bind('click',function(){
							$("#record-tips").hide();
							//$.cookie(that.domain+'_record-tips',1,{expire:20});
						});
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.renderOne = function(key) {
				var that = this;
				var row = this.getRow(key);
				if (row==undefined)  {
					return;
				}
				if (row['id']==1) {
					this.nsname = row['value'];
				}
				row.divid = this.getRowId(key);
				var obj = "#"+row.divid;
				var update = false;
				var template = $("#record-row-template").html();
				if ($(obj).html()) {
					update = true;
					template = $("#record-row-refresh-template").html();
				}
				var isdisabled = false;
				if (row['hold']) {
					isdisabled = true;
				}
				if (isdisabled) {
					row.disabled = 'disabled="disabled"';
				}else {
					var operat_template = $("#record-operat-template").html();
					row.operat = Mustache.to_html(operat_template,row);
					if (row['monitor_enable']) {
						var monitor_template = $("#record-monitor-template").html();
						row.monitor_operat = Mustache.to_html(monitor_template);
					}else {
						row.monitor_operat = '';
					}
				}
				var el = Mustache.to_html(template,row);
				if (update) {
					$(obj).html(el);
				}else {
					if ( this.listdiv.find('.record').length > 0) {
						this.listdiv.find('.record').eq(0).before(el);
					}else {
						this.listdiv.append(el);
					}
				}
				if (isdisabled) {
					$(obj).addClass('back-gray');
					//如果是锁定状态的，则不需要有操作以及监控信息显示了。
					return;
				}
				var div = $(obj);
				div.find(':checkbox').bind('click',function() {
					that.selectOne(key);
				});
				if (row['status']=='enable') {
					div.find('#record-operat').find("#stop").remove();
					div.find('#record-operat').find("#restor").bind({
						'click':function() {that.stopRecord(key);},
						'mouseover':function() {$(this).tooltip('show');}
					});
					div.removeClass('back-gray');
				}else {
					div.find('#record-operat').find("#restor").remove();
					div.find('#record-operat').find("#stop").bind({
						'click':function() {that.restorRecord(key);},
						'mouseover':function() {$(this).tooltip('show');}
					});
					div.addClass('back-gray');
				}
				//记录高级设置
				if(that.isadmin == 1){
					div.find("#height_set").find("#zhdc").bind('click',function(){
						var heightId = div.find("#height_set");
						that.recordHeightSet(heightId, key);
					});
				}else{
					div.find("#height_set").remove();
				}
				
				if (parseInt(row['backup'])==1) {
					div.find('#record-operat').find("#nobackup").remove();
					div.find('#record-operat').find("#backup").bind({
						'click':function(){	that.nobackupRecord(key);},
						'mouseover':function() {$(this).tooltip('show');}
					});
				}else {
					div.find('#record-operat').find("#backup").remove();
					div.find('#record-operat').find("#nobackup").bind({
						'click':function(){	that.backupRecord(key);},
						'mouseover':function() {$(this).tooltip('show');}
					});
				}
				if (row['monitor_enable']) {
					if(row['monitor_flag'] == 0){
						div.find('#record-monitor').find("#normal").remove();
					}
					if (row['monitor']) {
						div.find('#record-monitor').find("#add").remove();
						
						div.find('#record-monitor').find("#del").bind({
							'click':function(){
								that.delMonitorConfirm(key);
								//that.piaoDelMonitor(key);
							},
							'mouseover':function() {
								$(this).tooltip('show');
							}
						});
						div.find('#record-monitor').find("#edit").bind({
							'click':function(){	that.piaoEditMonitor(key);},
							'mouseover':function() {$(this).tooltip('show');}
						});
						div.find("#record-monitor").find('#error,#switch').bind({
							'mouseover':function() {$(this).tooltip('show');}
						});
						if (!row['monitor_switch']) {
							div.find('#record-monitor').find('#switch').remove();
						}else {
							div.find("#record-monitor").find("#switch").bind('click',function(){
								window.location = '?c=public&a=monitorLog&status=switch&record_id='+row['id'];
							});
							div.find("#record-monitor").find("#normal").remove();
						}
						if (!row['monitor_error']) {
							div.find('#record-monitor').find('#error').remove();
						}else {
							div.find("#record-monitor").find("#error").bind('click',function(){
								window.location = '?c=public&a=monitorLog&status=error&record_id='+row['id'];
							});
							div.find("#record-monitor").find("#normal").remove();
						}
						div.find("#record-monitor").find("#normal").bind({
							'mouseover':function(){$(this).tooltip('show');}
						});
						if (!row['monitor_switch'] && !row['monitor_error']) {
							div.find("#record-monitor").find("#normal").bind('click',function(){
								window.location = '?c=public&a=monitorLog&status=normal&record_id='+row['id'];
							});
						}
					}else {
						div.find('#record-monitor').find("#del").remove();
						div.find('#record-monitor').find("#edit").remove();
						div.find('#record-monitor').find("#error").remove();
						div.find('#record-monitor').find("#switch").remove();
						div.find('#record-monitor').find("#normal").remove();
						div.find('#record-monitor').find("#add").bind({
							'click':function(){that.piaoAddMonitor(key);},
							'mouseover':function() {$(this).tooltip('show');}
						});
					}
					
					if (!row['monitor_error']) {
						div.find('#record-monitor').find("#error").remove();
					}
					if (!row['monitor_switch']) {
						div.find('#record-monitor').find("#switch").remove();
					}
					
				}
				div.find('#record-operat').find('#del').bind({
					'click':function(){
						that.delConfirm(key);
					},
					'mouseover':function() {
						$(this).tooltip('show');
					}
				});
				div.find('#record-name,#record-type,#record-line,#record-value,#record-ttl').bind('click',function() {
					that.piaoEditRecord(key);
				});
				div.find('#remark').bind({
					'click':function(){	that.piaoRemark(key);},
					'mouseover':function() {$(this).tooltip('show');}
				});
				//cdn站点域名状态
				if(that.iscdn == 1){
					if(that.cdn_id == 0){
						div.find("#record-operat").find("#domain_status0").remove();
						div.find("#record-operat").find("#domain_status1").remove();
						div.find("#record-operat").find("#edit_cdn").remove();
					}
					if(row['type'] == "DNAME" || row['type'] == "MX" || row['type'] == "NS" || row['type'] == "TXT" || row['type'] == "SRV" || row['type'] == "URL" || row['type']=="CNAME"){
						div.find("#record-operat").find("#domain_status0").remove();
						div.find("#record-operat").find("#domain_status1").remove();
						div.find("#record-operat").find("#edit_cdn").remove();
					}
					div.find("#record-operat").find("#domain_status0").bind({
						'click':function(){that.addCdnSiteDomain(key,that.domain);},
						'mouseover':function(){$(this).tooltip('show');}
					});
					if(row['cdn'] == 0){
						div.find("#record-operat").find("#domain_status1").remove();
						div.find("#record-operat").find("#edit_cdn").remove();
					}else{
						div.find("#record-operat").find("#domain_status0").remove();
						div.find("#record-operat").find("#domain_status1").bind({
							'click':function(){
								//that.delSiteDomainConfirm(key);
								that.delCdnSiteDomain(key);
							},
							'mouseover':function(){$(this).tooltip('show');}
						});
						div.find("#record-operat").find("#edit_cdn").bind({
							'click':function(){
								that.editCdnDomain(key);
							},
							'mouseover':function(){$(this).tooltip('show');}
						});
					}
				}else{
					div.find("#record-operat").find("#domain_status0").remove();
					div.find("#record-operat").find("#domain_status1").remove();
					div.find("#record-operat").find("#edit_cdn").remove();
				}
				
				/*
				div.find('#del,#stop,#restor,#backup,#nobackup,#hijack,#nohijack,#add,#edit').bind({
					'mouseover':function(){
						$(this).addClass('back-red');
					}, 
					'mouseout':function() {
						$(this).removeClass('back-red');
					}
				}); 
				*/
			};
			this.editCdnDomain = function(key){
				var that = this;
				var div = $("#"+that.getRowId(key));
				var template = $("#edit-cdn-domain-template").html();
				var el = Mustache.to_html(template);
				div.html(el);
				div.find("#edit_cdn_onoff").find("#enter").bind('click',function(){
					var domain = div.find("#edit_cdn_domain").find("[name=domain]").val();
					var ip = div.find("#edit_cdn_ip").find("[name=ip]").val();
					that.editCdnDomainEnter(key,domain,ip);
				});
				div.find("#edit_cdn_onoff").find("#esc").bind('click',function(){
					that.renderOne(key);
				});
			};
			this.editCdnDomainEnter = function(key,domain,ip){
				var that = this;
				var vhost = that.domain;
				var cb_domain_id = that.recordlist[key]['cb_domain_id'];
				var cdn_pid = that.recordlist[key]['cdn_pid'];
				$.ajax({
					url:'?c=cdn&a=editCdnDomain',
					data:{vhost:vhost,cb_domain_id:cb_domain_id,cdn_pid:cdn_pid,domain:domain,ip:ip},
					dataType:'json',
					success:function(a){
						if(a.status.code == 1){
							that.showMessage('域名修改成功',true);
							that.renderOne(key);
							return;
						}
						that.showError('域名修改失败',true);
						that.renderOne(key);
					},
					error:function(a){
						that.showError('响应失败',true);
					}
				});
			};
			//删除站点域名确认
			/*
			this.delSiteDomainConfirm = function(key){
				var that = this;
				var template = $("#row-del-site-domian-template").html();
				var row = that.getRow(key);
				row.content = "删除cdn站点域名";
				var el = Mustache.to_html(template, row);
				var rowdiv = $("#"+that.getRowId(key));
				rowdiv.html(el);
				rowdiv.addClass('alert-error');
				rowdiv.find('#record-value').addClass('lead');
				rowdiv.find("#enter").bind('click',function(){
					that.delCdnSiteDomain(key);
				});
				rowdiv.find('#esc').bind('click',function(){
					rowdiv.removeClass('alert-error');
					rowdiv.find('#record-value').removeClass('lead');
					that.renderOne(key);
				});
			};
			*/
			//删除cdn站点下域名
			this.delCdnSiteDomain = function(key){
				var that = this;
				var rowdiv = $("#"+that.getRowId(key));
				var record_id = that.recordlist[key]['id'];
				$.ajax({
					url:'/api/?c=record&a=changeCdn',
					data:{
						cdn:0,
						record_id:record_id
						},
					dataType:'json',
					success:function(a){
						if(a.status.code == 1){
							that.recordlist[key]['cdn'] = 0;
							that.renderOne(key);
							rowdiv.removeClass('alert-error');
							rowdiv.find('#record-value').removeClass('lead');
							return;
						}
						that.showMessage("cdn站点域名删除失败",true);
					},
					error:function(a){
						that.showError('响应失败',true);
					}
				});
			};
			//增加cdn站点域名
			this.addCdnSiteDomain = function(key,domain){
				var that = this;
				var record_id = that.recordlist[key]['id'];
				$.ajax({
					url:'/api/?c=record&a=changeCdn',
					data:{
						cdn:1,
						record_id:record_id,
						},
					dataType:'json',
					success:function(a){
						if(a.status.code == 1){
							that.recordlist[key]['cdn'] = 1;
							that.renderOne(key);
							that.showMessage("增加CDN站点域名成功",true);
							return;
						}
						that.showMessage("增加CDN站点域名失败",true);
					},
					error:function(a){
						that.showError('响应失败',true);
					}
				});
			};
			this.delMonitorConfirm = function(key){
				var that = this;
				var template = $("#del-monitor-confirm-template").html();
				var rowdiv = $("#"+this.getRowId(key));
				rowdiv.html(template);
				rowdiv.find("#enter").bind('click',function(){
					that.piaoDelMonitor(key);
				});
				rowdiv.find("#esc").bind('click',function(){
					rowdiv.removeClass('alert-error');
					rowdiv.find('#record-value').removeClass('lead');
					that.renderOne(key);
				});
			};
			this.piaoRemark = function(key) {
				var that = this;
				var row = this.getRow(key);
				var template = $("#record-remark-template").html();
				var el = Mustache.to_html(template, row);
				var rowdiv = $("#"+this.getRowId(key));
				rowdiv.html(el);
				rowdiv.find('#enter').bind({
					'click':function() {that.remark(key);},
					'keyup':function(event) {
						var keycode = event.which;
						if (keycode == 13) {
							that.remark(key);
						}
					}
				});
				rowdiv.find('#esc').bind('click',function(){
					that.renderOne(key);
				});
				var rowdiv = $("#"+this.getRowId(key));
				rowdiv.find('[name=remark]').trigger('focus');
			};
			this.remark = function(key) {
				var that = this;
				var row = this.getRow(key);
				var rowdiv = $("#"+this.getRowId(key));
				var remark = rowdiv.find('[name=remark]').val();
				$.ajax({
					url:"/api/?c=record&a=remark",
					data:{domain:that.domain,record_id:row['id'],remark:remark},
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.setRow(key, 'remark', remark);
						that.renderOne(key);
						that.showMessage(a.status.message,true);
					},
 					error:function(e) {
 						that.showError("后台数据出错",true);
					}
				});
			};
			this.delConfirm = function(key) {
				var that = this;
				var template = $("#row-del-confirm-template").html();
				var row = this.getRow(key);
				
				row.content = '确定要删除该条记录吗?';
				var el = Mustache.to_html(template, row);
				var rowdiv = $("#"+this.getRowId(key));
				rowdiv.html(el);
				rowdiv.addClass('alert-error');
				rowdiv.find('#record-value').addClass('lead');
				rowdiv.find('#enter').bind({
					'click':function(){
						that.delRecord(key);
					},
					'keyup':function(event) {
						var keycode = event.which;
						if (keycode == 13) {
							that.delRecord(key);
						}
					}
				});
				rowdiv.find('#esc').bind('click',function(){
					rowdiv.removeClass('alert-error');
					rowdiv.find('#record-value').removeClass('lead');
					that.renderOne(key);
				});
			};
			this.selectOne = function(key) {
				var checked = $("#"+this.getRowId(key)).find(':checkbox').attr('checked');
				this.recordlist[key]['checked'] = checked;
			};
			this.piaoEditRecord = function(key) {
				var that = this;
				var div = $("#"+this.getRowId(key));
				var row = this.getRow(key);
				var template = $("#record-eidt-template").html();
				var el = Mustache.to_html(template, row);
				div.html(el);
				div.find('#record-type').find('select').html(this.getTypeHtml(row['type']));
				div.find('#record-line').find('select').html(this.getLineHtml(row['line']));
				div.find('button').eq(0).bind('click',function() {
					that.editRecord(key);	
				});
				div.find('button').eq(1).bind('click',function() {
					that.renderOne(key);
				});
			};
			this.checkName = function(type,name){
				if (type=='DNAME') {
					if (name.indexOf('*') >= 0) {
						return false;
					}
				}
				return true;
			};
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
			};
			this.editRecord = function(key) {
				var that = this;
				var row = this.getRow(key);
				var record_id = row['id'];
				var data = {};
				var div = $("#"+this.getRowId(key));
				data.sub_domain = div.find('[name=name]').val();
				data.record_type = div.find('[name=type]').val();
				data.value = this.checkValue(data.record_type,div.find('[name=value]').val());
				data.ttl = div.find('[name=ttl]').val();
				data.record_line = div.find('[name=line]').val();
				data.record_id = record_id;
				data.domain = that.domain;
				if (!this.checkName(data.record_type,data.sub_domain)) {
					this.showError('主机名称错误');
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=modify',
					data:data,
					type:'POST',
					async:true,
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return;
						}
						that.editRecordAfter(key,data);
						that.showMessage(a.status.message,true);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.editRecordAfter = function(key,option) {
				this.setRow(key, 'name', option.sub_domain);
				this.setRow(key, 'type', option.record_type);
				if (option.record_type != 'A' && option.record_type != 'AAAA' && option.record_type != 'CNAME') {
					this.setRow(key, 'monitor_enable', '');
				}else {
					this.setRow(key, 'monitor_enable', 'enable');
				}
				this.setRow(key, 'line', option.record_line);
				this.setRow(key, 'ttl', option.ttl);
				this.setRow(key, 'value', option.value);
				this.renderOne(key);
			};
			this.piaoAddMonitor = function(key) {
				var that = this;
				that.removePiaoEditMonitor();//防止出现修改模板时id冲突
				that.removePiaoAddMonitor();//防止出现多个增加模板时id冲突
				$("#monitor-add-row").remove();
				var template = $("#monitor-add-template").html();
				var row = [];
				var div = $("#"+this.getRowId(key));
				var sub_domain = div.find('#record-name').text();
				if (sub_domain== '@') {
					sub_domain = '';
				}else {
					sub_domain +='.';
				}
				row.url = 'http://'+sub_domain+that.domain+'/';
				var el = Mustache.to_html(template, row);
				div.after(el);
				$("#monitor-add-row").find('button').eq(0).bind('click',function(){
					that.removePiaoAddMonitor();
				});
				$("#monitor-add-row").find('button').eq(1).bind('click',function(){
					that.addMonitor(key);
				});
				if($(':radio[name="action"]:checked').val()!=2){
					$("#switch_type,#switch_host").hide();
				}
				$("input[name='action']").change(function(){
					if($(this).val()!=2){
						$("#switch_type,#switch_host").hide("fast");
					}else{
						$("#switch_type,#switch_host").show("fast");
					}
				});
			};
			this.addMonitor = function(key) {
				var that = this;
				var url = $.trim($("#monitor-add-row").find('[name=url]').val());
				if (!url) {
					that.showError('监控地址不能为空',true);
					return;
				}
				var mdiv = $("#monitor-add-row");
				var content = mdiv.find('[name=content]').val();
				var time = mdiv.find('[name=interval_time]').val();
				var action = mdiv.find('[name=action]:checked').val();
				var t = mdiv.find('[name=monitor_t]:checked').val();
				var value = mdiv.find('[name=value]').val();
				var name = mdiv.find('[name=name]').val();
				var active = mdiv.find('[name=active]:checked').val();
				var weixin = mdiv.find('[name=weixin]:checked').val();
				var sms = mdiv.find('[name=sms]:checked').val();
				var email = mdiv.find('[name=email]:checked').val();
				var row = this.getRow(key);
				$.ajax({
					url:'/api/?c=monitor&a=add',
					data:{
						domain_id:that.domain,
		                record_id:row['id'],
		                url:url,
		                action:action,
		                content:content,
		                t:t,
		                value:value,
		                active:active,
		                name:name,
		                interval_time:time,
		                weixin:weixin,
		                sms:sms,
		                email:email
					},
					type:'POST',
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return;
						}
						that.showMessage(a.status.message,true);
						that.removePiaoAddMonitor();
						that.monitorAddAfter(key,{url:url,content:content,interval_time:time,action:action,monitor_t:t,monitor_value:value,name:name,active:active,monitor_id:a.monitor_id});
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
				
			};
			this.removePiaoAddMonitor = function() {
				$("#monitor-add-row").remove();
			};
			this.monitorAddAfter = function(key,monitordata) {
				this.setRow(key,'monitor', 'yes');
				this.setRow(key,'monitor_data', monitordata);
				this.renderOne(key);
			};
			this.getMonitorData = function(key) {
				var row = this.getRow(key);
				if (row['monitor_data']) {
					return row['monitor_data'];
				}
				var that = this;
				$.ajax({
					url:'/api/?c=monitor&a=getInfo',
					data:{record_id:row['id'],domain:that.domain},
					dataType:'json',
					async:false,
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return;
						}
						that.updateRecordMonitorData(key,a.info);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
				var row = this.getRow(key);
				return row['monitor_data'];
			};
			this.updateRecordMonitorData = function(key,monitor_data) {
				var that = this;
				if (monitor_data) {
					if (typeof that.recordlist[key]['monitor_data'] =='undefined') {
						that.recordlist[key]['monitor_data'] = [];
					}
					for ( var i in monitor_data) {
						that.recordlist[key]['monitor_data'][i] = monitor_data[i];
					}
				}else {
					this.recordlist[key]['monitor_data'] = monitor_data;
				}
			};
			this.piaoEditMonitor = function(key) {
				var that = this;
				that.removePiaoAddMonitor();
				that.removePiaoEditMonitor();
				var data = this.getMonitorData(key);
				data['typeA'] = '';
				data['typeAAAA'] = '';
				data['typeCNAME'] = '';
				if (data['monitor_t']=='A') {
					data['typeA'] = 'checked';
				}else if (data['monitor_t'] =='AAAA') {
					data['typeAAAA'] = 'checked';
				}else {
					data['typeCNAME'] = 'checked';
				}
				data['action1'] ='';
				data['action0'] = '';
				data['action2'] = '';
				var a = data['action'];
				data['action'+a] ='checked';
				data['active1'] = '';
				data['active0'] = '';
				var ac = data['active'];
				data['active'+ac] = 'checked';
				data['notice_weixin'] = data['notice_weixin'] ? "checked" : '';
				data['notice_sms'] = data['notice_sms'] ? 'checked' : '';
				data['notice_email'] = data['notice_email'] ? 'checked' : '';
				var template = $("#monitor-edit-template").html();
				var el = Mustache.to_html(template, data);
				$("#"+this.getRowId(key)).after(el);
				$("#monitor-edit-row").find('button').eq(0).bind('click',function(){
					that.removePiaoEditMonitor();
				});
				$("#monitor-edit-row").find('button').eq(1).bind('click',function(){
					that.editMonitor(key);
				});
				if($(':radio[name="action"]:checked').val()!=2){
					$("#switch_type,#switch_host").hide();
				}
				$("input[name='action']").change(function(){
					if($(this).val()!=2){
						$("#switch_type,#switch_host").hide("fast");
					}else{
						$("#switch_type,#switch_host").show("fast");
					}
				});
			};
			this.editMonitor = function(key) {
				var that = this;
				var url = $.trim($("#monitor-edit-row").find('[name=url]').val());
				if (!url) {
					that.showError('监控地址不能为空',true);
					return;
				}
				var div = $("#monitor-edit-row");
				var content = div.find('[name=content]').val();
				var time = div.find('[name=interval_time]').val();
				var action = div.find('[name=action]:checked').val();
				var t = div.find('[name=monitor_t]:checked').val();
				var value = div.find('[name=value]').val();
				var name = div.find('[name=name]').val();
				var active = div.find('[name=active]:checked').val();
				var weixin = div.find('[name=weixin]:checked').val();
				var sms = div.find('[name=sms]:checked').val();
				var email = div.find('[name=email]:checked').val();
				var weixinattr = div.find('[name=weixin]').attr("checked");
				var smsattr = div.find('[name=sms]').attr("checked");
				var emailattr = div.find('[name=email]').attr("checked");
				var row = this.getRow(key);
				$.ajax({
					url:'/api/?c=monitor&a=edit',
					data:{
						domain_id:that.domain,
		                record_id:row['id'],
		                url:url,
		                action:action,
		                content:content,
		                t:t,
		                value:value,
		                active:active,
		                name:name,
		                interval_time:time,
		                weixin:weixin,
		                sms:sms,
		                email:email
					},
					type:'POST',
					dataType:'json',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return;
						}
						that.showMessage(a.status.message,true);
						that.updateRecordMonitorData(key,{
							url:url,
							content:content,
							interval_time:time,
							action:action,
							monitor_t:t,
							monitor_value:value,
							name:name,
							active:active,
							notice_weixin:weixinattr,
							notice_sms:smsattr,
							notice_email:emailattr
							});
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
				that.removePiaoEditMonitor();
			};
			this.removePiaoEditMonitor = function() {
				$("#monitor-edit-row").remove();
			};
			this.piaoDelMonitor = function(key) {
				var that = this;
				var row = this.getRow(key);
				$.ajax({
					url:'/api/?c=monitor&a=del',
					data:{record_id:row['id'],domain_id:that.domain},
					dataType:'json',
					type:'POST',
					success:function(a) {
						if (a.status.code != 1) {
							that.showError(a.status.message);
							return;
						}
						that.delMonitorAfter(key);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.delMonitorAfter = function(key) {
				this.setRow(key,'monitor','');
				this.setRow(key,'monitor_data','');
				this.renderOne(key);
			};
			this.backupRecord = function(key) {
				var that = this;
				var status = 1;
				var row = this.getRow(key);
				if (row['backup'] ==1) {
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=changeBackup',
					data:{record_id:row['id'],domain:that.domain,backup:status},
					dataType:'json',
					async:false,
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							that.showError(a.status.message,true);
							return;
						} 
						that.backupAfterRender(key,status);
						that.showMessage(a.status.message,true);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.nobackupRecord = function(key) {
				var that = this;
				var status = 0;
				var row = this.getRow(key);
				if (row['backup'] != 1) {
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=changeBackup',
					data:{record_id:row['id'],domain:that.domain,backup:status},
					dataType:'json',
					async:false,
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							that.showError(a.status.message,true);
							return;
						} 
						that.backupAfterRender(key,status);
						that.showMessage(a.status.message,true);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.backupAfterRender = function(key,status) {
				this.setRow(key, 'backup', status);
				this.renderOne(key);
			};
			this.stopRecord = function(key,multi) {
				var that = this;
				var status = 'disable';
				var rowkey = key;
				var row ;
				if (multi) {
					row = this.getRow(this.selectarr[key]);
					rowkey = this.selectarr[key];
				}else {
					row = this.getRow(key);
				}
				if (row['status'] == status) {
					that.deferredStopMultiRecord(key+1);
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=status',
					data:{record_id:row['id'],domain:that.domain,status:status},
					dataType:'json',
					async:true,
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							if (multi) {
								that.multiresult.error.push(that.createRowStr(row)+':'+a.status.message);
							}else {
								that.showError(a.status.message,true);
							}
						} else {
							that.statusAfterRender(rowkey,status);
							if (multi) {
								that.multiresult.success.push(that.createRowStr(row) +':'+a.status.message);
								that.deferredStopMultiRecord(key+1);
							}else {
								that.showMessage(a.status.message,true);
							}
						}
					},
					error:function(e) {
						if (multi) {
							that.deferredStopMultiRecord(key+1);
						}
					}
				});
			};
			this.restorRecord = function(key,multi) {
				var that = this;
				var status = 'enable';
				var rowkey = key;
				var row;
				if (multi) {
					row = this.getRow(this.selectarr[key]);
					rowkey = this.selectarr[key];
				}else {
					row = this.getRow(key);
				}
				if (row['status'] ==status) {
					that.deferredRestorMultiRecord(key+1);
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=status',
					data:{record_id:row['id'],domain:that.domain,status:status},
					dataType:'json',
					async:true,
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							if (multi) {
								that.multiresult.error.push(that.createRowStr(row) +':'+a.status.message);
							}else {
								that.showError(a.status.message,true);
							}
						} else {
							that.statusAfterRender(rowkey,status);
							if (multi) {
								that.multiresult.success.push(that.createRowStr(row) +':'+a.status.message);
								that.deferredRestorMultiRecord(key+1);
							}else {
								that.showMessage(a.status.message,true);
							}
						}
						
					},
					error:function(e) {
						if (multi) {
							that.deferredRestorMultiRecord(key+1);
						}
					}
				});
			};
			this.statusAfterRender = function(key,status) {
				this.setRow(key,'status',status);
				this.renderOne(key);
			};
			this.delRecord = function(key,multi) {
				var that = this;
				var rowkey = key;
				var row;
				if (multi) {
					rowkey = this.selectarr[key];
					row = this.getRow(rowkey);
				}else{
					row = this.getRow(rowkey);
				}
				$.ajax({
					url:'/api/?c=record&a=del',
					data:{record_id:row['id'],domain:that.domain},
					dataType:'json',
					async:true,
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							if (multi) {
								that.multiresult.error.push(that.createRowStr(row) +':'+a.status.message);
							}else {
								that.showError(a.status.message,true);
							}
						} else {
							that.removeRecord(rowkey);
							if (multi) {
								that.multiresult.success.push(that.createRowStr(row) +':'+a.status.message);
								that.deferredDelMultiRecord(key+1);
							}else {
								that.showMessage(a.status.message,true);
							}
						}
						
					},
					error:function(e) {
						if (multi) {
							that.deferredDelMultiRecord(key+1);
						}
					}
				});
			};
			//发送删除调用后的处理,从列表里面删除，以及显示的的删除
			this.removeRecord = function(key) {
				$("#"+this.getRowId(key)).remove();
				this.total -= 1;
				//this.recordlist.splice(key, 1);
				//不能把这条记录从列表里把key删除，删除后将影响数据的排序，后面的数据也将乱掉。
				this.recordlist[key] = undefined;
			};
			this.stopHijack = function(key) {
				var that = this;
				var status = 0;
				var row = this.getRow(key);
				if (row['ns_protection'] < 1) {
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=changeNsprotection',
					data:{record_id:row['id'],domain:that.domain,status:status},
					dataType:'json',
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.hijackAfterRender(key,status);
						that.showMessage(a.status.message,true);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.restorHijack = function(key) {
				var that = this;
				var status = 1;
				var row = this.getRow(key);
				if (row['ns_protection']==status) {
					return;
				}
				//status=1为启用
				$.ajax({
					url:'/api/?c=record&a=changeNsprotection',
					data:{record_id:row['id'],domain:that.domain,status:status},
					dataType:'json',
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							that.showError(a.status.message,true);
							return;
						}
						that.hijackAfterRender(key,status);
						that.showMessage(a.status.message,true);
					},
					error:function(e) {
						that.showError('响应失败',true);
					}
				});
			};
			this.hijackAfterRender = function(key,ns_protection) {
				var status = ns_protection==1 ? ns_protection :'';
				this.setRow(key,'ns_protection',status);
				this.renderOne(key);
			};
			this.getTypeHtml = function(checkedvalue) {
				var value = checkedvalue ? checkedvalue :'A';
				var types = ['A','AAAA','CNAME','DNAME','MX','NS','TXT','SRV','URL'];
				var html = '';
				for ( var i in types) {
					html += '<option value="' + types[i]+'"';
					if (types[i]==value) {
						html += ' selected';
					}
					html += '>'+types[i] +'</option>';
				}
				return html;
			};
			this.getLineHtml = function(checkedvalue) {
				var value = checkedvalue ? checkedvalue :'默认';
				var html = '';
				this.getLine();
				for ( var i in this.lines) {
					html += '<option value="' + this.lines[i]+'"';
					if (this.lines[i]==value) {
						html += ' selected';
					}
					html += '>'+this.lines[i] +'</option>';
				}
				return html;
			};
			this.getLine = function() {
				var that = this;
				if (this.lines && this.lines.length > 0) {
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=getLine',
					data:{domain:that.domain},
					dataType:'json',
					async:false,
					success:function(a) {
						if (a.status.code != 1 || !a.lines) {
							//老域名的线路组不存在会导致后台给出数据出错
							that.lines = ['默认'];
							//that.showError(a.status.message,true);
							return;
						}
						that.lines = a.lines.sort();
					},
					error:function(e) {
						that.lines = ['默认'];
						that.showError('响应失败',true);
					}
 				});
			};
			this.piaoAddRecord = function() {
				var that = this;
				/*
				if ($("#record-add-row").html()) {
					return;
				}
				*/
				var key = this.piaoarr.length;
				this.showLog(key);
				this.piaoarr.push(key);
				var option = [];
				option.ttl = that.defaultTtl;
				option.key = key;
				var template = $("#record-add-template").html();
				var el = Mustache.to_html(template,option);
				if (this.listdiv.find('div').length==0) {
					this.listdiv.append(el);
				}else {
					this.listdiv.find('div').eq(0).before(el);
				}
				var adddiv = $("#record-add-row_"+key);
				adddiv.find('[name=type]').html(this.getTypeHtml());
				adddiv.find('[name=line]').html(this.getLineHtml());
				function enter(){
					var name = $.trim(adddiv.find('[name=name]').val());
					var ttl = adddiv.find('[name=ttl]').val();
					var type = adddiv.find('[name=type]').val();
					var line = adddiv.find('[name=line]').val();
					var value = $.trim(adddiv.find('[name=value]').val());
					/*
					if(type=="A"){
						var ip = /^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/;
						if(!ip.test(value)){
							that.showError('解析值格式有误','clear');return;
						}
					}
					if(type=="MX"){
						var mx = /^[0-9]+\s{1}\S/;
						if(!mx.test(value)){
							that.showError('解析值格式有误','clear');return;
						}
					}
					*/
					esc();
					that.addRecord(name,ttl,type,line,value);
				}
				function esc(){
					adddiv.remove();
					that.removeAddPrompt();
					if (that.getPiaoAddRecordLength()==0) {
						that.piaoarr.length = 0;
					}else {
						that.piaoarr[key] == undefined;
					}
				}
				adddiv.find('button#enter').bind('click', function() {
					enter();
				});
				adddiv.bind('keyup',function(event){
					var keycode = event.which;
					if (keycode == 13) {
						enter();
					}
				});
				adddiv.find('button#esc').bind('click', function() {
					esc();
				});
				adddiv.find('[name=name]').trigger('focus');
				adddiv.find('#record-name,#record-value,#record-type,#record-line,#record-ttl').bind('mouseover',function(){
					that.piaoAddPrompt($(this));
				});
			};
			this.getPiaoAddRecordLength = function() {
				return $("[data-type=add]").length;
			};
			this.removeAddPrompt = function() {
				$("#add-prompt").remove();
			};
			this.getPromptDiv = function() {
				//一定会有一个,找到第一个添加的行
				for ( var i=0;i<=this.piaoarr.length;i++) {
					if (this.piaoarr[i]==undefined) {
						continue;
					}
					if ($("#record-add-row_"+i).html()) {
						return $("#record-add-row_"+i);
					}
				}
			};
			this.piaoAddPrompt = function(obj) {
				var id = obj.attr('id');
				var template = $("#prompt-"+id+'-template').html();
				if (!template) {
					return;
				}
				//var adddiv = $("#record-add-row_"+max);
				var adddiv = this.getPromptDiv();
				$("#add-prompt").remove();
				var div = '<div id="add-prompt" class="record clearfix"></div>';
				adddiv.after(div);
				var promptdiv = $("#add-prompt");
				var option = [];
				option.name = this.domain;
				option.nsname = this.nsname;
				option.panelname = this.panelname;
				var el = Mustache.to_html(template,option);
				promptdiv.html(el);
			};
			this.addRecord = function(name,ttl,type,line,value,addkey) {
				var that = this;
				if (addkey != undefined) {
					if (!that.multidiv.find("#import-record-"+addkey).find('input').attr('checked')){
						that.deferredImportRecord(addkey+1);
						return ;
					}
					var row = that.addarr[addkey];
					name = row['name'];
					ttl = row['ttl'];
					type = row['type'];
					line = '默认';
					value = row['value'];
					if (!this.checkName(type, name)) {
						that.multiresult.error.push(name + ':主机名称错误');
						that.deferredImportRecord(addkey+1);
						return ;
					}
				}else {
					ttl = ttl> 0 ? ttl : that.defaultTtl;
					if (!value) {
						this.showError('解析记录值不能为空',true);
						return ;
					}
					if (!this.checkName(type, name)) {
						this.showError('主机名称错误');
						return ;
					}
					value = this.checkValue(type,value);
					name = name ? name :'@';
				}
				$.ajax({
					url:'/api/?c=record&a=add',
					data:{domain:that.domain,sub_domain:name,ttl:ttl,record_type:type,record_line:line,value:value},
					dataType:'json',
					type:'POST',
					async:true,
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							if (addkey != undefined) {
								that.multiresult.error.push(name + ':'+a.status.message);
								that.deferredImportRecord(addkey+1);
							}else {
								that.showError(a.status.message,true);
							}
							return;
						}
						that.total += 1;
						that.renderPageCount();
						var option = [];
						option.name = a.record.name;
						option.id = a.record.id;
						option.value = value;
						option.type =  type;
						option.line = line;
						option.ttl = ttl;
						option.monitor_enable = a.record.monitor_enable;
						option.status = 'enable';
						option.cdn = 0;
						option.cdnSiteStatus = that.cdn_site_status;
						that.renderOne(that.addRow(option));
						if (addkey != undefined) {
							that.multiresult.success.push(name + ':'+a.status.message);
							that.deferredImportRecord(addkey+1);
						}else {
							that.showMessage(a.status.message,true);
						}
					},
					error:function(e) {
						if (addkey != undefined) {
							that.deferredImportRecord(addkey+1);
						}
					}
				});
			};
			this.loadComplete = function() {
				$("#error-message").html('');
			};
			this.loading = function(width) {
				$("#error-message").html('<img src="/style/busy.gif">');
			};
			this.showError = function(message, clear) {
				var that = this;
				this.errordiv.html(message).append('&nbsp;&nbsp;<a href="javascript:;" id="closea"><i class="icon-remove"></i></a>').removeClass('alert-success').addClass('alert alert-error');
				if (clear) {
					setTimeout(function() {
						that.errordiv.html('').removeClass('alert alert-success alert-error');
					}, 4000);
				}
				that.errordiv.find('#closea').bind('click',function(){
					that.errordiv.html("").removeClass('alert alert-success').removeClass('alert-error');
				});
			};
			this.createRowStr = function(row) {
				return row['name'] + ' ' + row['type'] + ' ' + row['line'];
			};
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
			};
			this.selectAll = function(checked,norender) {
				if (this.searchlist.length > 0) {
					for ( var i in this.searchlist) {
						var row = this.getRow(this.searchlist[i]);
						if (row == undefined) {
							continue;
						}
						if (row['hold']) {
							continue;
						}
						row['checked'] = checked;
					}
					this.renderSearch(this.searchlist);
					return;
				}
				for ( var i in this.recordlist) {
					if (this.recordlist[i]==undefined) {
						continue;
					}
					if (this.recordlist[i]['hold']) {
						continue;
					}
					this.recordlist[i]['checked'] = checked;
				}
				if (norender) {
					return;
				}
				this.render(this.recordlist);
			};
			this.piaoMultiDelConfrim = function() {
				var that = this;
				var select = [];
				for ( var i in this.recordlist) {
					if (this.recordlist[i]==undefined) {
						continue;
					}
					if (this.recordlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					this.showError('请选中记录',true);
					return;
				}
				var template = $("#multi-del-confirm-template").html();
				var option = [];
				option.content = '确认要删除选中的 '+select.length + ' 条记录吗?';
				option.title = '批量删除确认';
				var el =  Mustache.to_html(template,option);
				$("body").append(el);
				//need edit bootstrmp-modal.js model.hideModal.hide() to remove();
				var piao = $("#confirm-modal");
				var modal = piao.modal(option);
				piao.find('#esc').bind('click',function(){
					piao.modal('hide');
					piao.modal('removeBackdrop');
				});
				piao.find('#enter').bind('click',function(){
					piao.modal('hide');
					piao.modal('removeBackdrop');
					openCloseBg('open');
					that.delMultiRecord();
				});
			};
			
			this.delMultiRecord = function() {
				var select = [];
				this.multiresult.empty();
				this.selectarr.length = 0;
				for ( var i in this.recordlist) {
					if (this.recordlist[i]==undefined) {
						continue;
					}
					if (this.recordlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					this.showError('请选中记录',true);
					return;
				}
				this.multidelli.button('loading');
				this.selectarr = select;
				this.deferredDelMultiRecord(0);
			};
			this.deferredDelMultiRecord = function(selectkey,complete) {
				if (selectkey == this.selectarr.length || complete) {
					openCloseBg('close');
					this.multidelli.button('reset');
					this.showMultiResult();
					this.selectarr.length = 0;
					return ;
				}
				this.delRecord(selectkey,true);
			};
			this.restorMultiRecord = function() {
				var select = [];
				this.multiresult.empty();
				this.selectarr.length = 0;
				for ( var i in this.recordlist) {
					if (this.recordlist[i]==undefined) {
						continue;
					}
					if (this.recordlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					this.showError('请选中记录',true);
					return;
				}
				this.selectarr = select;
				this.multirestorli.button('loading');
				openCloseBg('open');
				this.deferredRestorMultiRecord(0);
			};
			this.deferredRestorMultiRecord = function(selectkey,complete) {
				if (selectkey == this.selectarr.length || complete) {
					openCloseBg('close');
					this.multirestorli.button('reset');
					this.showMultiResult();
					this.selectarr.length = 0;
					return ;
				}
				this.restorRecord(selectkey,true);
			};
			
			this.stopMultiRecord = function() {
				var select = [];
				this.multiresult.empty();
				for ( var i in this.recordlist) {
					if (this.recordlist[i]==undefined) {
						continue;
					}
					if (this.recordlist[i]['checked']) {
						select.push(i);
					}
				}
				if (select.length < 1) {
					this.showError('请选中记录',true);
					return;
				}
				this.selectarr = select;
				this.multistopli.button('loading');
				//初始都是0
				this.deferredStopMultiRecord(0);
			};
			this.deferredStopMultiRecord = function(selectkey,complete) {
				if (selectkey == this.selectarr.length || complete) {
					this.multistopli.button('reset');
					this.showMultiResult();
					this.selectarr.length = 0;
					return ;
				}
				this.stopRecord(selectkey,true);
			};
			this.piaoAddMultiRecord = function() {
				if ($("#record-add-multi").html()) {
					return;
				}
				var that = this;
				var template = $("#record-add-multi-template").html();
				var row = [];
				row.ttl = that.defaultTtl;
				var el = Mustache.to_html(template,row);
				this.multidiv.html(el).show();
				this.multidiv.find('select').eq(0).html(this.getTypeHtml());
				this.multidiv.find('select').eq(1).html(this.getLineHtml());
				this.multidiv.find('button').eq(1).bind('click',function() {
					that.addMultiRecord();
				});
				this.multidiv.find('button').eq(0).bind('click',function() {
					that.hideMultidiv();
				});
			};
			this.hideMultidiv = function() {
				this.multidiv.html("").hide();
			};
			this.addMultiRecord = function() {
				var that = this;
				this.multiresult.empty();
				
				var replacechecked = this.multidiv.find('[name=replace]').attr('checked');
				var replace = replacechecked ? 1 : 0;
				var type = this.multidiv.find('[name=record_type]').val();
				var line = this.multidiv.find('[name=record_line]').val();
				var ttl = this.multidiv.find('[name=ttl]').val();
				ttl = ttl > 0 ? ttl : that.defaultTtl;
				var values = $.trim(this.multidiv.find('[name=values]').val());
				if (!values) {
					this.showError("解析名称和记录值不能为空", true);
					return;
				}
				//清空已存在的数据
				that.multiarr.length = 0;
				this.multidiv.find('#enter').button('loading').attr('disabled','disabled');
				var rows = values.split("\n");
				for ( var i in rows) {
					var len = rows[i].indexOf(' ');
					if (len < 0) {
						continue;
					}
					var name = rows[i].substr(0,len);
					var value = rows[i].substr(len+1);
					var row = [];
					row['name'] = name;
					row['value'] = value;
					row['type'] = type;
					row['line'] = line;
					row['ttl'] = ttl;
					row['replace'] = replace;
					//row['cb_doamin_id'] = 0;
					//row['cdnSiteStatus'] = that.cdn_site_status;
					that.multiarr.push(row);
				}
				this.deferredAddMultiRecord(0);
			};
			this.deferredAddMultiRecord = function(arrkey,complete) {
				var that = this;
				var complete = false;
				if (arrkey == this.multiarr.length || complete) {
					this.multidiv.find('#enter').button('reset');
					that.hideMultidiv();
					this.showMultiResult();
					that.multiarr.length = 0;
					return;
				}
				that.addOneRecord(arrkey);
			};
			this.addOneRecord = function(arrkey) {
				var that = this;
				var row = this.multiarr[arrkey];
				if (!row) {
					this.deferredAddMultiRecord(0,true);
					return;
				}
				if (!this.checkName(row['type'],row['name'])) {
					this.deferredAddMultiRecord(addkey+1);
					that.multiresult.error.push(name +':主机名称错误');
					return;
				}
				$.ajax({
					url:'/api/?c=record&a=add',
					data:{
						domain_id:that.domain,
						sub_domain:row['name'],
						value:row['value'],
						replace:row['replace'],
						ttl:row['ttl'],
						record_type:row['type'],
						record_line:row['line']
					},
					dataType:'json',
					async:true,
					type:'POST',
					success:function(a) {
						if (parseInt(a.status.code) != 1) {
							//that.showError(a.status.message,true);
							that.multiresult.error.push(name +':'+a.status.message);
						}else {
							that.total += 1;
							var option = [];
							option.name = a.record.name;
							option.id = a.record.id;
							option.value = row['value'];
							option.type =  row['type'];
							option.line = row['line'];
							option.ttl = row['ttl'];
							option.monitor_enable = a.record.monitor_enable;
							option.status = 'enable';
							option.cb_domain_id = 0;
							option.cdnSiteStatus = that.cdn_site_status;
							that.renderOne(that.addRow(option));
							that.multiresult.success.push(name +':'+a.status.message);
						}
						that.deferredAddMultiRecord(arrkey+1);
					},
					error:function(e) {
						that.deferredAddMultiRecord(arrkey+1);
					}
				});
			};
			//分页了后台搜索
			this.search = function(event) {
				this.searchlist.length = 0;
				$('#record-select-all').attr('checked',false);
				var searchvalue = $.trim($("#from-search").find('#search-input').val());
				if (this.keyword != '' && this.keyword != searchvalue) {
					this.keyword = searchvalue;
					this.getRecordList(0);
					return;
				}
				
				//如果总数大于当前页显示数，则去后台取数据
				if (this.all_total > this.pagecount) {
					this.keyword = searchvalue;
					this.getRecordList(0);
					return;
				}
				//搜索为空，重新展示页面
				this.keyword = '';
				if (!searchvalue) {
					if (this.all_total > this.total) {
						this.getRecordList(0);
						return;
					}
					//将选中状态取消，并重新展示页面,如果第二个参数为true,则不展示页面
					this.selectAll('');
					return;
				}
				//在当前页搜索
				//如果之前已经选中的，需要将选中删除。否则影响搜索后的结果
				this.selectAll('',true);
				this.searchLocal(searchvalue);
			};
			this.searchLocal = function(searchvalue) {
				var list = [];
				var len = searchvalue.length;
				for ( var i in this.recordlist) {
					if (this.recordlist[i]==undefined) {
						continue;
					}
					if (this.recordlist[i]['name'].substr(0,len)==searchvalue ||  this.recordlist[i]['value'].substr(0,len)==searchvalue) {
						list.push(i);
					}
				}
				this.renderSearch(list);
			};
			
			this.renderPage = function() {
				this.renderPageCount();
				var that = this;
				var template = $("#record-page-li-template").html();
				$("#record-page-div").find('li').remove();
				var pages = this.getPages();
				if ($(pages).length ==0) {
					return;
				}
				for ( var i in pages) {
					var option = [];
					option['pagename'] = i;
					option['page'] = pages[i];
					var el = Mustache.to_html(template,option);
					$("#record-page-div").append(el);
				}
				$("#record-page-div").find('a').bind('click',function() {
					that.changePage($(this).attr('href'));
				});
			};
			this.getPages = function() {
				var page = new Page(this.total,this.pagecount);
				return page.getPagecount(this.page);
			};
			this.changePage = function(href) {
				var that = this;
				that.page = href.substr(1);
				that.getRecordList(that.page);
				that.renderPage();
			};
			this.renderPageCount = function() {
				var that = this;
				var pagecounts = this.getPageCount();
				var template = $("#record-page-count-template").html();
				var option = [];
				option.countstart = (this.page) * this.pagecount + 1;
				option.countend = (this.page +1) * this.pagecount;
				option.total = this.total;
				var el = Mustache.to_html(template,option);
				$("#record-pagecount-div").html(el);
				var litemplate = $("#record-page-count-li-template").html();
				for ( var i in pagecounts){
					var data = [];
					data.pagecount = pagecounts[i];
					var el =  Mustache.to_html(litemplate,data);
					$("#record-pagecount-ul").append(el);
				}
				$("#record-pagecount-ul").find('a').bind('click',function(){
					that.changePagecount($(this).attr('data-pagecount'));
				});
			};
			this.changePagecount = function(pagecount) {
				var that = this;
				that.pagecount = pagecount;
				that.getRecordList(this.page);
			};
			this.getPageCount = function() {
				var pagecount = [50,200,1000,5000];
				for ( var i in pagecount) {
					if (this.pagecount == pagecount[i]) {
						pagecount.splice(i,1);
						break;
					}
				}
				return pagecount;
			};
			this.piaoImportRecord = function() {
				var that = this;
				this.importdiv.button('loading');
				this.multidiv.html('<span class="offset2"><img src="/style/busy.gif"></span>').show();
				$("#import_multi_record").attr('disabled','disabled');
				$.getJSON('/public/?c=tools&a=scanrecord&domain='+that.domain+'&callback=?',function(a){
					var lists = [];
					if (typeof a =='object') {
						for ( var i in a) {
							var row = [];
							row['name'] = a[i][0];
							row['type'] = a[i][1];
							row['ttl'] = a[i][2];
							row['value'] = a[i][3];
							lists.push(row);
						}
					}
					that.addarr = lists;
					that.showImportList();
				});
			};
			this.showImportList = function() {
				var that = this;
				this.importdiv.button('reset');
				if (that.addarr.length==0) {
					that.hideMultidiv();
					$("#import_multi_record").attr('disabled',false);
					this.showError('没有找到记录',true);
					return;
				}
				this.multidiv.html('').show();
				var template = $("#import-list-li-template").html();
				for ( var i in that.addarr) {
					that.addarr[i]['key'] = i;
					var el =  Mustache.to_html(template,that.addarr[i]);
					that.multidiv.append(el);
				}
				var operatrowhtml = "<div class='record clearfix' style='margin:0 0 0 -1px'>";
				operatrowhtml += "<span class='record-checkbox'>&nbsp;</span>";
				operatrowhtml += "<span class='record-name'>&nbsp;</span>";
				operatrowhtml += '<span class="record-type">&nbsp;</span>';
				operatrowhtml += '<span class="record-line">&nbsp;</span>';
				operatrowhtml += "<span class='record-value'><button class='btn btn-primary' id='enter' data-loading-text='正在执行..'>确定</button>&nbsp;<button class='btn btn-primary'>取消</button></span>";
				operatrowhtml += '<span class="record-ttl">&nbsp;</span>';
				operatrowhtml += '<span class="record-operat">&nbsp;</span>';
				operatrowhtml += '<span class="record-monitor">&nbsp;</span>';
				operatrowhtml += "</div>";
				
				this.multidiv.append(operatrowhtml);
				this.multidiv.find('button').eq(0).bind('click',function(){
					$("#import_multi_record").attr('disabled',false);
					that.importRecord();
				});
				this.multidiv.find('button').eq(1).bind('click',function(){
					$("#import_multi_record").attr('disabled',false);
					that.hideMultidiv();
				});
			};
			this.importRecord = function() {
				var that = this;
				if (that.addarr.length==0) {
					that.hideMultidiv();
					return;
				}
				this.multiresult.empty();
				this.multidiv.find("#enter").button('loading').attr('disabled','disabled');
				/*
				for ( var i in data) {
					if (that.multidiv.find("#import-record-"+i).find('input').attr('checked')) {
						that.addRecord(data[i]['name'], data[i]['ttl'],data[i]['type'], '默认', data[i]['value'],true);
					}
				} 
				*/
				this.deferredImportRecord(0);
			};
			this.deferredImportRecord = function(addkey) {
				var that = this;
				if (addkey == that.addarr.length) {
					that.hideMultidiv();
					this.showMultiResult();
					return;
				}
				that.addRecord(null, null,null,null,null,addkey);
			};
			this.piaoAddSubdomain = function() {
				var that = this;
				var template = $("#add-subdomain-template").html();
				var el = Mustache.to_html(template);
				this.multidiv.html(el).show();
				var div = $("#add-subdomain");
				div.find('[name=values]').trigger('focus');
				div.find('#esc').bind('click',function(){
					that.hideMultidiv();
				});
				div.find('#enter').bind('click',function(){
					that.addSubdomain(div.find('[name=values]').val().trim());
				});
			};
			this.piaoExportContent = function(){
				var that = this;
				window.location = "/api/?c=record&a=exportContent&domain="+that.domain;
			};
			this.addSubdomain = function(values) {
				if (!values) {
					return;
				}
				var rows = values.split("\n");
				this.multiresult.empty();
				var div = $("#add-subdomain");
				div.find('#enter').button('loading').attr('disabled','disabled');
				this.addarr.length = 0;
				for ( var i in rows) {
					if (rows[i].trim()=='') {
						break;
					}
					this.addarr.push(rows[i]);
				}
				this.deferredAddSubdomain(0);
			};
			//complete通知是否已完成
			this.deferredAddSubdomain = function(addkey,complete) {
				if (addkey == this.addarr.length || complete) {
					this.showMultiResult();
					this.hideMultidiv();
					this.addarr.length = 0;
					return ;
				}
				this.addOneSubdomain(addkey);
			};
			this.addOneSubdomain = function(addkey) {
				var name = this.addarr[addkey];
				if (!name) {
					this.deferredAddSubdomain(0,true);
					return ;
				}
				var that = this;
				$.ajax({
					url:'/api/?c=record&a=addSubdomain',
					data:{domain:that.domain,name:name},
					dataType:'json',
					async:true,
					success:function(a) {
						if (a.status.code != 1) {
							that.multiresult.error.push(name + ':' + a.status.message);
						}else {
							that.multiresult.success.push(name + ':' + a.status.message);
						}
						that.deferredAddSubdomain(addkey+1);
					},
					error:function(e) {
						that.deferredAddSubdomain(addkey+1);
					}
				});
				
			};
			this.showMultiResult = function() {
				var message = '';
				message += '成功: '+ this.multiresult.get('success').length + ' 个';
				message += '&nbsp;';
				message += '失败:' + this.multiresult.get('error').length + ' 个';
				message += '&nbsp;';
				message += '<a href="javascript:;" id="show_multia">详细</a>';
				this.showMessage(message);
			};
			this.showAllMultiMessage = function() {
				var message = '';
				var s = this.multiresult.get('success');
				for (var i in s ) {
					message += s[i]+'<br>';
				}
				var e = this.multiresult.get('error');
				for ( var i in e) {
					message += e[i];
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
			};
			this.showLog = function(message) {
				if (typeof console != 'undefined') {
					console.log(message);
				}
			};
			this.multiresult = {};
			this.multiresult.error = [];
			this.multiresult.success = [];
			this.multiresult.get = function(type) {
				if (type =='error') {
					return this.error;
				}
				return this.success;
			};
			this.multiresult.empty = function() {
				this.error.length = 0;
				this.success.length = 0;
			};
			//;记录高级设置
			this.recordHeightSet = function(div,key){
				var that = this;
				var record = that.getRow(key);
				var template = $("#height-set-template").html();
				if(div.find("#height-set-span").html()){
					template = $("#height-set-ref-template").html();
				}
				if(div.find("#height-set-span").html()){
					div.find("#height-set-span").html(template);
				}else{
					div.html(template);
				}
				var heightspan = div.find("#height-set-span");
				heightspan.find("#down").bind('click',function(){
					heightspan.html('<a href="javascript:;" id="zhdc">高级</a>');
					that.recordHeightSetDown(div, key);
				});
				var checkHeightColor = function(record,rkey,id){
					if (record[rkey]) {
						heightspan.find("#"+id).attr('data-original-title','点击关闭').css('color','green');
					}
				};
				checkHeightColor(record,'height_cf','cf');
				checkHeightColor(record,'height_ho','ho');
				checkHeightColor(record,'height_cb','cb');
				checkHeightColor(record,'height_th','th');
				checkHeightColor(record,'height_tc','tc');
				checkHeightColor(record,'height_sh','sh');
				var heightSpanBind = function(id,rkey,setkey){
					heightspan.find("#"+id).bind({
						'click':function(){
							var status = 1;
							if(record[rkey]){
								status = 0;
							}
							that.nsHeightSet(setkey, status,key,div);
						},
						'mouseover':function(){$(this).tooltip('show');}
					});
				};
				heightSpanBind('cf','height_cf','cf');
				heightSpanBind('ho','height_ho','ho');
				heightSpanBind('cb','height_cb','cb');
				heightSpanBind('th','height_th','th');
				heightSpanBind('tc','height_tc','tc');
				heightSpanBind('sh','height_sh','sh');
			};
			this.recordHeightSetDown = function(div,key){
				var that = this;
				div.find("#height-set-span").find("#zhdc").bind('click',function(){
					that.recordHeightSet(div, key);
				});
			};
			this.nsHeightSet = function(name,status,key,div){
				var that = this;
				var record = that.getRow(key);
				var recordid = record['id'];
				$.ajax({
					url:'/api/?c=record&a=nsHeightSet',
					data:{name:name,recordid:recordid,status:status},
					dataType:'json',
					success:function(a){
						if(a.status.code != 1){
							that.showError('设置失败',true);
							return;
						}
						if(status){
							div.find("#height-set-span").find("#"+name).css('color','green');
							record['height_'+name] = 'yes';
							div.find("#height-set-span").find("#"+name).attr('data-original-title','点击关闭');
						}else{
							div.find("#height-set-span").find("#"+name).css('color','#E9967A');
							record['height_'+name] = null;
							div.find("#height-set-span").find("#"+name).attr('data-original-title','点击开启');
						}
						
					},
					error:function(a){
						that.showError('响应失败',true);
					}
				});
			};
			//记录分类显示
			this.recordClassify = function(type){
				if (type == '') {
					this.render(this.recordlist);
					return;
				}
				var selectArr = [];
				for(var i in this.recordlist){
					switch (type) {
					case "CNAME":
						if (this.recordlist[i]['type'] == type) {
							selectArr.push(i);
						}
						break;
					case "A":
						if (this.recordlist[i]['type'] == "A" || this.recordlist[i]['type'] == "AAAA") {
							selectArr.push(i);
						}
						break;
					case "unite":
						if(this.recordlist[i]['name'] == '@' || this.recordlist[i]['name'] == 'www') {
							selectArr.push(i);
						}
						break;
					case "analyses_start":
						if (this.recordlist[i]['status'] == 'enable') {
							selectArr.push(i);
						}
						break;
					case "analyses_pause":
						if (this.recordlist[i]['status'] == 'disable') {
							selectArr.push(i);
						}
						break;
					case "standby":
						if (this.recordlist[i]['backup'] == 1) {
							selectArr.push(i);
						}
						break;
					case "start":
						if (this.recordlist[i]['backup'] == 0) {
							selectArr.push(i);
						}
						break;
					case "standby_record":
						if (this.recordlist[i]['remark'] != null) {
							selectArr.push(i);
						}
						break;
					}
				}
				this.renderSearch(selectArr);
			};
		};
		var record = new RecordClass();
		record.getInfo(iscdn,isadmin);
	});