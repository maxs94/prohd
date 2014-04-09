<?php
$this->breadcrumbs=array(
	'Reports',
);

$this->printMenu();

echo "<div class='currentstats'>";

$data1 = $this->getItemHistoricalData(17887);
$data2 = $this->getItemHistoricalData(16274);
$data3 = $this->getItemHistoricalData(17889);
$data4 = $this->getItemHistoricalData(17888);

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
		 array('name' => 'Oxygen', 'type'=>'scatter', 'data' => 'js:'.$data1),
		 array('name' => 'Helium', 'type'=>'scatter', 'data' => 'js:'.$data2),
		 array('name' => 'Hydrogen', 'type'=>'scatter', 'data' => 'js:'.$data3),
		 array('name' => 'Nitrogen', 'type'=>'scatter', 'data' => 'js:'.$data4),
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

