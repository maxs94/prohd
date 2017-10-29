<?php
$this->breadcrumbs=array(
	'Overview',
);

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);
$allMembers =  Characters::Model()->findAll(); // Find all members
	foreach ($allMembers as $member)
	{
		$allMembersArray[] = $member->characterID;
	}
$allMembersString = "(".implode($allMembersArray,',').")";

$journalInterface = new APIJournal;

if (!($journalInterface->getCacheExpiration($groupMembers[0]->characterID)))
{
	?>
		<script type="text/javascript">
			$(function() {
				$.gritter.add({
					title: 'Updating API',
					text: 'Your journal is being updated...',
					time: 4000,
					image: '<?php echo Yii::app()->request->baseUrl; ?>/images/repeat-icon.png'
				});
			});
		</script>
	<?
	$updatejournal = CHtml::ajax(array(
		'url'=>'index.php?r=mainPage/updatejournal',
		'success'=>'js:function(){
			$.gritter.add({
				title: "Update Complete",
				text: "You may refresh the page.",
				time: 4000,
				image: "'.Yii::app()->request->baseUrl.'/images/repeat-icon.png"
			});
		}'
	));
	
	Yii::app()->clientScript->registerScript('updatejournal',$updatejournal,CClientScript::POS_READY);
}
?>
<?php # echo $group->name; ?>
<hr>
<?php
//Big hunk of ajax updates
$evestatus = CHtml::ajax(array(
	'url'=>'index.php?r=api/online',
	'update'=>'#evestatus'
	));
	
Yii::app()->clientScript->registerScript('evestatus',$evestatus,CClientScript::POS_READY);

$transcache = CHtml::ajax(array(
	'url'=>'index.php?r=api/checkcache&charID='.$groupMembers[0]->characterID.'&apiObject=APITransactions',
	'update'=>'#transcache'
	));
	
Yii::app()->clientScript->registerScript('transcache',$transcache,CClientScript::POS_READY);

$ordercache = CHtml::ajax(array(
	'url'=>'index.php?r=api/checkcache&charID='.$groupMembers[0]->characterID.'&apiObject=APIOrders',
	'update'=>'#ordercache'
	));
	
Yii::app()->clientScript->registerScript('ordercache',$ordercache,CClientScript::POS_READY);

$journalcache = CHtml::ajax(array(
	'url'=>'index.php?r=api/checkcache&charID='.$groupMembers[0]->characterID.'&apiObject=APIJournal',
	'update'=>'#journalcache'
	));
	
Yii::app()->clientScript->registerScript('journalcache',$journalcache,CClientScript::POS_READY);
	
$industrycache = CHtml::ajax(array(
	'url'=>'index.php?r=api/checkcache&charID='.$groupMembers[0]->characterID.'&apiObject=APIIndustryJobs',
	'update'=>'#industrycache'
	));
	
Yii::app()->clientScript->registerScript('industrycache',$industrycache,CClientScript::POS_READY);

$assetscache = CHtml::ajax(array(
	'url'=>'index.php?r=api/checkcache&charID='.$groupMembers[0]->characterID.'&apiObject=APIAssetList',
	'update'=>'#assetscache'
	));
	
Yii::app()->clientScript->registerScript('assetscache',$assetscache,CClientScript::POS_READY);

$charbalances = CHtml::ajax(array(
	'url'=>'index.php?r=api/charbalances',
	'update'=>'#charbalances'
	));
Yii::app()->clientScript->registerScript('charbalances',$charbalances,CClientScript::POS_READY);

$then = microtime(true);
$profitArray = $this->getProfitData(30);

$revProfit = array_reverse($profitArray);
$i=0;
foreach ($revProfit as $row)
{
	$i++;
	if ($i <= 1)
	{
		$todaysProfit = $row[1];
	}
	if ($i <= 7)
	{
		$sevenDayProfit = $sevenDayProfit + $row[1];
	}
	$thirtyDayProfit = $thirtyDayProfit + $row[1];
}
#$now = microtime(true);
#$time = $now - $then;
#echo "PROFIT TIME: $time"; DEBUG
?>

