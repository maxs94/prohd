<?php

/**
 * This is the model class for table "inventoryLog".
 *
 * The followings are the available columns in table 'inventoryLog':
 * @property integer $logID
 * @property integer $sourceTransactionID
 * @property integer $targetTransactionID
 * @property integer $quantity
 */
class InventoryLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return InventoryLog the static model class
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
		return 'inventoryLog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sourceTransactionID, targetTransactionID, quantity', 'required'),
			array('sourceTransactionID, targetTransactionID, quantity', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('logID, sourceTransactionID, targetTransactionID, quantity', 'safe', 'on'=>'search'),
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
			'logID' => 'Log',
			'sourceTransactionID' => 'Source Transaction',
			'targetTransactionID' => 'Target Transaction',
			'quantity' => 'Quantity',
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

		$criteria->compare('logID',$this->logID);
		$criteria->compare('sourceTransactionID',$this->sourceTransactionID);
		$criteria->compare('targetTransactionID',$this->targetTransactionID);
		$criteria->compare('quantity',$this->quantity);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}