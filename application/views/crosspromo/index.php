<div class="well crosspromo" style="padding-top:0px;">

    <div id="layout">
      <div class="hidden csrf-form">
        <?php echo form_open() ?>
        <?php echo form_close() ?>
      </div>     
      <div class="accordion-heading">
          <legend  _class="inline-legend" style="margin-bottom:0px;">Select a game</legend>
          <a href="#more-games" data-toggle="collapse" class="accordion-toggle">
            <!-- <a  style="margin-left:5px; margin-top:-7px;" onclick="$('#crosspromo-games>.thumbnails').toggle(); return false;" class="btn" rel="tooltip" title="Toggle list"><i class="icon-resize-vertical" style="left:0; top:0"></i></a> -->
              <?php echo form_dropdown('game_id', $games_select, '', 'id="crosspromo_base_game" class="span8 chosen" data-placeholder="Select a game"') ?>
            <!-- <h6 style="display:inline-block; position:relative; top:0px; "> or select from the list</h6> -->
          </a>
      </div>
      <div class=" accordion-inner">
      </div>
    </div>  
</div>