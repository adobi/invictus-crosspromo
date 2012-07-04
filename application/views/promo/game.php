<?php if ($lists): ?>
  <div class="navbar-fixed-top">
    <div class="container">
      <ul class="nav nav-tabs crosspromo-tabs tk-ff-cocon-web-pro">
          <?php foreach ($lists as $i=>$item): ?>
            <li <?php echo (!$list_id && $i === 0) || $list_id === $item->id ? 'class="active"' : '' ?>>
              <a href="<?php echo base_url() ?>promo/show/list/<?php echo $item->id ?>/<?php echo $this->uri->assoc_to_uri($params); ?>">
                <?php if ($item->image): ?>
                  <img src="<?php echo base_url() ?>uploads/original/<?php echo $item->image ?>" alt="">
                <?php endif ?>
                <span><?php echo $item->name ?></span>
              </a>
            </li>
          <?php endforeach ?>
      </ul>
    </div>
  </div>
<?php endif ?>

<div class="hide csrf-form">
  <?php echo form_open() ?>
  <?php echo form_close() ?>
</div>
    
<div class="items" data-game-id="<?php echo isset($game_platform) ? $game_platform->id : '' ?>" data-user-id="<?php echo $params ? $params['device'] : '' ?>">
  <p class="text-center hidden" id="_ajax-loader-img">
    <img src="<?php echo base_url() ?>img/ajax-loader.gif" alt="">
  </p>
  <?php if ($items && $lists): ?>
    <?php foreach ($items as $item): ?>
      <?php if (is_object($item)): ?>
        <div class="item" style="<?php echo isset($item->removed) ? 'opacity:.6' : '' ?>" data-game-id="<?php echo $item->promo_game_id ?>" data-type="<?php echo get_item_type($item) ?>">
          <a href="<?php echo $item->long_url ?>" target="_blank" <?php echo event_tracking($item) ?>>
          <table>
            <tr>
              <td class="promo-item-image">
                <img data-src="<?php echo base_url() ?>/uploads/original/<?php echo $item->logo ?>" alt="" style="width:128px">
                <h3 class="_tk-ff-cocon-web-pro"  class="price">
                  <?php echo $is_free ? 'FREE' : (isset($item->promo_price) && $item->promo_price ? $item->promo_price . ($item->currency ? $item->currency : '$') : ($item->price ? $item->price . ($item->currency ? $item->currency : '$') : '')) ?>
                </h3>
              </td>
              <td class="promo-item-content">
                <h2>
                  <?php echo $item->name ?>
                </h2>
                <?php if (isset($item->title) && $item->title): ?>
                  <h3><span class="raquo">&raquo;</span> <?php echo $item->title ?></h3>
                <?php endif ?>
                <p>
                  <?php if (isset($item->description)): ?>
                    <?php echo substr($item->description, 0, 80) ?>
                  <?php else: ?>
                    <?php if (isset($item->short_description)): ?>
                      <?php echo substr($item->short_description, 0, 80) ?>
                    <?php endif ?>
                  <?php endif ?>
                  
                </p>
                <?php if (isset($item->until) && to_date($item->until) !== '1970-01-01'): ?>
                  <p style="font-weight:bold"><?php echo round((strtotime($item->until) - time()) / (60*60*24)) ?> more days</p>
                <?php endif ?>
                <?php if (ENVIRONMENT === '_development'): ?>
                  <div class="well">
                      os type: <?php echo $item->platform_name ?>
                      min os version: <?php echo $item->min_os_version ?>
                      game version: <?php echo $item->version ?>
                      random inserted: <?php echo @$item->inserted ?>
                      is new game: <?php echo $item->is_new ?>
                  </div>
                <?php endif ?>
              </td>
              <td class="promo-item-download">
                <!-- 
                <div class="download-new text-right">
                  <?php $flag = false; ?>
                  <?php if (isset($item->is_updated)): $flag = true; ?>
                    <img src="<?php echo base_url() ?>img/icon-update.png" alt="">
                    <h3 class="tk-ff-cocon-web-pro _red silver">
                      UPDATE NOW
                    </h3>
                  <?php endif ?>
                  <?php if ($item->is_new): $flag = true; ?>
                      <img src="<?php echo base_url() ?>img/icon-new.png" alt="" class="new-icon">
                      <h3 class="tk-ff-cocon-web-pro _red silver">
                        DOWNLOAD NOW
                      </h3>
                  <?php endif ?>
                  <?php if (!$flag): ?>
                      <?php if (isset($item->type_id)): ?>
                        <img src="<?php echo base_url() ?>uploads/original/<?php echo $item->type_image ?>" alt="" class="<?php echo strtolower($item->type_name) ?>-icon">
                      <?php else: ?>
                        <img src="<?php echo base_url() ?>img/download-icon-arrow-original.png" alt="">
                      <?php endif ?>
                      <h3 class="tk-ff-cocon-web-pro _red silver">
                        <?php if (isset($item->type_text) && $item->type_text): ?>
                          <?php echo strtoupper($item->type_text) ?>
                        <?php else: ?>
                          DOWNLOAD NOW
                        <?php endif ?>
                      </h3>
                  <?php endif ?>
                </div>
                 -->
                 <div class="download-new text-right">
                   <?php if (isset($item->type_id)): ?>
                    <img src="<?php echo base_url() ?>uploads/original/<?php echo $item->type_image ?>" alt="" >                      
                  <?php else: ?>
                    <img src="<?php echo base_url() ?>uploads/original/cricon_downloadnow.png" alt="" >   
                   <?php endif ?>
                </div>
              </td>
            </tr>
          </table>
          </a>
        </div>        
      <?php endif ?>
    <?php endforeach ?>
  <?php else: ?>
    <div class="alert alert-error">
      No items
    </div>  
  <?php endif ?>
</div>
