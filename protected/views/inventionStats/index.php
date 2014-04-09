<?php
$this->breadcrumbs=array(
	'Invention Stats',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

<div class="currentstats" style="width: 550px;">
<table>
<tr class="header1">
<td style="text-align: left; width: 350px;">Blueprint</td>
<td style="text-align: left; width: 50px;">Success</td>
<td style="text-align: left; width: 50px;">Total</td>
<td style="text-align: left; width: 150px;">Performance</td>
</tr>
<?
$index = 0;
$results = $this->getInventionTypes();
	foreach ($results as $row)
	{
	if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";

	$total = $this->inventionCalcTotal($row['typeID']);
	$totalJobs = $totalJobs + $total;
	$success = $this->inventionCalcSuccess($row['typeID']);
	$totalSuccess = $totalSuccess + $success;
	$diff = number_format(($success / $total) * 100,1);
			
	echo "<td style='text-align: left;'><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row[typeID]."_32.png'><a href='index.php?r=wallet/item&id=$row[typeID]'>".$this->getName($row['typeID'])."</div></td>";
	echo "<td style='text-align: left;'>".$success."</td>";
	echo "<td style='text-align: left;'>".$total."</td>";
	echo "<td style='text-align: right;'><div class='progress-container'><div style='width: ".$diff."%'>".$diff."%</div></div></td>";
	echo "</tr>";
	$index++;
	}
	echo "</tr>";
	
	echo "<tr>";
	echo "<td></td>";
	echo "<td><div class='totalBorder'><B>".$totalSuccess."</B></div></td>";
	echo "<td><div class='totalBorder'><B>".$totalJobs."</B></div></td>";
	$diff = number_format(($totalSuccess/$totalJobs) * 100,1);
	echo "<td style='text-align: right;'><div class='progress-container-invention'><div style='width: ".$diff."%'>".$diff."%</div></div></td>";
	echo "</tr>";

?>
</table>
</div>

<BR>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left; width: 280px;">Blueprint</td>
<td style="text-align: left; width: 50px;">Install ME</td>
<td style="text-align: left; width: 50px;">Install PE</td>
<td style="text-align: left; width: 70px;">Install Runs</td>
<td style="text-align: left; width: 70px;">Status</td>
<td style="text-align: left width: 80px;">Result</td>
<td style="text-align: left width: 80px;">Finish</td>
<td style="text-align: left; width: 50px;">End Runs</td>
<td style="text-align: left; width: 50px;">End ME</td>
</tr>

<?php

$index=0;
$criteria = new CDbCriteria;
$criteria->order = 'endProductionTime DESC';
$criteria->condition = 'activityID = 8';

$results = IndustryJobs::Model()->findAll($criteria);
	foreach ($results as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->outputTypeID);
		$itemName = Invtypes::Model()->find($itemInfo);
	
		//$icon = $this->getIcon($row->blueprintID);
	
		//$t2blueprint = $this->findT2Blueprints($row->typeID);
		
		$dateNow = date('Y-m-d H:i:s', strtotime("+4 hour"));
		$dateEnd = $row->endProductionTime;
		//$dateEnd = date("m-d H:i",strtotime($dateEnd));
		
		if ($row->completedStatus > 0 & $row->completed > 0)
			{
			$jobResult = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Success<div></font>";
			}
			elseif ($row->completed == 0)
			{
			$jobResult = "";
			}
			else
			{
			$jobResult = "<font color='red'><div class='textCenter'><img src='./images/exclamation.png'>Failure<div></font>";
			}
			
		if (strtotime($row->beginProductionTime) > strtotime($dateNow))
			{
			$jobStatus = "<font color='red'><div class='textCenter'><img src='./images/clock_red.png'>Pending</div></font>";
			$dateEnd = "<font color='red'>$row->beginProductionTime</font>";
			//$dateEnd = date("m-d H:i",strtotime($dateEnd));
			}
			elseif (strtotime($dateNow) > strtotime($row->endProductionTime))
			{
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/accept.png'>Finished<div></font>";
			$dateEnd = "$row->endProductionTime";
			//$dateEnd = date("m-d H:i",strtotime($dateEnd));
			}
			else
			{
			$jobStatus = "<font color='green'><div class='textCenter'><img src='./images/time_go.png'>Running</div></font>";
			}	
	
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row->outputTypeID."_32.png'><a href='index.php?r=wallet/item&id=$row->outputTypeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: left;'>".$row->installedItemMaterialLevel."</td>";
		echo "<td style='text-align: left;'>".$row->installedItemProductivityLevel."</td>";
		echo "<td style='text-align: left;'>".$row->installedItemLicensedProductionRunsRemaining."</td>";
		echo "<td style='text-align: left;'>$jobStatus</td>";
		echo "<td style='text-align: left;'>$jobResult</td>";
		echo "<td style='text-align: left;'>$dateEnd</td>";
		echo "<td style='text-align: left;'>".$row->licensedProductionRuns."</td>";
		echo "<td style='text-align: left;'>".$row->materialMultiplier."</td>";
		echo "</tr>";
	$index++;
	}
?>
</tr>
</table>
</div>