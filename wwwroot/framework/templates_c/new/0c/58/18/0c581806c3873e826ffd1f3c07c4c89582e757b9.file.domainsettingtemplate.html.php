<?php /* Smarty version Smarty-3.0.5, created on 2015-10-29 16:16:03
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/domainsettingtemplate.html" */ ?>
<?php /*%%SmartyHeaderCode:7179831865631d5c3009be3-58924867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c581806c3873e826ffd1f3c07c4c89582e757b9' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/domainsettingtemplate.html',
      1 => 1446106552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7179831865631d5c3009be3-58924867',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type='text/template' id="domainsetting-nologin-template">

<tr id="nologin-row">

	<td class="span2">错误:</td>

	<td class="span8"><a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a></td>

</tr>

</script>

<script type='text/template' id="domainkey-show-template">

<tr id="domainkey-row">

	<td class="span2" style="width:14%"><h5>API设置</h5></td>

	<td class="span6"><h5>用于API通信.{{{message}}}</h5></td>

	<td class="span2"><h5><a id="money" href="javascript:;"  title="修改">修改</a></h5></td>

</tr>

</script>

<script type='text/template' id="domainkey-refresh-template">

	<td class="span2" style="width:14%"><h5>API设置</h5></td>

	<td class="span6"><h5>用于API通信.{{{message}}}</h5></td>

	<td class="span2"><h5><a id="money" href="javascript:;" title="修改">修改</a></h5></td>

</script>

<script type='text/template' id="domainkey-edit-template">

	<td class="span2" style="width:14%"><h5>API设置</h5></td>

	<td class="span8 responsive-domainset-set" colspan=2 >

			<span>

			域名密钥:<input type='text' style="width:120px;" name="domainkey" placeholder="当前{{setmessage}}">*为空则取消API通信

			&nbsp;&nbsp;&nbsp;<button class="btn btns btn-success">确定</button>&nbsp;&nbsp;<button class="btn btns btn-success">取消</button>

			</span>

	</td>

</script>



<script type='text/template' id="passwd-show-template">

<tr id="passwd-row">

	<td class="span2"><h5>域名密码</h5></td>

	<td class="span6"><h5>用于独立登陆.{{{message}}}</h5></td>

	<td class="span2"><h5><a id="passwd" href="javascript:;" title="修改">修改</a></h5></td>

</tr>

</script>

<script type='text/template' id="passwd-edit-template">

	<td class="span2"><h5>域名密码</h5></td>

	<td class="span8 responsive-domainset-set" colspan=2>

			<span>

			输入密码:<input type='text' style="width:120px;" name="passwd" placeholder="当前{{setmessage}}">*为空则不允许登陆

			&nbsp;&nbsp;&nbsp;<button class="btn btns btn-success">确定</button>&nbsp;&nbsp;<button class="btn btns btn-success">取消</button>

			</span>

	</td>

</script>

<script type='text/template' id="passwd-refresh-template">

	<td class="span2"><h5>域名密码</h5></td>

	<td class="span6"><h5>用于独立登陆.{{{message}}}</h5></td>

	<td class="span2"><h5><a id="passwd" href="javascript:;"  title="修改">修改</a></h5></td>

</script>

<script type='text/template' id="autorenew-show-template">

<tr id="autorenew-row">

	<td class="span2"><h5>自动续费</h5></td>

	<td class="span6"><h5><span class="text-error">{{{message}}}</span></h5></td>

	<td class="span2"><h5><a id="autorenew" href="javascript:;"  title="修改">修改</a></h5></td>

</tr>

</script>

<script type='text/template' id="autorenew-refresh-template">

	<td class="span2"><h5>自动续费</h5></td>

	<td class="span6"><h5><span class="text-error">{{{message}}}</span></h5></td>

	<td class="span2"><h5><a id="autorenew" href="javascript:;"  title="修改">修改</a></h5></td>

</script>

<script type='text/template' id="autorenew-edit-template">

	<td class="span2"><h5>自动续费</h5></td>

	<td class="span8 responsive-domainset-set" colspan=2>

			<span>

			请选择:

			<input type='radio' name="autorenew" value=1 {{#autorenew}}checked{{/autorenew}}>开启

			&nbsp;&nbsp;<input type='radio' name="autorenew" value=0 {{^autorenew}}checked{{/autorenew}}>关闭

			&nbsp;&nbsp;&nbsp;<button class="btn btns btn-success">确定</button>&nbsp;&nbsp;<button class="btn btns btn-success">取消</button>

			</span>

	</td>

</script>

<script type='text/template' id="weixin-show-template">

<tr id="weixin-row">

	<td class="span2"><h5>攻击信息</h5></td>

	<td class="span6"><h5>{{{message}}}</h5></td>

	<td class="span2"><h5><a id="weixin" href="javascript:;"  title="">修改</a></h5></td>

</tr>

</script>

<script type='text/template' id="weixin-refresh-template">

	<td class="span2"><h5>攻击信息</h5></td>

	<td class="span6"><h5>{{{message}}}</h5></td>

	<td class="span2"><h5><a id="weixin" href="javascript:;" title="修改">修改</a></h5></td>

</script>

<script type='text/template' id="weixin-edit-template">

	<td class="span2"><h5>攻击信息</h5></td>

	<td class="span8 zhdc-font-size responsive-domainset-set" colspan=2>

			<span>

			请选择:

					<input type='checkbox' name="weixin" value="weixin" {{notice_weixin}}>微信

					&nbsp;&nbsp;<input type='checkbox' name="email" value="email" {{notice_email}}>邮件

                   &nbsp;&nbsp;<input type='checkbox'  name="sms" value="sms" {{notice_sms}}>短信(服务收费,需在用户设置里面开通短信通知)

			&nbsp;&nbsp;&nbsp;<button class="btn btns btn-success" id="enter">确定</button>&nbsp;&nbsp;<button class="btn btns btn-success" id="esc">取消</button>

			</span>

	</td>

</script>



<script type='text/template' id="ttl-show-template">

<tr id="ttl-row">

	<td class="span2"><h5>TTL默认值</h5></td>

	<td class="span6"><h5>{{{message}}}</h5></td>

	<td class="span2"><h5><a id="ttl" href="javascript:;"  title="修改">修改</a></h5></td>

</tr>

</script>

<script type='text/template' id="ttl-refresh-template">

	<td class="span2"><h5>TTL默认值</h5></td>

	<td class="span6"><h5>{{{message}}}</h5></td>

	<td class="span2"><h5><a id="ttl" href="javascript:;" title="修改">修改</a></h5></td>

</script>

<script type='text/template' id="ttl-edit-template">

	<td class="span2"><h5>TTL默认值</h5></td>

	<td class="span8 responsive-domainset-set " colspan=2>

			<span>

			请选择:

					<input type='radio' name="ttl" value=60 {{ttl60}}>&nbsp;1分钟

					&nbsp;&nbsp;<input type='radio' name="ttl" value=300 {{ttl300}}>&nbsp;5分钟

					&nbsp;&nbsp;<input type='radio' name="ttl" value=600 {{ttl600}}>&nbsp;10分钟

					&nbsp;&nbsp;<input type='radio' name="ttl" value=1800 {{ttl1800}}>&nbsp;30分钟

					&nbsp;&nbsp;<input type='radio' name="ttl" value=3600 {{ttl3600}}>&nbsp;1小时

			&nbsp;&nbsp;&nbsp;<button class="btn btns btn-success">确定</button>&nbsp;&nbsp;<button class="btn btns btn-success">取消</button>

			</span>

	</td>

</script>

<script type='text/template' id="linegroup-show-template">

<tr id="linegroup-row">

	<td class="span2"><h5>线路组</h5></td>

	<td class="span6"><h5>{{{message}}}</h5></td>

	<td class="span2"><h5><a id="ttl" href="javascript:;" title="修改">修改</a></h5></td>

</tr>

</script>

<script type='text/template' id="linegroup-refresh-template">

	<td class="span2"><h5>线路组</h5></td>

	<td class="span6"><h5>{{{message}}}</h5></td>

	<td class="span2"><h5><a id="ttl" href="javascript:;"  title="修改">修改</a></h5></td>

</script>

<script type='text/template' id="linegroup-edit-template">

	<td class="span2"><h5>线路组</h5></td>

	<td class="span8" colspan=2>

			<span class="responsive-domainset-set1">

			请选择:<span id="linegroup">{{{linegrouphtml}}}

					</span>

			&nbsp;&nbsp;&nbsp;<button class="btn btns btn-success">确定</button>&nbsp;&nbsp;<button class="btn btns btn-success">取消</button>

			</span>

	</td>

</script>

