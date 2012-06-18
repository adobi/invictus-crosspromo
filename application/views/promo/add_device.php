<br><br>

<div>
  <legend>Token</legend>
  <fieldset class="control-group">
    <input type="text" value="<?php echo $token ? $token->name : '' ?>" disabled placeholder="token name"/>

    <input type="text" value="<?php echo $token ? $token->value : '' ?>" disabled placeholder="token value"/>
  </fieldset>
  <fieldset class="form-actions">
    <a href="<?php echo base_url() ?>promo/add_device_ui/get_token" class="btn btn-primary">Get token</a>
  </fieldset>
</div>

<?php if ($token): ?>
  <!-- <form action="<?php echo base_url() ?>promo/add_device_ui"  class="add-device-form form-horizontal" method="post"> -->
  <?php echo form_open( base_url() ."promo/add_device/", array('class'=>'add-device-form form-horizontal')) ?>
      <div class="hide alert alert-error"></div>
      <div class="hide alert alert-success"></div>
	    <legend>
	      Add device
        <div class="btn-group pull-right">
          <a href="<?php echo base_url() ?>promo" class="btn dropdown-toggle" data-toggle="dropdown">
            <i class="icon-align-justify"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>/promo" style="font-size:13px">Crosspromos</a></li>
            <li><a href="<?php echo base_url() ?>auth/login" style="font-size:13px">Login</a></li>
          </ul>
        </div>
      </legend>
      <fieldset class="control-group">
          <label class="control-label" for="device_id">Device ID</label>
          <div class="controls">
		        <input type="text" name="device_id" id="device_id" class="input-xlarge" value="<?php echo md5('a') ?>"/>
		        Type: 
		        <select name="platform_type" id="" class="span2">
		          <option value="phone">phone</option>
		          <option value="table">tablet</option>
	          </select>
          </div>
      </fieldset>
      <fieldset class="control-group">
          <label class="control-label" for="device_id">Device OS</label>
          <div class="controls">
		        <select name="platform_name" id="" class="span2">
		          <option value="ios">ios</option>
		          <option value="android">android</option>
	          </select>
	          Version: 
		        <input type="text" name="os_version" id="os_version" class="span1" />
          </div>
      </fieldset>      
      <fieldset class="control-group">
          <label class="control-label" for="os_version">Game name</label>
          <div class="controls">
		        <?php //echo form_dropdown('game_id', $games, '', 'class="input-xlarge chosen" data-placeholder="Select a game"') ?>
		        <input type="text" name="game_name" value="">
          </div>
      </fieldset>
      <fieldset class="control-group">
          <label class="control-label" for="game_version">Game version</label>
          <div class="controls">
		        <input type="text" name="game_version" id="game_version" class="span1" />
          </div>
      </fieldset>
      <fieldset class="form-actions">
          <!-- <input type="hidden" name="<?php echo $token->name ?>" value="<?php echo $token->value ?>"> -->
          <button type="submit" class="btn btn-primary">Create</button>
      </fieldset> 
  <?php echo form_close() ?>
<?php endif ?>

