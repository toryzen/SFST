<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * 视图类
 * @author Huangzhen 
 *
 */
class V{

    public $contents;
    
    public $mode = "HTML";
    
    /*
     * 视图显示
     * @param string $filename
     * @param array $data_array
    */
    public function view($filename,$data_array=array()){
    	$file_path = APP."/views/".$filename.".php";
    	if(t_file_exists($file_path)){
    		ob_start();
    		if(is_array($data_array)){
    			foreach($data_array as $key=>$value){
    				$$key = $value;
    			}
    		}
    		include($file_path);
    		$this->contents .= ob_get_contents();
    		@ob_end_clean();
    	}else{
    		show_error("视图文件没有找到！文件:".$file_path);
    	}
    }
    /**
     * 模板中载入
     * @param unknown $filename
     * @param unknown $data_array
     */
    public function load($filename,$data_array=array()){
    	$file_path = APP."/views/".$filename.".php";
    	if(t_file_exists($file_path)){
    		//ob_start();
    		if(is_array($data_array)){
    			foreach($data_array as $key=>$value){
    				$$key = $value;
    			}
    		}
    		include($file_path);
    		//$this->contents .= ob_get_contents();
    		//@ob_end_clean();
    	}else{
    		show_error("视图文件没有找到！文件:".$file_path);
    	}
    }
    
    /*
     * 输出
    */
    public function output($mode="HTML",$type=TRUE){
    	if($mode=="TXT" OR $this->mode=="TXT")
    	{
    		$contents = "<PRE>".htmlspecialchars($this->contents)."</PRE>";
    	}else{
    		$contents = $this->contents;
    	}
    	if($type==TRUE){
    		echo $contents;
    	}else{
    		return $contents;
    	}
    	
    }
    
    
    
}