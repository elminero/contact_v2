<?php

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property string $id
 * @property string $person_id
 * @property integer $live
 * @property integer $type
 * @property string $iso
 * @property string $state
 * @property string $street
 * @property string $city
 * @property string $postal_code
 * @property string $note
 * @property string $date_entered
 * @property string $date_updated
 * @property string $ip_created
 * @property string $ip_updated
 *
 * The followings are the available model relations:
 * @property Person $person
 */
class Address extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_id, iso', 'required'),
			array('live, type', 'numerical', 'integerOnly'=>true),
			array('person_id', 'length', 'max'=>10),
			array('iso', 'length', 'max'=>2),
			array('state, street, city, postal_code', 'length', 'max'=>30),
			array('ip_created, ip_updated', 'length', 'max'=>50),
			array('note, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, live, type, iso, state, street, city, postal_code, note, date_entered, date_updated, ip_created, ip_updated', 'safe', 'on'=>'search'),
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
			'iso' => 'Country',
			'state' => 'State',
			'street' => 'Street',
			'city' => 'City',
			'postal_code' => 'Postal Code',
			'note' => 'Note',
			'date_entered' => 'Date Entered',
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
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('live',$this->live);
		$criteria->compare('type',$this->type);
		$criteria->compare('iso',$this->iso,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date_entered',$this->date_entered,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('ip_created',$this->ip_created,true);
		$criteria->compare('ip_updated',$this->ip_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


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

    public $Countries;






    public function getCountries()
    {

        $model = Country::model()->findAll();

//        $Countries = array();

        $countries = array('00'=>' ');

        foreach($model as $value)
        {
            $countries[$value['iso']] = $value['country'];
        }
//     $countries = array('US'=>'United Snakes');
        return $countries;
    }


    public function getSubdivision($iso)
    {
        $data=subdivision::model()->findAll('iso=:iso', array(':iso'=>$iso));

        // $data=CHtml::listData($data,'subdivision','subdivision');

//        $subdivisions = array('00'=>'(FIRST SELECT A COUNTRY)');

        foreach($data as $value)
        {
            $subdivisions[$value['subdivision']] = $value['subdivision'];
        }

        //   $subdivisions = array('New York'=>'New York');

        return $subdivisions;
    }



    public function getCities($subdivisions)
    {

        if($subdivisions == "New York")
        {
            $stateAbbreviation =  "NY";
        }

        if($subdivisions == "California")
        {
            $stateAbbreviation =  "CA";
        } else
        {
            $stateAbbreviation =  "AL";
        }




        $criteria = new CDbCriteria();
        $criteria->condition = "zip_code_type = 'STANDARD'  AND  state=:state";
        $criteria->params = array(':state'=>$stateAbbreviation);
        $criteria->order = 'city';


        $data=zipCodes::model()->findAll($criteria);


        foreach($data as $value)
        {
            $cities[$value['city']] = $value['city'];
        }

        //   $subdivisions = array('New York'=>'New York');

        return $cities;

    }




    public function getAddressTypes()
    {
        return array(
                        0=>" ",
                        1=>"Current Street",
                        2=>"Current Mailing",
                        3=>"Previous Street",
                        4=>"Previous Mailing",
                        5=>"Current Crash Pad",
                        6=>"Previous Crash Pad",
                        7=>"Other");
    }


    public function getAddressTypeByNumber($addressTypeNumber)
    {
        switch($addressTypeNumber)
        {
            case 0:
                $addressType = " ";
                break;
            case 1:
                $addressType = "Current Street";
                break;
            case 2:
                $addressType = "Current Mailing";
                break;
            case 3:
                $addressType = "Previous Street";
                break;
            case 4:
                $addressType = "Previous Mailing";
                break;
            case 5:
                $addressType = "Current Crash Pad";
                break;
            case 6:
                $addressType = "Previous Crash Pad";
                break;
            case 7:
                $addressType = "Other";
                break;
            default:
                $month = null;
        }
        return $addressType;
    }



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Address the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
