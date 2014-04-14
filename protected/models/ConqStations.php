<?php

/**
 * This is the model class for table "conqStations".
 *
 * The followings are the available columns in table 'conqStations':
 * @property string $stationID
 * @property string $stationName
 * @property integer $stationTypeID
 * @property integer $solarSystemID
 * @property string $corporationID
 * @property string $corporationName
 */
class ConqStations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConqStations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conqStations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stationID, stationName, stationTypeID, solarSystemID, corporationID, corporationName', 'required'),
			array('stationTypeID, solarSystemID', 'numerical', 'integerOnly'=>true),
			array('stationID, corporationID', 'length', 'max'=>20),
			array('stationName, corporationName', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stationID, stationName, stationTypeID, solarSystemID, corporationID, corporationName', 'safe', 'on'=>'search'),
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
			'stationID' => 'Station',
			'stationName' => 'Station Name',
			'stationTypeID' => 'Station Type',
			'solarSystemID' => 'Solar System',
			'corporationID' => 'Corporation',
			'corporationName' => 'Corporation Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('stationID',$this->stationID,true);
		$criteria->compare('stationName',$this->stationName,true);
		$criteria->compare('stationTypeID',$this->stationTypeID);
		$criteria->compare('solarSystemID',$this->solarSystemID);
		$criteria->compare('corporationID',$this->corporationID,true);
		$criteria->compare('corporationName',$this->corporationName,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
