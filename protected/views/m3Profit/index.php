<?php
$this->breadcrumbs=array(
	'm3 Profit',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left; width: 8px;">Rank</td>
		<td style="text-align: left;">Item</td>
		<?php
			$stations = TrackingStations::Model()->FindAll('trackingGroupID=:trackingGroupID', array(':trackingGroupID'=>Yii::app()->user->trackingGroupID));
			foreach ($stations as $station)
			{
				echo '<td style="text-align: left; width: 100px;"><a href="http://evemaps.dotlan.net/system/'.$station->solarSystemName.'">'.$station->solarSystemName.'</a></td>';
			}
		?>
		<td style="text-align: right; width: 70px;">Quantity</td>
		<td style="text-align: right; width: 70px;">Volume</td>
		<td style="text-align: right; width: 70px;">Weight</td>
		</tr>

		<?php
		
			$topItems = $this->getm3Profit();
			
			foreach ($topItems as $item)
			{
				$i++;
				if ($i % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
				
				$name = $item['typeName'];
				$quantity = $item['totalQuantity'];
				$volume = $item['volume'];
				$weight = $item['ticketWeight'];
				$typeID = $item['typeID'];
				$icon = $this->getIcon($typeID);
				
				echo '<td style="text-align: right;">'.$i.'</td>';
				
				echo '<td><div class="textCenter"><img height="18" width="18" src="http://image.eveonline.com/Type/'.$icon.'"><a href="index.php?r=wallet/item&id='.$typeID.'">'.$name.'</a></div></td>';
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
				echo '<td style="text-align: right;">'.number_format($quantity,0).'</td>';
				echo '<td style="text-align: right;">'.number_format($volume,2).'</td>';
				echo '<td style="text-align: right;"><font color="green">+'.number_format($weight,2).'</font></td>';
				echo "</tr>";
			}
		?>
		</table>
		</div>	