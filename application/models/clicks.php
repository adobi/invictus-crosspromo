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
}