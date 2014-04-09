<?php
$this->breadcrumbs=array(
	'POS',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left; width: 20px;">Tower</td>
<td style="text-align: left; width: 125px;">Size</td>
<td style="text-align: left; width: 70px;">Location</td>
<td style="text-align: left; width: 70px;">Moon</td>
<td style="text-align: left; width: 200px;">Fuel Contents</td>
<td style="text-align: left; width: 150px;">Fuel Level</td>

<?
$index=0;

$towers = $this->getPOS();

foreach ($towers as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		
		$icon = $this->getIcon($row['typeID']);
		$fuelItem = $this->getFuelLevel($row['typeID'],$row['itemID']);
		
		echo "<td><img style='height: 32; width: 32px;' src='http://image.eveonline.com/Type/$icon'></td>";
		echo "<td style='text-align: left;'>".$row['typeName']."</td>";
		echo "<td style='text-align: left;'>".$row['locationName']."</td>";
		echo "<td style='text-align: left;'>Moon Name</td>";
		echo "<td style='text-align: left;'>";
		foreach ($fuelItem as $row1)
			{
			$icon = $this->getIcon($row1['typeID']);
			echo "<div class='textCenter'><img style='height: 16; width: 16px;' src='http://image.eveonline.com/Type/$icon'>".$row1['typeName']." - ".number_format($row1['quantity'],0)."</div>";
			}
		echo "</td>";
		
		$diff = $this->calcFuelLevel();
		echo "<td style='text-align: right;'><div class='progress-container'><div style='width: ".$diff."%'>".$diff."%</div></div></td>";
	$index++;
	}
?>


</tr>
</table>
</div>