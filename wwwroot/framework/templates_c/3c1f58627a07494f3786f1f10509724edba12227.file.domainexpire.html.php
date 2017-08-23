<?php /* Smarty version Smarty-3.0.5, created on 2015-10-15 18:14:02
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/domainexpire.html" */ ?>
<?php /*%%SmartyHeaderCode:932924577561f7c6a1e86d4-24710556%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c1f58627a07494f3786f1f10509724edba12227' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/domainexpire.html',
      1 => 1444640958,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '932924577561f7c6a1e86d4-24710556',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p>尊敬的 <?php echo $_smarty_tpl->getVariable('user')->value;?>
 用户：</p>

<p>您的域名 <?php echo $_smarty_tpl->getVariable('domain')->value;?>
 购买的套餐 (<?php echo $_smarty_tpl->getVariable('pid_name')->value;?>
) <?php echo $_smarty_tpl->getVariable('pid_expire_time')->value;?>
 到期</p>

<p>套餐续费价格: <?php echo $_smarty_tpl->getVariable('pid_price')->value;?>
 元</p>

<p>为了不影响您的使用,请及时续费</p>

<p>详情请登陆网站查询或联系客服.</p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 官方网站：<a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

<p>-------------------------------------------------------------------------------</p>

<p>To our valued <?php echo $_smarty_tpl->getVariable('user')->value;?>
 customer：</p>

<p>There is a new invoice generated for your domain <?php echo $_smarty_tpl->getVariable('domain')->value;?>
 Invoice due on (<?php echo $_smarty_tpl->getVariable('pid_name')->value;?>
) <?php echo $_smarty_tpl->getVariable('pid_expire_time')->value;?>
</p>

<p>Outstanding balance :￥ <?php echo $_smarty_tpl->getVariable('pid_price')->value;?>
 </p>

<p>For more details, please visit our website or contact customer service.</p> 

<p>(system auto-message,please don't reply)</p>

<p>Regards</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 Support Team: <a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>