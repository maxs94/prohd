<?php

/**
 * This is the model class for table "corpAssets".
 *
 * The followings are the available columns in table 'corpAssets':
 * @property integer $characterID
 * @property string $itemID
 * @property string $locationID
 * @property integer $typeID
 * @property integer $quantity
 * @property integer $flag
 * @property integer $singleton
 * @property string $containerID
 * @property string $locationName
 * @property string $typeName
 * @property integer $groupID
 */
class CorpAssets extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CorpAssets the static model class
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
		return 'corpAssets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('characterID, typeID, quantity, singleton, groupID', 'required'),
			array('characterID, typeID, quantity, flag, singleton, groupID', 'numerical', 'integerOnly'=>true),
			array('locationID, containerID', 'length', 'max'=>20),
			array('locationName, typeName', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('characterID, itemID, locationID, typeID, quantity, flag, singleton, containerID, locationName, typeName, groupID', 'safe', 'on'=>'search'),
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
			'values'=>array(self::HAS_ONE, 'AssetValues', '', 'on'=>'t.typeID = values.typeID')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'characterID' => 'Character',
			'itemID' => 'Item',
			'locationID' => 'Location',
			'typeID' => 'Type',
			'quantity' => 'Quantity',
			'flag' => 'Flag',
			'singleton' => 'Singleton',
			'containerID' => 'Container',
			'locationName' => 'Location Name',
			'typeName' => 'Type Name',
			'groupID' => 'Group',
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

		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('itemID',$this->itemID,true);
		$criteria->compare('locationID',$this->locationID,true);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('singleton',$this->singleton);
		$criteria->compare('containerID',$this->containerID,true);
		$criteria->compare('locationName',$this->locationName,true);
		$criteria->compare('typeName',$this->typeName,true);
		$criteria->compare('groupID',$this->groupID);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}