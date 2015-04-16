<?php
/* @var $this PersonController */
/* @var $model Person */
?>


<div style="float: left">
    <?php
    $this->breadcrumbs=array(
	'List'=>array('list'), 'Profile'=>array('view', 'id'=>$model->id),
    $model->last_name . " " . $model->first_name . " " . $model->middle_name,);

    ?>
</div>
<div style="float: right">
    <?php echo CHtml::link('DELETE PROFILE', array('person/remove', 'id'=>$model->id), array('confirm'=>'Are you sure?')) ?>

</div>
<div style="clear: both"></div>

<?php // echo Yii::app()->user->name; ?>



<!-- div 1 Start Avatar -->
<div align="center" style="float: left;" >
    <?php if($avatar): ?>

    <?php
    echo CHtml::link('<img src="'. Yii::app()->request->baseUrl  . "/pictures/" . $avatar->file_name . '_t.jpg" /> ', array('person/picture', 'id'=>$avatar->id) );
    ?>

    <?php endif ?>

    <?php // echo var_dump($avatar->name); ?>

    <br />

    <?php

        $photo = "Photo";

        if($livePictureCount == 0)
        {
            $photo = "Photos";
        }

        if($livePictureCount > 1)
        {
            $photo = "Photos";
        }


        echo CHtml::link($livePictureCount . ' ' . $photo, array('person/portfolio', 'id'=>$model->id), array('class'=>''));
    ?>

    &nbsp &nbsp

    <?php
        echo CHtml::link(' Add', array('picture/create', 'id'=>$model->id), array('class'=>''));
    ?>&nbsp &nbsp
    <?php
    echo CHtml::link('Edit', array('person/viewPicturesEdit', 'id'=>$model->id), array('class'=>''));
    ?>

    <!--  <a class="fltrt" href="addphotos.php?insert_id=3">Add Photos</a> -->
 </div>
 <!-- End Avatar -->

