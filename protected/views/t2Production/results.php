<?
foreach ($results as $reqSet)
{
	foreach ($reqSet as $row)
	{
		if (!($row['categoryID'] == 16))
		{
			$typeID = $row['requiredTypeID'];
			$totalReqs[$typeID]['typeName'] = $row['typeName'];
			$totalReqs[$typeID]['typeID'] = $typeID;
			if ($row['wasted'])
			{
				$totalReqs[$typeID]['quantity'] += round($row['quantity'] + ($row['quantity'] * ($row['wasteFactor'] / 100) * 5)) * $row['runs'];
			}
			else
			{
				if ($row['groupID'] == 332)
				{
					$totalReqs[$typeID]['quantity'] += $row['quantity'] * $row['damagePerJob'] * $row['runs'];
				}
				else
				{
					$totalReqs[$typeID]['quantity'] += $row['quantity'] * $row['runs'];
				}
				
			}
			if ($row['groupID'] == 332)
			{
				$totalReqs[$typeID]['ram'] = true;
			}
			else
			{
				$totalReqs[$typeID]['ram'] = false;
			}
		}
	}
}
?>

<table>
	<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_11.png" width="16" height="16">Materials</div></td>
		<td style='text-align: right;'>Required</td>
		<td style='text-align: right;'>Stock</td>
		<td style='text-align: right;'>Needed</td>
		<td style="text-align: right;">Materials Cost</td>
	</tr>
<?
foreach ($totalReqs as $requirement)
{
	if (!($requirement['ram']))
	{
		$lastJita = $this->lastJitaPrice($requirement['typeID']);
		$totalCost = $requirement['quantity'] * $lastJita;
		$finalPrice += $totalCost;
		$quantity = $requirement['quantity'];
		$stock = $this->getStock($requirement['typeID']);
		
		$needed = $stock - $quantity;
			if ($needed > 0)
			{
			$needed = 0;
			}
		
		if ($i % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/{$requirement['typeID']}_32.png'><a href='index.php?r=wallet/item&id={$requirement['typeID']}'>{$requirement['typeName']}</div></td>";
		echo "<td style='text-align: right;'>".number_format($quantity,0)."</td>";
		echo "<td style='text-align: right;'>".number_format($stock,0)."</td>";
		echo "<td style='text-align: right;'>".number_format($needed,0)."</td>";
		echo "<td style='text-align: right;'>".number_format($totalCost,2)."</td>";
		echo "</tr>";
		
		$i++;
	}
}
?>
</table>
<table>
	<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_11.png" width="16" height="16">R.A.M. Components</div></td>
		<td style='text-align: right;'>Required</td>
		<td style='text-align: right;'>Consumed</td>
		<td style='text-align: right;'>Stock</td>
		<td style='text-align: right;'>Needed</td>
		<td style="text-align: right;">R.A.M Cost</td>
	</tr>
<?
$i = 0;
foreach ($totalReqs as $requirement)
{
	if ($requirement['ram'])
	{
		$lastJita = $this->lastJitaPrice($requirement['typeID']);
		$totalCost = ceil($requirement['quantity']) * $lastJita;
		$finalPrice += $totalCost;
		$quantity = $requirement['quantity'];
		$stock = $this->getStock($requirement['typeID']);
		
		if ($i % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		$required = ceil($requirement['quantity']);
		
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/{$requirement['typeID']}_32.png'><a href='index.php?r=wallet/item&id={$requirement['typeID']}'>{$requirement['typeName']}</div></td>";
		echo "<td style='text-align: right;'>{$required}</td>";
		echo "<td style='text-align: right;'>{$requirement['quantity']}</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td style='text-align: right;'>".number_format($totalCost,2)."</td>";
		echo "</tr>";
		$i++;
	}
}
?>
</table>
<table>
	<tr>
		<td style="width: 750px;"></td>
		<td style="text-align: right;"><div class='totalBorder'><B><? echo number_format($finalPrice,2); ?></B></div></td>
	</tr>
</table>
