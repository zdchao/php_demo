<?php /* Smarty version Smarty-3.0.5, created on 2017-08-14 14:32:58
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/container/nocontainer.html" */ ?>
<?php /*%%SmartyHeaderCode:9078276155991441a13ca66-74479707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52a5314a39983f1c0432532651e274d057678511' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/container/nocontainer.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9078276155991441a13ca66-74479707',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<style>
.message{
	font-size:20px;
	color:#f26382;
	margin:8% 0% 0% 20%;
}
</style>
<link href="/style/user/css/domain.css" rel="stylesheet">
<link href="/style/user/css/container.css" rel="stylesheet">
<div class="row-fluid" style="height:30px;">
		<span id="domain_error" class="offset3"></span>
</div>
<div class="wrap" id="left">
    <div class="cl mtb20">
		<div class="menus_aside">
            <div id="left_group_list">
            	<div>
					<a href="?c=public&a=container"><span class="container_left left_color">产品列表</span></a>
				</div>
				<div  class="cur">
					<a  href="?c=containerproduct&a=usercontainer"><span class="container_left">我的容器<sup>(<?php echo $_smarty_tpl->getVariable('count')->value;?>
)</sup></span></a>
				</div>
				<div>
					<a  href="?c=customimage&a=pagelist"><span  class="container_left left_color">镜像管理</span></a>
				</div>
            </div>
        </div>
 		<div class="cont_main">
 			<div class="buynocontent">
 				<div class="message">亲，不好意思，您还没有购买哟！---->
 				<a href="?c=public&a=container"><span class="buy_button">点击购买</span></a>
 				</div>
 			</div>
 			
 		</div>
  </div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>