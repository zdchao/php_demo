<?php /* Smarty version Smarty-3.0.5, created on 2016-08-31 04:51:35
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/index.html" */ ?>
<?php /*%%SmartyHeaderCode:88844308757c5f1d750e874-69198982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23bb284e5e313e2143139af6736a089103d6d433' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/index.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88844308757c5f1d750e874-69198982',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!--end头文件中-->
<div class="header_c3"></div>
<div class="tab h_flash">
	<ul>
		<li style="display:block;" class="b_1"><a href="?c=public&a=products"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/banner/01.jpg" alt="" width="1000" height="485" /></a></li>
		<li class="b_2"><a href="?c=public&a=buy"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/banner/02.jpg" alt="" width="1000" height="485" /></a></li>
		<li class="b_3"><a href="?c=public&a=buy"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/banner/03.jpg" alt="" width="1000" height="485" /></a></li>
		<li class="b_4"><a href="?c=public&a=buy"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/banner/04.jpg" alt="" width="1000" height="485" /></a></li>
	</ul>
<div class="num h_flash_num">
	<dl><dd class="cur">1</dd><dd>2</dd><dd>3</dd><dd>4</dd></dl>
</div>
<div class="f_light png_bj"></div>
</div>
<!--end_jquery图片播放-->

<div class="clear_div2 h_center">
<div class="h_tool">
	<ul class="h_tool">
	
		<li><dl><dt><a href="###"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/01.gif" alt="" width="70" height="70"></a></dt>
		<dd><a href="###" class="th">防攻击</a><p>具备超强的攻击防御技术，可抵御超大流量的DDoS攻击及DNS查询攻击，保障您的在线业务高枕无忧</p></dd></dl></li>
		<li><dl><dt><a href="###"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/02.gif" alt="" width="70" height="70"></a></dt>
		<dd><a href="###" class="th">防CC攻击</a><p>DNS的CDN服务，彻底解决您的域名被CC攻击烦恼！</p></dd></dl></li>
		
		<li><dl><dt><a href="###"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/03.gif" alt="" width="70" height="70"></a></dt>
		<dd><a href="###" class="th">智能监控</a><p>服务器宕机？DON＇T PANIC DNS立即帮你切换到可用服务器，永远在线</p></dd></dl></li>
		<li><dl><dt><a href="###"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/04.gif" alt="" width="70" height="70"></a></dt>
		<dd><a href="###" class="th">最精准、细致的区域划分</a><p>我们拥有最权威的地址库，大洲、 国家、 省份、 运营商，任划分</p></dd></dl></li>
		
		<li><dl><dt><a href="###"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/05.gif" alt="" width="70" height="70"></a></dt>
		<dd><a href="###" class="th">实时生效</a><p>修改解析，仅仅2秒就可以同步到所有的DNS服务器、快如闪电</p></dd></dl></li>
		<li><dl><dt><a href="###"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/06.gif" alt="" width="70" height="70"></a></dt>
		<dd><a href="###" class="th">了解更多</a><p>搜索引擎优化，混合泛解析，无线域名，无限记录......</p></dd></dl></li>
	</ul>
</div>
<!--end功能-->
<div class="h_right">
<dl class="r_th"><dd class="th">最新动态<span>news</span></dd><dt><a href="#">+ MORE</a></dt></dl>
	<ul class="clear_div h_news">
          <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('blogs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
    	<li>
             <a href="<?php echo $_smarty_tpl->tpl_vars['row']->value['link'];?>
" target=_blank><?php echo $_smarty_tpl->tpl_vars['row']->value['title'];?>
</a>
        </li>
        <?php }} ?>
	</ul>
<dl class="r_th r_th_gray"><dd class="th">联系我们<span>CONTACT US</span></dd></dl>
<dl class="clear_div h_contact">
<dt><p><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/tel.gif" alt="contact" width="35" height="43"></p></dt>

<dd>客服 QQ：<a href="tencent://message/?uin=2653705417&amp;Site=www.dnsdun.com&amp;Menu=yes" class="qq_btn png_bj">QQ交谈</a></dd><br />
<dd><div style="height:5px;"></div></dd>
<dd>客服 QQ：<a href="tencent://message/?uin=1679763385&amp;Site=www.dnsdun.com&amp;Menu=yes" class="qq_btn png_bj">QQ交谈</a></dd>
<dd><p><span class="th">服务热线：400-807-9103</span><p>QQ交流群：<a href="###">179133623</a></p></dd>
</dl>

</div>
<!--end右边-->
</div>
<!--end中间区域-->
<?php $_template = new Smarty_Internal_Template('public/float.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
