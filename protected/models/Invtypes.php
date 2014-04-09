<?php

/**
 * This is the model class for table "invtypes".
 *
 * The followings are the available columns in table 'invtypes':
 * @property integer $typeID
 * @property integer $groupID
 * @property string $typeName
 * @property string $description
 * @property integer $graphicID
 * @property double $radius
 * @property double $mass
 * @property double $volume
 * @property double $capacity
 * @property integer $portionSize
 * @property integer $raceID
 * @property double $basePrice
 * @property integer $published
 * @property integer $marketGroupID
 * @property double $chanceOfDuplicating
 */
class Invtypes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invtypes the static model class
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
		return 'invTypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeID', 'required'),
			array('typeID, groupID, graphicID, portionSize, raceID, published, marketGroupID', 'numerical', 'integerOnly'=>true),
			array('radius, mass, volume, capacity, basePrice, chanceOfDuplicating', 'numerical'),
			array('typeName', 'length', 'max'=>100),
			array('description', 'length', 'max'=>3000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('typeID, groupID, typeName, description, graphicID, radius, mass, volume, capacity, portionSize, raceID, basePrice, published, marketGroupID, chanceOfDuplicating', 'safe', 'on'=>'search'),
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
			'transactions'=>array(self::HAS_MANY, 'Wallet', 'typeID'),
			'orders'=>array(self::HAS_MANY, 'Orders', 'typeID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'typeID' => 'Type',
			'groupID' => 'Group',
			'typeName' => 'Type Name',
			'description' => 'Description',
			'graphicID' => 'Graphic',
			'radius' => 'Radius',
			'mass' => 'Mass',
			'volume' => 'Volume',
			'capacity' => 'Capacity',
			'portionSize' => 'Portion Size',
			'raceID' => 'Race',
			'basePrice' => 'Base Price',
			'published' => 'Published',
			'marketGroupID' => 'Market Group',
			'chanceOfDuplicating' => 'Chance Of Duplicating',
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

		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('groupID',$this->groupID);
		$criteria->compare('typeName',$this->typeName,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('graphicID',$this->graphicID);
		$criteria->compare('radius',$this->radius);
		$criteria->compare('mass',$this->mass);
		$criteria->compare('volume',$this->volume);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('portionSize',$this->portionSize);
		$criteria->compare('raceID',$this->raceID);
		$criteria->compare('basePrice',$this->basePrice);
		$criteria->compare('published',$this->published);
		$criteria->compare('marketGroupID',$this->marketGroupID);
		$criteria->compare('chanceOfDuplicating',$this->chanceOfDuplicating);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}