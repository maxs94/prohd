<?php

/**
 * This is the model class for table "invMarketGroups".
 *
 * The followings are the available columns in table 'invMarketGroups':
 * @property integer $marketGroupID
 * @property integer $parentGroupID
 * @property string $marketGroupName
 * @property string $description
 * @property integer $iconID
 * @property integer $hasTypes
 */
class InvMarketGroups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return InvMarketGroups the static model class
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
		return 'invMarketGroups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('marketGroupID', 'required'),
			array('marketGroupID, parentGroupID, iconID, hasTypes', 'numerical', 'integerOnly'=>true),
			array('marketGroupName', 'length', 'max'=>100),
			array('description', 'length', 'max'=>3000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('marketGroupID, parentGroupID, marketGroupName, description, iconID, hasTypes', 'safe', 'on'=>'search'),
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
			'marketGroupID' => 'Market Group',
			'parentGroupID' => 'Parent Group',
			'marketGroupName' => 'Market Group Name',
			'description' => 'Description',
			'iconID' => 'Icon',
			'hasTypes' => 'Has Types',
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

		$criteria->compare('marketGroupID',$this->marketGroupID);
		$criteria->compare('parentGroupID',$this->parentGroupID);
		$criteria->compare('marketGroupName',$this->marketGroupName,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('iconID',$this->iconID);
		$criteria->compare('hasTypes',$this->hasTypes);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}