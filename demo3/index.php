<?php
date_default_timezone_set('Asia/Shanghai');
//filesize 解决大于2G 大小问题
//http://stackoverflow.com/questions/5501451/php-x86-how-to-get-filesize-of-2-gb-file-without-external-program
function get_filesize($path){
	$result = false;
	$fp = fopen($path,"r");
	if(! $fp = fopen($path,"r")) return $return;
	if(PHP_INT_SIZE >= 8 ){ //64bit
		$result = (float)(abs(sprintf("%u",@filesize($path))));
	}else{
		if (fseek($fp, 0, SEEK_END) === 0) {
			$result = 0.0;
			$step = 0x7FFFFFFF;
			while ($step > 0) {
				if (fseek($fp, - $step, SEEK_CUR) === 0) {
					$result += floatval($step);
				} else {
					$step >>= 1;
				}
			}
		}else{
			static $iswin;
			if (!isset($iswin)) {
				$iswin = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN');
			}
			static $exec_works;
			if (!isset($exec_works)) {
				$exec_works = (function_exists('exec') && !ini_get('safe_mode') && @exec('echo EXEC') == 'EXEC');
			}
			if ($iswin && class_exists("COM")) {
				try {
					$fsobj = new COM('Scripting.FileSystemObject');
					$f = $fsobj->GetFile( realpath($path) );
					$size = $f->Size;
				} catch (Exception $e) {
					$size = null;
				}
				if (ctype_digit($size)) {
					$result = $size;
				}
			}else if ($exec_works){
				$cmd = ($iswin) ? "for %F in (\"$path\") do @echo %~zF" : "stat -c%s \"$path\"";
				@exec($cmd, $output);
				if (is_array($output) && ctype_digit($size = trim(implode("\n", $output)))) {
					$result = $size;
				}
			}else{
				$result = filesize($path);
			}
		}
	}
	fclose($fp);
	return $result;
}

/**
 * 文件大小格式化
 *
 * @param  $ :$bytes, int 文件大小
 * @param  $ :$precision int  保留小数点
 * @return :string
 */
function size_format($bytes, $precision = 2){
	if ($bytes == 0) return "0 B";
	$unit = array(
			'TB' => 1099511627776,  // pow( 1024, 4)
			'GB' => 1073741824,		// pow( 1024, 3)
			'MB' => 1048576,		// pow( 1024, 2)
			'kB' => 1024,			// pow( 1024, 1)
			'B ' => 1,				// pow( 1024, 0)
	);
	foreach ($unit as $un => $mag) {
		if (doubleval($bytes) >= $mag)
			return round($bytes / $mag, $precision).' '.$un;
	}
}

function setErrorLog($msg){
	$path = "/var/tmp/domain_register.log";
	error_log($msg." ".date("Y-m-d",time())."\n",3,$path);
}

function setSyslog($msg){
	openlog("Bizcn domain register log", LOG_PID | LOG_PERROR, LOG_LOCAL0);
	syslog(LOG_MAIL,$msg."\n");
	closelog();
}

for($i=0;$i<10;$i++){
	setSyslog("sflsjfsfljdslasfkjsdjfsljdfsjdfjsajfslkjdfsdjfshfhsdfsdfjsdkfjlasfjoqiern;ajfosjafjfghaijfoijsijwejoijwefijaskjfosijfsajgqoijfwoaijfwoifj");
// 	$size = get_filesize("/var/tmp/domain_register.log");
// 	echo $size."\n";
// 	$file_size = ($size/1048576);
// 	echo $file_size."\n";
// 	if ($file_size > 5){
// 		unlink("/var/tmp/domain_register.log");
// 	}
// 	$format = size_format($size,2);
// 	echo $format."\n";
}

