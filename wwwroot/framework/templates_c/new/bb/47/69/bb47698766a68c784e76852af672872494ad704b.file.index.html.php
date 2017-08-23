<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 18:58:41
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/domain/index.html" */ ?>
<?php /*%%SmartyHeaderCode:160496124055f010e15485e8-75818664%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb47698766a68c784e76852af672872494ad704b' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/domain/index.html',
      1 => 1438912905,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160496124055f010e15485e8-75818664',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<?php $_template = new Smarty_Internal_Template('domain/templete.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type='text/javascript' src="/style/common/md5.js"></script>
<script type='text/javascript'>
	var p;
	var domainlist;
	var groupid ="<?php echo $_smarty_tpl->getVariable('groupid')->value;?>
" ;
	var iscdn = "<?php echo $_smarty_tpl->getVariable('iscdn')->value;?>
";
	var webdomain = "<?php echo $_smarty_tpl->getVariable('webdomain')->value;?>
"
</script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
domain/domain.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
domain/page.js"></script>
<!--  <link href="/style/css/z-domain-list.css" rel="stylesheet">-->
<!--  <link href="/style/user/css/domain.css" rel="stylesheet">-->
	  
<div class="row-fluid" style="height:30px;">
	<!--<span id="domain_error" class="offset3"></span>-->
</div>

<!----内容------>
	
<div class="erp_nr clearB">
<!-----left----->
<div id="nr_left">
    <!----二级导航------>
    <div class="ejdh">
    	<ul id="left_group_list">
    		
    	</ul>
    </div>
</div>
	<!--  
		<div class="menus_aside">
            <div id="left_group_list">
            </div>
        </div>
        -->
        
	<!-----right----->
	<div id="nr_right">
		<!-----按钮 ----->
		<div class="nr_domain">
			<!--  <ul>
        		<li id="tianjia"><a href="javascript:;" id="add_multi_domain">+添加域名</a><p></p></li>
        	</ul>-->
				<div class="btn-group">
					<button class="btn btn-success btns" id="add_multi_domain" style="border-radius:10px;width:100px; height:36px;background:#FF6760;">添加域名</button>
				</div>
				
				<div class="btn-group">
					<button class="btn btns dropdown-toggle btn-success" data-toggle="dropdown" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">域名操作<span class="caret"></span></button>
					<ul class="dropdown-menu" id="dropdown_operating">
						<li><a href="javascript:;" id="del">删除</a></li>
						<li><a href="javascript:;" id="restor">启用</a></li>
						<li><a href="javascript:;" id="stop">暂停</a></li><!--
						<?php if ($_smarty_tpl->getVariable('iscdn')->value==1){?>
						<li><a href="javascript:;" id="cdn">接入CDN</a></li>
						<li><a href="javascript:;" id="del_cdn">删除CDN</a></li>
						<?php }?>-->
					</ul>
				</div>
				
				<div class="btn-group">
					<button class="btn btns dropdown-toggle btn-success" data-toggle="dropdown" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">记录操作<span class="caret"></span></button>
					<ul class="dropdown-menu" id="dropdown_multi_operating">
						<li><a href="javascript:;" id="edit">批量修改记录</a></li>
						<li><a href="javascript:;" id="add">批量增加记录</a></li>
						<li><a href="javascript:;" id="import">批量导入记录</a></li>
					</ul>
				</div>
				<div class="btn-group">
					<button class="btn btns dropdown-toggle btn-success" data-toggle="dropdown" style="border-radius:10px;width:100px; height:36px;background:#eeeeee;color:#696969;border:#eeeeee;">分组操作<span class="caret"></span></button>
					<ul class="dropdown-menu" id="dropdown_group">
						<li id="create"><a href="javascript:;" id="createa">增加分组</a></li>
					</ul>
				</div>
				<!--
				<span id="form-search">
					<input type="text" id="search-query" class="search_btn" placeholder="域名搜索"/>
				</span>-->
		</div>
		<div class="blank10"></div>
		<div class="piliangtianjia" id="multi_div" style="display:none;margin:10px 0 10px 0;"></div>
		 <!------列表----->
		<div class="nr_liebiao" id="domain-list">
			<table cellpadding="0" cellspacing="0" align="center" style="width:100%; height:40px; line-height:40px; margin:0px auto;">
				<thead>
					<tr style="border-bottom:1px solid #c0c0c0;">
						<th width="5%" style="border-right:1px solid #c0c0c0; text-align:center;"><input type='checkbox' id="select_all"></th>
						<!--<th class="tab_th2"></th>-->
						<th id="name-sort" width="25%" style="border-right:1px solid #c0c0c0; text-align:center;">域名</th>
						<th id="pname-sort" width="20%" style="border-right:1px solid #c0c0c0; text-align:center;">套餐</th>
						<th width="20%" style="border-right:1px solid #c0c0c0; text-align:center;">状态</th>
						<!--<?php if ($_smarty_tpl->getVariable('iscdn')->value==1){?><th class="tab_th1">CDN</th><?php }?>-->
						<th width="25%" style="text-align:center;">操作</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			
		</div>
		<!-- 分页 -->
		<div class="row">
				<div class="pull-right" style="padding-top: 20px;">
					<div id="domain-pagecount-div" ></div>
				</div>
				<div class="col-md-4">
					<div class="pager pull-center" id="domain-page-div">
						<ul>
						</ul>
					</div>
				</div>
		   </div>
		
		
	</div>
</div>
<span id="div-bg"></span>
<style>
.domain_tip{
position:fixed;
top:0;
left:50%;
margin-left:-110px;
padding-top:16px;
padding-bottom:16px;
border-radius:0;
}
</style>
<span id="domain_error" class="domain_tip"></span>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
