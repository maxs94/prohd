<?php

class ReportsController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionIndex()
	{
	
		//Get our profit data array
		$profitArray = $this->getProfitData();
		
		//Calc 5 day moving average
		$fiveDayMoving = $this->calcMovingAverage($profitArray,5);
		
		//Calc 20 day moving average
		$twentyDayMoving = $this->calcMovingAverage($profitArray,20);
	
		$this->render('index', array
			(
			'profitArray'=>$profitArray,
			'fiveDayMoving'=>$fiveDayMoving,
			'twentyDayMoving'=>$twentyDayMoving
			)
		);
	}
	
	public function actionGross()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('gross', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionMove()
	{
		$this->render('move');
	}
	
	public function actionWallet()
	{
		$profitArray = $this->getWalletData();
		
		$fiveDayMoving = $this->calcMovingAverage($profitArray,5);
		$twentyDayMoving = $this->calcMovingAverage($profitArray,20);
		
		$this->render('wallet', array
			(
			'profitArray'=>$profitArray,
			'fiveDayMoving'=>$fiveDayMoving,
			'twentyDayMoving'=>$twentyDayMoving
			)
		);
	}
	
	public function getProfitData()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, SUM( profit ) AS totalProfit
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "sell"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,round(($row['totalProfit'] / 1000000),2));
		}
		return $profitData;
	}
	
	public function getIncomeData()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, SUM( (price * quantity) ) AS totalIncome
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "sell"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,round(($row['totalIncome'] / 1000000),2));
		}
		return $profitData;
	}
	
	public function getExpenditureData()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, SUM( (price * quantity) ) AS totalIncome
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "buy"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,round(($row['totalIncome'] / 1000000),2));
		}
		return $profitData;
	}
	
	public function getMovementData()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, COUNT(transactionDateTime) AS totalVolume
					FROM wallet
					WHERE personal = 0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "sell"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,$row['totalVolume']);
		}
		return $profitData;
	}
	
	public function getStationMovementData($stationID)
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, COUNT(transactionDateTime) AS totalVolume
					FROM wallet
					WHERE personal = 0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "sell"
					AND stationID = '.$stationID.'
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,$row['totalVolume']);
		}
		return $profitData;
	}
	
	public function getVolumeData()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, SUM( quantity ) AS totalVolume
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "sell"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,$row['totalVolume']);
		}
		return $profitData;
	}
	
	public function getWalletData()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( balanceDateTime ) AS date1, MAX( balance ) AS balance1
					FROM balances
					WHERE characterID = 1663841543
					GROUP BY date1
					ORDER BY date1');		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$walletResults=$command->query();
		foreach ($walletResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$walletData[] = array($date,$row['balance1'] / 1000000);
		}
		return $walletData;
	}
	
	public function calcMovingAverage($profitArray,$days)
	{
		foreach ($profitArray as $row)
		{
			if ((count($fiveDays)) < ($days - 1))
			{
				$fiveDays[] = $row[1];
			}
			else
			{
				$fiveDays[] = $row[1];
				$total = 0;
				foreach ($fiveDays as $day)
				{
					$total = $total + $day;
				}
				$average = $total / $days;
				$fiveDayArray[] = array($row[0],$average);
				array_shift($fiveDays);
			}
		}
		return $fiveDayArray;
	}
	
	public function getItemHistoricalData($typeID, $sell='sell')
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		$criteria = new CdbCriteria;
		$criteria->condition = 'typeID=:typeID AND transactionType = :sell AND personal = 0 AND characterID IN '.$sqlarray.'';
		$criteria->params = array(':typeID'=>$typeID, ':sell'=>$sell);
		$criteria->order = 'transactionDateTime';
		
		$history = Wallet::Model()->findAll($criteria);
		$graphArray = '[';
		foreach ($history as $transaction)
		{
			$date = (strtotime($transaction->transactionDateTime) - (5*60*60)) * 1000;
			$graphArray = $graphArray . '['.$date.','.$transaction->price.'],';
		}
		$graphArray = $graphArray . ']';
		return $graphArray;
	}
	
	public function actionHacsales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('hacsales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionFuelsales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('fuelsales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionBssales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('bssales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionBasicimplantsales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('basicimplantsales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionStandardimplantsales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('standardimplantsales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionBcsales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('bcsales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionBctier3sales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('bctier3sales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionLargerigssales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('largerigssales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionIndustrysales()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('industrysales', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
	}
	
	public function actionStation()
	{
	
		//Get our profit data array
		$incomeArray = $this->getIncomeData();
		
		$this->render('station', array
			(
			'incomeArray'=>$incomeArray,
			)
		);
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
	
	public function printMenu()
	{
		$this->menu=array(
		array('label'=>'Profit History', 'url'=>array('index')),
		array('label'=>'Revenue & Expenditures', 'url'=>array('gross')),
		array('label'=>'Volume & Movement', 'url'=>array('move')),
		array('label'=>'Wallet History', 'url'=>array('wallet')),
		array('label'=>'Stations', 'url'=>array('station')),
		array('label'=>'BS', 'url'=>array('bssales')),
		array('label'=>'BC', 'url'=>array('bcsales')),
		array('label'=>'BC Tier3', 'url'=>array('bctier3sales')),
		array('label'=>'HAC', 'url'=>array('hacsales')),
		array('label'=>'Fuel', 'url'=>array('fuelsales')),
		array('label'=>'Industry', 'url'=>array('industrysales')),
		array('label'=>'Large Rigs', 'url'=>array('largerigssales')),
		array('label'=>'Basic Implant', 'url'=>array('basicimplantsales')),
		array('label'=>'Standard Implant', 'url'=>array('standardimplantsales')),
		);
	}
	
}