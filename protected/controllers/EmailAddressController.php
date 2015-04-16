<?php

class EmailAddressController extends Controller
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
		$model=new EmailAddress;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EmailAddress']))
		{
			$model->attributes=$_POST['EmailAddress'];
            $model->person_id = (int)$_GET['id'];
			if($model->save())
            {
                $this->redirect(array('person/view','id'=>$model->person_id, 'div5c'=>$model->id));
            }

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

		if(isset($_POST['EmailAddress']))
		{
			$model->attributes=$_POST['EmailAddress'];
			if(isset($_POST ["yt1"]))
            {
                $model->live=0;
            }

            if($model->save())
            {
               $this->redirect(array('person/view','id'=>$model->person_id, 'div5u'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('EmailAddress');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EmailAddress('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EmailAddress']))
			$model->attributes=$_GET['EmailAddress'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EmailAddress the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EmailAddress::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EmailAddress $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='email-address-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
