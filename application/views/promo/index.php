<ul class="thumbnails well">
  <?php if ($games): ?>
    <?php foreach ($games as $item): ?>
      <li class="span2">
        <div class="thumbnail text-center">
          <h6 style="height:42px;"><?php echo $item->game_name ?> <?php echo $item->platform_name ?></h6>
          <a class="open-window" style="width:64px;display:inline-block" href="<?php echo base_url() ?>promo/game/<?php echo $item->id ?>"><img style="max-height:128px" src="<?php echo base_url() ?>uploads/original/<?php echo $item->logo ?>" alt=""></a>
        </div>
      </li>
    <?php endforeach ?>
  <?php endif ?>
</ul>