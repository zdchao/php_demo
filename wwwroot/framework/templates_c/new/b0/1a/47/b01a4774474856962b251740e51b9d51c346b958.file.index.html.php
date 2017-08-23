<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 18:59:50
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/index.html" */ ?>
<?php /*%%SmartyHeaderCode:17066391555f01126b49989-78744947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b01a4774474856962b251740e51b9d51c346b958' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/index.html',
      1 => 1439371801,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17066391555f01126b49989-78744947',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<link href="/style/user/css/record.css" rel="stylesheet">
<script type='text/javascript' src="/style/jq.cookie.js"></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
domain/page.js"></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
record/record.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<?php $_template = new Smarty_Internal_Template('record/indextemplete.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/javascript">
var iscdn = "<?php echo $_smarty_tpl->getVariable('iscdn')->value;?>
";
var isadmin = "<?php echo $_smarty_tpl->getVariable('isadmin')->value;?>
";
var recordvalue = "<?php echo $_smarty_tpl->getVariable('recordvalue')->value;?>
";
</script>
<div class="record_toptip"><span id="error-message" ></span></div>
<div class="erp_nr clearB">
	<?php $_template = new Smarty_Internal_Template('record/right-operat.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
	<div id="nr_right">
    	<div class="nr_domain">
			<div class="btn-group">
				<button id="add-record" class="btn btn-success btns" style="border-radius:10px;width:100px; height:36px;background:#FF6760;">添加记录</button>
			</div>
			<div class="btn-group">
					<button class="btn btns dropdown-toggle btn-success"		data-toggle="dropdown" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">更多操作<span class="caret"></span></button>
					<ul class="dropdown-menu" id="dropdown_operating">
						<li><a href="javascript:;" id="del" 	data-loading-text="正在执行...">删除</a></li>
						<li><a href="javascript:;" id="restor" 	data-loading-text="正在执行...">启用</a></li>
						<li><a href="javascript:;" id="stop" 	data-loading-text="正在执行...">暂停</a></li>
						<!--  
						<?php if ($_smarty_tpl->getVariable('iscdn')->value==1){?>
						<li><a href="javascript:;" id="cdn_add" data-loading-text="正在执行...">增加CDN</a></li>
						<li><a href="javascript:;" id="cdn_del">删除CDN</a></li>
						<?php }?>
						-->
					</ul>
				</div>
				<div class="btn-group">
					<button class="btn btns btn-success dropdown-toggle" data-toggle="dropdown" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">分类显示<span class="caret"></span></button>
					<ul class="dropdown-menu" id="dropdown-classify-opera">
						<li><a href="javascript:;" id="all">显示全部</a></li>
						<li><a href="javascript:;" id="a_record">A记录</a></li>
						<li><a href="javascript:;" id="cname_record">CNAME记录</a></li>
						<li><a href="javascript:;" id="unite">@&www</a></li>
						<li><a href="javascript:;" id="analyses_start">解析启用</a></li>
						<li><a href="javascript:;" id="analyses_pause">解析暂停</a></li>
						<li><a href="javascript:;" id="start">启用</a></li>
						<li><a href="javascript:;" id="standby">备用</a></li>
						<li><a href="javascript:;" id="standby_record">备注记录</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button class="btn" id="add_multi_record" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">批量添加</button>
				</div>
				<div class="btn-group">
					<button class="btn" id="import_multi_record" data-loading-text="正在加载" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">自动导入</button>
				</div>
				<div class="btn-group">
					<button class="btn" id="export_content" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">导出记录</button>
				</div>
				<div class="btn-group">
					<button class="btn" id="recoverData" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">导入记录</button>
				</div>
				<span id="from-search">
					<input type="text"  id="search-input" placeholder="搜索记录">
				</span>
			</div>
         <div class="blank10"></div>
          <div  id="record-tips">
          </div>
         <div class="blank10"></div>
         <div id="multi_div"   style="display:none" class="piliangtianjia"></div>
          <div class="blank10"></div>
         <div class="nr_liebiao">
            <table class="table">
	         	<tbody id="record-list">
	         	</tbody>
         	</table>
         </div>
         <div>
           <div class="blank10"></div>
			<div style="position:relative;height:50px;">
				<div id="record-pagecount-div" style="width:132px;position:absolute;right:56px;"></div>
			</div >
			<div>
				<div class="pager" id="record-page-div"  style="margin-top:-1px;">
					<ul style="padding-top:0px;">
					</ul>
				</div>
		</div >
	</div>
	</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
