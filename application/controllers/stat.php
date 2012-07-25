<?php 

if (! defined('BASEPATH')) exit('No direct script access');

//require_once 'MY_Controller.php';

class Stat extends MY_Controller 
{
    public function index() 
    {
      $this->benchmark->mark('code_start');

      $data = $this->_collectData(false);
      
      $this->benchmark->mark('code_end');
      
      $data['benchmark_time'] = $this->benchmark->elapsed_time('code_start', 'code_end');  

      $this->load->model('Crosspromotypes', 'types');
      
      $data['types'] = $this->types->fetchAll();
    
      $this->template->build('stat/index', $data);
    }
    
    public function refresh()
    {
      echo $this->_collectData();
      die;
    }
    
    private function _collectData($isJson = true) 
    {
        $data = array();

        $this->load->model('Users', 'users');
        
        $data['users'] = $this->users->fetchCount();
        
        $devices_chart_data = $this->users->fetchDevicesChartData();
        $data['devices_chart_data'] = !$isJson ? json_encode($devices_chart_data) : $devices_chart_data;

        $devices_source_chart_data = $this->users->fetchDevicesSourceChartData();
        $data['devices_source_chart_data'] = !$isJson ? json_encode($devices_source_chart_data) : $devices_source_chart_data;
        
        
        $this->load->model('Clicks', 'click');
        
        $data['clicks'] = $this->click->fetchCount();
        
        $clicks_chart_data = $this->click->fetchClicksChartData();
        $data['clicks_chart_data'] = !$isJson ? json_encode($clicks_chart_data) : $clicks_chart_data;

        $clicks_per_day_chart_data = $this->click->fetchClicksPerDayChartData();
        $data['clicks_per_day_chart_data'] = !$isJson ? json_encode($clicks_per_day_chart_data) : $clicks_per_day_chart_data;
        
        $this->load->model('Orders', 'order');
        
        $data['orders'] = $this->order->fetchCount();
        
        $orders_chart_data = $this->order->fetchOrdersChartData();
        $data['orders_chart_data'] = !$isJson ? json_encode($orders_chart_data) : $orders_chart_data;
        
        
        
        return $isJson ? json_encode($data) : $data;      
    }
}