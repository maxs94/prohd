<?php
$this->breadcrumbs=array(
	'Wallets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Manage Wallet', 'url'=>array('admin')),
);
?>

<h1>Create Wallet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>