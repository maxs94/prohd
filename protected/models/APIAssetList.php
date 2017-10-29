<?php
class APIAssetList extends EVEXMLData
{
	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/char/AssetList.xml.aspx',
			'cacheID'=>'APIAssetList',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
		);
	}
	
	public function storeData($walletID)
	{
		$assets = $this->getEVEData($walletID);
		
		$character = Characters::model()->findByPk($walletID);
		
		Assets::Model()->deleteAll('characterID=:characterID',array(':characterID'=>$character->characterID));
                
                //echo $assets->__toString();
		
		$this->parseAssets($assets->result->rowset->row,$character->characterID,0);
                
                
	}
	
	public function parseAssets($rowset,$characterID,$containerID)
	{
                //echo "Working on container: $containerID <br>";
                
		foreach ($rowset as $item)
		{
			if ($item->count() > 0)
			{
                                //echo "Triggered next nest. Count = {$rowset->count()} <br>";
				$this->parseAssets($item->rowset->row,$characterID,$item->attributes()->itemID);
			}
			if (isset($item->attributes()->locationID))
			{
				$locationName = $this->getLocationName($item->attributes()->locationID);
			}
			$invType = Invtypes::Model()->findByPk($item->attributes()->typeID);

			
			$asset = new Assets;
			$asset->characterID = $characterID;
			$asset->itemID = $item->attributes()->itemID;
			$asset->locationID = $item->attributes()->locationID;
			$asset->typeID = (int) $item->attributes()->typeID;
			$asset->quantity = (int) $item->attributes()->quantity;
			$asset->flag = (int) $item->attributes()->flag;
			$asset->singleton = (int) $item->attributes()->singleton;
			$asset->containerID = $containerID;
			$asset->locationName = $locationName;
			$asset->typeName = $invType->typeName;
			$asset->groupID = $invType->groupID;
                        try
                        {
                            $asset->save();
                            //echo "Item: {$asset->itemID} {$asset->typeName} Character: {$asset->characterID} Container: {$asset->containerID} <br>";
                        }
                        catch(Exception $e)
                        {
                            //echo "ERROR: Item {$asset->itemID} <br>";
                            //echo "Item: {$asset->itemID} {$asset->typeName} Character: {$asset->characterID} Container: {$asset->containerID} <br>";
                            //$message = $e->getMessage();
                            //echo "Exception: $message <br>";
                        }
			
			if (count($asset->getErrors()) > 0) Yii::log(print_r($asset->getErrors(), true), "warning", "APIAssetList");
			
		}
	}
        
        /*
        public function parseAssetsNew($assetNode, $characterID, $containerID)
        {
            
            //Loop through each row
            foreach ($assetNode)
            {
                //Determine if this asset contains contents
                if ($assetNode->xpath('/row/rowset[@name="contents"]')
                
                //Parse the asset and add it to the database
            }
            
            
        }
	
         * 
         */
	public function getLocationName($locationID)
	{
		$locationName = "Space";
                //echo "Getting Location!\n";
		
		switch ($locationID)
		{		
			case ((66000000 < $locationID) && ($locationID < 66014933)):
				$stationID = $locationID - 6000001;
				$station = StaStations::Model()->findByPk($stationID);
				$locationName = $station->stationName;
				break;
			
			case ((66014934 < $locationID) && ($locationID < 67999999)):
				$stationID = $locationID - 6000000;
				$station = ConqStations::Model()->findByPk($stationID);
				$locationName = $station->stationName;
				break;
				
			case ((60014861 < $locationID) && ($locationID < 60014928)):
				$stationID = $locationID;
				$station = ConqStations::Model()->findByPk($stationID);
				$locationName = $station->stationName;
				break;
				
			case ((60000000 < $locationID) && ($locationID < 61000000)):
				$stationID = $locationID;
				$station = StaStations::Model()->findByPk($stationID);
				$locationName = $station->stationName;
				break;
				
			case ($locationID >= 61000000):
				$stationID = $locationID;
				$station = ConqStations::Model()->findByPk($stationID);
				$locationName = $station->stationName;
				break;
			
			default:
				$map = MapDenormalize::Model()->findByPk($locationID);
				$locationName = $map->itemName;
				break;
		}
		return $locationName;
	}
	
	public function getMembersAsCharIDArray($groupID)
	{
		
		$members = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		foreach ($members as $member)
		{
			$character = Characters::Model()->findByPk($member->characterID);
			$memberArray[] = $character->characterID;
		}
		
		return $memberArray;
	}
}
?>