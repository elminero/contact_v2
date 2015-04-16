<?php
/* @var $this PersonController */
/* @var $dataProvider CActiveDataProvider */


$this->breadcrumbs=array(
    'List',
);

$this->menu=array(
    array('label'=>'Create Person', 'url'=>array('create')),
    array('label'=>'Manage Person', 'url'=>array('admin')),
);
?>

<h1>People</h1>

<?php


foreach($people as $person)
{
    // echo var_dump($value);

    echo  CHtml::link($person["first_name"] . " " . $person["last_name"] . " " . $person["middle_name"], array('person/view', 'id'=>$person["id"])) . "<br />";

    // echo $person["first_name"] . ", " . $person["last_name"] . "<br />";
    //echo $models[$i]["first_name"];
}

/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
*/



?>
