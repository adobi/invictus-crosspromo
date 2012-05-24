<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('strip_ext')) {
	
		function strip_ext($file) {
		  if (!$file) return false;
		  
		  $reverse = explode('.', strrev($file));
		  
		  if (!isset($reverse[1])) return false;
		  
		  return strrev($reverse[1]);
		}	
	}

?>