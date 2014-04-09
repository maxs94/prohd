<?php

class PosController extends Controller
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
	public function getPOS()
	{
	$sql = 'SELECT * FROM corpAssets WHERE groupID = 365 AND singleton = 1';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$tower[] = array("locationID"=>$row['locationID'], "locationName"=>$row['locationName'],"typeID"=>$row['typeID'],"singleton"=>$row['singleton'],"typeName"=>$row['typeName'],"itemID"=>$row['itemID']);
		}
	return $tower;
	}
	
	// Change this to find the number of fuel blocks in the tower
	//
	public function getFuelLevel($typeID, $itemID)
	{
	$sql = 'SELECT * FROM corpAssets WHERE containerID = '.$itemID.' ORDER BY typeID ASC';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$fuelItems[] = array("typeID"=>$row['typeID'],"quantity"=>$row['quantity'],"typeName"=>$row['typeName']);
		}
	return $fuelItems;
	}
	
	// Calc how many fuel blocks are left % wise
	//
	public function calcFuelLevel()
	{
	
	return number_format(33.33333333333,1);
	}
}