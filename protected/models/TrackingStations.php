<?php

/**
 * This is the model class for table "trackingStations".
 *
 * The followings are the available columns in table 'trackingStations':
 * @property integer $trackingGroupID
 * @property integer $stationID
 * @property string $solarSystemName
 */
class TrackingStations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TrackingStations the static model class
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
		return 'trackingStations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trackingGroupID, stationID, solarSystemName', 'required'),
			array('trackingGroupID, stationID', 'numerical', 'integerOnly'=>true),
			array('solarSystemName', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('trackingGroupID, stationID, solarSystemName', 'safe', 'on'=>'search'),
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
			'trackingGroupID' => 'Tracking Group',
			'stationID' => 'Station',
			'solarSystemName' => 'Solar System Name',
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

		$criteria->compare('trackingGroupID',$this->trackingGroupID);
		$criteria->compare('stationID',$this->stationID);
		$criteria->compare('solarSystemName',$this->solarSystemName,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}