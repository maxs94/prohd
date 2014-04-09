<?php

/**
 * This is the model class for table "planetSchematicsTypeMap".
 *
 * The followings are the available columns in table 'planetSchematicsTypeMap':
 * @property integer $schematicID
 * @property integer $typeID
 * @property integer $quantity
 * @property integer $isInput
 */
class PlanetSchematicsTypeMap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PlanetSchematicsTypeMap the static model class
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
		return 'planetSchematicsTypeMap';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('schematicID, typeID', 'required'),
			array('schematicID, typeID, quantity, isInput', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('schematicID, typeID, quantity, isInput', 'safe', 'on'=>'search'),
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
			'schematicID' => 'Schematic',
			'typeID' => 'Type',
			'quantity' => 'Quantity',
			'isInput' => 'Is Input',
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

		$criteria->compare('schematicID',$this->schematicID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('isInput',$this->isInput);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}