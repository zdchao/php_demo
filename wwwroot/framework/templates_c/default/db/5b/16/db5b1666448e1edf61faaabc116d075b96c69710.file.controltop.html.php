<?php /* Smarty version Smarty-3.0.5, created on 2015-09-09 17:37:31
         compiled from "/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/controltop.html" */ ?>
<?php /*%%SmartyHeaderCode:54014415555effddbbd0976-63195284%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db5b1666448e1edf61faaabc116d075b96c69710' => 
    array (
      0 => '/home/ftp/d/dnsdun/wwwroot/wwwroot/super/view/default/controltop.html',
      1 => 1440490184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54014415555effddbbd0976-63195284',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<HTML>
<HEAD>
<style type="text/css">.cacher {behavior:url(#default#userdata);}</style>
<script language="javascript">
var COOKIE_NAME = "x";

function setCookie(name, value, expiry, path, domain, secure){
	var nameString = name + "=" + value;
	var expiryString = (expiry == null) ? "" : " ;expires = "+ expiry.toGMTString();
	var pathString = (path == null) ? "" : " ;path = "+ path;
	var domainString = (path == null) ? "" : " ;domain = "+ domain;
	var secureString = (secure) ?";secure" :"";
	document.cookie = nameString + expiryString + pathString + domainString + secureString;
}

function getCookie(sName) {
	var aCookie = document.cookie.split("; ");
	for (var i=0; i < aCookie.length; i++) {
		var aCrumb = aCookie[i].split("=");
		if (sName == aCrumb[0]) 
		return unescape(aCrumb[1]);
	}
	return "";
}

function remainLocale() {
	var layoutObj = new Array();
	var i = 0;
	while (i < top.frames.length) {
		var frame_obj = eval("top.frames[" + i + "]");
		layoutObj[i] = frame_obj.name + "^" +  frame_obj.location;
		i++;
	}
	saveDataToCache(layoutObj.valueOf());
	setCookie(COOKIE_NAME, 'y');
}

var CACHE_DATA_KEY = "cData";
var CACHE_DATA_NAME = "cDataName";

function setExpire(obj) {	
	var oTimeNow = new Date();
	oTimeNow.setMinutes(oTimeNow.getMinutes() + 5);
	var sExpirationDate = oTimeNow.toUTCString();
	obj.expires = sExpirationDate;
}

function saveDataToCache(v) {
	var cacheData = document.getElementById("cacheData");
	//setExpire(cacheData);
	cacheData.setAttribute(CACHE_DATA_NAME, v);
	cacheData.save(CACHE_DATA_KEY);	
}

function loadDataFromCache() {	
	var cacheData = document.getElementById("cacheData");
//	cacheData.load(CACHE_DATA_KEY);
	return cacheData.getAttribute(CACHE_DATA_NAME);
}

function removeDataFromCache() {
	try {
		var cacheData = document.getElementById("cacheData");
		cacheData.removeAttribute(CACHE_DATA_NAME);		
		cacheData.save(CACHE_DATA_KEY);
	} catch(e) {};
}

function restoreLocale() {
	var cv = getCookie(COOKIE_NAME);
	var str = loadDataFromCache();
	if (cv && str && str.length>0) {
		var frame_obj = str.split(",");

		var layoutObj = new Array();
		for (i=0; i<frame_obj.length; i++) {
			var piece = frame_obj[i].split("^");
			if (piece[0]==window.name) continue;
			eval("top." + piece[0] + ".location = '" + piece[1] + "'");
		}
	}
	removeDataFromCache();
}

var flag = false;
function shift_status()
{
	var rightFrame = top.document.getElementsByName("right")[0];
	if(flag)
	{
		if(screen.height>768)
			rightFrame.rows = "64,9,*";
		else if(screen.height>600)	
			rightFrame.rows = "64,9,*";
		else
			rightFrame.rows = "64,9,*";
		document.getElementById('menuSwitch1').src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/ej1_31.png';
		document.getElementById('menuSwitch1').title='隐藏';
	}
	else
	{
		rightFrame.rows = "0,9,*";
		document.getElementById('menuSwitch1').src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/ej1_31a.png';
		document.getElementById('menuSwitch1').title='显示';
	}

	flag = !flag;
}
</script>
</HEAD>

<BODY onclick="shift_status()" leftmargin=0 topmargin=0   bgcolor="#DCDCDC">
<span class="cacher" id="cacheData" name="cacheData"></span>
<table width="100%" height="9" border=0 cellpadding="0" cellspacing="0">
	<tr>
	 <td align="center" background="images/control-top-line.png" id=menuSwitch style="cursor:hand"><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/ej1_31.png" name="menuSwitch1" height="9" id="menuSwitch1"></td>
	</tr>
</table>
</BODY>
</HTML>