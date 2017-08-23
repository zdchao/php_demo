<?php /* Smarty version Smarty-3.0.5, created on 2016-01-24 18:00:52
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/noticetemplate.html" */ ?>
<?php /*%%SmartyHeaderCode:42132218056a4a0d4d10020-76495141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf805b7652298ec031fcb91417a898e80ee52741' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/user/view/new/user/noticetemplate.html',
      1 => 1438838778,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42132218056a4a0d4d10020-76495141',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type='text/template' id="user-nologin-template">
<div id="nologin-row">
	<span class="span2">错误:</span>
	<span class="span8"><a href="?c=session&a=loginForm" class="font-red">没有登陆,点击登陆</a></span>
</div>
</script>
<script type='text/template' id="notice-row-template">
<div id="{{rowid}}" class="clearfix record {{rowclass}}" style="margin-top:8px;">
	<span class="record-time">{{createtime}}</span>
	<span class="record-title dnsdun-cursor ">{{body}}</span>
</div>
</script>
<script type='text/template' id="notice-row-refresh-template">
	<span class="record-time">{{createtime}}</span>
	<span class="record-title dnsdun-cursor ">{{body}}</span>
</script>

<script type='text/template' id="notice-row-header-template">
<div id="notice-list-header" class="clearfix record" style="margin-top:8px;">
	<span class="record-time dnsdun-cursor" id="name-sort" >日期</span>
	<span class="record-title dnsdun-cursor" id="ttl-sort" >标题</span>
</div>
</script>
<script type='text/template' id="notice-show-mutli-template">
<div id="show-multi-operat" class="clearfix record" style="margin-top:8px;">
	<span class="record-time"><h5>&nbsp;</h5></span>
	<span><h5><a href="javascript:;" id="packup">收起</a></h5></span>
	<span class="record-title">
		<h5><a href="javascript:;" id="show-multi">查看更多>></a></h5>
	</span>
</div>
</script>
<script type="text/template" id="operat-launch-template">
<div id="show-launch" class="clearfix record" style="margin-top:8px;">
	<span class="record-time"><h5>&nbsp;</h5></span>
	<span><h5><a id="launch" href="javascript:;">展开</a></h5></span>
</div>
</script>
<script type='text/template' id="notice-show-body-template">
	<span class="record-time">{{createtime}}</span>
	<span class="record-body dnsdun-cursor ">{{body}}</span>
</script>
