<html>
<?
if(empty($strDomain) || $strDomain == "")
{
?>
<script language='JavaScript'>
function CheckInput() {
if (!document.domainreg.agreement.checked)
{
	alert('您尚未阅读并接受商务中国的域名注册协议.');
	return false;
}
if(document.domainreg.dom_org.value.length > 50)
{
	alert('域名所有者 长度不能超过50');
	document.domainreg.dom_org.focus();
	return false;
}
bString = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 -.,()@&!'";
for(i = 0; i < document.domainreg.dom_org.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_org.value.substring(i,i+1))==-1)
	{
		alert('域名所有者 只能包含字母数字和-.,()\@&!');
		document.domainreg.dom_org.focus();
		return false;
	}
}

if(document.domainreg.dom_ln.value.length > 30)
{
	alert('姓 长度不能超过30');
	document.domainreg.dom_ln.focus();
	return false;
}
for(i = 0; i < document.domainreg.dom_ln.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_ln.value.substring(i,i+1))==-1)
	{
		alert('姓 只能包含字母数字和-.,()@&!');
		document.domainreg.dom_ln.focus();
		return false;
	}
}

if(document.domainreg.dom_fn.value.length > 30)
{
	alert('名 长度不能超过30');
	document.domainreg.dom_fn.focus();
	return false;
}
for(i = 0; i < document.domainreg.dom_fn.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_fn.value.substring(i,i+1))==-1)
	{
		alert('名 只能包含字母数字和-.,()@&!');
		document.domainreg.dom_fn.focus();
		return false;
	}
}

if(document.domainreg.admi_ln.value.length > 30)
{
	alert('姓 长度不能超过30');
	document.domainreg.admi_ln.focus();
	return false;
}
for(i = 0; i < document.domainreg.admi_ln.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_ln.value.substring(i,i+1))==-1)
	{
		alert('姓 只能包含字母数字和-.,()@&!');
		document.domainreg.admi_ln.focus();
		return false;
	}
}

if(document.domainreg.admi_fn.value.length > 30)
{
	alert('名 长度不能超过30');
	document.domainreg.admi_fn.focus();
	return false;
}
for(i = 0; i < document.domainreg.admi_fn.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_fn.value.substring(i,i+1))==-1)
	{
		alert('名 只能包含字母数字和-.,()@&!');
		document.domainreg.admi_fn.focus();
		return false;
	}
}

if(document.domainreg.tech_ln.value.length > 30)
{
	alert('姓 长度不能超过30');
	document.domainreg.tech_ln.focus();
	return false;
}
for(i = 0; i < document.domainreg.tech_ln.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_ln.value.substring(i,i+1))==-1)
	{
		alert('姓 只能包含字母数字和-.,()@&!');
		document.domainreg.tech_ln.focus();
		return false;
	}
}

if(document.domainreg.tech_fn.value.length > 30)
{
	alert('名 长度不能超过30');
	document.domainreg.tech_fn.focus();
	return false;
}
for(i = 0; i < document.domainreg.tech_fn.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_fn.value.substring(i,i+1))==-1)
	{
		alert('名 只能包含字母数字和-.,()@&!');
		document.domainreg.tech_fn.focus();
		return false;
	}
}

if(document.domainreg.bill_ln.value.length > 30)
{
	alert('姓 长度不能超过30');
	document.domainreg.bill_ln.focus();
	return false;
}
for(i = 0; i < document.domainreg.bill_ln.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_ln.value.substring(i,i+1))==-1)
	{
		alert('姓 只能包含字母数字和-.,()@&!');
		document.domainreg.bill_ln.focus();
		return false;
	}
}

if(document.domainreg.bill_fn.value.length > 30)
{
	alert('名 长度不能超过30');
	document.domainreg.bill_fn.focus();
	return false;
}
for(i = 0; i < document.domainreg.bill_fn.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_fn.value.substring(i,i+1))==-1)
	{
		alert('名 只能包含字母数字和-.,()@&!');
		document.domainreg.bill_fn.focus();
		return false;
	}
}

