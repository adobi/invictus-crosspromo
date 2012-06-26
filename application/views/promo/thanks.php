
<div class="items" style="margin-top:20px;">
  <div class="item">
    <a href="<?php unset($params['thanks']); echo base_url().'promo/show/'.$this->uri->assoc_to_uri($params) ?>" id="redirect" class="pull-right" style="margin: 5px 5px 0"><img src="<?php echo base_url() ?>img/icon-close.png" alt=""></a>
    <h3 class="text-center tk-ff-cocon-web-pro" style="padding:20px; color:#d3d3d3">
      Thank your for downloading
    </h3>
    <h3 class="text-center tk-ff-cocon-web-pro" style="padding:0 20px 20px;font-size:1.6em; color:#fff"><?php echo $game->name ?></h3>
  </div>
</div>
