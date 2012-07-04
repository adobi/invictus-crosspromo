        </div> <!-- /container -->
		
		<!-- <div id="loading-global"><img src="<?php echo base_url() ?>img/loading.gif" alt=""></div>		 -->
    
    	            
    <script type="text/javascript">
        var App = App || {};
        App.URL = "<?php echo base_url() ?>";
    </script>      
  	<script src = "<?php echo base_url() ?>scripts/plugins/headjs/head.min.js"></script> 
  	<script type="text/javascript">
  	    head.js("//code.jquery.com/jquery-1.7.1.min.js", 
  	          <?php if (ENVIRONMENT === 'development') : ?>
  	            "<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap.js",
                "<?php echo base_url() ?>scripts/plugins/event-tracking/jquery.trackevent.js",
                "<?php echo base_url() ?>scripts/plugins/chosen/chosen.jquery.min.js",
                "<?php echo base_url() ?>scripts/promo/promo.js",
              <?php else: ?>
                "<?php echo base_url() ?>assets/scripts/all.min.js",
              <?php endif; ?>
                function() {
                }                     
          );
  	</script>

  </body>
</html>