<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('create_thumb')) {
	
		function create_thumb($originalImage, $width) {
            
			$ci =& get_instance();
		  if (!file_exists(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'uploads/thumbs/'.$originalImage)) {
		    
        $config['source_image'] = dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'uploads/original/'.$originalImage;
        $config['new_image'] = dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'uploads/thumbs/'.$originalImage;
        $config['width'] = $width;
        $config['height'] = 85;
        //$config['dynamic_output'] = true;
        //$config['maintain_ratio'] = TRUE;
        
        $ci->load->library('image_lib');
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();	
        //$ci->image_lib->display_errors();
		  }
      return base_url().'uploads/thumbs/'.$originalImage;
		}	
	}

?>