<!-- div 2 Start Name and DOB -->
<div style="float:left; margin-left: 10px; ">

    <?php

    $div2Color = $this->nameDOBColor($model->user_id_created, $model->id);


    $nameDOB = "Name: " . $model->last_name . " " . $model->first_name . " " . $model->middle_name . "<br />" .
        "Alias: " . $model->alias_name . "<br />";

    if(($model->birth_year != 0) AND ($model->birth_month != 0) AND ($model->birth_day !=0))
    {
        $nameDOB .= "DOB: " . $model->getMonthNameByNumber($model->birth_month)  . " " . $model->birth_day . ", " . $model->birth_year . "<br />";
    }

    if(($model->birth_year == 0) || ($model->birth_month == 0) || ($model->birth_day == 0))
    {
        if(($model->birth_year == 0) && ($model->birth_month == 0) && ($model->birth_day == 0))
        {
            $nameDOB .= "DOB: Unknown";
        }

        if(($model->birth_year != 0) || ($model->birth_month != 0) || ($model->birth_day != 0))
        {
            $nameDOB .= "DOB Incomplete : ";
        }

        if($model->birth_year != 0)
        {
            $nameDOB .= " Year: " . $model->birth_year;
            if($model->birth_month != 0)
                {
                    $nameDOB .= ", ";
                }
                if($model->birth_day != 0)
                    {
                        $nameDOB .= ", ";
                    }
        }

        if($model->birth_month != 0)
        {
            $nameDOB .= " Month: " . $model->getMonthNameByNumber($model->birth_month); if($model->birth_day != 0)
            {
                $nameDOB .= ", ";
            }
        }

        if($model->birth_day != 0)
        {
            $nameDOB .= " Day: " . $model->birth_day;
        }

        $nameDOB .= "<br />Age Unknown<br />";
    }

    if(($model->birth_year != 0) AND ($model->birth_month != 0) AND ($model->birth_day !=0))
    {
        $nameDOB .= "Age: " . $model->getAge($model->birth_year, $model->birth_month, $model->birth_day). "<br />";
    }

    $nameDOB .=
    "Note:




    <form>
        <textarea rows=\"6\" cols=\"71\" style=\"color:" . $div2Color . "; margin-bottom: 5px;\">" . $model->note. "</textarea>
    </form>";


    if((Yii::app()->user->checkAccessById($model->user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
    {
        echo CHtml::link($nameDOB, array('person/update', 'id'=>$model->id), array('class'=>$div2Color));
    }
    else
    {
        echo $nameDOB;
    }


    ?>


    <div style="font-size: 12px; margin: 4px; float: right; color: #000000">
        Member ID: <?php echo $model->user_id_created . " " ?>
        created from IP: <?php echo $model->ip_created . " on: " . $model->date_created . ". "; ?><br />
        <?php if($model->ip_updated): ?>
            Last updated from IP: <?php echo $model->ip_updated . " on: " . $model->date_updated; ?>
        <?php endif ?>
    </div>
</div>





<div style="clear: both"></div>
<!-- End Name and DOB -->


<!-- div3 Start Phone Numbers -->
<div>
    <hr />
    <?php


    echo CHtml::link('Add a Phone Number', array('phoneNumber/create', 'id'=>$model->id)); ?>
    <br /><br />
    <?php
    foreach($model->phoneNumbers as $phoneNumber)
    {

        $div3Color = $this->phoneNumberColor($phoneNumber->user_id_created, $phoneNumber->id);

        $phoneInfo = $this->getPhoneType($phoneNumber->type)  . " " . $phoneNumber->phone . " " . $phoneNumber->note . "<br />";


        if((Yii::app()->user->checkAccessById($phoneNumber->user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            echo Chtml::link($phoneInfo, array('phoneNumber/update', 'id'=>$phoneNumber->id), array('class'=>$div3Color));
        }
        else
        {
            echo $phoneInfo;
        }
    }
    ?>
</div>
<!-- End Phone Numbers -->



<div>
    <hr />

    <table>
        <?php $i = 4; $b = 1; ?>

        <?php echo CHtml::link('Add an Address', array('address/create', 'id'=>$model->id)); ?>
        <br /><br />
        <?php
        foreach($model->addresses as $address)
        {

            $div4Color = $this->addressColor($address->user_id_created, $address->id);

            if(($i % 4) == 0)
            {
                echo "<tr>";
            }

            echo "<td style=\"padding-right: 20px\">";

            $addressInfo = $model->getAddressTypeByNumber($address->type) . "<br />" .
                           $address->street . "<br />" .
                           $address->city . ", " . $address->state . " ". $address->postal_code . " " . $address->iso . "<br />" .
                           $address->note . "<br /><br />";

            if((Yii::app()->user->checkAccessById($address->user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
            {
                echo Chtml::link($addressInfo, array('address/update', 'id'=>$address->id), array('class'=>$div4Color));
            }
            else
            {
                echo $addressInfo;
            }

            echo "</td>";

            if(($b % 4) == 0)
            {
                echo "</tr>";
            }

            $i++; $b++;

        }
        ?>
    </table>
</div>
<div>
    <hr />
    <?php echo CHtml::link('Add an Email Address', array('emailAddress/create', 'id'=>$model->id)); ?>
    <br /><br />
    <?php
    foreach($model->emailAddresses as $emailAddress)
    {

        $div5Color = $this->emailAddressColor($emailAddress->user_id_created, $emailAddress->id);

        $emailAddressInfo = $model->getEmailAddressTypeByNumber($emailAddress->type) .
            " " . $emailAddress->email .
            " " . $emailAddress->note .
            "<br />";

        if((Yii::app()->user->checkAccessById($emailAddress->user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            echo CHtml::link($emailAddressInfo, array('emailAddress/update', 'id'=>$emailAddress->id), array('class'=>$div5Color));
        }
        else
        {
            echo $emailAddressInfo;
        }

    }



    ?>




</div>






<?php

/*
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'date_created',
		'date_updated',
		'ip_created',
		'ip_updated',
	),


));
*/
?>
