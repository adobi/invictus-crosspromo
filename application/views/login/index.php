
<?php if (validation_errors()): ?>
    <div class="alert alert-error">
        <?php echo validation_errors() ?>
    </div>
<?php endif ?>

<?php echo form_open('', array('class'=>'form-horizontal')) ?>
      
      
	    <legend>
	      Please login
        <div class="btn-group pull-right">
          <a href="<?php echo base_url() ?>promo" class="btn dropdown-toggle" data-toggle="dropdown">
            <i class="icon-align-justify"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>promo">Crosspromos</a></li>
            <li><a href="<?php echo base_url() ?>promo/add_device_ui">Add device</a></li>
          </ul>
        </div>
      </legend>
        <fieldset class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
			    <input type="text" name="username" id="username" class="username input-xlarge" />
            </div>
        </fieldset>
        <fieldset class="control-group">
            <label class="control-label" for="password">Password</label>
            <div class="controls">
			    <input type="password" name="password" id="password" class="password input-xlarge" />
            </div>
        </fieldset>
        <fieldset class="form-actions">
            <button type="submit" class="btn btn-primary">Login</button>
        </fieldset> 

<?php echo form_close() ?>