bString = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
if(document.domainreg.admi_co.value.length < 2)
{
	alert('国家代码 两位字母 例: cn');
	document.domainreg.admi_co.focus();
	return false;
}
for(i = 0; i < document.domainreg.admi_co.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_co.value.substring(i,i+1))==-1)
	{
		alert('国家代码 两位字母 例: cn');
		document.domainreg.admi_co.focus();
		return false;
	}
}

if(document.domainreg.tech_co.value.length < 2)
{
	alert('国家代码 两位字母 例: cn');
	document.domainreg.tech_co.focus();
	return false;
}
for(i = 0; i < document.domainreg.tech_co.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_co.value.substring(i,i+1))==-1)
	{
		alert('国家代码 两位字母 例: cn');
		document.domainreg.tech_co.focus();
		return false;
	}
}

if(document.domainreg.bill_co.value.length < 2)
{
	alert('国家代码 两位字母 例: cn');
	document.domainreg.bill_co.focus();
	return false;
}
for(i = 0; i < document.domainreg.bill_co.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_co.value.substring(i,i+1))==-1)
	{
		alert('国家代码 两位字母 例: cn');
		document.domainreg.bill_co.focus();
		return false;
	}
}

bString = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 -.,#*@/&";
for(i = 0; i < document.domainreg.dom_adr1.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_adr1.value.substring(i,i+1))==-1)
	{
		alert('地址 只能包含字母数字和- . , # * @ / & 空格 地址如果太长的话请注意单词间适当留个空格');
		document.domainreg.dom_adr1.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.admi_adr1.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_adr1.value.substring(i,i+1))==-1)
	{
		alert('地址 只能包含字母数字和- . , # * @ / & 空格 地址如果太长的话请注意单词间适当留个空格');
		document.domainreg.admi_adr1.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.tech_adr1.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_adr1.value.substring(i,i+1))==-1)
	{
		alert('地址 只能包含字母数字和- . , # * @ / & 空格 地址如果太长的话请注意单词间适当留个空格');
		document.domainreg.tech_adr1.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.bill_adr1.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_adr1.value.substring(i,i+1))==-1)
	{
		alert('地址 只能包含字母数字和- . , # * @ / & 空格 地址如果太长的话请注意单词间适当留个空格');
		document.domainreg.bill_adr1.focus();
		return false;
	}
}

bString = "0123456789,.+()/-&";
for(i = 0; i < document.domainreg.dom_ph.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_ph.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.dom_ph.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.dom_fax.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_fax.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.dom_fax.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.admi_ph.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_ph.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.admi_ph.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.admi_fax.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_fax.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.admi_fax.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.tech_ph.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_ph.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.tech_ph.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.tech_fax.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_fax.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.tech_fax.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.bill_ph.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_ph.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.bill_ph.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.bill_fax.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_fax.value.substring(i,i+1))==-1)
	{
		alert('电话传真 只能包含数字和,.+()/-&');
		document.domainreg.bill_fax.focus();
		return false;
	}
}

bString = "0123456789-*";
for(i = 0; i < document.domainreg.dom_pc.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_pc.value.substring(i,i+1))==-1)
	{
		alert('邮编 只能包含数字-*');
		document.domainreg.dom_pc.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.admi_pc.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_pc.value.substring(i,i+1))==-1)
	{
		alert('邮编 只能包含数字-*');
		document.domainreg.admi_pc.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.tech_pc.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_pc.value.substring(i,i+1))==-1)
	{
		alert('邮编 只能包含数字-*');
		document.domainreg.tech_pc.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.bill_pc.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_pc.value.substring(i,i+1))==-1)
	{
		alert('邮编 只能包含数字-*');
		document.domainreg.bill_pc.focus();
		return false;
	}
}

