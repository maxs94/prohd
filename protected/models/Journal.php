<?php

/**
 * This is the model class for table "journal".
 *
 * The followings are the available columns in table 'journal':
 * @property string $date
 * @property string $refID
 * @property string $refTypeID
 * @property string $ownerName1
 * @property string $ownerID1
 * @property string $ownerName2
 * @property string $ownerID2
 * @property string $argName1
 * @property string $argID1
 * @property string $characterID
 * @property double $amount
 * @property double $balance
 * @property string $reason
 */
class Journal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Journal the static model class
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
		return 'journal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, refID, refTypeID, ownerName1, ownerID1, ownerName2, ownerID2, argName1, argID1, amount, balance, reason', 'required'),
			array('amount, balance', 'numerical'),
			array('refID, characterID', 'length', 'max'=>20),
			array('refTypeID, ownerID1, ownerID2, argID1', 'length', 'max'=>10),
			array('ownerName1, ownerName2, argName1, reason', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, refID, refTypeID, ownerName1, ownerID1, ownerName2, ownerID2, argName1, argID1, characterID, amount, balance, reason', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'refID' => 'Ref',
			'refTypeID' => 'Ref Type',
			'ownerName1' => 'Owner Name1',
			'ownerID1' => 'Owner Id1',
			'ownerName2' => 'Owner Name2',
			'ownerID2' => 'Owner Id2',
			'argName1' => 'Arg Name1',
			'argID1' => 'Arg Id1',
			'characterID' => 'Character',
			'amount' => 'Amount',
			'balance' => 'Balance',
			'reason' => 'Reason',
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

		$criteria->compare('date',$this->date,true);
		$criteria->compare('refID',$this->refID,true);
		$criteria->compare('refTypeID',$this->refTypeID,true);
		$criteria->compare('ownerName1',$this->ownerName1,true);
		$criteria->compare('ownerID1',$this->ownerID1,true);
		$criteria->compare('ownerName2',$this->ownerName2,true);
		$criteria->compare('ownerID2',$this->ownerID2,true);
		$criteria->compare('argName1',$this->argName1,true);
		$criteria->compare('argID1',$this->argID1,true);
		$criteria->compare('characterID',$this->characterID,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('reason',$this->reason,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}