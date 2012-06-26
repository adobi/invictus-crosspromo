<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" style="overflow: hidden_">
    <head>
      <title>
        <?php if (isset($game) && $game && $game->name): ?>
          <?php echo $game->name .' - ' ?>
          <?php if (isset($current_list) && $current_list): ?>
            <?php echo $current_list->name ?>
          <?php else: ?>
            Thank you page
          <?php endif ?>
        <?php else: ?>
          Invictus Crosspromo
        <?php endif ?>
      </title>
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
        <link rel = "stylesheet" type="text/css" href="<?= base_url() ?>assets/css/all.css">
      <?php endif ?>       
      
       
    </head>
    
    <body>    
        <script type="text/javascript">
        
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-27571060-2']);
            <?php if (isset($params) && isset($params["device"])) : ?>
              _gaq.push(['_setCustomVar', 1, 'UserID', '<?php echo $params["device"] ?>', 1]);
            <?php endif; ?>
            <?php if (isset($game) && isset($game_platform)) : ?>
              _gaq.push(['_setCustomVar', 2, 'SourceGame', '<?php echo $game->name . " - " . $game_platform->version?>', 2]);
            <?php endif; ?>
            <?php if (isset($params['thanks'])) : ?>
              //_gaq.push(['_setCustomVar', 3, 'Loyalty', '', 1]);
            <?php endif; ?>
            _gaq.push(['_setSiteSpeedSampleRate', 100]);
            _gaq.push(['_setDomainName', 'crosspromo.invictus.com']);
            _gaq.push(['_trackPageview']);
            
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
      
        </script>    
        <div class="container <?php echo isset($params['game']) ? 'well' : '' ?>" id="container">
