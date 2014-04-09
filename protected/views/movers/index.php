<?php
$this->breadcrumbs=array(
	'Movers',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left; width: 8px;">Rank</td>
		<td style="text-align: left;">Item</td>
		<td style="text-align: right; width: 70px;">30 Day Move</td>
		<td style="text-align: right; width: 70px;">30 Day Profit</td>
		<td style="text-align: right; width: 70px;">Profit/Unit</td>
				<?php
			$stations = TrackingStations::Model()->FindAll('trackingGroupID=:trackingGroupID', array(':trackingGroupID'=>Yii::app()->user->trackingGroupID));
			foreach ($stations as $station)
			{
				echo '<td style="text-align: left; width: 110px;"><a href="http://evemaps.dotlan.net/system/'.$station->solarSystemName.'">'.$station->solarSystemName.'</a></td>';
			}
		?>
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
				
				echo '<td style="text-align: right;">'.$i.'</td>';
				
				echo '<td><div class="textCenter"><img height="14" width="14" src="http://image.eveonline.com/Type/'.$icon.'"><a href="index.php?r=wallet/item&id='.$typeID.'">'.$name.'</a></div></td>';
				echo '<td style="text-align: right;">'.number_format($volume,0).'</td>';
				echo '<td style="text-align: right;"><font color="green">+'.number_format($profit,0).'</font></td>';
				echo '<td style="text-align: right;"><font color="green">+'.number_format($profit/$volume,0).'</font></td>';
				foreach ($stations as $station)
				{
						
					//get order data
					$orders = Orders::Model()->find('typeID=:typeID AND stationID=:stationID AND orderState = 0 AND charID IN ('.implode(',',$this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID)).')',array(':typeID'=>$typeID,':stationID'=>$station->stationID));
				
					if (empty($orders))
					{
						$orderText = "<font color='orange'>No Orders<font>";
					}
					else
					{
						$orderText = number_format($orders->volRemaining) . " / ". number_format($orders->volEntered);
					}
					echo "<td>$orderText</td>";
				}

				echo "</tr>";
			}
		?>
		</table>
		</div>	