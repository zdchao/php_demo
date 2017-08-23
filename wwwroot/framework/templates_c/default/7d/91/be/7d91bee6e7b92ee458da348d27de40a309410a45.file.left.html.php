<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 17:37:31
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/left.html" */ ?>
<?php /*%%SmartyHeaderCode:155842456855effddbd0b315-93957369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d91bee6e7b92ee458da348d27de40a309410a45' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/left.html',
      1 => 1440492128,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155842456855effddbd0b315-93957369',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/left.css"

	type="text/css" media="all" />

<link rel="stylesheet" rev="stylesheet"

	href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/public.css" type="text/css" media="all" />

<style type='text/css'>

.one {

	font-size: 20;

	color: red;

}

</style>

<script type="text/javascript">

	function SwitchMenu(obj, sty) {

		if (document.getElementById) {

			var el = document.getElementById(obj);

			var ml = document.getElementById(sty);

			var ar = document.getElementById("masterdiv").getElementsByTagName("ul");

			var mr = document.getElementById("masterdiv").getElementsByTagName("h1");

			if (el.style.display == "none") {

				el.style.display = "block";

				ml.className = "menu";

			} else {

				el.style.display = "none";

				ml.className = "menu1";

			}

		}

	}

</script>

<body style="overflow-x:hidden; overflow-y:hidden;">

	<div id="masterdiv" style="overflow-y:scroll; overflow-x: hidden;">

		<h1 id="m1" onClick="SwitchMenu('sub1','m1')" class="menu">服务器管理</h1>

			<ul class="submenu left_linght" id="sub1">

				<li><a href="?c=index&a=main" target='main'><?php echo $_smarty_tpl->getVariable('lang')->value['myinfo'];?>
</a></li>

				<li><a href="?c=admins&a=pagelist" target='main'>管理列表</a></li>

				<li><a href="?c=setting&a=addFrom" target='main'>管理设置</a></li>

				<li><a href="?c=adminlog&a=pagelist" target='main'>管理日志</a></li>



				<li><a href="?c=mail&a=index" target='main'>邮件推送</a></li>

				<!--  

				<li><a href="?c=mail&a=template" target='main'>邮件模板</a></li>

								<li><a href="?c=blog&a=pagelist" target='main'>blog设置</a></li>

				<li><a href="?c=setting&a=proxy" target='main'>代理相关设置</a></li>-->

				<!--  

				<li><a href="?c=allowserver&a=pagelist" target='main'>允许server</a></li>

				-->

				<li><a href="?c=domaintld&a=pagelist" target='main'>域名后缀管理</a></li>

				<li><a href="?c=server&a=pagelist" target='main'>server列表</a></li>

				<li><a href="?c=database&a=pagelist" target="main">数据库检测</a></li>

				<li><a href="?c=domainreserved&a=pagelist" target="main">预留域名</a></li>

				<li><a href="?c=message&a=pagelist" target="main">信息模拟</a></li>

			</ul>

			<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu">产品管理</h1>

			<ul class="submenu left_linght" id="sub6">

				<li><a href="?c=product&a=pagelist" target='main'>产品列表</a></li>

				

			</ul>

		<h1 id="m8" onClick="SwitchMenu('sub8','m8')" class="menu">财务管理</h1>

			<ul class="submenu left_linght" id="sub8">

				<li><a href="?c=moneylog&a=pagelist" target='main'>金额列表</a></li>

				<!-- 

				<li><a href="?c=promostr&a=pagelist" target='main'>优惠信息</a></li>

				<li><a href="?c=proxyrecord&a=pagelist"  target='main'>代理分成</a></li>

				 -->

			</ul>

		<h1 id="m2" onClick="SwitchMenu('sub2','m2')" class="menu">用户管理</h1>

			<ul class="submenu left_linght" id="sub2">

				<li><a href="?c=users&a=pagelist" target='main'>用户列表</a></li>

			</ul>

		<h1 id="m3" onClick="SwitchMenu('sub3','m3')" class="menu">域名解析管理</h1>

			<ul class="submenu left_linght" id="sub3">

				<li><a href="?c=domains&a=pagelist" target='main'>域名列表</a></li>

				<li><a href="?c=domains&a=pagelistexpire" target='main'>过期域名</a></li>

				<li><a href="?c=records&a=query" target='main'>解析量排名</a></li>

				<li><a href='?c=monitor&a=pagelist' target='main'>监控记录</a></li>

				<li><a href="?c=attack&a=pagelist" target='main'>迁引列表</a>

			</ul>

			<!--  

		<h1 id="m7" onClick="SwitchMenu('sub7','m7')" class="menu">域名迁引管理</h1>

			<ul class="submenu left_linght" id="sub7">

			<li><a href="?c=attack&a=pagelist" target='main'>迁引列表</a>

			<li><a href="?c=blockns&a=pagelist" target='main'>阻断ns列表</a></li>

			</ul>

			-->

		<h1 id="m4" onClick="SwitchMenu('sub4','m4')" class="menu">线路管理</h1>

			<ul class="submenu left_linght" id="sub4">

				<li><a href="?c=views&a=pagelist" target='main'>线路列表</a></li>

				<li><a href="?c=groupview&a=pagelist" target='main'>线路组列表</a></li>

			</ul>

		<h1 id="m5" onClick="SwitchMenu('sub5','m5')" class="menu">NS管理</h1>

			<ul class="submenu left_linght" id="sub5">

				<!--  

				<li><a href="?c=ns&a=iplist" target='main'>ip列表</a></li>

				-->

				<li><a href="?c=ns&a=nslist" target='main'>ns列表</a></li>

				<!-- 

				<li><a href="?c=ns&a=oplog" target='main'>ns日志</a></li>

				 -->

			</ul>

			<?php if ($_smarty_tpl->getVariable('iscdn')->value==1){?>

		<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu">cdn管理</h1>

			<ul class="submenu left_linght" id="sub6">

				<li><a href="?c=cdnproduct&a=pagelist" target='main'>cdn产品</a></li>

				<!--  <li><a href="?c=containerproduct&a=pagelist" target='main'>容器产品</a></li>

				<li><a href="?c=cdncontainer&a=pagelist" target='main'>cdn容器</a></li>-->

				<!--  

				<li><a href="?c=cdnsite&a=siteList" target="main">站点列表</a></li>

				-->

				<li><a href="?c=cdnlog&a=pagelist" target='main'>cdn记录</a></li>

				<li><a href="?c=cdnrefundlog&a=pagelist" target='main'>受理退费</a></li>

			</ul>

		<?php }?>

	</div>

</body>

<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

