<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('panel_close')) {
	
		function panel_close($url = false) {
		    return '<p class=" panel-close">'
		        .'<a rel="tooltip" title="Prev page" data-ajax-link ="1" href="'.base_url().'/game/'.$url.'" class="btn '.($url ? '' : 'invisible').' prev-right-panel"><i class="icon-arrow-left"></i></a>'.
            '<a href="#" data-close-right="1" data-unselect="1" class="pull-right"><i class="icon-remove" style="margin-right:0"></i></a>
        </p>';
		}	
	}

?>