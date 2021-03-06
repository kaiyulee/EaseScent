<?php
header("Content-Type:text/html; charset=utf-8");
set_time_limit(0);
echo 'Start...'."\r\n";
$ZlData = new ZlData();
$ZlData->index4();
echo 'Over'."\r\n";
class ZlData{
	public function __construct(){
		$DB = new DB();
		$String = new String();
	}
	public function index(){
		$DB = new DB();
		$path = '../../../Upload/Jiuku/Region/images/';
		$handle = opendir($path);
		while(false !== ($file=readdir($handle))){
			if($file != '.' && $file != '..' && !is_dir($path.$file)){
				$filearr[] = $file;
			}
		}
		$file_count = count($filearr);
		foreach($filearr as $key=>$val){
			echo '	RegionImg:	'.($key+1).'	/ '.$file_count."\r\n";
			$indexpath = mb_substr($val,0,2,'utf-8').'/'.mb_substr($val,2,2,'utf-8').'/';
			if(!is_dir($path.$indexpath)){
				mkdir($path.$indexpath, 0777 ,true);
				@touch($path.$indexpath.'/index.html');
			}
			copy($path.$val,$path.$indexpath.$val);
			//unlink($path.$val);
			$imginfo = getimagesize($path.$indexpath.$val);
			$extstr = '.gif|.jpeg|.png';
			$ext1 = image_type_to_extension($imginfo['2']);
			$tempArr = explode(".", $val);
			$ext2 = strtolower(trim(array_pop($tempArr)));
			if(stripos($extstr,$ext1) && in_array($ext2,array('gif','jpg','jpeg','png'))){
				$this->thumb2($path.$indexpath.$val,80,60);
				$this->thumb2($path.$indexpath.$val,150,195);
			}
		}
		$res = $DB->linkmysql('SELECT * FROM `jiuku_region_img` WHERE `filename` not like \'%/%\'');
		foreach($res as $key=>$val){
			echo '	RegionImgSql:	'.($key+1).'	/ '.count($res)."\r\n";
			$val['filename'] = mb_substr($val['filename'],0,2,'utf-8').'/'.mb_substr($val['filename'],2,2,'utf-8').'/'.$val['filename'];
			$DB->linkmysql('UPDATE `jiuku_region_img` SET `filename`=\''.$val['filename'].'\' WHERE `id`='.$val['id']);
		}
		$this->index2();
	}
	public function index2(){
		$DB = new DB();
		$path = '../../../Upload/Jiuku/Winery/images/';
		$handle = opendir($path);
		while(false !== ($file=readdir($handle))){
			if($file != '.' && $file != '..' && !is_dir($path.$file)){
				$filearr[] = $file;
			}
		}
		$file_count = count($filearr);
		foreach($filearr as $key=>$val){
			echo '	WineryImg:	'.($key+1).'	/ '.$file_count."\r\n";
			$indexpath = mb_substr($val,0,2,'utf-8').'/'.mb_substr($val,2,2,'utf-8').'/';
			if(!is_dir($path.$indexpath)){
				mkdir($path.$indexpath, 0777 ,true);
				@touch($path.$indexpath.'/index.html');
			}
			copy($path.$val,$path.$indexpath.$val);
			//unlink($path.$val);
			$imginfo = getimagesize($path.$indexpath.$val);
			$extstr = '.gif|.jpeg|.png';
			$ext1 = image_type_to_extension($imginfo['2']);
			$tempArr = explode(".", $val);
			$ext2 = strtolower(trim(array_pop($tempArr)));
			if(stripos($extstr,$ext1) && in_array($ext2,array('gif','jpg','jpeg','png'))){
				$this->thumb2($path.$indexpath.$val,300,225);
			}
		}
		$res = $DB->linkmysql('SELECT * FROM `jiuku_winery_img` WHERE `filename` not like \'%/%\'');
		foreach($res as $key=>$val){
			echo '	RegionImgSql:	'.($key+1).'	/ '.count($res)."\r\n";
			$val['filename'] = mb_substr($val['filename'],0,2,'utf-8').'/'.mb_substr($val['filename'],2,2,'utf-8').'/'.$val['filename'];
			$DB->linkmysql('UPDATE `jiuku_winery_img` SET `filename`=\''.$val['filename'].'\' WHERE `id`='.$val['id']);
		}
		$this->index3();
	}
	public function index3(){
		$DB = new DB();
		$path = '../../../Upload/Jiuku/Wine/images/';
		$handle = opendir($path);
		while(false !== ($file=readdir($handle))){
			if($file != '.' && $file != '..' && is_dir($path.$file)){
				$handle2 = opendir($path.$file.'/');
				while(false !== ($file2=readdir($handle2))){
					if($file2 != '.' && $file2 != '..' && is_dir($path.$file.'/'.$file2)){
						$handle3 = opendir($path.$file.'/'.$file2.'/');
						while(false !== ($file3=readdir($handle3))){
							if($file3 != '.' && $file3 != '..' && !is_dir($path.$file.'/'.$file2.'/'.$file3)){
								$filearr[] = array($path.$file.'/'.$file2.'/',$file3);
							}
						}
					}
				}
			}
		}
		$file_count = count($filearr);
		foreach($filearr as $key=>$val){
			echo '	WineImg:	'.($key+1).'	/ '.$file_count."\r\n";
			//unlink($path.$val);
			$imginfo = @getimagesize($val[0].$val[1]);
			$extstr = '.gif|.jpeg|.png';
			$ext1 = image_type_to_extension($imginfo['2']);
			$tempArr = explode(".", $val[1]);
			$ext2 = strtolower(trim(array_pop($tempArr)));
			if($ext2 == '200'){
				unlink($val[0].$val[1]);
			}
			if(stripos($extstr,$ext1) && in_array($ext2,array('gif','jpg','jpeg','png'))){
				$this->thumb3($val[0].$val[1],90,120);
				$this->thumb3($val[0].$val[1],180,240);
			}
		}
	}
	public function index4(){
		$DB = new DB();
		$path = '../../../Upload/Jiuku/Region/images/';
		$handle = opendir($path);
		while(false !== ($file=readdir($handle))){
			if($file != '.' && $file != '..' && is_dir($path.$file)){
				$handle2 = opendir($path.$file.'/');
				while(false !== ($file2=readdir($handle2))){
					if($file2 != '.' && $file2 != '..' && is_dir($path.$file.'/'.$file2)){
						$handle3 = opendir($path.$file.'/'.$file2.'/');
						while(false !== ($file3=readdir($handle3))){
							if($file3 != '.' && $file3 != '..' && !is_dir($path.$file.'/'.$file2.'/'.$file3)){
								$filearr[] = array($path.$file.'/'.$file2.'/',$file3);
							}
						}
					}
				}
			}
		}
		$file_count = count($filearr);
		foreach($filearr as $key=>$val){
			echo '	RegionImg:	'.($key+1).'	/ '.$file_count."\r\n";
			//unlink($path.$val);
			$imginfo = @getimagesize($val[0].$val[1]);
			$extstr = '.gif|.jpeg|.png';
			$ext1 = image_type_to_extension($imginfo['2']);
			$tempArr = explode(".", $val[1]);
			$ext2 = strtolower(trim(array_pop($tempArr)));
			$ext3 = strtolower(trim(array_pop($tempArr)));
			if($ext2 == '195' && $ext3 == '150'){
				//var_dump($val[0].$val[1]);
				unlink($val[0].$val[1]);
			}
			if(stripos($extstr,$ext1) && in_array($ext2,array('gif','jpg','jpeg','png'))){
				$this->thumb2($val[0].$val[1],260,195);
				$this->thumb3($val[0].$val[1],620,320);
				//var_dump($val[0].$val[1]);
			}
		}
	}
	static function thumb2($im, $t_width='', $t_height=''){
        $outfile = $im . '.'.$t_width.'.'.$t_height;
	    $file = basename($im);
		$tempArr = explode(".", $file);
		$ext = strtolower(trim(array_pop($tempArr)));
		if(!in_array($ext,array('gif','jpg','jpeg','png'))){
			return false;
		}
		$imgType = array(1=>'gif', 2=>'jpeg', 3=>'png');
		if(!list($width, $height, $type) = getimagesize($im)){
			return false;
		}
		$funcCreate = "imagecreatefrom".$imgType[$type];
		$funcOut = "image".$imgType[$type];
		$w_h = ($width/$t_width > $height/$t_height) ? 'w' : 'h';
		if($w_h == 'w'){
			$w_h_percent = $height/$t_height;
			$z_height = $t_height;
			$z_width = ceil($width/$w_h_percent);
			$x = ceil(($z_width-$t_width)/2*$w_h_percent);
			$y = 0;
		}else{
			//下移
			$w_h_percent = $width/$t_width;
			$z_width = $t_width;
			$z_height = ceil($height/$w_h_percent);
			$x = 0;
			$y = ceil(($z_height-$t_height)/2*$w_h_percent*1.6);
		}
		$thumb = imagecreatetruecolor($t_width, $t_height);
		$color = imagecolorAllocate($thumb,255,255,255);
		imagefill($thumb,0,0,$color);
		$img = $funcCreate($im);
		imagecopyresampled($thumb, $img, 0, 0, $x, $y, $z_width, $z_height, $width, $height);
		$funcOut($thumb,$outfile);
    }
    static function thumb3($im, $t_width='', $t_height=''){
        $outfile = $im . '.'.$t_width.'.'.$t_height;
	    $file = basename($im);
		$tempArr = explode(".", $file);
		$ext = strtolower(trim(array_pop($tempArr)));
		if(!in_array($ext,array('gif','jpg','jpeg','png'))){
			return false;
		}
		$imgType = array(1=>'gif', 2=>'jpeg', 3=>'png');
		if(!list($width, $height, $type) = getimagesize($im)){
			return false;
		}
		$funcCreate = "imagecreatefrom".$imgType[$type];
		$funcOut = "image".$imgType[$type];
		$w_h = ($width/$t_width > $height/$t_height) ? 'w' : 'h';
		if($w_h == 'w'){
			$w_h_percent = $width/$t_width;
			$z_width = $t_width;
			$z_height = ceil($height/$w_h_percent);
			$x = 0;
			$y = floor(($t_height-$z_height)/2);
		}else{
			$w_h_percent = $height/$t_height;
			$z_height = $t_height;
			$z_width = ceil($width/$w_h_percent);
			$x = floor(($t_width-$z_width)/2);
			$y = 0;
		}
		$thumb = imagecreatetruecolor($t_width, $t_height);
		$color = imagecolorAllocate($thumb,248,248,248);
		imagefill($thumb,0,0,$color);
		$img = $funcCreate($im);
		imagecopyresampled($thumb, $img, $x, $y, 0, 0, $z_width, $z_height, $width, $height);
		$funcOut($thumb,$outfile);
    }
}
class String{
	function myReplace($array){
		$f = array('\'');
		$r = array('\'\'');
		foreach($array as $key=>$val){
			$array[$key] = trim(str_replace($f,$r,$val));
		}
		return $array;
	}
}
class DB{
	function linkmysql($sql){
		$connect=mysql_connect('localhost','root','vertrigo');
		if(!$connect)
		{
			die(''.mysql_error());
			return false;
		}
		$db_selected=mysql_select_db('eswine_ww',$connect);
		if(!$db_selected)
		{
			die(''.mysql_error());
			return false;
		}
		mysql_query("set names utf8"); 
		$result=mysql_query($sql,$connect);
		if(!$result)
		{
			echo $sql;
			die('sql Error!'.mysql_error());
			return false;
		}
		if($result === true){
			$return1 = true;
		}else{
			$return1 = array();
			while($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
			$return1[]=$rs;
			}
		}
		mysql_close($connect);
		usleep(20000);
		return $return1;
	}
}
?>