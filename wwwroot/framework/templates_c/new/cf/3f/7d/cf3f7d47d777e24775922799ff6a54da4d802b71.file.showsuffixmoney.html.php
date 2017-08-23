<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:50
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/domainregister/showsuffixmoney.html" */ ?>
<?php /*%%SmartyHeaderCode:102526861656786bca65a4b3-46482055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf3f7d47d777e24775922799ff6a54da4d802b71' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/domain/view/new/domainregister/showsuffixmoney.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102526861656786bca65a4b3-46482055',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('public/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<div class="wrap">
	<div class="contain">
		<div class="domain_box">
		<table class="domain_table" style="width:100%;">
			<caption>域名新购、续费、转入价格列表</caption>
			<thead>
				<tr>
					<th>域名</th>
					<th>优惠活动价格(元/年)</th>
					<th>首年注册(元/年)</th>
					<th>续费(元/年)</th>
					<th>转入(元/年)</th>
				</tr>
			</thead>
			<tbody>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['suffix'];?>
<?php if ($_smarty_tpl->tpl_vars['row']->value['suffix_type']==1){?>(英文)<?php }elseif($_smarty_tpl->tpl_vars['row']->value['suffix_type']==2){?>(中文)<?php }?></td>
					<td><?php if ($_smarty_tpl->tpl_vars['row']->value['preferential_price']==0){?>/<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['row']->value['preferential_price']/100;?>
<?php }?></td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['first_price']/100;?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['renewal_price']/100;?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['row']->value['entrust_price']/100;?>
</td>
				</tr>
				<?php }} ?>
			</tbody>
		</table>
		</div>
	</div>
</div>
<?php $_template = new Smarty_Internal_Template("public/foot.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>