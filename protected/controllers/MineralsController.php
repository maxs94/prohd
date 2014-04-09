<?php

class MineralsController extends Controller
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
	
	/* moved to get data from assetValue table
	public function lastJitaPrice($typeID)
		{
			//Get the last Jita buy price
			$criteria = new CDbCriteria;
			$criteria->condition = ('typeID=:typeID AND (characterID = 0 OR characterID = 3) AND stationID = 60003760');
			$criteria->params = array(':typeID'=>$typeID);
			$criteria->order = 'transactionDateTime DESC';
			
			//Run the query
			$lastJita = Wallet::Model()->find($criteria);
			
			return $lastJita->price;
		}
	*/
	
	public function lastJitaPrice($typeID)
	{
	$sql = 'SELECT value
	FROM assetValues
	WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['value'];
	}

	/*
	public function lastJitaPrice($typeID)
	{
	$sql = 'SELECT value
	FROM assetValues
	WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['value'];
	}*/
		
	public function lastNullPrice($typeID)
		{
			//Get the last Null buy price
			$criteria = new CDbCriteria;
			$criteria->condition = ('typeID=:typeID AND (characterID = 2) AND stationID = 60014899 AND transactionType = "buy"');
			$criteria->params = array(':typeID'=>$typeID);
			$criteria->order = 'transactionDateTime DESC';
			
			//Run the query
			$lastNull = Wallet::Model()->find($criteria);
			
			return $lastNull->price;
		}
		
	public function lastJitaVolume($typeID,$range)
		{
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
			$sqlarray = '('.implode(',',$members).')';

			$eveDate = $this->getEveTimeSql();
			
			$sql = ('SELECT sum(quantity) as volume 
			FROM wallet 
			WHERE typeID = :typeID AND stationID = 60003760 
			AND transactionType = "sell"
			AND characterID IN '.$sqlarray.'
			AND DATE(transactionDateTime) > DATE_SUB( :eveDate, INTERVAL :days DAY)');
			
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
			$command->bindParam(":days",$range,PDO::PARAM_STR);
			$command->bindParam(":typeID",$typeID,PDO::PARAM_STR);
			
			//Run the query
			$results = $command->query();
			$volumeRow = $results->read();
			
				
			return $volumeRow['volume'];
		}
		
	public function lastNullVolume($typeID,$range)
		{
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
			$sqlarray = '('.implode(',',$members).')';

			$eveDate = $this->getEveTimeSql();
			
			$sql = ('SELECT sum(quantity) as volume 
			FROM wallet 
			WHERE typeID = :typeID AND stationID = 60014899
			AND transactionType = "buy"
			AND characterID IN '.$sqlarray.'
			AND DATE(transactionDateTime) > DATE_SUB( :eveDate, INTERVAL :days DAY)');
			
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
			$command->bindParam(":days",$range,PDO::PARAM_STR);
			$command->bindParam(":typeID",$typeID,PDO::PARAM_STR);
			
			//Run the query
			$results = $command->query();
			$volumeRow = $results->read();
			
				
			return $volumeRow['volume'];
		}
	public function mineralLowendVolumeArray()
	{
	
	$trit = $this->lastJitaVolume(34,30) + $this->lastNullVolume(34,30);
	$pye = $this->lastJitaVolume(35,30) + $this->lastNullVolume(35,30);
	$mex = $this->lastJitaVolume(36,30) + $this->lastNullVolume(36,30);
	$iso = $this->lastJitaVolume(37,30) + $this->lastNullVolume(37,30);

	return "[$trit,$pye,$mex,$iso]";
	}
	
	public function mineralHighendVolumeArray()
	{
	
	$noc = $this->lastJitaVolume(38,30) + $this->lastNullVolume(38,30);
	$zyd = $this->lastJitaVolume(39,30) + $this->lastNullVolume(39,30);
	$mega = $this->lastJitaVolume(40,30) + $this->lastNullVolume(40,30);
	$mor = $this->lastJitaVolume(11399,30) + $this->lastNullVolume(11399,30);
	
	return "[$noc,$zyd,$mega,$mor]";
	}
}