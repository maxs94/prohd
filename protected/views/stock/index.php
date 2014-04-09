<?php
$this->breadcrumbs=array(
	'Stock',
);?>
<hr>

<div style="width: 49%; float: left; padding: 2px;">

<?php

$groups = $this->stockGroups();
$groupNames = array_keys($groups);
$totalGroups = count($groups);
$totalGroupRows = $totalGroups + count($groups,1);
$i = 0;
$firstRow = 1;
$names = 0;
foreach ($groups as $group)
{
	$i = $i + 2;
	//Go to the next column div if this group number is more than half the number of groups
	if (($i >= ($totalGroupRows/2)) && ($firstRow == 1))
	{
		echo "</div><div style='width: 50%; float: left; padding: 2px;'>\n";
		$firstRow = 0;
	}
	
	//Groupname header
	echo "<div class='mcenter'>$groupNames[$names]</div>\n";
	echo "<div class='currentstats'><table>\n";
	echo "<tr>\n";
	echo "<td class='header1'>Item</td>\n";
	#echo "<td class='header1'>Orders</td>\n";
	echo "<td class='header1'>Volume</td>\n";
	echo "<td style='text-align: right;' class='header1'>Profit</td>\n";
	echo "<td style='text-align: right;' class='header1'>Profit/Unit</td>\n";
	echo "</tr>\n";

	$names++;	
	$j = 0;
	//Loop through the items
	foreach ($group as $item)
	{
		$i++;
		$j++;
		if ($j % 2)
			echo "<tr class='odd'>\n";
		else
			echo "<tr>\n";
			
		//Get the item details
		$itemDetails = Invtypes::Model()->findByPk($item);
		
		//Get some order information
		$orders = Orders::Model()->find('typeID=:typeID AND orderState = 0',array(':typeID'=>$item));
		
		if (empty($orders))
		{
			$orderText = "<font color='#FFA824'>No Orders</font>";
		}
		else
		{
			$orderText = number_format($orders->volRemaining) . "/". number_format($orders->volEntered) . " (" . floor(($orders->volRemaining/$orders->volEntered) * 100) . "%)";
		}
		
		//Get profit, volume, and icon information
		$details = $this->getProfitDetails($item);
		$detailsRow = $details->read();
		$profit = number_format($detailsRow['totalProfit']);
		$volume = number_format($detailsRow['totalVolume']);
		$perUnit = number_format($detailsRow['totalProfit']/$detailsRow['totalVolume'],0);
		
		$color = $this->numToColor($profit);
		$icon = $this->getIcon($itemDetails->typeID);
		
		echo "<td><div class='textCenter'><img height='16' width='16' src='http://image.eveonline.com/Type/$icon'> <a href='index.php?r=wallet/item&id=$itemDetails->typeID'>$itemDetails->typeName</a></div></td>\n";
		#echo "<td><div class='textCenter'><img height='16' width='16' src='images/items/$icon'>$itemDetails->typeName</div></td>\n";
		#echo "<td>$orderText</td>\n";
		echo "<td>$volume</td>\n";
		echo "<td style='text-align: right; color: $color;'>$profit</td>\n";
		echo "<td style='text-align: right;'>$perUnit</td>\n";
		echo "</tr>";
	}
	
	echo "</table></div>\n";
	
}
?>
</div>
