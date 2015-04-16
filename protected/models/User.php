<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property integer $live
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $roles
 * @property string $note
 * @property string $date_created
 * @property string $date_updated
 * @property string $ip_created
 * @property string $ip_updated
 */
class User extends CActiveRecord
{
    public $passwordCompare;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password', 'required'),
            array('username', 'unique'),
            array('email', 'unique'),
			array('live', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>45),
			array('email', 'length', 'max'=>60),
			array('password', 'length', 'max'=>64),

            array('password', 'compare', 'compareAttribute'=>'passwordCompare', 'on'=>'insert'),
//            array('pass', 'compare', 'compareAttribute'=>'passwordCompare', 'on'=>'update'),

//			array('roles', 'length', 'max'=>6),
			array('ip_created, ip_updated', 'length', 'max'=>50),
			array('note, date_updated, passwordCompare, roles', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, live, username, email, password, roles, note, date_created, date_updated, ip_created, ip_updated', 'safe', 'on'=>'search'),
		);
	}


    public function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->ip_created = $_SERVER['REMOTE_ADDR'];
            $this->date_created = new CDbExpression('NOW()');
          $this->roles = 'non_approved';
//            $this->password = new CDbExpression('SHA2(:password, 512)', array(':password' => $this->password));
            $this->password = hash('ripemd160', $this->password);
        }
        else
        {
            $this->ip_updated = $_SERVER['REMOTE_ADDR'];
            $this->date_updated = new CDbExpression('NOW()');
//            $this->password = new CDbExpression('SHA2(:password, 512)', array(':password' => $this->password));
//            $this->password = hash('ripemd160', $this->password);
        }
        return parent::beforeSave();
    }



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'live' => 'Live',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
            'passwordCompare' => 'Retype Password',
			'roles' => 'roles',
			'note' => 'Note',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'ip_created' => 'Ip Created',
			'ip_updated' => 'Ip Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('live',$this->live);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('roles',$this->roles,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('ip_created',$this->ip_created,true);
		$criteria->compare('ip_updated',$this->ip_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



    public function getRolesOptions()
    {

        return ["non_approved"=>"Not Approved", "viewer"=>"Viewer", "author"=>"Author", "author_plus"=>"Author Plus", "admin"=>"Admin"];

        //    'non_approved','viewer','author','author_plus','admin'


    }



    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
