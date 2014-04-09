<?php
$this->breadcrumbs=array(
	'Invention',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>
<script type='text/javascript'>
$(function() {
	$('#shipselect').val(<?php echo $typeID; ?>)
	$('#shipselect').change(function() {
	  self.location = './index.php?r=invention/index&id=' + $(this).val();
	});
});
</script>
<?php

//Get a list of T2'able ships and display a dropdown select
echo "Select Base Item: <select id='shipselect'>\n";
$ships = $this->getT2ShipParents();
foreach ($ships as $ship)
{
	echo '<option value='.$ship['typeID'].'>'.$ship['typeName'].'</option>\n';
}
echo "</select><br><br>\n";
$blueprint = InvBlueprintTypes::Model()->find('productTypeID=:productTypeID', array(':productTypeID'=>$typeID));
$bp = $blueprint->blueprintTypeID;
$itemInfo = $this->blueprintDetail($bp);
$t1ItemName = $this->itemNameFromBlueprint($bp);

// TECH1 WORK
//

echo "<div class='mainHalfLeft'>";
	echo "<div class='currentstats'>";
	echo "<img style='height: 64px; width: 64px;' src='http://image.eveonline.com/Type/".$bp."_64.png'>";
	echo "<img style='height: 64px; width: 64px;' src='http://image.eveonline.com/Type/".$itemInfo['productTypeID']."_64.png'><BR>";
	echo "<a href='index.php?r=wallet/item&id=".$itemInfo['productTypeID']."'>".$t1ItemName['typeName']."</a><BR>";

	echo "Production Time: ".$this->humanTime($itemInfo['productionTime'] / (1 + (5 * .05)))."<BR>";
	echo "ME Time: ".$this->humanTime($itemInfo['researchMaterialTime'] / (1 + (5 * .05)))."<BR>";
	echo "PE Time: ".$this->humanTime($itemInfo['researchProductivityTime'])."<BR>";
	echo "Copy Time: ".$this->humanTime((($itemInfo['researchCopyTime'] * 2 ) / $itemInfo['maxProductionLimit']) / (1 + (5 * .05)))."<BR>";
	echo "Max Runs: ".$itemInfo['maxProductionLimit']."<BR>";
	//echo "Tech Level: ".$itemInfo['techLevel']."<BR>";
	echo "</div>";
echo "</div>";

echo "<div class='mainHalfRight'>";
	echo "<div class='currentstats'>";
	echo "<img style='height: 64px; width: 64px;' src='http://image.eveonline.com/Type/".$t2ItemRow['blueprintTypeID']."_64.png'><img style='height: 64px; width: 64px;' src='http://image.eveonline.com/Type/".$t2ItemRow['typeID']."_64.png'><BR>";
	echo "<a href='index.php?r=wallet/item&id=".$t2ItemRow['typeID']."'>".$t2ItemName['typeName']."</a><BR>";
	echo "Production Time: ".$this->humanTime($itemInfo['productionTime'] / (1 + (5 * .05)))."<BR>";
	echo "Max Runs: ".$itemInfo['maxProductionLimit']."<BR>";
	//echo "Tech Level: ".$itemInfo['techLevel']."<BR>";
	echo "</div>";
echo "</div>";

$product = $this->getProduct($bp);
$materials = $this->getMaterials($bp,$product,5,10,5);
	echo "<div class='currentstats'>";
	echo "<table>";
	echo "<tr class='header1'>";
	echo "<td style='text-align: left;'><div class='textCenter'><img src='images/items/icon33_02.png' width='16' height='16'>Material</div></td>";
	echo "<td style='text-align: right; width: 60px;'>Quantity</td>";
	echo "<td style='text-align: right; width: 45px;'>Null Cost</td>";
	echo "<td style='text-align: right; width: 45px;'>Null Total</td>";
	echo "<td style='text-align: right; width: 45px;'>Jita Cost</td>";
	echo "<td style='text-align: right; width: 45px;'>Jita Total</td>";
	echo "<td style='text-align: right; width: 45px;'>Difference</td>";
	echo "</tr>";
	$index = 0;
	foreach ($materials as $row)
		{
		$jitaMaterialPrice = $this->assetValue($row['typeID']);
		$jitaMaterialTotal = $row['quantity'] * $jitaMaterialPrice;
		$itemJitaMaterialTotal = $itemJitaMaterialTotal + $jitaMaterialTotal;
		$nullMaterialPrice = $this->lastNullPrice($row['typeID']);
		$nullMaterialTotal = $row['quantity'] * $nullMaterialPrice;
		$itemNullMaterialTotal = $itemNullMaterialTotal + $nullMaterialTotal;
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row['typeID']."_32.png'><a href='index.php?r=wallet/item&id=".$row['typeID']."'>".$row['typeName']."</a></td>";
		echo "<td style='text-align: right;'>".number_format($row['quantity'],0)."</td>";
		echo "<td style='text-align: right;'><font color='red'>".number_format($nullMaterialPrice,2)."</font></td>";
		echo "<td style='text-align: right;'><font color='red'>".number_format($nullMaterialTotal,2)."</font></td>";
		echo "<td style='text-align: right;'><font color='green'>".number_format($jitaMaterialPrice,2)."</font></td>";
		echo "<td style='text-align: right;'><font color='green'>".number_format($jitaMaterialTotal,2)."</font></td>";
		echo "<td style='text-align: right;'>".number_format($jitaMaterialTotal-$nullMaterialTotal,2)."</td>";
		echo "</tr>";
		$index++;
		}
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='red'>".number_format($itemNullMaterialTotal,2)."</font></B></div></td>";
		echo "<td></td>";
		echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemJitaMaterialTotal,2)."</font></B></div></td>";
		echo "<td style='text-align: right;'><div class='totalBorder'><B>".number_format($itemJitaMaterialTotal-$itemNullMaterialTotal,2)."</B></div></td>";
		echo "</tr>";
	echo "</table>";
	echo "</div>";

