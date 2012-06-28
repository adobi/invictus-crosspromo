<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Categories extends MY_Model 
{
    protected $_name = "cp_category";
    protected $_primary = "id";

    public function initFromApi()
    {
      
      $data = $this->invictus->setUri(INVICTUS_API_URI)->setAction('categories')->get(true);
      
      if (!$data) return false;
      
      $d = array();
      foreach ($data as $item) {
        
        $d[] = array(
          'id'=>$item['id'], 
          'name'=>$item['name'], 
        );
      }
      
      $this->truncate();
      
      $this->bulk_insert($d);
    }    
}