bString = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 -.,\'";
for(i = 0; i < document.domainreg.dom_st.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_st.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.dom_st.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.dom_ct.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.dom_ct.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.dom_ct.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.admi_st.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_st.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.admi_st.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.admi_ct.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.admi_ct.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.admi_ct.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.tech_st.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_st.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.tech_st.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.tech_ct.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.tech_ct.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.tech_ct.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.bill_st.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_st.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.bill_st.focus();
		return false;
	}
}

for(i = 0; i < document.domainreg.bill_ct.value.length; i ++)
{
	if (bString.indexOf(document.domainreg.bill_ct.value.substring(i,i+1))==-1)
	{
		alert('省份城市 只能包含字母数字 -.,和空格');
		document.domainreg.bill_ct.focus();
		return false;
	}
}



return true;
}
</script>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=GB2312">
<tltle>域名注册</title>
</HEAD>
<body>
      <p align="center"><font color="#FF0000">以下每项资料必填且只能输入英文<br>
        </font></p>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <form name="domainreg" method="post" action="index.php" onSubmit='return CheckInput()'>
          <tr> 
            <td width="50" valign="top">1.</td>
            <td> 
              <table border=0 cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td width="150">要注册的域名: </td>
                  <td><input type="text" name="strDomain" maxlength=67></td>
                </tr>
                <tr>
                  <td width="150">域名管理密码: </td>
                  <td><input type="text" name="strDomainpwd" maxlength=32></td>
                </tr>
                <tr> 
                  <td width="150">选择注册年限：</td>
                  <td> 
                    <select name="years">
                      <option value=1>1</option>
                      <option value=2 selected>2</option>
					  <option value=3>3</option>
					  <option value=4>4</option>
                      <option value=5>5</option>
					  <option value=6>6</option>
					  <option value=7>7</option>
					  <option value=8>8</option>
					  <option value=9>9</option>
                      <option value=10>10</option>
                    </select>
                  </td>
                </tr>
              </table>
              <br>
              <table border=0 width="100%" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="150">域名服务器(DNS)：</td>
                  <td> 
                    <input type="text" name="dns_host1" value="dns.bizcn.com">
                  </td>
                </tr>
                <tr> 
                  <td width="150">域名服务器IP：</td>
                  <td> 
                    <input type="text" name="dns_ip1" value="218.5.77.19">
                  </td>
                </tr>
                <tr> 
                  <td width="150">域名服务器(DNS)：</td>
                  <td> 
                    <input type="text" name="dns_host2" value="dns.cnmsn.net">
                  </td>
                </tr>
                <tr> 
                  <td width="150">域名服务器IP：</td>
                  <td> 
                    <input type="text" name="dns_ip2" value="61.151.248.15">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td rowspan="2" valign="top"><br>2.</td>
            <td> 
              <hr size=1 color="#084B8E">
            </td>
          </tr>
          <tr> 
            <td> 
              <p><b>域名所有者</b></p>
              <p> 
              <table border=0 width="100%" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100">域名所有者</td>
                  <td> 
                    <input type="text" name="dom_org" value="" maxlength="50">
                  </td>
                </tr>
                <tr> 
                  <td>姓</td>
                  <td> 
                    <input type="text" name="dom_ln" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>名</td>
                  <td> 
                    <input type="text" name="dom_fn" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>国家代码</td>
                  <td>
                   <input type="text" name="dom_co" value="cn" maxlength="2">
                  </td>
                </tr>
                <tr> 
                  <td>省份</td>
                  <td> 
                    <input type="text" name="dom_st" value="" maxlength="40">
                  </td>
                </tr>
                <tr> 
                  <td>城市</td>
                  <td> 
                    <input type="text" name="dom_ct" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>地址</td>
                  <td> 
                    <input type="text" name="dom_adr1" value="" maxlength="120">
                  </td>
                </tr>
                <tr> 
                  <td>邮编</td>
                  <td> 
                    <input type="text" name="dom_pc" value="">
                  </td>
                </tr>
                <tr> 
                  <td>电话</td>
                  <td> 
                    <input type="text" name="dom_ph" value="">
                  </td>
                </tr>
                <tr> 
                  <td>传真</td>
                  <td> 
                    <input type="text" name="dom_fax" value="">
                  </td>
                </tr>
                <td>电子邮件</td>
                <td> 
                  <input type="text" name="dom_em" value="">
                </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td valign="top"><br>3.</td>
            <td> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td colspan="2"> 
                    <hr size=1 color="#084B8E">
                  </td>
                </tr>
                <tr> 
                  <td width="100"><b>域名管理人</b></td>
                  <td> 
                    <div align="right"><input type=button value='复制所有人信息' onClick='
