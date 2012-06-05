<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" style="overflow: hidden_">
    <head>
      <title><?php echo SITE_TITLE ?></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
      
      <meta name="description" content="">
      <meta name="author" content="">
      
      <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->        

      <?php if (ENVIRONMENT==="development"): ?>
        <link rel="stylesheet/less" type="text/css" href="<?= base_url() ?>css/promo/all.less">
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/plugins/lessjs/less-1.3.0.min.js"></script>
        <script type="text/javascript">
          less.env = "development";
          //less.watch();        
        </script>
      <?php else: ?>
        <link rel = "stylesheet" type="text/css" href="<?= base_url() ?>css/promo/all.css">
      <?php endif ?>       
       
    </head>
    
    <body>    
        <div class="container <?php echo $this->uri->segment(2) === 'game' ? 'well' : '' ?>" id="container">
