<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('display_errors')) {
		
		function display_errors($message) {
	    $html = '';
			if ($message) {
    			    
    			//$html .= '<div class = \'alert alert-error \'>';
    				$html .= str_replace("\n", "", $message);
    			//$html .= '</div>';
			
			}
			return $html;
		}
	}

?>