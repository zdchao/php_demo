<?php /* Smarty version Smarty-3.0.5, created on 2015-10-15 18:14:14
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_deny.html" */ ?>
<?php /*%%SmartyHeaderCode:1931639768561f7c763d5920-10824486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0d40d78813f40fcfe8c3c382196f29ea873fbcc' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_deny.html',
      1 => 1444642550,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1931639768561f7c763d5920-10824486',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p>尊敬的 <?php echo $_smarty_tpl->getVariable('user')->value;?>
 用户：</p>

<p>您的域名：<?php echo $_smarty_tpl->getVariable('domain')->value;?>
 在 <?php echo $_smarty_tpl->getVariable('date')->value;?>
 QPS已达到 <?php echo $_smarty_tpl->getVariable('qps')->value;?>
，已被系统暂定，请等待恢复.</p>

<p>详情请登陆网站查询或联系客服.</p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 官方网站：<a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

<p>-------------------------------------------------------------------------------</p>

<p>To our valued <?php echo $_smarty_tpl->getVariable('user')->value;?>
 customer：</p>

<p>We are here to inform you that your domain： <?php echo $_smarty_tpl->getVariable('domain')->value;?>
 has been suspended due to attack which reached QPS <?php echo $_smarty_tpl->getVariable('qps')->value;?>
 limit by <?php echo $_smarty_tpl->getVariable('date')->value;?>
. Please wait for further update.</p>

<p>For details please contact our support team via website.</p> 

<p>(system auto-message,please don't reply)</p>

<p>Regards</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 Support Team: <a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

