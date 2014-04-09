<?php
$this->breadcrumbs=array(
	'Characters',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<h1>Character Summary - <?php echo $group->name; ?></h1>



<?php 

	$characters = $this->getCharacters();
	
	$dataProvider=new CArrayDataProvider($this->getCharacters(), array(
		'id'=>'characters',
		'pagination'=>array(
			'pageSize'=>25,
		),
	));
	

	$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>'{items}',
	)); 
?>


