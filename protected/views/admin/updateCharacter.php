<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'characters-updateCharacter-form',
	'enableAjaxValidation'=>false,
)); ?>

	<h1>Update <? echo $model->characterName; ?></h1>
	
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'characterID'); ?>
		<?php echo $form->textField($model,'characterID'); ?>
		<?php echo $form->error($model,'characterID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'characterName'); ?>
		<?php echo $form->textField($model,'characterName',array('size'=>40)); ?>
		<?php echo $form->error($model,'characterName'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'keyID'); ?>
		<?php echo $form->textField($model,'keyID'); ?>
		<?php echo $form->error($model,'keyID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vCode'); ?>
		<?php echo $form->textField($model,'vCode',array('size'=>100,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'vCode'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accountID'); ?>
		<?php echo $form->dropDownList($model,'accountID',$accountsArray); ?>
		<?php echo $form->error($model,'accountID'); ?>
	</div>
	
	<h2>Character Preferences</h2>
	
	<div class="row">
		<?php echo $form->checkBox($model,'limitUpdate'); ?>
		Supress updates before the specified date
		<?php echo $form->error($model,'limitUpdate'); ?>
	</div>
	
	<div class="row">
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		  'model'=>$model,
		  'attribute'=>'limitDate',
		  'value'=>$model->limitDate,
		  // additional javascript options for the date picker plugin
		  'options'=>array(
			'showAnim'=>'fade',
			'showButtonPanel'=>true,
			'autoSize'=>true,
			'dateFormat'=>'yy-mm-dd',
			'defaultDate'=>$model->limitDate,
		   ),
		));?>
		<?php echo $form->error($model,'accountID'); ?>
	</div>
	
	<h5>EVE API Feeds Enabled</h5>
	
	<div class="row">
		<?php echo $form->checkBox($model,'walletEnabled'); ?>
		Wallet Transactions
		<?php echo $form->error($model,'walletEnabled'); ?>
	</div>
	<div class="row">
		<?php echo $form->checkBox($model,'journalEnabled'); ?>
		Wallet Journal
		<?php echo $form->error($model,'journalEnabled'); ?>
	</div>
	<div class="row">
		<?php echo $form->checkBox($model,'ordersEnabled'); ?>
		Market Orders
		<?php echo $form->error($model,'ordersEnabled'); ?>
	</div>
	
	<h5>Display Preferences</h5>
	<div class="row">
		<?php echo $form->checkBox($model,'displayBalance'); ?>
		Display wallet balance on Overview
		<?php echo $form->error($model,'displayBalance'); ?>
	</div>
	<div class="row">
		<?php echo $form->checkBox($model,'displayOrders'); ?>
		Display market orders
		<?php echo $form->error($model,'displayOrders'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Update'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->