<?php
$this->breadcrumbs=array(
	'PI',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>


<?php
// REPORT ON WHAT IS BEING HARVESTED
//
$moonDetail = $this->getMoonDetail();
echo "<div class='currentstats'>";
echo "<table>";
echo "<tr class='header1'>";
echo "<td style='text-align: left; width: 100px;'><div class='textCenter'><img src='images/items/32_128_2.png' width='16' height='16'>Character</div></td>";
echo "<td style='text-align: left; width: 80px;'>Location</td>";
echo "<td style='text-align: left; width: 120px;'>Type</td>";
echo "<td style='text-align: left; width: 45px;'>Processors</td>";
echo "<td style='text-align: left; width: 125px;'>Planetary Material (T0)</td>";
echo "<td style='text-align: right; width: 50px;'>h</td>";
echo "<td style='width: 20px;'></td>";
echo "<td style='text-align: left; width: 125px;'>Processed Material (T1)</td>";
echo "<td style='text-align: right; width: 50px;'>d</td>";
echo "<td style='text-align: right; width: 50px;'>ISK/d</td>";
echo "</tr>";

$index = 0;
foreach ($moonDetail as $row)
	{
	$productName = $this->getSchematic($row['typeID']);
	$iskPerDay = ($row['averageOutput']/$productName[1]['quantity']/0.38) * $this->assetValue($productName[1]['typeID']);
	$iskPerDayTotal = $iskPerDayTotal + $iskPerDay;
	
	if ($index % 2)
		echo "<tr class='odd'>";
	else
		echo "<tr>";
	//echo "<td style='text-align: left;'><div class='textCenter'><img src='http://image.eveonline.com/Character/".$row['characterID']."_200.jpg' height='20' width='20'>".$this->getCharacter($row['characterID'])."</div></td>";
	echo "<td style='text-align: left;'>".$this->getCharacter($row['characterID'])."</td>";
	echo "<td style='text-align: left;'>".$this->getPlanet($row['moonID'])."</td>";
	echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$this->getPlanetIcon($row['moonID'])."_32.png'>".$this->getPlanetType($row['moonID'])."</div></td>";
	echo "<td style='text-align: left;'>".$row['processorCount']."</td>";
	echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row['typeID']."_32.png'>".$this->getName($row['typeID'])."</div></td>";	
	echo "<td style='text-align: right;'>".number_format($row['averageOutput']/0.01,0)."</td>";
	echo "<td style='text-align: center;'><img src='images/arrow_right.png'></td>";
	echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$productName[1]['typeID']."_32.png'><a href='index.php?r=wallet/item&id=".$productName[1]['typeID']."'>".$productName[1]['typeName']."</a></div></td>";
	echo "<td style='text-align: right;'>".number_format($row['averageOutput']/$productName[1]['quantity']/0.38,0)."</td>";
	echo "<td style='text-align: right;'><font color='green'>".number_format($iskPerDay,0)."</font></td>";
	echo "</tr>";
	$index++;
	}
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($iskPerDayTotal,2)."</font></B></div></td>";
echo "</tr>";
echo "</table>";
echo "</div>";


//LIST OF PI ITEMS AND HARVESTING STATS
//
$piItemDetail = $this->getPlanetaryMaterials();
echo "<div class='currentstats'>";
echo "<table>";
echo "<tr class='header1'>";
echo "<td style='text-align: left; width: 140px;'>Planetary Material (T0)</td>";
echo "<td style='width: 40px;'></td>";
echo "<td style='text-align: left; width: 140px;'>Processed Material (T1)</td>";
echo "<td style='text-align: right; width: 130px;'>Jita Price</td>";
echo "<td style='text-align: right; width: 130px;'>Stock</td>";
echo "<td style='text-align: right; width: 130px;'>Value</td>";
echo "</tr>";

$index = 0;
foreach ($piItemDetail as $row)
	{
	$this->storeSingleAssetValue($productName[1]['typeID']); // Get Jita Prices
	$harvesting = $this->harvestingCheck($row['typeID']);
	$productName = $this->getSchematic($row['typeID']); // GET P1 from P0
	$itemValue = $this->assetValue($productName[1]['typeID']);
	$itemQuantity = $this->assetQuantity($productName[1]['typeID']);
	
	$itemTotalValue = $itemTotalValue + ($itemValue * $itemQuantity);
	
	if ($index % 2)
		echo "<tr class='odd'>";
	else
		echo "<tr>";
	echo "<td style='text-align: left;'><div class='textCenter'>".$harvesting."<img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row['typeID']."_32.png'>".($row['typeName'])."</div></td>";
	echo "<td style='text-align: center;'><img src='images/arrow_right.png'></td>";
	echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$productName[1]['typeID']."_32.png'><a href='index.php?r=wallet/item&id=".$productName[1]['typeID']."'>".($productName[1]['typeName'])."</a></div></td>";
	echo "<td style='text-align: right;'>".number_format($itemValue,2)."</td>";
	echo "<td style='text-align: right;'>".number_format($itemQuantity,0)."</td>";
	echo "<td style='text-align: right;'>".number_format($itemValue * $itemQuantity,2)."</td>";
	echo "</tr>";
	$index++;
	}
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemTotalValue,2)."</font></B></div></td>";
echo "</tr>";
echo "</table>";
echo "</div>";


