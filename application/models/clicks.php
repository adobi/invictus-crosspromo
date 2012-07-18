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
    
    public function fetchClicksChartData()
    {
      $sql = "select 
              	date(created) as created
              	, count(cp_click.game_id) as click_count
              	, cp_click.game_id
              	, concat(cp_game.`name`, ' ', cp_platform.`name`) as game_name
              from cp_click
              join cp_game_platform on cp_game_platform.id = cp_click.game_id
              join cp_game on cp_game.id = cp_game_platform.game_id
              join cp_platform on cp_platform.id = cp_game_platform.platform_id
              group by cp_click.game_id";
              
      $result = $this->execute($sql);
      
      if (!$result) return false;
      
      $return = array();
      foreach ($result as $item) {
        $return[] = array($item->game_name, intval($item->click_count));
      }
      
      return $return;
    }
} 