<?php

/**
 * This is the model class for table "wcorp".
 *
 * The followings are the available columns in table 'wcorp':
 * @property string $transactionDateTime
 * @property string $transactionID
 * @property string $quantity
 * @property string $typeName
 * @property string $typeID
 * @property double $price
 * @property string $clientID
 * @property string $clientName
 * @property string $characterID
 * @property string $characterName
 * @property string $corpID
 * @property string $stationID
 * @property string $stationName
 * @property string $transactionType
 * @property string $division
 */
class Wcorp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Wcorp the static model class
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
		return 'wcorp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transactionDateTime, transactionID, quantity, typeName, typeID, price, clientID, clientName, characterID, characterName, corpID, stationID, stationName, transactionType, division', 'required'),
			array('price', 'numerical'),
			array('transactionID, quantity, typeID, clientID, characterID, corpID, stationID', 'length', 'max'=>20),
			array('typeName, clientName, characterName, stationName', 'length', 'max'=>255),
			array('transactionType', 'length', 'max'=>4),
			array('division', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transactionDateTime, transactionID, quantity, typeName, typeID, price, clientID, clientName, characterID, characterName, corpID, stationID, stationName, transactionType, division', 'safe', 'on'=>'search'),
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
			'transactionDateTime' => 'Transaction Date Time',
			'transactionID' => 'Transaction',
			'quantity' => 'Quantity',
			'typeName' => 'Type Name',
			'typeID' => 'Type',
			'price' => 'Price',
			'clientID' => 'Client',
			'clientName' => 'Client Name',
			'characterID' => 'Character',
			'characterName' => 'Character Name',
			'corpID' => 'Corp',
			'stationID' => 'Station',
			'stationName' => 'Station Name',
			'transactionType' => 'Transaction Type',
			'division' => 'Division',
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

		$criteria->compare('transactionDateTime',$this->transactionDateTime,true);
		$criteria->compare('transactionID',$this->transactionID,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('typeName',$this->typeName,true);
		$criteria->compare('typeID',$this->typeID,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('clientID',$this->clientID,true);
		$criteria->compare('clientName',$this->clientName,true);
		$criteria->compare('characterID',$this->characterID,true);
		$criteria->compare('characterName',$this->characterName,true);
		$criteria->compare('corpID',$this->corpID,true);
		$criteria->compare('stationID',$this->stationID,true);
		$criteria->compare('stationName',$this->stationName,true);
		$criteria->compare('transactionType',$this->transactionType,true);
		$criteria->compare('division',$this->division,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}