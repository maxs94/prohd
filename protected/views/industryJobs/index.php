<?php
$this->breadcrumbs=array(
	'Industry Jobs',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>

<?
//Check on our cache value
$industryInterface = new APIIndustryJobs;
$corpIndustryInterface = new APICorpIndustryJobs;

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID); // Find members in your group
$allMembers =  Characters::Model()->findAll(); // Find all members
	foreach ($allMembers as $member)
	{
		$allMembersArray[] = $member->characterID;
	}
$allMembersString = "(".implode($allMembersArray,',').")";
	
	
if(!($industryInterface->getCacheExpiration($groupMembers[0]->characterID)))
{

	foreach ($groupMembers as $member)
	{
		$orders = $industryInterface->getEveData($member->characterID);
		$character = Characters::Model()->findByPk($member->characterID);
		$industryInterface->storeData($member->characterID);
		$corpIndustryInterface->storeData($member->characterID);
	}
}
?>
<script type="text/javascript">
$(function() {
   $('#industry-job-calendar').phdIndustryCalendarRef({url: '<? echo $this->createUrl('/industryJobs/getCalendar'); ?>'}); 
});
</script>


<hr>

<div id="industry-job-calendar"></div>
<?
/*
<div class="currentstats" style="width: 400px;">
<table>
<tr class="header1">
<td style="text-align: left;"><div class='textCenter'><img src="images/items/icon18_02.png" width="16" height="16">Character</div></td>
<td style="text-align: left; width: 125px;">Manufacturing</td>
<td style="text-align: left; width: 125px;">Research</td>
</tr>
<?
$index = 0;
$characters = $this->getCharacters(1);
foreach ($characters as $row)
	{
	if ($index % 2)
		echo "<tr class='odd'>";
	else
		echo "<tr>";
		
	echo "<td style='text-align: left;'>".$row['characterName']."</td>";
	
	//Manufacturing
	$diff = 0;
	echo "<td style='text-align: right;'><div class='progress-container-industry'><div style='width: ".$diff."%'>".$diff."%</div></div></td>";

	//Research
	$total = 10;
	$inUse = $this->getJobResearchCount($row['characterID']);
	$diff = ($inUse/$total)*100;
	echo "<td style='text-align: right;'><div class='progress-container-industry'><div style='width: ".$diff."%'>".$diff."%</div></div></td>";
	
	echo "</tr>";
	$index++;
	}
?>
</table>
</div>
*/?>
<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;"><div class='textCenter'><img src="images/items/18_128_2.png" width="16" height="16">Invention</div></td>
<td style="text-align: right; width: 80px;">Character</td>
<td style="text-align: right; width: 60px;">System</td>
<td style="text-align: right; width: 45px;">Runs</td>
<td style="text-align: right; width: 45px;">ME</td>
<td style="text-align: right; width: 70px;">Status</td>
<td style="text-align: right; width: 80px;">End</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?php

$criteria = new CDbCriteria;
$criteria->condition = 'completed = 0 AND activityID = 8';
//$criteria->condition = 'completed = 0 AND activityID = 8 AND installerID IN '.$allMembersString.'';
$criteria->order = 'endProductionTime ASC';

