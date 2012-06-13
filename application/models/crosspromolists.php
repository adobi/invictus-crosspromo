<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Crosspromolists extends MY_Model 
{
    protected $_name = "cp_crosspromo_list";
    protected $_primary = "id";
    
    public function isFree($listId) 
    {
      if (!$listId) return false;
      
      $list = $this->find($listId);
      
      return !$list ? false : strpos(strtolower($list->name), 'free') !== false;
    }
    
    public function fetchForGame($id) 
    {
      if (!$id) return false;
      
      $result = $this->fetchRows(array('where'=>array('game_id'=>$id, 'is_active'=>1),'order'=>array('by'=>'order', 'dest'=>'asc')));
      
      return $result;
    }
}