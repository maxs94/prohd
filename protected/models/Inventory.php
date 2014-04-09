<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property string $transactionDateTime
 * @property string $transactionID
 * @property string $quantity
 * @property string $remaining
 * @property string $typeName
 * @property integer $typeID
 * @property double $price
 * @property string $clientID
 * @property string $clientName
 * @property integer $characterID
 * @property string $stationID
 * @property string $stationName
 * @property integer $personal
 */
class Inventory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Inventory the static model class
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
		return 'inventory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transactionDateTime, transactionID, quantity, remaining, typeName, typeID, price, clientID, clientName, characterID, stationID, stationName, personal', 'required'),
			array('typeID, characterID, personal', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('transactionID, quantity, remaining, clientID, stationID', 'length', 'max'=>20),
			array('typeName, clientName, stationName', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transactionDateTime, transactionID, quantity, remaining, typeName, typeID, price, clientID, clientName, characterID, stationID, stationName, personal', 'safe', 'on'=>'search'),
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
			'remaining' => 'Remaining',
			'typeName' => 'Type Name',
			'typeID' => 'Type',
			'price' => 'Price',
			'clientID' => 'Client',
			'clientName' => 'Client Name',
			'characterID' => 'Character',
			'stationID' => 'Station',
			'stationName' => 'Station Name',
			'personal' => 'Personal',
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
		$criteria->compare('remaining',$this->remaining,true);
		$criteria->compare('typeName',$this->typeName,true);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('price',$this->price);
		$criteria->compare('clientID',$this->clientID,true);
		$criteria->compare('clientName',$this->clientName,true);
		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('stationID',$this->stationID,true);
		$criteria->compare('stationName',$this->stationName,true);
		$criteria->compare('personal',$this->personal);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}