<?php
$this->breadcrumbs=array(
	'Reports',
);

$this->printMenu();

echo "<div class='currentstats'>";

$data1 = $this->arrayToHighchart($this->getStationMovementData(61000350)); //D2-HOS
$data2 = $this->arrayToHighchart($this->getStationMovementData(60014899)); //G8AD-C
$data3 = $this->arrayToHighchart($this->getStationMovementData(61000182)); //GE-8JV
$data4 = $this->arrayToHighchart($this->getStationMovementData(61000363)); //6VDT-H
$data5 = $this->arrayToHighchart($this->getStationMovementData(60014945)); //1DH-SX
$data6 = $this->arrayToHighchart($this->getStationMovementData(61000746)); //K-6K16


$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('height' => 325, 'zoomType' => 'x'),
	  'title' => array('text' => 'Sale Transactions Per Day'),
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
		 array('name' => 'D2-HOS', 'type'=>'scatter', 'data' => 'js:'.$data1),
		 array('name' => 'G8AD-C', 'type'=>'scatter', 'data' => 'js:'.$data2),
		 array('name' => 'GE-8JV', 'type'=>'scatter', 'data' => 'js:'.$data3),
		 array('name' => '6VDT-H', 'type'=>'scatter', 'data' => 'js:'.$data4),
		 array('name' => '1DH-SX', 'type'=>'scatter', 'data' => 'js:'.$data5),
		 array('name' => 'K-6K16', 'type'=>'scatter', 'data' => 'js:'.$data6),
	  ),
	  'credits' => array('enabled' => false),
	  'exporting' => array('enabled' => false),
	  'tooltip' => array('formatter' => "js:
		function() {
		   return '<b>'+ Highcharts.dateFormat('%b %e, %Y', this.x) +'</b><br/>'+
		   Highcharts.numberFormat(this.y, 0) +' Transactions';
		}"
	  ),
	  'plotOptions' => 
		array(
			'scatter' => array('marker' => array('radius' => 3)),
			//'series' => array('marker' => array('radius' => 3)),
			//'spline' => array('enableMouseTracking' => 'js:false', 'marker' => array('enabled' => false))
		),
   )
));
?>
</div>

