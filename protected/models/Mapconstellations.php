<?php

/**
 * This is the model class for table "mapconstellations".
 *
 * The followings are the available columns in table 'mapconstellations':
 * @property integer $regionID
 * @property string $constellationID
 * @property string $constellationName
 * @property integer $factionID
 */
class Mapconstellations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Mapconstellations the static model class
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
		return 'mapconstellations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('regionID, factionID', 'numerical', 'integerOnly'=>true),
			array('constellationID', 'length', 'max'=>11),
			array('constellationName', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('regionID, constellationID, constellationName, factionID', 'safe', 'on'=>'search'),
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
			'regionID' => 'Region',
			'constellationID' => 'Constellation',
			'constellationName' => 'Constellation Name',
			'factionID' => 'Faction',
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

		$criteria->compare('regionID',$this->regionID);
		$criteria->compare('constellationID',$this->constellationID,true);
		$criteria->compare('constellationName',$this->constellationName,true);
		$criteria->compare('factionID',$this->factionID);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}