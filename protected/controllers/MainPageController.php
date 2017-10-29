<?php

class MainPageController extends Controller
{


	/**
	* This is the main action of the dashboard
	* This method is used by the 'accessControl' filter.
	*/
	public function actionIndex()
	{
		$this->render('index');
	}
	
	
	public function actionStuff()
	{
		//Start to roll backwards through 30 days
		$i = 0;
		$datetime = $this->getEveTimeSql();
		while ($i < 31)
		{
			$sales = Wallet::Model()->findAll('DATE(transactionDateTime) = DATE_SUB(DATE(:currentDate), INTERVAL :days day) AND transactionType = "sell" AND personal = 0',array(':days'=>$i,':currentDate'=>$datetime));
			
			$profitTable = new Profits;
			$runningTotal = 0;
			
			foreach($sales as $sale)
			{
			
			
				$lastJita = $this->lastJitaPrice($sale->typeID,$sale);
				if ($lastJita == 0)
				{
					$profit = 0;	
				}
				else
				{
					$profit = ($sale->quantity * $sale->price) - ($sale->quantity * $lastJita);
				}
				
				if (!($profit == $sale->profit))
				{
					echo "DEBUG: $sale->transactionID - $sale->typeName - Q: $sale->quantity L: $lastJita P: $sale->price EXP: $profit ACT: $sale->profit <br>";
				}
				
				$runningTotal = $runningTotal + $profit;
			}
			
			$date = strtotime("- $i day",$this->getEveTime());
			$mysqldate = date( 'Y-m-d', $date );
			echo $mysqldate . "<br>";
			
			$profitTable->total = $runningTotal;
			$profitTable->date = $mysqldate;
			$profitTable->save();
			print_r($profitTable->getErrors());
			$i++;

		}
		
		$this->render('index');
		//$this->redirect('index.php?r=mainPage/index');
	}
	
	public function actionGenerate()
	{
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		//Get the whole wallet
		$transactions = Wallet::Model()->findAll('characterID IN '.$sqlarray.'');
		
		foreach($transactions as $transaction)
		{
			//Get the individual row to update with the profits
			$updatedTransaction = Wallet::Model()->findByPk($transaction->transactionID);
			
			//Find our profit
			$lastJita = $this->lastJitaPrice($transaction->typeID,$transaction);
			
			if (($lastJita == 0) || ($transaction->transactionType == "buy"))
			{
			$updatedTransaction->profit = 0;
			}
			else
			{
				$updatedTransaction->profit = ($transaction->quantity * $transaction->price) - ($transaction->quantity * $lastJita);
			}
			
			//Save the transaction
			$updatedTransaction->save();
			
		}
	
		$this->render('index');
	}
			
	public function actionIndexajax()
	{
		$this->renderPartial('_indexAjax',NULL,false,true);
	}
	
