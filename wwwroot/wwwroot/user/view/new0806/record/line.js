var lines = function() {
	this.domain = '';
	this.pname = '免费版';
	this.diy_view = '';
	this.linelist = [];
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
					that.diy_view = a.domain.diy_view;
					that.renderAdd();
					that.getList();
				},
				error:function(e) {
					that.showError('后台数据出错'+e.responseText);
				}
			});
	}
	this.renderLoginError = function() {
		var template = $("#line-nologin-template").html();
		$("#line-list-row").append(template);
	}
	this.render = function(rows) {
		$("#domain_name_show").html(this.domain);
		$("#domain_pname_show").html(this.pname).parent('a').attr('href','?c=product&a=index&domain='+this.domain);
		if (rows.length < 1) {
			return;
		}
		for ( var i in rows) {
			this.renderOne(rows[i]);
		}
	}
	/*
	row.id && row.name
	 */
	this.renderOne = function(row) {
		var that = this;
		var template = $("#line-show-row-template").html();
		row.rowid = 'div' + row['id'];
		var el = Mustache.to_html(template, row);
		$("#line-list-row").append(el);
		$("#" + row.rowid).find('button').eq(0).bind({
			click : function() {
				that.piaoLineEdit(row.rowid)
			},
			mouseover : function() {
				$(this).addClass('btn-primary');
			},
			mouseout : function() {
				$(this).removeClass('btn-primary');
			}
		});
		$("#" + row.rowid).find('button').eq(1).bind({
			click : function() {
				that.piaoLineDel(row.rowid)
			},
			mouseover : function() {
				$(this).addClass('btn-danger');
			},
			mouseout : function() {
				$(this).removeClass('btn-danger');
			}
		});
	}
	this.piaoLineDel = function(rowid) {
		var that = this;
		var name = $("#" + rowid).find('span').eq(0).text();
		var id = rowid.substr(3);
		$.ajax({
			url : '/api/?c=line&a=del',
			data : {
				domain : that.domain,
				id : id
			},
			dataType : 'json',
			success : function(a) {
				if (a.status.code != 1) {
					that.showError(a.status.message, true);
					return;
				}
				$("#" + rowid).remove();
				for ( var i in that.linelist) {
					if (i == id) {
						that.linelist.splice(i, 1);
					}
				}
			}
		});
	}
	this.piaoLineEdit = function(rowid) {
		var that = this;
		var id = rowid.substr(3);
		$.ajax({
			url : '/api/?c=line&a=getInfo',
			data : {
				id : id,
				domain : that.domain,
			},
			dataType : 'json',
			success : function(a) {
				if (a.status.code != 1) {
					that.showError(a.status.message, true);
					return;
				}
				$("#line-add").find('[name=name]').val(a.info['name']).attr('disabled', true);
				$("#line-add").find('[name=ips]').val(a.info['ips']);
				$("#line-add").find('button').unbind();
				$("#line-add").find('button').eq(0).text('修改');
				$("#line-add").find('button').eq(0).bind('click', function() {
					that.lineEdit(rowid);
				});
				$("#line-add").find('button').eq(1).bind('click', function() {
					that.escEdit();
				});
			}
		});
	}
	this.lineEdit = function(rowid) {
		var that = this;
		var id = rowid.substr(3);
		var newips = $("#line-add").find('[name=ips]').val();
		$.ajax({
			url : '/api/?c=line&a=editIps',
			data : {
				id : id,
				domain : that.domain,
				ips : newips
			},
			type:'POST',
			dataType : 'json',
			success : function(a) {
				if (a.status.code != 1) {
					that.showError(a.status.message, true);
					return;
				}
				that.escEdit();
				that.showMessage(a.status.message, true);
				return;
			},
			error : function(e) {

			}
		});
	}
	this.showError = function(message, clear) {
		$("#error-message").html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass(
				'alert-success').addClass('alert alert-error');
		if (clear) {
			setTimeout(function() {
				$("#error-message").html('').removeClass('alert alert-success alert-error');
			}, 4000);
		}
		$("#error-message").find('a').bind('click', function() {
			$("#error-message").html("").removeClass('alert alert-success').removeClass('alert-error');
		});
	}
	this.showMessage = function(message, clear) {
		$("#error-message").html(message).append('&nbsp;&nbsp;<a href="#"><i class="icon-remove"></i></a>').removeClass(
				'alert-error').addClass('alert alert-success');
		;
		if (clear) {
			setTimeout(function() {
				$("#error-message").html('').removeClass('alert alert-success alert-error');
			}, 4000);
		}
		$("#error-message").find('a').bind('click', function() {
			$("#error-message").html("").removeClass('alert alert-success alert-error');
		});
	}
	this.getList = function() {
		var that = this;
		if (this.diy_view != 'yes') {
			return;
		}
		$.ajax({
			url : '/api/?c=line&a=getList',
			data : {
				domain : that.domain
			},
			dataType : 'json',
			async : false,
			success : function(a) {
				if (a.status.code != 1) {
					that.showError(a.status.message, true);
					return;
				}
				for ( var i in a.views) {
					that.linelist[a.views[i]['id']] = a.views[i];
				}
				that.render(that.linelist);
			},
			error : function(e) {
			}
		});
	}
	this.escEdit = function() {
		$("#line-add").remove();
		this.renderAdd();
	}
	this.renderAdd = function() {
		var that = this;
		if (this.diy_view != 'yes') {
			var template = $("#line-accessdeny-template").html();
			$("#line-add-row").html(template);
			return;
		}
		var template = $("#line-add-template").html();
		$("#line-add-row").html(template);
		$("#line-add").find('button').eq(0).bind('click', function() {
			that.addLine();
		});
		$("#line-add").find('button').eq(1).bind('click', function() {
			that.escAdd();
		});
	}
	this.escAdd = function() {
		$("#line-add").find('[name=name]').val("");
		$("#line-add").find('[name=ips]').val("");
	}
	this.addLine = function() {
		var that = this;
		var name = $.trim($("#line-add").find('[name=name]').val());
		var ips = $.trim($("#line-add").find('[name=ips]').val());
		if (!name) {
			this.showError('线路名称不能为空', true);
			return;
		}
		$.ajax({
			url : '/api/?c=line&a=add',
			data : {
				line_name : name,
				line_ips : ips,
				domain : that.domain
			},
			type:'POST',
			dataType : 'json',
			success : function(a) {
				if (a.status.code != 1) {
					that.showError(a.status.message, true);
					return;
				}
				that.linelist[a.info.id] = a.info;
				that.renderOne(a.info);
				that.escAdd();
			},
			error : function(e) {

			}
		});
	}
}
$(document).ready(function() {
	var line = new lines();
	line.getInfo();
	$("#record-operat").find('#line').find('a').addClass('cur');
	$("#nav_domain").addClass("nav_domain");
});