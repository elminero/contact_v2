<?php
/* @var $this PhoneNumberController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Phone Numbers',
);

$this->menu=array(
	array('label'=>'Create PhoneNumber', 'url'=>array('create')),
	array('label'=>'Manage PhoneNumber', 'url'=>array('admin')),
);
?>

<h1>Phone Numbers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
