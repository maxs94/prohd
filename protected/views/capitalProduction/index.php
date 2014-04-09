<?php
$this->breadcrumbs=array(
	'Capital Production',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);

// Change this to work with the Station Selection Menu Item
$prodStation = 60010822;

//Get cached data values
$typeID = $this->phdGetCache("capitalCache");
$bpcMELevel = $this->phdGetCache("BPCMECache");
$charPELevel = $this->phdGetCache("charPECache");
$characterID = $this->phdGetCache("characterIDCache");
$sellPrice = $this->phdGetCache("priceSellCache");
$bpcPrice = $this->phdGetCache("priceBPCCache");
$partsPrice = $this->phdGetCache("priceCapitalPartsCache");
$slotPrice = $this->phdGetCache("priceSlotCache");

if ($characterID == 0)
{
	$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);
	$walletID = $groupMembers[0]->characterID;
	
	$characterID = Characters::Model()->findByPk($walletID)->characterID;
	$this->phdSetCache("characterIDCache",$characterID);
}

$invType = Invtypes::Model()->findByPk($typeID);

//Find the blueprint typeID
$bpTypeID = InvBlueprintTypes::Model()->find("productTypeID = :typeID", array(':typeID'=>$invType->typeID));

//Load the skill sheet
$skillSheet = APICharacterSheet::load($characterID);

?>
<script type="text/javascript">
		jQuery(function($)
		{
			$('.bpcme').phdInlineInput({
				'label'		: 'Select',
				'getUrl' 	: 'capitalProduction/getbpcme',
				'submitUrl'	: 'capitalProduction/submitbpcme'
			});
			$('.pricesell').phdInlineInput({
				'label'		: 'Select',
				'getUrl' 	: 'capitalProduction/getpricesell',
				'submitUrl'	: 'capitalProduction/submitpricesell'
			});
			$('.pricebpc').phdInlineInput({
				'label'		: 'Select',
				'getUrl' 	: 'capitalProduction/getpricebpc',
				'submitUrl'	: 'capitalProduction/submitpricebpc'
			});
			$('.pricecapitalparts').phdInlineInput({
				'label'		: 'Select',
				'getUrl' 	: 'capitalProduction/getpricecapitalparts',
				'submitUrl'	: 'capitalProduction/submitpricecapitalparts'
			});
			$('.priceslot').phdInlineInput({
				'label'		: 'Select',
				'getUrl' 	: 'capitalProduction/getpriceslot',
				'submitUrl'	: 'capitalProduction/submitpriceslot'
			});
			$('.selectCapital').phdInlineSelect({
				'label'		: 'Select',
				'listUrl' 	: 'capitalProduction/getcapitals',
				'getUrl'	: 'capitalProduction/getcurrentcap',
				'submitUrl'	: 'capitalProduction/submitcapital'
			});
			$('.charselect').phdInlineSelect({
				'label'		: 'Select',
				'listUrl' 	: 'capitalProduction/getcharacters',
				'getUrl'	: 'capitalProduction/getcurrentcharacter',
				'submitUrl'	: 'capitalProduction/submitcharacter'
			});				
		});
	</script>
<hr>

<div class="mainHalfLeft">

	<div class="currentstats" style="width:425px;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_11.png" width="16" height="16">Project Item</div></td>
	<td style="text-align: right; width: 200px;">Selection</td>
	</tr>

	<tr>
	<td style="text-align: left;"><div class='textCenter'><img src="http://image.eveonline.com/Type/<? echo $this->getIcon($bpTypeID->blueprintTypeID); ?>" width="24" height="24">Blueprint</div></td>
	<td style="text-align: right;"><div class='selectCapital'>Thanatos</div></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/7_64_4.png" width="24" height="24">Production System</div></td>
	<td style="text-align: right;"><a href="http://evemaps.dotlan.net/map/The_Forge/Kiainti">Kiainti</a></td>
	</tr>

	<tr>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="24" height="24">BPC ME</div></td>
	<td style="text-align: right;"><div class="bpcme"></div></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/2_64_16.png" width="24" height="24">Character</div></td>
	<td style="text-align: right;"><div class="charselect"></div></td>
	</tr>

	</table>
	</div>
	
	<BR>

