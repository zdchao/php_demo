<?php /* Smarty version Smarty-3.0.5, created on 2015-10-29 11:45:43
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/indextemplete.html" */ ?>
<?php /*%%SmartyHeaderCode:786979098563196678b4af3-25776509%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac0795a6fccb2d29b206d7239348673c50734898' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/record/indextemplete.html',
      1 => 1446090324,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '786979098563196678b4af3-25776509',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type='text/template' id="record-nologin-template">
	<div><a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a></div>
</script>
<script type='text/template' id="record-loading-template">
    <div class="progress progress-striped" id="record-loading">
    	<div class="bar" style="width: {{width}}%;">正在载入数据...</div>
    </div>
</script>
<script type='text/template' id="record-list-header-template">
<thead>
<tr id="record-list-header">
	<td  width="5%"><input type='checkbox' id="record-select-all"></td>
	<td   width="15%"><span id="name-sort" data-original-title="点击按主机名排序" data-toggle="name-sort" data-placement="top">主机名称</span></td>
	<td   width="10%"><span id="type-sort" data-original-title="点击按类型排序" data-toggle="type-sort" data-placement="top">类型</span></td>
	<td  width="10%"><span id="line-sort" data-original-title="点击按线路排序" data-toggle="line-sort" data-placement="top">线路</span></td>
	<td   width="20%"><spanid="value-sort" data-original-title="点击按解析值排序" data-toggle="value-sort" data-placement="top">解析值</span></td>
	<td   width="8%"><span id="ttl-sort" data-original-title="点击按TTL排序" data-toggle="ttl-sort" data-placement="top">TTL</span></td>
	<td  width="22%" >操作</td>
	<td  width="10%" >监控</td>
</tr>
</thead>
</script>
<script type='text/template' id="record-row-template">
	<tr id="{{divid}}">
		<td id="record-checkbox"><input type="checkbox" {{disabled}} {{checked}}></td>
		<td  id="record-name">{{name}}</td>
		<td  id="record-type">{{type}}</td>
		<td id="record-line">{{line}}</td> 
		<td id="record-value">{{value}}</td>
		<td  id="record-ttl">{{ttl}}</td>
		<td id="record-operat">{{{operat}}}</td>
		<td id="record-monitor">{{{monitor_operat}}}</td>
	</tr>
</script>
<script type='text/template' id="record-row-refresh-template">
	<td  id="record-checkbox"><input type="checkbox" {{disabled}} {{checked}}></td>
	<td  id="record-name">{{name}}</td>
	<td  id="record-type">{{type}}</td>
	<td id="record-line">{{line}}</td>
	<td  id="record-value">{{value}}</td>
	<td id="record-ttl">{{ttl}}</td>
	<td  id="record-operat">{{{operat}}}</td>
	<td id="record-monitor">{{{monitor_operat}}}</td>
</script>
<script type="text/template" id="del-monitor-confirm-template">
	<td style="width:21%;color:red;" id="record-value" colspan="6">你确定要删除这个监控吗？</td>
	<td colspan="2"><a href="javascript:;" id="enter"><span  class="btn_red">确定</span></a><a href="javascript:;" id="esc"><span class="btn_grey">取消</span></a></td>
</script>
<script type='text/template' id="row-del-confirm-template">
	<td id="record-checkbox"><input type="checkbox" {{disabled}} {{checked}}></td>
	<td  id="record-name">{{name}}</td>
	<td  id="record-type">{{type}}</td>
	<td id="record-line">{{line}}</td>
	<td id="record-value" colspan="2">{{content}}</td>
	<td  id="record-operat" ><a href="javascript:;"  id="enter"><span  class="btn_red" style="margin-right:10px;">确定</span></a><a href="javascript:;"  id="esc"><span class="btn_grey">取消</span></a></td>
	<td  id="record-monitor"></td>
</script>
<script type="text/template" id="row-del-site-domian-template">
	<td class="record-checkbox" id="record-checkbox"><input type="checkbox" {{disabled}}{{checked}}/></td>
	<td class="record-name" id="record-name">{{name}}</td>
	<td class="record-type" id="record-type">{{type}}</td>
	<td class="record-line" id="record-line">{{line}}</td>
	<td class="record-value" id="record-value">{{content}}</td>
	<td class="record-ttl" id="record-ttl">&nbsp;</td>
	<td class="record-operat" id="record-operat"><a href="javascript:;" class="btn" id="enter">确定</a><a href="javascript:;" class="btn" id="esc">取消</a></td>
	<td class="record-monitor" id="record-monitor"></td>
</script>
<script type='text/template' id="multi-del-confirm-template">
<div class="modal hide fade" id="confirm-modal">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>{{{title}}}</h3>
    </div>
    <div class="modal-body">
    <p>{{{content}}}</p>
    </div>
    <div class="modal-footer"><a href="#" class="btn" id="esc">取消</a><a href="#" class="btn btn-primary" id="enter">确定</a>
    </div>
</div>
</script>
<script type='text/template' id="record-eidt-template">
	<td class="record-checkbox" id="record-checkbox"><input type="checkbox" {{disabled}} {{checked}}></td>
	<td class="record-name" id="record-name"><input type="text" name="name" value='{{name}}'></td>
	<td class="record-type" id="record-type"><select name="type" ></select></td>
	<td class="record-line" id="record-line"><select name="line"></select></td>
	<td class="record-value" id="record-value"><input type='text' value='{{value}}' name="value" ></td>
	<td class="record-ttl" id="record-ttl"><input type='text' value='{{ttl}}' name="ttl" value="{{ttl}}"></td>
	<td class="record-operat" id="record-operat"><button class="btn btns btn-success">确定</button>&nbsp;<button class="btn btns btn-success">取消</button></td>
	<td class="record-monitor" id="record-monitor">&nbsp;</td>
</script>
<script type="text/template" id="edit-cdn-domain-template">
	<td style="width:20%;">&nbsp;</td>
	<td id="edit_cdn_domain">域名:<input type="text" name="domain"/></td>
	<td id="edit_cdn_ip">IP:<input type="text" name="ip"/></td>
	<td id="edit_cdn_onoff"><button id="enter" class="btn btn-primary">确定</button>&nbsp;&nbsp;<button id="esc" class="btn btn-primary">取消</button></td>
</script>

<script type='text/template' id="record-remark-template">
	<td  id="record-checkbox"><input type="checkbox"></td>
	<td id="record-name">{{name}}</td>
	<td  id="record-type">{{type}}</td>
	<td id="record-line">{{line}}</td>
	<td id="record-remark" colspan="2">
		<input type='text' name="remark" value="{{#remark}}{{remark}}{{/remark}}" placeholder="例:这个域名是在Aegins托管解析的">
	</td>
	<td  id="record-addoperat" colspan="2">
		<span class="btn_red" id="enter">备注</span>
		<span class="btn_grey" id="esc">取消</span>
	</td>
</script>
<script type='text/template' id="record-operat-template">
     <span id="del" data-original-title="点击删除" data-toggle="del" data-placement="top"><a style="color:#4fc0e8;" title="删除" href="#del">删除</a><span style="padding:0px 5px; color:#4fc0e8;">|</span></span>
	<span id="backup" data-original-title="当前为备用,点击启用" data-toggle="backup" data-placement="top"><a style="color:#DE3163;" title="备用" href="#">备用</a><span style="padding:0px 5px; color:#4fc0e8;">|</span></span>
	<span id="nobackup" data-original-title="已启用,点击设为备用" data-toggle="nobackup" data-placement="top"><a style="color:#4fc0e8;" title="启用" href="#">启用</a><span style="padding:0px 5px; color:#4fc0e8;">|</span></span>
	<!--
	<span id="hijack" data-original-title="没有开启防劫持,点击开启" data-toggle="hijack" data-placement="top"><a href="javascript:;"><i class="icon-nojiechi"></i></a></span>
	<span id="nohijack" data-original-title="已开启防劫持,点开关闭" data-toggle="nohijack" data-placement="top"><a href="javascript:;"><i class="icon-jiechi"></i></a></span>
	-->
	<span id="remark" data-original-title="{{#remark}}{{remark}}{{/remark}}{{^remark}}点击添加备注{{/remark}}" data-toggle="remark" data-placement="top"><a href="javascript:;" style="color:#4fc0e8;" title="备注">备注</a><span style="padding:0px 5px; color:#4fc0e8;">|</span></span>
	<span id="stop" data-original-title="已暂停,点击恢复解析" data-toggle="stop" data-placement="top"><a style="color:#DE3163;" title="暂停" href="#" >暂停</a><span style="padding:0px 5px; color:#4fc0e8;"></span></span>
	<span id="restor" data-original-title="解析中,点击暂停解析" data-toggle="restor" data-placement="top"><a style="color:#4fc0e8;" title="解析" href="#">解析</a><span style="padding:0px 5px; color:#4fc0e8;"></span></span>
</script>
<script type="text/template" id="record-cdn-template">
	<span id="domain_status1" data-original-title="点击可删除cdn站点" data-toggle="domain_status1" data-placement="top"><a href="javascript:;"><i class="icon-cdndomain1"></i></a></span>
	<span id="domain_status0" data-original-title="点击添加cdn站点域名" data-toggle="domain_status0" data-placement="top"><a href="javascript:;"><i class="icon-cdndomain0"></i></a></span>
	<span id="edit_cdn" data-original-title="修改cdn站点域名" data-toggle="edit_cdn" data-placement="top"><a href="javascript:;"><i class="icon-cdn-edit"></i></a></span>
</script>
<script type='text/template' id="record-monitor-template">
	<span id="add" data-original-title="点击添加监控" data-toggle="add" data-placement="top"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/jk_tianjia.png"></a></span>
	<span id="del" data-original-title="点击删除监控" data-toggle="del" data-placement="top"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/shanchu.png"></a></span>
	<span id="edit" data-original-title="点击修改监控" data-toggle="edit" data-placement="top"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/bianji.png"></a></span>
	<span id="error" data-original-title="监控有错误" data-toggle="error" data-placement="top"><a href="javascript:;"><em class="icon-errorer"></em></a></span>
	<span id="switch" data-original-title="监控有异常" data-toggle="switch" data-placement="top"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/agies/img/jiankong.png"></a></span>
	<span id="normal" data-original-title="监控正常" data-toggle="normal" data-placement="top"><a href="javascript:;"><em class="icon_13"></em></a></span>
</script>
<script type='text/template' id="record-add-template">
<tr id="record-add-row_{{key}}" data-type="add" >
	<td class="record-checkbox" id="record-checkbox"><input type="checkbox" {{disabled}} {{checked}}  class="input-small"></td>
	<td class="record-name" id="record-name"><input type="text" name="name" value='{{name}}'  class="input-small"></td>
	<td class="record-type" id="record-type"><select name="type"  class="input-small"></select></td>
	<td class="record-line" id="record-line"><select name="line"  class="input-small" ></select></td>
	<td class="record-value" id="record-value"><input type='text' value='{{value}}' name="value"  input-medium=""></td>
	<td class="record-ttl" id="record-ttl"><input type='text' value='{{ttl}}' name="ttl" value="{{ttl}}"  class="input-mini" required></td>
	<td class="record-operat" id="record-operat">
		<button href="javascript:;" class="btn_red" id="enter">确定</button>
		<button href="javascript:;" class="btn_grey" id="esc">取消</button>
	</td>
	<td class="record-monitor" id="record-monitor">&nbsp;</td>
</tr>
</script>
<script type='text/template' id="prompt-record-name-template">
<td colspan="8"  class="offset1">
	<h4 class="offset1" style="padding-top:3px">主机记录就是域名前缀，常见用法有:</h4>
	<dl class="offset1" style="padding-top:10px">
		<dt class="span1 btn-link text-right">www</dt><dd>：解析后的域名为<code>www.{{name}}</code></dd>
		<dt class="span1 btn-link text-right">@</dt><dd>：直接解析主域名<code>{{name}}</code></dd>
		<dt class="span1 btn-link text-right">*</dt><dd>：泛解析，匹配其他所有域名 <code>*.{{name}}</code></dd>
	</dl>	
</td>
</script>
<script type='text/template' id="prompt-record-value-template">
 <td colspan="8"  class="offset1">
	<h4>各类型的记录值输入格式:</h4>
	<dl>
		<dt class="btn-link span1 text-right">A</dt>
			<dd>&nbsp:&nbsp填写您服务器 IP，如果您不知道，请咨询您的空间商</dd>
		<dt class="btn-link span1 text-right">AAAA</dt>
			<dd>&nbsp:&nbsp解析到 IPv6 的地址</dd>
		<dt class="btn-link span1 text-right">CNAME</dt>
			<dd>&nbsp:&nbsp主机名(如果主机名是域名，请以<code>.</code>结尾)，例如：<code>www.{{name}}.</code> 或 <code>www</code></dd>
		<dt class="btn-link span1 text-right">DNAME</dt>
			<dd>&nbsp;:&nbsp;和CNAME相同,不可泛解析,不可与CNAME同时解析</dd>
		<dt class="btn-link span1 text-right">TXT</dt>
			<dd>&nbsp:&nbsp一般用于 Google、QQ等企业邮箱的反垃圾邮件设置</dd>
		<dt class="btn-link span1 text-right">NS</dt>
			<dd>&nbsp:&nbsp不常用。NS向下授权，填写dns域名，例如：<code>{{nsname}}</code></dd>
		<dt class="btn-link span1 text-right">MX</dt>
			<dd>&nbsp:&nbsp填写您邮件服务器的IP地址或企业邮局给您提供的域名，格式为:优先级 空格 主机名,例:<code>10 mail.{{name}}.</code>,请咨询您的邮件服务提供商</dd>
		<dt class="btn-link span1 text-right">URL</dt>
			<dd>&nbsp:&nbsp填写要跳转到的网址,例<code>301 www.{{name}}</code>,<code>302 bbs.{{name}}</code>,<code>200 www.{{name}} 标题</code></dd>
		<dt class="btn-link span1 text-right">SRV</dt>
			<dd>&nbsp:&nbsp不常用。格式为：优先级 空格 权重 空格 端口 空格 主机名，例：<code>5 0 5269 xmpp-server.l.{{name}}.</code></dd>
	</dl>
 </td>
</script>
<script type='text/template' id="prompt-template">
<tr id="add-prompt">

</tr>
</script>
<script type='text/template' id="prompt-record-type-template">
 <td colspan="8" class="offset1">
	<h4>各记录类型说明:</h4>
	<dl>
		<dt class="btn-link span1 text-right">A</dt>
			<dd>&nbsp;:&nbsp;地址记录，用来指定域名的IPv4地址（如：<code>8.8.8.8</code>），如果需要将域名指向一个IP地址，就需要添加A记录</dd>
		<dt class="btn-link span1 text-right">AAAA</dt>
			<dd>&nbsp;:&nbsp;用来指定主机名（或域名）对应的IPv6地址（例如：<code>ff06:0:0:0:0:0:0:c3</code>）记录</dd>
		<dt class="btn-link span1 text-right">CNAME</dt>
			<dd>&nbsp;:&nbsp;主机别名,如果需要将域名指向另一个域名，再由另一个域名提供ip地址，就需要添加CNAME记录</dd>
		<dt class="btn-link span1 text-right">DNAME</dt>
			<dd>&nbsp;:&nbsp;域名别名,不可泛解析,相同记录不可与CNAME同时解析.例:www.{{name}}解析了CNAME记录，则不可再解析DNAME记录</dd>
		<dt class="btn-link span1 text-right">TXT</dt>
			<dd>&nbsp;:&nbsp;在这里可以填写任何东西，长度限制255。绝大多数的TXT记录是用来做SPF记录（反垃圾邮件</dd>
		<dt class="btn-link span1 text-right">NS</dt>
			<dd>&nbsp;:&nbsp;域名服务器记录，如果需要把子域名交给其他DNS服务商解析，就需要添加NS记录</dd>
		<dt class="btn-link span1 text-right">MX</dt>
			<dd>&nbsp;:&nbsp;如果需要设置邮箱，让邮箱能收到邮件，就需要添加MX记录。</dd>
		<dt class="btn-link span1 text-right">URL</dt>
			<dd>&nbsp;:&nbsp;从一个地址301重定向到另一个地址的时候，就需要添加显性URL记录</dd>
		<dt class="btn-link span1 text-right">SRV</dt>
			<dd>&nbsp;:&nbsp;记录了哪台计算机提供了哪个服务。格式为：服务的名字、点、协议的类型，例如：_xmpp-server._tcp</dd>
	</dl>
</td>
</script>
<script type='text/template' id="prompt-record-line-template">
<td colspan="8" class="offset1">
	<h4>各线路说明:</h4>
	<dl>
		<dt class="btn-link span1 text-right">默认</dt>
			<dd>&nbsp;:&nbsp;必需添加,智能线路，自动给用户分配IP访问.</dd>
		<dt class="btn-link span1 text-right">电信</dt>
			<dd>&nbsp;:&nbsp;单独为【电信用户】指定服务器访问IP,其他用户使用默认线路访问</dd>
		<dt class="btn-link span1 text-right">搜索引擎</dt>
			<dd>&nbsp;:&nbsp;指定服务器上某个IP让蜘蛛抓取</dd>
	</dl>
</td>
</script>
<script type='text/template' id="prompt-record-ttl-template">
<td colspan="8" class="offset1">
	<h4>TTL:即 Time To Live，缓存的生存时间。指地方dns缓存您域名记录信息的时间，缓存失效后会再次到<code>{{panelname}}</code>获取记录值</h4>
	<dl>
		<dt class="btn-link span1 text-right">3600</dt>
			<dd>&nbsp;:&nbsp;比较常用的,如果您不经常修改记录,推荐使用</dd>
		<dt class="btn-link span1 text-right">600</dt>
			<dd>&nbsp;:&nbsp;如果您偶尔会修改记录的情况下使用</dd>
		<dt class="btn-link span1 text-right">60</dt>
			<dd>&nbsp;:&nbsp;如果您经常修改记录的情况下使用</dd>
	</dl>
</td>
</script>

<script type='text/template' id="record-add-multi-template">
<div id="record-add-multi" class="piliangtianjia">
	<h3><span>*</span>批量添加记录</h3>
	<!--<div>覆&nbsp;盖:<input type='checkbox' name="replace" value=1></div>
	<div>类&nbsp;型:</div>
	<div>线&nbsp;路:</div>
	<div>T&nbsp;TL:<input type="text" ></div>
	<div>解析名字和值,一行一个,主机和解析值用空格分割</div>
	<div><textarea name="values" placeholder="www 192.168.1.1" required></textarea></div>
	<div>
		<span class="btn_grey" id="esc">取消</span>&nbsp;
		<span class="btn_red" id="enter" data-loading-text="正在执行..">确定</span>
	</div>-->
	 <div class="pltj_nr">
        	<ul>
                <li><p>覆盖 : </p><input type='checkbox' name="replace" value=1></li>
                <li><p>类型：</p><select name="record_type"></select></li>
 				<li><p>线路：</p><select name="record_line"></select></li>
  				<li><p>TTL：</p><input type="text" class="paynum" name="ttl" value="{{ttl}}" style="width:400px; height:33px; border:1px solid #e6e6e6; padding-left:10px;"></li>
                <li><h4>主机  解析值(一行一条记录,主机和解析值用空格分割) </h4></li>
                <li><p></p><textarea  placeholder="www 192.168.1.11" class="paynum" name="values" style="width:400px; height:100px; border:1px solid #e6e6e6; padding-left:10px;"></textarea></li>
                <div class="blank10"></div>
  <div class="blank10"></div>
  <div class="blank10"></div>
  <div class="blank10"></div>
 <div class="blank10"></div>
                <div class="blank10"></div>
                
            </ul> 
        </div>
        <div class="blank10"></div>
		 <div class="pltj_an">
		<p><a href="#"><button  id="enter" data-loading-text="正在执行.." style="width:100px; height:35px; display:block;  background:#FF6760; color:#fff; text-align:center; line-height:35px; border:none; border-radius:10px; ">保存</button></a></p>
         <p><a href="#"><button  id="esc" style="width:100px; height:35px; display:block;  background:#eeeeee; border:1px solid #e6e6e6; color:#696969; text-align:center; line-height:35px;  border-radius:10px; ">取消</button></a></p>        
        </div>
        <div class="blank10"></div>
</div>	
</script>
<script type='text/template' id="monitor-add-template">
<tr id="monitor-add-row">
	<td colspan="8">
			<form style="text-align:left;margin-left:30%;line-height:30px;">
				<div>监控网址:<input type="text" name="url" value='{{url}}' title="可监控服务器上某个文件">*必填</div>
				<div class="blank10"></div>
				<div>包含内容:<input type="text" name="content" placeholder='监控url文件中的内容' >如没有可不填</div>
<div class="blank10"></div>
				<div>间隔时间:<input type="text" name="interval_time" value='300' >秒</div>
<div class="blank10"></div>
				<div>故障动作:	
					<input type='radio' name='action'  value=0 checked >不处理
					<input type='radio' name='action'  value=1 >暂停
					<input type='radio' name='action'  value=2 >自动切换
				</div>
				<div id="switch_type">切换类型:
					<input type='radio' name='monitor_t' value='A' checked>A
					<input type='radio' name='monitor_t' value='AAAA'>AAAA
					<input type='radio' name='monitor_t' value='CNAME'>CNAME
				</div>
<div class="blank10"></div>
				<div  id="switch_host">切换主机:<input type="text" name="value"></div>
<div class="blank10"></div>
            	<div>是否启用:
					<input type='radio' name='active'  value=1 checked>启用
					<input type='radio' name='active'  value=0>暂停
				</div>
				<div>监控名称:<input type="text" name='name'>(相同名称的监控故障动作会联动)</div>
<div class="blank10"></div>
				<div>监控通知:
					<input type="checkbox" name="weixin" value="weixin"/>微信
					<input type="checkbox" name="sms" value="sms"/>短信
					<input type="checkbox" name="email" value="email"/>邮件
				</div>
<div class="blank10"></div>
			</form>
		<div class="record-btn">
        	<button class="btn btns btn-success">取消</button>
        	<button class="btn btns btn-success">确认</button>
		</div>
	</td>
</tr>
</script>
<script type='text/template' id="monitor-edit-template">
<tr id="monitor-edit-row">
	<td colspan=8>
			<form  style="text-align:left;margin-left:30%">
				<div>监控网址:<input type="text" name="url" value='{{url}}' title="可监控服务器上某个文件">*必填</div>
<!--<div class="blank10"></div>-->
				<div>包含内容:<input type="text" name="content" value="{{content}}">如没有可不填</div>
<!--<div class="blank10"></div>-->
				<div>间隔时间:<input type="text" name="interval_time" value='{{interval_time}}'>秒</div>
				<div>故障动作:	
					<input type='radio' name='action'  value=0 {{action0}} >不处理
					<input type='radio' name='action'  value=1 {{action1}}>暂停
					<input type='radio' name='action'  value=2 {{action2}}>自动切换
				</div>
<!--<div class="blank10"></div>-->
				<div id="switch_type">切换类型:
					<input type='radio' name='monitor_t' value='A' {{typeA}}>A
					<input type='radio' name='monitor_t' value='AAAA' {{typeAAAA}}>AAAA
					<input type='radio' name='monitor_t' value='CNAME' {{typeCNAME}}>CNAME
				</div>
<!--<div class="blank10"></div>-->
				<div  id="switch_host">切换主机:<input name="value" value='{{monitor_value}}'></div>
<!--<div class="blank10"></div>-->
            	<div>是否启用:
					<input type='radio' name='active'  value=1 {{active1}}>启用
					<input type='radio' name='active'  value=0 {{active0}}>暂停
				</div>
<!--<div class="blank10"></div>-->
				<div>监控名称:<input type="text" name='name' value="{{name}}">(相同名称的监控故障动作会联动)</div>
<!--<div class="blank10"></div>-->
				<div>监控通知:
					<input type="checkbox" name="weixin" {{notice_weixin}} value="weixin"/>微信
					<input type="checkbox" name="sms" {{notice_sms}} value="sms"/>短信
					<input type="checkbox" name="email" {{notice_email}} value="email"/>邮件
				</div>
<!--<div class="blank10"></div>-->
			</form>
		<div class="record-btn">
        	<button class="btn btns btn-success" id="esc">取消</button>
           	<button class="btn btns btn-success" id="enter">确认</button>
		</div>
		<div class="blank10"></div>
	</td>
</tr>
</script>
<script type='text/template' id="record-page-li-template">
	<li class="{{liclass}}"><a href="#{{page}}" data-page='{{page}}'>{{pagename}}</a></li>
</script>
<script type="text/template" id="record-page-count-template">
    <span class="btn-group" style="padding-top:10px;margin-left:40px" >
    	<button class="btn-grey dropdown-toggle" data-toggle="dropdown" >{{countstart}}&nbsp;-&nbsp;{{countend}}&nbsp;/&nbsp;{{total}}
    	<span class="caret"></span>
    	</button>
    	<ul class="dropdown-menu" id="record-pagecount-ul" >
    	</ul>
    </span>
</script>
<script type='text/template' id="record-page-count-li-template">
	<li><a href="javascript:;" data-pagecount='{{pagecount}}'>{{pagecount}}/页</a></li>
</script>
<script type='text/template' id="import-list-li-template">
	<tr class="record clearfix text-success" id="import-record-{{key}}" style="margin:0 0 0 -1px">
		<td class="record-checkbox"><input type='checkbox' value=1 name="check" checked></td>
		<td class="record-name">{{name}}</td>
		<td class="record-type">{{type}}</td>
		<td class="record-line">默认</td>
		<td class="record-value">{{value}}</td>
		<td class="record-ttl">{{ttl}}</td>
		<td class="record-operat">&nbsp;</td>
		<td class="record-monitor">&nbsp;</td>
	</tr>
</script>
<script type='text/template' id="add-subdomain-template">
<div id="add-subdomain" class="alert-success">
		<div class="offset2 alert-warning" style="padding-top:8px">子域名前缀,一行一个</div>
		<div class="offset2" style="padding-top:8px"><textarea name="values" placeholder="例:www" rows=4 cols="80" style='width:300px' required></textarea></div>
		<div class="offset3"><button class="btn btn-primary" id="esc">取消</button>&nbsp;<button class="btn btn-primary" id="enter" data-loading-text="正在执行..">确定</button></div>
	</div>	
</script>
<script type="text/template" id="recover-data-template">
<div id="recover-data-div" class="alert-success">
		<div class="offset2 alert-warning" style="padding-top:8px">请将数据记录文件中的数据复制到对话框内</div>
		<div class="offset2" style="padding-top:8px"><textarea name="values" placeholder="" rows=25 cols="150" style='width:800px' required></textarea></div>
		<div class="offset3"><button class="btn btn-primary" id="esc">取消</button>&nbsp;<button class="btn btn-primary" id="enter" data-loading-text="正在执行..">确定</button></div>
	</div>	
</script>
<script type="text/template" id="file-upload-template">
<div id="file-upload-div" style="margin-top:8px;">
	<div class="offset2" >
		<form name="form" method="POST" action="" enctype="multipart/form-data">
			<input type="file" name="fileToUpload" id="fileToUpload"/>
              <button id="submit" style="width:100px; height:35px; background:#FF6760; border:1px solid #e6e6e6; color:#fff; text-align:center; line-height:35px; border-radius:10px; ">导入数据</button>
		</form>
	</div>
</div>
</script>
<script type="text/template" id="file-prompt-template">
<div id="file-prompt-div" class="alert-success">
	<div class="offset2 alert-warning" style="padding-top:8px;height:50px;line-height:50px;">{{{content}}<img id="imggif" src="/style/busy.gif"/></div>
</div>
</script>
<script type="text/template" id="file-recover-success-template">
<div id="file-recover-success-div" class="alert-success">
	<div class="offset2 alert-warning" style="padding-top:8px;height:50px;line-height:50px;">文件导入成功</div>
</div>
</script>
<script type='text/template' id="piao-modal-template">
    <div class="modal hide fade" id="piao-modal">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3>{{title}}</h3>
    	</div>
    	<div class="modal-body">
    		<p>{{{content}}}</p>
    	</div>
    	<div class="modal-footer">
    		<a href="#" class="btn" id="closea">关闭</a>
    	</div>
    </div>
</script>
<script type="text/template" id="height-set-template">
<span id="height-set-span">
		<a href="javascript:;" id="zhdc">高级</a>
		<div class="test_triangle" id="a">
			<div class="popup"><span></span>
				<div>
					<div class="nsheightset"><a href="javascript:;" id="cf" data-original-title="点击开启" data-toggle="cf" data-placement="top">CF</a></div>
					<div class="nsheightset"><a href="javascript:;" id="ho" data-original-title="点击开启" data-toggle="ho" data-placement="top">HO</a></div>
					<div class="nsheightset"><a href="javascript:;" id="cb" data-original-title="点击开启" data-toggle="cb" data-placement="top">CB</a></div>
					<div class="nsheightset"><a href="javascript:;" id="th" data-original-title="点击开启" data-toggle="th" data-placement="top">TH</a></div>
					<div class="nsheightset"><a href="javascript:;" id="tc" data-original-title="点击开启" data-toggle="tc" data-placement="top">TC</a></div>
					<div class="nsheightset"><a href="javascript:;" id="sh" data-original-title="点击开启" data-toggle="sh" data-placement="top">SH</a></div>
					<div style="width:30px;float:left;font-size:12px;"><a href="javascript:;" style="color:red" id="down">关闭</a></div>
				</div>
			</div>
		</div>
</span>
</script>
<script type="text/template" id="height-set-ref-template">
<a href="javascript:;" id="zhdc">高级</a>
		<div class="test_triangle" id="a">
			<div class="popup"><span></span>
				<div>
					<div class="nsheightset"><a href="javascript:;" id="cf" data-original-title="点击开启" data-toggle="cf" data-placement="top">CF</a></div>
					<div class="nsheightset"><a href="javascript:;" id="ho" data-original-title="点击开启" data-toggle="ho" data-placement="top">HO</a></div>
					<div class="nsheightset"><a href="javascript:;" id="cb" data-original-title="点击开启" data-toggle="cb" data-placement="top">CB</a></div>
					<div class="nsheightset"><a href="javascript:;" id="th" data-original-title="点击开启" data-toggle="th" data-placement="top">TH</a></div>
					<div class="nsheightset"><a href="javascript:;" id="tc" data-original-title="点击开启" data-toggle="tc" data-placement="top">TC</a></div>
					<div class="nsheightset"><a href="javascript:;" id="sh" data-original-title="点击开启" data-toggle="sh" data-placement="top">SH</a></div>
					<div style="width:30px;float:left;font-size:12px;"><a href="javascript:;" style="color:red" id="down">关闭</a></div>
				</div>
			</div>
		</div>
</script>