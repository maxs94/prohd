<?php
$this->breadcrumbs=array(
	'Assets',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);

$assetInterface = new APIAssetList;

$groupMembersArray = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
$groupMembersString = "(".implode(",",$groupMembersArray).")";

if(!($assetInterface->getCacheExpiration($groupMembers[0]->characterID)))
{
//	$groupMembersArray = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
//	$groupMembersString = "(".implode(",",$groupMembersArray).")";
	Assets::Model()->deleteAll('characterID IN '.$groupMembersString);
	
	foreach ($groupMembers as $member)
	{
		$assetInterface->storeData($member->characterID);
		$assets = $assetInterface->getEVEData($member->characterID);
	}
}

$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.treeTable.js', CClientScript::POS_HEAD);  
$cs->registerCssFile(Yii::app()->baseUrl . '/css/jquery.treeTable.css');
?>

<script type="text/javascript">
  
$(document).ready(function()  {
  $("#assets").treeTable();
});
  
</script>

<table id="assets" style="font-size: 12px">
	<tr class="header1">
		<td>Location</td>
		<td>Quantity</td>
	</tr>
	<?php
	
		//Find all the distinct locations of our assets
		$criteria = new CDbCriteria;
		$criteria->select = 'locationName, locationID';
		$criteria->distinct = true;
		$criteria->condition = 'containerID=0 AND characterID IN '.$groupMembersString.'';
		$criteria->order='locationName';
		$assetLocations = Assets::Model()->findAll($criteria);
		
		//Loop through our asset locations
		foreach ($assetLocations as $assetLocation)
		{?>
			<tr id="node-<?php echo $assetLocation->locationID; ?>">
				<td style="background-color: #F4F4F4; border-bottom: 1px solid light-gray"><?php echo $assetLocation->locationName; ?></td>
				<td style="background-color: #F4F4F4"></td>
			</tr>
		<?php
			//Determine the asset location's children
			$criteria = new CDbCriteria;
			$criteria->condition='containerID=0 AND locationID=:locationID AND characterID IN '.$groupMembersString.'';
			$criteria->order='groupID, typeName';
			$criteria->params = array(':locationID'=>$assetLocation->locationID);
			$baseAssets = Assets::Model()->findAll($criteria);
			
			//Loop through the base assets for this location
			$idx1 = 1;
			foreach ($baseAssets as $baseAsset)
			{?>
			<? $icon = $this->getIcon($baseAsset->typeID); ?>
				<tr id="node-<?php echo $assetLocation->locationID; ?>-<?php echo $baseAsset->itemID; ?>" class="child-of-node-<?php echo $assetLocation->locationID; ?> <?if ($idx1 % 2) echo odd ?>">
					<td><img style='height: 18px; width: 18px; margin-right: 4px;' src='./images/items/<? echo $icon; ?>'><?php echo $baseAsset->typeName; ?></td>
					<td><?php echo number_format($baseAsset->quantity,0); $idx1++;?></td>
				</tr>
			<?php
				
				//Check the base assets for containership
				$contents = Assets::Model()->findAll('containerID=:containerID AND characterID IN '.$groupMembersString.'',array(':containerID'=>$baseAsset->itemID));
				if ($contents)
				{
					$idx = 1;
					foreach ($contents as $content)
					{?>
					<? $icon = $this->getIcon($content->typeID); ?>

						<tr id="node-<?php echo $assetLocation->locationID; ?>-<?php echo $baseAsset->itemID; ?>-<?php echo $content->itemID; ?>" class="child-of-node-<?php echo $assetLocation->locationID; ?>-<?php echo $baseAsset->itemID; ?>" <?if ($idx % 2) echo 'style="background-color: #F0FFE6"' ?>">
							<td><div class='textCenter'><img style='height: 18px; width: 18px; margin-right: 4px;' src='./images/items/<? echo $icon; ?>'><?php echo $content->typeName; ?></div></td>
							<td><?php echo number_format($content->quantity,0); $idx++; ?></td>
						</tr>
					<?php
					}
				}
			}
		}
?>
</table>