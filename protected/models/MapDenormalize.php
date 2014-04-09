<?php

/**
 * This is the model class for table "mapDenormalize".
 *
 * The followings are the available columns in table 'mapDenormalize':
 * @property integer $itemID
 * @property integer $typeID
 * @property integer $groupID
 * @property integer $solarSystemID
 * @property integer $constellationID
 * @property integer $regionID
 * @property integer $orbitID
 * @property double $x
 * @property double $y
 * @property double $z
 * @property double $radius
 * @property string $itemName
 * @property double $security
 * @property integer $celestialIndex
 * @property integer $orbitIndex
 */
class MapDenormalize extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MapDenormalize the static model class
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
		return 'mapDenormalize';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemID', 'required'),
			array('itemID, typeID, groupID, solarSystemID, constellationID, regionID, orbitID, celestialIndex, orbitIndex', 'numerical', 'integerOnly'=>true),
			array('x, y, z, radius, security', 'numerical'),
			array('itemName', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('itemID, typeID, groupID, solarSystemID, constellationID, regionID, orbitID, x, y, z, radius, itemName, security, celestialIndex, orbitIndex', 'safe', 'on'=>'search'),
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
			'itemID' => 'Item',
			'typeID' => 'Type',
			'groupID' => 'Group',
			'solarSystemID' => 'Solar System',
			'constellationID' => 'Constellation',
			'regionID' => 'Region',
			'orbitID' => 'Orbit',
			'x' => 'X',
			'y' => 'Y',
			'z' => 'Z',
			'radius' => 'Radius',
			'itemName' => 'Item Name',
			'security' => 'Security',
			'celestialIndex' => 'Celestial Index',
			'orbitIndex' => 'Orbit Index',
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

		$criteria->compare('itemID',$this->itemID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('groupID',$this->groupID);
		$criteria->compare('solarSystemID',$this->solarSystemID);
		$criteria->compare('constellationID',$this->constellationID);
		$criteria->compare('regionID',$this->regionID);
		$criteria->compare('orbitID',$this->orbitID);
		$criteria->compare('x',$this->x);
		$criteria->compare('y',$this->y);
		$criteria->compare('z',$this->z);
		$criteria->compare('radius',$this->radius);
		$criteria->compare('itemName',$this->itemName,true);
		$criteria->compare('security',$this->security);
		$criteria->compare('celestialIndex',$this->celestialIndex);
		$criteria->compare('orbitIndex',$this->orbitIndex);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}