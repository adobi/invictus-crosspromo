
            </div> <!-- content-wrapper -->
            <?php if ($this->session->userdata('logged_in') && $this->uri->segment(1) !== 'stat'): ?>
              <div class="span5 sidebar-navigation-wrapper-right">
          	    <div class="well">
                  <?php //echo panel_close() ?>
                  
                  <ul style="margin-top:0px;" class="legend nav nav-tabs">
                    <li class="<?php echo !$this->session->userdata('selected-sidebar-tab') ? 'active' : '' ?>">
                      <a href="#all-games-list" data-toggle="tab" >Select games</a>
                    </li>
                    <li class="<?php echo $this->session->userdata('selected-sidebar-tab') === 'types' ? 'active' : '' ?>">
                      <a href="#types" data-toggle="tab">Types</a>
                    </li>
                  </ul>
                  
                  <div class="items page-items tab-content">
                    <div class="tab-pane <?php echo !$this->session->userdata('selected-sidebar-tab') ? 'active' : '' ?>" id="all-games-list">
                      <div class="alert alert-info info-bar">
                        <i class="icon-info-sign icon-white"></i> Drag items and move them. Select multiple items by clicking them.                      
                      </div>
                      
                      <div>
                        <input class="search-query" id="quick-search-by-game-name" type="text" name="name" style="" placeholder="Start type the name of the game" />
                      </div>
                      <div class="subnav platforms-filter-bar" style="margin:10px 0 10px 0"></div>
                      
                      <div class="right-side-scroll"> 
                      </div> <!-- /right-side-scrol -->
                    </div> <!-- all-games-list -->
                    <div class="tab-pane <?php echo $this->session->userdata('selected-sidebar-tab') === 'types' ? 'active' : '' ?>" id="types">
                      <p>
                        <a href="#" class="btn edit-type-modal" data-type-id=""><i class="icon-plus"></i></a>
                      </p>
                      <div class="well">
                        <ul class="thumbnails types-list" style="margin-top:10px;">
                          <?php foreach ($types as $t): ?>
                            <li id="<?php echo $t->id ?>" class="type-item" data-type-id="<?php echo $t->id ?>">
                              <div class="thumbnail">
                                <h6 class="text-center"><?php echo $t->name ?></h6>
                                <?php if ($t->image): ?>
                                  <img src="<?php echo base_url() ?>/uploads/original/<?php echo $t->image ?>" alt="" style="max-height:80px;">
                                <?php else: ?>
                                  <img src="//placehold.it/80x80" alt="">
                                <?php endif ?>
                                <hr style="margin-bottom:5px">
                                <div class="caption text-right">
                                  <div class="btn-group">
                                    <a href="#" class="btn edit-type-modal" data-type-id="<?php echo $t->id ?>"><i class="icon-edit"></i></a>
                                    <a href="#" class="btn delete-type" data-id = "<?php echo $t->id ?>"><i class="icon-trash"></i></a>
                                  </div>
                                </div>
                              </div>
                            </li>
                          <?php endforeach ?>
                        </ul>
                      </div>
                      <?php  $this->session->unset_userdata('selected-sidebar-tab') ?>
                    </div> <!-- /types -->
                  </div> <!-- /items -->
                </div> <!-- well -->
              </div> <!-- /sidebar-navigation-wrapper -->
            <?php endif ?>
           
          </div> <!-- /content -->   
        </div> <!-- /container -->
		
		<div id="loading-global">Working...</div>		
    
		<!-- Le javascript templates -->
	  <div class="hidden">
      <div class="modal hide fade" id="delete-confirmation">
        <div class="modal-header alert-error">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Confirmation</h3>
          </div>
          <div class="modal-body">
          <p>Are you sure you want to delete the following "<strong id="the-item"></strong>" ?</p>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" data-dismiss="modal">No, I changed my mind</a>
          <a href="#" class="delete-item btn btn-danger" id="delete-yes">Ok, let's do this!</a>
        </div>
      </div>
      
      <div class="modal hide fade" id="overwrite-warning">
        <div class="modal-header alert-warning">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Warning</h3>
          </div>
          <div class="modal-body">
          <p>Are you sure you want to replace <strong id="old-item"></strong> with <strong id="new-item"></strong>?</p>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" data-dismiss="modal">No, I changed my mind</a>
          <a href="#" class="btn btn-warning" id="overwrite-yes">Ok, let's do this!</a>
        </div>
      </div>    
      
      <div class="modal hide fade" id="already-in-use-error">
        <div class="modal-header alert-error">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Error</h3>
        </div>
        <div class="modal-body">
          <p>
          <!-- <strong id="item-to-use"></strong> is --> Already in the list, select something else!</p>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
      </div>         
      	    
      <div class="modal hide fade" id="edit-description-modal_">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Edit description</h3>
        </div>
        <?php echo form_open('', array('style'=>'margin-bottom:0;', 'id'=>'edit-description-form')) ?>
        <div class="modal-body">
          <p style="text-align:center">
            <textarea name="description" class="span6" rows="3" data-countable="1" data-limit="160" data-parent=".modal-body" data-prepend=".modal-footer"></textarea>
          </p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <?php echo form_close() ?>
      </div>

      <?php if (isset($games_select)): ?>
        <div class="modal hide fade" id="copy-list-modal">
          <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Copy list</h3>
          </div>
          <?php echo form_open('', array('style'=>'margin-bottom:0;', 'id'=>'copy-list-form', 'data-action'=>'crosspromo/copy_list/')) ?>
          <div class="modal-body">
            <div class="alert alert-error hide"></div>
            <div style="margin-bottom:200px">
              <?php echo form_dropdown('target_games[]', $games_select, '', 'class="span6 chosen" data-placeholder="Select games" multiple') ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Copy</button>
          </div>
          <?php echo form_close() ?>
        </div>      
      <?php endif ?>
	  </div>
    <!-- /javascript templates -->
    
    <div id="dummy-container"></div>
    
    <!-- drag'n'drop helper -->
    <ul class="unstyled dnd-helper"></ul>
    	            
    <script type="text/javascript">
        var App = App || {};
        App.URL = "<?php echo base_url() ?>";
    </script>      
    
  	<script src = "<?php echo base_url() ?>scripts/plugins/headjs/head.min.js"></script> 
  	<script type="text/javascript">
  	    head.js("http://code.jquery.com/jquery-latest.min.js", 
  	            "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js",
  	            "https://raw.github.com/cowboy/jquery-hashchange/v1.3/jquery.ba-hashchange.min.js",
  	            "http://cloud.github.com/downloads/wycats/handlebars.js/handlebars-1.0.0.beta.6.js",
  	            "https://raw.github.com/filamentgroup/jQuery-Visualize/master/js/visualize.jQuery.js",
              <?php if (ENVIRONMENT === 'development') : ?>
                "<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap.js",
                "<?php echo base_url() ?>scripts/plugins/chosen/chosen.jquery.min.js",
                "<?php echo base_url() ?>scripts/plugins/charcounter/jquery.charcounter.js",

                "<?php echo base_url() ?>scripts/admin/nav.js?<?php echo time(); ?>",
                "<?php echo base_url() ?>scripts/admin/template.js?<?php echo time(); ?>",
                "<?php echo base_url() ?>scripts/admin/utils.js?<?php echo time(); ?>",
                <?php if ($this->uri->segment(1) === 'crosspromo') : ?>
                  "<?php echo base_url() ?>scripts/admin/crosspromo.js?<?php echo time(); ?>",
                <?php endif; ?>
                "<?php echo base_url() ?>scripts/admin/page.js?<?php echo time(); ?>",
              <?php else: ?>
                "<?php echo base_url() ?>assets/scripts/admin.min.js",
              <?php endif; ?>
                function() {
                  //$('.chart-data').visualize({type: 'line', width: '420px'});
                    <?php if ($this->session->flashdata('message')): ?>
                        $(function() {
                            App.showNotification("<?php echo ($this->session->flashdata("message")) ?>")
                        })
                    <?php endif ?>
                    
                    <?php if ($this->uri->segment(1) === 'crosspromo') :?>
                      $(function () {
                        //(new App.Nav()).setHref('<?php echo base_url() ?>game/all').loadIntoRightPanel()
                      })
                          //
                    <?php endif; ?>
                }                     
          );
  	</script>
    <?php if (isset($devices_chart_data) && isset($clicks_chart_data) && isset($orders_chart_data)): ?>
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript">
        var Data = {}
        
        Data.Devices = JSON.parse('<?php echo $devices_chart_data ?>')
        Data.Clicks = JSON.parse('<?php echo $clicks_chart_data ?>')
        Data.Orders = JSON.parse('<?php echo $orders_chart_data ?>')
        Data.ClicksPerDay = JSON.parse('<?php echo $clicks_per_day_chart_data ?>')
        
        google.load("visualization", "1", {packages:["corechart"]});
        
        google.setOnLoadCallback(drawDevicesChart);
      
        function drawDevicesChart() {
          var chart_data = [], 
              json_data = Data.Devices,
              json_data_length = json_data.length
          
          chart_data.push(['Date', 'Device count'])
          
          if (json_data_length) {
            for (var i = 0; i < json_data_length; i++) chart_data.push(json_data[i])
          }
          
          if (chart_data.length !== 1) {
            var data = google.visualization.arrayToDataTable(chart_data);
            var options = {
              title: 'Devices',
              backgroundColor: '#f9f9f9'
            };
            var chart = new google.visualization.LineChart(document.getElementById('device-chart'));
            chart.draw(data, options);
          }
        }
        
        google.setOnLoadCallback(drawClicksChart);
      
        function drawClicksChart() {
          var chart_data = [], 
              json_data = Data.Clicks,
              json_data_length = json_data.length
          
          chart_data.push(['Game name', 'Clicks on game count'])
          
          if (json_data_length) {
            for (var i = 0; i < json_data_length; i++) chart_data.push(json_data[i])
          }
          
          if (chart_data.length !== 1) {
            var data = google.visualization.arrayToDataTable(chart_data);
            var options = {
              title: 'Clicks',
              backgroundColor: '#f9f9f9'
            };
        
            var chart = new google.visualization.BarChart(document.getElementById('clicks-chart'));
            chart.draw(data, options);
            
          }
          
        } 

        google.setOnLoadCallback(drawClickPerDayChart);
        
        function drawClickPerDayChart() {
          var chart_data = [], 
              json_data = Data.ClicksPerDay,
              json_data_length = json_data.length
          
          chart_data.push(['Date', 'Click count'])
          
          if (json_data_length) {
            for (var i = 0; i < json_data_length; i++) chart_data.push(json_data[i])
          }
          
          if (chart_data.length !== 1) {
            var data = google.visualization.arrayToDataTable(chart_data);
            var options = {
              title: 'Clicks per day',
              backgroundColor: '#f9f9f9'
            };
            var chart = new google.visualization.LineChart(document.getElementById('clicks-per-day-chart'));
            chart.draw(data, options);
          }
        }         
        
        google.setOnLoadCallback(drawOrdersChart);
      
        function drawOrdersChart() {
          var chart_data = [], 
              json_data = Data.Orders,
              json_data_length = json_data.length
          
          chart_data.push(['Date', 'Order count'])
          
          if (json_data_length) {
            for (var i = 0; i < json_data_length; i++) chart_data.push(json_data[i])
          }
          
          var data = google.visualization.arrayToDataTable(chart_data);
          var options = {
            title: 'Orders',
            backgroundColor: '#f9f9f9'
          };
      
          if (chart_data.length !== 1) {
            var data = google.visualization.arrayToDataTable(chart_data);
            var options = {
              title: 'Orders',
              backgroundColor: '#f9f9f9'
            };
            var chart = new google.visualization.LineChart(document.getElementById('orders-chart'));
            chart.draw(data, options);
          }
        }  
        
      </script>  	  
    <?php endif ?>  	
  	<!-- 
      time: <?php echo $this->benchmark->elapsed_time();?>
      memory: <?php echo $this->benchmark->memory_usage();?>
    -->
  </body>
</html>