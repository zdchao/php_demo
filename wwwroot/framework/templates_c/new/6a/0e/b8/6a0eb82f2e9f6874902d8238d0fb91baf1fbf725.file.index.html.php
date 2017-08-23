<?php /* Smarty version Smarty-3.0.5, created on 2016-04-20 09:10:14
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/index.html" */ ?>
<?php /*%%SmartyHeaderCode:9318204165716d6f6dd8217-43457087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a0eb82f2e9f6874902d8238d0fb91baf1fbf725' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/index.html',
      1 => 1461114608,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9318204165716d6f6dd8217-43457087',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>


<?php $_template = new Smarty_Internal_Template('user/templete.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<link href="/style/user/css/userset.css" rel="stylesheet">

<style>

.table td:first-child{

  width:25%;

}

</style>

</script>

 <div class="blank10"></div>

  <div class="blank10"></div>

  <div id="show_error"></div>

<div class="erp_nr clearB">

<!-----left----->



<div id="nr_left">

    <!----二级导航------>

    <div class="ejdh">

    <ul>

    <li id="ejdh" ><a href="#" style="margin-left: 20px;">个人设置</a></li>

<!--   <li><a href="#">修改密码</a></li> -->  

    </ul>

    </div>

   

</div>

<div id="nr_right">

    <table class="table">

        <tbody id="content_tbody">

        </tbody>

    </table>

</div>

</div>

<div class="modal hide fade" id="piao-modal">

    	<div class="modal-header">

    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

    		<h3>绑定微信</h3>

    	</div>

    	<div class="modal-body">

    		<p></p>

    	</div>

    </div>

<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
user/user.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>

<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