//LIST OF T2 PI ITEMS AND HARVESTING STATS
//

echo "<div class='currentstats'>";
echo "<table>";
echo "<tr class='header1'>";
echo "<td style='text-align: left; width: 200px;'>Processed Material (T1)</td>";
echo "<td style='width: 40px;'></td>";
echo "<td style='text-align: left; width: 200px;'>Refined Commodities (T2)</td>";
echo "<td style='text-align: right; width: 130px;'>Jita Price</td>";
echo "<td style='text-align: right; width: 130px;'>Stock</td>";
echo "<td style='text-align: right; width: 130px;'>Value</td>";
echo "</tr>";

$t2materials = $this->getPlanetary2Materials();
$index = 0;
foreach ($t2materials as $materialRow)
{
	if ($lastSchematic != $materialRow['schematicID'])
	{
		$lastSchematic = $materialRow['schematicID'];
		$piItemDetail = $this->getSchematicProduct($materialRow['schematicID']);
		
		foreach ($piItemDetail as $row)
		{
			$this->storeSingleAssetValue($row['typeID']); // Get Jita Prices
			$itemValue = $this->assetValue($row['typeID']);
			$itemQuantity = $this->assetQuantity($row['typeID']);
			$itemTotalValue = $itemTotalValue + ($itemValue * $itemQuantity);
			
			$inputItem = $this->getSchematicInput($row['schematicID']);
			
			if ($index % 2)
				echo "<tr class='odd'>";
			else
				echo "<tr>";
			echo "<td style='text-align: left;'>";
				foreach ($inputItem as $input)
				{
				$inStock = $this->haveItemInStock($input['typeID']);
				echo "<div class='textCenter'>".$inStock."<img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$input['typeID']."_32.png'><a href='index.php?r=wallet/item&id=".$input['typeID']."'>".($input['typeName'])."</a></div>";
				}
			echo "</td>";
			echo "<td style='text-align: center;'><img src='images/arrow_switch.png'></td>";
			echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 32px; width: 32px;' src='http://image.eveonline.com/Type/".$row['typeID']."_32.png'>".($row['typeName'])."</div></td>";
			echo "<td style='text-align: right;'>".number_format($itemValue,2)."</td>";
			echo "<td style='text-align: right;'>".number_format($itemQuantity,0)."</td>";
			echo "<td style='text-align: right;'>".number_format($itemValue * $itemQuantity,2)."</td>";
			echo "</tr>";
			$index++;
		}
	}
}
	
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemTotalValue,2)."</font></B></div></td>";
echo "</tr>";
echo "</table>";
echo "</div>";



//LIST OF T2 PI ITEMS AND HARVESTING STATS
//

echo "<div class='currentstats'>";
echo "<table>";
echo "<tr class='header1'>";
echo "<td style='text-align: left; width: 200px;'>Refined Commodities (T2)</td>";
echo "<td style='width: 40px;'></td>";
echo "<td style='text-align: left; width: 200px;'>Specialized Commodities (T3)</td>";
echo "<td style='text-align: right; width: 130px;'>Jita Price</td>";
echo "<td style='text-align: right; width: 130px;'>Stock</td>";
echo "<td style='text-align: right; width: 130px;'>Value</td>";
echo "</tr>";

$t3materials = $this->getPlanetary3Materials();
$index = 0;
$itemTotalValue = 0;
foreach ($t3materials as $materialRow)
{
	if ($lastSchematic != $materialRow['schematicID'])
	{
		$lastSchematic = $materialRow['schematicID'];
		$piItemDetail = $this->getSchematicProduct($materialRow['schematicID']);
		
		foreach ($piItemDetail as $row)
		{
			$this->storeSingleAssetValue($row['typeID']); // Get Jita Prices
			$itemValue = $this->assetValue($row['typeID']);
			$itemQuantity = $this->assetQuantity($row['typeID']);
			$itemTotalValue = $itemTotalValue + ($itemValue * $itemQuantity);
			
			$inputItem = $this->getSchematicInput($row['schematicID']);
			
			if ($index % 2)
				echo "<tr class='odd'>";
			else
				echo "<tr>";
			echo "<td style='text-align: left;'>";
				foreach ($inputItem as $input)
				{
				$inStock = $this->haveItemInStock($input['typeID']);
				echo "<div class='textCenter'>".$inStock."<img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$input['typeID']."_32.png'><a href='index.php?r=wallet/item&id=".$input['typeID']."'>".($input['typeName'])."</a></div>";
				}
			echo "</td>";
			echo "<td style='text-align: center;'><img src='images/arrow_switch.png'></td>";
			echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 32px; width: 32px;' src='http://image.eveonline.com/Type/".$row['typeID']."_32.png'>".($row['typeName'])."</div></td>";
			echo "<td style='text-align: right;'>".number_format($itemValue,2)."</td>";
			echo "<td style='text-align: right;'>".number_format($itemQuantity,0)."</td>";
			echo "<td style='text-align: right;'>".number_format($itemValue * $itemQuantity,2)."</td>";
			echo "</tr>";
			$index++;
		}
	}
}
	
echo "<tr>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemTotalValue,2)."</font></B></div></td>";
echo "</tr>";
echo "</table>";
echo "</div>";
?>

</tr>
</table>
</div>