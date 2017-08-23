<?php /* Smarty version Smarty-3.0.5, created on 2017-08-14 14:32:56
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/container/custom_image.html" */ ?>
<?php /*%%SmartyHeaderCode:126587191159914418ce1387-97634019%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a00226cb0b96aba954717539cb4fcb59af5833a4' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/container/custom_image.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126587191159914418ce1387-97634019',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<link href="/style/user/css/container.css" rel="stylesheet">
<link href="/style/user/css/domain.css" rel="stylesheet">

<script type="text/template" id="add-template">
	  <div class="form-horizontal" >
    	 <div class="control-group">
  		  	<label class="control-label">镜像</label>
   		    <div class="controls">
     	 		<input type="text" name="name" style="width:300px" placeholder="输入的格式请参考docker的镜像说明"/>&nbsp;*
   		    </div>
		 </div>
		<div class="control-group">
  		  	<label class="control-label">命令</label>
   		    <div class="controls">
     	 		<input name="cmd" name="cmd" type="text" style="width:300px" placeholder="可空"/>
   		    </div>
		 </div>
		<div class="control-group">
  		  	<label class="control-label">备注</label>
   		    <div class="controls"> 
				<textarea name="mem" style="width:300px;height:100px;"  placeholder="可空"></textarea>
   		    </div>
		 </div>
<!--
		<div class="control-group">
   		    <div class="controls" style="float:right;margin-right:76px;">
				<button class="btn"  id="esc" >取消</button>
				<button class="btn btn-info btns"  id="enter">提交</button>	
   		    </div>
		 </div>
-->
     </div>
</script>
<script>
$(function(){
	inputdiv = $("#piao-modal");
	$("#left_group_list").find('div').eq(2).addClass('cur');
	$("#nav_container").addClass("cur");
});
function piaoAdd(){
	inputdiv.find(".modal-body").html($("#add-template").html());
	inputdiv.modal();
	inputdiv.find("#enter").unbind();
	inputdiv.find("#enter").bind('click',function(){
		add();
	});
}
function add(){
	var name = inputdiv.find("input[name=name]").val();
	var cmd = inputdiv.find("input[name=cmd]").val();
	var mem = inputdiv.find("textarea[name=mem]").val();
	$.ajax({
		url:"?c=customimage&a=add",
		data:{name:name,cmd:cmd,mem:mem},
		dataType:"json",
		type:"POST",
		success:function(a){
			if(a.status.code != 1){
				showMsg(a.status.message);
				return ;
			}
			window.location.reload();
		},
		error:function(){
			showMsg("请求失败");
		}
	});
}


function showMsg(msg){
	alert(msg)
}
function del(id){
	var tr = $("#items").find("#item" + id);
	$.ajax({
		url:"?c=customimage&a=del",
		data:{id:id},
		dataType:"json",
		success:function(a){
			if(a.status.code != 1){
				showMsg(a.status.message);
				return ;
			}
			tr.remove();
		},
		error:function(){
			showMsg("请求失败");
		}
	});
}

</script>
<div class="row-fluid" style="height:30px;">
		<span id="domain_error" class="offset3"></span>
</div>
<div class="wrap" id="left">
    <div class="cl mtb20">
	<?php $_template = new Smarty_Internal_Template('container/containerleft.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
 		<div class="cont_main">
 		   <div class="mtb20 pr">
		   		<div class="btn-group">
					  <span onclick="piaoAdd()" class="btn btn-success btns">添加镜像</span>
				</div>
	        </div>
 			<div class="domain_box">
 			 <div id="input"></div>
	 				<table class="domain_table" style="width:100%" id="items">
	 					<thead>
	 				  <tr>
							<th>名称</th>
							<th>命令</th>
							<th>备注</th>
							<th>操作</th>
						</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rows')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
			 					<tr id="item<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
			 						<td><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
			 						<td><?php echo $_smarty_tpl->tpl_vars['row']->value['cmd'];?>
</td>
			 						<td><?php echo $_smarty_tpl->tpl_vars['row']->value['mem'];?>
</td>
			 						<td><a href="javascript:del(<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
);">删除</a></td>
			 					</tr>
							<?php }} ?>
						</tbody>
					</table>
 			</div>
 		</div>
  </div>
</div>
 <div class="modal hide fade" id="piao-modal">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<div style="font-size:16px;color:F5F5F5">添加镜像</div>
    	</div>
    	<div class="modal-body">
    		
    	</div>
    	<div class="modal-footer">
            <a href="#" id="enter"  class="btn btn-success btns">提交</a>
    		<a href="#"  class="btn" data-dismiss="modal">关闭</a>
    	</div>
    </div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>