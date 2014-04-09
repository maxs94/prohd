<?php

/**
 * This is the model class for table "invgroups".
 *
 * The followings are the available columns in table 'invgroups':
 * @property string $groupID
 * @property integer $categoryID
 * @property string $groupName
 * @property integer $graphicID
 */
class Invgroups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invgroups the static model class
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
		return 'invGroups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('categoryID, graphicID', 'numerical', 'integerOnly'=>true),
			array('groupID', 'length', 'max'=>11),
			array('groupName', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('groupID, categoryID, groupName, graphicID', 'safe', 'on'=>'search'),
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
			'groupID' => 'Group',
			'categoryID' => 'Category',
			'groupName' => 'Group Name',
			'graphicID' => 'Graphic',
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

		$criteria->compare('groupID',$this->groupID,true);
		$criteria->compare('categoryID',$this->categoryID);
		$criteria->compare('groupName',$this->groupName,true);
		$criteria->compare('graphicID',$this->graphicID);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}