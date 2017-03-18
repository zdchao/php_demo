<?php
/**
 * 获取文件(夹)权限 rwx_rwx_rwx
 */
function get_mode($file){
	$Mode = @fileperms($file);
	$theMode = ' '.decoct($Mode);
	$theMode = substr($theMode,-4);
	$Owner = array();$Group=array();$World=array();
	if ($Mode &0x1000) $Type = 'p'; // FIFO pipe
	elseif ($Mode &0x2000) $Type = 'c'; // Character special
	elseif ($Mode &0x4000) $Type = 'd'; // Directory
	elseif ($Mode &0x6000) $Type = 'b'; // Block special
	elseif ($Mode &0x8000) $Type = '-'; // Regular
	elseif ($Mode &0xA000) $Type = 'l'; // Symbolic Link
	elseif ($Mode &0xC000) $Type = 's'; // Socket
	else $Type = 'u'; // UNKNOWN
	// Determine les permissions par Groupe
	$Owner['r'] = ($Mode &00400) ? 'r' : '-';
	$Owner['w'] = ($Mode &00200) ? 'w' : '-';
	$Owner['x'] = ($Mode &00100) ? 'x' : '-';
	$Group['r'] = ($Mode &00040) ? 'r' : '-';
	$Group['w'] = ($Mode &00020) ? 'w' : '-';
	$Group['e'] = ($Mode &00010) ? 'x' : '-';
	$World['r'] = ($Mode &00004) ? 'r' : '-';
	$World['w'] = ($Mode &00002) ? 'w' : '-';
	$World['e'] = ($Mode &00001) ? 'x' : '-';
	// Adjuste pour SUID, SGID et sticky bit
	if ($Mode &0x800) $Owner['e'] = ($Owner['e'] == 'x') ? 's' : 'S';
	if ($Mode &0x400) $Group['e'] = ($Group['e'] == 'x') ? 's' : 'S';
	if ($Mode &0x200) $World['e'] = ($World['e'] == 'x') ? 't' : 'T';
	$Mode = $Type.$Owner['r'].$Owner['w'].$Owner['x'].' '.
			$Group['r'].$Group['w'].$Group['e'].' '.
			$World['r'].$World['w'].$World['e'];
			return $Mode.'('.$theMode.')';
}

/**
 判断文件（夹）是否可写
 $path = "C:/robot/web/de_zhao/kalcaddle-KODExplorer-master/KODExplorer/data/temp/";
 * */
function path_writeable($path){
	$result = intval(is_writeable($path));
	if($result){
		return $result;
	}
	$mode = get_mode($path);
	if( $mode && strlen($mode) == 18 && substr($mode,-9,1) == 'r'){// -rwx rwx rwx(0777)
		return true;
	}
	return false;
}

$resutl = path_writeable("C:/robot/web/de_zhao/kalcaddle-KODExplorer-master/KODExplorer/data/temp/");
var_dump($resutl);






















