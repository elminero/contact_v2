<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 7/3/14
 * Time: 12:56 AM
 */

?>
<?php
/* @var $this PictureController */
/* @var $model Picture */
/* @var $form CActiveForm */
?>

<div style="width: 725px; padding-left: 25px">
<div style="float: left">
    <img src="./pictures/<?php echo $model->file_name; ?>_t.jpg" />
</div>

<div style="float: right">
<div class="form">

    <?php // echo $model->user_id_created; ?>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'picture-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>

    <?php echo $form->errorSummary($model); ?>



    <div class="row">
        <?php echo $form->labelEx($model,'avatar'); ?>
        <?php echo $form->checkBox($model,'avatar'); ?>
        <?php echo $form->error($model,'avatar'); ?>
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
</div>
</div>