<?php

/**
 * This is the model class for table "projectMaterials".
 *
 * The followings are the available columns in table 'projectMaterials':
 * @property integer $materialID
 * @property integer $projectID
 * @property integer $typeID
 * @property integer $required
 * @property integer $quantity
 * @property integer $isMineral
 */
class ProjectMaterials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectMaterials the static model class
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
		return 'projectMaterials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectID, typeID, required, quantity, isMineral', 'required'),
			array('projectID, typeID, required, quantity, isMineral', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('materialID, projectID, typeID, required, quantity, isMineral', 'safe', 'on'=>'search'),
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
			'materialID' => 'Material',
			'projectID' => 'Project',
			'typeID' => 'Type',
			'required' => 'Required',
			'quantity' => 'Quantity',
			'isMineral' => 'Is Mineral',
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

		$criteria->compare('materialID',$this->materialID);
		$criteria->compare('projectID',$this->projectID);
		$criteria->compare('typeID',$this->typeID);
		$criteria->compare('required',$this->required);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('isMineral',$this->isMineral);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}