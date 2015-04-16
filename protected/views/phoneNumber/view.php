<?php
/* @var $this PhoneNumberController */
/* @var $model PhoneNumber */

$this->breadcrumbs=array(
	'Phone Numbers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PhoneNumber', 'url'=>array('index')),
	array('label'=>'Create PhoneNumber', 'url'=>array('create')),
	array('label'=>'Update PhoneNumber', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PhoneNumber', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PhoneNumber', 'url'=>array('admin')),
);
?>

<h1>View PhoneNumber #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'person_id',
		'live',
		'type',
		'phone',
		'note',
		'date_entered',
		'date_updated',
		'ip_created',
		'ip_updated',
	),
)); ?>
