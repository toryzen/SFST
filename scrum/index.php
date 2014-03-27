<?php
/**
	TZN Framework 入口文件
 */
$app    = "./";	//APP目录
$system = "../system"; //SYSTEM目录
$dubug  = false;	//DEBUG模式

if(is_dir($app)){
    $app = realpath($app)."\\";
}else{
    exit("App path not found !");
}

if(is_dir($system)){
    $system = realpath($system)."\\";
}else{
    exit("System path not found !");
}
$app    = str_replace("\\","/",$app);
$system = str_replace("\\","/",$system);

define("APP",$app);
define("SYSTEM",$system);
define("DEBUG",$dubug);

require SYSTEM."bootstrap.php";

