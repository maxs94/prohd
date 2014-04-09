<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$item->typeName,
);

$this->menu=array(
	array('label'=>'Create Transactions', 'url'=>array('create')),
	array('label'=>'Manage Transactions', 'url'=>array('admin')),
);

?>
<div style="float: right; margin-bottom:10px;">Search: 
<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name'=>'item',
    'sourceUrl'=>'index.php?r=wallet/search',
    // additional javascript options for the autocomplete plugin
    'options'=>array(
        'minLength'=>'3',
		'select'=>'js:
			function (event, ui)
			{
				window.location = "index.php?r=wallet/item&id=" + ui.item.id;
			}',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px; width: 250px;'
    ),
));
echo "</div><div class='clear'></div>";

?>
<h1><?php echo "<div class='textCenter'><img style='height: 32px; width: 32px;' src='http://image.eveonline.com/Type/".$item->typeID."_32.png'>".$item->typeName;?></div></h1>
<?php
$selldata = $this->getItemHistoricalData($item->typeID);
$buydata = $this->getItemHistoricalData($item->typeID,'buy');

$selldataavg = $this->arrayToHighchart($this->calcMovingAverage($this->getItemAvgData($item->typeID),20));
$buydataavg = $this->arrayToHighchart($this->calcMovingAverage($this->getItemAvgData($item->typeID,'buy'),20));
?>

<div class="mainHalfLeft">

<div class="currentstats" style="width:340px;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/6_64_3.png" width="16" height="16">Item Stats</div></td>
	<td style="text-align: right; width: 150px;"></td>
	</tr>
	
	<tr>
	<td style="text-align: left;">Last Purchase</td>
	<td style="text-align: right;"><?php echo number_format($this->lastJitaPrice($item->typeID),2); ?></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;">Last Sale</td>
	<td style="text-align: right;"><?php echo number_format($this->lastNullPrice($item->typeID),2); ?></td>
	</tr>
	
	<tr>
	<td style="text-align: left;">Difference</td>
	<td style="text-align: right;"><font color="green">+<?php echo number_format($this->lastNullPrice($item->typeID) - $this->lastJitaPrice($item->typeID),2); ?></font></td>
	</tr>
	
	<tr  class='odd'>
	<td style="text-align: left;">Profit</td>
	<td style="text-align: right;"><?php echo number_format((1 - ($this->lastJitaPrice($item->typeID)/$this->lastNullPrice($item->typeID))) * 100,2); ?>%</td>
	</tr>
	
	<tr>
	<td style="text-align: left;">Item m3</td>
	<td style="text-align: right;"><?php echo number_format($this->itemVolume($item->typeID),0); ?></td>
	</tr>
	
	<tr  class='odd'>
	<td style="text-align: left;">Profit / m3</td>
	<td style="text-align: right;"><?php echo number_format(($this->lastNullPrice($item->typeID) - $this->lastJitaPrice($item->typeID)) / $this->itemVolume($item->typeID),2); ?></td>
	</tr>
	
	</table>
</div>

</div>

<div class="mainHalfRight">

<div class="currentstats" style="width:340px;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/25_64_8.png" width="16" height="16">Volume Stats</div></td>
	<td style="text-align: right; width: 150px;"></td>
	</tr>
	
	<tr>
	<td style="text-align: left;">Sold Total</td>
	<td style="text-align: right;"><?php echo number_format($this->soldTotal($item->typeID),0); ?></td>
	</tr>
	
	<tr class='odd'>
	<td style="text-align: left;">Profit Total</td>
	<td style="text-align: right;"><font color="green">+<?php echo number_format($this->profitTotal($item->typeID),2); ?></font></td>
	</tr>

	<tr>
	<td style="text-align: left;">Sold 30 Days</td>
	<td style="text-align: right;"><?php echo number_format($this->soldCount($item->typeID,30),0); ?></td>
	</tr>
	
	<tr class='odd'>
	<td style="text-align: left;">Sold 7 Days</td>
	<td style="text-align: right;"><?php echo number_format($this->soldCount($item->typeID,7),0); ?></td>
	</tr>
	
	<tr>
	<td style="text-align: left;">30 Day Profit Projection</td>
	<td style="text-align: right;"><font color="green">+<?php echo number_format($this->soldCount($item->typeID,30) * ($this->lastNullPrice($item->typeID) - $this->lastJitaPrice($item->typeID)),2); ?></font></td>
	</tr>
	
	<tr class='odd'>
	<td style="text-align: left;">7 Day Profit Projection</td>
	<td style="text-align: right;"><font color="green">+<?php echo number_format($this->soldCount($item->typeID,7) * ($this->lastNullPrice($item->typeID) - $this->lastJitaPrice($item->typeID)),2); ?></font></td>
	</tr>
	
	</table>
</div>

</div>

<div style="clear: both;"></div>

<div class='currentstats'>
<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('height' => 300, 'zoomType' => 'x'),
	  'title' => array('text' => 'Historical Sales Data'),
	  'xAxis' => array(
		 'title' => array('text' => 'js:null'),
		 'type' => 'datetime',
		 'maxZoom' => (7 * 24 * 3600000),
	  ),
	  'yAxis' => array(
		 'title' => array('text' => 'js:null'),
		 //'min' => 'js:0',
		 'minorTickInterval' => 'auto',
		 'labels' => array(
			 'formatter' => "js:
			function() {
			   return Highcharts.numberFormat(this.value, 0);
			}",
		  )
	  ),
	  'series' => array(
		 array('name' => 'Sales', 'type'=>'scatter', 'data' => 'js:'.$selldata),
		 array('name' => 'Purchases', 'type'=>'scatter', 'data' => 'js:'.$buydata),
		 //array('name' => 'Sales Average', 'type'=>'spline', 'data' => 'js:'.$selldataavg),
		 //array('name' => 'Purchases Average', 'type'=>'spline', 'data' => 'js:'.$buydataavg),
	  ),
	  'credits' => array('enabled' => false),
	  'exporting' => array('enabled' => false),
	  'tooltip' => array('formatter' => "js:
		function() {
		   return '<b>'+ Highcharts.dateFormat('%b %e, %Y', this.x) +'</b><br/>'+
		   Highcharts.numberFormat(this.y, 2) +' ISK';
		}"
	  ),
	   'plotOptions' => 
		array(
			//'series' => array('series' => array('marker' => array('radius' => 3))),
			'scatter' => array('marker' => array('radius' => 3)),
			'spline' => array('enableMouseTracking' => 'js:false', 'marker' => array('enabled' => false))
		),
   )
));
?></div>

<h3>Sales</h3>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$salesTransactions,
	'itemView'=>'_view',
	'template'=>'{summary}{items}{pager}',
)); ?>

<h3>Purchases</h3>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$purchaseTransactions,
	'itemView'=>'_view',
	'template'=>'{summary}{items}{pager}',
)); ?>