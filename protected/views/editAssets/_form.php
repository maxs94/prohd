<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assets-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'characterID'); ?>
		<?php echo $form->textField($model,'characterID'); ?>
		<?php echo $form->error($model,'characterID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'locationID'); ?>
		<?php echo $form->textField($model,'locationID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'locationID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typeID'); ?>
		<?php echo $form->textField($model,'typeID'); ?>
		<?php echo $form->error($model,'typeID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'flag'); ?>
		<?php echo $form->textField($model,'flag'); ?>
		<?php echo $form->error($model,'flag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'singleton'); ?>
		<?php echo $form->textField($model,'singleton'); ?>
		<?php echo $form->error($model,'singleton'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'containerID'); ?>
		<?php echo $form->textField($model,'containerID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'containerID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'locationName'); ?>
		<?php echo $form->textField($model,'locationName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'locationName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typeName'); ?>
		<?php echo $form->textField($model,'typeName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'typeName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groupID'); ?>
		<?php echo $form->textField($model,'groupID'); ?>
		<?php echo $form->error($model,'groupID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->