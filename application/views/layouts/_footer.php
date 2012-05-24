
            </div> <!-- content-wrapper -->
            <?php if ($this->session->userdata('logged_in') && $this->uri->segment(1) !== 'systems'): ?>
              <div class="span5 sidebar-navigation-wrapper-right">
          	    <div class="well">
                  <?php //echo panel_close() ?>
                  <p>&nbsp;</p>
                  <legend style="margin-top:-30px;">Drag items and move them</legend>
                  <div class="items page-items">
                    <div class="subnav platforms-filter-bar" style="margin:10px 0 10px 0">
                    </div>
                    <div class="right-side-scroll"> 
                    </div> <!-- /right-side-scrol -->
                  </div> <!-- /items -->
                </div> <!-- well -->
              </div>
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
          <p><strong id="item-to-use"></strong> is already in the list, select something else!</p>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
      </div>         
      	    
	  </div>
    <!-- /javascript templates -->
    
    <!-- drag'n'drop helper -->
    <ul class="unstyled dnd-helper"></ul>
    	            
    <script type="text/javascript">
        var App = App || {};
        App.URL = "<?php echo base_url() ?>";
    </script>      
  	<script src = "<?php echo base_url() ?>scripts/plugins/headjs/head.min.js"></script> 
  	<script type="text/javascript">
  	    head.js("http://code.jquery.com/jquery-1.7.1.min.js", 
  	            "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js",
  	            "https://raw.github.com/cowboy/jquery-hashchange/v1.3/jquery.ba-hashchange.min.js",
  	            "http://cloud.github.com/downloads/wycats/handlebars.js/handlebars-1.0.0.beta.6.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-dropdown.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-tab.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-transition.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-alert.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-modal.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-tooltip.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-popover.js",
                //"<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap-transition.js",
                "<?php echo base_url() ?>scripts/plugins/bootstrap/bootstrap.js",

                //"<?php echo base_url() ?>scripts/plugins/redactor/js/redactor/redactor.js",
                //"<?php echo base_url() ?>scripts/plugins/fancybox/jquery.fancybox.pack.js",
                "<?php echo base_url() ?>scripts/plugins/chosen/chosen.jquery.min.js",
                
                "http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.js",
                //"<?php echo base_url(); ?>scripts/plugins/fileupload/vendor/jquery.ui.widget.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/tmpl.min.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/load-image.min.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/canvas-to-blob.min.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/jquery.iframe-transport.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/jquery.fileupload.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/jquery.fileupload-ip.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/jquery.fileupload-ui.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/locale.js",
                "<?php echo base_url(); ?>scripts/plugins/fileupload/main.js",
                
                //"<?php echo base_url(); ?>scripts/plugins/scroll/jquery.scrollTo-min.js",
                //"<?php echo base_url() ?>scripts/plugins/google-code-prettify/prettify.js",
                //"<?php echo base_url() ?>scripts/plugins/charcounter/jquery.charcounter.js",
                "<?php echo base_url() ?>scripts/plugins/prettify-upload/jquery.prettify-upload.js",
                //"<?php echo base_url() ?>scripts/plugins/lionbars/jquery.lionbars.0.3.min.js",
                "<?php echo base_url() ?>scripts/plugins/spinjs/spin.min.js",
                
                "<?php echo base_url() ?>scripts/admin/nav.js?<?php echo time(); ?>",
                "<?php echo base_url() ?>scripts/admin/template.js?<?php echo time(); ?>",
                "<?php echo base_url() ?>scripts/admin/utils.js?<?php echo time(); ?>",
                <?php if ($this->uri->segment(1) === 'crosspromo') : ?>
                  "<?php echo base_url() ?>scripts/admin/crosspromo.js?<?php echo time(); ?>",
                <?php endif; ?>
                "<?php echo base_url() ?>scripts/admin/page.js?<?php echo time(); ?>",
                function() {
                
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
   
  </body>
</html>