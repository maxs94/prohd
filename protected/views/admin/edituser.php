<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-edituser-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="formcenter">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'fullName'); ?>
		<?php echo $form->textField($model,'fullName'); ?>
		<?php echo $form->error($model,'fullName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userName'); ?>
		<?php echo $form->textField($model,'userName'); ?>
		<?php echo $form->error($model,'userName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userLevel'); ?>
		<?php echo $form->textField($model,'userLevel'); ?>
		<?php echo $form->error($model,'userLevel'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'trackingGroupID'); ?>
		<?php echo $form->textField($model,'trackingGroupID'); ?>
		<?php echo $form->error($model,'trackingGroupID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->