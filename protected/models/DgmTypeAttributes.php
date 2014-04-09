<?php

/**
 * This is the model class for table "dgmTypeAttributes".
 *
 * The followings are the available columns in table 'dgmTypeAttributes':
 * @property integer $typeID
 * @property integer $attributeID
 * @property integer $valueInt
 * @property double $valueFloat
 */
class DgmTypeAttributes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DgmTypeAttributes the static model class
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
		return 'dgmTypeAttributes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typeID, attributeID', 'required'),
			array('typeID, attributeID, valueInt', 'numerical', 'integerOnly'=>true),
			array('valueFloat', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('typeID, attributeID, valueInt, valueFloat', 'safe', 'on'=>'search'),
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
			'typeID' => 'Type',
			'attributeID' => 'Attribute',
			'valueInt' => 'Value Int',
			'valueFloat' => 'Value Float',
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

		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('attributeID',$this->attributeID);
		$criteria->compare('valueInt',$this->valueInt);
		$criteria->compare('valueFloat',$this->valueFloat);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}