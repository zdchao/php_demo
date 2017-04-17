<?php  
$mov  = file_get_contents("abc.txt");           //读取分割文件的信息  
$list = explode("\r\n",$mov);  
$fp   = fopen("split.wmv","ab");                  //合并后的文件名  
foreach($list as $value)  
{  
if(!emptyempty($value)) {    
      $handle = fopen($value,"rb");  
      fwrite($fp,fread($handle,filesize($value)));  
      fclose($handle);  
      unset($handle);  
	}  
}  
fclose($fp);  
?>  