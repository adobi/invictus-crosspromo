<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('youtube_video_image')) {
	
		function youtube_video_image($video, $width=340, $height=260) {
            
			return '<img src = "http://img.youtube.com/vi/'.$video.'/0.jpg" style = "opacity:0.6; width:'.$width.'px; '.($height ? 'height:'.$height.'px;' : '').'"/>';
		}	
	}

?>