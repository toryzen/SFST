<?php  if ( ! defined('SYSTEM')) exit('Go away!');
class Index_model extends M{
	/**
	 * 根据dwz获取FID
	 * @param string $dwz
	 * @return int fid
	 */
	public function get_id_by_dwz($dwz){
		$sql = "SELECT * FROM `board` WHERE dwz = '$dwz'";
		$reuslt = $this->fetch_one($sql);
		return $reuslt['id'];
	}
	
	/**
	 * 插入面板与任务数据
	 * @param array $borad
	 * @param array $task
	 * @return string dwz
	 */
	public function insert_data($borad,$task){
		//插入borad
		$dwz = dwz(md5(uniqid()));
		$sql = "INSERT INTO `board` (bname,begintime,endtime,exceptdays,dwz) 
				VALUES('".$borad['bname']."','".$borad['begintime']."','".$borad['endtime']."','".json_encode($borad['exceptdays'])."','".$dwz."')";
		$fid = $this->query($sql);
		//插入task
		$sql = "INSERT INTO `task` (fid,story,owner,expendt,workload) VALUES ";
		for($tmp_time = date("Y-m-d",strtotime($borad['begintime']));$tmp_time<=$borad['endtime'];$tmp_time = date("Y-m-d",strtotime("+1 day",strtotime($tmp_time))) ){
			if(!in_array($tmp_time,$borad['exceptdays'])){
				$workload[date("m-d",strtotime($tmp_time))] = "";
			}
		}
		$workload = json_encode($workload);
		for($i=1;$i<count($task['story']);$i++){
			$sql.="('".$fid."','".$task['story'][$i]."','".$task['owner'][$i]."','".$task['expendt'][$i]."','".$workload."'),";
		}
		$sql = substr($sql, 0,-1);
		$this->query($sql);
		return $dwz;
	}
	/**
	 * 更新面板与任务数据
	 * @param int $fid
	 * @param string $borad
	 * @param string $task
	 */
	public function update_data($fid,$borad,$task){
		//更新Borad
		$sql = "UPDATE `board` SET bname = '".$borad['bname']."',begintime='".$borad['begintime']."',endtime='".$borad['endtime']."',exceptdays='".json_encode($borad['exceptdays'])."' WHERE id = $fid";
		$this->query($sql);
		//更新Task
		$sql = "UPDATE `task` SET is_del = '1' WHERE fid = $fid";
		$this->query($sql);
		for($tmp_time = date("Y-m-d",strtotime($borad['begintime']));$tmp_time<=$borad['endtime'];$tmp_time = date("Y-m-d",strtotime("+1 day",strtotime($tmp_time))) ){
			if(@!in_array($tmp_time,$borad['exceptdays'])){
				$workload[date("m-d",strtotime($tmp_time))] = "";
			}
		}
		for($i=1;$i<count($task['story']);$i++){
			if($task['id'][$i]){
				$wk = array();$sourcewl=array();
				$sourcewl = json_decode($task['workload'][$i],TRUE);
				foreach($workload as $key=>$twk){
					$wk[$key] = $sourcewl[$key]!=""?$sourcewl[$key]:"";
				}
				$wk = json_encode($wk);
				$sql = "UPDATE `task` SET is_del = 0, story = '".$task['story'][$i]."',owner='".$task['owner'][$i]."',expendt='".$task['expendt'][$i]."',workload='$wk' WHERE id = '".$task['id'][$i]."'";
			}else{
				$sql = "INSERT INTO `task` (fid,story,owner,expendt,workload) VALUES ('".$fid."','".$task['story'][$i]."','".$task['owner'][$i]."','".$task['expendt'][$i]."','".$workload."')";
			}
			$this->query($sql);
		}
		
	}
	
	/**
	 * 获取面板与任务数据
	 * @param int $fid
	 * @return Ambigous <string, unknown, void, unknown>
	 */
	public function get_info($fid){
		$sql = "SELECT * FROM `board` WHERE id = $fid";
		$reuslt['borad'] = $this->fetch_one($sql);
		$reuslt['borad']['exceptdays'] = json_decode($reuslt['borad']['exceptdays'],TRUE);
		$sql = "SELECT * FROM `task` WHERE fid = '$fid' AND is_del = 0";
		$reuslt['task'] = $this->fetch_all($sql);
		if($reuslt['task']){
			foreach($reuslt['task'] as &$vo){
				$vo['workload'] = json_decode($vo['workload'],true);
			}
		}
		for($tmp_time = date("Y-m-d",strtotime($reuslt['borad']['begintime']));$tmp_time<=$reuslt['borad']['endtime'];$tmp_time = date("Y-m-d",strtotime("+1 day",strtotime($tmp_time))) ){
			if(@!in_array($tmp_time,$reuslt['borad']['exceptdays'])){
				$reuslt['time'][] = date("m-d",strtotime($tmp_time));
			}
			
		}
		return $reuslt;
	}
	
	/**
	 * 更新任务剩余工作量
	 * @param unknown $tid
	 * @param unknown $tdate
	 * @param unknown $dwz
	 * @param unknown $val
	 * @return boolean|string
	 */
	public function update_task($tid,$tdate,$dwz,$val){
		$sql = "SELECT id,workload,fid FROM `task` WHERE id = '{$tid}'";
		$tdata = $this->fetch_one($sql);
		if($this->get_id_by_dwz($dwz)==$tdata['fid']){
			if($tdata['id']>0){
				$workload = json_decode($tdata['workload'],true);
				$workload[$tdate] = $val;
				$workload = json_encode($workload);
				$sql = "UPDATE `task` SET workload = '{$workload}' WHERE id = '{$tid}'";
				$this->query($sql);
				return TRUE;
			}else{
				return "故事不存在！";
			}
		}else{
			return "故事不存在！";
		}
	}
	
	/**
	 * 获取燃尽数据
	 * @param unknown $fid
	 * @return number
	 */
	public function picdate($fid){
		$sql = "SELECT workload FROM `task` WHERE fid = '{$fid}' AND is_del = 0";
		$tdata = $this->fetch_all($sql);
		if($tdata){
			foreach($tdata as $vo){
				$workload = json_decode($vo['workload'],true);
				if($workload){
					foreach($workload as $key=>$tvo){
						$return[$key] = $return[$key]+$tvo;
					}
				}
				
			}
		}
		return $return;
	}

}