<?php

class PersonController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/primary';




    public function filterPersonNames($filterChain)
    {
        if(isset($_POST['Person']))
        {
            $model=new Person;
            $model->attributes=$_POST['Person'];
            if( ($model->last_name == null) && ($model->first_name == null) && ($model->middle_name == null) && ($model->alias_name == null) )
            {
                throw new CHttpException(': A contact must have a name or alias.');

            }
        }
        $filterChain->run();
    }

    public $results;
    public $pictureIdTest;

    public $pictureId = 0;

    public function filterPictureView($filterChain)
    {
        if( isset($_GET['id']))
        {
            $this->pictureId = $_GET['id']    ;
        }

        if(ctype_digit($this->pictureId))
        {
            $this->pictureId = (int)$this->pictureId;
        }
        else
        {
            throw new CHttpException(': PictureId must be in digits Zero through 10.');
        }



        if($this->pictureId == 0)
        {
            throw new CHttpException(': PictureId can not be zero or missing.');
        }


        if( $this->pictureId > 0  )
        {

            $criteria = new CDbCriteria();
            $criteria->select = 'id';
            $criteria->condition = 'id=' . $this->pictureId;
            $this->results = picture::model()->find($criteria);

            if(!$this->results)
            {
                throw new CHttpException(': PictureId can not be found.');
            }
        }



        $filterChain->run();
    }



	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'personNames + Create',
            'pictureView + picture',
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

    /*
    array('allow',
    'actions'=>array('create','update','delete','view','list', 'Portfolio', 'Picture', 'ViewPicturesEdit'),
    'roles'=>array('admin'),
    ),
    */

    array('allow',  // allow all users to perform 'iex' and 'view' actions
    'actions'=>array(''),
    'users'=>array('*'),
    ),


    array('allow', // allow authenticated user to perform 'create' and 'update' actions
    'actions'=>array('view','list', 'Portfolio', 'Picture',),
    //'users'=>array('@'),
    'roles'=>array('viewer'),
    //'expression'=>'isset(Yii::app()->user->roles) && (Yii::app()->user->roles==="viewer")',
    ),


    array('allow', // allow authenticated user to perform 'create' and 'update' actions
    'actions'=>array('create', 'view','list', 'Portfolio', 'Picture', 'ViewPicturesEdit'),
    //'users'=>array('@'),
    'roles'=>array('author', 'admin'),
    //'expression'=>'isset(Yii::app()->user->roles) && ( (Yii::app()->user->roles==="author")|| (Yii::app()->user->roles==="admin") )',
    ),


    array('allow', // allow authenticated user to perform 'create' and 'update' actions
    'actions'=>array('create','update','delete','view','list', 'Portfolio', 'Picture', 'ViewPicturesEdit', 'remove'),
    //'users'=>array('@'),
    'roles'=>array('author_plus', 'admin'),
    //'expression'=>'isset(Yii::app()->user->roles) && ( (Yii::app()->user->roles==="author_plus")|| (Yii::app()->user->roles==="admin") )',
    ),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

// Experimental
/*
    public function defaultScope()
    {
        return array('condition'=>'live=1');
    }
*/



	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $criteria = new CDbCriteria();
        $criteria->select = 'id, file_name';
        $criteria->condition = 'avatar=:avatar AND live=:live AND person_id=:person_id';
        $criteria->params = array(':avatar'=>1, 'live'=>1, ':person_id'=>$id);
        $avatar = picture::model()->find($criteria);

        $cmd = Yii::app()->db->createCommand();
        $cmd->select = 'COUNT(file_name)';
        $cmd->from = 'picture';
        $cmd->where = 'person_id= ' . $id . ' AND live=1';
        $livePictureCount =  $cmd->queryScalar();
/*
SELECT COUNT(file_name)
FROM picture
WHERE person_id=$id AND live=1;
*/

        $this->render('view', array('model'=>$this->loadModel($id), 'avatar'=>$avatar, 'livePictureCount'=>$livePictureCount ));
	}



    public function actionRemove()
    {



        Person::model()->updateAll(array('live'=>0), 'id =' . (int)$_GET['id']);
        $people = Person::model()->liveOnly()->findAll();
        $this->render('list', array('people'=>$people) );


    }


