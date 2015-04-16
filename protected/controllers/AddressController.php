<?php

class AddressController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';
    public $layout='//layouts/primary';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create'),
                'users'=>array('@'),
                'expression'=>'isset(Yii::app()->user->roles) && ( (Yii::app()->user->roles==="author") )',
            ),

            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('subdivision', 'zip'),
                'users'=>array('@'),
            ),


            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
                'expression'=>'isset(Yii::app()->user->roles) && ( (Yii::app()->user->roles==="author_plus")|| (Yii::app()->user->roles==="admin") )',
            ),
            /*
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
            */
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

/*
 *
SELECT *
FROM subdivision
WHERE iso = 'US';
 */



    public function actionSubdivision()
    {
        $data=subdivision::model()->findAll('iso=:iso', array(':iso'=>$_POST['iso']));

        $data=CHtml::listData($data,'id','subdivision');

        if($_POST['iso'] == '00'  )
        {
            echo CHtml::tag('option', array('value'=>'00'),CHtml::encode('(FIRST SELECT A COUNTRY)'),true);
        }

        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option', array('value'=>$name),CHtml::encode($name),true);
        }






    }


    public function actionZip()
    {





        switch($_POST['state']) {

            case "Alabama":
                $USStateAbbreviation = "AL";
                break;
            case "Alaska":
                $USStateAbbreviation = "AK";
                break;
            case "Arizona":
                $USStateAbbreviation = "AZ";
                break;
            case "Arkansas":
                $USStateAbbreviation = "AR";
                break;
            case "California":
                $USStateAbbreviation = "CA";
                break;
            case "Colorado":
                $USStateAbbreviation = "CO";
                break;
            case "Connecticut":
                $USStateAbbreviation = "CT";
                break;
            case "Delaware":
                $USStateAbbreviation = "DE";
                break;
            case "District Of Columbia":
                $USStateAbbreviation = "DC";
                break;
            case "Florida":
                $USStateAbbreviation = "FL";
                break;
            case "Georgia":
                $USStateAbbreviation = "GA";
                break;
            case "Hawaii":
                $USStateAbbreviation = "HI";
                break;
            case "Idaho":
                $USStateAbbreviation = "IA";
                break;
            case "Illinois":
                $USStateAbbreviation = "IL";
                break;
            case "Indiana":
                $USStateAbbreviation = "IN";
                break;
            case "Iowa":
                $USStateAbbreviation = "IA";
                break;
            case "Kansas":
                $USStateAbbreviation = "KS";
                break;
            case "Kentucky":
                $USStateAbbreviation = "KY";
                break;
            case "Louisiana":
                $USStateAbbreviation = "LA";
                break;
            case "Maine":
                $USStateAbbreviation = "MA";
                break;
            case "Maryland":
                $USStateAbbreviation = "MD";
                break;
            case "Massachusetts":
                $USStateAbbreviation = "MA";
                break;
            case "Michigan":
                $USStateAbbreviation = "MI";
                break;
            case "Minnesota":
                $USStateAbbreviation = "MN";
                break;
            case "Mississippi":
                $USStateAbbreviation = "MS";
                break;
            case "Missouri":
                $USStateAbbreviation = "MO";
                break;
            case "Montana":
                $USStateAbbreviation = "MT";
                break;
            case "Nebraska":
                $USStateAbbreviation = "NE";
                break;
            case "Nevada":
                $USStateAbbreviation = "NV";
                break;
            case "New Hampshire":
                $USStateAbbreviation = "NH";
                break;
            case "New Jersey":
                $USStateAbbreviation = "NJ";
                break;
            case "New Mexico":
                $USStateAbbreviation = "NM";
                break;
            case "New York":
                $USStateAbbreviation = "NY";
                break;
            case "North Carolina":
                $USStateAbbreviation = "NC";
                break;
            case "North Dakota":
                $USStateAbbreviation = "ND";
                break;
            case "Ohio":
                $USStateAbbreviation = "OH";
                break;
            case "Oklahoma":
                $USStateAbbreviation = "OK";
                break;
            case "Oregon":
                $USStateAbbreviation = "OR";
                break;
            case "Pennsylvania":
                $USStateAbbreviation = "PA";
                break;
            case "Rhode Island":
                $USStateAbbreviation = "RI";
                break;
            case "South Carolina":
                $USStateAbbreviation = "SC";
                break;
            case "South Dakota":
                $USStateAbbreviation = "SD";
                break;
            case "Tennessee":
                $USStateAbbreviation = "TN";
                break;
            case "Texas":
                $USStateAbbreviation = "TX";
                break;
            case "Utah":
                $USStateAbbreviation = "UT";
                break;
            case "Vermont":
                $USStateAbbreviation = "VT";
                break;
            case "Virginia":
                $USStateAbbreviation = "VA";
                break;
            case "Washington":
                $USStateAbbreviation = "WA";
                break;
            case "West Virginia":
                $USStateAbbreviation = "WV";
                break;
            case "Wisconsin":
                $USStateAbbreviation = "WI";
                break;
            case "Wyoming":
                $USStateAbbreviation = "WY";
                break;
            default:
                $USStateAbbreviation = "notOnList";


        }




        $criteria = new CDbCriteria();
        $criteria->condition = "zip_code_type = 'STANDARD'  AND  state=:state";
        $criteria->params = array(':state'=>$USStateAbbreviation);
        $criteria->order = 'city';


        $data=zipCodes::model()->findAll($criteria);


        foreach($data as $value)
        {


                echo CHtml::tag('option', array('value'=>$value->city), $value->city,true);






        }









    }


// $subdivisions = array('00'=>'(FIRST SELECT A COUNTRY)');


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $model=new Address;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Address']))
		{
			$model->attributes=$_POST['Address'];
            $model->person_id = (int)$_GET['id'];
			if($model->save())
				$this->redirect(array('person/view','id'=>$model->person_id,'div4c'=>$model->id ));
		}

		$this->render('create',array('model'=>$model,));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Address']))
		{
			$model->attributes=$_POST['Address'];
			if(isset($_POST["yt1"]))
            {
                $model->live = 0;
            }

            if($model->save())
            {
               	$this->redirect(array('person/view','id'=>$model->person_id, 'div4u'=>$model->id));
            }

		}


        if((Yii::app()->user->checkAccessById($model->user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            $this->render('update',array('model'=>$model,));
        }
        else
        {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Address');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Address('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Address']))
			$model->attributes=$_GET['Address'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Address the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Address::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Address $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='address-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}




}
