<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('get_item_type')) {
	
		function get_item_type($item) 
		{
      if (isset($item->is_updated)) return 'Update';
      
      if (isset($item->is_new)) return 'New';
      
      if (isset($item->type_id) && $item->type_name) return $item->type_name;
      
      return 'No type';
		}	
	}

?>