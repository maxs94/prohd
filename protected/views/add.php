<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'characters-add-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'walletID'); ?>
		<?php echo $form->textField($model,'walletID'); ?>
		<?php echo $form->error($model,'walletID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'characterID'); ?>
		<?php echo $form->textField($model,'characterID'); ?>
		<?php echo $form->error($model,'characterID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'characterName'); ?>
		<?php echo $form->textField($model,'characterName'); ?>
		<?php echo $form->error($model,'characterName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userID'); ?>
		<?php echo $form->textField($model,'userID'); ?>
		<?php echo $form->error($model,'userID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apiKey'); ?>
		<?php echo $form->textField($model,'apiKey'); ?>
		<?php echo $form->error($model,'apiKey'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accountID'); ?>
		<?php echo $form->textField($model,'accountID'); ?>
		<?php echo $form->error($model,'accountID'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->