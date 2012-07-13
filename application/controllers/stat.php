<?php 

if (! defined('BASEPATH')) exit('No direct script access');

//require_once 'MY_Controller.php';

class Stat extends MY_Controller 
{
    public function index() 
    {
        $data = array();

        $this->load->model('Crosspromotypes', 'types');
        
        $data['types'] = $this->types->fetchAll();
      
        $this->load->model('Users', 'users');
        
        $data['users'] = $this->users->fetchAllWithGames();
        
        $data['devices_chart_data'] = json_encode($this->users->fetchDevicesChartData());
        
        $this->load->model('Clicks', 'click');
        
        $data['clicks'] = $this->click->fetchAll();
        
        $data['clicks_chart_data'] = json_encode($this->click->fetchClicksChartData());
        
        $this->template->build('stat/index', $data);
    }
}