document.domainreg.admi_fn.value=document.domainreg.dom_fn.value;
document.domainreg.admi_ln.value=document.domainreg.dom_ln.value;
document.domainreg.admi_co.value=document.domainreg.dom_co.value;
document.domainreg.admi_st.value=document.domainreg.dom_st.value;
document.domainreg.admi_ct.value=document.domainreg.dom_ct.value;
document.domainreg.admi_adr1.value=document.domainreg.dom_adr1.value;
document.domainreg.admi_pc.value=document.domainreg.dom_pc.value;
document.domainreg.admi_ph.value=document.domainreg.dom_ph.value;
document.domainreg.admi_fax.value=document.domainreg.dom_fax.value;
document.domainreg.admi_em.value=document.domainreg.dom_em.value;
'> </div>
                  </td>
                </tr>
              </table>
              <table border=0 width="100%" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100">姓</td>
                  <td> 
                    <input type="text" name="admi_ln" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>名</td>
                  <td> 
                    <input type="text" name="admi_fn" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>国家代码</td>
                  <td> 
                    <input type="text" name="admi_co" maxlength=2 value="cn"> (两位字母 例: cn)		
                  </td>
                </tr>
                <tr> 
                  <td>省份</td>
                  <td> 
                    <input type="text" name="admi_st" value="" maxlength="40">
                  </td>
                </tr>
                <tr> 
                  <td>城市</td>
                  <td> 
                    <input type="text" name="admi_ct" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>地址</td>
                  <td> 
                    <input type="text" name="admi_adr1" value="" maxlength="120">
                  </td>
                </tr>
                <tr> 
                  <td>邮编</td>
                  <td> 
                    <input type="text" name="admi_pc" value="">
                  </td>
                </tr>
                <tr> 
                  <td>电话</td>
                  <td> 
                    <input type="text" name="admi_ph" value="">
                  </td>
                </tr>
                <tr> 
                  <td>传真</td>
                  <td> 
                    <input type="text" name="admi_fax" value="">
                  </td>
                </tr>
                <td>电子邮件</td>
                <td> 
                  <input type="text" name="admi_em" value="">
                </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> 
              <hr size=1 color="#084B8E">
            </td>
          </tr>
          <tr> 
            <td valign="top">4.</td>
            <td> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="80"><b>技术联系人</b></td>
                  <td> 
                    <div align="right"> <input type=button value='复制所有人信息' onClick='
