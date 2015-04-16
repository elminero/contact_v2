<?php
/* @var $this EmailAddressController */
/* @var $model EmailAddress */

$this->breadcrumbs=array(
	'Email Addresses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmailAddress', 'url'=>array('index')),
	array('label'=>'Create EmailAddress', 'url'=>array('create')),
	array('label'=>'View EmailAddress', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmailAddress', 'url'=>array('admin')),
);
?>

<h1>Update EmailAddress <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>