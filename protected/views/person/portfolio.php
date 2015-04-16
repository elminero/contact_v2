<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 6/29/14
 * Time: 1:19 PM
 */


$this->breadcrumbs=array(
    'List'=>array('list'), 'Profile'=>array('view', 'id'=>$model->id), 'Portfolio',
    $model->last_name . " " . $model->first_name . " " . $model->middle_name,
);

?>


<?php
foreach($portfolio as $picture) : ?>

    <?php

    echo CHtml::link('<img src="'. Yii::app()->request->baseUrl  . "/pictures/" . $picture->file_name .         '_t.jpg" /> ', array('person/picture', 'id'=>$picture->id));

    ?>



<?php endforeach; ?>





