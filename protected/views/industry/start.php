<h1>Start Industry Project</h1>
<div class="currentstats" style="padding: 10px">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'projects-start-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<label>Project Name</label>
			<?php echo $form->textField($model,'projectName'); ?>
			<?php echo $form->error($model,'projectName'); ?>
		</div>
		
		<div class="row">
			<label>Item</label>
			<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'name'=>'item',
				'sourceUrl'=>'index.php?r=wallet/search',
				// additional javascript options for the autocomplete plugin
				'options'=>array(
					'minLength'=>'3',
					'select'=>'js:
						function (event, ui)
						{
							var itemID = ui.item.id;
							alert(itemID);
							$("#typeIDHidden").val(itemID);
						}',
				),
				
				'htmlOptions'=>array(
					'style'=>'height:20px; width: 250px;'
				),
			));
			?>
			<?php echo $form->error($model,'typeID'); ?>
		</div>

		<div class="row">
			<label>Manufacturing Station</label>
			<?php echo $form->textField($model,'stationID'); ?>
			<?php echo $form->error($model,'stationID'); ?>
		</div>

		<div class="row">
			<label>Character</label>
			<?php echo $form->dropDownList($model,'characterID', $this->getCharacters()); ?>
			<?php echo $form->error($model,'characterID'); ?>
		</div>
		
		<input name=<?php echo CHtml::activeName($model, 'typeID') ?> type="hidden" id="typeIDHidden">
		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>