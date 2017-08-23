<?php /* Smarty version Smarty-3.0.5, created on 2015-10-13 12:35:08
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_monitor.html" */ ?>
<?php /*%%SmartyHeaderCode:1191218763561c89fca3a7e8-29148065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a38e3c1bab35137c54e1545f485de9542d55596' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/attack_event_monitor.html',
      1 => 1444706037,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1191218763561c89fca3a7e8-29148065',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<p>尊敬的<?php echo $_smarty_tpl->getVariable('user')->value;?>
用户：</p>

<p><?php echo $_smarty_tpl->getVariable('monitor')->value['record_name'];?>
.<?php echo $_smarty_tpl->getVariable('monitor')->value['domain'];?>
监控通知:</p>

<p>时间:<?php echo $_smarty_tpl->getVariable('date')->value;?>
</p>

<p>状态:<?php if ($_smarty_tpl->getVariable('monitor')->value['status']==0){?>正常<?php }else{ ?>异常<?php }?></p>

<p>主机:<?php echo $_smarty_tpl->getVariable('monitor')->value['src'];?>
 <?php if ($_smarty_tpl->getVariable('monitor')->value['name']){?></p>

<p>名称:<?php echo $_smarty_tpl->getVariable('monitor')->value['name'];?>
 <?php }?> <?php if ($_smarty_tpl->getVariable('monitor')->value['dst']){?></p>

<p>处理:已切换至<?php echo $_smarty_tpl->getVariable('monitor')->value['dst'];?>
 <?php }?></p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
官方网站：<a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

<p>-------------------------------------------------------------------------------</p>

<p>To our valued <?php echo $_smarty_tpl->getVariable('user')->value;?>
 customer：</p>

<p><?php echo $_smarty_tpl->getVariable('monitor')->value['record_name'];?>
.<?php echo $_smarty_tpl->getVariable('monitor')->value['domain'];?>
 Monitor notification:</p>

<p>Time:<?php echo $_smarty_tpl->getVariable('date')->value;?>
</p>

<p>Status:<?php if ($_smarty_tpl->getVariable('monitor')->value['status']==0){?> Normal <?php }else{ ?> Error <?php }?></p>

<p>Server:<?php echo $_smarty_tpl->getVariable('monitor')->value['src'];?>
 <?php if ($_smarty_tpl->getVariable('monitor')->value['name']){?></p>

<p>Monitor:<?php echo $_smarty_tpl->getVariable('monitor')->value['name'];?>
 <?php }?> <?php if ($_smarty_tpl->getVariable('monitor')->value['dst']){?></p>

<p>Opretion:Changed to <?php echo $_smarty_tpl->getVariable('monitor')->value['dst'];?>
 <?php }?></p>

<p>(System auto-message ,please don't reply)</p>

<p>Regards</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 Support Team: <a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>