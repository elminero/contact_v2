<?php

/**
 * This is the model class for table "zip_codes".
 *
 * The followings are the available columns in table 'zip_codes':
 * @property string $record_number
 * @property integer $zip_code
 * @property string $zip_code_type
 * @property string $city
 * @property string $state
 * @property string $location_type
 * @property string $latitude
 * @property string $longitude
 * @property string $location
 * @property string $decommisioned
 * @property string $taxreturnsfiled
 * @property string $population
 * @property string $wages
 */
class ZipCodes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zip_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('record_number, state', 'required'),
			array('zip_code', 'numerical', 'integerOnly'=>true),
			array('record_number, population', 'length', 'max'=>5),
			array('zip_code_type, latitude, longitude, taxreturnsfiled', 'length', 'max'=>10),
			array('city, decommisioned', 'length', 'max'=>30),
			array('state', 'length', 'max'=>2),
			array('location_type, wages', 'length', 'max'=>15),
			array('location', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('record_number, zip_code, zip_code_type, city, state, location_type, latitude, longitude, location, decommisioned, taxreturnsfiled, population, wages', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'record_number' => 'Record Number',
			'zip_code' => 'Zip Code',
			'zip_code_type' => 'Zip Code Type',
			'city' => 'City',
			'state' => 'State',
			'location_type' => 'Location Type',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'location' => 'Location',
			'decommisioned' => 'Decommisioned',
			'taxreturnsfiled' => 'Taxreturnsfiled',
			'population' => 'Population',
			'wages' => 'Wages',
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

		$criteria->compare('record_number',$this->record_number,true);
		$criteria->compare('zip_code',$this->zip_code);
		$criteria->compare('zip_code_type',$this->zip_code_type,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('location_type',$this->location_type,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('decommisioned',$this->decommisioned,true);
		$criteria->compare('taxreturnsfiled',$this->taxreturnsfiled,true);
		$criteria->compare('population',$this->population,true);
		$criteria->compare('wages',$this->wages,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ZipCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
