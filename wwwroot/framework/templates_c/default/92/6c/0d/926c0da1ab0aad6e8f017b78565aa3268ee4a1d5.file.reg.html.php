<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:53
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/reg.html" */ ?>
<?php /*%%SmartyHeaderCode:143116044256786bcd4c17c4-43521856%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '926c0da1ab0aad6e8f017b78565aa3268ee4a1d5' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/reg.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143116044256786bcd4c17c4-43521856',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- 阴影 -->
<div class="header_c2 i_header_c"></div>

<div class="clear_div login_box">
  <div class="clear_div login_w">
    <div class="login_l">
      <form action="/user/?c=public&a=register" method="post" id="register-from" class="form-horizontal">
        <table class="login_table">
          <tr>
            <th colspan="2"><span class="th">注册新用户</span><em class="red_link">已有账号？ 直接<a href="?c=public&a=login">登录</a>&gt;
            </em></th>
          </tr>

          <tr>
            <td class="r_text"><label for="r_1">邮箱:</label></td>
            <td><input type="text" class="email_text" id="r_1" name="email" placeholder="Email" required></td>
          </tr>
          <tr>
            <td class="r_text" style="vertical-align: top;"><span class="note_red">*</span><label for="r_2">密码:</label></td>
            <td><input type="password" class="pass_text" id="r_2" name="passwd" placeholder="password"	required>
              <ul class="pass_o">
                <li><span>弱</span></li>
                <li style="background: #f0cd28;"><span>中</span></li>
                <li style="background: #e3443d;"><span>强</span></li>
              </ul></td>
          </tr>
          <tr>
            <td class="r_text"><label for="r_3">姓名:</label></td>
            <td><input type="text" class="login_text" id="r_3" name="name"></td>
          </tr>
          <tr>
            <td></td>
            <td><label for="r_3"><input type="checkbox" class="checlass" id="r_3"  name="agreement" value=1 checked><a
                href="user/?c=public&a=pact" target="_blank">我已阅读并接受版权声明和隐私保护条款</a></label></td>
          </tr>
          <tfoot>
            <tr>
              <td></td>
              <td><input type="submit" class="reg_btn th" value="立即注册"></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
    <!--end左边-->
    <div class="login_r">
      <img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/login/01.gif" alt="" width="355" height="230">
      <p>
        <a href="?c=public&a=login">马上登陆</a>，即可使用免费稳定的智能解析服务
      </p>
    </div>
    <!--end右边-->
  </div>
  <!--end宽度-->
</div>
<!--end中间区域-->

<!--end文件脚下-->
<?php $_template = new Smarty_Internal_Template('public/float2.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