	public function actionUpdatejournal()
	{
		$this->renderPartial('_updateJournal');
	}

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // Enable access authentication control for this page
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
			array('allow', // allow admin user only
				'actions'=>array('index','stuff','generate','indexajax','updatejournal'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function income($numDays)
	{
		//Get our current group characters
		$members = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		
		$currentDate = $this->getEveTimeSql();
		//Establish the search criteria
		$criteria = new CDbCriteria;
		$criteria->select='amount'; //select only the amount
		$criteria->condition='refTypeID = 2 AND DATE(date) >= (DATE_SUB(DATE( :currentDate ), INTERVAL :numDays DAY)) AND 
			(ownerID2 IN '.$sqlarray.')'; //where only for the selected number of days and only Blakes and Mathias selling
		$criteria->params=array(':numDays'=>$numDays,':currentDate'=>$currentDate); //sets the correct number of days for the previous condition above
		
		//Run the sales query using those criteria
		$salesArray=Journal::model()->findAll($criteria);
		
		//Add all the numbers in the sales array
		if (!empty($salesArray))
		{
			foreach ($salesArray as $arrayRow)
			{
				$salesValues[] = $arrayRow->amount;
			}
			$totalSales = array_sum($salesValues);
			return number_format($totalSales, 2);
		}
		else return "0.00";
		
	}
	
        public function brokerFees($numDays)
	{
		
		//Get our current group characters
		$members = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		
		$currentDate = $this->getEveTimeSql();
		//Establish the search criteria
		$criteria = new CDbCriteria;
		$criteria->select='amount'; //select only the amount
		$criteria->condition='refTypeID = 46 AND DATE(date) >= (DATE_SUB(DATE( :currentDate ), INTERVAL :numDays DAY)) AND ownerID1 IN '.$sqlarray.''; //where only for the selected number of days and only Blakes and Mathias selling
		$criteria->params=array(':numDays'=>$numDays,':currentDate'=>$currentDate); //sets the correct number of days for the previous condition above
		
		//Run the sales query using those criteria
		$feesArray=Journal::model()->findAll($criteria);
		
		//Add all the numbers in the sales array
		if (!empty($feesArray))
		{
			foreach ($feesArray as $arrayRow)
			{
				$feesValues[] = $arrayRow->amount;
			}
			$totalFees = array_sum($feesValues);
			return number_format($totalFees, 2);
		}
		else return "0.00";
		
	}
	
        public function taxes($numDays)
	{
		
		//Get our current group characters
		$members = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$currentDate = $this->getEveTimeSql();
		//Establish the search criteria
		$criteria = new CDbCriteria;
		$criteria->select='amount'; //select only the amount
		$criteria->condition='refTypeID = 54 AND DATE(date) >= (DATE_SUB(DATE( :currentDate ), INTERVAL :numDays DAY)) AND ownerID1 IN '.$sqlarray.''; //where only for the selected number of days and only Blakes and Mathias selling
		$criteria->params=array(':numDays'=>$numDays,':currentDate'=>$currentDate); //sets the correct number of days for the previous condition above
		
		//Run the sales query using those criteria
		$taxArray=Journal::model()->findAll($criteria);
		
		//Add all the numbers in the sales array
		if (!empty($taxArray))
		{
			foreach ($taxArray as $arrayRow)
			{
				$taxValues[] = $arrayRow->amount;
			}
			$totalTaxes = array_sum($taxValues);
			return number_format($totalTaxes, 2);
		}
		else return "0.00";
		
	}
	
	public function getBalanceOld($character)
	{
		//Get last balance of $character
		$criteria = new CDbCriteria;
		$criteria->condition='characterID=:characterID';
		$criteria->params=array(':characterID'=>$character);
		$criteria->order='date DESC';
		
		//Run the query
		$journalEntry = Journal::Model()->find($criteria);
		
		return $journalEntry->balance;
		
	}
	
	public function minutesSeconds($seconds)
	{
		if ($seconds == 0)
		{
			return "Ready";
		}
		return floor($seconds/60) . " minutes, " . $seconds % 60 . " seconds";
	}
	
	public function lastJitaPrice($typeID, $days)
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		//Get the last Jita buy price
		$criteria = new CDbCriteria;
		$criteria->condition = ('typeID=:typeID AND characterID IN '.$sqlarray.' AND stationID = 60003760 AND transactionType = "buy"');
		$criteria->params = array(':typeID'=>$typeID);
		$criteria->order = 'transactionDateTime DESC';
		
		//Run the query
		$lastJita = Wallet::Model()->find($criteria);
		
		if (!(empty($lastJita)))
		{
			return $lastJita->price;
		}
		else return 0;
	}
	
	
	/*
	public function getProfitData($days)
	{
		$i = $days;
		while ($i >= 0)
		{
			$profitData = Profits::Model()->find('date = DATE_SUB(CURDATE(), INTERVAL :days day)',array(':days'=>$i));
			$value = floor($profitData->total / 1000000);
			
			$profitValues = $profitValues . $value;
			if (!($i == 0))
			{
				$profitValues = $profitValues . ",";
			}
			$i--;
		}
		
		return $profitValues;
	}
	*/
	
	public function getProfitData($days)
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, SUM( profit ) AS totalProfit
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND DATE( transactionDateTime ) > DATE_SUB( :eveDate , INTERVAL :days DAY )
					AND transactionType = "sell"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		$command->bindParam(":days",$days,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			if ($row['totalProfit'] < 0)
			{
				$row['totalProfit'] = 0;
			}
			$date = (strtotime($row['date1']) - (4*60*60)) * 1000;
			$profitData[] = array($date,round(($row['totalProfit'] / 1000000),2));
		}
		return $profitData;
	}
	
	public function getProfitDataOld($days)
	{
		
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
	
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, SUM( profit ) AS totalProfit
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND DATE( transactionDateTime ) > DATE_SUB( :eveDate , INTERVAL :days DAY )
					AND transactionType = "sell"
					GROUP BY date1
					ORDER BY date1');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		$command->bindParam(":days",$days,PDO::PARAM_STR);
		
		$profitResults=$command->query();
	
		/*
		$criteria = new CDbCriteria;
		$criteria->select = 'DATE(transactionDateTime) as date1, SUM(profit) as totalProfit';
		$criteria->condition = 'transactionType = "sell" AND personal = 0 AND DATE(transactionDateTime) > DATE_SUB(DATE(:eveDate), INTERVAL :days DAY)';
		$criteria->order = 'date1';
		$criteria->group = 'date1';
		$criteria->params = array(':eveDate'=>$eveDate,':days'=>$days);
		
		$profitResults = Wallet::Model()->findAll($criteria);
		*/
		$totalRows = $profitResults->rowCount;
		$i = 0;
		foreach ($profitResults as $row)
		{
			while ($i <($days - $totalRows))
			{
				$profitData = $profitData . "0,";
				$i++;
			}
			if (empty($row))
			{
				$profitData = $profitData . "0";
			}
			else
			{
				$profitData = $profitData . floor($row['totalProfit'] / 1000000);
			}
			
			$i++;
			if (!($i == $days))
			{
				$profitData = $profitData . ",";
			}
		}
		
		return $profitData;
		
	}
	
