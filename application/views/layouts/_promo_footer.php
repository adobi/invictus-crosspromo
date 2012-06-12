        </div> <!-- /container -->
		
		<div id="loading-global">Working...</div>		
    
    	            
    <script type="text/javascript">
        var App = App || {};
        App.URL = "<?php echo base_url() ?>";
    </script>      
  	<script src = "<?php echo base_url() ?>scripts/plugins/headjs/head.min.js"></script> 
  	<script type="text/javascript">
  	    head.js("//code.jquery.com/jquery-1.7.1.min.js", 
  	            "//ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js",
  	            "//cloud.github.com/downloads/wycats/handlebars.js/handlebars-1.0.0.beta.6.js",
  	            "<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap.js",
                "<?php echo base_url() ?>scripts/plugins/spinjs/spin.min.js",
                "<?php echo base_url() ?>scripts/plugins/event-tracking/jquery.trackevent.js",
                "<?php echo base_url() ?>scripts/plugins/chosen/chosen.jquery.min.js",
                
                "<?php echo base_url() ?>scripts/promo/promo.js",
                function() {
                }                     
          );
  	</script>
   
  </body>
</html>