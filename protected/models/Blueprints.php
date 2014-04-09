<?php

/**
 * This is the model class for table "blueprints".
 *
 * The followings are the available columns in table 'blueprints':
 * @property integer $primaryID
 * @property integer $itemID
 * @property integer $blueprintID
 * @property integer $typeID
 * @property integer $meLevel
 * @property integer $peLevel
 * @property integer $characterID
 * @property string $solarSystemID
 * @property string $npcPrice
 * @property string $value
 */
class Blueprints extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Blueprints the static model class
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
		return 'blueprints';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemID, blueprintID, typeID, meLevel, peLevel, characterID, solarSystemID, npcPrice, value', 'required'),
			array('itemID, blueprintID, typeID, meLevel, peLevel, characterID', 'numerical', 'integerOnly'=>true),
			array('solarSystemID, npcPrice, value', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('primaryID, itemID, blueprintID, typeID, meLevel, peLevel, characterID, solarSystemID, npcPrice, value', 'safe', 'on'=>'search'),
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
			'primaryID' => 'Primary',
			'itemID' => 'Item',
			'blueprintID' => 'Blueprint',
			'typeID' => 'Type',
			'meLevel' => 'Me Level',
			'peLevel' => 'Pe Level',
			'characterID' => 'Character',
			'solarSystemID' => 'Solar System',
			'npcPrice' => 'Npc Price',
			'value' => 'Value',
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

		$criteria->compare('primaryID',$this->primaryID);
		$criteria->compare('itemID',$this->itemID);
		$criteria->compare('blueprintID',$this->blueprintID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('meLevel',$this->meLevel);
		$criteria->compare('peLevel',$this->peLevel);
		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('solarSystemID',$this->solarSystemID,true);
		$criteria->compare('npcPrice',$this->npcPrice,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}