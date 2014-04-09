<?php

class APIJournal extends EVEXMLData
{

	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/char/WalletJournal.xml.aspx',
			'cacheID'=>'APIJournal',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
			'storageTable'=>'journal',
			'cacheOffset'=>0,
			'cacheOverride'=>0,
		);
	}

	public function storeData($walletID)
	{
		$attributes = $this->apiAttributes();
		$character = Characters::Model()->findByPk($walletID);
		
		//Retrieve the XML dataset
		$journal = $this->getEVEData($walletID);
		
		if(!(isset($journal->error)))
		{
			foreach ($journal->result->rowset->row as $row)
			{
				if ($character->limitUpdate)
				{
					$orderTime = strtotime($row->attributes()->date);
					$timeLimit = strtotime($character->limitDate);
				}
				else
				{
					$orderTime = 1;
					$timeLimit = 0;
				}
				
				$exist = Journal::Model()->exists('refID=:refID',array(':refID'=>$row->attributes()->refID));
				if ((!$exist) && ($orderTime > $timeLimit))
				{
					$orderRow = new Journal;
					$orderRow->date = $row->attributes()->date;
					$orderRow->refID = $row->attributes()->refID;
					$orderRow->refTypeID = $row->attributes()->refTypeID;
					$orderRow->ownerName1 = $row->attributes()->ownerName1;
					$orderRow->ownerID1 = $row->attributes()->ownerID1;
					$orderRow->ownerName2 = $row->attributes()->ownerName2;
					$orderRow->ownerID2 = $row->attributes()->ownerID2;
					$orderRow->argName1 = $row->attributes()->argName1;
					$orderRow->argID1 = $row->attributes()->argID1;
					$orderRow->amount = $row->attributes()->amount;
					$orderRow->balance = $row->attributes()->balance;
					$orderRow->reason = $row->attributes()->reason;
					$orderRow->characterID = $walletID;
					$orderRow->save();
				}
			}
		}
	}
}
?>