<?php
/* @var $this PictureController */
/* @var $model Picture */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'picture-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'avatar'); ?>
        <?php echo $form->checkBox($model,'avatar'); ?>
        <?php echo $form->error($model,'avatar'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_name'); ?>
		<?php echo $form->fileField($model,'file_name'); ?>
		<?php echo $form->error($model,'file_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caption'); ?>
		<?php echo $form->textArea($model,'caption',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'caption'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'copyright'); ?>
        <?php echo $form->textField($model,'copyright'); ?>
        <?php echo $form->error($model,'copyright'); ?>
    </div>

	<div class="row">
		<?php // echo $form->labelEx($model,'date_entered'); ?>
		<?php // echo $form->textField($model,'date_entered'); ?>
		<?php // echo $form->error($model,'date_entered'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'date_updated'); ?>
		<?php // echo $form->textField($model,'date_updated'); ?>
		<?php // echo $form->error($model,'date_updated'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'ip_created'); ?>
		<?php // echo $form->textField($model,'ip_created',array('size'=>50,'maxlength'=>50)); ?>
		<?php // echo $form->error($model,'ip_created'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'ip_updated'); ?>
		<?php // echo $form->textField($model,'ip_updated',array('size'=>50,'maxlength'=>50)); ?>
		<?php // echo $form->error($model,'ip_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->