<div class="mainLeft">

		<div class='currentstats' id='iskmovement'>
		<table>
		<tr class="header1">
		<td><div class='textCenter'><img src="images/items/18_128_1.png" width="16" height="16"></div></td>
		<td style="text-align: right;">Profit (M)</td>
		<td style="text-align: right;">M/Hour</td>
		<td style="text-align: right;">Gross Income</td>
		<td style="text-align: right;">Total Taxes</td>
		<td style="text-align: right;">Broker Fees</td>
		</tr>
		<tr>
		<td>30 Days</td>
		<td style="text-align: right;"><font color="green">+<?php echo number_format($thirtyDayProfit,0); ?></font></td>
		<td style="text-align: right;"><font color="green">+<?php echo number_format($thirtyDayProfit/(24*30),1); ?></font></td>
		<td style="text-align: right;"><font color="green">+<?php echo $this->income(30); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->taxes(30); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->brokerFees(30); ?></font></td>
		</tr>
		<tr class='odd'>
		<td>7 Days</td>
		<td style="text-align: right;"><font color="green">+<?php echo number_format($sevenDayProfit,0); ?></font></td>
		<td style="text-align: right;"><font color="green">+<?php echo number_format($sevenDayProfit/(24*7),1); ?></font></td>
		<td style="text-align: right;"><font color="green">+<?php echo $this->income(7); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->taxes(7); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->brokerFees(7); ?></font></td>
		</tr>
		<tr>
		<td>Today</td>
		<td style="text-align: right;"><font color="green">+<?php echo number_format($todaysProfit,0); ?></font></td>
		<td style="text-align: right;"><font color="green">+<?php echo number_format($todaysProfit/(24),1); ?></font></td>
		<td style="text-align: right;"><font color="green">+<?php echo $this->income(0); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->taxes(0); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->brokerFees(0); ?></font></td>
		</tr>
		</table>
		</div>
		
		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/18_128_2.png" width="16" height="16">Next 10 Industry Jobs</div></td>
		<td style="text-align: right; width: 80px;">End</td>
		<td style="text-align: right; width: 100px;">Progress</td>
		</tr>

		<?php

		$criteria = new CDbCriteria;
		$criteria->condition = 'completed = 0 AND installerID IN '.$allMembersString.'';
		$criteria->order = 'endProductionTime ASC LIMIT 10';

		$results = IndustryJobs::Model()->findAll($criteria);
			foreach ($results as $row)
			{
				if ($index % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
												
				$itemInfo = new CDbCriteria;
				$itemInfo->condition = 'typeID=:typeID';
				$itemInfo->params = array(':typeID'=>$row->outputTypeID);
				$itemName = Invtypes::Model()->find($itemInfo);

				$dateEnd = $row->endProductionTime;
				$dateBegin = $row->beginProductionTime;
				//$dateNow = date('Y-m-d H:i:s', strtotime("+4 hour"));
				$dateNow = date('Y-m-d H:i:s', $this->getEveTime());
				
				$diff = 100 - ((strtotime($dateEnd) - strtotime($dateNow)) / (strtotime($dateEnd) - strtotime($dateBegin))) * 100;
				$diff = number_format($diff, 1, '.', '');
				if ($diff < 0) // Handle case where job is pending
					{
					$diff = 0;
					}
				if ($diff > 100) // Handle case where job is completed
					{
					$diff = 100;
					}
				$dateEnd = date("m-d H:i",strtotime($dateEnd));
				$icon = $this->getIcon($row->outputTypeID);
					
				echo "<td><div class='textCenter'><img style='height: 16px; width: 16px;' src='http://image.eveonline.com/Type/$icon'>+$row->runs <a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		
				echo "<td style='text-align: right;'>$dateEnd</td>";
				echo "<td style='text-align: right;'><div class='progress-container-main'><div style='width: $diff%'>$diff%</div></div></td>";
				echo "</tr>";
			$index++;
			}
		?>
		</tr>
		</table>
		</div>
		
		
		<div class="currentstats">
		<table>
		<tr>
		<td>
		
		<?php 
		$data = $this->arrayToHighchart($profitArray);
		$this->Widget('ext.highcharts.HighchartsWidget', array(
		   'options'=>array(
			  'chart' => array('marginLeft' => 38, 'marginRight' => 4, 'marginBottom' => 16, 'height' => 250),
			  'title' => array('text' => 'Daily Profit (M)'),
			  'xAxis' => array(
				 'title' => array('text' => 'js:null'),
				 'type' => 'datetime',
			  ),
			  'yAxis' => array(
				 'title' => array('text' => 'Profit'),
				 'min' => 'js:0',
				 'minorTickInterval' => 'auto',
			  ),
			  'series' => array(
				 array('showInLegend' => 'js:false', 'name' => 'Daily Profit', 'data' => 'js:'.$data),
			  ),
			  'credits' => array('enabled' => false),
			  'exporting' => array('enabled' => false),
			  'legend' => array('enabled' => false),
			  'tooltip' => array('formatter' => "js:
				function() {
                   return '<b>'+ Highcharts.dateFormat('%b %e, %Y', this.x) +'</b><br/>'+
				   this.y +' M Profit';
				}"
			  ),
			  'plotOptions' => array(
				'series' => array(
					'lineWidth' => 2,
					'marker' => array('radius' => 3)
				)
			  )
		   )
		));
		?>
		</td>
		</tr>
		</table>
		</div>
		
		<div class="currentstats">
		<table>
		<tr>
		<td>
		
		<?php
		$netAssetValue = number_format($this->getNetAssetValue(),2);
		$orderValue = number_format($this->getOrderValue(),2);
		$blueprintValue = number_format($this->getBlueprintValue(),2);
		$totalBalance = number_format($this->getTotalBalance() / 1000000000,2);
		$totalManufacturing = 0.0; // Taken out of pie chart for now until we calc $ from actual manufacturing jobs
		$totalCorpAssets = number_format($this->getCorpAssetValue(),2);
		//$totalCorpAssets = 0;
		$totalCorpBalance = 0;
		$constructionValue = 20;
		$RISCValue = 19;
		
		//Total
		$totalNetValue = ($netAssetValue + $orderValue + $blueprintValue + $totalBalance + $totalManufacturing + $totalCorpAssets + $totalCorpBalance + $constructionValue + $RISCValue);
		
		$this->Widget('ext.highcharts.HighchartsWidget', array(
			'options'=>array(
				'chart'=>array(
					'defaultSeriesType' => 'pie', 'height' => 300,
				),
				'title' => array('text' => 'Net Value '.$totalNetValue.' (B)'),
				'series' => array(
					array('data' => 'js: [["Personal ISK",'.$totalBalance.'],["Personal Assets",'.$netAssetValue.'],["Corp Assets",'.$totalCorpAssets.'],["Orders",'.$orderValue.'],["BPO",'.$blueprintValue.'],["Construction",'.$constructionValue.'],["RISC",'.$RISCValue.']]')
				),
				'plotOptions' => array(
					'pie' => array(
						'allowPointSelect' => true,
						'cursor' => 'pointer',
						'dataLabels' => array(
							'enabled' => true,
							'distance' => 14,
							'connectorColor' => 'black',
							'formatter' => "js:
								function() {
								return '<b>'+ this.point.name +'</b>: '+ this.y +'';
								}"
						),
					),
				),
				'credits' => array('enabled' => false),
			    'exporting' => array('enabled' => false),
				'legend' => array('enabled' => true),
				'tooltip' => array(
							'formatter' => "js:
							function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +'';
							}"
				),
			)
		));
		?>
		</td>
		</tr>
		</table>
		</div>
		
