<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('create_mobile_image')) {
	
		function create_mobile_image($originalImage, $type) {
            
			$ci =& get_instance();
		  if (!file_exists(dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'uploads/mobile/'.$originalImage)) {
		    
        $config['source_image'] = dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'uploads/original/'.$originalImage;
        $config['new_image'] = dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.'uploads/mobile/'.$originalImage;
        if ($type === 'hero') {
          
          $config['width'] = 480;
          $config['height'] = 320;
        }
        
        if ($type === 'teaser') {
          
          $config['width'] = 230;
          $config['height'] = 105;
        }
        //$config['dynamic_output'] = true;
        //$config['maintain_ratio'] = TRUE;
        
        $ci->load->library('image_lib');
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();	
        //$ci->image_lib->display_errors();
		  }
      return base_url().'uploads/mobile/'.$originalImage;
		}	
	}

?>