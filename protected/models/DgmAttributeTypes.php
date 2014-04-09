<?php

/**
 * This is the model class for table "dgmAttributeTypes".
 *
 * The followings are the available columns in table 'dgmAttributeTypes':
 * @property integer $attributeID
 * @property string $attributeName
 * @property string $description
 * @property integer $iconID
 * @property double $defaultValue
 * @property integer $published
 * @property string $displayName
 * @property integer $unitID
 * @property integer $stackable
 * @property integer $highIsGood
 * @property integer $categoryID
 *
 * The followings are the available model relations:
 * @property EveIcons $icon
 * @property InvTypes[] $invTypes
 */
class DgmAttributeTypes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DgmAttributeTypes the static model class
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
		return 'dgmAttributeTypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attributeID', 'required'),
			array('attributeID, iconID, published, unitID, stackable, highIsGood, categoryID', 'numerical', 'integerOnly'=>true),
			array('defaultValue', 'numerical'),
			array('attributeName, displayName', 'length', 'max'=>100),
			array('description', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('attributeID, attributeName, description, iconID, defaultValue, published, displayName, unitID, stackable, highIsGood, categoryID', 'safe', 'on'=>'search'),
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
			'icon' => array(self::BELONGS_TO, 'EveIcons', 'iconID'),
			'invTypes' => array(self::MANY_MANY, 'InvTypes', 'dgmTypeAttributes(attributeID, typeID)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'attributeID' => 'Attribute',
			'attributeName' => 'Attribute Name',
			'description' => 'Description',
			'iconID' => 'Icon',
			'defaultValue' => 'Default Value',
			'published' => 'Published',
			'displayName' => 'Display Name',
			'unitID' => 'Unit',
			'stackable' => 'Stackable',
			'highIsGood' => 'High Is Good',
			'categoryID' => 'Category',
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

		$criteria->compare('attributeID',$this->attributeID);
		$criteria->compare('attributeName',$this->attributeName,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('iconID',$this->iconID);
		$criteria->compare('defaultValue',$this->defaultValue);
		$criteria->compare('published',$this->published);
		$criteria->compare('displayName',$this->displayName,true);
		$criteria->compare('unitID',$this->unitID);
		$criteria->compare('stackable',$this->stackable);
		$criteria->compare('highIsGood',$this->highIsGood);
		$criteria->compare('categoryID',$this->categoryID);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}