<table>
	<tr class="header1">
		<td><div class='textCenter'><img src="images/items/2_64_16.png" width="16" height="16">Character</div></td>
		<td style="text-align: right; width: 30px;">Balance</td>
	</tr>
	<?php
	$i=0;
	$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
	$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);
	foreach ($groupMembers as $member)
	{
		$character = Characters::Model()->findByPk($member->characterID);
		$sheetInterface = new APICharacterSheet;
		if (!($sheetInterface->getCacheExpiration($member->characterID)))
		{
			$balance = (float)$this->getBalance($member->characterID);
			$balanceRow = new Balances;
			$balanceRow->characterID = $character->characterID;
			$balanceRow->balanceDateTime = $this->getEveTimeSql();
			$balanceRow->balance = $balance;
			$balanceRow->save();
		}
		else
		{
			$balance = (float)$this->getBalance($member->characterID);
		}
		$balanceText = number_format($balance,0);
		
		
		if ($character->displayBalance)
		{
			if ($i % 2)
				echo "<tr class='odd'>";
			else
				echo "<tr>";
				

			
			
			echo	'<td><div style="float:left"><div class="textCenter"><img src="http://image.eveonline.com/Character/'.$character->characterID.'_200.jpg" height="16" width="16">'.$character->characterName.'</div></div></td>';
			echo		"<td style='text-align: right;'><font color='green'>+$balanceText</font></td>";
			echo		"</tr>";
			
			$totalBalance = $totalBalance + $balance;
			$i++;
		}
	}
	?>
	<tr class="total">
		<td style="text-align: right;"><B><?php echo $group->name; ?> Total</B></td>
		<td style="text-align: right;"><font color="green"><B>+<?php echo number_format(($totalBalance),0); ?></B></font></td>
	</tr>
</table>