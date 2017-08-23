<?php /* Smarty version Smarty-3.0.5, created on 2015-09-14 20:42:54
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/moneyselect.html" */ ?>
<?php /*%%SmartyHeaderCode:121717493855f6c0cedb1506-33671409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1656cb777974ba92854fe903d22ad516311e497' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/moneyselect.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121717493855f6c0cedb1506-33671409',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include '/home/ftp/d/dnsdun/wwwroot/framework/smarty/plugins/function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<style>
/* 大屏幕 */
@media (min-width: 1200px) {
	.domain_box{padding-bottom:20px;}
	.r_row{width:1120px;margin:10px auto;}
	.platform{display:inline-block;}
}
/* 平板电脑和小屏电脑之间的分辨率 */
@media (min-width: 768px) and (max-width: 1199px) {
	.domain_box{padding-bottom:20px;}
	.r_row{width:90%;margin:10px auto;}
	.platform{display:inline-block;}
}
/* 横向放置的手机和竖向放置的平板之间的分辨率 */
@media (max-width: 767px) {
	.domain_box{padding-bottom:20px;}
	.r_row{width:90%;margin:10px auto;}
	.platform{margin:5px 0;}
}
</style>

<script type='text/javascript'>
function check_submit()
{
	/*
	var gw = $("form[name=moneySelect]").find("[name=gw]:checked").val();
	if (gw==3) {
		var  userAgent = navigator.userAgent.toLowerCase();
		if (userAgent.indexOf('firefox')!==-1) {
			alert("使用财付通支付建议使用IE或chmore浏览器");
		}
	}
	*/
	moneySelect.submit();
}
</script>
<div class="wrap">
	<div class="contain">
	<header class="jumbotron subhead" id="overview">
  		<div class="container">
    		<h1><?php echo $_smarty_tpl->getVariable('session')->value['web_name'];?>
智能解析系统</h1>
    		<p class="lead">最稳定,最安全的域名解析服务</p>
  		</div>
	</header>
	<div class="domain_box">
    <div class="alert alert-success r_row" style="margin-top:6px;border-radius:0;">
    <span class="btn btn-link">
    <?php echo $_smarty_tpl->getVariable('session')->value['web_name'];?>
,现在购买一年可优惠两个月
   </span>
    
    </div>
    <div class="alert r_row" style="margin-top:6px;border-radius:0;">
      <form action="?c=user&a=addMoney" method="POST" name="moneySelect">
        <div>请选择您的支付方式( 充值金额:<b class="font-red"><?php echo $_smarty_tpl->getVariable('money')->value;?>
</b>元)</div>
        <div style="margin-left: 100px; margin-top: 20px;">
          <?php if (!$_smarty_tpl->getVariable('alipay_disable')->value){?>
          <div class="platform">
          	<input type='radio' name="gw" value=1 checked>
          	<img src="/style/img/alipay.gif">
          </div>
          <?php }?>
          <?php if (!$_smarty_tpl->getVariable('chinapay_disable')->value){?>
          <div class="platform">
          <input type="radio" name="gw" value=2 <?php if ($_smarty_tpl->getVariable('alipay_disable')->value){?>checked<?php }?>>
          <img src="/style/img/chinapay.jpg" class="img-polaroid" style="width: 160px; height: 40px">
          </div>
          <?php }?>
          
          <?php if (!$_smarty_tpl->getVariable('tenpay_disable')->value){?>
          <div class="platform">
          <input type="radio" name="gw" value=3 <?php if ($_smarty_tpl->getVariable('alipay_disable')->value){?>checked<?php }?>>
          <img src="/pay/tenpay/image/cft.gif" class="img-polaroid" style="width: 160px; height: 40px">
          </div>
          <?php }?>
          <input name="money" type="hidden" value="<?php echo $_smarty_tpl->getVariable('money')->value;?>
">
        </div>
        <div>
          <input type="button" onclick="check_submit()" value="确定充值" class="btn btn-primary" style="margin-left: 200px; margin-top: 20px;">
        </div>
        
      </form>
    </div>
    
    
    <div class="alert alert-info r_row" style="border-radius:0;">支付成功后,请不要关闭浏览器,回到账户设置界面刷新即可</div>
    </div>
  </div>
</div>
<?php $_template = new Smarty_Internal_Template('public/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
