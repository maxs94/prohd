<?php

/**
 * This is the model class for table "stastations".
 *
 * The followings are the available columns in table 'stastations':
 * @property string $stationID
 * @property integer $corporationID
 * @property integer $solarSystemID
 * @property integer $constellationID
 * @property integer $regionID
 * @property string $stationName
 */
class Stastations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stastations the static model class
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
		return 'staStations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('corporationID, solarSystemID, constellationID, regionID', 'numerical', 'integerOnly'=>true),
			array('stationID', 'length', 'max'=>11),
			array('stationName', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stationID, corporationID, solarSystemID, constellationID, regionID, stationName', 'safe', 'on'=>'search'),
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
			'corporationID' => 'Corporation',
			'solarSystemID' => 'Solar System',
			'constellationID' => 'Constellation',
			'regionID' => 'Region',
			'stationName' => 'Station Name',
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
		$criteria->compare('corporationID',$this->corporationID);
		$criteria->compare('solarSystemID',$this->solarSystemID);
		$criteria->compare('constellationID',$this->constellationID);
		$criteria->compare('regionID',$this->regionID);
		$criteria->compare('stationName',$this->stationName,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}