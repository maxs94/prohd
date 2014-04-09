<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $orderID
 * @property integer $charID
 * @property integer $stationID
 * @property integer $volEntered
 * @property integer $volRemaining
 * @property integer $minVolume
 * @property integer $orderState
 * @property integer $typeID
 * @property integer $range
 * @property integer $accountKey
 * @property integer $duration
 * @property string $escrow
 * @property string $price
 * @property integer $bid
 * @property string $issued
 */
class Orders extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Orders the static model class
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
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderID, charID, stationID, volEntered, volRemaining, minVolume, orderState, typeID, range, accountKey, duration, escrow, price, bid, issued', 'required'),
			array('orderID, charID, stationID, volEntered, volRemaining, minVolume, orderState, typeID, range, accountKey, duration, bid', 'numerical', 'integerOnly'=>true),
			array('escrow, price', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('orderID, charID, stationID, volEntered, volRemaining, minVolume, orderState, typeID, range, accountKey, duration, escrow, price, bid, issued', 'safe', 'on'=>'search'),
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
			'invtypes'=>array(self::BELONGS_TO, 'Invtypes', 'typeID'),
			'chararacter'=>array(self::BELONGS_TO, 'Characters', 'characterID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'orderID' => 'Order',
			'charID' => 'Char',
			'stationID' => 'Station',
			'volEntered' => 'Vol Entered',
			'volRemaining' => 'Vol Remaining',
			'minVolume' => 'Min Volume',
			'orderState' => 'Order State',
			'typeID' => 'Type',
			'range' => 'Range',
			'accountKey' => 'Account Key',
			'duration' => 'Duration',
			'escrow' => 'Escrow',
			'price' => 'Price',
			'bid' => 'Bid',
			'issued' => 'Issued',
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

		$criteria->compare('orderID',$this->orderID);
		$criteria->compare('charID',$this->charID);
		$criteria->compare('stationID',$this->stationID);
		$criteria->compare('volEntered',$this->volEntered);
		$criteria->compare('volRemaining',$this->volRemaining);
		$criteria->compare('minVolume',$this->minVolume);
		$criteria->compare('orderState',$this->orderState);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('range',$this->range);
		$criteria->compare('accountKey',$this->accountKey);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('escrow',$this->escrow,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('issued',$this->issued,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}