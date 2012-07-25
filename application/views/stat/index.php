<!-- 
<div class="well">
  Benchmark time: <?php echo $benchmark_time ?>
</div>
 -->
<div class=" stat-box">
  <div class="accordion-heading">
    <legend style="width:98%">
      Registered devices <span id="" class="devices-count badge badge-info"><?php echo $users ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if (json_decode($devices_chart_data)): ?>
    <div id="device-chart" style="height: 300px;"></div>
  <?php endif ?>
    
</div>


<div class=" stat-box">
  <div class="accordion-heading">
    <legend>
      Source games <span class="devices-count badge badge-info"><?php echo $users ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if ($ccd = json_decode($devices_source_chart_data)): ?>
    <div id="devices-source-chart" style="height: <?php echo count($ccd) * 40 ?>px;"></div>
  <?php endif ?>
    
</div>

<div class=" stat-box">
  <div class="accordion-heading">
    <legend>
      Clicks per day <span class="clicks-count badge badge-info"><?php echo $clicks ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if ($ccd = json_decode($clicks_per_day_chart_data)): ?>
    <div id="clicks-per-day-chart" style="height:300px;"></div>
  <?php endif ?>
</div>

<div class=" stat-box">
  <div class="accordion-heading">
    <legend>
      Clicks on games <span class="clicks-count badge badge-info"><?php echo $clicks ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if ($ccd = json_decode($clicks_chart_data)): ?>
    <div id="clicks-chart" style="height: <?php echo count($ccd) * 40 ?>px;"></div>
  <?php endif ?>
    
</div>


<div class=" stat-box">
  <div class="accordion-heading">
    <legend>
      Orders <span id="orders-count" class="badge badge-info"><?php echo $orders ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if (json_decode($orders_chart_data)): ?>
    <div id="orders-chart" style="height: 500px;"></div>
  <?php endif ?>
</div>

