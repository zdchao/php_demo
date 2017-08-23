<?php /* Smarty version Smarty-3.0.5, created on 2015-10-15 18:14:09
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_start.html" */ ?>
<?php /*%%SmartyHeaderCode:1325476255561f7c71a56230-51916399%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '203e4cfb1837d85ad36ec823f3f7348519312a07' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_start.html',
      1 => 1444640977,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1325476255561f7c71a56230-51916399',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p>尊敬的<?php echo $_smarty_tpl->getVariable('user')->value;?>
用户：</p>

<p>您的域名：<?php echo $_smarty_tpl->getVariable('domain')->value;?>
 有攻击, 在 <?php echo $_smarty_tpl->getVariable('date')->value;?>
 QPS达到 <?php echo $_smarty_tpl->getVariable('qps')->value;?>
.</p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
官方网站：<a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

<p>-------------------------------------------------------------------------------</p>

<p>To our valued <?php echo $_smarty_tpl->getVariable('user')->value;?>
 customer：</p>

<p>We have just detected an attack on your domain：<?php echo $_smarty_tpl->getVariable('domain')->value;?>
 at <?php echo $_smarty_tpl->getVariable('date')->value;?>
 reached QPS <?php echo $_smarty_tpl->getVariable('qps')->value;?>
.</p>

<p>(system auto-message,please don't reply)</p>

<p>Regards</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 Support Team: <a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>