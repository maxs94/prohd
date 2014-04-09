<?php
$this->breadcrumbs=array(
	'Minerals',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<h1>Minerals - <?php echo $group->name; ?></h1>
<hr>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left; width: 70px;">Minerals</td>
<td style="text-align: right; width: 40px;">Last Null</td>
<td style="text-align: right; width: 60px;">Null Volume</td>
<td style="text-align: right; width: 60px;">Null Value</td>
<td style="text-align: right; width: 40px;">Last Jita</td>
<td style="text-align: right; width: 60px;">Jita Volume</td>
<td style="text-align: right; width: 60px;">Jita Value</td>
<td style="text-align: right; width: 40px;">Difference</td>
<td style="text-align: left; width: 150px;">% Difference</td>
</tr>

<?
$index=0;

$mineralInfo = new CDbCriteria;
$mineralInfo->condition = 'groupID=18 AND published=1 ';
$minerals = Invtypes::Model()->findAll($mineralInfo);


foreach ($minerals as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		
		$icon = $this->getIcon($row->typeID);
		
		$lastNullPrice = $this->lastNullPrice($row->typeID);
		$lastJitaPrice = $this->lastJitaPrice($row->typeID);
		$lastJitaVolume = $this->lastJitaVolume($row->typeID,30);
		$lastNullVolume = $this->lastNullVolume($row->typeID,30);	
		
		
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/$icon'><a href='index.php?r=wallet/item&id=$row->typeID'>$row->typeName</div></td>";
		echo "<td style='text-align: right;'><font color='red'>".number_format($lastNullPrice,2)."</font></td>";
		echo "<td style='text-align: right;'><font color='red'>".number_format($lastNullVolume,0)."</font></td>";
		echo "<td style='text-align: right;'><font color='red'>".number_format($lastNullPrice*$lastNullVolume,0)."</font></td>";
		echo "<td style='text-align: right;'><font color='green'>".number_format($lastJitaPrice,2)."</font></td>";
		echo "<td style='text-align: right;'><font color='green'>".number_format($lastJitaVolume,0)."</font></td>";
		echo "<td style='text-align: right;'><font color='green'>".number_format($lastJitaPrice*$lastJitaVolume,0)."</font></td>";
		echo "<td style='text-align: right;'>".number_format($lastJitaPrice - $lastNullPrice,2)."</td>";

		$diff = (100-($lastNullPrice/$lastJitaPrice)*100);

		echo "<td><div class='progress-container'><div style='width:$diff%'>".number_format($diff,0)."%</div></div></td>";
		echo "</tr>";

	$index++;
	}
?>

<? /*
$data = $this->mineralLowendVolumeArray();
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('height' => 300, 'zoomType' => 'x'),
	  'title' => array('text' => 'Lowend Volume'),
	  'xAxis' => array(
		 'title' => array('text' => 'js:null'),
		 'type' => 'column',
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
		'xAxis' => array(
			'categories' => array('Tritanium','Pyerite','Mexallon','Isogen'),
	  ),
	  'series' => array(
		 array('name' => 'Volume', 'type'=>'column', 'data' => 'js:'.$data),
	  ),
	  'credits' => array('enabled' => false),
	  'exporting' => array('enabled' => false),
	  'tooltip' => array('formatter' => "js:
		function() {
		   return '<b>'+ this.x +'</b><br/>'+
		   Highcharts.numberFormat(this.y, 0) +' M';
		}"
	  ),
	  'plotOptions' => 
		array(
			'column' => array('pointPadding' => 0.2),
		),
	  'legend' => 
		array(
			'enabled' => false,
		),
   )
));
?>

<?
$data = $this->mineralHighendVolumeArray();
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('height' => 300, 'zoomType' => 'x'),
	  'title' => array('text' => 'Highend Volume'),
	  'xAxis' => array(
		 'title' => array('text' => 'js:null'),
		 'type' => 'column',
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
		'xAxis' => array(
			'categories' => array('Nocxium','Zydrine','Megacyte','Morphite'),
	  ),
	  'series' => array(
		 array('name' => 'Volume', 'type'=>'column', 'data' => 'js:'.$data),
	  ),
	  'credits' => array('enabled' => false),
	  'exporting' => array('enabled' => false),
	  'tooltip' => array('formatter' => "js:
		function() {
		   return '<b>'+ this.x +'</b><br/>'+
		   Highcharts.numberFormat(this.y, 0) +' M';
		}"
	  ),
	  'plotOptions' => 
		array(
			'column' => array('pointPadding' => 0.2),
		),
	  'legend' => 
		array(
			'enabled' => false,
		),
   )
));
*/?>

</tr>
</table>
</div>