<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * 引导文件
 * @author toryzen 
 * 
 */
define("CORE","TNZPHP");
define("VERSION","0.0.8");
define("ISWIN",(strstr(PHP_OS,"WIN")?1:0));
if(DEBUG){
	define("STIME",microtime());
	define("SMEMS",memory_get_usage());
}
//引入公共方法
require(SYSTEM."common.php");

if(DEBUG){
	$Debug = &load("Debug","debug.php");
}

//检测配置文件
if(t_file_exists(APP."config.php")){
	require(APP."config.php");
}else{
	show_error("没有找到配置文件!\n文件:".APP."config1.php");
}

//引入基础控制器
require(SYSTEM."controller.php");

if(DEBUG){
	$Debug->mark("引入基础控制器完毕");
}

//自动加载
if(!empty($config_al['functions'])){
	foreach($config_al['functions'] as $alf){
		import($alf);
	}
	if(DEBUG){
		$Debug->mark("自动加载完毕");
	}
}

//路由分发
$RT = &load("D","dispatcher.php");

$class  = $RT->class."_controller";
$method = $RT->method;

if(t_file_exists(APP."controllers/".$class.".php")){
    include(APP."controllers/".$class.".php");
    if(DEBUG){
    	$Debug->mark("引入控制器完毕");
    }
    if(class_exists($class)){
        $V = &load("V","view.php");
        //实例化控制器
        $Controller = new $class();
        if(DEBUG){
        	$Debug->mark("实例化控制器完毕");
        }
        //前置方法
        if(method_exists($Controller,"_before_".$method)){
        	call_user_func(array(&$Controller,"_before_".$method));
        }
        if(method_exists($Controller,$method)){
            //调用方法
            call_user_func(array(&$Controller,$method));
            if(DEBUG){
            	$Debug->mark("调用控制器方法完毕");
            }
            $V->output();
            if(DEBUG){
            	$Debug->mark("输出显示完毕");
            }
            if(DEBUG){
            	$Debug->show($V->output("TXT",FALSE));
            }
        }else{
        	show_error("没有找到可用方法! 方法：'".$method."' 文件:".APP."controllers/".$class.".php");
        }
        //后置方法
        if(method_exists($Controller,"_after_".$method)){
        	call_user_func(array(&$Controller,"_after_".$method));
        }
    }else{
    	show_error("没有找到可用类! 类名：'".$class."' 文件:".APP."controllers/".$class.".php");
    }
}else{
	show_error("没有找到控制器! 文件:".APP."controllers/".$class.".php");
}


//关闭数据库连接
if(isset($Controller->conn)){
    $Controller->conn->close();
}

//获取控制器对象
function &get_inst(){
	return C::get_inst();
}

//数据连接驱动
function &db_driver(){
    global $config_db,$db;
    if(isset($db)){return $db;}
    require_once(SYSTEM.'db/db.php');
    switch ($config_db['db_type']){
    	case "mysql":
    		require_once(SYSTEM.'db/mysqli.php');
    		$db = new mysqli($config_db['hostname'],$config_db['username'],$config_db['password'],$config_db['database']);
    		$db->set_charset($config_db['char_set']);
    		if(!$db){
    			show_error("数据库连接错误! 信息:".$db->error);
    		}
    		break;
    	default:
    		show_error("不支持该类型的数据库! 类型:".$config_db['db_type']);
    }
    require_once(SYSTEM."model.php");
    return $db;
}

    