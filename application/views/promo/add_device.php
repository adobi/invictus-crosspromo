<br><br>
<?php echo form_open('http://press.invictus.com/cp/'.'promo/add_device', array('class'=>'add-device-form form-horizontal')) ?>
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
          </div>
      </fieldset>
      <fieldset class="control-group">
          <label class="control-label" for="os_version">Device OS version</label>
          <div class="controls">
		        <input type="text" name="os_version" id="os_version" class="span2" />
          </div>
      </fieldset>
      <fieldset class="control-group">
          <label class="control-label" for="os_version">Select a game</label>
          <div class="controls">
		        <?php echo form_dropdown('game_id', $games, '', 'class="input-xlarge chosen" data-placeholder="Select a game"') ?>
          </div>
      </fieldset>
      <fieldset class="control-group">
          <label class="control-label" for="game_version">Game version</label>
          <div class="controls">
		        <input type="text" name="game_version" id="game_version" class="span2" />
          </div>
      </fieldset>
      <fieldset class="form-actions">
          <button type="submit" class="btn btn-primary">Create</button>
      </fieldset> 

<?php echo form_close() ?>

