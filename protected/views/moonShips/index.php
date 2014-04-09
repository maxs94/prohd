<?php
$this->breadcrumbs=array(
	'moonShips',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left; width: 8px;">Rank</td>
		<td style="text-align: left;">itemName</td>
		<td style="text-align: right; width: 70px;">Cadmium</td>
		<td style="text-align: right; width: 70px;">Caesium</td>
		<td style="text-align: right; width: 70px;">Chromium</td>
		<td style="text-align: right; width: 70px;">Cobalt</td>
		<td style="text-align: right; width: 70px;">Dysprosium</td>
		<td style="text-align: right; width: 70px;">Hafnium</td>
		<td style="text-align: right; width: 70px;">Mercury</td>
		</tr>

<?
$results = $this->getShipList();
foreach ($results as $item)
			{
				$i++;
				if ($i % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
				
				$name = $item['typeName'];
				$typeID = $item['typeID'];
				$icon = $this->getIcon($typeID);
				
				echo '<td style="text-align: right;">'.$i.'</td>';
				echo '<td><div class="textCenter"><img height="18" width="18" src="http://image.eveonline.com/Type/'.$icon.'"><a href="index.php?r=wallet/item&id='.$typeID.'">'.$name.'</a></div></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo '<td style="text-align: right;">'.$typeID.'</font></td>';
				echo "</tr>";
			}



?>
</table>
</div>	