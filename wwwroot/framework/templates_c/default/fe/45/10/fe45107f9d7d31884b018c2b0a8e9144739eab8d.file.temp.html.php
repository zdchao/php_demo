<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 20:33:10
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domains/temp.html" */ ?>
<?php /*%%SmartyHeaderCode:13164662255f0270633a525-02563962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe45107f9d7d31884b018c2b0a8e9144739eab8d' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/domains/temp.html',
      1 => 1437962550,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13164662255f0270633a525-02563962',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/template" id="piao-edit-server-template">
<div id="edit-server-div">
	<p><img src="/style/dot.gif">请确认新的server是已存在的</p>
	<p style="margin-top:20px">
		新的server:
		<!--<input name="new_server"  type="text"><input type=button value="修改" class="btn" id="enter">-->
		{{{select}}}
	</p>
</div>
</script>
<script type="text/template" id="piao-set-pidexpiretime-template">
<div id="set-pidexpiretime-div">
	<div class="piao_div">当前操作域名:<big class="green">{{name}}</big></div>
	<div class="piao_div">新的过期时间:<input name="pid_expire_time" id="piao_pid_expire_time" value="{{pidexpiretime}}" class="jcDate jcDateIco">
	<input type=button value="修改" id="enter" class="btn"></div>
</div>
</script>
<script type="text/template" id="piao-set-adminremark-template">
<div id="set-adminremark-div">
	<div class="piao_div">&nbsp; 备 注 :<textarea id="piao_admin_remark" name="admin_remark" rows=8 cols=44></textarea></div>
	<div class="piao_div"><span class="pull-right"><input type="button" id="enter" value="设置" class="btn"></span></div>
</div>
</script>
<script type="text/template" id="piao-edit-rrl-template">
<div id="edit-rrl-div">
	<div>请使用双引号<b class="red">(单引号会引起数据错误)</b></div>
	<div style="margin-top:20px;">rrl:<textarea id="edit_rrl" name="rrl" rows="8" cols="40" >{{rrl}}</textarea></div>
	<div ><span class="pull-right"><input type="button" class="btn" id="enter" value="确定"></span></div>
</div>
</script>
<script type="text/template" id="piao-edit-ns-template">
<div id="edit-ns-div">
	<div><img src="/style/dot.gif">值为0则后台随机,功能已迁至proxy面板操作</div>
	<div class='piao_div'>NS1:<input name='ns1' id='edit_ns1' value=0></div>
	<div class='piao_div'>NS2:<input name='ns2' id='edit_ns2' value=0></div>
	<div ><input type='button' id="enter" value='提交'></div>
</div>
</script>
<script type="text/template" id="piao-edit-groupview-template">
<div id="edit-groupview-template">
	<form action='?c=domains&a=editGroupview&domain={{domain}}&server={{server}}' method='POST'>
	<p style="margin-top:20px">线路组:<input name="group_view" type="text" value="{{groupview}}"><input type="submit" class="btn" value="提交"></p>
	</form>
</div>
</script>
<script type="text/template" id="piao-custom-ns-template">
<div id="custom-ns-div">
	<p title='为空则取用户里的ns1 name'>ns1:<input id='custom_ns1' placeholder='ns1.dnsdun.com' name='ns1'></p>
	<p title='为空则取用户里的ns2 name'>ns2:<input id='custom_ns2' placeholder='ns2.dnsdun.com' name='ns2'></p>
	<p title='为空则取用户里的soa email'>soa邮箱:<input id='custom_email' placeholder='admin@dnsdun.com' name='custom'></p>
	<p><input type='button' id="enter" class="btn" value='修改'></p>
</div>
</script>
<script type="text/template" id="domain-set-pid-template">
<div id="domain-set-pid-div">
	<div><img src="/style/dot.gif">定制套餐可设置续费的价格</div>
	<div class="piao_div">当前域名:<big class="green"><b>{{name}}</b></big>&nbsp;<span id="show_pay_pid_name"></span></div>
	<div class="piao_div">选择套餐:<select name="pid" id="set_pid">{{{producthtml}}}</select><span id="this_pid_msg"></span></div>
	<div class="piao_div">购买时间:<select id="piao_month" name='month'>
									<option value=0 selected>无</option>
									<option value=1>一月</option>
									<option value=3>三月</option>
									<option value=6>六月</option>
									<option value=12>一年</option>
									<option value=24>二年</option>
								</select>
	</div>
	<div class="piao_div">已 付 款:<input type="checkbox" id="piao_ispay" value=1>勾选后不会再从用户账号上扣钱</div>
	<div class="piao_div">续费价格:<input name="pid_price" id="piao_pid_price" value="{{pid_price}}">元/每月,为0使用套餐内定义的价格</div>
	<div class="piao_div">增加备注:<textarea id="piao_admin_remark"  name="admin_remark"  rows=2 cols=44></textarea></div>
	<div class="piao_div"><span class="pull-right"><input type="button" id='enter' value="设置" class="btn" ></span></div>
</div>
</script>
<script type='text/template' id="domain-add-movecited-template">
<div id="domain-add-movecited-div" style="width:400px">
	<div class="piao_div"><span style="font-size:20px;">确定要对当前域名进行迁引吗?</span></div>
	<div class="piao_div"><span class="pull-right"><button class="btn" id="enter">迁引</button></span></div>
</div>
</script>
<script type='text/template' id="domain-add-blockns-template">
<div id="domain-add-blockns-div" style="width:400px">
	<div class="piao_div">当前域名:<big class="green"><b>{{name}}</b></big></div>
	<div class="piao_div"><span class="pull-right"><button class="btn" id="enter">增加阻断NS</button></span></div>
</div>

</script>
<script type="text/template" id="admin-add-domain-template">
<div id="admin-add-domain-div" style="width:400px;">
	<div class="piao_div">域名:<input id="domainName" type="text" style="width:300px;"/></div>
	<div class="piao_div">UID:<input id="userID" type="text" style="width:300px;" placeholder="用户的UID"/></div>
	<div class="piao_div">server:<input id="server" type="text" style="width:300px;" placeholder="用户的server"/></div>
	<div class="piao_div"><span class="pull-right"><button class="btn" id="enter">确定</button></span></div>
</div>
</script>
<script type="text/template" id="confirm-template">
<div id="confirm-div">
	<div style="font-size:18px;">{{tip}}</div>
	<div style="margin-top:10px;" ><span class="pull-right"><input type="button" class="btn" value="确定" id="enter"/></span></div>
</div>
</script>