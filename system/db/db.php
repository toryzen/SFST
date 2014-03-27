<?php  if ( ! defined('SYSTEM')) exit('Go away!');
/**
 * DB类接口
 * @author toryzen 
 * 
 */
interface DB_interface {

    public function query($sql);
    
    public function fetch_one($sql);
    
    public function fetch_all($sql);
    
}