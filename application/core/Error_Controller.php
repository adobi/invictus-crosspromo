<?php 

if (! defined('BASEPATH')) exit('No direct script access');

require_once(BASEPATH.'core/Controller'.EXT);

class Error_Controller extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        
        $this->template->set_layout('invictus');
    }
}
