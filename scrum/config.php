<?php

//数据库配置
$config_db['db_type']  = 'mysql';
$config_db['hostname'] = 'localhost';
$config_db['username'] = 'root';
$config_db['password'] = '';
$config_db['database'] = 'task_manage';
$config_db['char_set'] = 'utf8';

//路由配置
$config_rt['type']     = '2';	  						//URL模式,1:默认($_GET['c']:控制器,$_GET['m']:方法),2:PathInfo,3:混合
$config_rt['class']    = 'Index'; 						//默认控制器类
$config_rt['method']   = 'index'; 						//默认方法
$config_rt['redict']['Index/test']   = 'Index/index';   //重定向

//自动加载
$config_al['functions']     = array('Common');//array('Common','Somethine')