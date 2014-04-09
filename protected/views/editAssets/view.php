<?php
$this->breadcrumbs=array(
	'Assets'=>array('index'),
	$model->itemID,
);

$this->menu=array(
	array('label'=>'List Assets', 'url'=>array('index')),
	array('label'=>'Create Assets', 'url'=>array('create')),
	array('label'=>'Update Assets', 'url'=>array('update', 'id'=>$model->itemID)),
	array('label'=>'Delete Assets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->itemID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Assets', 'url'=>array('admin')),
);
?>

<h1>View Assets #<?php echo $model->itemID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'characterID',
		'itemID',
		'locationID',
		'typeID',
		'quantity',
		'flag',
		'singleton',
		'containerID',
		'locationName',
		'typeName',
		'groupID',
	),
)); ?>
