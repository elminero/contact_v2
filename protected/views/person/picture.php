<?php
/* @var $this PictureController */
/* @var $model Picture */

Yii::app()->clientScript->registerCoreScript('jquery');

$this->breadcrumbs=array(
    'List'=>array('list'), 'Profile'=>array('view', 'id'=>$model->person_id), 'Portfolio'=>array('portfolio', 'id'=>$model->person_id), 'Picture # ' . $model->id

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
<h1>Picture #<?php echo $model->id; ?></h1>

<?php echo $model->person->first_name . " " . $model->person->last_name;  ?>
<br />





<div align="center" style="margin:1px; padding:1px;">

<div id="imageChange" style="width: 250px;">
    <?php

    if($previous != $subsequent)
    {
        echo CHtml::link('<--PREVIOUS', array('person/picture', 'id'=>$previous), array('class'=>'picture_previous'));

        echo CHtml::link(' NEXT-->', array('person/picture', 'id'=>$subsequent), array('class'=>'picture_next'));
    }

    ?>
</div>



    <?php
    $picture = "<img  src=" . Yii::app()->request->baseUrl . "/" . $model::IMAGE_FOLDER . $model->file_name . ".jpg />";
    echo CHtml::link($picture, array('person/picture', 'id'=>$subsequent) );
    ?>




    <?php // echo "<img id=\"next \" \" src=" . Yii::app()->request->baseUrl . "/" . $model::IMAGE_FOLDER . $nextPicture . ".jpg />"; ?>





    <?php   $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'person_id',
            'live',
            'avatar',
            'file_name',
            'caption',
            'copyright',
            'user_id_created',
            'date_entered',
            'date_updated',
            'ip_created',
            'ip_updated',
        ),
    ));  ?>
</