$results = IndustryJobs::Model()->findAll($criteria);
	foreach ($results as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		//Load the solarsystem information

		$systemInfo = new CDbCriteria;
		$systemInfo->condition = 'solarSystemID=:solarSystemID';
		$systemInfo->params = array(':solarSystemID'=>$row->installedInSolarSystemID);
		$systemName = MapSolarSystems::Model()->find($systemInfo);
		
		$charInfo = new CDbCriteria;
		$charInfo->condition = 'characterID=:characterID';
		$charInfo->params = array(':characterID'=>$row->installerID);
		$charName = Characters::Model()->find($charInfo);
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->outputTypeID);
		$itemName = Invtypes::Model()->find($itemInfo);

		$dateEnd = $row->endProductionTime;
		$dateBegin = $row->beginProductionTime;
		$dateNow = date('Y-m-d H:i:s', strtotime("+5 hour"));
		
		$diff = 100 - ((strtotime($dateEnd) - strtotime($dateNow)) / (strtotime($dateEnd) - strtotime($dateBegin))) * 100;
		$diff = number_format($diff, 1, '.', '');
		if ($diff < 0) // Handle case where job is pending
			{
			$diff = 0;
			}
		if ($diff > 100) // Handle case where job is completed
			{
			$diff = 100;
			}
	
		$icon = $this->getIcon($row->outputTypeID);
		if (strtotime($row->beginProductionTime) > strtotime($dateNow)) //Pending Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='red'><div class='textCenter'><img src='./images/clock_red.png'>Pending</div></font>";
			$dateEnd = "$dateEndTime";
			}
			elseif (strtotime($dateNow) > strtotime($row->endProductionTime)) //Finished Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Finished<div></font>";
			$dateEnd = "$dateEndTime";
			}
			else // Running Condition
			{
			$dateEnd = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<div class='textCenter'><img src='./images/time_go.png'>Running</div>";
			}
			
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/$icon'><a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: right;'>$charName->characterName</td>";
		echo "<td style='text-align: right;'><a href='http://evemaps.dotlan.net/system/$systemName->solarSystemName'>$systemName->solarSystemName</a></td>";
		echo "<td style='text-align: right;'>$row->runs</td>";
		echo "<td style='text-align: right;'>$row->installedItemMaterialLevel</td>";
		echo "<td style='text-align: right;'>$jobStatus</td>";
		echo "<td style='text-align: right;'>$dateEnd</td>";
		echo "<td style='text-align: right;'><div class='progress-container'><div style='width: $diff%'>$diff%</div></div></td>";
		echo "</tr>";
	$index++;
	}
?>
</tr>
</table>
</div>

<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;"><div class='textCenter'><img src="images/items/18_128_2.png" width="16" height="16">Manufacturing Item</div></td>
<td style="text-align: right; width: 80px;">Character</td>
<td style="text-align: right; width: 60px;">System</td>
<td style="text-align: right; width: 45px;">Runs</td>
<td style="text-align: right; width: 45px;">ME</td>
<td style="text-align: right; width: 70px;">Status</td>
<td style="text-align: right; width: 80px;">End</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?php

$criteria = new CDbCriteria;
$criteria->condition = 'completed = 0 AND activityID = 1';
//$criteria->condition = 'completed = 0 AND activityID = 1 AND installerID IN '.$allMembersString.'';
$criteria->order = 'endProductionTime ASC';

$results = IndustryJobs::Model()->findAll($criteria);
	foreach ($results as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		//Load the solarsystem information

		$systemInfo = new CDbCriteria;
		$systemInfo->condition = 'solarSystemID=:solarSystemID';
		$systemInfo->params = array(':solarSystemID'=>$row->installedInSolarSystemID);
		$systemName = MapSolarSystems::Model()->find($systemInfo);
		
		$charInfo = new CDbCriteria;
		$charInfo->condition = 'characterID=:characterID';
		$charInfo->params = array(':characterID'=>$row->installerID);
		$charName = Characters::Model()->find($charInfo);
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->outputTypeID);
		$itemName = Invtypes::Model()->find($itemInfo);

		$dateEnd = $row->endProductionTime;
		$dateBegin = $row->beginProductionTime;
		$dateNow = date('Y-m-d H:i:s', strtotime("+5 hour"));
		
		$diff = 100 - ((strtotime($dateEnd) - strtotime($dateNow)) / (strtotime($dateEnd) - strtotime($dateBegin))) * 100;
		$diff = number_format($diff, 1, '.', '');
		
		if ($diff < 0) // Handle case where job is pending
			{
			$diff = 0;
			}
		if ($diff > 100) // Handle case where job is completed
			{
			$diff = 100;
			}
	
		$icon = $this->getIcon($row->outputTypeID);
		if (strtotime($row->beginProductionTime) > strtotime($dateNow)) //Pending Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='red'><div class='textCenter'><img src='./images/clock_red.png'>Pending</div></font>";
			$dateEnd = "$dateEndTime";
			}
			elseif (strtotime($dateNow) > strtotime($row->endProductionTime)) //Finished Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Finished<div></font>";
			$dateEnd = "$dateEndTime";
			}
			else // Running Condition
			{
			$dateEnd = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<div class='textCenter'><img src='./images/time_go.png'>Running</div>";
			}
			
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/$icon'><a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: right;'>$charName->characterName</td>";
		echo "<td style='text-align: right;'><a href='http://evemaps.dotlan.net/system/$systemName->solarSystemName'>$systemName->solarSystemName</a></td>";
		echo "<td style='text-align: right;'>$row->runs</td>";
		echo "<td style='text-align: right;'>$row->installedItemMaterialLevel</td>";
		echo "<td style='text-align: right;'>$jobStatus</td>";
		echo "<td style='text-align: right;'>$dateEnd</td>";
		echo "<td style='text-align: right;'><div class='progress-container'><div style='width: $diff%'>$diff%</div></div></td>";
		echo "</tr>";
	$index++;
	}
