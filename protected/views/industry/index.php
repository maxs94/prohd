<?php
$this->breadcrumbs=array(
	'Industry Projects',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);

?>

<h1>Industry Projects - <?php echo $group->name; ?></h1>
<div class="currentstats">
	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$projects,
		'columns'=>array(
			'projectName',
			array(
				'name'=>'typeID',
				'value'=>'Invtypes::Model()->findByPk($data->typeID)->typeName'
			),
			array(
				'name'=>'characterID',
				'value'=>'Characters::Model()->find("characterID=:characterID",array(":characterID"=>$data->characterID))->characterName'
			),
			array(
				'name'=>'stationID',
				'value'=>'ConqStations::Model()->findByPk($data->stationID)->stationName'
			),
			'creationDateTime'
		)
	));
	?>
</div>
<?php echo CHtml::link('Start New Project', array('industry/start')); ?>
