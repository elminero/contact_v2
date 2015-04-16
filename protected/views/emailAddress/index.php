<?php
/* @var $this EmailAddressController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Email Addresses',
);

$this->menu=array(
	array('label'=>'Create EmailAddress', 'url'=>array('create')),
	array('label'=>'Manage EmailAddress', 'url'=>array('admin')),
);
?>

<h1>Email Addresses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
