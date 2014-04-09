<?php

/**
 * This is the model class for table "balances".
 *
 * The followings are the available columns in table 'balances':
 * @property integer $balanceID
 * @property integer $characterID
 * @property string $balanceDateTime
 * @property double $balance
 */
class Balances extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Balances the static model class
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
		return 'balances';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('characterID, balanceDateTime, balance', 'required'),
			array('characterID', 'numerical', 'integerOnly'=>true),
			array('balance', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('balanceID, characterID, balanceDateTime, balance', 'safe', 'on'=>'search'),
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
			'balanceID' => 'Balance',
			'characterID' => 'Character',
			'balanceDateTime' => 'Balance Date Time',
			'balance' => 'Balance',
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

		$criteria->compare('balanceID',$this->balanceID);
		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('balanceDateTime',$this->balanceDateTime,true);
		$criteria->compare('balance',$this->balance);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}