<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wallet-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'transactionDateTime'); ?>
		<?php echo $form->textField($model,'transactionDateTime'); ?>
		<?php echo $form->error($model,'transactionDateTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typeName'); ?>
		<?php echo $form->textField($model,'typeName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'typeName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'typeID'); ?>
		<?php echo $form->textField($model,'typeID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'typeID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profit'); ?>
		<?php echo $form->textField($model,'profit'); ?>
		<?php echo $form->error($model,'profit'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'clientID'); ?>
		<?php echo $form->textField($model,'clientID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'clientID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clientName'); ?>
		<?php echo $form->textField($model,'clientName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'clientName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'characterID'); ?>
		<?php echo $form->textField($model,'characterID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'characterID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stationID'); ?>
		<?php echo $form->textField($model,'stationID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'stationID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stationName'); ?>
		<?php echo $form->textField($model,'stationName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'stationName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transactionType'); ?>
		<?php echo $form->textField($model,'transactionType',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'transactionType'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->