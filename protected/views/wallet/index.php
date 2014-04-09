<?php
$this->breadcrumbs=array(
	'Transactions',
);

$this->menu=array(
	array('label'=>'Create Transactions', 'url'=>array('create')),
	array('label'=>'Manage Transactions', 'url'=>array('admin')),
);

?>
<div style="float: right; margin-bottom:10px;">Search: 
<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name'=>'item',
    'sourceUrl'=>'index.php?r=wallet/search',
    // additional javascript options for the autocomplete plugin
    'options'=>array(
        'minLength'=>'3',
		'select'=>'js:
			function (event, ui)
			{
				window.location = "index.php?r=wallet/item&id=" + ui.item.id;
			}',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px; width: 250px;'
    ),
));
echo "</div><div class='clear'></div>";

//Check on our cache value
$transactionInterface = new APITransactions;

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);


if(!($transactionInterface->getCacheExpiration($groupMembers[0]->characterID)))
{
	?>
		<script type="text/javascript">
			$(function() {
				$.gritter.add({
					title: 'Updating API',
					text: 'Your transactions are being updated...',
					time: 4000,
					image: '<?php echo Yii::app()->request->baseUrl; ?>/images/repeat-icon.png'
				});
			});
		</script>
	<?

	$request  = CHtml::ajax(array(
		'url'=>'index.php?r=wallet/updateajax',
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

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<hr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>'{summary}{pager}{items}{pager}',
)); 
?>