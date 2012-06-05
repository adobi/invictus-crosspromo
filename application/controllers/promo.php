<?php 

if (! defined('BASEPATH')) exit('No direct script access');

require_once(APPPATH.'core/Promo_Controller'.EXT);

class Promo extends Promo_Controller 
{
  
  public function index()
  {
    $data = array();
  
    $this->load->model('Gameplatforms', 'model');
    
    $data['games'] = $this->model->fetchAllWithGameAndPlatform();    
    
    $this->template->build('promo/index', $data);
  }
  
  public function game() 
  {
    $data = array();
    $this->load->model('Crosspromos', 'model');
    
    $id = $this->uri->segment(3);
    
    $this->load->model('Games', 'games');
    $this->load->model('Gameplatforms', 'gp');
    $this->load->model('Platforms', 'platforms');
    $gp = $this->gp->find($id);
    
    if ($gp) {
    
      $this->load->model('Crosspromolists', 'types');
      
      $types = $this->types->fetchAll(array('order'=>array('by'=>'order', 'dest'=>'asc')));
      
      //$return = array();
      //foreach ($types as $value) {
      //  $return[] = array('list'=>$value, 'games'=>$this->model->fetchByGame($this->uri->segment(3), $value->id));
      //}
      
      //$data['result'] = $return;
      
      $data['lists'] = $types;
      
      if ($types && $types[0])
        $data['items'] = $this->model->fetchByGame($id, $types[0]->id);
    }
    
    $this->template->build('promo/game', $data);
  }
}