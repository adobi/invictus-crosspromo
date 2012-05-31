<?php 

if (! defined('BASEPATH')) exit('No direct script access');

require_once(BASEPATH.'core/Controller'.EXT);

class Promo_Controller extends CI_Controller 
{
    //php 5 constructor
    public function __construct() 
    {

        parent::__construct();
        
        
        $this->template->set_layout('promo');
    }
}