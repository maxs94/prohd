<?php

/**
 * This is the model class for table "invBlueprintTypes".
 *
 * The followings are the available columns in table 'invBlueprintTypes':
 * @property integer $blueprintTypeID
 * @property integer $parentBlueprintTypeID
 * @property integer $productTypeID
 * @property integer $productionTime
 * @property integer $techLevel
 * @property integer $researchProductivityTime
 * @property integer $researchMaterialTime
 * @property integer $researchCopyTime
 * @property integer $researchTechTime
 * @property integer $productivityModifier
 * @property integer $materialModifier
 * @property integer $wasteFactor
 * @property integer $maxProductionLimit
 */
class InvBlueprintTypes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return InvBlueprintTypes the static model class
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
		return 'invBlueprintTypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('blueprintTypeID', 'required'),
			array('blueprintTypeID, parentBlueprintTypeID, productTypeID, productionTime, techLevel, researchProductivityTime, researchMaterialTime, researchCopyTime, researchTechTime, productivityModifier, materialModifier, wasteFactor, maxProductionLimit', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('blueprintTypeID, parentBlueprintTypeID, productTypeID, productionTime, techLevel, researchProductivityTime, researchMaterialTime, researchCopyTime, researchTechTime, productivityModifier, materialModifier, wasteFactor, maxProductionLimit', 'safe', 'on'=>'search'),
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
			'blueprintTypeID' => 'Blueprint Type',
			'parentBlueprintTypeID' => 'Parent Blueprint Type',
			'productTypeID' => 'Product Type',
			'productionTime' => 'Production Time',
			'techLevel' => 'Tech Level',
			'researchProductivityTime' => 'Research Productivity Time',
			'researchMaterialTime' => 'Research Material Time',
			'researchCopyTime' => 'Research Copy Time',
			'researchTechTime' => 'Research Tech Time',
			'productivityModifier' => 'Productivity Modifier',
			'materialModifier' => 'Material Modifier',
			'wasteFactor' => 'Waste Factor',
			'maxProductionLimit' => 'Max Production Limit',
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

		$criteria->compare('blueprintTypeID',$this->blueprintTypeID);
		$criteria->compare('parentBlueprintTypeID',$this->parentBlueprintTypeID);
		$criteria->compare('productTypeID',$this->productTypeID);
		$criteria->compare('productionTime',$this->productionTime);
		$criteria->compare('techLevel',$this->techLevel);
		$criteria->compare('researchProductivityTime',$this->researchProductivityTime);
		$criteria->compare('researchMaterialTime',$this->researchMaterialTime);
		$criteria->compare('researchCopyTime',$this->researchCopyTime);
		$criteria->compare('researchTechTime',$this->researchTechTime);
		$criteria->compare('productivityModifier',$this->productivityModifier);
		$criteria->compare('materialModifier',$this->materialModifier);
		$criteria->compare('wasteFactor',$this->wasteFactor);
		$criteria->compare('maxProductionLimit',$this->maxProductionLimit);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}