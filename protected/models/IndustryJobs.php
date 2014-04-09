<?php

/**
 * This is the model class for table "industryJobs".
 *
 * The followings are the available columns in table 'industryJobs':
 * @property integer $jobID
 * @property integer $assemblyLineID
 * @property integer $containerID
 * @property string $installedItemID
 * @property integer $installedItemLocationID
 * @property integer $installedItemQuantity
 * @property integer $installedItemProductivityLevel
 * @property integer $installedItemMaterialLevel
 * @property integer $installedItemLicensedProductionRunsRemaining
 * @property integer $outputLocationID
 * @property integer $installerID
 * @property integer $runs
 * @property integer $licensedProductionRuns
 * @property integer $installedInSolarSystemID
 * @property integer $containerLocationID
 * @property double $materialMultiplier
 * @property double $charMaterialMultiplier
 * @property double $timeMultiplier
 * @property double $charTimeMultiplier
 * @property integer $installedItemTypeID
 * @property integer $outputTypeID
 * @property integer $containerTypeID
 * @property integer $installedItemCopy
 * @property integer $completed
 * @property integer $completedSuccessfully
 * @property integer $installedItemFlag
 * @property integer $activityID
 * @property integer $completedStatus
 * @property string $installTime
 * @property integer $outputFlag
 * @property string $beginProductionTime
 * @property string $endProductionTime
 * @property string $pauseProductionTime
 */
class IndustryJobs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return IndustryJobs the static model class
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
		return 'industryJobs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jobID, assemblyLineID, containerID, installedItemID, installedItemLocationID, installedItemQuantity, installedItemProductivityLevel, installedItemMaterialLevel, installedItemLicensedProductionRunsRemaining, outputLocationID, installerID, runs, licensedProductionRuns, installedInSolarSystemID, containerLocationID, materialMultiplier, charMaterialMultiplier, timeMultiplier, charTimeMultiplier, installedItemTypeID, outputTypeID, containerTypeID, installedItemCopy, completed, completedSuccessfully, installedItemFlag, activityID, completedStatus, installTime, outputFlag, beginProductionTime, endProductionTime, pauseProductionTime', 'required'),
			array('jobID, assemblyLineID, containerID, installedItemLocationID, installedItemQuantity, installedItemProductivityLevel, installedItemMaterialLevel, installedItemLicensedProductionRunsRemaining, outputLocationID, installerID, runs, licensedProductionRuns, installedInSolarSystemID, containerLocationID, installedItemTypeID, outputTypeID, containerTypeID, installedItemCopy, completed, completedSuccessfully, installedItemFlag, activityID, completedStatus, outputFlag', 'numerical', 'integerOnly'=>true),
			array('materialMultiplier, charMaterialMultiplier, timeMultiplier, charTimeMultiplier', 'numerical'),
			array('installedItemID', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jobID, assemblyLineID, containerID, installedItemID, installedItemLocationID, installedItemQuantity, installedItemProductivityLevel, installedItemMaterialLevel, installedItemLicensedProductionRunsRemaining, outputLocationID, installerID, runs, licensedProductionRuns, installedInSolarSystemID, containerLocationID, materialMultiplier, charMaterialMultiplier, timeMultiplier, charTimeMultiplier, installedItemTypeID, outputTypeID, containerTypeID, installedItemCopy, completed, completedSuccessfully, installedItemFlag, activityID, completedStatus, installTime, outputFlag, beginProductionTime, endProductionTime, pauseProductionTime', 'safe', 'on'=>'search'),
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
			'jobID' => 'Job',
			'assemblyLineID' => 'Assembly Line',
			'containerID' => 'Container',
			'installedItemID' => 'Installed Item',
			'installedItemLocationID' => 'Installed Item Location',
			'installedItemQuantity' => 'Installed Item Quantity',
			'installedItemProductivityLevel' => 'Installed Item Productivity Level',
			'installedItemMaterialLevel' => 'Installed Item Material Level',
			'installedItemLicensedProductionRunsRemaining' => 'Installed Item Licensed Production Runs Remaining',
			'outputLocationID' => 'Output Location',
			'installerID' => 'Installer',
			'runs' => 'Runs',
			'licensedProductionRuns' => 'Licensed Production Runs',
			'installedInSolarSystemID' => 'Installed In Solar System',
			'containerLocationID' => 'Container Location',
			'materialMultiplier' => 'Material Multiplier',
			'charMaterialMultiplier' => 'Char Material Multiplier',
			'timeMultiplier' => 'Time Multiplier',
			'charTimeMultiplier' => 'Char Time Multiplier',
			'installedItemTypeID' => 'Installed Item Type',
			'outputTypeID' => 'Output Type',
			'containerTypeID' => 'Container Type',
			'installedItemCopy' => 'Installed Item Copy',
			'completed' => 'Completed',
			'completedSuccessfully' => 'Completed Successfully',
			'installedItemFlag' => 'Installed Item Flag',
			'activityID' => 'Activity',
			'completedStatus' => 'Completed Status',
			'installTime' => 'Install Time',
			'outputFlag' => 'Output Flag',
			'beginProductionTime' => 'Begin Production Time',
			'endProductionTime' => 'End Production Time',
			'pauseProductionTime' => 'Pause Production Time',
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

		$criteria->compare('jobID',$this->jobID);
		$criteria->compare('assemblyLineID',$this->assemblyLineID);
		$criteria->compare('containerID',$this->containerID);
		$criteria->compare('installedItemID',$this->installedItemID,true);
		$criteria->compare('installedItemLocationID',$this->installedItemLocationID);
		$criteria->compare('installedItemQuantity',$this->installedItemQuantity);
		$criteria->compare('installedItemProductivityLevel',$this->installedItemProductivityLevel);
		$criteria->compare('installedItemMaterialLevel',$this->installedItemMaterialLevel);
		$criteria->compare('installedItemLicensedProductionRunsRemaining',$this->installedItemLicensedProductionRunsRemaining);
		$criteria->compare('outputLocationID',$this->outputLocationID);
		$criteria->compare('installerID',$this->installerID);
		$criteria->compare('runs',$this->runs);
		$criteria->compare('licensedProductionRuns',$this->licensedProductionRuns);
		$criteria->compare('installedInSolarSystemID',$this->installedInSolarSystemID);
		$criteria->compare('containerLocationID',$this->containerLocationID);
		$criteria->compare('materialMultiplier',$this->materialMultiplier);
		$criteria->compare('charMaterialMultiplier',$this->charMaterialMultiplier);
		$criteria->compare('timeMultiplier',$this->timeMultiplier);
		$criteria->compare('charTimeMultiplier',$this->charTimeMultiplier);
		$criteria->compare('installedItemTypeID',$this->installedItemTypeID);
		$criteria->compare('outputTypeID',$this->outputTypeID);
		$criteria->compare('containerTypeID',$this->containerTypeID);
		$criteria->compare('installedItemCopy',$this->installedItemCopy);
		$criteria->compare('completed',$this->completed);
		$criteria->compare('completedSuccessfully',$this->completedSuccessfully);
		$criteria->compare('installedItemFlag',$this->installedItemFlag);
		$criteria->compare('activityID',$this->activityID);
		$criteria->compare('completedStatus',$this->completedStatus);
		$criteria->compare('installTime',$this->installTime,true);
		$criteria->compare('outputFlag',$this->outputFlag);
		$criteria->compare('beginProductionTime',$this->beginProductionTime,true);
		$criteria->compare('endProductionTime',$this->endProductionTime,true);
		$criteria->compare('pauseProductionTime',$this->pauseProductionTime,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}