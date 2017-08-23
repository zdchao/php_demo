<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 19:00:08
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/templete.html" */ ?>
<?php /*%%SmartyHeaderCode:198089986655f01138463206-30785520%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f5f0576e6f0e5fd0dd5c15d7f93ce13ff302aa0' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/templete.html',
      1 => 1438911674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198089986655f01138463206-30785520',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type='text/template' id="user-nologin-template">
<tr id="nologin-row">
	<td class="span2">错误:</td>
	<td class="span8"><a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a></td>
</tr>
</script>
<script type='text/template' id="money-show-template">
<tr id="money-row">
	<td class="span2">
		余额
	</td>
	<td class="span6">{{money}}元</td>
	<td class="span2"><a id="money" href="javascript:;">充值</a></td>
</tr>
</script>
<script type='text/template' id="money-edit-template">
	<td class="span2">余额</td>
	<td class="span8 responsive-user-set" colspan=2>
			<span>
			充值金额:<input type='text' style="width:120px;" name="money" />元
			<button class="btn_red">确定</button>&nbsp;&nbsp;<button class="btn_grey">取消</button>
			</span>
	</td>
</script>
<script type='text/template' id="money-refresh-template">
	<td class="span2">
		余额
		<!--
		<div class="td_div">
			<span class="icon_yuan"></span>
			<span class="font">余额</span>
		</div>
		-->
	</td>
	<td class="span6">{{money}}元</td>
	<td class="span2"><a id="money" href="javascript:;">充值</a></td>
</script>
<script type='text/template' id="ns-show-template">
<tr id="ns-row">
	<td class="span2">默认NS</td>
	<td class="span6">{{ns1}}&nbsp;&nbsp;&nbsp;{{ns2}}</td>
	<td class="span2"></td>
</tr>
</script>
<script type='text/template' id="tel-show-template">
<tr id="tel-row">
	<td class="span2">手机号码</td>
	<td class="span6 ">{{tel}}
     {{#tel}}
      {{#adminSmsReady}}
    <a  id="sms" href="javascript:;">短信通知</a>
     {{/adminSmsReady}}
    {{/tel}}</td>
	<td class="span2"><a id ="modify" href="javascript:;">修改</a></td>
</tr>
</script>
<script type='text/template' id="tel-refresh-template">
	<td class="span2">手机号码</td>
	<td class="span6 ">{{tel}}
    {{#tel}}
      {{#adminSmsReady}}
    <a  id="sms" href="javascript:;">短信通知</a>
     {{/adminSmsReady}}
    {{/tel}}</td>
	<td class="span2"><a id ="modify" href="javascript:;">修改</a></td>
</script>
<script type = 'text/template' id='sms-edit-template'>
    <td class="span2"> 短信提醒功能 </td>
    <td class="span8" colspan=2>
   <div style="text-align:left;">
         <p>开通短信提醒功能，您可以获得以下几项短信提醒服务：</p>
        <ul>
			<li>1.域名受到攻击</li>
			<li>2.监控通知</li>
			<li>3.每条短信收费{{smsMoney}}元</li>
            <li>4.您还可以发送{{free_message}}条免费短信</li>
		</ul>
       <div class="blank10"></div>
       	{{^sms}}
		<p>新号码:<input name="tel" type='text' id="new-tel" value="{{tel}}" style="width:120px;"/>手机号码通过验证后，才可开通服务!</p>
       <div class="blank10"></div>
		 <p>验证码:<input name="code" type='text' id="code" value="{{code}}" style="width:120px;"/><button class="btn" id="get-code">获取验证码</button><b id = "clock"></b></p>
		{{/sms}}
		<div class="blank10"></div>
		<p>
		{{^sms}}
     			<a  id="enter">	<span class="btn">我知道了,立马给我开通	</span ></a>
		{{/sms}}
	    {{#sms}}
			<a id="enter"><span class="btn">取消短信提醒功能</span></a>
		{{/sms}}
		<span ><a class="btn_grey" id="esc">取&nbsp;&nbsp;消</a></span>
		</p>
    <div>
	</td>      
</script>
<script type='text/template' id="tel-edit-template">
	<td class="span2">手机号码</td>
    <td class="span8" colspan=2 style="text-align:left">
      <p>短信提醒功能，您可以获得以下几项短信提醒服务：</p>
  <div class="blank10"></div>
                       <ul>
						<li>1.域名受到攻击</li>
						<li>2.监控通知</li>
						<li>3.每条短信收费{{smsMoney}}元</li>
                        <li>4.你还可以获得{{free_message}}条免费短信</li>
					</ul>
		  <div class="blank10"></div>
		新号码:<input name="tel" type='text' id="new-tel" value="{{tel}}" style="width:120px;"/>手机号码通过验证后，可接收各项短信提醒服务！
  <div class="blank10"></div>
        验证码:<input name="code" type='text' id="code" value="{{code}}" style="width:120px;"/>
      <span  class="btn"  id="get-code">获取验证码</span>
        <b id = "clock"></b><br />
	  <div class="blank10"></div>
		<button class="btn_red" id="enter">确定</button>&nbsp;
		<button class="btn_grey" id="esc">取消</button>
	</td>
</script>
<script type="text/template" id ="tel-editWithoutCode-template">
<td class="span2">手机号码</td>
	<td class="span8" colspan=2>
		<span class="responsive-user-set">
		新号码:<input name="tel" type='text' id="new-tel" value="{{tel}}" style="width:120px;"/>
		<button class="btn_red">确定</button>&nbsp;
		<button class="btn_grey">取消</button>
		</span>
	</td>
</script>
<script type='text/template' id="name-show-template">
<tr id="name-row">
	<td class="span2">联系人</td>
	<td class="span6">{{name}}</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
</tr>
</script>
<script type='text/template' id="name-refresh-template">
	<td class="span2">联系人</td>
	<td class="span6">{{name}}</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
</script>
<script type='text/template' id="name-edit-template">
	<td class="span2">联系人</td>
	<td class="span8 responsive-user-set" colspan=2>
			<span>
			姓名:<input name="name" type='text' value="{{name}}" style="width:120px;"/>
			<button class="btn_red">确定</button>&nbsp;<button class="btn_grey">取消</button>
			</span>
		</td>
</script>
<script type='text/template' id="passwd-show-template">
<tr id="passwd-row">
	<td class="span2">密码</td>
	<td class="span6">定期修改密码是个好习惯!</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
</tr>
</script>
<script type='text/template' id="passwd-refresh-template">
	<td class="span2">密码</td>
	<td class="span6">定期修改密码是个好习惯!</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
</script>
<script type='text/template' id="passwd-edit-template">
	<td class="span2">密码</td>
	<td class="span8 responsive-user-set" colspan=2>
		<span>
		旧密码:<input type='text' name="oldpasswd" style="width:80px;">
		新密码:<input type='text' name="newpasswd" style="width:80px;">
		<button class="btn_red">确定</button>&nbsp;<button class="btn_grey">取消</button>
		</span>
	 </td>
</script>
<script type='text/template' id="moneylog-show-template">
<tr id="moneylog-row">
	<td class="span2">充值消费记录</td>
	<td class="span6">可查看您最近的消费以及充值情况</td>
	<td class="span2"><a href="javascript:;">查看</a></td>
</tr>
</script>
<script type='text/template' id="moneylog-refresh-template">
	<td class="span2">充值消费记录</td>
	<td class="span6">可查看您最近的消费以及充值情况</td>
	<td class="span2"><a href="javascript:;">查看</a></td>
</script>
<script type='text/template' id="monitor-show-mutli-template">
<button id="button" class="btn btn-link">收起aaa</button>
</script>
<script type='text/template' id="moneylog-list-show-template">
<td class="span12" colspan=4>
	<table class="" style="width:100%;">
		<thead title="点击关闭">
		<tr>
			<th class="span3">时间</th>
			<th class="span1">类型</th>
			<th class="span2">金额(元)</th>
			<th class="span9">备注/订单号</th>
		</tr>
		</thead>
		<tbody id="list-content">
			
		</tbody>
	</table>
</td>
</script>
<script type="text/template" id="moneylog-list-close-template">
<tr id="tr1">
	<td id="td1" class="span" colspan=3>&nbsp;</td>
	<td id="zhdc" colspan=2>
		<button id="button" class="btn btn-link">收起</button> 
		<button id="button1" class="btn btn-link">查询更多>></button>
	</td> 
</tr>
</script>
<script type='text/template' id="moneylog-list-row-template">
	<tr>
		<td class="span3">{{create_time}}</td>
		<td class="span1">{{type}}</td>
		<td class="span2">{{money}}</td>
		<td class="span9">{{domain}}{{mem}}</td>
	</tr>
</script>
<script type='text/template' id="proxy-show-template">
<tr id="proxy-row">
	<td class="span2">代理分成比例</td>
	<td class="span6">{{divided}}%</td>
	<td class="span2"><a href="javascript:;">查看</a></td>
</tr>
</script>
<script type='text/template' id="proxy-refresh-template">
	<td class="span2">代理分成比例</td>
	<td class="span6">{{divided}}%</td>
	<td class="span2"><a href="javascript:;">查看</a></td>
</script>
<script type='text/template' id="proxy-list-show-template">
<td class="span12" colspan=4>
	<table class="table">
		<thead>
			<th class="span3 btn-link">消费时间</th>
			<th class="span3 btn-link">消费域名</th>
			<th class="span3 btn-link">分成金额(元)</th>
			<th class="span3 btn-link">消费备注</th>
		</thead>
		<tbody id="proxy_user_rows">
		</tbody>
		<tfoot id="more_proxy">
			<tr id="tr_row"><td >&nbsp;</td>
			<td ><button class="btn btn-link" id="closed">收起</button></td>
			<td>
				<button class="btn btn-link" id="next">查看更多>></button></td>
			<td>&nbsp;</td></tr>
		</tfoot>
	</table>
</td>
</script>
<script type='text/template' id="proxy-list-row-template">
	<tr>
		<td>{{create_time}}</td>
		<td>{{domain}}</td>
		<td>{{proxy_money}}</td>
		<td>{{mem}}</td>
	</tr>
</script>
<script type='text/template' id="weixin-show-template">
<tr id="weixin-row">
{{^openid}}
	<td class="span2">微信帐号</td>
	<td class="span6">未绑定</td>
	<td class="span2"><a href="javascript:;">绑定</a></td>
{{/openid}}
{{#openid}}
<td class="span2">微信帐号</td>
	<td class="span6">已绑定</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
{{/openid}}
</tr>
</script>
<script type='text/template' id="weixin-refesh-template">
{{^openid}}
	<td class="span2">微信帐号</td>
	<td class="span6">未绑定</td>
	<td class="span2"><a href="javascript:;">绑定</a></td>
{{/openid}}
{{#openid}}
    <td class="span2">微信帐号</td>
	<td class="span6">已绑定</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
{{/openid}}
</script>
<!--  
<script type='text/template' id="weixin-Qrcode-template">
       <div style="margin: 10px auto; height:380px; border-radius:4px;text-align:center;color:#666">
           <div style="border-radius:4px 4px 0 0;height:50px;text-shadow:0 1px 0 #fff;font-size:32px;line-height:50px;">扫描二维码</div>
            <div style="padding:20px;">
            <img style="width:200px; box-shadow:0 6px 6px #999999;" src="{{weixin_url}}">
              <div style="margin:10px 0 0;">
                <p style="float:none;text-align:center;font-size:14px;color:#888;">如果您已收听DNS盾公众帐号，可以发送“bind”指令绑定微信</p>
              </div>
            </div>
          </div>     
</script>
-->
<script type='text/template' id="weixin-Qrcode-template">
       <div style="margin: 10px auto; height:380px; border-radius:4px;text-align:center;color:#666">
           <div style="border-radius:4px 4px 0 0;height:50px;text-shadow:0 1px 0 #fff;font-size:32px;line-height:50px;">扫描二维码</div>
            <div style="padding:20px;">
            <img style="width:200px; box-shadow:0 6px 6px #999999;" src="{{weixin_url}}">
              <div style="margin:10px 0 0;">
                <p style="float:none;text-align:center;font-size:14px;color:#888;">如果您已收听DNS盾公众帐号，可以发送“bind”指令绑定微信</p>
              </div>
            </div>
          </div>     
</script>
<script type='text/template' id="weixin-unbinding-template">
<td class="span2">微信帐号</td>
{{#openid}}
<td class="span6" colspan=2>状态:<input name="name" type='text' value="已绑定" style="width:120px;"  disabled/>
{{/openid}}
<button class="btn_red">解绑</button>&nbsp;<button class="btn_grey">取消</button>		
</td>
</script>
<script type="text/template" id="cdn-row-tempalte">
<tr id="cdnproduct-row">
	<td class="span2">CDN设置</td>
	<td class="span6">可以定制自己的CDN产品</td>
	<td class="span2"><a href="javascript:;" id="edit">设置</a></td>
</tr>
</script>
<script type="text/template" id="cdn-row-refresh-tempalte">
	<td class="span2">CDN设置</td>
	<td class="span6">可以定制自己的CDN产品</td>
	<td class="span2"><a href="javascript:;" id="edit">设置</a></td>
</script>
<script type="text/template" id="cdn-edit-template">
<td class="span2">{{title}}</td>
<td class="span6 responsive-user-set responsive-td-height">
	<span>
	cdn用户id:<input name="cdn_uid" type="text" style="width:60px;" value="{{cb_uid}}"/>
	cdn秘钥:<input name="cdn_key" type="text" style="width:140px;"/>
	<i id="operat">
		<button class="btn_red" id="enter">确定</button>
		<button class="btn_grey" id="esc">取消</button>
	</i>
	</span>
</td>
<td class="span2"></td>
</script>
<script type="text/template" id="cdn-self-select-template">
	cdn产品:
	{{{select}}}
	<button class="btn_red" id="enter">确定</button>
	<button class="btn_grey" id="esc">取消</button>
</script>
<script type="text/template" id="cdn-self-config-template">
	<td class="span2">CDN设置</td>
	<td class="span6">自定义CDN配置未开启</td>
	<td class="span2"><a href="javascript:;">设置</a></td>
</script>
<script type='text/template' id="disturb-show-template">
<tr id="disturb-row">
	<td class="span2">免打扰模式</td>
	<td class="span6">免打扰模式开启之后，在22:00-8:00期间，您不会收到来自微信、短信、邮件的监控攻击信息。</td>
	<td class="span2"><a href="javascript:;">修改</a></td>
</tr>
</script>
<script type='text/template' id="disturb-refesh-template">
	<td class="span2">免打扰模式</td>
	<td class="span6">免打扰模式开启之后，在22:00-8:00期间，您不会收到来自微信、短信、邮件的监控攻击信息。</td>
	<td class="span2"><a href="#">修改</a></td>
</script>
<script type = 'text/template' id="disturb-edit-template">
<td class="span2">免打扰模式</td>
    <td class="span4 responsive-user-set" colspan=2>
		<span>
		请选择：<input name="flags" value=0 type="radio" {{#flags}}checked{{/flags}} >开启
        <input name="flags" value=1 type="radio"  {{^flags}}checked{{/flags}} >关闭
		<button class="btn_red">确定</button>&nbsp;
		<button class="btn_grey">取消</button>
		</span>
	</td>
</script>
<!-- api设置模板 -->
<script type="text/template" id="api-manager-template">
<tr id="api-manager-tr">
	<td class="span2">API设置</td>
	<td class="span6"></td>
	<td class="span2">{{#api_edit}}<a href="javascript:;" id="edit">已设置</a>{{/api_edit}}{{^api_edit}}<a href="javascript:;" id="set">未设置</a>{{/api_edit}}</td>
</tr>
</script>
<script type="text/template" id="api-edit-template">
<tr id="api-edit-tr">
	<td  colspan="3" >
        <form style="text-align:left;margin-left:30%;">
		<div><lable>UID:</lable><span id="api_uid">{{uid}}</span></div>
        <div class="blank10"></div>
		<div>
			<lable>API_KEY:&nbsp;</lable>
			<input name="key" type="text" disabled="disabled" value="{{key}}" style="width:150px;"/>&nbsp;
			<button type="button" class="btn_grey" id="generate">产生</button>&nbsp;
			<button type="button" class="btn_grey" id="empty">清空</button>
		</div>
		<div class="blank10"></div>
		<div>
			<lable>API_IP:&nbsp;
			</lable><input name="ip" type="text" placeholder="127.0.0.1|127.0.0.2" value="{{ips}}"/>
			<span>多个IP以 | 隔开</span>
		</div>
       <div class="blank10"></div>
		</form>
		<div><button type="button" class="btn_red" id="set">设置</button>&nbsp;<button type="button" class="btn_grey" id="drop">关闭</button></div>
	</td>
</tr>
</script>
