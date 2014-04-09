<?php
$this->breadcrumbs=array(
	'Reports',
);

$this->printMenu();

echo "<div class='currentstats'>";

$data1 = $this->getItemHistoricalData(4302);
$data2 = $this->getItemHistoricalData(4306);
$data3 = $this->getItemHistoricalData(4308);
$data4 = $this->getItemHistoricalData(4310);

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
		 array('name' => 'Oracle', 'type'=>'line', 'data' => 'js:'.$data1),
		 array('name' => 'Naga', 'type'=>'line', 'data' => 'js:'.$data2),
		 array('name' => 'Talos', 'type'=>'line', 'data' => 'js:'.$data3),
		 array('name' => 'Tornado', 'type'=>'line', 'data' => 'js:'.$data4),

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
			'series' => array('marker' => array('radius' => 3)),
			'spline' => array('enableMouseTracking' => 'js:false', 'marker' => array('enabled' => false))
		),
   )
));
?>
</div>

