<?php

//Acquire skill in training
$characterTable = Characters::Model()->find('characterID=:characterID',array(':characterID'=>$data->characterID));

$skillAPI = new APISkillInTraining;
$skills = $skillAPI->getEVEData($characterTable->walletID);
?>
<div style="width: 100%;" class="characterstats">
	<h1 class="header1"><B><?php echo $data->characterName; ?></B></h1>
	
	<table>
	<tr>
	<td>
	
	<div style="width: 150px; height: 150px; margin-right: 2px;">
		<img src="http://image.eveonline.com/Character/<?php echo $data->characterID; ?>_200.jpg" height="150" width="150">
	</div>
	
	<div style="margin-top: 0px; margin-bottom: 0px; width: 150px;" class="affiliationstats">
		<div style="width: 200px;">
			<img src="http://image.eveonline.com/Corporation/<?php echo $data->corporationID; ?>_32.png" style="float:left; margin-right:2px;">
			<div style="margin-left: 0px;">
				<a href="http://evemaps.dotlan.net/corp/<?php echo $data->corporation; ?>"><?php echo $data->corporation; ?></a><BR>
				<?php echo $data->corporationDate; ?>
			</div>
		</div>
		<div style="clear: both; width:1px;"></div>
		<div style="width: 200px;">
			<img src="http://image.eveonline.com/Alliance/<?php echo $data->allianceID; ?>_32.png" style="float:left; margin-right:2px;">
			<div style="margin-left: 0px;">
				<a href="http://evemaps.dotlan.net/alliance/<?php echo $data->alliance; ?>"><?php echo $data->alliance; ?></a><BR>
				<?php echo $data->allianceDate; ?>
			</div>
		</div>
		<div style="clear: both; width:1px;"></div>
	</div>
	
	</td>
	<td style="vertical-align:top">
	
	<div style="clear: both;"></div>
	
	<div class="currentstats" style="width: 370px">
	<table>
		<tr class="header1">
			<td style="text-align: left; width: 100px;"><div class='textCenter'><img src="images/items/icon18_03.png" width="16" height="16">Item</div></td>
			<td style="text-align: left; width: 300px;">Detail</td>
		</tr>
		<tr>
			<td>Skill Points</td>
			<td><?php echo number_format((int)$data->skillPoints,0); ?></td>
		</tr>
		<tr class='odd'>
			<td>Location</td>
			<td><?php echo $data->lastKnownLocation; ?></td>
		</tr>
		<tr>
			<td>Active Ship</td>
			<td><?php echo $data->shipName; ?> - <?php echo $data->shipTypeName?></td>
		</tr>
		<tr class='odd'>
			<td>Security Status</td>
			<td><?php echo number_format((float)$data->securityStatus,3); ?></td>
		</tr>
		<tr>
			<td>Account Balance</td>
			<td><?php echo number_format((float)$data->accountBalance,2); ?></td>
		</tr>
	</table>
	</div>
	
	</td>
	<td style="vertical-align:top">
	
	<div class="currentstats" style="width: 300px">
	<table>
		<tr class="header1">
			<td style="text-align: left; width: 100px;"><div class='textCenter'><img src="images/items/icon25_14.png" width="16" height="16">Training Item</div></td>
			<td style="text-align: left; width: 200px;">Detail</td>
		</tr>
		<tr>
			<td>Training</td>
		<?
		if ($skills->result->skillInTraining == 0)
			{
				$currentSkill = "<font color='red'>There is no skill currently in training.</font>";
			}
			else
			{
				$typeData = Invtypes::Model()->findByPk($skills->result->trainingTypeID);
				$level = $skills->result->trainingToLevel;
				$finishes = $skills->result->trainingEndTime;
				$starts = $skills->result->trainingStartTime;
				$currentSkill = "";
			$dateNow = date('Y-m-d H:i:s', strtotime("+4 hour"));
			$diff = 100 - ((strtotime($finishes) - strtotime($dateNow)) / (strtotime($finishes) - strtotime($starts))) * 100;
			$diff = number_format($diff, 1, '.', '');
			if ($diff > 100)
				{
				$diff = 0;
				}
			$progressBar = 	"<div class='progress-container'><div style='width:$diff%'>$diff%</div></div>";
			}
		?>
		<td><?php echo "$typeData->typeName $level $currentSkill";?></td>
		</tr>
		<tr class='odd'>
			<td>Finishes</td>
			<td><?php echo $finishes; ?></td>
		</tr>
		<tr>
			<td>Progress</td>
			<td><?php echo $progressBar; ?></td>
		</tr>
	</table>
	</div>
	
	</td>
	</tr>
	</table>
	
	<!-- <img height="32" width="32" src="./images/items/<? echo $data->shipTypeID ?>.png"> -->
</div>
<div style="clear: both;"></div>
<BR>
	