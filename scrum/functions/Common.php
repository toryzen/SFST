<?php  if ( ! defined('SYSTEM')) exit('Go away!');
//跳转
if(!function_exists("redirct")){
	function redirct($url,$contents="操作成功"){
		echo "<script>alert('$contents');top.location='$url'</script>";
		//header("Location:$url");
	}
}
//短网址
if(!function_exists("dwz")){
	function dwz($url){
		$code = sprintf('%u', crc32($url));
		$surl = '';
		while($code){
			$mod = $code % 62;
			if($mod>9 && $mod<=35){
				$mod = chr($mod + 55);
			}elseif($mod>35){
				$mod = chr($mod + 61);
			}
			$surl .= $mod;
			$code = floor($code/62);
		}
		return $surl;
	}
}