
<?php if (validation_errors()): ?>
    <div class="alert alert-error">
        <?php echo validation_errors() ?>
    </div>
<?php endif ?>

<?php echo form_open('', array('class'=>'form-horizontal')) ?>
      
    <fieldset>
	    <legend>
	      Please login
        <div class="btn-group pull-right">
          <a href="<?php echo base_url() ?>promo" class="btn dropdown-toggle" data-toggle="dropdown">
            <i class="icon-align-justify"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() ?>promo">Crosspromos</a></li>
            <li><a href="<?php echo base_url() ?>promo/console">API</a></li>
          </ul>
        </div>
      </legend>
      <div class="control-group">
          <label class="control-label" for="name">&nbsp;</label>
          <div class="controls">
		        <div class="input-prepend">
              <span class="add-on"><i class="icon-user"></i></span><input type="text" name="username" id="username" class="username span4" />
            </div>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="password">&nbsp;</label>
          <div class="controls">
		        <div class="input-prepend">
              <span class="add-on"><i class="icon-lock"></i></span><input type="password" name="password" id="password" class="password span4" />
            </div>
          </div>
      </div>
      
      <div class="form-actions">
          <button type="submit" id="login" class="btn btn-primary" _onclick="$(this).tooltip('show');" data-placement="right" data-trigger="manual" title="Please wait! <br /> Loading data from invictus.com ...">Login</button>
      </div> 
      
    </fieldset>  
<?php echo form_close() ?>