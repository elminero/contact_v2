<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/25/14
 * Time: 8:06 PM
 */

/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'live'); ?>
        <?php echo $form->textField($model,'live',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'live'); ?>
    </div>



    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>60)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'passwordCompare'); ?>
        <?php echo $form->passwordField($model,'passwordCompare',array('size'=>60,'maxlength'=>64)); ?>
    </div>



    <div class="row">
        <?php echo $form->labelEx($model,'roles'); ?>
        <?php echo $form->textField($model,'roles',array('size'=>6,'maxlength'=>6)); ?>
        <?php echo $form->error($model,'roles'); ?>
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