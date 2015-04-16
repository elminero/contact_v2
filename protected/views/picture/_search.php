<?php
/* @var $this PictureController */
/* @var $model Picture */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person_id'); ?>
		<?php echo $form->textField($model,'person_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live'); ?>
		<?php echo $form->textField($model,'live'); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model,'avatar'); ?>
        <?php echo $form->textField($model,'avatar'); ?>
    </div>

	<div class="row">
		<?php echo $form->label($model,'file_name'); ?>
		<?php echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'caption'); ?>
		<?php echo $form->textArea($model,'caption',array('rows'=>6, 'cols'=>50)); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model,'copyright'); ?>
        <?php echo $form->textField($model,'copyright'); ?>
    </div>


	<div class="row">
		<?php echo $form->label($model,'date_entered'); ?>
		<?php echo $form->textField($model,'date_entered'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_updated'); ?>
		<?php echo $form->textField($model,'date_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_created'); ?>
		<?php echo $form->textField($model,'ip_created',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_updated'); ?>
		<?php echo $form->textField($model,'ip_updated',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->