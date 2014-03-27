<?php  if ( ! defined('SYSTEM')) exit('Go away!');

class Index_controller extends C{
	
	public function _init(){
		$this->indexModel = $this->model("Index_model");
		//处理DWZ
		$dwz=$_POST['dwz']?$_POST['dwz']:$_GET['dwz'];
		if($dwz){
			$this->fid = $this->indexModel->get_id_by_dwz($dwz);
		}
	}
	
	/**
     * 新建面板
     */
    public function index(){
    	if(!empty($_POST)){
    		$dwz = $this->indexModel->insert_data($_POST['borad'],$_POST['task']);
    		redirct("http://localhost/TZN_Framework/taskmanage/index.php/Index/pannel?dwz=".$dwz);
    	}
        $this->V->view("index");
    }
    
    /**
     * 修改面板
     */
    public function edit(){
    	if(!empty($_POST)){
    		$this->indexModel->update_data($this->fid,$_POST['borad'],$_POST['task']);
    		redirct("http://localhost/TZN_Framework/taskmanage/index.php/Index/pannel?dwz=".$_POST['dwz']);
    	}
    	if($_GET['dwz']){
    		//$fid = $this->indexModel->get_id_by_dwz($_GET['dwz']);
    		$data = $this->indexModel->get_info($this->fid);
    		$this->V->view("edit",$data);
    	}
    }
    
    /**
     * 展示面板
     */
    public function pannel(){
    	//基本信息+任务
    	$data = $this->indexModel->get_info($this->fid);
    	//轨迹数据
    	/*
    	$data["burn"]['left'] = $this->indexModel->picdate($this->fid);
    	$first = @current($data["burn"]['left']);
    	if($data["burn"]['left']){
	    	foreach($data["burn"]['left'] as $key=>$locus){
	    		$left = $first-($i*($first/count($data["burn"]['left'])));
	    		$data["burn"]['locus'][$key] = $left;
	    		$i ++ ;
	    	}
    	}
    	*/
    	$this->V->view("pannel",$data);
    }
    
    /**
     * 更新任务剩余工作量Ajax
     */
    public function update_task(){
    	$retid = explode("|",$_POST['tid']);
    	$dwz = $_POST['dwz'];
    	$val = $_POST['val'];
    	if(count($retid)==2){
    		$re = $this->indexModel->update_task($retid[0],$retid[1],$dwz,$val);
    		echo $re;
    	}else{
    		echo "信息错误！";
    	}
    }
    
    /**
     * 燃尽图数据Ajax
     */
    public function burnpic(){
    	$data = $this->indexModel->picdate($this->fid);
    	$first = current($data);
    	foreach($data as $vo){
    		if($vo){
    			$left.=$vo.",";
    		}
    	}
    	$left = substr($left,0,-1);
    	for($i = 0;$i<count($data);$i++){
    		$locus.=round($first-($i*($first/count($data))),2).",";
    	}
    	$locus = substr($locus,0,-1);
    	echo $left."|".$locus;
    }
   
}