echo "<BR>";
echo "<BR>";

// TECH2 WORK
//
echo "<div class='mainHalfLeft'>";

$t2blueprint = $this->findT2Blueprints($itemInfo['productTypeID']);
foreach ($t2blueprint as $t2ItemRow)
	{
	$jitaMaterialTotal = 0;
	$itemJitaMaterialTotal = 0;
	$t2ItemName = $this->itemNameFromBlueprint($t2ItemRow['blueprintTypeID']);
	$itemInfo = $this->blueprintDetail($t2ItemRow['blueprintTypeID']);
	$materials = $this->getT2Materials($t2ItemRow['blueprintTypeID']);
	
	echo "<div class='currentstats'>";
	echo "<table>";
	echo "<tr class='header1'>";
	echo "<td style='text-align: left;'><div class='textCenter'><img src='images/items/icon33_02.png' width='16' height='16'>Material</div></td>";
	echo "<td style='text-align: right; width: 60px;'>Quantity</td>";
	echo "<td style='text-align: right; width: 45px;'>Jita Cost</td>";
	echo "<td style='text-align: right; width: 45px;'>Jita Total</td>";
	echo "</tr>";
	
	// MATERIAL WORK
	//
	$index = 0;
	foreach ($materials as $row)
		{
		$this->storeSingleAssetValue($row['requiredTypeID']);
		$jitaMaterialPrice = $this->assetValue($row['requiredTypeID']);
		$adjustedQuantity = $this->adjustedt2ME($row['quantity'],$row['wasted']);
		$jitaMaterialTotal = $adjustedQuantity * $jitaMaterialPrice;
		$itemJitaMaterialTotal = $itemJitaMaterialTotal + $jitaMaterialTotal;
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row['requiredTypeID']."_32.png'><a href='index.php?r=wallet/item&id=".$row['requiredTypeID']."'>".$row['typeName']."</a></div>";
			
			/* PUT ME IN A DIV
			$constructionItem = $this->constructionMaterials($row['requiredTypeID']);		
			echo "<div class='materialstats' style='width:400px;'>";
			echo "<table>";
			foreach ($constructionItem as $constructionRow)
			{
			echo "<tr>";
			echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$constructionRow['materialTypeID']."_32.png'>".$constructionRow['typeName']."</div></td>";
			echo "<td>".$constructionRow['quantity']."</td>";
			echo "</tr>";
			}
			echo "</table>";
				
			echo"</td>"; END DIV */
			
		echo "<td style='text-align: right;'>".number_format($adjustedQuantity,0)."</td>";
		echo "<td style='text-align: right;'>".number_format($jitaMaterialPrice,2)."</td>";
		echo "<td style='text-align: right;'>".number_format($jitaMaterialTotal,2)."</td>";
		echo "</tr>";
		$index++;
		}
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemJitaMaterialTotal,2)."</font></B></div></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	
	$complexReaction = $this->getCompositeMaterialsTotal($t2ItemRow['blueprintTypeID']);
	echo "<div class='currentstats'>";
	echo "<table>";
	echo "<tr class='header1'>";
	echo "<td style='text-align: left;'><div class='textCenter'><img src='images/items/icon33_02.png' width='16' height='16'>Composite Material</div></td>";
	echo "<td style='text-align: right; width: 60px;'>Quantity</td>";
	echo "<td style='text-align: right; width: 45px;'>Jita Cost</td>";
	echo "<td style='text-align: right; width: 45px;'>Total</td>";
	echo "</tr>";
	$index=0;
	$jitaMaterialTotal = 0;
	$itemJitaMaterialTotal = 0;
	foreach ($complexReaction as $reactionRow)
		{
		$this->storeSingleAssetValue($reactionRow['typeID']);
		$jitaMaterialPrice = $this->assetValue($reactionRow['typeID']);
		$adjustedQuantity = $reactionRow['quantity'];
		$jitaMaterialTotal = $adjustedQuantity * $jitaMaterialPrice;
		$itemJitaMaterialTotal = $itemJitaMaterialTotal + $jitaMaterialTotal;
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$reactionRow['typeID']."_32.png'><a href='index.php?r=wallet/item&id=".$reactionRow['typeID']."'>".$reactionRow['typeName']."</a>";
		//echo "".$this->constructionMaterialsCount($t2ItemRow['typeID'],$reactionRow['typeID'])."</div></td>";
		echo "<td style='text-align: right;'>".number_format($adjustedQuantity,0)."</td>";
		echo "<td style='text-align: right;'>".number_format($jitaMaterialPrice,2)."</td>";
		echo "<td style='text-align: right;'>".number_format($jitaMaterialTotal,2)."</td>";
		echo "</tr>";
		$index++;
		}
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemJitaMaterialTotal,2)."</font></B></div></td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	
	echo "<BR>";
	echo "</div>";
	}
