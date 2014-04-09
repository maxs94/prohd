<?php

/**
 * This is the model class for table "wallet".
 *
 * The followings are the available columns in table 'wallet':
 * @property string $transactionDateTime
 * @property string $transactionID
 * @property string $quantity
 * @property string $typeName
 * @property string $typeID
 * @property double $price
 * @property string $clientID
 * @property string $clientName
 * @property string $characterID
 * @property string $stationID
 * @property string $stationName
 * @property string $transactionType
 */
class Wallet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Wallet the static model class
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
		return 'wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transactionDateTime, transactionID, quantity, typeName, typeID, price, clientID, clientName, characterID, stationID, stationName, transactionType', 'required'),
			array('price, profit', 'numerical'),
			array('transactionID, quantity, typeID, clientID, characterID, stationID', 'length', 'max'=>20),
			array('typeName, clientName, stationName', 'length', 'max'=>255),
			array('transactionType', 'length', 'max'=>4),
			array('personal', 'boolean'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transactionDateTime, transactionID, quantity, typeName, typeID, price, clientID, clientName, characterID, stationID, stationName, transactionType, personal', 'safe', 'on'=>'search'),
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
		'typeID' => array(self::BELONGS_TO, 'Invtypes', 'typeId'),
		'characterID'=>array(self::BELONGS_TO, 'Characters', 'walletID'),
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
			'stationID' => 'Station',
			'stationName' => 'Station Name',
			'transactionType' => 'Transaction Type',
			'personal' => 'Personal Purchase',
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
		$criteria->compare('stationID',$this->stationID,true);
		$criteria->compare('stationName',$this->stationName,true);
		$criteria->compare('transactionType',$this->transactionType,true);
		$criteria->compare('personal',$this->personal,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}