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
      <li class="span2">
        <div class="thumbnail text-center">
          <h6 style="height:42px;"><?php echo $item->game_name ?> <?php echo $item->platform_name ?></h6>
          <a class="open-window" style="width:64px;display:inline-block" href="<?php echo base_url() ?>promo/show/game/<?php echo $item->id ?>/device/<?php echo md5('a') ?>/platform/ios/type/phone/os/4.2/version/2.1">
            <img style="max-height:128px" src="<?php echo $item->logo ? base_url() . 'uploads/original/'.$item->logo : 'http://placehold.it/64x64' ?>" alt="">
          </a>
        </div>
      </li>
    <?php endforeach ?>
  <?php endif ?>
</ul>