?>

<div class='mainHalfRight'>
<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon18_01.png" width="16" height="16">Profit Report</div></td>
		<td style="text-align: right;">Profit</td>
		</tr>
		<?php
			echo '<tr>';
			echo '<td style="text-align: left;">Tech 1 Item</font></td>';
			echo '<td style="text-align: right;">'.number_format($jitaMaterialTotal,2).'</font></td>';
			echo "</tr>";
			echo '<tr class="odd">';
			echo '<td style="text-align: left;">Datacore 1</font></td>';
			echo '<td style="text-align: right;">'.number_format($jitaMaterialTotal,2).'</font></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align: left;">Datacore 2</font></td>';
			echo '<td style="text-align: right;">'.number_format($jitaMaterialTotal,2).'</font></td>';
			echo "</tr>";
			echo '<tr class="odd">';
			echo '<td style="text-align: left;">Composite Materials</font></td>';
			echo '<td style="text-align: right;">'.number_format($itemJitaMaterialTotal,2).'</font></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td style="text-align: left;">Noncomposite Materials</font></td>';
			echo '<td style="text-align: right;">'.number_format($jitaMaterialTotal,2).'</font></td>';
			echo "</tr>";
			echo "<tr>";
			echo "<td></td>";
			echo "<td style='text-align: right;'><div class='totalBorder'><B><font color='green'>".number_format($itemJitaMaterialTotal,2)."</font></B></div></td>";
			echo "</tr>";
		?>
		</table>
		</div>	
</div>