document.domainreg.tech_fn.value=document.domainreg.dom_fn.value;
document.domainreg.tech_ln.value=document.domainreg.dom_ln.value;
document.domainreg.tech_co.value=document.domainreg.dom_co.value;
document.domainreg.tech_st.value=document.domainreg.dom_st.value;
document.domainreg.tech_ct.value=document.domainreg.dom_ct.value;
document.domainreg.tech_adr1.value=document.domainreg.dom_adr1.value;
document.domainreg.tech_pc.value=document.domainreg.dom_pc.value;
document.domainreg.tech_ph.value=document.domainreg.dom_ph.value;
document.domainreg.tech_fax.value=document.domainreg.dom_fax.value;
document.domainreg.tech_em.value=document.domainreg.dom_em.value;
'><input type=button value='复制管理人信息' onClick='
document.domainreg.tech_fn.value=document.domainreg.admi_fn.value;
document.domainreg.tech_ln.value=document.domainreg.admi_ln.value;
document.domainreg.tech_co.value=document.domainreg.admi_co.value;
document.domainreg.tech_st.value=document.domainreg.admi_st.value;
document.domainreg.tech_ct.value=document.domainreg.admi_ct.value;
document.domainreg.tech_adr1.value=document.domainreg.admi_adr1.value;
document.domainreg.tech_pc.value=document.domainreg.admi_pc.value;
document.domainreg.tech_ph.value=document.domainreg.admi_ph.value;
document.domainreg.tech_fax.value=document.domainreg.admi_fax.value;
document.domainreg.tech_em.value=document.domainreg.admi_em.value;
'> </div>
                  </td>
                </tr>
              </table>
              <table border=0 width="100%" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100">姓</td>
                  <td> 
                    <input type="text" name="tech_ln" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>名</td>
                  <td> 
                    <input type="text" name="tech_fn" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>国家代码</td>
                  <td> 
                    <input type="text" name="tech_co" maxlength=2 value="cn"> (两位字母 例: cn)
                  </td>
                </tr>
                <tr> 
                  <td>省份</td>
                  <td> 
                    <input type="text" name="tech_st" value="" maxlength="40">
                  </td>
                </tr>
                <tr> 
                  <td>城市</td>
                  <td> 
                    <input type="text" name="tech_ct" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>地址</td>
                  <td> 
                    <input type="text" name="tech_adr1" value="" maxlength="120">
                  </td>
                </tr>
                <tr> 
                  <td>邮编</td>
                  <td> 
                    <input type="text" name="tech_pc" value="">
                  </td>
                </tr>
                <tr> 
                  <td>电话</td>
                  <td> 
                    <input type="text" name="tech_ph" value="">
                  </td>
                </tr>
                <tr> 
                  <td>传真</td>
                  <td> 
                    <input type="text" name="tech_fax" value="">
                  </td>
                </tr>
                <td>电子邮件</td>
                <td> 
                  <input type="text" name="tech_em" value="">
                </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> 
              <hr size=1 color="#084B8E">
            </td>
          </tr>
          <tr> 
            <td valign="top">5.</td>
            <td> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="80"><b>缴费联系人</b></td>
                  <td> 
                    <div align="right"> <input type=button value='复制技术人信息' onClick='
document.domainreg.bill_fn.value=document.domainreg.tech_fn.value;
document.domainreg.bill_ln.value=document.domainreg.tech_ln.value;
document.domainreg.bill_co.value=document.domainreg.tech_co.value;
document.domainreg.bill_st.value=document.domainreg.tech_st.value;
document.domainreg.bill_ct.value=document.domainreg.tech_ct.value;
document.domainreg.bill_adr1.value=document.domainreg.tech_adr1.value;
document.domainreg.bill_pc.value=document.domainreg.tech_pc.value;
document.domainreg.bill_ph.value=document.domainreg.tech_ph.value;
document.domainreg.bill_fax.value=document.domainreg.tech_fax.value;
document.domainreg.bill_em.value=document.domainreg.tech_em.value;
'><input type=button value='复制管理人信息' onClick='
document.domainreg.bill_fn.value=document.domainreg.admi_fn.value;
document.domainreg.bill_ln.value=document.domainreg.admi_ln.value;
document.domainreg.bill_co.value=document.domainreg.admi_co.value;
document.domainreg.bill_st.value=document.domainreg.admi_st.value;
document.domainreg.bill_ct.value=document.domainreg.admi_ct.value;
document.domainreg.bill_adr1.value=document.domainreg.admi_adr1.value;
document.domainreg.bill_pc.value=document.domainreg.admi_pc.value;
document.domainreg.bill_ph.value=document.domainreg.admi_ph.value;
document.domainreg.bill_fax.value=document.domainreg.admi_fax.value;
document.domainreg.bill_em.value=document.domainreg.admi_em.value;
'> </div>
                  </td>
                </tr>
              </table>
              <table border=0 width="100%" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100">姓</td>
                  <td> 
                    <input type="text" name="bill_ln" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>名</td>
                  <td> 
                    <input type="text" name="bill_fn" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>国家代码</td>
                  <td> 
                    <input type="text" name="bill_co" maxlength=2 value="cn"> (两位字母 例: cn)

                  </td>
                </tr>
                <tr> 
                  <td>省份</td>
                  <td> 
                    <input type="text" name="bill_st" value="" maxlength="40">
                  </td>
                </tr>
                <tr> 
                  <td>城市</td>
                  <td> 
                    <input type="text" name="bill_ct" value="" maxlength="30">
                  </td>
                </tr>
                <tr> 
                  <td>地址</td>
                  <td> 
                    <input type="text" name="bill_adr1" value="" maxlength="120">
                  </td>
                </tr>
                <tr> 
                  <td>邮编</td>
                  <td> 
                    <input type="text" name="bill_pc" value="">
                  </td>
                </tr>
                <tr> 
                  <td>电话</td>
                  <td> 
                    <input type="text" name="bill_ph" value="">
                  </td>
                </tr>
                <tr> 
                  <td>传真</td>
                  <td> 
                    <input type="text" name="bill_fax" value="">
                  </td>
                </tr>
                <td>电子邮件</td>
                <td> 
                  <input type="text" name="bill_em" value="">
                </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td height="45"> 
              <input type="checkbox" name="agreement" value="1">
              我已经阅读、理解并接受 <a href="#" target="_blank">商务中国的域名注册协议 
              </a></td>
          </tr>
          <tr> 
            <td> &nbsp;</td>
            <td> 
              <div align="center"> 
                <input type="submit" name="submit" value="确定">
              </div>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </form>
      </table>
