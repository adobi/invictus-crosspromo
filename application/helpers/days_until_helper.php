<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('days_until')) {
	
		function days_until($until) {
      
		  $result = round((strtotime($until) - time()) / (60*60*24));
		  
		  return $result > 0 ? $result : 0;  
		}	
	}

?>