</div>
	
	
<div class="mainRight">
		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_12.png" width="16" height="16">API</div></td>
		<td style="text-align: left;">Status</td>
		</tr>
		<tr>
		<td>EVE Server</td>
		<td id='evestatus'>Please wait...</td>
		</tr>
		<tr class='odd'>
		<td>Transactions</td>
		<td id='transcache'>Please wait...</td>
		</tr>
		<tr>
		<td>Market Orders</td>
		<td id='ordercache'>Please wait...</td>
		</tr>
		<tr class='odd'>
		<td>Wallet Journal</td>
		<td id='journalcache'>Please wait...</td>
		</tr>
		<tr>
		<td>Industry Jobs</td>
		<td id='industrycache'>Please wait...</td>
		</tr>
		<tr class='odd'>
		<td>Personal Assets</td>
		<td id='assetscache'>Please wait...</td>
		</tr>
		</table>
		</div>

		
		<div class="currentstats" id='charbalances'>
		Please wait...<img src='./images/load.gif'>
		</div>	
		
		
		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/7_64_16.png" width="16" height="16">Last 25 Sales</div></td>
		<td style="text-align: right;">Price</td>
		<td style="text-align: right;">Profit</td>
		</tr>
		<?php
			$i=0;
			$topItems = $this->getLastSales();
			foreach ($topItems as $item)
			{
				if ($i % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
				
				$quantity = $item['quantity'];
				$name = $item['typeName'];
				$profit = $item['profit'];
				$price = $item['price'];
				$typeID = $item['typeID'];
				$icon = $this->getIcon($typeID);
				
				echo '<td><div class="textCenter"><img height="16" width="16" src="http://image.eveonline.com/Type/'.$icon.'">'.number_format($quantity,0).' x <a href="index.php?r=wallet/item&id='.$typeID.'">'.$name.'</a></div></td>';
				echo '<td style="text-align: right;">'.number_format($price,2).'</td>';
				echo '<td style="text-align: right;"><font color="green">+'.number_format($profit,0).'</font></td>';
				echo "</tr>";
				$i++;
			}
		?>
		</table>
		</div>
		
		
		
</div>