<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Platforms extends MY_Model 
{
    protected $_name = "cp_platform";
    protected $_primary = "id";
    
    public function fetchAvailableForGame($gameId) 
    {
      if (!$gameId) return false;
      
      return $this->execute("select p.* from $this->_name p where p.id not in (select platform_id from c_game_platform where game_id = $gameId)");
    }
    
}