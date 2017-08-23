<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:49
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/domainregister/index.html" */ ?>
<?php /*%%SmartyHeaderCode:209031091156786bc9508ad7-90692160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58507bc3b56418ad0b8aa65152c3fe0d2ff9da27' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/domainregister/index.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209031091156786bc9508ad7-90692160',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('public/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type='text/javascript' src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/js/domainsearch.js?v=<?php echo $_smarty_tpl->getVariable('jsversion')->value;?>
"></script>
<div class="wrap">
<div class="contain">
	<div class="register_box">
		<!-- 域名搜索框开始 -->
		<div class="d_list">
			<form action="?c=public&a=domainRegister" class="form-inline" role="form" method="POST">
					<input type="text" value="<?php echo $_smarty_tpl->getVariable('domain')->value;?>
" name="domain" id="domain"/>
					<input type="submit" value="搜索"/>
			</form>
		</div>
		<!-- 域名搜索框结束 -->
		<div style="margin-top:30px;position:relative;">
			<div class="domain_search_list">
				<div style="position:relative;margin-bottom:10px;">
					<ul class="nav nav-tabs" id="ul_tab">
						<li><a href="javascript:;" id="domain_all">全部</a></li>
						<li><a href="javascript:;" id="domain_register">未注册</a></li>
					</ul>
					<a href="?c=public&a=showSuffixMoney" class="ds_domain_serach_money" target="_Blank" style="position:absolute;top:15px;right:5px;">价格列表</a>
				</div>
				<table class="domain_table" width="100%">
					<thead>
						<tr>
							<th><span>域名</span></th>
							<th><span>价格(元)</span></th>
							<th><span>操作</span></th>
						</tr>
					</thead>
					<tbody id="table_html" >
					</tbody>
				</table>
			</div>
			<div class="domain_serach_car">
				<ul class="list-group" id="shop_cart_ul">
					<li class="list-group-item">购物车</li>
					<li id="shop_cart_tip" class="list-group-item">请选择域名</li>
				</ul>
			</div>
		</div>
		<!-- 域名搜索列表框开始
			<div>
				<ul class="nav nav-tabs" id="ul_tab">
					<li><a href="javascript:;" id="domain_all">全部</a></li>
					<li><a href="javascript:;" id="domain_register">未注册</a></li>
				</ul>
				<a href="?c=public&a=showSuffixMoney" class="ds_domain_serach_money" target="_Blank">价格列表</a>
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="45%"><span>域名</span></th>
							<th width="35%"><span>价格(元)</span></th>
							<th width="20%"><span>操作</span></th>
						</tr>
					</thead>
					<tbody id="table_html" >
					</tbody>
				</table>
			</div>
			<div>
				<ul class="list-group" id="shop_cart_ul">
					<li class="list-group-item">购物车</li>
					<li id="shop_cart_tip" class="list-group-item">请选择域名</li>
				</ul>
			</div>
		 域名搜索列表框结束 -->
	</div>
</div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/template" id="search-tip-template">
<tr id="search-tip-tr">
	<td width="45%"><span></span></td>
	<td width="35%"><span>正在查询...</span></td>
	<td width="20%"><span></span></td>
</tr>
</script>
<script type="text/template" id="domain-all-list-template">
<tr>
	<td width="45%"><span>{{domain}}</span></td>
	<td width="35%"><span>{{status}}</span></td>
	<td width="20%"><span>{{{op}}}</span></td>
</tr>
</script>
<script type="text/template" id="domain-register-list-template">
<tr>
	<td class="text-center" colspan="3">您搜索的域名已被注册，请尝试其他的域名</td>
</tr>
</script>
<script type="text/template" id="shop-cart-list-template">
	<li class="list-group-item" id="{{key}}">{{domain}}<a href="javascript:delShopCart('{{key}}')" class="badge">删除</a></li>
</script>
<script type="text/template" id="shop-cart-btn-template">
	<li id="enter_buy" class="list-group-item"><button type="button" class="btn btns btn-success btn-sm btn-block" onclick="buyDomainEnter()">购买</button></li>
</script>

<!-- 搜索可注册域名模板 -->
<script type="text/template" id="domain-serach-init-template">
<tr id="tr{{key}}">
	<td width="45%"><span>{{domain}}</span></td>
	<td width="35%"><span>{{price}}</span></td>
	<td width="20%"><span>正在查询</span></td>
</tr>
</script>