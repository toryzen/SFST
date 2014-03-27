<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * 控制器类
 * @author toryzen 
 *
 */
class C{

    public $conn;
    public $Models;

    private static $instance;
    
    public function __construct(){
    	self::$instance =& $this;
    	foreach(save_load() as $class){
    		$this->$class = &load($class);
    	}
    	if(method_exists($this, '_init')){
    		$this->_init();
    	}
    }
    /**
     * 引入类
     * @param string $class
     * @param string $file
     */
    public function load($class,$file){
    	$this->$class = &load($class,"libraries/".$file);
    }
    /**
     * 模型实例化
     * @param string $filename
     */
    public function model($filename="M"){
    	//如果已经实例化过则直接返回
        if(isset($this->Models[$filename])){return $this->Models[$filename];  }
        $file_path = APP."/models/".$filename.".php";
        if(t_file_exists($file_path)||$filename=='M'){
            $class_name = $filename;
            $this->conn = &db_driver();
            include($file_path);
            if(class_exists($class_name)||$filename=='M'){
                $this->Models[$filename] = new $class_name($this->conn);
                return $this->Models[$filename];
            }else{
            	$this->conn->close();
            	show_error("模型类没有找到！类：".$class_name."文件:".$file_path);
            }
        }else{
        	show_error("模型文件没有找到！文件:".$file_path);
        }
    }
    
    /**
     * 获取超级对象
     * @return C
     */
    public static function & get_inst(){
    	return self::$instance;
    }
}