<?php
/* @var $this PhoneNumberController */
/* @var $model PhoneNumber */

$this->breadcrumbs=array(
	'Phone Numbers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PhoneNumber', 'url'=>array('index')),
	array('label'=>'Create PhoneNumber', 'url'=>array('create')),
	array('label'=>'View PhoneNumber', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PhoneNumber', 'url'=>array('admin')),
);
?>

<h1>Update PhoneNumber <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>