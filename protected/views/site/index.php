<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>
    <?php echo CHtml::link('View a complete list of contacts', array('person/list')); ?>
    <br />
    <?php echo CHtml::link('View #8', array('person/view', 'id' => 8), array('class'=>'test-link')); ?>
    <br />
    <?php
     echo CHtml::link($this->createAbsoluteUrl('person/view', array('id'=>2)), array('person/view', 'id'=>2)); ?>

    <br />

    <?php
        echo CHtml::normalizeUrl(array('person/view', 'id'=>2));

    ?>
    <br />



    <?php
   // Yii::app()->request->baseUrl
    $app = Yii::app();


    echo CHtml::link('<img src="' . $app->request->baseUrl . '/images/ad67121c_t.jpg" /> ', array('person/index')); ?>

</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

