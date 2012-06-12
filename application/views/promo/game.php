  <div class="navbar-fixed-top">
    <div class="container">
      <ul class="nav nav-tabs crosspromo-tabs tk-ff-cocon-web-pro">
        <li class="pull-right no-tab text-center">
          <!-- <i class="close-icon"></i> -->
          <a href="#" id="close"><img src="<?php echo base_url() ?>img/icon-close.png" alt=""></a>
        </li>
        <?php if ($lists): ?>
          <?php foreach ($lists as $i=>$item): ?>
            <li <?php echo (!$list_id && $i === 0) || $list_id === $item->id ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url() ?>promo/game/<?php echo $game_id ?>/<?php echo $item->id ?>">
                <img src="<?php echo base_url() ?>uploads/original/<?php echo $item->image ?>" alt="">
                <span><?php echo $item->name ?></span>
              </a>
            </li>
          <?php endforeach ?>
        <?php endif ?>
      </ul>
    </div>
  </div>
  
  <?php if ($items && $lists): ?>
    <div class="items">
      <?php foreach ($items as $item): ?>
        
        <div class="item">
          <a href="<?php echo $item->long_url ?>" target="_blank" <?php echo event_tracking($item) ?>>
          <table>
            <tr>
              <td class="promo-item-image">
                <img src="<?php echo base_url() ?>/uploads/original/<?php echo $item->logo ?>" alt="" style="width:128px">
                <h3 class="tk-ff-cocon-web-pro">
                  <?php echo $item->promo_price ? $item->promo_price . ' $' : 'FREE' ?>
                </h3>
              </td>
              <td class="promo-item-content">
                <h2>
                  <!-- <span class="badge badge-important tk-ff-cocon-web-pro">NEW</span> -->
                  <?php echo $item->name ?>
                </h2>
                <?php if ($item->title): ?>
                  <h3><span class="raquo">&raquo;</span> <?php echo $item->title ?></h3>
                <?php endif ?>
                <p><?php echo $item->description ?></p>
                <?php if ($item->until): ?>
                  <p style="font-weight:bold">Until <?php echo round((strtotime($item->until) - time()) / (60*60*24)) ?> more days</p>
                <?php endif ?>
              </td>
              <td class="promo-item-download">
                <span href="#"  class="download-new text-right">
                  <?php if ($item->type_id): ?>
                    <img src="<?php echo base_url() ?>uploads/original/<?php echo $item->type_image ?>" alt="" class="<?php echo strtolower($item->type_name) ?>-icon">
                  <?php else: ?>
                    <img src="<?php echo base_url() ?>img/download-icon-arrow-original.png" alt="">
                  <?php endif ?>
                  <h3 class="tk-ff-cocon-web-pro _red silver">
                    <?php if ($item->type_text): ?>
                      <?php echo strtoupper($item->type_text) ?>
                    <?php else: ?>
                      DOWNLOAD NOW
                    <?php endif ?>
                  </h3>
                </span>
              </td>
            </tr>
          </table>
          </a>
        </div>        
      <?php endforeach ?>
    </div>
  <?php else: ?>
    <div class="alert alert-error">
      No items
    </div>  
  <?php endif ?>
  