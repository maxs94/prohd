<?php
$this->breadcrumbs=array(
	'Assets'=>array('index'),
	$model->itemID=>array('view','id'=>$model->itemID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Assets', 'url'=>array('index')),
	array('label'=>'Create Assets', 'url'=>array('create')),
	array('label'=>'View Assets', 'url'=>array('view', 'id'=>$model->itemID)),
	array('label'=>'Manage Assets', 'url'=>array('admin')),
);
?>

<h1>Update Assets <?php echo $model->itemID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>