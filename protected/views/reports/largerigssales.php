<?php
$this->breadcrumbs=array(
	'Reports',
);

$this->printMenu();

echo "<div class='currentstats'>";

$data1 = $this->getItemHistoricalData(25948);
$data2 = $this->getItemHistoricalData(25894);
$data3 = $this->getItemHistoricalData(26088);

$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('height' => 500, 'zoomType' => 'x'),
	  'title' => array('text' => 'Historical Sales'),
	  'xAxis' => array(
		 'title' => array('text' => 'js:null'),
		 'type' => 'datetime',
		 'maxZoom' => (7 * 24 * 3600000),
	  ),
	  'yAxis' => array(
		 'title' => array('text' => 'js:null'),
		 'min' => 'js:0',
		 'minorTickInterval' => 'auto',
		 'labels' => array(
			 'formatter' => "js:
			function() {
			   return Highcharts.numberFormat(this.value, 0);
			}",
		  )
	  ),
	  'series' => array(
		 array('name' => 'Large Capacitor Control Circuit I', 'type'=>'scatter', 'data' => 'js:'.$data1),
		 array('name' => 'Large Trimark Armor Pump I', 'type'=>'scatter', 'data' => 'js:'.$data2),
		 array('name' => 'Large Core Defence Field Extender I', 'type'=>'scatter', 'data' => 'js:'.$data3),

	  ),
	  'credits' => array('enabled' => false),
	  'exporting' => array('enabled' => false),
	  'tooltip' => array('formatter' => "js:
		function() {
		   return '<b>'+ Highcharts.dateFormat('%b %e, %Y', this.x) +'</b><br/>'+
		   Highcharts.numberFormat(this.y, 2) +'M ISK';
		}"
	  ),
	  'plotOptions' => 
		array(
			'scatter' => array('marker' => array('radius' => 3)),
		),
   )
));
?>
</div>