// Not Used
    public function actionProfile($id)
    {

        $criteria = new CDbCriteria();
        $criteria->select = 'file_name';
        $criteria->condition = 'avatar=:avatar AND person_id=:person_id';
        $criteria->params = array(':avatar'=>1, ':person_id'=>$id);
        $avatar = picture::model()->find($criteria);

        $this->render('view', array('model'=>$this->loadModel($id), 'avatar'=>$avatar,  'livePictureCount'=>1));
    }


    public function actionPortfolio($id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'file_name, id';
        $criteria->condition = 'person_id=:person_id AND live=1' . ' ORDER BY id DESC';
        $criteria->params = array(':person_id'=>$id);
        $portfolio = picture::model()->findAll($criteria);

        $this->render('portfolio', array('model'=>$this->loadModel($id), 'portfolio'=>$portfolio ));
    }


    public function actionViewPicturesEdit($id)
    {
            if( isset( $_GET['picture']) &&
              ( isset(Yii::app()->user->roles) &&
                      Yii::app()->user->roles === 'author_plus' || Yii::app()->user->roles === 'admin' ) )
            {
                $cmd = Yii::app()->db->createCommand();
                $cmd->update( 'picture',
                array('live'=>0), 'id=:id', array(':id'=>(int)$_GET['picture'] ) );
            }

        $criteria = new CDbCriteria();
        $criteria->select = 'file_name, id, live, avatar, file_name, user_id_created, caption, copyright';
        $criteria->condition = 'live=1 AND person_id=:person_id' . ' ORDER BY id DESC';
        $criteria->params = array(':person_id'=>$id);
        $portfolio = picture::model()->findAll($criteria);

        $this->render('editprofile', array('model'=>$this->loadModel($id), 'portfolio'=>$portfolio ));

    }



    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */


    private $_back;
    private $_subsequent;
    private $_previous;
    private $_next;
    private $_nextPicture;


    public function actionPicture($id)
    {
        //find a picture row by id and get the corresponding person row
        $model =  Picture::model()->with('person')->findByPk($id);


        $criteria = new CDbCriteria();

        $criteria->select = 'id';
        $criteria->condition = 'person_id=:person_id AND id>:id AND live=1';
        $criteria->params = array(':person_id'=>$model->person->id, ':id'=>$id);
        $this->_subsequent = picture::model()->find($criteria);

        if($this->_subsequent)
        {
            $this->_previous  = $this->_subsequent->id;
        }
        else
        {
            $criteria->select = 'id';
            $criteria->condition = 'person_id=:person_id AND live=1';
            $criteria->params=array(':person_id'=>$model->person->id);
            $this->_subsequent = picture::model()->find($criteria);

            if($this->_subsequent)
            {
                $this->_previous = $this->_subsequent->id;
            }
        }


        $criteria->select = array('file_name', 'id');
        $criteria->condition = 'person_id=' . $model->person->id . ' AND id < ' .  $id . ' AND live=1 ORDER BY id DESC' ;
        $this->_back = picture::model()->find($criteria);

        if($this->_back)
        {
            $this->_next = $this->_back->id;
            $this->_nextPicture = $this->_back->file_name;

        }
        else
        {
            $criteria->select = array('file_name', 'id');
            $criteria->condition = 'person_id=:person_id AND id > :id AND live=1 ORDER BY id DESC' ;
            $criteria->params=array(':person_id'=>$model->person->id, ':id'=>$id );
            $this->_back = picture::model()->find($criteria);

            if($this->_back)
            {
                $this->_next  = $this->_back->id;
                $this->_nextPicture = $this->_back->file_name;
            }
            else
            {
                $this->_next = $this->_previous;
            }

        }

        $this->render('picture', array( 'model'=>$model, 'subsequent'=>$this->_next, 'nextPicture'=>$this->_nextPicture, 'previous'=>$this->_previous ) );
    }





	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Person;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Person']))
		{
			$model->attributes=$_POST['Person'];
			if($model->save())
            {
//                echo var_dump($model->attributes);
                $this->redirect(array('view','id'=>$model->id, 'div'=>'3', 'div2c'=>$model->id));
            }
		}

		$this->render('create', array('model'=>$model,));
	}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
	public function actionUpdate($id)
	{
            $model=$this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

        if(isset($_POST['Person']))
        {
            $model->attributes=$_POST['Person'];

            if($model->save())
            {
                $this->redirect(array('view','id'=>$model->id, 'div2u'=>$model->id));
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

        $models = Person::model()->findAll();
        $this->render('index', array('models'=>$models) );
        /*
        $dataProvider=new CActiveDataProvider('Person');
		$this->render( 'index',array('dataProvider'=>$dataProvider,) );
        */
	}



    /**
     * Lists all models.
     */
    public function actionList()
    {

        $people = Person::model()->liveOnly()->findAll();
        $this->render('list', array('people'=>$people) );
        /*
        $dataProvider=new CActiveDataProvider('Person');
		$this->render( 'index',array('dataProvider'=>$dataProvider,) );
        */
    }






	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Person('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Person']))
			$model->attributes=$_GET['Person'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Person the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Person::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Person $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='person-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}



    public function getPhoneType($phoneTypeId = null)  // class PhoneNumber
    {
        switch($phoneTypeId)
        {
            case 0:
                $phoneType = "";
                break;
            case 1:
                $phoneType = "Business";
                break;
            case 2:
                $phoneType = "Home";
                break;
            case 3:
                $phoneType = "Fax";
                break;
            case 4:
                $phoneType = "Other";
                break;
            default:
                $phoneType = null;
        }
        return $phoneType;
    }


    public function nameDOBColor($user_id_created, $pkId)
    {
        if((Yii::app()->user->checkAccessById($user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            $div2Color = "blue";
        }
        else
        {
            $div2Color = "black";
        }

        if( isset($_GET['div2u']) && ($_GET['div2u'] === $pkId) )
        {
            $div2Color = "red";
        }

        if( isset($_GET['div2c']) && ($_GET['div2c'] === $pkId))
        {
            $div2Color = "green";
        }

        return $div2Color;
    }

    public function phoneNumberColor($user_id_created, $pkId)
    {
        if((Yii::app()->user->checkAccessById($user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            $div3Color = "blue";
        }
        else
        {
            $div3Color = "black";
        }


        if( (isset($_GET['div3u'])) && ($_GET['div3u'] === $pkId) )
        {
            $div3Color = "red";
        }

        if( (isset($_GET['div3c'])) && ($_GET['div3c'] == $pkId) )
        {
            $div3Color = "green";
        }

        return $div3Color;
    }

    public function addressColor($user_id_created, $pkId)
    {
        if((Yii::app()->user->checkAccessById($user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            $div4Color = "blue";
        }
        else
        {
            $div4Color = "black";
        }

        if( (isset($_GET['div4u'])) && ($_GET['div4u'] === $pkId) )
        {
            $div4Color = "red";
        }

        if( (isset($_GET['div4c'])) && ($_GET['div4c'] === $pkId) )
        {
            $div4Color = "green";
        }

        return $div4Color;
    }


    public function emailAddressColor($user_id_created, $pkId)
    {
        if((Yii::app()->user->checkAccessById($user_id_created))||(Yii::app()->user->getState("roles") === 'admin'))
        {
            $div5Color = "blue";
        }
        else
        {
            $div5Color = "black";
        }


        if( (isset($_GET['div5u'])) && ($_GET['div5u'] === $pkId) )
        {
            $div5Color = "red";
        }

        if( (isset($_GET['div5c'])) && ($_GET['div5c'] === $pkId) )
        {
            $div5Color = "green";
        }

        return $div5Color;
    }

}



