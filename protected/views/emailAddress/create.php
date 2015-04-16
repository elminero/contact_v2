<?php
/* @var $this EmailAddressController */
/* @var $model EmailAddress */

$this->breadcrumbs=array(
	'Email Addresses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmailAddress', 'url'=>array('index')),
	array('label'=>'Manage EmailAddress', 'url'=>array('admin')),
);
?>

<h1>Create EmailAddress</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>