</div>

<div class="mainHalfRight">
	
	<div class="currentstats" style="width:425px; float:right;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_11.png" width="16" height="16">Construction Item</div></td>
	<td style="text-align: right; width: 150px;">Detail</td>
	</tr>
	
	<tr>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/18_128_2.png" width="24" height="24">Manufacturing Time</div></td>
	<td style="text-align: right;"><?php echo $this->humanTime(($bpTypeID->productionTime) / (1 + ($skillSheet->Industry * .05)) ); ?></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="24" height="24">ML Research Time</div></td>
	<td style="text-align: right;"><?php echo $this->humanTime(($bpTypeID->researchMaterialTime) / (1 + ($skillSheet->Metallurgy * .05)) ); ?></td>
	</tr>
	
	<tr>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="24" height="24">Copy Time</div></td>
	<td style="text-align: right;"><?php echo $this->humanTime((($bpTypeID->researchCopyTime * 2) / $bpTypeID->maxProductionLimit) / (1 + ($skillSheet->Science * .05))); ?></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="24" height="24">Max. Runs When Copied</div></td>
	<td style="text-align: right;"><?php echo $bpTypeID->maxProductionLimit; ?></td>
	</tr>
	
	</table>
	</div>
	
</div>

<BR>
<BR>

<div style="clear: both;"></div>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;">Capital Components</td>
<td style="text-align: right; width: 70px;">Required</td>
<td style="text-align: right; width: 70px;">Stock</td>
<td style="text-align: right; width: 70px;">Production</td>
<td style="text-align: right; width: 70px;">Needed</td>
<td style="text-align: right; width: 70px;">BPC Needed</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?

$materials = $this->getMaterials($invType->typeID,$bpTypeID->blueprintTypeID,0,$bpcMELevel,$skillSheet->Production_Efficiency);

$i = 0;

foreach ($materials as $material)
{
	if ($i % 2)
		echo "<tr class='odd'>";
	else
		echo "<tr>";
	?>
	<?
	$itemRequired = $material['quantity'];
	$capRequiredTotal = $capRequiredTotal + $itemRequired;
	$itemStock = $this->getComponentCount($material['typeID'],$prodStation);
	$itemProduction = $this->getIndustryCount($material['typeID'],$prodStation);
	$itemNeeded = $itemRequired - $itemStock - $itemProduction;
	if ($itemNeeded < 0)
		{
		$itemNeeded = 0;
		}
	$capNeededTotal = $capNeededTotal + $itemNeeded;
	$diff = ($itemStock + $itemProduction) / $itemRequired * 100;
	if ($diff > 100) // Handle case where we have more than required cap parts for CSS progress bar correction to 100%
		{
		$diff = 100;
		}
	
	//icon time
	$icon = $this->getIcon($material['typeID']);
	?>
	
	<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/<? echo $icon; ?>'><a href='index.php?r=wallet/item&id=<? echo $material['typeID']; ?>'><? echo $material['typeName']; ?></div></td>
	<td style="text-align: right;"><? echo $itemRequired; ?></td>
	<td style="text-align: right;"><div class='textCenter'><a href="index.php?r=editAssets/update&id=<? echo $this->getStock($material['typeID'],$prodStation); ?>"><? echo $itemStock; ?> </a></div></td>
	<td style="text-align: right;"><? echo $itemProduction; ?></td>
	<td style="text-align: right;"><? echo $itemNeeded; ?></td>
	<td style="text-align: right;"><? echo number_format(round($itemNeeded/5, 0, PHP_ROUND_HALF_UP),0); ?></td>
	<td style="text-align: right;"><div class='progress-container'><div style='width: <? echo $diff; ?>%'><? echo number_format($diff,0); ?>%</div></div></td>
	</tr>
	
<?
$i++;
}
?>
</table>
</div>

