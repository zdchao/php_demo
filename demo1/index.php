<?php
$mod = 755;
$mod = octdec('0'.$mod);

/**
 * 修改文件、文件夹权限
 * @param  $path 文件(夹)目录
 * @return :string
 */
function chmod_path($path,$mod){
	if (!isset($mod)) $mod = 0777;
	if (!file_exists($path)) return;
	if (is_file($path)) return @chmod($path,$mod);
	if (!$dh = @opendir($path)) return false;
	while (($file = readdir($dh)) !== false){
		if ($file != "." && $file != "..") {
			$fullpath = $path . '/' . $file;
			@chmod($fullpath,$mod);
			chmod_path($fullpath,$mod);
		}
	}
	closedir($dh);
	return @chmod($path,$mod);
}