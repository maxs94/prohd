<?php

/**
 * This is the model class for table "mapregions".
 *
 * The followings are the available columns in table 'mapregions':
 * @property string $regionID
 * @property string $regionName
 * @property integer $factionID
 */
class Mapregions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Mapregions the static model class
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
		return 'mapregions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('factionID', 'numerical', 'integerOnly'=>true),
			array('regionID', 'length', 'max'=>11),
			array('regionName', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('regionID, regionName, factionID', 'safe', 'on'=>'search'),
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
			'regionName' => 'Region Name',
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

		$criteria->compare('regionID',$this->regionID,true);
		$criteria->compare('regionName',$this->regionName,true);
		$criteria->compare('factionID',$this->factionID);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}