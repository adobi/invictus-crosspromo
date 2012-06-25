<br><br>

<style type="text/css">
  .paramters .label {
    font-family:Menlo, Monaco, Consolas, "Courier New", monospace
  }
  
  .doc-section {
    margin-left:30px;
  }
  h6 {
    margin-top:20px;
    margin-bottom:10px;
  }
  
  h6 .label {
    text-transform:lowercase;
    margin-left:10px;
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


  <legend><a href="#" class="btn btn-mini toggle"><i class="icon-<?php echo $response ? 'minus' : 'plus' ?>"></i></a> Test console</legend>
  <?php echo form_open(base_url() . 'promo/console', array('class'=>'add-device-form form-horizontal well ' . ($response ? '' : 'hide'))) ?>
  <!-- <?php echo form_open(base_url() . 'promo/add_device/xml', array('class'=>'add-device-form form-horizontal well ' . ($response ? '' : 'hide'))) ?> -->
      <div class="hide alert alert-error"></div>
      <div class="hide alert alert-success"></div>
      <fieldset class="control-group">
          <label class="control-label" for="device_id">Device ID</label>
          <div class="controls">
  	        <input type="text" name="device_id" id="device_id" class="span3" value="<?php echo md5(rand(1, 10000)) ?>"/>
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
      <fieldset class="control-group">
          <label class="control-label" for="os_version">Response</label>
          <div class="controls">
            <label class="radio inline">
              <input type="radio" name="response_type" value="json"> JSON
            </label>            
  	        <label class="radio inline">
  	          <input type="radio" name="response_type" value="xml" checked/> XML
            </label>            

          </div>
      </fieldset>
      <fieldset class="form-actions">
          <button type="submit" class="btn btn-primary">Create</button>
      </fieldset> 
      <?php if ($response): ?>
        <div class="alert alert-info">
          Response
          <pre><?php echo htmlspecialchars($response) ?></pre>        
        </div>
      <?php endif ?>
  <?php echo form_close() ?>

<legend>
  <a href="#" class="btn btn-mini toggle"><i class="icon-minus"></i></a> 
  Add device
</legend>

<fieldset class="doc-section">
  <h6>Request uri</h6>
  <pre><?php echo base_url() ?>promo/add_device/<span class="label label-info">:[json|xml]</span></pre>

  <h6>Description</h6>
  <p>Call this method once after game start.</p>

  <h6>Request method</h6>
  <pre>POST</pre>
  <h6>Parameters <span class="label label-important">all fields are required</span></h6>
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
        <td>unique device identifier (md5 hash)</td>
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
        <td>The name of the game (e.g. <em>Froggy Jump</em>) <a data-toggle="modal" href="#games-modal" class="btn" rel="tooltip" title="Show games list"><i class="icon-list"></i></a></td>
      </tr>
      <tr>
        <td><span class="label label-info">game_version</span></td>
        <td>The version of the game</td>
      </tr>
    </tbody>
  </table>
  
  <h6>Response type</h6>
  <pre>JSON or XML</pre>

  <h6>Response JSON</h6>
Success
<pre>
{
  "success": 
  {
    "game": <strong>52</strong> /* used at the Get crosspromo list api call*/
  },
  "has_list": 1 /* 0 or 1 */
}</pre>
Error
<pre>
{
  "error": "Error message"
}
</pre> 

  <h6>Response XML</h6>
Success
<pre>
<?php echo htmlspecialchars("<success>
  <game>
    52 /* used at the Get crosspromo list api call*/
  </game>
  <has_list>
    1  /* 0 or 1 */
  </has_list>
</success>
") ?></pre>
Error
<pre>
<?php echo htmlspecialchars("<error>
  Error message
</error>") ?>
</pre> 

</fieldset>

<br>

<legend>
  <a href="#" class="btn btn-mini toggle"><i class="icon-minus"></i></a> 
  Get crosspromo list
</legend>
<fieldset class="doc-section">
  <h6>Request uri</h6>
  <pre><?php echo base_url() ?>promo/show/game/<span class="label label-info">:game_id</span>/device/<span class="label label-info">:device_id</span>/platform/<span class="label label-info">:[ios|android]</span>/type/<span class="label label-info">:[phone|tablet]</span>/os/<span class="label label-info">:os_version</span>/version/<span class="label label-info">:game_version</span></pre>

  <h6>Request method</h6>
  <pre>GET</pre>
  <h6>Parameters <span class="label label-important">all fields are required</span></h6>
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
        <td>Unique device identifier (md5 hash)</td>
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

<div id="games-modal" class="hide fade modal">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">×</button>
      <h3>Game names</h3>
    </div>
    <div class="modal-body">
      <?php if ($games): ?>
        <?php foreach ($games as $item): ?>
          <?php if ($item): ?>
            <input type="text" class="span5" value="<?php echo $item->name ?>" />
          <?php endif ?>
        <?php endforeach ?>
      <?php else: ?>
        <div class="alert alert-error">No games</div>
      <?php endif ?>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
