<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/25/14
 * Time: 8:02 PM
 */

/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

$this->menu=array(
    array('label'=>'List User', 'url'=>array('index')),
    array('label'=>'Create User', 'url'=>array('create')),
    array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

    <h1>Update User <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_admin_form', array('model'=>$model)); ?>