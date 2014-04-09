<?php
$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$model->transactionID,
);

$this->menu=array(
	array('label'=>'List Transactions', 'url'=>array('index')),
	array('label'=>'Create Transactions', 'url'=>array('create')),
	array('label'=>'Update Transactions', 'url'=>array('update', 'id'=>$model->transactionID)),
	array('label'=>'Delete Transactions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->transactionID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transactions', 'url'=>array('admin')),
);
?>

<h1>View Transactions #<?php echo $model->transactionID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'transactionDateTime',
		'transactionID',
		'quantity',
		'typeName',
		'typeID',
		'price',
		'clientID',
		'clientName',
		'characterID',
		'stationID',
		'stationName',
		'transactionType',
	),
)); ?>
