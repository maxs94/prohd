<?php

/**
 * This is the model class for table "pi".
 *
 * The followings are the available columns in table 'pi':
 * @property integer $characterID
 * @property integer $moonID
 * @property integer $typeID
 * @property integer $processorTypeID
 * @property integer $processorCount
 * @property integer $averageOutput
 */
class Pi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pi the static model class
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
		return 'pi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('characterID, moonID, typeID, processorTypeID, processorCount, averageOutput', 'required'),
			array('characterID, moonID, typeID, processorTypeID, processorCount, averageOutput', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('characterID, moonID, typeID, processorTypeID, processorCount, averageOutput', 'safe', 'on'=>'search'),
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
			'characterID' => 'Character',
			'moonID' => 'Moon',
			'typeID' => 'Type',
			'processorTypeID' => 'Processor Type',
			'processorCount' => 'Processor Count',
			'averageOutput' => 'Average Output',
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

		$criteria->compare('characterID',$this->characterID);
		$criteria->compare('moonID',$this->moonID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('processorTypeID',$this->processorTypeID);
		$criteria->compare('processorCount',$this->processorCount);
		$criteria->compare('averageOutput',$this->averageOutput);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}