<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Orders extends MY_Model 
{
    protected $_name = "cp_order";
    protected $_primary = "id";
    
    public function getTransactions($user) 
    {
      if (!$user) return false;
      
      return $this->fetchBy('user_id', $user);
    }
    
    public function getLoyalty($user) 
    {
      $result = $this->getTransactions($user);
      
      $count = count($result);
      
      if ($count === 1) return "1";
      
      if ($count >= 2 && $count <= 4) return "2-4";
      
      if ($count >= 5) return "5+";
    }
}