<?php

/**
 * This is the model class for table "characters".
 *
 * The followings are the available columns in table 'characters':
 * @property integer $walletID
 * @property integer $characterID
 * @property string $characterName
 * @property integer $keyID
 * @property string $vCode
 * @property integer $accountID
 * @property integer $limitUpdate
 * @property string $limitDate
 * @property integer $displayBalance
 * @property integer $walletEnabled
 * @property integer $journalEnabled
 * @property integer $ordersEnabled
 * @property integer $displayOrders
 */
 
class Characters extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Characters the static model class
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
		return 'characters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('characterID, characterName, keyID, vCode, accountID', 'required'),
			array('characterID, keyID, accountID, limitUpdate, displayBalance, walletEnabled, journalEnabled, ordersEnabled, displayOrders', 'numerical', 'integerOnly'=>true),
			array('characterName', 'length', 'max'=>255),
			array('vCode', 'length', 'max'=>64),
			array('limitDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('walletID, characterID, characterName, keyID, vCode, accountID, limitUpdate, limitDate, displayBalance, walletEnabled, journalEnabled, ordersEnabled, displayOrders', 'safe', 'on'=>'search'),
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
			'trackingGroups'=>array(self::HAS_ONE, 'TrackingGroupMembers', 'characterID'),
			'account'=>array(self::BELONGS_TO, 'Accounts', 'accountID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'walletID' => 'Wallet Number',
			'characterID' => 'Character ID',
			'characterName' => 'Character Name',
			'keyID' => 'Key ID',
			'vCode' => 'vCode',
			'accountID' => 'Account ID',
			'limitUpdate' => 'Limit Update',
			'limitDate' => 'Limit Date',
			'displayBalance' => 'Display Balance',
			'walletEnabled' => 'Wallet Enabled',
			'journalEnabled' => 'Journal Enabled',
			'ordersEnabled' => 'Orders Enabled',
			'displayOrders' => 'Display Orders',

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

		$criteria->compare('walletID',$this->walletID);
		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('characterName',$this->characterName,true);
		$criteria->compare('keyID',$this->keyID);
		$criteria->compare('vCode',$this->vCode,true);
		$criteria->compare('accountID',$this->accountID);
		$criteria->compare('limitUpdate',$this->limitUpdate);
		$criteria->compare('limitDate',$this->limitDate,true);
		$criteria->compare('displayBalance',$this->displayBalance);
		$criteria->compare('walletEnabled',$this->walletEnabled);
		$criteria->compare('journalEnabled',$this->journalEnabled);
		$criteria->compare('ordersEnabled',$this->ordersEnabled);
		$criteria->compare('displayOrders',$this->displayOrders);


		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}