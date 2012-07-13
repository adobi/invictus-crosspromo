<br>
<h1>
  Select a game
  <div class="btn-group pull-right">
    <a href="<?php echo base_url() ?>promo" class="btn dropdown-toggle" data-toggle="dropdown">
      <i class="icon-align-justify"></i>
    </a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url() ?>promo/console" style="font-size:13px">API</a></li>
      <li><a href="<?php echo base_url() ?>auth/login" style="font-size:13px">Login</a></li>
    </ul>
  </div>
  
</h1>
<br>
<ul class="thumbnails well">
  <?php if ($games): ?>
    
    <?php foreach ($games as $item): ?>
      <?php if (in_array($item->platform_id, array(2,5,7,8))): ?>
        <li class="span2">
          <div class="thumbnail text-center">
            <h6 style="height:42px;"><?php echo $item->game_name ?> <?php echo $item->platform_name ?></h6>
            <?php  
              
              $device = md5('a');
              $url = base_url()."promo/show/game/$item->id/device/$device/platform/";
              
              if (in_array($item->platform_id, array(2, 5))) {
                $url .= 'ios';
              }
              if (in_array($item->platform_id, array(7, 8))) {
                $url .= 'android';
              }
              
              $url .= "/type/";
              
              if (in_array($item->platform_id, array(2, 7))) {
                $url .= 'phone';
              }
              if (in_array($item->platform_id, array(8, 5))) {
                $url .= 'tablet';
              }
              $url .= "/os/2/version/2.1";
            ?>
            <a class="open-window" style="width:64px;display:inline-block" href="<?php echo $url ?>">
              <img style="max-height:128px" src="<?php echo $item->logo ? base_url() . 'uploads/original/'.$item->logo : 'http://placehold.it/64x64' ?>" alt="">
            </a>
          </div>
        </li>
      <?php endif ?>
    <?php endforeach ?>
  <?php endif ?>
</ul>