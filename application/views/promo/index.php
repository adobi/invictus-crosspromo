<ul class="thumbnails well">
  <?php if ($games): ?>
    <?php foreach ($games as $item): ?>
      <li class="span2">
        <div class="thumbnail text-center">
          <h6 style="height:42px;"><?php echo $item->game_name ?> <?php echo $item->platform_name ?></h6>
          <a class="open-window" style="width:64px;display:inline-block" href="<?php echo base_url() ?>promo/show/game/<?php echo $item->id ?>/device/<?php echo md5('a') ?>/platform/ios/type/phone/os/4.2/version/2.1"><img style="max-height:128px" src="<?php echo base_url() ?>uploads/original/<?php echo $item->logo ?>" alt=""></a>
        </div>
      </li>
    <?php endforeach ?>
  <?php endif ?>
</ul>