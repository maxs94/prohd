<?php
$this->breadcrumbs=array(
	'Assets',
);

$this->menu=array(
	array('label'=>'Create Assets', 'url'=>array('create')),
	array('label'=>'Manage Assets', 'url'=>array('admin')),
);
?>

<h1>Assets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
