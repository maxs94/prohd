<?php

class InventionStatsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionIndexajax()
	{
		$this->renderPartial('_indexAjax');
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin only
				'actions'=>array('index','indexajax'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	public function usageCheck($installedItemID)
	{
		//Grab an industry job for this installedItemID if one exists
		$job = IndustryJobs::Model()->find('installedItemID=:installedItemID AND completed = 0',array(':installedItemID'=>$installedItemID));
		
		if ($job != NULL)
		{
			return "<img src='./images/tick.png' style='height: 12px; width: 12px;'>";
		}
	}
	
	public function inventionCalcTotal($typeID)
	{
	//Total Jobs
	$sql = 'SELECT COUNT(1)
	FROM industryJobs
	WHERE installedItemTypeID = '.$typeID.'
	AND activityID = 8';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['COUNT(1)'];
	}
	
	public function inventionCalcSuccess($typeID)
	{
	$sql = 'SELECT COUNT(1)
	FROM industryJobs
	WHERE installedItemTypeID = '.$typeID.'
	AND activityID = 8
	AND completedStatus = 1';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['COUNT(1)'];
	}
	
	public function getInventionTypes()
	{
	$sql = 'SELECT DISTINCT(installedItemTypeID) FROM industryJobs WHERE activityID = 8';
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$list[] = array("typeID"=>$row['installedItemTypeID']);
		}

	return $list;
	}
	
	public function getName($typeID)
	{
	$sql = 'SELECT typeName
	FROM invTypes
	WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemName = $results->read();
	
	return $itemName['typeName'];
	}
	
}