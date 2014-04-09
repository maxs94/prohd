<?php

/**
 * This is the model class for table "mapSolarSystems".
 *
 * The followings are the available columns in table 'mapSolarSystems':
 * @property integer $regionID
 * @property integer $constellationID
 * @property integer $solarSystemID
 * @property string $solarSystemName
 * @property double $x
 * @property double $y
 * @property double $z
 * @property double $xMin
 * @property double $xMax
 * @property double $yMin
 * @property double $yMax
 * @property double $zMin
 * @property double $zMax
 * @property double $luminosity
 * @property integer $border
 * @property integer $fringe
 * @property integer $corridor
 * @property integer $hub
 * @property integer $international
 * @property integer $regional
 * @property integer $constellation
 * @property double $security
 * @property integer $factionID
 * @property double $radius
 * @property integer $sunTypeID
 * @property string $securityClass
 */
class MapSolarSystems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MapSolarSystems the static model class
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
		return 'mapSolarSystems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('solarSystemID', 'required'),
			array('regionID, constellationID, solarSystemID, border, fringe, corridor, hub, international, regional, constellation, factionID, sunTypeID', 'numerical', 'integerOnly'=>true),
			array('x, y, z, xMin, xMax, yMin, yMax, zMin, zMax, luminosity, security, radius', 'numerical'),
			array('solarSystemName', 'length', 'max'=>100),
			array('securityClass', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('regionID, constellationID, solarSystemID, solarSystemName, x, y, z, xMin, xMax, yMin, yMax, zMin, zMax, luminosity, border, fringe, corridor, hub, international, regional, constellation, security, factionID, radius, sunTypeID, securityClass', 'safe', 'on'=>'search'),
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
			'solarSystemID' => 'Solar System',
			'solarSystemName' => 'Solar System Name',
			'x' => 'X',
			'y' => 'Y',
			'z' => 'Z',
			'xMin' => 'X Min',
			'xMax' => 'X Max',
			'yMin' => 'Y Min',
			'yMax' => 'Y Max',
			'zMin' => 'Z Min',
			'zMax' => 'Z Max',
			'luminosity' => 'Luminosity',
			'border' => 'Border',
			'fringe' => 'Fringe',
			'corridor' => 'Corridor',
			'hub' => 'Hub',
			'international' => 'International',
			'regional' => 'Regional',
			'constellation' => 'Constellation',
			'security' => 'Security',
			'factionID' => 'Faction',
			'radius' => 'Radius',
			'sunTypeID' => 'Sun Type',
			'securityClass' => 'Security Class',
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
		$criteria->compare('constellationID',$this->constellationID);
		$criteria->compare('solarSystemID',$this->solarSystemID);
		$criteria->compare('solarSystemName',$this->solarSystemName,true);
		$criteria->compare('x',$this->x);
		$criteria->compare('y',$this->y);
		$criteria->compare('z',$this->z);
		$criteria->compare('xMin',$this->xMin);
		$criteria->compare('xMax',$this->xMax);
		$criteria->compare('yMin',$this->yMin);
		$criteria->compare('yMax',$this->yMax);
		$criteria->compare('zMin',$this->zMin);
		$criteria->compare('zMax',$this->zMax);
		$criteria->compare('luminosity',$this->luminosity);
		$criteria->compare('border',$this->border);
		$criteria->compare('fringe',$this->fringe);
		$criteria->compare('corridor',$this->corridor);
		$criteria->compare('hub',$this->hub);
		$criteria->compare('international',$this->international);
		$criteria->compare('regional',$this->regional);
		$criteria->compare('constellation',$this->constellation);
		$criteria->compare('security',$this->security);
		$criteria->compare('factionID',$this->factionID);
		$criteria->compare('radius',$this->radius);
		$criteria->compare('sunTypeID',$this->sunTypeID);
		$criteria->compare('securityClass',$this->securityClass,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}