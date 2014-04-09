<?php
$this->breadcrumbs=array(
	'Corp Assets',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);

$assetInterface = new APICorpAssetList;

$corpKeys = $this->getCorpKeys(Yii::app()->user->trackingGroupID);

if(!($assetInterface->getCacheExpiration($corpKeys[0]['walletID'])))
{
//	$groupMembersArray = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
//	$groupMembersString = "(".implode(",",$groupMembersArray).")";
	CorpAssets::Model()->deleteAll();
        
	$assetInterface->storeData($corpKeys[0]['walletID']);
	$assets = $assetInterface->getEVEData($corpKeys[0]['walletID']);
}

$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.treeTable.js', CClientScript::POS_HEAD);  
$cs->registerCssFile(Yii::app()->baseUrl . '/css/jquery.treeTable.css');
?>

<script type="text/javascript">
  
$(document).ready(function()  {

	$("#assets").treeTable();
  
	$("#asset-dialog").dialog({
		modal: true,
		autoOpen: false,
		resizable: false,
		title: 'Updating Asset Values',
		beforeClose: function(event, ui) {
			return false;
		}
	});
	
	$('#asset-refresh').click(function(){
		//Get the assets from our controller
		$.getJSON('./index.php?r=corpAssets/getAssetsJson', function(data) {
			
			var assets = [];
			assets = data;
			var i = 0;
			var number = 0;
			
			//Open the dialog box
			$('#asset-dialog').dialog('open');
			
			$.each(assets, function(id, name) {
				
				number = i + 1;
				$('#asset-dialog-currentaction').html(number + ' of ' + assets.length + ': ' + name[1]);
				$.ajax({
					url: './index.php?r=assets/storeValue',
					data: 'id=' + name[0],
					async: false
				});
				$('#asset-dialog-progressbar').progressbar('value', (i / assets.length) * 100);
				i++;
			});
			
			$('#asset-dialog').dialog('option', 'beforeClose', function(){return true;});
			$('#asset-dialog').dialog('close');
		});
	});
	
	$('#asset-dialog-progressbar').progressbar({
		value: 0
	});
	
});
  
</script>
<h1>Corp Assets - <?php echo $group->name; ?></h1>
<a href='#' style='float:right' id='asset-refresh'>Refresh Asset Values</a>
<br><br>
<table id="assets" style="font-size: 12px">
	<tr class="header1">
		<td>Location</td>
		<td style="text-align: right">Quantity</td>
		<td style="text-align: right">Value</td>
	</tr>
	<?php
	
		//Find all the distinct locations of our assets
		$criteria = new CDbCriteria;
		$criteria->select = 'locationName, locationID';
		$criteria->distinct = true;
		$criteria->condition = 'containerID=0';
		$criteria->order='locationName';
		$assetLocations = CorpAssets::Model()->findAll($criteria);
		
		//Loop through our asset locations
		foreach ($assetLocations as $assetLocation)
		{?>
			<tr id="node-<?php echo $assetLocation->locationID; ?>">
				<td style="background-color: #F4F4F4; border-bottom: 1px solid light-gray"><?php echo $assetLocation->locationName; ?></td>
				<td style="background-color: #F4F4F4"></td>
				<td style="background-color: #F4F4F4"></td>
			</tr>
		<?php
			//Determine the asset location's children
			$criteria = new CDbCriteria;
			$criteria->condition='containerID=0 AND locationID=:locationID';
			$criteria->order='groupID, typeName';
			$criteria->params = array(':locationID'=>$assetLocation->locationID);
			$baseAssets = CorpAssets::Model()->with('values')->findAll($criteria);
			
			//Loop through the base assets for this location
			$idx1 = 1;
			foreach ($baseAssets as $baseAsset)
			{
			?>
			<? $icon = $this->getIcon($baseAsset->typeID); $idx1++;?>
				<tr id="node-<?php echo $assetLocation->locationID; ?>-<?php echo $baseAsset->itemID; ?>" class="child-of-node-<?php echo $assetLocation->locationID; ?> <?if ($idx1 % 2) echo odd ?>">
					<td><img style='height: 18px; width: 18px; margin-right: 4px;' src='http://image.eveonline.com/Type/<? echo $icon; ?>'><?php echo $baseAsset->typeName; ?></td>
					<td style="text-align: right;"><?php echo number_format($baseAsset->quantity,0); ?></td>
					<td style="text-align: right"><?php echo number_format((($baseAsset->values->value * $baseAsset->quantity)/1000000),2) ?>M</td>
				</tr>
			<?php
				
				//Check the base assets for containership
				$contents = CorpAssets::Model()->with('values')->findAll('containerID=:containerID',array(':containerID'=>$baseAsset->itemID));
				if ($contents)
				{
					$idx = 1;
					foreach ($contents as $content)
					{?>
					<? $icon = $this->getIcon($content->typeID); $idx++; ?>

						<tr id="node-<?php echo $assetLocation->locationID; ?>-<?php echo $baseAsset->itemID; ?>-<?php echo $content->itemID; ?>" class="child-of-node-<?php echo $assetLocation->locationID; ?>-<?php echo $baseAsset->itemID; ?>" <?if ($idx % 2) echo 'style="background-color: #F0FFE6"' ?>">
							<td><div class='textCenter'><img style='height: 18px; width: 18px; margin-right: 4px;' src='http://image.eveonline.com/Type/<? echo $icon; ?>'><?php echo $content->typeName; ?></div></td>
							<td><?php echo number_format($content->quantity,0); ?></td>
							<td style="text-align: right"><?php echo number_format((($content->values->value * $content->quantity)/1000000),2) ?>M</td>
						</tr>
					<?php
					}
				}
			}
		}
?>
</table>
<?
//Create the delete user dialog
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogload',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
    ),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<div id='asset-dialog'>
	<p>Updating your asset values from Eve Central. This may take some time.</p>
	<div id='asset-dialog-currentaction'></div>
	<div id='asset-dialog-progressbar'></div>
</div>