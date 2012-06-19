<br><br>
<!-- 
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
 -->
<style type="text/css">
  .paramters .label {
    font-family:Menlo, Monaco, Consolas, "Courier New", monospace
  }
  
  .doc-section {
    margin-left:30px;
  }
</style>

<h1>
  Crosspromo API
  <div class="btn-group pull-right">
    <a href="<?php echo base_url() ?>promo" class="btn dropdown-toggle" data-toggle="dropdown">
      <i class="icon-align-justify"></i>
    </a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url() ?>/promo" style="font-size:13px">Crosspromos</a></li>
      <li><a href="<?php echo base_url() ?>auth/login" style="font-size:13px">Login</a></li>
    </ul>
  </div>
  
</h1> 
<hr> 

<legend>
  <a href="#" class="btn btn-mini toggle"><i class="icon-minus"></i></a> 
  Add device
</legend>
<fieldset class="doc-section">
  <h6>Request uri</h6>
  <pre><?php echo base_url() ?>promo/add_device</pre>
  
  <h6>Request method</h6>
  <pre>POST</pre>
  <h6>Parameters</h6>
  <table class="table table-striped table-bordered parameters">
    <thead>
      <tr>
        <th class="span2">Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="label label-info">device_id</span></td>
        <td>unique device identifier</td>
      </tr>
      <tr>
        <td><span class="label label-info">platform_type</span></td>
        <td>phone or tablet</td>
      </tr>
      <tr>
        <td><span class="label label-info">platform_name</span></td>
        <td>ios or android</td>
      </tr>
      <tr>
        <td><span class="label label-info">os_version</span></td>
        <td>OS version (e.g. <em>4.2</em>)</td>
      </tr>
      <tr>
        <td><span class="label label-info">game_name</span></td>
        <td>The name of the game (e.g. <em>Froggy Jump</em>)</td>
      </tr>
      <tr>
        <td><span class="label label-info">game_version</span></td>
        <td>The version of the game</td>
      </tr>
    </tbody>
  </table>
  
  <h6>Response type</h6>
  <pre>JSON</pre>

  <h6>Response</h6>
Success
<pre>
{
  "success": 
  {
    "game": <strong>52</strong> /* used at the Get crosspromo list api call*/
  }
}</pre>
Error
<pre>
{
  "error": "Error message"
}
</pre> 
  <h6><a href="#" class="btn btn-mini toggle"><i class="icon-plus"></i></a> Test console</h6>
  <?php echo form_open(base_url() . 'promo/console', array('class'=>'add-device-form form-horizontal well hide')) ?>
      <div class="hide alert alert-error"></div>
      <div class="hide alert alert-success"></div>
      <fieldset class="control-group">
          <label class="control-label" for="device_id">Device ID</label>
          <div class="controls">
  	        <input type="text" name="device_id" id="device_id" class="span3" value="<?php echo md5('a') ?>"/>
  	        Type: 
  	        <select name="platform_type" id="" class="span2">
  	          <option value="phone">phone</option>
  	          <option value="table">tablet</option>
            </select>
          </div>
      </fieldset>
      <fieldset class="control-group">
          <label class="control-label" for="platform_name">Device OS</label>
          <div class="controls">
  	        <select name="platform_name" id="platform_name" class="span2">
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
  	        <input type="text" name="game_name" value="" class="span4">
  	        Version:
  	        <input type="text" name="game_version" id="game_version" class="span1" />
          </div>
      </fieldset>
      <fieldset class="form-actions">
          <!-- <input type="hidden" name="<?php echo $token->name ?>" value="<?php echo $token->value ?>"> -->
          <button type="submit" class="btn btn-primary">Create</button>
      </fieldset> 
  <?php echo form_close() ?>
  
</fieldset>

<br>

<legend>
  <a href="#" class="btn btn-mini toggle"><i class="icon-minus"></i></a> 
  Get crosspromo list
</legend>
<fieldset class="doc-section">

  <br>
  <h6>Request uri</h6>
  <pre><?php echo base_url() ?>promo/show/game/<span class="label label-info">:game_id</span>/device/<span class="label label-info">:device_id</span>/platform/<span class="label label-info">:[ios|android]</span>/type/<span class="label label-info">:[phone|tablet]</span>/os/<span class="label label-info">:os_version</span>/version/<span class="label label-info">:game_version</span></pre>

  <h6>Request method</h6>
  <pre>GET</pre>
  <h6>Parameters</h6>
  <table class="table table-striped table-bordered parameters">
    <thead>
      <tr>
        <th class="span2">Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="label label-info">:game_id</span></td>
        <td>Sent by the server after the <strong>Add device</strong> api call</td>
      </tr>
      <tr>
        <td><span class="label label-info">:device_id</span></td>
        <td>Unique device identifier</td>
      </tr>
      <tr>
        <td><span class="label label-info">:[ios|android]</span></td>
        <td>ios or android</td>
      </tr>
      <tr>
        <td><span class="label label-info">:[phone|tablet]</span></td>
        <td>phone or tablet</td>
      </tr>
      <tr>
        <td><span class="label label-info">:os_version</span></td>
        <td>OS version (<em>e.g. 4.2</em>)</td>
      </tr>
      <tr>
        <td><span class="label label-info">:game_version</span></td>
        <td>Game version (<em>e.g. 2.1</em>)</td>
      </tr>
    </tbody>
  </table>
  
  <h6>Response type</h6>
  <pre>HTML</pre>
</fieldset>
