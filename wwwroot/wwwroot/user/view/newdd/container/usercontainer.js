$(document).ready(function(){
	 if(lastaddname){
		 $("#main").find('li').eq(0).addClass("active");
		 $("#main").find('#used').addClass("active");
	 }else if(unusedcontainer.length>0){
		 $("#main").find('li').eq(1).addClass("active");
		 $("#main").find('#unused').addClass("active");
		 $("#main").find('#unused').find("tbody tr").eq(0).find('a').popover('show');
	 }else{
		 $("#main").find('li').eq(0).addClass("active");
		 $("#main").find('#used').addClass("active");
	 }
	 for(var i in usedcontainer){
		 rending(usedcontainer[i]['id']);
		 if(usedcontainer[i]['name'] == lastaddname){
			 intro(usedcontainer[i]['id']);
		 }
		 continue;
	 }
});
/*var arr = [];///我自己做的粗糙的引导
var i =0;
function showdirection(id){
	 var tr =  $("#used").find("#tr" +id);
	 tr.find('td').eq(0).popover({
		  title:'容器名称',
	      placement:'top',
	      animation:true,
	      html:true,
	      container:'body',
	      content:"点击，即可进入该容器域名，数据库等设置"
	   });
	 arr.push('0');
	  tr.find('td').eq(7).popover({
		  title:'容器状态',
	      placement:'top',
	      html:true,
	      animation:true,
	      container:'body',
	      content:"1.“正在创建中”--容器正在创建，请等待并刷新页面；2."
	   });
	  arr.push('7');
	 var  inval = setInterval("popover("+id+")",3000);
	  if(i == arr.length){
			clearInterval(intval);
		}
}
function popover(id){
	 var tr =  $("#used").find("#tr" +id);
	 tr.find('td').popover('hide');
	 tr.find('td').removeClass("show");
	 tr.find('td').eq(arr[i]).popover('show');
	 tr.find('td').eq(arr[i]).addClass("show");
	 i++;
}*/
var mirro = [];
function submit(id){
	var div = $("#tr"+id);
	var months =  parseInt(div.find("input[name=months]").val());
	$.ajax({
		url:'?c=containerproduct&a=buy',
		type:'POST',
		data:{pid:id,months:months},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			window.location.href = "?c=containerproduct&a=usercontainer";
		},
		error:function(a){
			alert("error");
		}
	});
}
function piaoCreateContainer(id){
	if($("#unused").find("#addcontainer").length>0){
		$("#unused").find("#addcontainer").remove();
	}
	var tem = $("#create-container-template").html();
	$("#unused").find("#tr"+id).after(tem);
	var div = $("#unused").find("#addcontainer");
	div.find("#esc").bind('click',function (){
		div.remove();
	});
   div.find("#enter").bind('click',function (){
		 createContainer(id,div);
	});
	getImages();
}
function createContainer(id,div){
	var name = div.find('input[name=name]').val();
	if(!name){
		alert('请输入容器名称');
		return;
	}
	var selectop = div.find('option:selected');
	var custom = false;
	var action="add";
	if(selectop.attr("data-custom") == 1){
		custom = true;
		action = "customAdd"
	}
	data = {};
	if(custom == false){
		data.image =  selectop.val();
		data.imageid =  selectop.attr("data-id");
	}else{
		data.image =  selectop.val();
		data.cmd =  selectop.attr("data-cmd");
	}
	data.id = id;
	data.name = name;
	$.ajax({
		url:'?c=container&a=' +action ,
		type:'POST',
		data:data,
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			window.location.href = "?c=containerproduct&a=usercontainer&lastaddname="+name;
		},
		error:function(a){
			alert("error");
		}
	});
}
function getImages(){
	if(mirro.length>0){
		renderImage();
		return;
	}
	$.ajax({
		url:'?c=container&a=getImages',
		type:'POST',
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			mirro = a.rows;
			renderImage();
		},
		error:function(a){
			alert("error");
		}
	});
}
function renderImage(){
	var rows = mirro;
	var html = '<select name="images">';
	var custom = false;
	for (var i  =0;i<rows.length;i++){
		if(rows[i] ==null){
			custom = true;
			continue;
		}
		if(custom == false){
			html += "<option  data-index='"+i+"' value='"+rows[i]['name']+"' data-id='"+rows[i]['id']+"'>"+rows[i]['name']+"</option >"
		}else{
			html += "<option data-index='"+i+"'  data-custom='1' value='"+rows[i]['name']+"' data-cmd='"+rows[i]['cmd']+"'>自定义： "+rows[i]['name']+"</option >"
		}
	}
	html += '</select>';
	var div = $("#unused").find("#addcontainer");
	div.find("#images").html(html);
	div.find("#info").find("span").html(rows[0]['mem']);
	div.find('select[name=images]').change(function(){
	     var index = div.find("option:selected").attr('data-index');
	    var image = rows[index];
	    if(image){
	    	div.find("#info").find("span").html(image['mem']);
	    }
	});
}

