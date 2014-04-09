<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->itemID), array('view', 'id'=>$data->itemID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('characterID')); ?>:</b>
	<?php echo CHtml::encode($data->characterID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locationID')); ?>:</b>
	<?php echo CHtml::encode($data->locationID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeID')); ?>:</b>
	<?php echo CHtml::encode($data->typeID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flag')); ?>:</b>
	<?php echo CHtml::encode($data->flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('singleton')); ?>:</b>
	<?php echo CHtml::encode($data->singleton); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('containerID')); ?>:</b>
	<?php echo CHtml::encode($data->containerID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('locationName')); ?>:</b>
	<?php echo CHtml::encode($data->locationName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeName')); ?>:</b>
	<?php echo CHtml::encode($data->typeName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groupID')); ?>:</b>
	<?php echo CHtml::encode($data->groupID); ?>
	<br />

	*/ ?>

</div>