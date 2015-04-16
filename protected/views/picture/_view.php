<?php
/* @var $this PictureController */
/* @var $data Picture */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
	<?php echo CHtml::encode($data->person_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live')); ?>:</b>
	<?php echo CHtml::encode($data->live); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('avatar')); ?>:</b>
    <?php echo CHtml::encode($data->avatar); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_name')); ?>:</b>
	<?php echo CHtml::encode($data->file_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('caption')); ?>:</b>
	<?php echo CHtml::encode($data->caption); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('copyright')); ?>:</b>
    <?php echo CHtml::encode($data->copyright); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_entered')); ?>:</b>
	<?php echo CHtml::encode($data->date_entered); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_updated')); ?>:</b>
	<?php echo CHtml::encode($data->date_updated); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_created')); ?>:</b>
	<?php echo CHtml::encode($data->ip_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_updated')); ?>:</b>
	<?php echo CHtml::encode($data->ip_updated); ?>
	<br />

	*/ ?>

</div>