?>
</tr>
</table>
</div>

<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="16" height="16">Copy Item</div></td>
<td style="text-align: right; width: 80px;">Character</td>
<td style="text-align: right; width: 60px;">System</td>
<td style="text-align: right; width: 45px;">Runs</td>
<td style="text-align: right; width: 45px;">ME</td>
<td style="text-align: right; width: 70px;">Status</td>
<td style="text-align: right; width: 80px;">End</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?php

$criteria = new CDbCriteria;
$criteria->condition = 'completed = 0 AND activityID = 5';
//$criteria->condition = 'completed = 0 AND activityID = 5 AND installerID IN '.$allMembersString.'';
$criteria->order = 'endProductionTime ASC';

$results = IndustryJobs::Model()->findAll($criteria);
$index=0;

	foreach ($results as $row)
	{
	
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		//Load the solarsystem information

		$systemInfo = new CDbCriteria;
		$systemInfo->condition = 'solarSystemID=:solarSystemID';
		$systemInfo->params = array(':solarSystemID'=>$row->installedInSolarSystemID);
		$systemName = MapSolarSystems::Model()->find($systemInfo);
		
		$charInfo = new CDbCriteria;
		$charInfo->condition = 'characterID=:characterID';
		$charInfo->params = array(':characterID'=>$row->installerID);
		$charName = Characters::Model()->find($charInfo);
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->installedItemTypeID);
		$itemName = Invtypes::Model()->find($itemInfo);
		
		$dateEnd = $row->endProductionTime;
		$dateBegin = $row->beginProductionTime;
		$dateNow = date('Y-m-d H:i:s', strtotime("+5 hour"));
		
		$diff = 100 - ((strtotime($dateEnd) - strtotime($dateNow)) / (strtotime($dateEnd) - strtotime($dateBegin))) * 100;
		$diff = number_format($diff, 1, '.', '');
		
		
		if ($diff < 0) // Handle case where job is pending
			{
			$diff = 0;
			}
		if ($diff > 100) // Handle case where job is completed
			{
			$diff = 100;
			}
		
		$icon = $this->getIcon($row->installedItemTypeID);
		if (strtotime($row->beginProductionTime) > strtotime($dateNow)) //Pending Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='red'><div class='textCenter'><img src='./images/clock_red.png'>Pending</div></font>";
			$dateEnd = "$dateEndTime";
			}
			elseif (strtotime($dateNow) > strtotime($row->endProductionTime)) //Finished Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Finished<div></font>";
			$dateEnd = "$dateEndTime";
			}
			else // Running Condition
			{
			$dateEnd = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<div class='textCenter'><img src='./images/time_go.png'>Running</div>";
			}
			
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/$icon'><a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: right;'>$charName->characterName</td>";
		echo "<td style='text-align: right;'><a href='http://evemaps.dotlan.net/system/$systemName->solarSystemName'>$systemName->solarSystemName</a></td>";
		echo "<td style='text-align: right;'>$row->runs</td>";
		echo "<td style='text-align: right;'>$row->installedItemMaterialLevel</td>";
		echo "<td style='text-align: right;'>$jobStatus</td>";
		echo "<td style='text-align: right;'>$dateEnd</td>";
		echo "<td style='text-align: right;'><div class='progress-container'><div style='width: $diff%'>$diff%</div></div></td>";
		echo "</tr>";
	$index++;
	}
