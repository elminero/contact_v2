<?php
/* @var $this EmailAddressController */
/* @var $model EmailAddress */

$this->breadcrumbs=array(
	'Email Addresses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmailAddress', 'url'=>array('index')),
	array('label'=>'Create EmailAddress', 'url'=>array('create')),
	array('label'=>'Update EmailAddress', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmailAddress', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmailAddress', 'url'=>array('admin')),
);
?>

<h1>View EmailAddress #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'person_id',
		'live',
		'type',
		'email',
		'note',
		'date_entered',
		'date_updated',
		'ip_created',
		'ip_updated',
	),
)); ?>
