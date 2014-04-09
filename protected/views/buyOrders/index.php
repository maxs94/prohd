<?php
$this->breadcrumbs=array(
	'Buy Orders',
);

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);

//Check on our cache value
$orderInterface = new APIOrders;

if(!($orderInterface->getCacheExpiration($groupMembers[0]->characterID)))
{
	?>
		<script type="text/javascript">
			$(function() {
				$.gritter.add({
					title: 'Updating API',
					text: 'Your orders are being updated...',
					time: 4000,
					image: '<?php echo Yii::app()->request->baseUrl; ?>/images/repeat-icon.png'
				});
			});
		</script>
	<?
	
	$request  = CHtml::ajax(array(
		'url'=>'index.php?r=sellOrders/indexAjax',
		'success'=>'js:function(){
			$.gritter.add({
				title: "Update Complete",
				text: "You may refresh the page.",
				time: 4000,
				image: "'.Yii::app()->request->baseUrl.'/images/repeat-icon.png"
			});
		}'
	));
		
	Yii::app()->clientScript->registerScript('updateapi',$request,CClientScript::POS_READY);
}

?>
<hr>
<?php

foreach ($groupMembers as $member)
{
	$character = Characters::Model()->findByPk($member->characterID);
	
	if ($character->displayOrders)
	{
		//Retrieve our API data
		$orders = $this->getOrdersDataProvider($member->characterID);
		
		$total = $this->getOrderTotal($member->characterID);
		
		$niceTotal = number_format(round(($total / 1000000),2),2);
		
		echo "<div style='float:left'><div class='textCenter'><img src='http://image.eveonline.com/Character/".$character->characterID."_200.jpg' height='36' width='36'></div></div>";
		
		echo "<div style='float:left'><B>$character->characterName</B><BR>Total Order Value: $niceTotal</div>";
		
		echo "<div style='clear: both;'></div>";

		$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$orders,
		'itemView'=>'_view',
		'template'=>
			'{summary}
			<div class="view">
				<table>
					<col width="20%">
					<col width="5%">
					<col width="5%">
					<col width="5%">
					<col width="25%">
					<col width="12%">
					<col width="12%">
					<col width="17%">
					<tr class="header1">
					<td>Station ID</td>
					<td>Rem</td>
					<td>Ent</td>
					<td>%</td>
					<td>Item</td>
					<td style="text-align: right">Price</td>
					<td style="text-align: right">Value</td>
					<td>Expires</td>
					</tr>
					{items}
				</table>
			</div>
			{pager}',
		));
	}
echo "<BR>";
}
?>