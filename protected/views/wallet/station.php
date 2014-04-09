<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$station->stationName,
);

$this->menu=array(
	array('label'=>'Create Transactions', 'url'=>array('create')),
	array('label'=>'Manage Transactions', 'url'=>array('admin')),
);
?>
<hr>
<div class="mainHalfLeft">

<div class='currentstats' id='iskmovement' style="width:325px;">
		<table>
		<tr class="header1">
			<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon18_01.png" width="16" height="16">Duration</div></td>
			<td style="text-align: right;">Profit</td>
		</tr>
		<tr>
			<td style="text-align: left;"><font color="green">30 Days</font></td>
			<td style="text-align: right;"><font color="green">+<?php echo number_format($this->getSalesDataByStation($station->stationID, 30),2) ?></font></td>
		</tr>
		<tr class='odd'>
			<td style="text-align: left;"><font color="green">7 Days</font></td>
			<td style="text-align: right;"><font color="green">+<?php echo number_format($this->getSalesDataByStation($station->stationID, 6),2) ?></font></td>
		</tr>
		<tr>
			<td style="text-align: left;"><font color="green">Yesterday</font></td>
			<td style="text-align: right;"><font color="green">+<?php echo number_format($this->getSalesDataByStation($station->stationID, 0),2) ?></font></td>
		</tr>
		</table>
</div>

</div>

<div class="mainRight">

<div class='currentstats' id='iskmovement' style="width:325px; float:right;">
		<table>
		<tr class="header1">
			<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon18_01.png" width="16" height="16">Text</div></td>
			<td style="text-align: right;">Profit</td>
		</tr>
		<tr>
			<td style="text-align: left;">Text</td>
			<td style="text-align: right;">Text</td>
		</tr>
		<tr class='odd'>
			<td style="text-align: left;">Text</td>
			<td style="text-align: right;">Text</td>
		<tr>
			<td style="text-align: left;">Text</td>
			<td style="text-align: right;">Text</td>
		</tr>
		</table>
</div>

</div>

<div style="clear: both;"></div>

<div class='currentstats'>
<?
$data = $this->arrayToHighchart($this->getMovementData($station->stationID,"sell"));
$data2 = $this->arrayToHighchart($this->getMovementData($station->stationID,"buy"));

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
		 array('name' => 'Sales', 'data' => 'js:'.$data),
		 array('name' => 'Purchases', 'data' => 'js:'.$data2),
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
			'series' => array('marker' => array('radius' => 3)),
			'spline' => array('enableMouseTracking' => 'js:false', 'marker' => array('enabled' => false))
		),
   )
));
?>
</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$stationTransactions,
	'itemView'=>'_view',
	'template'=>'{summary}{pager}{items}{pager}',
)); ?>