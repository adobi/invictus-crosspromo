<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Users extends MY_Model 
{
    protected $_name = "cp_user";
    protected $_primary = "id";
    
    public function findByDeviceId($deviceId) 
    {
      if (!$deviceId) return false;
      
      $result = $this->fetchRows(array('where'=>array('device_id'=>$deviceId)));
      
      return $result;
    }
}