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
              <a href="<?php echo base_url() ?>promo/show/list/<?php echo $item->id ?>/<?php echo $this->uri->assoc_to_uri($params); ?>">
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
        <?php if (is_object($item)): ?>
          <div class="item" style="<?php echo isset($item->removed) ? 'opacity:.6' : '' ?>">
            <a href="<?php echo $item->long_url ?>" target="_blank" <?php echo event_tracking($item) ?>>
            <table>
              <tr>
                <td class="promo-item-image">
                  <img src="<?php echo base_url() ?>/uploads/original/<?php echo $item->logo ?>" alt="" style="width:128px">
                  <h3 class="tk-ff-cocon-web-pro">
                    <?php echo $is_free ? 'FREE' : (isset($item->promo_price) && $item->promo_price ? $item->promo_price . ($item->currency ? $item->currency : '$') : ($item->price ? $item->price . ($item->currency ? $item->currency : '$') : '')) ?>
                  </h3>
                </td>
                <td class="promo-item-content">
                  <h2>
                    <!-- <span class="badge badge-important tk-ff-cocon-web-pro">NEW</span> -->
                    <?php echo $item->name ?>
                  </h2>
                  <?php if (isset($item->title) && $item->title): ?>
                    <h3><span class="raquo">&raquo;</span> <?php echo $item->title ?></h3>
                  <?php endif ?>
                  <p>
                    <?php if (isset($item->description)): ?>
                      <?php echo $item->description ?>
                    <?php else: ?>
                      <?php if (isset($item->short_description)): ?>
                        <?php echo $item->short_description ?>
                      <?php endif ?>
                    <?php endif ?>
                    
                  </p>
                  <?php if (isset($item->until) && to_date($item->until) !== '1970-01-01'): ?>
                    <p style="font-weight:bold"><?php echo round((strtotime($item->until) - time()) / (60*60*24)) ?> more days</p>
                  <?php endif ?>
                  <p>
                    <ul>
                      <li>os type: <?php echo $item->platform_name ?></li>
                      <li>min os version: <?php echo $item->min_os_version ?></li>
                      <li>game version: <?php echo $item->version ?></li>
                      <li>random inserted: <?php echo @$item->inserted ?></li>
                      <li>is new game: <?php echo $item->is_new ?></li>
                    </ul>
                  </p>
                </td>
                <td class="promo-item-download">
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
                </td>
              </tr>
            </table>
            </a>
          </div>        
        <?php endif ?>
      <?php endforeach ?>
    </div>
  <?php else: ?>
    <div class="alert alert-error">
      No items
    </div>  
  <?php endif ?>
  