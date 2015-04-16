<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'address-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $model->getAddressTypes() ); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>





	<div class="row">
		<?php echo $form->labelEx($model,'iso'); ?>
		<?php echo $form->dropDownList($model,'iso', $model->getCountries(),
            array('ajax'=>array('dataType'=>'text',
                                'data'=> array('iso'=>'js:$(this).val()'),
                                'url'=>CController::createUrl('address/subdivision'),
                                'type'=>'post',
                                'update'=>'#'.CHtml::activeId($model,'state'),

                                )
                 )
                                      );
        ?>
		<?php echo $form->error($model,'iso'); ?>

	</div>

<?php //  echo CController::createUrl('address/subdivision'); ?>






    <div class="row">
        <?php echo $form->labelEx($model,'state'); ?>
        <?php

        if($model->iso)
        {

            echo $form->dropDownList($model,'state', $model->getSubdivision($model->iso),array('class'=>'dropList'));
        }
        else
        {
            echo $form->dropDownList($model,'state', array('00'=>'(FIRST SELECT A COUNTRY)'), array('class'=>'dropList') );
        }

       //  ?>

        <?php
//        echo CHtml::dropDownList('state',$model, array());
        ?>

        <?php echo $form->error($model,'state'); ?>

    </div>


	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>


    <?php


    ?>
	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postal_code'); ?>
		<?php echo $form->textField($model,'postal_code',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'postal_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

    <div style="width: 200px; margin: 0 auto;">
        <div class="row buttons" style="float: left">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
        <div class="row buttons" style="float: right;">
            <?php
            if(!$model->isNewRecord)
            {
                echo CHtml::submitButton($label = 'Delete', array('confirm' => 'Are you sure?'));
            }
            ?>
        </div>
    </div>




<?php $this->endWidget(); ?>

</div><!-- form -->