?>
</tr>
</table>
</div>

<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_12.png" width="16" height="16">Production Efficiency</div></td>
<td style="text-align: right; width: 80px;">Character</td>
<td style="text-align: right; width: 60px;">System</td>
<td style="text-align: right; width: 45px;">Start PE</td>
<td style="text-align: right; width: 45px;">End PE</td>
<td style="text-align: right; width: 70px;">Status</td>
<td style="text-align: right; width: 80px;">End</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?php

$criteria = new CDbCriteria;
$criteria->condition = 'completed = 0 AND activityID = 3';
//$criteria->condition = 'completed = 0 AND activityID = 3 AND installerID IN '.$allMembersString.'';
$criteria->order = 'endProductionTime ASC';

$results = IndustryJobs::Model()->findAll($criteria);
$index=0;

	foreach ($results as $row)
	{
	
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		//Load the solarsystem information

		$systemInfo = new CDbCriteria;
		$systemInfo->condition = 'solarSystemID=:solarSystemID';
		$systemInfo->params = array(':solarSystemID'=>$row->installedInSolarSystemID);
		$systemName = MapSolarSystems::Model()->find($systemInfo);
		
		$charInfo = new CDbCriteria;
		$charInfo->condition = 'characterID=:characterID';
		$charInfo->params = array(':characterID'=>$row->installerID);
		$charName = Characters::Model()->find($charInfo);
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->installedItemTypeID);
		$itemName = Invtypes::Model()->find($itemInfo);
		
		$dateEnd = $row->endProductionTime;
		$dateBegin = $row->beginProductionTime;
		$dateNow = date('Y-m-d H:i:s', strtotime("+5 hour"));
		
		$diff = 100 - ((strtotime($dateEnd) - strtotime($dateNow)) / (strtotime($dateEnd) - strtotime($dateBegin))) * 100;
		$diff = number_format($diff, 1, '.', '');
		
		if ($diff > 100) // Handle case where job is completed
			{
			$diff = 100;
			}
		if ($diff < 0) // Handle case where job is pending
			{
			$diff = 0;
			}
		$icon = $this->getIcon($row->installedItemTypeID);
		$endPE = $row->installedItemProductivityLevel + $row->runs;
		if (strtotime($row->beginProductionTime) > strtotime($dateNow)) //Pending Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='red'><div class='textCenter'><img src='./images/clock_red.png'>Pending</div></font>";
			$dateEnd = "$dateEndTime";
			}
			elseif (strtotime($dateNow) > strtotime($row->endProductionTime)) //Finished Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Finished<div></font>";
			$dateEnd = "$dateEndTime";
			}
			else // Running Condition
			{
			$dateEnd = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<div class='textCenter'><img src='./images/time_go.png'>Running</div>";
			}
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/$icon'><a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: right;'>$charName->characterName</td>";
		echo "<td style='text-align: right;'><a href='http://evemaps.dotlan.net/system/$systemName->solarSystemName'>$systemName->solarSystemName</a></td>";
		echo "<td style='text-align: right;'>$row->installedItemProductivityLevel</td>";
		echo "<td style='text-align: right;'>$endPE</td>";
		echo "<td style='text-align: right;'>$jobStatus</td>";
		echo "<td style='text-align: right;'>$dateEnd</td>";
		echo "<td style='text-align: right;'><div class='progress-container'><div style='width: $diff%'>$diff%</div></div></td>";
		echo "</tr>";
	$index++;
	}
