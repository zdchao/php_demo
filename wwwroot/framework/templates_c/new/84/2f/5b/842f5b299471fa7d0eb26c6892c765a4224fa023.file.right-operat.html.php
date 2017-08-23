<?php /* Smarty version Smarty-3.0.5, created on 2016-01-28 16:21:54
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/right-operat.html" */ ?>
<?php /*%%SmartyHeaderCode:65388494056a9cfa2317a11-67440957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '842f5b299471fa7d0eb26c6892c765a4224fa023' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/right-operat.html',
      1 => 1453969310,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65388494056a9cfa2317a11-67440957',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!--  <div class="show-message"><strong ><span class="offset2" id="error-message" ></span></strong></div>-->

<!-- 进度条 

<div id="progress_main" class="progress" style="display:none">

	<div id="progress_success" class="bar bar-success" style="width:0%;"></div>

	<div id="progress_error" class="bar bar-danger" style="width:0%"></div>

</div>-->

<!--  <div class="contain_top">

		<div class="title_logo">

			<a href="?c=public&a=index&groupid=<?php echo $_smarty_tpl->getVariable('groupid')->value;?>
" id="go_home"><i></i></a>

			<span id="domain_name_show"></span><strong id="domain_pname_show">免费版</strong>

		</div>

		<div class="cont_menus">

			<ul id="record-operat">

			<li><a href="javascript:;" id="close">打开</a></li>

			<li id="record"><a href="?c=public&a=record">记录管理</a></li>

			<li id="query"><a href="?c=public&a=recordQuery">解析统计</a></li>

			<li id="line"><a href="?c=public&a=line">线路管理</a></li>

			<li id="monitor"><a href="?c=public&a=monitorLog">监控日志</a></li>

			<li id="operat"><a href="?c=public&a=operatLog">操作日志</a></li>

			<li id="setting"><a href="?c=public&a=domainSetting">域名设置</a></li>

			<?php if ($_smarty_tpl->getVariable('iscdn')->value==1){?>

			<li id="cdn_cg"><a href="?c=public&a=cdnCg">CDN设置</a></li>

			<li id="cdnflow"><a href="?c=public&a=cdnflow">CDN流量</a></li>

			<li id="connection"><a href="?c=public&a=connection">连接信息</a></li>

			<?php }?>

		

			</ul>

		</div>

</div>-->

<div id="nr_left">

    <!----二级导航------>

    <div class="ejdh">

	    <ul  id="record-operat">
			<li><a href="?c=public&a=index" id="nav_domain" style="margin-left:35px; background:none;">域名管理</a></li>
            
		    <li id="record"><a href="?c=public&a=record"><span><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/xinkehu.png" /></span>记录管理</a></li>

			<li id="query"><a href="?c=public&a=recordQuery"><span><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/kehuzhuangyi.png" /></span>解析统计</a></li>

			<li id="line"><a href="?c=public&a=line"><span><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/xinqiandan.png"  /></span>线路管理</a></li>

			<li id="monitor"><a href="?c=public&a=monitorLog"><span><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/pinglun.png"  /></span>监控日志</a></li>

			<li id="operat"><a href="?c=public&a=operatLog"><span><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/wodehuifu.png"/></span>操作日志</a></li>

			<li id="setting"><a href="?c=public&a=domainSetting"><span><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/gerenshezhi_hui.png" /></span>域名设置</a></li>

	    </ul>

    </div>

</div>

