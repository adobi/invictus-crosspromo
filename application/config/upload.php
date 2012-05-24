<?php  

    $config['upload_path'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/original/';
    $config['upload_path_base'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/';
    $config['upload_path_thumbs'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/thumbs/';
    //echo $config['upload_path'];
    $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx';
    $config['max_size'] = '10240';
//    $config['max_width'] = '1024';
//    $config['max_height'] = '768';
//    $config['image_width'] = 340;
//    $config['image_height'] = 260;
//    $config['thumb_width'] = 280;
//    $config['thumb_height'] = 210;

?>