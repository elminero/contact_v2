<?php  /* NOT USED */
/* @var $this PictureController */
/* @var $model Picture */





$this->breadcrumbs=array(
	'Pictures'=>array('index'),
    $model->person->first_name . " " . $model->person->last_name,
);


$this->menu=array(
	array('label'=>'List Picture', 'url'=>array('index')),
	array('label'=>'Create Picture', 'url'=>array('create')),
	array('label'=>'Update Picture', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Picture', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Picture', 'url'=>array('admin')),
);



?>
<div style="clear: both"></div>
<h1>View Picture #<?php echo $model->id; ?></h1>

<?php echo $model->person->first_name . " " . $model->person->last_name; ?>

<div align="center" style="margin:1px; padding:1px;">



<img style="display: block; margin-left: auto; margin-right: auto " src="<?php echo Yii::app()->request->baseUrl . "/" . $model::IMAGE_FOLDER . $model->file_name ?>.jpg" />
<?php echo $model::IMAGE_FOLDER ?>


    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'person_id',
		'live',
        'avatar',
		'file_name',
		'caption',
        'copyright',
		'date_entered',
		'date_updated',
		'ip_created',
		'ip_updated',
	),
)); ?>
</div>