?>
</tr>
</table>
</div>

<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_11.png" width="16" height="16">Material Efficiency</div></td>
<td style="text-align: right; width: 80px;">Character</td>
<td style="text-align: right; width: 60px;">System</td>
<td style="text-align: right; width: 45px;">Start ME</td>
<td style="text-align: right; width: 45px;">End ME</td>
<td style="text-align: right; width: 70px;">Status</td>
<td style="text-align: right; width: 80px;">End</td>
<td style="text-align: right; width: 150px;">Progress</td>
</tr>

<?php

$criteria = new CDbCriteria;
$criteria->condition = 'completed = 0 AND activityID = 4';
//$criteria->condition = 'completed = 0 AND activityID = 4 AND installerID IN '.$allMembersString.'';
$criteria->order = 'endProductionTime ASC';

$results = IndustryJobs::Model()->findAll($criteria);
$index=0;

	foreach ($results as $row)
	{
	
	
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
		//Load the solarsystem information

		$systemInfo = new CDbCriteria;
		$systemInfo->condition = 'solarSystemID=:solarSystemID';
		$systemInfo->params = array(':solarSystemID'=>$row->installedInSolarSystemID);
		$systemName = MapSolarSystems::Model()->find($systemInfo);
		
		$charInfo = new CDbCriteria;
		$charInfo->condition = 'characterID=:characterID';
		$charInfo->params = array(':characterID'=>$row->installerID);
		$charName = Characters::Model()->find($charInfo);
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->installedItemTypeID);
		$itemName = Invtypes::Model()->find($itemInfo);
		
		$dateEnd = $row->endProductionTime;
		$dateBegin = $row->beginProductionTime;
		$dateNow = date('Y-m-d H:i:s', strtotime("+5 hour"));
		
		$diff = 100 - ((strtotime($dateEnd) - strtotime($dateNow)) / (strtotime($dateEnd) - strtotime($dateBegin))) * 100;
		if ($diff < 0) // Handle case where job is pending
			{
			$diff = 0;
			}			
		if ($diff > 100) // Handle case where job is completed
			{
			$diff = 100;
			}
			
		$diff = number_format($diff, 1, '.', '');
		$icon = $this->getIcon($row->installedItemTypeID);
		$endME = $row->installedItemMaterialLevel + $row->runs;
		if (strtotime($row->beginProductionTime) > strtotime($dateNow)) //Pending Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='red'><div class='textCenter'><img src='./images/clock_red.png'>Pending</div></font>";
			$dateEnd = "$dateEndTime";
			}
			elseif (strtotime($dateNow) > strtotime($row->endProductionTime)) //Finished Condition
			{
			$dateEndTime = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Finished<div></font>";
			$dateEnd = "$dateEndTime";
			}
			else // Running Condition
			{
			$dateEnd = date("m-d H:i",strtotime($dateEnd));
			$jobStatus = "<div class='textCenter'><img src='./images/time_go.png'>Running</div>";
			}
		
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/$icon'><a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: right;'>$charName->characterName</td>";
		echo "<td style='text-align: right;'><a href='http://evemaps.dotlan.net/system/$systemName->solarSystemName'>$systemName->solarSystemName</a></td>";
		echo "<td style='text-align: right;'>$row->installedItemMaterialLevel</td>";
		echo "<td style='text-align: right;'>$endME</td>";
		echo "<td style='text-align: right;'>$jobStatus</td>";
		echo "<td style='text-align: right;'>$dateEnd</td>";
		echo "<td style='text-align: right;'><div class='progress-container'><div style='width: $diff%'>$diff%</div></div></td>";
		echo "</tr>";
	$index++;
	}
?>
</tr>
</table>
</div>