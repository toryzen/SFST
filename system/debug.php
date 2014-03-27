<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * Debug
 * @author toryzen(toryzen.com) 
 *
 */
class Debug{
	
	public $_starttime;
	public $_startmems;
	public $marker = array();
	
	public function __construct($starttime=null,$startmems=null){
		$this->marker['time']['初始化']    = isset($starttime)?$starttime:microtime(true);
		$this->marker['memory']['初始化']  = isset($startmems)?$startmems:memory_get_usage();
	}
	/**
	 * 记录事件&时间
	 * @param unknown $name
	 */
	function mark($name)
	{
		$this->marker['time'][$name] = microtime(true);
		$this->marker['memory'][$name] = memory_get_usage();
		
	}
	/**
	 * 显示Debug
	 * @param unknown $contents
	 */
    public function show($contents){
    	if(t_file_exists(SYSTEM."html/debug.php")){
    		include SYSTEM."html/debug.php";
    	}else{
    		echo $contents;
    	}
    }

}