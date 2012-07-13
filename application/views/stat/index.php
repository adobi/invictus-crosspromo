<div class="span12 stat-box">
  <div class="accordion-heading">
    <legend>Registered devices <span class="badge badge-info" style="position:relative; top:-2px;"><?php echo $users ? count($users) : 0 ?> </span></legend>
  </div>  
  <div id="device-chart" style="height: 300px;"></div>
</div>
<div class="span12 stat-box">
  <div class="accordion-heading">
    <legend>Clicks <span class="badge badge-info" style="position:relative; top:-2px;"><?php echo $clicks ? count($clicks) : 0 ?> </span></legend>
  </div>  
  <div id="clicks-chart" style="height: 500px;"></div>
</div>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  
  google.setOnLoadCallback(drawDevicesChart);

  function drawDevicesChart() {
    var devices_chart_data = [], 
        json_data = JSON.parse('<?php echo $devices_chart_data ?>'),
        json_data_length = json_data.length
    
    devices_chart_data.push(['Date', 'Device count'])
    
    if (json_data_length) {
      for (var i = 0; i < json_data_length; i++) devices_chart_data.push(json_data[i])
    }
    
    var data = google.visualization.arrayToDataTable(devices_chart_data);
    var options = {
      title: 'Devices',
      backgroundColor: '#f9f9f9'
    };

    var chart = new google.visualization.LineChart(document.getElementById('device-chart'));
    chart.draw(data, options);
  }
  
  google.setOnLoadCallback(drawClicksChart);

  function drawClicksChart() {
    var devices_chart_data = [], 
        json_data = JSON.parse('<?php echo $clicks_chart_data ?>'),
        json_data_length = json_data.length
    
    devices_chart_data.push(['Game anem', 'Click count'])
    
    if (json_data_length) {
      for (var i = 0; i < json_data_length; i++) devices_chart_data.push(json_data[i])
    }
    
    var data = google.visualization.arrayToDataTable(devices_chart_data);
    var options = {
      title: 'Devices',
      backgroundColor: '#f9f9f9'
    };

    var chart = new google.visualization.BarChart(document.getElementById('clicks-chart'));
    chart.draw(data, options);
  }  
  
</script>