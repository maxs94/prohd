<?php
$this->breadcrumbs=array(
	'Blueprints',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left; width: 220px;">Blueprint</td>
<td style="text-align: left; width: 20px;">In Use</td>
<td style="text-align: right; width: 10px;">ME</td>
<td style="text-align: right; width: 10px;">PE</td>
<td style="text-align: right; width: 50px;">Owner</td>
<td style="text-align: right; width: 50px;">Location</td>
<td style="text-align: right; width: 30px;">NPC</td>
<td style="text-align: right; width: 30px;">Market</td>
</tr>

<?php

//We shouldn't do this here but we are going to anyway for now

//Update PE/ME
$blueprints = Blueprints::Model()->findAll();
foreach ($blueprints as $blueprint)
{
	//$bp = Blueprints::Model()->find('itemID=:itemID',array(':itemID'=>$blueprint->itemID));
	$bpcrit = new CDbCriteria;
	
	$bpcrit->condition = 'installedItemID=:itemID AND completed = 1 AND activityID = 3';
	$bpcrit->params = array(':itemID'=>$blueprint->itemID);
	$bpcrit->order = 'installTime DESC';
	
	$indJob = IndustryJobs::Model()->find($bpcrit);
	if ($indJob != NULL)
	{
		$blueprint->peLevel = $indJob->runs;
		$update = true;
	}
	
	$bpcrit = new CDbCriteria;
	$bpcrit->condition = 'installedItemID=:itemID AND completed = 1 AND activityID = 4';
	$bpcrit->params = array(':itemID'=>$blueprint->itemID);
	$bpcrit->order = 'installTime DESC';
	
	$indJob = IndustryJobs::Model()->find($bpcrit);
	if ($indJob != NULL)
	{
		$blueprint->meLevel = $indJob->runs;
		$update = true;
	}
	if ($update)
	{
		$blueprint->save();
	}
}
	
	

$index=0;
$criteria = new CDbCriteria;
$criteria->order = 'blueprintID ASC';

$results = Blueprints::Model()->findAll($criteria);
	foreach ($results as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		//Load the solarsystem information

		$systemInfo = new CDbCriteria;
		$systemInfo->condition = 'solarSystemID=:solarSystemID';
		$systemInfo->params = array(':solarSystemID'=>$row->solarSystemID);
		$systemName = MapSolarSystems::Model()->find($systemInfo);
		
		$charInfo = new CDbCriteria;
		$charInfo->condition = 'characterID=:characterID';
		$charInfo->params = array(':characterID'=>$row->characterID);
		$charName = Characters::Model()->find($charInfo);
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->typeID);
		$itemName = Invtypes::Model()->find($itemInfo);
	
		//$icon = $this->getIcon($row->blueprintID);
	
		//$t2blueprint = $this->findT2Blueprints($row->typeID);
		
		if ($row->meLevel > 0)
			{
			$meRow = "<font color='green'>$row->meLevel</font>";
			}
			else
			{
			$meRow = "<font color='red'>$row->meLevel</font>";
			}
			
		if ($row->peLevel > 0)
			{
			$peRow = "<font color='green'>$row->peLevel</font>";
			}
			else
			{
			$peRow = "<font color='red'>$row->peLevel</font>";
			}	
	
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row->blueprintID."_32.png'><a href='index.php?r=wallet/item&id=$row->typeID'>$itemName->typeName</div></td>";
		//	echo "<td style='text-align: left;'>";
		//	foreach ($t2blueprint as $t2ItemRow)
		//		{
		//		$t2ItemName = $this->itemNameFromBlueprint($t2ItemRow['blueprintTypeID']);
		//		echo "<div class='textCenter'><img style='height: 16px; width: 16px;' src='http://image.eveonline.com/Type/".$t2ItemRow['blueprintTypeID']."_32.png'><a href='index.php?r=wallet/item&id=".$t2ItemRow['typeID']."'>".$t2ItemName['typeName']."</a></div>";
		//		}
		//	echo "</td>";
		echo "<td>".$this->usageCheck($row->itemID)."</td>";
		echo "<td style='text-align: right;'>$meRow</td>";
		echo "<td style='text-align: right;'>$peRow</td>";
		echo "<td style='text-align: right;'>$charName->characterName</td>";
		echo "<td style='text-align: right;'><a href='http://evemaps.dotlan.net/system/$systemName->solarSystemName'>$systemName->solarSystemName</a></td>";
		echo "<td style='text-align: right;'>".number_format($row->npcPrice,0)."</td>";
		echo "<td style='text-align: right;'>".number_format($row->value,0)."</td>";
		//echo "<td style='text-align: right;'>".number_format($row->value - $row->npcPrice,0)."</td>";
		echo "</tr>";
	$npcTotal = $npcTotal + $row->npcPrice;
	$valueTotal = $valueTotal + $row->value;
	//$researchTotal = $researchTotal + ($row->value - $row->npcPrice);
	
	$index++;
	}
	if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td style='text-align: right;'><B>".number_format($npcTotal,0)."</B></td>";
	echo "<td style='text-align: right;'><B>".number_format($valueTotal,0)."</B></td>";
	echo "</tr>";
?>
</tr>
</table>
</div>