<BR>
<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;">Minerals</td>
<td style="text-align: right; width: 70px;">Required</td>
<td style="text-align: right; width: 50px;">Value</td>
<td style="text-align: right; width: 80px;">Stock</td>
<td style="text-align: right; width: 50px;">Value</td>
<td style="text-align: right; width: 50px;">Needed</td>
<!--<td style="text-align: right; width: 50px;">Null Price</td>-->
<!--<<td style="text-align: right; width: 50px;">Null Total</td>-->
<td style="text-align: right; width: 50px;">Jita Price</td>
<td style="text-align: right; width: 50px;">Jita Total</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?
$minerals = $this->getMineralRequirements($materials);

$i = 0;

foreach ($minerals as $mineralName => $mineral)
{
	if ($i % 2)
		echo "<tr class='odd'>";
	else
		echo "<tr>";
		
	$stock = $this->getComponentCount($mineral['typeID'],$prodStation);
	?>
	<?
	$itemRequired = $mineral['quantity'];
	if ($itemRequired < 0) // Handle case where we have more than required minerals and set to 0 to make ISK calcs accurate
		{
		$itemRequired = 0;
		}
		
	$itemNeeded = $mineral['quantity'] - $stock;
	if ($itemNeeded < 0) // Handle case where we have more than required minerals and set to 0 to make ISK calcs accurate
		{
		$itemNeeded = 0;
		}
	$nullPrice = $this->lastNullPrice($mineral['typeID']);
	$nullPriceTotal = $nullPriceTotal + ($nullPrice * $itemNeeded);
	
	$jitaPrice = $this->lastJitaPrice($mineral['typeID']);
	$jitaPriceTotal = $jitaPriceTotal + ($jitaPrice * $itemNeeded);
	
	$remainJitaPriceTotal = $remainJitaPriceTotal + ($itemRequired * $jitaPrice); // Price totals for remaining project
	$remainNullPriceTotal = $remainNullPriceTotal + ($itemRequired * $nullPrice);
	
	$diff = ($stock / $itemRequired) * 100;
	if ($diff > 100) // Handle case where we have more than required minerals for CSS progress bar correction to 100%
		{
		$diff = 100;
		}
	$diffTotal = $diffTotal + $diff;
	
	//icon time
	$icon = $this->getIcon($mineral['typeID']);
	?>
	<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/<? echo $icon; ?>'><a href='index.php?r=wallet/item&id=<? echo $mineral['typeID']; ?>'><? echo $mineralName; ?></div></td>
	<td style="text-align: right;"><? echo number_format($itemRequired,0); ?></td>
	<td style="text-align: right;"><? echo number_format($itemRequired * $jitaPrice/1000000,1); ?> M</td>
	<td style="text-align: right;"><a href="index.php?r=editAssets/update&id=<? echo $this->getStock($mineral['typeID'],$prodStation); ?>"><? echo number_format($stock,0); ?></a></td>
	<td style="text-align: right;"><? echo number_format($stock * $jitaPrice/1000000,1); ?> M</td>
	<td style="text-align: right;"><? echo number_format(($itemNeeded),0); ?></td>
	<!--<td style="text-align: right;"><font color="red"><? number_format($nullPrice,2); ?></font></td>-->
	<!--<td style="text-align: right;"><font color="red"><? number_format(($itemNeeded * $nullPrice)/1000000,1); ?> M</font></td>-->
	<td style="text-align: right;"><font color="green"><? echo number_format($jitaPrice,2); ?></font></td>
	<td style="text-align: right;"><font color="green"><? echo number_format(($itemNeeded * $jitaPrice)/1000000,1); ?> M</font></td>
	<td style="text-align: right;"><div class='progress-container'><div style='width: <? echo $diff; ?>%'><? echo number_format($diff,1); ?>%</div></div></td>
	</tr>
<?
$i++;
}
?>
</table>
</div>

<BR>
<BR>

<?
$minDiff = ($diffTotal/7);
$capDiff = 100-($capNeededTotal / $capRequiredTotal)*100;
?>

<? //Get total mineral requirements
$minerals = $this->getTotalMineralRequirements($materials);

