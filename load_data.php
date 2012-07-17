<?php
  
  //if (isset($_GET['hash']) && isset($_GET['key'])) {
  
    //$cmd = 'curl crosspromo.invictus.com/api/load/'.$_GET['hash'].'/'.$_GET['key'].' &';
    $cmd = 'curl http://crosspromo.invictus.com/api/init_from_remote/ >> update_log.txt &';
    //$cmd = `php index.php api init_from_remote > /dev/null &`
    //echo $cmd;
    exec($cmd);    
  //}
  
  //die;
