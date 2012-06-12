<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" style="overflow: hidden_">
    <head>
      <title><?php echo SITE_TITLE ?></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
      
      <meta name="description" content="">
      <meta name="author" content="">
      
      <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->        

      <?php if (ENVIRONMENT==="development"): ?>
        <link rel="stylesheet/less" type="text/css" href="<?= base_url() ?>css/common/all.less">
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/plugins/lessjs/less-1.3.0.min.js"></script>
        <script type="text/javascript">
          less.env = "development";
          //less.watch();        
        </script>
      <?php else: ?>
        <link rel = "stylesheet" type="text/css" href="<?= base_url() ?>css/common/all.css">
      <?php endif ?>       
       
    </head>
    
    <body>    
        	
        <?php if ($this->session->userdata('logged_in')): ?>
            <div class="navbar navbar-fixed-top">
              <div class="navbar-inner" style="height:60px">
                <div class="container-fluid">
                  <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a href="<?php echo base_url() ?>" class="brand" style="margin-top:10px; margin-right:3px; color:#fff">
                    <i class="icon-big roundabout-icon" style="display:inline-block"></i>
                    In-game crosspromo
                  </a>
                  
                  <div class="nav-collapse">
                    <ul class="nav systems">
                      <!-- 
                      <li><a href="#">
                        <i class="icon-big iphone-icon"></i>
                        devices
                      </a></li>
                       -->
                    </ul>
                    <div class="pull-right">
                        <ul class="nav">
                            <li class="divider-vertical"></li>
                            <li>
                              <a href="<?php echo base_url() ?>auth/logout" style="font-weight:bold;margin-top:5px;" rel="tooltip" title="Logout" data-placement="bottom">
                                <i class="icon-big power-icon"></i>
                              </a>
                            </li>
                        </ul>
                    </div>
                  </div><!--/.nav-collapse -->
                </div>
              </div>
            </div>               
        <?php endif ?> 
        <div class="container-fluid" id="container" style="padding-left:0px;">
        	<div class="content row-fluid" style="margin-top:60px;">
        	  <?php if ($this->session->userdata('logged_in')): ?>
          	      <!-- 
          	  <div class="span1 sidebar-navigation-wrapper-left">
          	    <div class="sidebar-nav">
          	      <ul class="nav nav-list left-side-nav">
          	        <li <?php echo $this->uri->segment(1) === 'crosspromo' ? 'class="active"' : '' ?>>
                      <a href="<?php echo base_url() ?>crosspromo" rel="tooltip" title="Crosspromo" data-placement="right">
                        <i class="icon-big roundabout-icon"></i>
                        <span>Crosspromo</span>
                      </a>
                    </li>                    
          	      </ul>
          	    </div>
          	  </div>
          	       -->
        	  <?php endif ?>
        	  <div class="<?php echo $this->uri->segment(1) === 'systems' ? 'span12' : 'span7' ?> content-wrapper">
