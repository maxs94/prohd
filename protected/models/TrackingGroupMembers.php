<?php

/**
 * This is the model class for table "trackingGroupMembers".
 *
 * The followings are the available columns in table 'trackingGroupMembers':
 * @property integer $memberID
 * @property integer $characterID
 * @property integer $trackingGroupID
 */
class TrackingGroupMembers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TrackingGroupMembers the static model class
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
		return 'trackingGroupMembers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memberID, characterID, trackingGroupID', 'required'),
			array('memberID, characterID, trackingGroupID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberID, characterID, trackingGroupID', 'safe', 'on'=>'search'),
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
			'characters'=>array(self::BELONGS_TO, 'Characters', 'characterID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'memberID' => 'Member',
			'characterID' => 'Character',
			'trackingGroupID' => 'Tracking Group',
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

		$criteria->compare('memberID',$this->memberID);
		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('trackingGroupID',$this->trackingGroupID);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}