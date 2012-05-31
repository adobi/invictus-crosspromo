<?php 

if (! defined('BASEPATH')) exit('No direct script access');

require_once(APPPATH.'core/Promo_Controller'.EXT);

class Promo extends Promo_Controller 
{
  public function game() 
  {
    $data = array();
    $this->load->model('Crosspromos', 'model');
    
    
    
    $this->template->build('promo/game', $data);
  }
}