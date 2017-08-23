<?php /* Smarty version Smarty-3.0.5, created on 2015-09-10 17:43:35
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/setting/add.html" */ ?>
<?php /*%%SmartyHeaderCode:113235216755f150c782f800-54772819%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06cb6de1157843a05be3004b827eaf8e4c171dfd' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/setting/add.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113235216755f150c782f800-54772819',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<script type="text/template" id="money-template">
<div id="money-div"> 
    <div class="piao_div">别名:{{nickname}}</div>
    <div class="piao_div">网站域名:{{web_host}}</div>
    <div class="piao_div">网站名称:{{web_name}}</div>
    <div class="piao_div">账户余额:{{money}}</div>
</div>
</script>
<script type='text/javascript'>
	var msg = "<?php echo $_smarty_tpl->getVariable('msg')->value;?>
";
	$(document).ready(function() {

	});
	function getSmsInfo(){
		var div = $("#sms");
		var name = div.find("input[name=smsuser]").val();
		var passwd = div.find("input[name=smspasswd]").val();
		$.ajax({
			url:'?c=setting&a=getSmsInfo',
			dataType:'json',
			data:{name:name,passwd:passwd},
			success:function(a){
				if(a.status.code!=1){
					if(a.status.code!=1){
						alert(a.status.message ? a.status.message :"操作失败");
						return;
					}
				}
			    a.userinfo.money = a.userinfo.money/100;
				var html = $("#money-template").html();			
				var el = Mustache.to_html(html,a.userinfo);
				art.dialog({id:'222',lock:true,content:el,title:'账户余额'});
			}
		});
	}
</script>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
  <div align="center">
    <div class="wid_main mar_main" align="left">
      <div class="block_top" align="left">当前位置：系统设置--> 管理设置</div>
      <form action="?c=setting&a=add" method='post' name='setfrom'>
        <table class="table_main2" cellpadding="0" cellspacing="1">
          <tr>
            <td colspan="2" class="bg_main hg_main"><b>支付宝设置</b></td>
          </tr>
          <tr>
            <td class="wid_general">是否启用</td>
            <td><input name='ALIPAY_disable' type='radio' value=1 <?php if ($_smarty_tpl->getVariable('setting')->value['ALIPAY_disable']==1){?>checked<?php }?>>禁用
                <input name='ALIPAY_disable' type='radio' value=0 <?php if ($_smarty_tpl->getVariable('setting')->value['ALIPAY_disable']!=1){?>checked<?php }?>>启用
                </td>
          </tr>
          <tr>
            <td class="wid_general">支付宝账号</td>
            <td><input name='ALIPAY_SELLER_EMAIL' size='28' value='<?php echo $_smarty_tpl->getVariable('setting')->value['ALIPAY_SELLER_EMAIL'];?>
'></td>
          </tr>
          <tr>
            <td class="wid_general">支付宝安全码(key)</td>
            <td><input name='ALIPAY_KEY' size='28' type='password' value='<?php echo $_smarty_tpl->getVariable('setting')->value['ALIPAY_KEY'];?>
'></td>
          </tr>
          <tr>
            <td class="wid_general">合作身份者ID</td>
            <td><input name='ALIPAY_PARTNER' size='28' value='<?php echo $_smarty_tpl->getVariable('setting')->value['ALIPAY_PARTNER'];?>
'></td>
          </tr>
          <tr>
            <td class="wid_general">支付宝接口</td>
            <td><input name='USE_ALIPAY2' type=radio value='1' <?php if ($_smarty_tpl->getVariable('setting')->value['USE_ALIPAY2']==1){?>checked<?php }?>>担保交易 <input name='USE_ALIPAY2'
                type=radio value='0' <?php if ($_smarty_tpl->getVariable('setting')->value['USE_ALIPAY2']==0){?>checked<?php }?>>即时到账 <input name='USE_ALIPAY2' type=radio value='2'
                <?php if ($_smarty_tpl->getVariable('setting')->value['USE_ALIPAY2']==2){?>checked<?php }?>>双功能接口</td>
          </tr>
          <tr>
            <td class="wid_general">收款方名称</td>
            <td><input name='ALIPAY_MAINNAME' size='28' value='<?php echo $_smarty_tpl->getVariable('setting')->value['ALIPAY_MAINNAME'];?>
'></td>
          </tr>
          <!-- 在线网银 -->
          <tr>
            <td colspan="2" class="bg_main hg_main"><b>chinapay在线网银设置</b></td>
          </tr>
          <tr>
            <td class="wid_general">是否启用</td>
            <td><input name='chinapay_disable' type='radio' value=1 <?php if ($_smarty_tpl->getVariable('setting')->value['chinapay_disable']==1){?>checked<?php }?>>禁用
                <input name='chinapay_disable' type='radio' value=0 <?php if ($_smarty_tpl->getVariable('setting')->value['chinapay_disable']!=1){?>checked<?php }?>>启用
                </td>
          </tr>
          <tr>
            <td class="wid_general">商户编号</td>
            <td><input name='chinapay_v_mid' size='28'  value='<?php echo $_smarty_tpl->getVariable('setting')->value['chinapay_v_mid'];?>
'></td>
          </tr>
          <!-- 财付通 -->
            <tr>
            <td colspan="2" class="bg_main hg_main"><b>财付通支付设置</b></td>
          </tr>
          <tr>
            <td class="wid_general">是否启用</td>
            <td><input name='tenpay_disable' type='radio' value=1 <?php if ($_smarty_tpl->getVariable('setting')->value['tenpay_disable']==1){?>checked<?php }?>>禁用
                <input name='tenpay_disable' type='radio' value=0 <?php if ($_smarty_tpl->getVariable('setting')->value['tenpay_disable']!=1){?>checked<?php }?>>启用
                </td>
          </tr>
          <tr>
            <td class="wid_general">商户名称</td>
            <td><input name='tenpay_name' size='28'  value='<?php echo $_smarty_tpl->getVariable('setting')->value['tenpay_name'];?>
'></td>
          </tr>
          <tr>
            <td class="wid_general">商户号</td>
            <td><input name='tenpay_user' size='28'  value='<?php echo $_smarty_tpl->getVariable('setting')->value['tenpay_user'];?>
'></td>
          </tr>
          <tr>
            <td class="wid_general">密钥</td>
            <td><input name='tenpay_key' size='28'  value='<?php echo $_smarty_tpl->getVariable('setting')->value['tenpay_key'];?>
' type='password'></td>
          </tr>
          <!-- 邮件 -->
          <tr>
            <td colspan="2" class="bg_main hg_main"><b>邮件设置</b></td>
          </tr>
          <tr>
            <td class="wid_general">发送方式</td>
            <td><input type='radio' name="mail_model" value="smtp" <?php if ($_smarty_tpl->getVariable('setting')->value['mail_model']!='sendcloud'){?>checked<?php }?>>smtp 
                <input type='radio' name="mail_model" value="sendcloud" <?php if ($_smarty_tpl->getVariable('setting')->value['mail_model']=='sendcloud'){?>checked<?php }?>>sendcloud web api
             </td>
          </tr>
          <tr>
            <td class="wid_general">SMTP设置</td>
            <td>smtp主机:<input name='mail_host' size='18' value='<?php echo $_smarty_tpl->getVariable('setting')->value['mail_host'];?>
' placeholder="smtp.gmail.com"> 端口:<input name='mail_port'
                size='8' value='<?php echo $_smarty_tpl->getVariable('setting')->value['mail_port'];?>
' placeholder="465"> <br> 账号:<input name='mail_user' size='32' value='<?php echo $_smarty_tpl->getVariable('setting')->value['mail_user'];?>
'
                placeholder="security621@gmail.com"> 密码:<input name='mail_passwd' size='16' type='password' value='<?php echo $_smarty_tpl->getVariable('setting')->value['mail_passwd'];?>
'> <br>
              发送者邮箱:<input name='mail_from' size='32' value='<?php echo $_smarty_tpl->getVariable('setting')->value['mail_from'];?>
' placeholder="可以同账号"> 发送人名称:<input name='mail_fromname' size='32'
                value='<?php echo $_smarty_tpl->getVariable('setting')->value['mail_fromname'];?>
'>
            </td>
          </tr>
          <tr>
            <td class="wid_general">sendCloud设置</td>
            <td>触发账号:<input name='sendcloud_apiuser' size='32' value='<?php echo $_smarty_tpl->getVariable('setting')->value['sendcloud_apiuser'];?>
' placeholder="postmaster@dnsdunkf.sendcloud.org">
              触发账号密码:<input name='sendcloud_apikey' size='16' type='password' value='<?php echo $_smarty_tpl->getVariable('setting')->value['sendcloud_apikey'];?>
'>*用于发送一封邮件时 <br> 批量账号:<input
                name='sendcloud_multi_apiuser' size='32' value='<?php echo $_smarty_tpl->getVariable('setting')->value['sendcloud_multi_apiuser'];?>
' placeholder="postmaster@dnsdun.sendcloud.org">
              批量账号密码:<input name='sendcloud_multi_apikey' size='16' type='password' value='<?php echo $_smarty_tpl->getVariable('setting')->value['sendcloud_multi_apikey'];?>
'>*用于发送多个邮箱 <br>
              发送者邮箱:<input name='sendcloud_from' size='32' value='<?php echo $_smarty_tpl->getVariable('setting')->value['sendcloud_from'];?>
' placeholder="邮箱格式"> 发送人名称:<input
                name='sendcloud_fromname' size='16' value='<?php echo $_smarty_tpl->getVariable('setting')->value['sendcloud_fromname'];?>
' placeholder="">
            </td>
          </tr>
          <tr>
            <td colspan="2" class="bg_main hg_main"><b>短信接口设置</b></td>
          </tr>
               <td class="wid_general">接口账号密码相关设置</td>
            <td id= "sms">
            		短信接口账号:<input name='smsuser' size='28' value='<?php echo $_smarty_tpl->getVariable('setting')->value['smsuser'];?>
'>
            		短信接口密码:<input name='smspasswd'  type="password" size='28' value='<?php echo $_smarty_tpl->getVariable('setting')->value['smspasswd'];?>
'>
            		[<a href="javascript:getSmsInfo()">余额查询</a>]<br/>
            </td>
          </tr>
          </tr>
               <td class="wid_general">短信收费设置</td>
            <td id= "sms">
            		短信发送每条:<input name='smsMoney' size='8' value='<?php echo $_smarty_tpl->getVariable('setting')->value['smsMoney'];?>
'>/分
            </td>
          </tr>
          <tr>
            <td colspan="2" class="bg_main hg_main"><b>产品设置</b></td>
          </tr>
          <tr>
            <td class="wid_general">域名添加时产品免费天数</td>
            <td>
            		<input name='domain_free_day' size='6' value='<?php echo $_smarty_tpl->getVariable('setting')->value['domain_free_day'];?>
'>天，注意：设置该项，则需要server处设置默认产品。
            </td>
          </tr>
            <tr>
            <td class="wid_general">后台备份通知接收微信ID(多个用,号分开)</td>
            <td>
            		<input type="text" size="48" name='receive_backup' value="<?php echo $_smarty_tpl->getVariable('setting')->value['receive_backup'];?>
">微信
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type='submit' value='确定'>&nbsp;&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
  </div>