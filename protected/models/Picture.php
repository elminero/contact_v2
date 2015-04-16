<?php

/**
 * This is the model class for table "picture".
 *
 * The followings are the available columns in table 'picture':
 * @property string $id
 * @property string $person_id
 * @property integer $live
 * @property integer $avatar
 * @property string $file_name
 * @property string $caption
 * @property string $copyright
 * @property string $date_entered
 * @property string $date_updated
 * @property string $ip_created
 * @property string $ip_updated
 *
 * The followings are the available model relations:
 * @property Person $person
 */

class Picture extends CActiveRecord
{
//    public $name;


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'picture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('file_name', 'required', 'on'=>'insert' ),
            array('file_name', 'file', 'types'=>'jpg', 'on'=>'insert' ),
			array('live, avatar', 'numerical', 'integerOnly'=>true),
			array('person_id, user_id_created', 'length', 'max'=>10),
			array('file_name', 'length', 'max'=>60),
			array('ip_created, ip_updated', 'length', 'max'=>50),
            array('copyright', 'length', 'max'=>100),
			array('caption, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, person_id, live, avatar, file_name, caption, user_id_created, date_entered, date_updated, ip_created, ip_updated', 'safe', 'on'=>'search'),
		);
	}


    public function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->ip_created = $_SERVER['REMOTE_ADDR'];
            $this->date_entered = new CDbExpression('NOW()');
            $this->user_id_created = Yii::app()->user->userId;



            /**
             * creates directories for storing image files
             * in the format: pictures/YY/MM/DD/HH.
             */
            self::createImageFolder();

            /**
             * copy image file into "HH" directory as "HH/original.jpg"
             * rename and copy as "HH/randomHex.jpg" and "HH/randomHex_t.jpg"
             * @return string "YY/MM/DD/HH/randomHex" without suffix .jpg of _t.jpg for saving in database
             */
            $this->file_name = self::moveToImageFolderRenameCopy();

            /**
             * reduce to full size and makes height proportional
             */
            self::reduceToFullSize();

            /**
             * reduce to ThumbNail size and makes height proportional
             */
            self::reduceToThumbNail();

        }
        else
        {
            $this->ip_updated = $_SERVER['REMOTE_ADDR'];
            $this->date_updated = new CDbExpression('NOW()');
        }

        return parent::beforeSave();
    }





    // WHERE TO PUT IMAGES
    const IMAGE_FOLDER = "pictures/";

    // WIDTH OF LARGE IMAGE
    const LARGE_IMAGE_WIDTH = 800;

    // WIDTH OF THUMB NAIL
    const THUMB_NAIL_IMAGE_WIDTH = 175;

    private $imageLocation;

    public function createImageFolder()
    {
        // Create the folders YY/MM/DD/HH
        $date = explode( "|", date("y|m|d|H") );
        list($y, $m, $d, $h) = $date;
        if(!file_exists(self::IMAGE_FOLDER . $y))
        {
            mkdir(self::IMAGE_FOLDER . $y);
        }
        if(!file_exists(self::IMAGE_FOLDER . $y . "/" . $m))
        {
            mkdir(self::IMAGE_FOLDER . $y . "/" . $m);
        }
        if(!file_exists(self::IMAGE_FOLDER . $y . "/" .  $m . "/" . $d))
        {
            mkdir(self::IMAGE_FOLDER . $y . "/" .  $m . "/" . $d);
        }
        if(!file_exists(self::IMAGE_FOLDER . $y . "/" .  $m . "/" . $d . "/" . $h))
        {
            mkdir(self::IMAGE_FOLDER . $y . "/" .  $m . "/" . $d . "/" . $h);
        }

        $this->imageLocation = $y . "/" .  $m . "/" . $d . "/" . $h . "/";
    }

    private $imageFolderLocationFullSize;
    private $imageFolderLocationThumbSize;
    private $randHex;

    public function moveToImageFolderRenameCopy()
    {
        // move_uploaded_file($_FILES["file"]["tmp_name"], self::IMAGE_FOLDER . $this->imageLocation . $_FILES["file"]["file_name"]);

        $this->file_name->saveAs('./' . self::IMAGE_FOLDER . $this->imageLocation . $this->file_name);

        $this->randHex = substr(md5(rand()), 0, 8);

        $fullSize = $this->randHex . ".jpg";

        $thumbSize = $this->randHex . "_t.jpg";

        $this->imageFolderLocationFullSize = self::IMAGE_FOLDER . $this->imageLocation . $fullSize;

        $this->imageFolderLocationThumbSize = self::IMAGE_FOLDER . $this->imageLocation . $thumbSize;

        // rename(self::IMAGE_FOLDER . $this->imageLocation . $_FILES["file"]["file_name"] ,  $this->imageFolderLocationFullSize) ;

        rename('./' . self::IMAGE_FOLDER . $this->imageLocation . $this->file_name ,  $this->imageFolderLocationFullSize) ;

        copy($this->imageFolderLocationFullSize, $this->imageFolderLocationThumbSize);

        return $this->imageLocation . $this->randHex;
    }


    public function reduceToFullSize()
    {
        //Resize the full size image only if original is more than 800 width
        $imageOriginal = imagecreatefromjpeg($this->imageFolderLocationFullSize);
        $imageOriginalWidth = imagesx($imageOriginal);
        if($imageOriginalWidth > self::LARGE_IMAGE_WIDTH)
        {
            $imageOriginalHeight = imagesy($imageOriginal);

            // Make the width 800px and find the new height
            $displayHeight = intval(self::LARGE_IMAGE_WIDTH * $imageOriginalHeight / $imageOriginalWidth);

            $displayImage = imagecreatetruecolor(self::LARGE_IMAGE_WIDTH, $displayHeight);

            imagecopyresampled($displayImage, $imageOriginal, 0, 0, 0, 0, self::LARGE_IMAGE_WIDTH, $displayHeight,
                $imageOriginalWidth, $imageOriginalHeight);

            imagejpeg($displayImage, $this->imageFolderLocationFullSize);
        }
    }


    public function reduceToThumbNail()
    {
        $imageOriginal = imagecreatefromjpeg($this->imageFolderLocationThumbSize);
        $imageOriginalWidth = imagesx($imageOriginal);

        $imageOriginalHeight = imagesy($imageOriginal);

        // Make the width and find the new height
        $displayHeight = intval(self::THUMB_NAIL_IMAGE_WIDTH * $imageOriginalHeight / $imageOriginalWidth);

        $displayImage = imagecreatetruecolor(self::THUMB_NAIL_IMAGE_WIDTH, $displayHeight);

        imagecopyresampled($displayImage, $imageOriginal, 0, 0, 0, 0, self::THUMB_NAIL_IMAGE_WIDTH, $displayHeight,
            $imageOriginalWidth, $imageOriginalHeight);

        imagejpeg($displayImage, $this->imageFolderLocationThumbSize );
    }



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array('person' => array(self::BELONGS_TO, 'Person', 'person_id'),);
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
            'avatar' => 'Avatar',
			'file_name' => 'File Name',
			'caption' => 'Caption',
            'copyright' => 'copyright',
            'user_id_created' => 'user id created',
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
        $criteria->compare('avatar',$this->avatar);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('caption',$this->caption,true);
// 		$criteria->compare('user_id_created',$this->user_id_created,true);
		$criteria->compare('date_entered',$this->date_entered,true);
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
	 * @return Picture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
