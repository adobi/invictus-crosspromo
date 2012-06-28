<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Clicks extends MY_Model 
{
    protected $_name = "cp_click";
    protected $_primary = "id";
    
    public function isGameClickedBy($game, $user) 
    {
      $result = $this->getGameClicksBy($game, $user);
      
      return !empty($result);
    }
    
    public function getGameClicksBy($game, $user) 
    {
      if (!$game || !$user) return false;
      
      $result = $this->fetchRows(array('where'=>array('game_id'=>$game, 'user_id'=>$user)));
      
      return $result;
    }
    
    public function getNumberOfGameClicksBy($game, $user) 
    {
      return count($this->getGameClicksBy($game, $user));
    }
    
    public function getTypeFromLatestClick($game, $user) 
    {
      if (!$game || !$user) return '';
      
      $result = $this->fetchRows(array('where'=>array('game_id'=>$game, 'user_id'=>$user), 'order'=>array('by'=>'created', 'dest'=>'desc'), 'limit'=>1, 'offset'=>0));
      
      if (empty($result)) return '';
      
      return $result[0]->type ? $result[0]->type : '';
    }
} 