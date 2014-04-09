<?php
$this->breadcrumbs=array(
	'Wallets'=>array('index'),
	$model->transactionID=>array('view','id'=>$model->transactionID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Create Wallet', 'url'=>array('create')),
	array('label'=>'View Wallet', 'url'=>array('view', 'id'=>$model->transactionID)),
	array('label'=>'Manage Wallet', 'url'=>array('admin')),
);
?>

<h1>Update Wallet <?php echo $model->transactionID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>