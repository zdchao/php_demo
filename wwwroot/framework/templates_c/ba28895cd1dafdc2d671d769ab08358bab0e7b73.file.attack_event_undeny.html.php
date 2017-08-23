<?php /* Smarty version Smarty-3.0.5, created on 2015-10-15 18:14:15
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_undeny.html" */ ?>
<?php /*%%SmartyHeaderCode:1387678674561f7c777e99c9-50400173%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba28895cd1dafdc2d671d769ab08358bab0e7b73' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_undeny.html',
      1 => 1444643090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1387678674561f7c777e99c9-50400173',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p>尊敬的<?php echo $_smarty_tpl->getVariable('user')->value;?>
用户：</p>

<p>您的域名：<?php echo $_smarty_tpl->getVariable('domain')->value;?>
在<?php echo $_smarty_tpl->getVariable('date')->value;?>
已自动解除暂停状态.</p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
官方网站：<a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

<p>-------------------------------------------------------------------------------</p>

<p>To our valued <?php echo $_smarty_tpl->getVariable('user')->value;?>
 customer：</p>

<p>We are happy to inform you that we no longer detect any attack on your domain：<?php echo $_smarty_tpl->getVariable('domain')->value;?>
 as of <?php echo $_smarty_tpl->getVariable('date')->value;?>
 System has unsuspended you site.

<p>(system auto-message,please don't reply)</p>

<p>Regards</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 Support Team: <a href="<?php echo $_smarty_tpl->getVariable('web_domain')->value;?>
" target="_blank"><?php echo $_smarty_tpl->getVariable('web_domain')->value;?>
</a></p>