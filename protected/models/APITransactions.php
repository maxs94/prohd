<?php
class APITransactions extends EVEXMLData
{

	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/char/WalletTransactions.xml.aspx',
			'cacheID'=>'APITransactions',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
			'storageTable'=>'orders',
			'cacheOffset'=>2700,
			'cacheOverride'=>3600,
		);
	}

	public function storeData($walletID)
	{
		$attributes = $this->apiAttributes();
		
		//Retrieve the XML dataset
		$transactions = $this->getEVEData($walletID);
		
		Yii::log(print_r($transactions,true));
		
		$character = Characters::Model()->findByPk($walletID);
		
		if(!(isset($transactions->error)))
		{
			$row = $transactions->result->rowset->row;
			for ($i = count($row) - 1; $i >= 0; $i--)
			{
				if ($character->limitUpdate)
				{
					$orderTime = strtotime($row[$i]->attributes()->transactionDateTime);
					$timeLimit = strtotime($character->limitDate);
				}
				else
				{
					$orderTime = 1;
					$timeLimit = 0;
				}
				
				$exist = Wallet::Model()->exists('transactionID=:transactionID',array(':transactionID'=>$row[$i]->attributes()->transactionID));
				if (($exist == false) && ($orderTime > $timeLimit))
				{
					if($row[$i]->attributes()->transactionFor == "personal")
					{
						
						$orderRow = new Wallet;
						$orderRow->transactionDateTime = $row[$i]->attributes()->transactionDateTime;
						$orderRow->transactionID = $row[$i]->attributes()->transactionID;
						$orderRow->quantity = $row[$i]->attributes()->quantity;
						$orderRow->typeName = $row[$i]->attributes()->typeName;
						$orderRow->typeID = $row[$i]->attributes()->typeID;
						$orderRow->price = (double) $row[$i]->attributes()->price;
						$orderRow->clientID = $row[$i]->attributes()->clientID;
						$orderRow->clientName = $row[$i]->attributes()->clientName;
						$orderRow->stationID = $row[$i]->attributes()->stationID;
						$orderRow->stationName = $row[$i]->attributes()->stationName;
						$orderRow->transactionType = $row[$i]->attributes()->transactionType;
						$orderRow->characterID = $walletID;
						$orderRow->personal = 0;
						
						$lastPrice = $this->lastStockPrice($orderRow->typeID,$orderRow,$character->walletID);
						
						if ($orderRow->transactionType == "buy")
						{
							$this->addStock($orderRow);
						}

						if (($lastPrice == 0) || ($orderRow->transactionType == "buy"))
						{
							$orderRow->profit = 0;
						}
						else
						{
							$orderRow->profit = ($orderRow->quantity * $orderRow->price) - ($orderRow->quantity * $lastPrice);
							$this->subtractStock($orderRow,$orderRow->quantity,$character->walletID);
						}
						
						$orderRow->save();
                         //print_r($orderRow->getErrors());
						 if (count($orderRow->getErrors()) > 0) Yii::log(print_r($orderRow->getErrors(), true), "warning", "APITransactions");
						 
						 
					}
				}
			}
		}
	}
	
	public function lastJitaPrice($typeID, $days, $walletID)
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray($this->getUsersGroup($walletID));
		$sqlarray = '('.implode(',',$members).')';
		
		//Get the last Jita buy price
		$criteria = new CDbCriteria;
		$criteria->condition = ('typeID=:typeID AND characterID IN '.$sqlarray.' AND stationID = 60003760 AND transactionType = "buy" AND personal = 0');
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
	
	public function lastStockPrice($typeID, $days, $walletID)
	{
		//Grab the characters from the db
                try
                {
                    $trackingGroup = $this->getUsersGroup($walletID);
                }
                catch (Exception $e)
                {
                    $trackingGroup = 1;
                }
                
		$members = $this->getMembersAsArray($trackingGroup);
		$sqlarray = '('.implode(',',$members).')';
		
		//Get the last Jita buy price
		$criteria = new CDbCriteria;
		$criteria->condition = ('typeID=:typeID AND characterID IN '.$sqlarray.' AND personal = 0');
		$criteria->params = array(':typeID'=>$typeID);
		$criteria->order = 'transactionDateTime DESC';
		
		//Run the query
		$lastStock = Inventory::Model()->find($criteria);
		
		if ($lastStock != NULL)
		{
			return $lastStock->price;
		}
		else return $this->lastJitaPrice($typeID, $days, $walletID);
	}
	
	public function getMembersAsArray($groupID)
	{
		
		$members = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		foreach ($members as $member)
		{
			$memberArray[] = $member->characterID;
		}
		
		return $memberArray;
	}
	
	public function addStock($orderRow)
	{
		if(!(Inventory::Model()->exists('transactionID=:transactionID',array(':transactionID'=>$orderRow->transactionID))))
		{
			$stock = new Inventory;
			
			$stock->transactionDateTime = $orderRow->transactionDateTime;
			$stock->transactionID = $orderRow->transactionID;
			$stock->quantity = $orderRow->quantity;
			$stock->remaining = $orderRow->quantity;
			$stock->typeName = $orderRow->typeName;
			$stock->typeID = $orderRow->typeID;
			$stock->price = $orderRow->price;
			$stock->clientID = $orderRow->clientID;
			$stock->characterID = $orderRow->characterID;
			$stock->clientName = $orderRow->clientName;
			$stock->stationID = $orderRow->stationID;
			$stock->stationName = $orderRow->stationName;
			$stock->personal = 0;
			$stock->save();
		}
	}
	
	public function subtractStock($orderRow,$quantity,$walletID)
	{
		//Grab the characters from the db
                try
                {
                    $trackingGroup = $this->getUsersGroup($walletID);
                }
                catch (Exception $e)
                {
                    $trackingGroup = 1;
                }
                
		$members = $this->getMembersAsArray($trackingGroup);
		$sqlarray = '('.implode(',',$members).')';
		
		$criteria = new CDbCriteria;
		$criteria->condition = "typeID=:typeID AND remaining > 0 AND characterID IN ".$sqlarray;
		$criteria->params = array(":typeID"=>$orderRow->typeID);
		$criteria->order = "transactionDateTime DESC";
		
		$stock = Inventory::Model()->find($criteria);
		if ($stock != NULL)
		{
			//Check to see if the quantity we need to subtract is greater than this record
			if ($quantity >= $stock->remaining)
			{
				$stockLeft = $stock->remaining;
				$stock->remaining = 0;
				$stock->save();
				$log = new InventoryLog;
				$log->sourceTransactionID = $orderRow->transactionID;
				$log->targetTransactionID = $stock->transactionID;
				$log->quantity = $stockLeft;
				$log->save();
			}
			else
			{
				$stock->remaining = $stock->remaining - $quantity;
				$stock->save();
				$log = new InventoryLog;
				$log->sourceTransactionID = $orderRow->transactionID;
				$log->targetTransactionID = $stock->transactionID;
				$log->quantity = $quantity;
				$log->save();
			}
			
			$quantity = $quantity - $stock->quantity;
			
			//If we're out of stock to remove
			if ($quantity <= 0)
			{
				return;
			}
			else
			{
				$this->subtractStock($orderRow,$quantity);
			}
		}
	}
	
	public function getMembersArray($groupID)
	{
		
		$members = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		foreach ($members as $member)
		{
			$memberArray[] = $member->characterID;
		}
		
		return $memberArray;
	}
        
        public function getUsersGroup($walletID)
        {
            $trackingGroup = TrackingGroupMembers::Model()->find('characterID=:walletID',array(':walletID'=>$walletID));
            return $trackingGroup->trackingGroupID;
        }
}
?>