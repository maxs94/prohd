<?php

class ProhdApiController extends Controller
{
	public function actionAddToCart()
	{
		$this->render('addToCart');
	}

	public function actionItemDetail()
	{
		$this->render('itemDetail');
	}

	public function actionListCart()
	{
		$this->render('listCart');
	}

	public function actionRemoveFromCart()
	{
		$this->render('removeFromCart');
	}

	public function actionSales()
	{
            //Check to see if we can get new data
            $groupMembers = $this->getTrackingGroupMembers(1);
            $transactionInterface = new APITransactions;
            if(!($transactionInterface->getCacheExpiration($groupMembers[0]->characterID)))
            {
                foreach ($groupMembers as $member)
                {
                    $orders = $transactionInterface->getEveData($member->characterID);
                    $character = Characters::Model()->findByPk($member->characterID);

                    if ($character->walletEnabled)
                    {
                            $transactionInterface->storeData($member->characterID);
                    }
                }
            }
            
            //Get our tracking group members
            $members = $this->getMembersAsArray(1);
            $sqlarray = '('.implode(',',$members).')';
            
            //Create our db criteria
            $criteria = new CDbCriteria;
            $criteria->condition = 'transactionType = "sell" AND characterID IN '.$sqlarray;
            $criteria->order = 'transactionDateTime DESC';
            $criteria->limit = 30;
            
            //Grab our last 30 transactions
            $results = Wallet::model()->findAll($criteria);
            
            //Create a new XML object
            $xmlObject = new DOMDocument();
            $root = $xmlObject->appendChild($xmlObject->createElement('TransactionList'));
            
            //Iterate over the db results and construct the XML
            foreach($results as $result)
            {
                //Create the parent tag for this transaction
                $trans = $root->appendChild($xmlObject->createElement('Transaction'));
                
                //Populate with the data
                $trans->appendChild($xmlObject->createElement('transactionDateTime', $result->transactionDateTime));
                $trans->appendChild($xmlObject->createElement('transactionTimestamp', strtotime($result->transactionDateTime)));
                $trans->appendChild($xmlObject->createElement('typeID', $result->typeID));
                $trans->appendChild($xmlObject->createElement('typeName', $result->typeName));
                $trans->appendChild($xmlObject->createElement('quantity', $result->quantity));
                $trans->appendChild($xmlObject->createElement('profit', $result->profit));
                $trans->appendChild($xmlObject->createElement('price', $result->price));
                $trans->appendChild($xmlObject->createElement('stationName', $result->stationName));
                $trans->appendChild($xmlObject->createElement('icon', $this->getIcon($result->typeID)));
            }
            
            //Render the XML
            $xmlObject->formatOutput = false;
            echo $xmlObject->saveXML();
            //$this->renderPartial('transactions',array('results'=>$results));
	}
        
        public function actionPurchases()
	{
            //Check to see if we can get new data
            $groupMembers = $this->getTrackingGroupMembers(1);
            $transactionInterface = new APITransactions;
            if(!($transactionInterface->getCacheExpiration($groupMembers[0]->characterID)))
            {
                foreach ($groupMembers as $member)
                {
                    $orders = $transactionInterface->getEveData($member->characterID);
                    $character = Characters::Model()->findByPk($member->characterID);

                    if ($character->walletEnabled)
                    {
                            $transactionInterface->storeData($member->characterID);
                    }
                }
            }
            
            //Get our tracking group members
            $members = $this->getMembersAsArray(1);
            $sqlarray = '('.implode(',',$members).')';
            
            //Create our db criteria
            $criteria = new CDbCriteria;
            $criteria->condition = 'transactionType = "buy" AND characterID IN '.$sqlarray;
            $criteria->order = 'transactionDateTime DESC';
            $criteria->limit = 30;
            
            //Grab our last 30 transactions
            $results = Wallet::model()->findAll($criteria);
            
            //Create a new XML object
            $xmlObject = new DOMDocument();
            $root = $xmlObject->appendChild($xmlObject->createElement('TransactionList'));
            
            //Iterate over the db results and construct the XML
            foreach($results as $result)
            {
                //Create the parent tag for this transaction
                $trans = $root->appendChild($xmlObject->createElement('Transaction'));
                
                //Populate with the data
                $trans->appendChild($xmlObject->createElement('transactionDateTime', $result->transactionDateTime));
                $trans->appendChild($xmlObject->createElement('transactionTimestamp', strtotime($result->transactionDateTime)));
                $trans->appendChild($xmlObject->createElement('typeID', $result->typeID));
                $trans->appendChild($xmlObject->createElement('typeName', $result->typeName));
                $trans->appendChild($xmlObject->createElement('quantity', $result->quantity));
                $trans->appendChild($xmlObject->createElement('profit', $result->profit));
                $trans->appendChild($xmlObject->createElement('price', $result->price));
                $trans->appendChild($xmlObject->createElement('stationName', $result->stationName));
                $trans->appendChild($xmlObject->createElement('icon', $this->getIcon($result->typeID)));
            }
            
            //Render the XML
            $xmlObject->formatOutput = false;
            echo $xmlObject->saveXML();
            //$this->renderPartial('transactions',array('results'=>$results));
	}
        
        public function actionOverview()
        {
            $incomeToday = $this->income(1);
            $incomeWeek = $this->income(7);
            $incomeMonth = $this->income(30);
            
            $profitArray = $this->getProfitData(30);

            $revProfit = array_reverse($profitArray);
            $i=0;
            $todaysProfit = 0;
            $sevenDayProfit = 0;
            $thirtyDaysProfit = 0;
            foreach ($revProfit as $row)
            {
                $i++;
                if ($i <= 1)
                {
                        $todaysProfit = $row[1];
                }
                if ($i <= 7)
                {
                        $sevenDayProfit = $sevenDayProfit + $row[1];
                }
                $thirtyDayProfit = $thirtyDayProfit + $row[1];
            }
            
            //Get our current group characters
            $members = $this->getMembersAsCharIDArray(1);
            $sqlarray = '('.implode(',',$members).')';
            $characters = Characters::Model()->findAll('characterID IN '.$sqlarray);
            $balance = 0;
                    
            foreach ($characters as $character)
            {
                $criteria = new CDbCriteria;
                $criteria->condition = 'characterID = :characterID';
                $criteria->params = array(':characterID'=>$character->characterID);
                $criteria->order = 'balanceDateTime DESC';
                $balance += Balances::model()->find($criteria)->balance;
            }
            
            //Create a new XML object
            $xmlObject = new DOMDocument();
            $root = $xmlObject->appendChild($xmlObject->createElement('Overview'));
            
            $root->appendChild($xmlObject->createElement('IncomeToday', $incomeToday));
            $root->appendChild($xmlObject->createElement('IncomeWeek', $incomeWeek));
            $root->appendChild($xmlObject->createElement('IncomeMonth', $incomeMonth));
            $root->appendChild($xmlObject->createElement('ProfitToday', $todaysProfit));
            $root->appendChild($xmlObject->createElement('ProfitWeek', $sevenDayProfit));
            $root->appendChild($xmlObject->createElement('ProfitMonth', $thirtyDayProfit));
            $root->appendChild($xmlObject->createElement('Balance', number_format($balance,2)));
            
            //Render the XML
            $xmlObject->formatOutput = false;
            echo $xmlObject->saveXML();
            
        }

        public function income($numDays)
	{
		//Get our current group characters
		$members = $this->getMembersAsCharIDArray(1);
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
		$members = $this->getMembersAsArray(1);
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
				LIMIT 10');
				
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