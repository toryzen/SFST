<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * 路由类
 * @author toryzen 
 *
 */
class D{
	
	//控制器
	public $class = "Index";
	//方法
	public $method = "index";
	
    public function __construct(){
    	global $config_rt;
    	
    	$this->class  = isset($config_rt['class'])?$config_rt['class']:$this->class;
    	$this->method = isset($config_rt['method'])?$config_rt['method']:$this->method;
    	
    	//判断路由模式
    	switch($config_rt['type']) {
			case 1:
				$this->class  = isset($_GET['c'])?$_GET['c']:$this->class;
				$this->method = isset($_GET['m'])?$_GET['m']:$this->method;
				break;
			case 2:
				$PATH_INFO = $_SERVER['PATH_INFO'];
				$PATH_INFO_ARRAY = explode("/",$PATH_INFO);
				$this->class  = isset($PATH_INFO_ARRAY[1])&&$PATH_INFO_ARRAY[1]!=""?$PATH_INFO_ARRAY[1]:$this->class;
				$this->method = isset($PATH_INFO_ARRAY[2])&&$PATH_INFO_ARRAY[2]!=""?$PATH_INFO_ARRAY[2]:$this->method;
				break;
			case 3:
				$PATH_INFO = $_SERVER['PATH_INFO'];
				$PATH_INFO_ARRAY = explode("/",$PATH_INFO);
				$this->class  = isset($PATH_INFO_ARRAY[1])&&$PATH_INFO_ARRAY[1]!=""?$PATH_INFO_ARRAY[1]:isset($_GET['c'])?$_GET['c']:$this->class;
				$this->method = isset($PATH_INFO_ARRAY[2])&&$PATH_INFO_ARRAY[2]!=""?$PATH_INFO_ARRAY[2]:isset($_GET['m'])?$_GET['m']:$this->method;
				break;
			default:
				show_error("路由类型设置错误！");
    			
    	};
    	
    	//重定向
    	if(isset($config_rt['redict'][$this->class."/".$this->method])){
    		$redict_path = explode("/",$config_rt['redict'][$this->class."/".$this->method]);
    		$this->class = $redict_path[0];
    		$this->method= $redict_path[1];
    	}
    	
    	
    }
    
    
    
}