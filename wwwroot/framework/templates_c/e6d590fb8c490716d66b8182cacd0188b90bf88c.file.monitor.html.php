<?php /* Smarty version Smarty-3.0.5, created on 2015-10-15 18:14:08
         compiled from "/home/ftp/d/dnsdun/wwwroot/framework/templete/monitor.html" */ ?>
<?php /*%%SmartyHeaderCode:789957114561f7c7016f166-38590737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6d590fb8c490716d66b8182cacd0188b90bf88c' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/framework/templete/monitor.html',
      1 => 1444706621,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '789957114561f7c7016f166-38590737',
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

<p>域名:<?php echo $_smarty_tpl->getVariable('domain')->value;?>
</p>

<p>服务器:<?php echo $_smarty_tpl->getVariable('domainip')->value;?>
</p>

<p>时间:<?php echo $_smarty_tpl->getVariable('date')->value;?>
</p>

<p>状态:<?php if ($_smarty_tpl->getVariable('status')->value===0){?> 已恢复正常访问 <?php }elseif($_smarty_tpl->getVariable('status')->value===1){?> 宕机 <?php }else{ ?> 开启监控成功 <?php }?></p>

<p>系统发信，请勿回复</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
官方网站：<a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>

<p>-------------------------------------------------------------------------------</p>

<p>To our valued <?php echo $_smarty_tpl->getVariable('user')->value;?>
 customer：</p>

<p><?php echo $_smarty_tpl->getVariable('monitor')->value['record_name'];?>
.<?php echo $_smarty_tpl->getVariable('monitor')->value['domain'];?>
 Monitor notification:</p>

<p>Domain:<?php echo $_smarty_tpl->getVariable('domain')->value;?>
</p>

<p>Server:<?php echo $_smarty_tpl->getVariable('domainip')->value;?>
</p>

<p>Time:<?php echo $_smarty_tpl->getVariable('date')->value;?>
</p>

<p>Status:<?php if ($_smarty_tpl->getVariable('status')->value===0){?> Back online <?php }elseif($_smarty_tpl->getVariable('status')->value===1){?> Down <?php }else{ ?> Monitor has been turned on <?php }?></p>

<p>(Sytem auto-message , please don't reply)</p>

<p>Regards</p>

<p><?php echo $_smarty_tpl->getVariable('web_name')->value;?>
 Support Team: <a href="http://www.cloud.ph" target="_blank">http://www.cloud.ph</a></p>