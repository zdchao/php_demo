<?php /* Smarty version Smarty-3.0.5, created on 2015-12-22 05:14:51
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/login.html" */ ?>
<?php /*%%SmartyHeaderCode:146300103356786bcbdcefe2-71276823%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e38b16c920d567adf9cbbf93fc938d20010d67d' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/public/view/default/public/login.html',
      1 => 1437558939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '146300103356786bcbdcefe2-71276823',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- 阴影 -->
<div class="header_c2 i_header_c"></div>

<div class="mains">

  <div class="clear_div login_box">
    <div class="clear_div login_w">
      <div class="login_l">
 <form action="/user/?c=session&a=login" method="post" class="form-horizontal" id="login-from">
        <table class="login_table">
         
          <tr>
            <th colspan="2"><span class="th">登录</span><em class="red_link">还没有账号？ <a href="?c=public&a=reg">马上注册</a>&gt;
            </em></th>
          </tr>
          <tr>
            <td class="r_text"><span class="note_red">*</span><label for="r_1">用户名:</label></td>
            <td><input type="text" id="inputEmail" placeholder="E-Mail" class="login_text" name="user" placeholder="Email"  required></td>
          </tr>
          <tr>
            <td class="r_text"><span class="note_red">*</span><label for="r_2">密码:</label></td>
            <td><input type="password" id="inputPassword" placeholder="Password" class="pass_text" id="r_2" name="passwd" placeholder="password" required></td>
          </tr>
          <tr>
            <td></td>
            <td><span class="red_link" style="padding-left: 25px;"><a href="/user/?c=public&a=findPasswdFrom">忘记密码？</a></span></td>
          </tr>
          <tfoot>
            <tr>
              <td></td>
              <td><input type="submit" class="login_btn th" value="立即登录"></td>
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
          <a href="?c=public&a=reg">马上注册</a>，即可使用免费稳定的智能解析服务
        </p>
      </div>
      <!--end右边-->
    </div>
    <!--end宽度-->
  </div>
</div>
<!--end中间区域-->
<?php $_template = new Smarty_Internal_Template('public/float2.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