$i = 0;
foreach ($minerals as $mineralName => $mineral)
	{
	$projectItemRequired = $mineral['quantity'];
	$nullPrice = $this->lastNullPrice($mineral['typeID']);
	$jitaPrice = $this->lastJitaPrice($mineral['typeID']);
	$projectNullPriceTotal = $projectNullPriceTotal + ($projectItemRequired * $nullPrice); // Price totals for entire project
	$projectJitaPriceTotal = $projectJitaPriceTotal + ($projectItemRequired * $jitaPrice);
	$i++;
	}
?>

<div class="mainHalfLeft">

	<div class="currentstats" style="width:425px;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon25_08.png" width="16" height="16">Project Items</div></td>
	<td style="text-align: right; width: 100px;">Progress</td>
	</tr>

	<tr>
	<td style="text-align: left;">Capital Components</td>
	<td style="text-align: right;"><div class='progress-container'><div style='width: <? echo $capDiff; ?>%'><? echo number_format($capDiff,1); ?>%</div></div></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;">Mineral Components</td>
	<td style="text-align: right;"><div class='progress-container'><div style='width: <? echo $minDiff; ?>%'><? echo number_format($minDiff,1); ?>%</div></div></td>
	</tr>

	<tr>
	<td style="text-align: left;">Total Components</td>
	<td style="text-align: right;"><div class='progress-container'><div style='width: <? echo ($capDiff + $minDiff)/2; ?>%'><? echo number_format(($capDiff + $minDiff)/2,1); ?>%</div></div></td>
	</tr>

	</table>
	</div>

	<BR>
	<BR>

	<div class="currentstats" style="width:425px;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon06_03.png" width="16" height="16">Remaining Totals</div></td>
	<td style="text-align: right; width: 100px;">Total Cost</td>
	</tr>

	<tr>
	<td style="text-align: left;">Null</td>
	<td style="text-align: right;"><? echo number_format($remainNullPriceTotal,0) ?></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;">Jita</td>
	<td style="text-align: right;"><? echo number_format($remainJitaPriceTotal,0) ?></td>
	</tr>

	<tr>
	<td style="text-align: left;">Difference</td>
	<td style="text-align: right;"><font color="green">+<? echo number_format($remainJitaPriceTotal - $remainNullPriceTotal,0) ?></font></td>
	</tr>

	</table>
	</div>

	<BR>

</div>

<div class="mainHalfRight">

	<div class="currentstats" style="width:425px; float:right;">
	<table>
	<tr class="header1">
	<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon27_13.png" width="16" height="16">Profit Calculation</div></td>
	<td style="text-align: right; width: 150px;">Cost</td>
	</tr>

	<tr>
	<td style="text-align: left;">Sell</td>
	<td style="text-align: right;"><div class="pricesell"></font></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;">Capital BPC</td>
	<td style="text-align: right;"><div class="pricebpc"></font></td>
	</tr>

	<tr>
	<td style="text-align: left;">Capital Part BPCs</td>
	<td style="text-align: right;"><div class="pricecapitalparts"></font></td>
	</tr>

	<tr class='odd'>
	<td style="text-align: left;">Slot Usage</td>
	<td style="text-align: right;"><div class="priceslot"></font></td>
	</tr>
	
	<tr>
	<td style="text-align: left;">Null Cost</td>
	<td style="text-align: right;"><? echo number_format($projectNullPriceTotal,0); ?></td>
	</tr>
	
	<tr class='odd'>
	<td style="text-align: left;">Jita Cost</td>
	<td style="text-align: right;"><? echo number_format($projectJitaPriceTotal,0); ?></td>
	</tr>

	<tr>
	<td style="text-align: left;">Null Profit</td>
	<td style="text-align: right;"><font color="green">+<? echo number_format($sellPrice - ($bpcPrice + $partsPrice + $slotPrice + $projectNullPriceTotal),0); ?></font></td>
	</tr>
	
	<tr class='odd'>
	<td style="text-align: left;">Jita Profit</td>
	<td style="text-align: right;"><font color="green">+<? echo number_format($sellPrice - ($bpcPrice + $partsPrice + $slotPrice + $projectJitaPriceTotal),0); ?></font></td>
	</tr>

	</table>
	</div>

</div>


