<?php
$this->breadcrumbs=array(
	'BPC Stock',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>

<div class="currentstats">
<table>
<tr class="header1">
<td style="text-align: left; width: 220px;">Blueprint</td>
<td style="text-align: right; width: 10px;">Stock</td>
<td style="text-align: right; width: 10px;">Value</td>
<td style="text-align: right; width: 50px;">Total</td>
</tr>

<?php

$index=0;
$criteria = new CDbCriteria;
$criteria->select='SUM(quantity) AS quantity, typeID';
$criteria->order='typeName ASC';
$criteria->condition = 'groupID IN (915,525,643) GROUP BY typeID';
$results = Assets::Model()->findAll($criteria);

	foreach ($results as $row)
	{
		if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
		
		$itemInfo = new CDbCriteria;
		$itemInfo->condition = 'typeID=:typeID';
		$itemInfo->params = array(':typeID'=>$row->typeID);
		$itemName = Invtypes::Model()->find($itemInfo);
		
		//TEMP
		// Need to figure out BPC value
		$value = 1.0;
	
		echo "<td><div class='textCenter'><img style='height: 20px; width: 20px;' src='http://image.eveonline.com/Type/".$row->typeID."_32.png'><a href='index.php?r=wallet/item&id=$row->typeID'>$itemName->typeName</div></td>";
		echo "<td style='text-align: right;'>$row->quantity</td>";
		echo "<td style='text-align: right;'>".$value."</td>";
		echo "<td style='text-align: right;'>Stock*Value</td>";
		echo "</tr>";
	$valueTotal = $valueTotal + $value;
	$stockTotal = $stockTotal + $row->quantity;
	
	$index++;
	}
	if ($index % 2)
			echo "<tr class='odd'>";
		else
			echo "<tr>";
			
	echo "<td></td>";
	echo "<td style='text-align: right;'><B>".number_format($stockTotal,0)."</B></td>";
	echo "<td style='text-align: right;'><B>".number_format($valueTotal,0)."</B></td>";
	echo "<td></td>";
	echo "</tr>";
?>
</tr>
</table>
</div>