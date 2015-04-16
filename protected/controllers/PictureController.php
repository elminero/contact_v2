<?php

class PictureController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';
    public $layout='//layouts/primary';


    private $_person = null;


    public function filterPicture($filterChain)
    {
        if(isset($_GET['id']))
        {
            $this->_person = SELF::loadPicture($_GET['id']);

            if($this->_person == null)
            {
                throw new CHttpException(403, 'The contact could not be found.');
            }
        }
        else
        {
            throw new CHttpException(403, 'Must specify a contact before uploading a picture.');
        }

        $filterChain->run();
    }


    public function loadPicture($id)
    {
        /*
        $criteria = new CDbCriteria();
        $criteria->select = 'file_name';
        $criteria->condition = 'avatar=:avatar AND person_id=:person_id';
        $criteria->params = array(':avatar'=>1, ':person_id'=>$id);
        $avatar = picture::model()->find($criteria);
        */


        $this->_person=Person::model()->findByPk($id);

        return $this->_person;
    }
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'Picture + create',
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
//                'expression'=>'isset(Yii::app()->user->roles) &&  ( (Yii::app()->user->roles==="author_plus")|| (Yii::app()->user->roles==="admin") )',
                'roles'=>array('author_plus', 'admin'),
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
        $model = Picture::model()->with('person')->findByPk($id);

//        $this->render('view', array( 'model'=>$model));

        $this->render('/person/picture', array('model'=>$model));
       // $this->render( 'view',array('model'=>$this->loadModel($id),) );
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Picture();


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Picture']))
		{

            $model->attributes=$_POST['Picture'];
            $model->file_name = CUploadedFile::getInstance($model, 'file_name');
            $model->person_id = (int)$_GET['id'];


            /*
             * if avatar was selected, set remove any avatar previously selected
             */
            if($model->avatar == 1)
            {
                Picture::model()->updateAll(array('avatar'=>0), 'person_id =' . $model->person_id    );
            }

           if($model->save())
           {
               if($model->avatar == 1)
               {
                   $this->redirect(array('person/view','id'=>$model->person_id ));
               }
               else
               {
                   $this->redirect(array('person/viewPicturesEdit','id'=>$model->person_id ));
               }



           }

		}



        $this->render( 'create',array('model'=>$model,) );




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

		if(isset($_POST['Picture']))
		{
			$model->attributes=$_POST['Picture'];

            if($model->avatar == 1)
            {
 //               Picture::model()->updateAll(array('avatar'=>0), 'person_id =' . $model->person_id    );

                $cmd = Yii::app()->db->createCommand();
                $cmd->update( 'picture', array('avatar'=>0), 'person_id=:person_id', array(':person_id'=>$model->person_id) );

                if($model->save())
                    $this->redirect(array('person/view','id'=>$model->person_id)
                    );



                }

            if($model->save())
				$this->redirect(array('person/viewPicturesEdit','id'=>$model->person_id)
            );
		}

		$this->render('update',array('model'=>$model,));
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
		$dataProvider=new CActiveDataProvider('Picture');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Picture('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Picture']))
			$model->attributes=$_GET['Picture'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Picture the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Picture::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Picture $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='picture-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