	public function getTopSales()
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
				LIMIT 10');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->query();

		return $results;
	
	}
	
	public function getLastSales() //Needs SQL Query Correction
	{
	$eveDate = $this->getEveTimeSql();
		
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		
		$sql = ('SELECT typeID, typeName, quantity, price, profit
				FROM wallet
				WHERE personal = 0
				AND transactionType = "sell"
				AND characterID IN ('.implode(',',$members).')
				ORDER BY transactionDateTime DESC
				LIMIT 25');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->query();

		return $results;
	
	}
	
	public function getTopGroups()
	{
	$eveDate = $this->getEveTimeSql();
		
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		
		$sql = ('SELECT SUM(profit) as totalProfit, SUM(quantity) as totalVolume, b.marketGroupID, a.marketGroupName, b.marketGroupName as parentName1, c.marketGroupName as parentName2
				FROM wallet
				JOIN (invTypes, invMarketGroups as a, invMarketGroups as b, invMarketGroups as c)
				ON (wallet.typeID = invTypes.typeID AND invTypes.marketGroupID = a.marketGroupID AND a.parentGroupID = b.marketGroupID AND b.parentGroupID = c.marketGroupID)
				WHERE DATE(transactionDateTime) > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
				AND characterID IN ('.implode(',',$members).')
				GROUP BY b.marketGroupID
				ORDER BY totalProfit DESC
				LIMIT 10');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->query();

		return $results;
	
	}
	
	public function getNetAssetValue()
	{
		$sql = "SELECT (SUM(assets.quantity * assetValues.value) / 1000000000) as netAssetValue FROM `assets`
				JOIN assetValues ON (assets.typeID = assetValues.typeID)
				JOIN characters ON (assets.characterID = characters.characterID)
				JOIN trackingGroupMembers on (characters.walletID = trackingGroupMembers.characterID)
				WHERE assets.typeName NOT LIKE '%blueprint%' AND trackingGroupMembers.trackingGroupID = ".Yii::app()->user->trackingGroupID;
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->queryScalar();

		return $results;
	}
	
	public function getCorpAssetValue()
	{
		$sql = "SELECT (SUM(corpAssets.quantity * assetValues.value) / 1000000000) as netAssetValue FROM `corpAssets`
				JOIN assetValues ON (corpAssets.typeID = assetValues.typeID)
				WHERE corpAssets.typeName NOT LIKE '%blueprint%' ";
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->queryScalar();

		return $results;
	}
	
	public function getOrderValue()
	{
		$sql = "SELECT (SUM(orders.volRemaining * orders.price) / 1000000000) as netOrderValue FROM `orders`
				JOIN characters ON (orders.charID = characters.characterID)
				JOIN trackingGroupMembers on (characters.walletID = trackingGroupMembers.characterID)
				WHERE orders.orderState = 0 AND orders.bid = 0 AND trackingGroupMembers.trackingGroupID = ".Yii::app()->user->trackingGroupID;
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->queryScalar();

		return $results;
	}
	
	public function getBlueprintValue()
	{
		$sql = "SELECT (SUM(blueprints.value) / 1000000000) as blueprintValue FROM `blueprints`
				JOIN characters ON (blueprints.characterID = characters.characterID)
				JOIN trackingGroupMembers on (characters.walletID = trackingGroupMembers.characterID)
				WHERE trackingGroupMembers.trackingGroupID = ".Yii::app()->user->trackingGroupID;
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->queryScalar();

		return $results;
	}
	
	public function getTotalBalance()
	{
		$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
		$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);
		foreach ($groupMembers as $member)
		{
			$character = Characters::Model()->findByPk($member->characterID);
			if ($character->displayBalance)
			{
				$criteria = new CDbCriteria;
				$criteria->condition = 'characterID = :characterID';
				$criteria->order = 'balanceDateTime DESC';
				$criteria->params = array(':characterID'=>$character->characterID);
				
				$balanceRow = Balances::Model()->find($criteria);
				
				$balance = $balance + $balanceRow->balance;
			}
		}
		return $balance;
	}					
}