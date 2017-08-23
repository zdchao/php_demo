<?php /* Smarty version Smarty-3.0.5, created on 2015-09-22 14:25:47
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/domain_admin_status.html" */ ?>
<?php /*%%SmartyHeaderCode:446500745600f46b160af0-59849856%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8146ace61a0aa28cb5e6a83b618f2d72d1114a6f' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/domain_admin_status.html',
      1 => 1438849678,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '446500745600f46b160af0-59849856',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p>尊敬的<?php echo $_smarty_tpl->getVariable('user')->value;?>
用户：</p>

<p>您好！</p>

<p>您的域名：<?php echo $_smarty_tpl->getVariable('domain')->value;?>
<?php if ($_smarty_tpl->getVariable('status')->value!=0){?>已被管理员禁用<?php }else{ ?>已恢复使用<?php }?></p>

<p>详情请登陆网站查询或联系客服.</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
运营团队祝您使用愉快.</p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
官方网站：<a href='http://www.cloud.ph/' target=_blank>http://www.cloud.ph/</a></p>

