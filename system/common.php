<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * 公共方法
 * @author toryzen
 *
 */
/*
 * 文件是否存在(区分Windows下大小写)
 */
if(!function_exists("t_file_exists")){
	function t_file_exists($filename){
		if(is_file($filename)){
			if(ISWIN){
				if(basename($filename)!=basename(realpath($filename))){
					return FALSE;
				}
			}
			return TRUE;
		}
		return FALSE;
		
	}
}
/*
 * 载入类
 */
if(!function_exists("load")){
	function &load($class,$file=""){
		static $_class;
		if(isset($_class[$class])){
			return $_class[$class];
		}
		$file_ok = FALSE;
		foreach(array(APP,SYSTEM) as $DIR){
			if(t_file_exists($DIR.$file)){
				if(!class_exists($class)){
					include($DIR.$file);
					$file_ok = TRUE;
					break;
				}
			}
		}
		if(!$file_ok){
			show_error("未找到类文件！".$file);
		}
		
		if(!class_exists($class)){
			show_error("未找到类！".$class);
		}
		$_class[$class] = new $class();
		save_load($class);
		return $_class[$class];
	}
}

/*
 * 记录载入的类
 */
if(!function_exists("save_load")){

	function &save_load($class=""){
		static $is_load = array();
		if($class!=""){
			$is_load[strtolower($class)] = $class;
		}
		return $is_load;
	}
}
/*
 * 加载文件
 */
if(!function_exists("import")){
	function import($filename,$dirc="functions"){
		static $ldfunc = array();
		if(!$ldfunc[$dirc.$filename]){
			if(file_exists(APP.$dirc."/".$filename.".php")){
				require(APP.$dirc."/".$filename.".php");
			}else{
				show_error("加载文件失败！(".APP."functions/".$filename.".php)");
			}	
		}
	}
}
/*
 * 错误信息展示页
 */
if(!function_exists("show_error")){
	function show_error($errinfo,$page=NULL)
	{
		if(DEBUG){
			$default_page = "error_frame";
		}else{
			$default_page = "error_nothing";
		}
		$page = empty($page)?$default_page:"error_".$page;
		if(t_file_exists(SYSTEM."html/".$page.".php")){
			include SYSTEM."html/".$page.".php";
		}else{
			exit("Error Page Not Found !");
		}
		die();
	}
}
//URL地址获取
if(!function_exists("url")){
	function url($param=""){
		$PHP_SELF = explode("/",$_SERVER['SCRIPT_NAME']);
		array_pop($PHP_SELF);
		foreach($PHP_SELF as $PS){
			$SELF .= $PS."/";
		}
		$URL = "http://".$_SERVER['HTTP_HOST'].$SELF;
		if($param){
			return "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."/".$param;
		}else{
			return $URL;
		}
	}
}