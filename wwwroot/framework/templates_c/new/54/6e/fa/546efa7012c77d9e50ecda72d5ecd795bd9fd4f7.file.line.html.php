<?php /* Smarty version Smarty-3.0.5, created on 2016-01-28 16:28:56
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/line.html" */ ?>
<?php /*%%SmartyHeaderCode:182265235956a9d148ae0c49-26894109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '546efa7012c77d9e50ecda72d5ecd795bd9fd4f7' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/line.html',
      1 => 1453969732,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182265235956a9d148ae0c49-26894109',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
record/line.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/template' id="line-add-template">
<div id="line-add" style="margin:30px 200px;">
	<div style="margin:5px;">名称:<input type='text' name="name"  required></div>
	<div style="margin:5px;">IP段:<textarea rows="5" cols="80" style="width:380px; margin-left:6px;" name="ips"></textarea></div>
	<div style="margin-left:32px; position:absolute;"><button class="btn" style="margin:5px;">增加</button><button class="btn" style="margin:5px;">取消</button></div>
</div>
</script>
<script type='text/template' id="line-show-row-template">
<div  id="{{rowid}}" style='padding-top:5px;'>
<table>
	<tr>
		<td width="230px"><span>{{name}}</span></td>
		<td><span><button class="btn" style="margin:5px;">修改</button><button class="btn" style="margin:5px;">删除</button></span></td>
	</tr>
</table>
<div>
</script>
<script type='text/template' id="line-accessdeny-template">
<div  id="line-accessdeny">
	 <div class="gonggao">
         	<h3><span><a href="#">X</a></span>提示</h3>
            <p><strong>您的域名不支持该功能,请联系管理员购买套餐!</strong></p>
         </div>
         <div class="blank10"></div>
</div>
</script>
<script type='text/template' id="line-nologin-template">
<a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a>
</script>

<div class="erp_nr clearB">
			<?php $_template = new Smarty_Internal_Template('record/right-operat.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
			<div id="nr_right">
				<div id="line-list-row" ></div>
				<div id="line-add-row" ></div>
		</div>		
		</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
