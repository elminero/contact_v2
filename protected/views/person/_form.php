<?php
/* @var $this PersonController */
/* @var $model Person */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array('id'=>'person-form', 'enableAjaxValidation'=>false));
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'middle_name'); ?>
		<?php echo $form->textField($model,'middle_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'middle_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias_name'); ?>
		<?php echo $form->textField($model,'alias_name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'alias_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_month'); ?>
		<?php // echo $form->textField($model,'birth_month'); ?>
        <?php echo $form->dropDownList($model,'birth_month', $model->getMonthOptions()); ?>
		<?php echo $form->error($model,'birth_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_day'); ?>
		<?php // echo $form->textField($model,'birth_day'); ?>
        <?php echo $form->dropDownList($model,'birth_day', $model->getDayOptions()) ; ?>
		<?php echo $form->error($model,'birth_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_year'); ?>
        <?php // echo $form->textField($model,'birth_year'); ?>
        <?php echo $form->dropDownList($model, 'birth_year', $model->getYearOptions()) ; ?>
		<?php echo $form->error($model,'birth_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>







</div><!-- form -->