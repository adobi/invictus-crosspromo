<?php if ($games): ?>
  <?php foreach ($games as $item): ?>
    <li class="span2" style="min-height:100%">
      <div class="item thumbnail" data-id = "<?php echo $item->id ?>">
        <h6 class="center" rel="tooltip" title="<?php echo $item->name ?>">
          <?php echo strlen($item->name) > 12 ? substr($item->name, 0, 13) . '...' : $item->name ?>
        </h6>
        <a href="#" class="crosspromo-selected-game" data-id="<?php echo $item->id ?>">
          <img src="<?php echo base_url() ?>uploads/original/<?php echo $item->logo ?>" style="width:96px" alt="">
        </a> 
        <div class="caption center" style="padding:5px 0">
          <a href="#" class="crosspromo-selected-game" data-id="<?php echo $item->id ?>">
            <span class="badge badge-info"><?php echo $item->count ?></span>
          </a>
        </div>                 
      </div>
    </li>
  <?php endforeach ?>
<?php endif ?>