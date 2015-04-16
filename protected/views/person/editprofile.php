<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 7/2/14
 * Time: 3:23 PM
 *
 * $picture->file_name, id, live, avatar, file_name, caption, copyright
 */

Yii::app()->clientScript->registerCoreScript('jquery');

?>

<?php
    echo CHtml::link('Add a Picture', array('picture/create', 'id'=>$model->id));
?>

<?php foreach($portfolio as $picture) : ?>
    <div style="width:700px">
        <div align="left" style="padding-left: 15px; ">

            <div>
            <div align="left" style="color: red"><?php if($picture->avatar == 1){ echo "Avatar"; } ?></div>
            <?php
            echo CHtml::link('<img src="'. Yii::app()->request->baseUrl  . "/pictures/" . $picture->file_name .
            '_t.jpg" /> ', array('person/picture', 'id'=>$picture->id), array('class'=>'edit_picture'));
            ?>
            </div>

        </div>
        <br />



        <div style="margin-bottom:10px; float:right;">

                <span style="color: blue">

                <?php

 //               echo $picture->user_id_created;
  //                 if(Yii::app()->user->checkAccess('author_plus'))
  //                 {
                    if( (Yii::app()->user->checkAccessById($picture->user_id_created) &&
                         Yii::app()->user->checkAccess('author_plus')) ||
                         Yii::app()->user->checkAccess('admin') )
                    {
                      //  echo $picture->user_id_created;
                        echo CHtml::link('Edit&nbsp;', array('picture/update', 'id'=>$picture->id), array('class'=>'blue'));

                        echo "<span>";
                        echo CHtml::link('&nbsp;Remove ', array('person/viewPicturesEdit', 'id'=>$model->id, 'picture'=>$picture->id),
                            array('class'=>'blue', 'confirm' => 'Are you sure?' ));
                        echo "</span>";
                    }



   //                }
                ?>



                </span><br />
                Caption:<br />
                <div style="border: 1px solid gray; width: 440px; height: 140px; padding: 3px"><?php echo $picture->caption ?></div>

                <?php echo $picture->copyright ?>
                <br />


        </div>
    </div>
    <div style="clear:both" ></div>
<?php endforeach; ?>