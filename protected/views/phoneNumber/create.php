<?php
/* @var $this PhoneNumberController */
/* @var $model PhoneNumber */

$this->breadcrumbs=array(
	'Phone Numbers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PhoneNumber', 'url'=>array('index')),
	array('label'=>'Manage PhoneNumber', 'url'=>array('admin')),
);
?>

<h1>Create PhoneNumber</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>