<?php

class MoversController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
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
				'actions'=>array('index'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	//Gets all the character sheets using data in the characters table

	public function getTopTenByProfit()
	{
		$eveDate = $this->getEveTimeSql();
		
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		
		$sql = ('SELECT typeID, typeName, sum( profit ) AS totalProfit, sum( quantity ) AS totalVolume
				FROM wallet
				WHERE DATE( transactionDateTime ) > DATE_SUB( DATE( :eveDate ), INTERVAL 30
				DAY )
				AND personal = 0
				AND transactionType = "sell"
				AND characterID IN ('.implode(',',$members).')
				GROUP BY typeID
				ORDER BY totalProfit DESC
				LIMIT 100');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->query();

		return $results;

	}
	
	
	public function getTopTenByVolume()
	{
	}
	
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	
	}