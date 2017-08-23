var id=1;
function addRow()
{
jQuery("#tb1").append('<tr><td style="padding-top:10px;"><input type="text"  style="width:280px; height:25px;" name="da" id="TextBox'+id+'"/>&nbsp;<a href="javascript:void(0)" style="color:#1a6cc1;" onclick="deleteRow('+id+')">删除</a></td></tr>');  
id++;
}
function deleteRow(did){   
jQuery('#TextBox'+did).parent().parent().remove();
}
