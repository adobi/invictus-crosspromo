<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Usergames extends MY_Model 
{
    protected $_name = "cp_user_game";
    protected $_primary = "id";
    
    public function hasGame($userId, $gameId) 
    {
      if (!$userId || !$gameId) return false;
      
      $result = $this->fetchRows(array('where'=>array('user_id'=>$userId, 'game_id'=>$gameId)));
            
      return $result ? $result[0] : false; 
    }
    
    public function findGameByDevice($gameId, $deviceId) 
    {
      if (!$deviceId || !$gameId) return false;
      
      $result = $this->fetchRows(array('where'=>array('user_id'=>$deviceId, 'game_id'=>$gameId)));
      //dump($deviceId); die;      
      return $result ? $result[0] : false; 
    }
}