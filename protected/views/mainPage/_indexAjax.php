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

$charbalances = CHtml::ajax(array(
	'url'=>'index.php?r=api/charbalances',
	'update'=>'#charbalances'
	));
Yii::app()->clientScript->registerScript('charbalances',$charbalances,CClientScript::POS_READY);
?>

	<div class="mainLeft">

		<div class="mcenter"><img src="images/icon18_01.png">ISK Movement</div>
		<div class='currentstats' id='iskmovement'>
		<table>
		<tr class="header1">
		<td></td>
		<td style="text-align: right;">Gross Income</td>
		<td style="text-align: right;">Total Taxes</td>
		<td style="text-align: right;">Broker Fees</td>
		</tr>
		<tr class='odd'>
		<td>30 Days</td>
		<td style="text-align: right;"><font color="green">+<?php echo $this->income(30); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->taxes(30); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->brokerFees(30); ?></font></td>
		</tr>
		<tr>
		<td>7 Days</td>
		<td style="text-align: right;"><font color="green">+<?php echo $this->income(7); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->taxes(7); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->brokerFees(7); ?></font></td>
		</tr>
		<tr class='odd'>
		<td>Today</td>
		<td style="text-align: right;"><font color="green">+<?php echo $this->income(0); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->taxes(0); ?></font></td>
		<td style="text-align: right;"><font color="red"><?php echo $this->brokerFees(0); ?></font></td>
		</tr>
		</table>
		</div>

		<div class="mcenter"><img src="images/icon07_16.png">Movers</div>
		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;">Item</td>
		<td style="text-align: left;">Orders</td>
		<td style="text-align: right;">Profit</td>
		</tr>

		<?php
		
			$topTenItems = $this->getTopTenByProfit();
			
			
			
			foreach ($topTenItems as $item)
			{
				$i++;
				if ($i % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
				
				$name = $item['typeName'];
				$volume = $item['totalVolume'];
				$profit = $item['totalProfit'];
				$typeID = $item['typeID'];
				$icon = $this->getIcon($typeID);
				
				
				//get order data
				$orders = Orders::Model()->find('typeID=:typeID AND orderState = 0 AND charID IN ('.implode(',',$this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID)).')',array(':typeID'=>$typeID));
				
				if (empty($orders))
				{
					$orderText = "No Orders";
				}
				else
				{
					$orderText = number_format($orders->volRemaining) . "/". number_format($orders->volEntered) . " (" . floor(($orders->volRemaining/$orders->volEntered) * 100) . "%)";
				}
				
				echo '<td><div class="textCenter"><img height="16" width="16" src="./images/items/'.$icon.'"><a href="index.php?r=wallet/item&id='.$typeID.'">'.$name.'</a></div></td>';
				echo "<td>$orderText</td>";
				echo '<td style="text-align: right;"><font color="green">+'.number_format($profit,0).'</font></td>';
				echo "</tr>";
			}
		?>
		</table>
		</div>	
		
	</div>

	<div class="mainRight">
		<div class="mcenter"><img src="images/icon57_12.png">API</div>
		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"></td>
		<td style="text-align: left;">Status</td>
		</tr>
		<tr class='odd'>
		<td>EVE Server</td>
		<td id='evestatus'>Please wait...</td>
		</tr>
		<tr>
		<td>Transactions</td>
		<td id='transcache'>Please wait...</td>
		</tr>
		<tr class='odd'>
		<td>Market Orders</td>
		<td id='ordercache'>Please wait...</td>
		</tr>
		<tr>
		<td>Wallet Journal</td>
		<td id='journalcache'>Please wait...</td>
		</tr>
		</table>
		</div>
		
		<div class="mcenter"><img src="images/icon02_16.png">Characters</div>
		<div class="currentstats" id='charbalances'>
		Please wait...
		</div>
		
		<div class="mcenter"><img src="images/icon25_08.png">Profit</div>
		<div class="currentstats">
		<table>
		<tr>
		<td>
		
		<!--
		<img src="http://chart.apis.google.com/chart
		?cht=lc
		&chs=375x200
		&chm=o,0066FF,0,-1,6
		&chxt=x,y
		&chxr=0,30,0|1,0,250
		&chds=0,250,0,30
		&chg=33,20,2,2
		&chco=0077CC
		&chd=t:">
		-->
		<?php 
		
		$data = $this->getProfitData(30);
		
		$this->Widget('ext.highcharts.HighchartsWidget', array(
		   'options'=>array(
			  'chart' => array('marginLeft' => 32, 'marginRight' => 4, 'marginBottom' => 16, 'height' => 300),
			  'title' => array('text' => 'Daily Profit (M)'),
			  'xAxis' => array(
				 'title' => array('text' => 'js:null'),
				 'type' => 'datetime',
			  ),
			  'yAxis' => array(
				 'title' => array('text' => 'Profit'),
				 'min' => 'js:0',
				 'minorTickInterval' => 'js:10',
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
				   this.y +'M ISK Profit';
				}"
			  )
		   )
		));
		?>
		</td>
		</tr>
		</table>
		</div>
		
	</div>	
</div>
