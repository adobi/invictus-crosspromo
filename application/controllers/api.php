<?php 

if (! defined('BASEPATH')) exit('No direct script access');

require_once(APPPATH.'core/Promo_Controller'.EXT);

class Api extends Promo_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function load() 
  {
    if ($this->_hashCheck()) {
      
      $this->init_from_remote();
      
      echo 'Update successfull';
    } else {
      echo 'Update fail';
    }
    
    die;
  }  
  
  private function _hashCheck()
  {
    $hash = $this->uri->segment(3);
    $key = $this->uri->segment(4);
    //dump(md5(CROSSPROMO_API_SECRET . $key));
    if ($hash === md5(CROSSPROMO_API_SECRET . $key)) {
      return true;
    } 
    
    return false;
  }
  
  public function init_from_remote()
  {
      $this->load->model('Platforms', 'platforms');
      $this->platforms->initFromApi();
      
      $this->load->model('Games', 'games');
      $this->games->initFromApi();          
      
      $this->load->model('Gameplatforms', 'gp');
      $this->gp->initFromApi();        
  
      $this->load->model('Categories', 'category');
      $this->category->initFromApi();   
      
      if ($this->uri->segment(3) === 'redirect') redirect($_SERVER['HTTP_REFERER']);
      else {
        echo "[".date('Y-m-d H:i:s')."] Update success \r\n";
      }
  }
}