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
    
    public function fetchAllWithGames()
    {
      $users = $this->fetchAll();
      
      if (!$users) return false;
      
      $this->load->model('Usergames', 'usergames');
      foreach ($users as $item) {
        $item->games = $this->usergames->fetchByWithGameInfo('user_id', $item->id);
      }
      
      return $users;
    }
    
    public function fetchDevicesChartData()
    {
      $sql = "select 
              	date(created) as created
              	, count(distinct device_id) as device_count
              from cp_user
              group by date(created)";
      $result = $this->execute($sql);
      
      if (!$result) return false;
      
      $return = array();
      foreach ($result as $item) {
        $return[] = array($item->created, intval($item->device_count));
      }
      
      return $return;
    }
}