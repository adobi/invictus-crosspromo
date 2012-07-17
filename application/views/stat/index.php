<div class="span12 stat-box">
  <div class="accordion-heading">
    <legend style="width:98%">
      Registered devices <span class="badge badge-info"><?php echo $users ? count($users) : 0 ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if (json_decode($devices_chart_data)): ?>
    <div id="device-chart" style="height: 300px;"></div>
  <?php endif ?>
    
</div>

<div class="span12 stat-box">
  <div class="accordion-heading">
    <legend>
      Orders <span class="badge badge-info"><?php echo $orders ? count($orders) : 0 ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if (json_decode($orders_chart_data)): ?>
    <div id="orders-chart" style="height: 500px;"></div>
  <?php endif ?>
</div>

<div class="span12 stat-box">
  <div class="accordion-heading">
    <legend>
      Clicks <span class="badge badge-info"><?php echo $clicks ? count($clicks) : 0 ?> </span>
      <a href="#" onclick="$(this).parents('.accordion-heading').next().toggle(); return false;" class="btn pull-right"><i class="icon-resize-vertical"></i></a>
    </legend>
  </div>  
  <?php if (json_decode($clicks_chart_data)): ?>
    <div id="clicks-chart" style="height: 500px;"></div>
  <?php endif ?>
    
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  
  google.setOnLoadCallback(drawDevicesChart);

  function drawDevicesChart() {
    var chart_data = [], 
        json_data = JSON.parse('<?php echo $devices_chart_data ?>'),
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
        json_data = JSON.parse('<?php echo $clicks_chart_data ?>'),
        json_data_length = json_data.length
    
    chart_data.push(['Game name', 'Click count'])
    
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
  
  google.setOnLoadCallback(drawOrdersChart);

  function drawOrdersChart() {
    var chart_data = [], 
        json_data = JSON.parse('<?php echo $orders_chart_data ?>'),
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
        title: 'Devices',
        backgroundColor: '#f9f9f9'
      };
      var chart = new google.visualization.LineChart(document.getElementById('orders-chart'));
      chart.draw(data, options);
    }

  }  
  
</script>