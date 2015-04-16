<?php

/**
 * This is the model class for table "phone_number".
 *
 * The followings are the available columns in table 'phone_number':
 * @property string $id
 * @property string $person_id
 * @property integer $live
 * @property integer $type
 * @property string $phone
 * @property string $note
 * @property integer $user_id_created
 * @property string $date_entered
 * @property string $date_updated
 * @property string $ip_created
 * @property string $ip_updated
 *
 * The followings are the available model relations:
 * @property Person $person
 */
class PhoneNumber extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'phone_number';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phone', 'required'),
			array('live, type', 'numerical', 'integerOnly'=>true),
			array('person_id', 'length', 'max'=>10),
			array('phone', 'length', 'max'=>60),
			array('ip_created, ip_updated', 'length', 'max'=>50),
			array('note, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, live, type, phone, note, date_entered, date_updated, ip_created, ip_updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'person_id' => 'Person',
			'live' => 'Live',
			'type' => 'Type',
			'phone' => 'Phone',
			'note' => 'Note',
			'date_entered' => 'Date Entered',
			'date_updated' => 'Date Updated',
			'ip_created' => 'Ip Created',
			'ip_updated' => 'Ip Updated',
		);
	}

    public function getPhoneTypes()
    {
        return $phoneTypes = array(
            0=>'Unknown',
            1=>'Business',
            2=>'Home',
            3=>'Fax',
            4=>'Other',
            5=>' '

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
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('live',$this->live);
		$criteria->compare('type',$this->type);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date_entered',$this->date_entered,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('ip_created',$this->ip_created,true);
		$criteria->compare('ip_updated',$this->ip_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

/*
$this->ip_created = $_SERVER['REMOTE_ADDR'];
$this->date_entered = new CDbExpression('NOW()');

            $this->ip_updated = $_SERVER['REMOTE_ADDR'];
            $this->date_updated = new CDbExpression('NOW()');

*/
    public function beforeSave()
    {
       if($this->isNewRecord)
       {
           $this->ip_created = $_SERVER['REMOTE_ADDR'];
           $this->date_entered = new CDbExpression('NOW()');
           $this->user_id_created = Yii::app()->user->userId;
       }
       else
       {
           $this->ip_updated = $_SERVER['REMOTE_ADDR'];
           $this->date_updated = new CDbExpression('NOW()');
       }

    return parent::beforeSave();
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PhoneNumber the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