</body>
<?
} //域名为空, 显示页面
else
{
?>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=GB2312">
<tltle>域名注册结果</title>
</HEAD>
<body>
<?
	//检查域名是否包含违法字符及是否符合规范
	$intPont = 0;
	for($i = 0; $i < strlen($strDomain); $i ++)
	{
		if(!(($strDomain[$i] >= 'a' && $strDomain[$i] <= 'z') || ($strDomain[$i] >= 'A' && $strDomain[$i] <= 'A')
		    || ($strDomain[$i] >= '0' && $strDomain[$i] <= '9'))
		    && $strDomain[$i] != '-' && $strDomain[$i] != '.')
		{
			echo "您的域名不符合域名规范";
			exit(0);
		}
		if($strDomain[$i] == '.')
		{
			$intPont ++;
		}
	}
	
	if($intPont < 1 || $intPont > 2)
	{
		echo "您的域名不符合域名规范";
		exit(0);
	}
	
	if($intPont > 1 && strcasecmp(".cn", substr($strDomain, -3)) != 0 && strcasecmp(".name", substr($strDomain, -5)) != 0)
	{
		echo "您的域名不符合域名规范";
		exit(0);
	}

	$strContent = "domainname\r\nadd\r\nentityname:domain\r\n";
	$strContent .= "domainname:" . $strDomain . "\r\n";
	$strContent .= "term:". $years . "\r\n";
	$strContent .= "dns_host1:" . $dns_host1 . "\r\n";
	$strContent .= "dns_ip1:". $dns_ip1 . "\r\n";
	$strContent .= "dns_host2:" . $dns_host2 . "\r\n";
	$strContent .= "dns_ip2:" . $dns_ip2 . "\r\n";
	$strContent .= "dom_org:" . $dom_org . "\r\n";
	$strContent .= "dom_fn:" . $dom_fn . "\r\n";
	$strContent .= "dom_ln:" . $dom_ln . "\r\n";
	$strContent .= "dom_adr1:" . $dom_adr1 . "\r\n";
	$strContent .= "dom_ct:" . $dom_ct . "\r\n";
	$strContent .= "dom_st:" . $dom_st . "\r\n";
	$strContent .= "dom_co:" . $dom_co . "\r\n";
	$strContent .= "dom_pc:" . $dom_pc . "\r\n";
	$strContent .= "dom_ph:" . $dom_ph . "\r\n";
	$strContent .= "dom_fax:" . $dom_fax . "\r\n";
	$strContent .= "dom_em:" . $dom_em . "\r\n";
	$strContent .= "tech_fn:" . $tech_fn . "\r\n";
	$strContent .= "tech_ln:" . $tech_ln . "\r\n";
	$strContent .= "tech_adr1:" . $tech_adr1 . "\r\n";
	$strContent .= "tech_ct:" . $tech_ct . "\r\n";
	$strContent .= "tech_st:" . $tech_st . "\r\n";
	$strContent .= "tech_co:" . $tech_co . "\r\n";
	$strContent .= "tech_pc:" . $tech_pc . "\r\n";
	$strContent .= "tech_ph:" . $tech_ph . "\r\n";
	$strContent .= "tech_fax:" . $tech_fax . "\r\n";
	$strContent .= "tech_em:" . $tech_em . "\r\n";
	$strContent .= "bill_fn:" . $bill_fn . "\r\n";
	$strContent .= "bill_ln:" . $bill_ln . "\r\n";
	$strContent .= "bill_adr1:" . $bill_adr1 . "\r\n";
	$strContent .= "bill_ct:" . $bill_ct . "\r\n";
	$strContent .= "bill_st:" . $bill_st . "\r\n";
	$strContent .= "bill_co:" . $bill_co . "\r\n";
	$strContent .= "bill_pc:" . $bill_pc . "\r\n";
	$strContent .= "bill_ph:" . $bill_ph . "\r\n";
	$strContent .= "bill_fax:" . $bill_fax . "\r\n";
	$strContent .= "bill_em:" . $bill_em . "\r\n";
	$strContent .= "admi_fn:" . $admi_fn . "\r\n";
	$strContent .= "admi_ln:" . $admi_ln . "\r\n";
	$strContent .= "admi_adr1:" . $admi_adr1 . "\r\n";
	$strContent .= "admi_ct:" . $admi_ct . "\r\n";
	$strContent .= "admi_st:" . $admi_st . "\r\n";
	$strContent .= "admi_co:" . $admi_co . "\r\n";
	$strContent .= "admi_pc:" . $admi_pc . "\r\n";
	$strContent .= "admi_ph:" . $admi_ph . "\r\n";
	$strContent .= "admi_fax:" . $admi_fax . "\r\n";
	$strContent .= "admi_em:" . $admi_em . "\r\n";
	$strContent .= "domainpwd:" . $strDomainpwd. "\r\n";
	$strContent .= ".\r\n";
	
	$midkeyServer = "120.25.217.82";		//此为运行中间件服务器的IP
	$midkeyPort = 8000;					//此为中间件监听的端口

	$mySocket = fsockopen ($midkeyServer, $midkeyPort, $errno, $errstr, 30);
	
	if(!$mySocket)
	{
		echo "无法打开连接";
		exit();
	}
	print_r($strContent);
	fputs($mySocket, $strContent);
	
	$strReturn = "";
	$blnAba = true;
	
	while(!feof($mySocke))
	{
		$strReturn .= fgets($mySocket, 2048);
		if($blnAba && intval($strReturn) <= 0)
		{
			$strReturn = "";
		}
		else
		{
			$blnAba = false;
		}

		if(strstr($strReturn, "\r\n.\r\n"))
		{
			break;
		}
	}
	fclose($mySocke);
	
	//echo "Get Response:<br>\n" . $strReturn;
	if(strncmp("200 ", $strReturn, 4) != 0)
	{
		echo "注册失败, 错误代码: \n<br>" . $strReturn;
	}
	else
	{
		$strOrderid = substr(strstr($strReturn, "orderid:"), strlen("orderid:"));
		$intOrderid = intval($strOrderid);
		echo "域名注册成功. 订单号为" . $intOrderid;
	}
?>
</BODY>
<?
}
?>
</html>