function rending(id){
	var tr =  $("#used").find("#tr" + id)
	var name = tr.attr("data-name")
	$.ajax({
		url:"?c=container&a=createStatus",
		data:{name:name},
		async:false,
		dataType:"json",
		success:function(a){
			if(a.status.code == 2){
				tr.find("#createstatus").html("<span class='label label-important'  title='请用户过段时间主动刷新'>正在创建</span><img  title='创建中' src='/style/busy.gif' alt='创建中'>");
				return;
			}
			if(a.status.code == 4){
				tr.find("#createstatus").html("<span class='label label-danger'  title='该容器创建失败,请删除重新创建'>创建失败</span>");
				return;
			}
			if(a.status.code != 1){
				//alert(a.status.message);
				tr.find("#createstatus").html("<span class='label label-danger'  title='该容器创建失败,请删除重新创建'>"+a.status.message+"</span>");
				return;
			}
			inspect(id)
		},
		error:function(e){
			alert("请求失败")
		}
	})
}

function inspect(id){
	var tr = $("#used").find("#tr"+id);
	var name = tr.attr('data-name');
	var disk_space = tr.attr('data-disk');
	$.ajax({
		url:'?c=container&a=inspect&name='+name,
		type:'POST',
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			renderStatus(a.ret.Running,id);
			var persent =Math.round(a.ret.Used_disk/(disk_space*1024)*100);
			var html = '<div class="progress progress-success" id="space" style="margin-bottom: 0px;" data-toggle="tooltip" title="('+ a.ret.Used_disk+'/'+disk_space*1024+')(M)"><div class="bar" style="width: '+persent+'%"></div></div>';
			tr.find("#disk").html(html);
		
			tr.find("#space").bind('mouseover',function(){
				tr.find("#space").tooltip('show');
			})
		},
		error:function(a){
			alert("error");
		}
	});
}
function getFtpHost(id){
	var tr = $("#used").find("#tr"+id);
	var name = tr.attr('data-name');
	$.ajax({
		url:'?c=container&a=getFtpHost&name='+name,
		type:'POST',
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			tr.find("#host").html(a.ret);
		},
		error:function(a){
			alert("error");
		}
	});
}
function renderStatus(status,id){
	var tr = $("#used").find("#tr"+id);
	var  statusdiv = tr.find("#createstatus");
	var html = '<span id="containerstatus" data-placement="top" data-toggle="containerstatus" data-original-title="容器暂停中，点击运行"><a href="javascript:;"><em class="icon_8 icon_8_cur"></em></a></span>';
	if(status)
	{
		var html = '<span id="containerstatus" data-placement="top" data-toggle="containerstatus" data-original-title="容器运行中，点击暂停"><a href="javascript:;"><em class="icon_8"></em></a></span>';
	}
	statusdiv.html(html);
	statusdiv.find("#containerstatus").bind('mouseover',function(){
		statusdiv.find("#containerstatus").tooltip('show');
	})
	statusdiv.find("#containerstatus").bind('click',function(){
		if(status){
			changeStatus(id,1);
			return;
		}
		changeStatus(id,0);
	})
}
function changeStatus(id,status){
	var tr = $("#tr"+id);
	var name = tr.attr('data-name');
	$.ajax({
		url:'?c=container&a=changeStatus&name='+name,
		type:'get',
		dataType:'json',
		data:{status:status},
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			status = status == 1? 0:1;
			renderStatus(status,id)
			/*var  statusdiv = $("#createstatus");
			  statusdiv.html("<i class='icon-play'  data-toggle='tooltip' title='容器运行中'></i>")
			if(status){
				statusdiv.html("<i class='icon-stop' data-toggle='tooltip' title='容器暂停'></i>")
			}*/
		},
		error:function(a){
			alert("error");
		}
	});
}
function createStatus(id){
	var div = $("#tr"+id);
	var name = div.attr("data-name");
	$.ajax({
		url:'?c=container&a=createStatus&name='+name,
		type:'POST',
		dataType:'json',
		success:function(a){
			var status = a.status.code;
			switch(status)
			{
			   case 1:
				   div.find("#createstatus").append("<span class='alert alert-success'>创建成功</span>");
				   break;
			   case 2:
				   div.find("#createstatus").append("<span class='alert alert-success'>"+a.pull_status.status+"</span>");
				   break;
			   case 4:
				   div.find("#createstatus").append("<span class='alert alert-success'>"+"创建失败，请删除容器重新创建"+"</span>");
				   break;
			   default:
				   div.find("#createstatus").append("<span class='alert alert-success'>"+"不知道"+"</span>");
			}
			  setTimeout(function() {	
				  div.find("#createstatus").find('span').remove();
			  },3000);
		},
		error:function(a){
			alert("error");
		}
	});
}
function del(id){
	if(confirm("您确定要删除这条记录") ===false){
		return;
	}
	$.ajax({
		url:'?c=container&a=del&id='+id,
		type:'get',
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			//$("#tr"+id).remove();
			window.location.reload();
		},
		error:function(a){
			alert("error");
		}
	});
}
function piaoAddVhost(id){
	if($("#used").find("#addvhost").length>0){
		$("#used").find("#addvhost").remove();
	}
	var tem = $("#add-vhost-template").html();
	$("#tr"+id).after(tem);
	var div = $("#used").find("#addvhost");
	div.find("#esc").bind('click',function (){
			div.remove();
	})
	div.find("#enter").bind('click',function (){
		 addVhost(id,div);
	})
}
function addVhost(id,div){
	var vhost = div.find('input[name=vhost]').val();
	if(!vhost){
		alert("站点名称不能为空");
		return;
	}
	$.ajax({
		url:'?c=container&a=addVhost&id='+id,
		type:'post',
		data:{vhost:vhost},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			window.location.reload();
		},
		error:function(a){
			alert("error");
		}
	});
}
function delVhost(id){
	if(confirm("您确定要删除站点记录吗？") ===false){
		return;
	}
	$.ajax({
		url:'?c=container&a=delVhost&id='+id,
		type:'get',
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			window.location.reload();
		},
		error:function(a){
			alert("error");
		}
	});
}
function piaoRenew(id){
	if($("#used").find("#renewcontainer").length>0){
		$("#used").find("#renewcontainer").remove();
	}
	var tem = $("#container-renew-template").html();
	var tr = 	$("#used").find("#tr"+id);
	 var name = tr.attr('data-name');
	 var price = tr.attr('data-price');
	 var option  =[];
	 option.name = name;
	 option.price = price;
	 tem = Mustache.to_html(tem,option);
		tr.after(tem);
	var div = $("#used").find("#renewcontainer");
	div.find("#esc").bind('click',function (){
		div.remove();
	});
   div.find("#enter").bind('click',function (){
		renew(id,div);
	});
   div.find("#add").bind('click',function(){
		addChange(div,price);
	})
	div.find("#minus").bind('click',function(){
		minusChange(div,price);
	})
}
function addChange(div,price){
	var months =  parseInt(div.find("input[name=month]").val());
	 div.find("input[name=month]").attr('value',months+1);
	 div.find("#sum").html("<em>￥"+price*(months+1)+"</em>");
}
function minusChange(div,price){
	var months =  parseInt(div.find("input[name=month]").val());
    months = months<=1?1:months-1;
	 div.find("input[name=month]").attr('value',months);
	 div.find("#sum").html("<em>￥"+price*months+"</em>");
}
function renew(id,div){
	var months = div.find('input[name=month]').val();
	if(!months){
		alert("续费月数不能为空");
		return;
	}
	$.ajax({
		url:'?c=container&a=renewal',
		type:'post',
		data:{months:months,id:id},
		dataType:'json',
		success:function(a){
			if(a.status.code != 1){
				alert(a.status.message);
				return;
			}
			window.location.reload();
		},
		error:function(a){
			alert("error");
		}
	});
}
function mouseover(id,showid){
	var tr = $("#used").find("#tr"+id);
		tr.find("#"+showid).bind('mouseover',function(){
		tr.find("#"+showid).tooltip('show');
	})
}
//每次页面加载时调用即可
function intro(id){
	       // var tr = $("#used").find("#tr"+id);
            //这个变量可以用来存取版本号， 系统更新时候改变相应值
            cur_val = 1;
            //判断函数所接收变量的长度
           /* if (arguments.length ==0)
            {
                //每个页面设置不同的cookie变量名称，不可以重复，有新版本时，更新cur_val
                //这里模拟很多网站有新版本更新时才出现一次引导页， 第二次进入进不再出现， 这里有cookie来判断
               /* if ($.cookie("intro_cookie_index") == cur_val)
                 {
                    return;
                 }
            }     */       

            introJs().setOptions({
                //对应的按钮
            	prevLabel:"上一步",
                nextLabel:"下一步",
                skipLabel:"跳过",
                doneLabel:"结束",
                steps: [
                    {
                        element:"#used #tr"+id,
                        //这里是每个引导框具体的文字内容，中间可以编写html代码
                        intro: "容器创建完成！现在我们进入容器的使用阶段！",
                        //这里可以规定引导框相对于选中对象出现的位置 top,bottom,left,right
                        position: "top"
                    },
                    {
                        //第二步引导
                        element:"#used #tr"+id+" #name",
                        intro: "点击，即可进入容器设置",
                        position: "left"
                    },
                    {
                        //第三步引导
                        element:"#used #tr"+id+" #createstatus",
                        intro: "<ul><li>正在创建中--容器正在创建，请刷新页面等待容器创建成功</li><li>正在运行--容器正在运行</li><li>已暂停--容器暂停，设置将不会生效</li></ul>",
                        position: "bottom"
                    }
                ]

            }).oncomplete(function(){
              
            }).onexit(function(){
                //点击结束按钮后， 执行的事件
             //  $.cookie("intro_cookie_index",cur_val,{expires:30});
            }) .start();           
        }