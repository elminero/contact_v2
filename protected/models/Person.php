<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property string $id
 * @property integer $live
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $alias_name
 * @property integer $birth_month
 * @property integer $birth_day
 * @property integer $birth_year
 * @property string $note
 * @property integer $user_id_created
 * @property string $date_created
 * @property string $date_updated
 * @property string $ip_created
 * @property string $ip_updated
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property EmailAddress[] $emailAddresses
 * @property PhoneNumber[] $phoneNumbers
 * @property Picture[] $pictures
 */
class Person extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('date_created, ip_created', 'required'),
			array('live, birth_year', 'numerical', 'integerOnly'=>true),
            array('live', 'default', 'value'=>1),
            array('birth_day', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>31),
            array('birth_month', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>12),
			array('last_name, first_name, middle_name, alias_name', 'length', 'max'=>30),
            array('last_name, first_name, middle_name, alias_name, note', 'filter', 'filter'=>'strip_tags'),
            array('last_name, first_name, middle_name, alias_name, note', 'filter', 'filter'=>'trim'),
			array('ip_created, ip_updated', 'length', 'max'=>50),
			array('note, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, live, last_name, first_name, middle_name, alias_name, birth_month, birth_day, birth_year, note, user_id_created, date_created, date_updated, ip_created, ip_updated', 'safe', 'on'=>'search'),
		);
	}


    public function getAge($birth_year, $birth_month, $birth_day)
    {
        $birthday = $birth_year . "-" . $birth_month . "-" . $birth_day;
        $age = date_create($birthday)->diff(date_create('today'))->y;
        return $age;
    }


    public function getYearOptions()
    {
        $yearMin=(int)date("Y")-120;
        $yearOptions=array();
        $yearOptions[0]='Unknown';

        for($year=(int)date("Y"); $year>$yearMin; $year--)
        {
            $yearOptions[$year]=(string)$year;
        }

        return $yearOptions;
    }


    public function getDayOptions()
    {
        $dayOptions=array();
        $dayOptions[0]='Unknown';

        for($day=1; $day<=31; $day++)
        {
           $dayOptions[$day]=(string)$day;
        }

        return $dayOptions;
    }


    public function getMonthOptions()
    {
        return $month = array(
            0=>'Unknown',
            1=>'January',
            2=>'February',
            3=>'March',
            4=>'April',
            5=>'May',
            6=>'June',
            7=>'July',
            8=>'August',
            9=>'September',
            10=>'October',
            11=>'November',
            12=>'December'
            );
    }

    function getMonthNameByNumber($monthNumber)
    {
        switch($monthNumber)
        {
            case 0:
                $month = " ";
                break;
            case 1:
                $month = "January";
                break;
            case 2:
                $month = "February";
                break;
            case 3:
                $month = "March";
                break;
            case 4:
                $month = "April";
                break;
            case 5:
                $month = "May";
                break;
            case 6:
                $month = "June";
                break;
            case 7:
                $month = "July";
                break;
            case 8:
                $month = "August";
                break;
            case 9:
                $month = "September";
                break;
            case 10:
                $month = "October";
                break;
            case 11:
                $month = "November";
                break;
            case 12:
                $month = "December";
                break;
            default:
                $month = null;
        }
        return $month;
    }

    public function getAddressTypeByNumber($addressTypeNumber)
    {

        $addressType = null;

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


    public function getEmailAddressTypeByNumber($emailAddressTypeNumber)
    {
        $emailAddressType = null;

        switch($emailAddressTypeNumber)
        {
            case 0:
                $emailAddressType = " ";
                break;
            case 1:
                $emailAddressType = "Business";
                break;
            case 2:
                $emailAddressType = "Home";
                break;
            case 3:
                $emailAddressType = "Shared";
                break;
            case 4:
                $emailAddressType = "Previous";
                break;
            case 5:
                $emailAddressType = "Other";
                break;
            default:
                $month = null;
        }
        return $emailAddressType;
    }


    public function beforeSave()
    {
        if($this->isNewRecord)
        {
           $this->ip_created = $_SERVER['REMOTE_ADDR'];
           $this->date_created = new CDbExpression('NOW()');
           $this->user_id_created = Yii::app()->user->userId;
        }
        else
        {
            $this->ip_updated = $_SERVER['REMOTE_ADDR'];
            $this->date_updated = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }



    public function scopes()
    {
        return array('liveOnly'=>array('condition'=>'live=1'));
    }


    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'addresses' => array(self::HAS_MANY, 'Address', 'person_id', 'condition'=>'live = 1'),
			'emailAddresses' => array(self::HAS_MANY, 'EmailAddress', 'person_id', 'condition'=>'live = 1'),
			'phoneNumbers' => array(self::HAS_MANY, 'PhoneNumber', 'person_id', 'condition'=>'live = 1'),
			'pictures' => array(self::HAS_MANY, 'Picture', 'person_id'),
//            'pictureCount' => array(self::STAT, 'Picture', 'person_id')
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
			'last_name' => 'Last Name',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'alias_name' => 'Alias Name',
			'birth_month' => 'Birth Month',
			'birth_day' => 'Birth Day',
			'birth_year' => 'Birth Year',
			'note' => 'Note',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'ip_created' => 'Created From IP',
			'ip_updated' => 'Last Updated From IP',
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
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('alias_name',$this->alias_name,true);
		$criteria->compare('birth_month',$this->birth_month);
		$criteria->compare('birth_day',$this->birth_day);
		$criteria->compare('birth_year',$this->birth_year);
        $criteria->compare('user_id_created',$this->user_id_created);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('ip_created',$this->ip_created,true);
		$criteria->compare('ip_updated',$this->ip_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Person the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
