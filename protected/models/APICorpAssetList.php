<?php
class APICorpAssetList extends EVEXMLData
{
	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/corp/AssetList.xml.aspx',
			'cacheID'=>'APICorpAssetList',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
		);
	}
	
	public function storeData($walletID)
	{
		$assets = $this->getEVEData($walletID);
		
		$character = Characters::model()->findByPk($walletID);
		
		CorpAssets::Model()->deleteAll('characterID=:characterID',array(':characterID'=>$character->characterID));
		
		$this->parseAssets($assets->result->rowset->row,$character->characterID,0);
	}
	
	public function parseAssets($rowset,$characterID,$containerID)
	{
		foreach ($rowset as $item)
		{
			if (($item->count()) > 0)
			{
				$this->parseAssets($item->rowset->row,$characterID,$item->attributes()->itemID);
			}
			if (isset($item->attributes()->locationID))
			{
				$locationName = $this->getLocationName($item->attributes()->locationID);
			}
			$invType = Invtypes::Model()->findByPk($item->attributes()->typeID);
			
			$asset = new CorpAssets;
			$asset->characterID = $characterID;
			$asset->itemID = $item->attributes()->itemID;
			$asset->locationID = $item->attributes()->locationID;
			$asset->typeID = $item->attributes()->typeID;
			$asset->quantity = $item->attributes()->quantity;
			$asset->flag = $item->attributes()->flag;
			$asset->singleton = $item->attributes()->singleton;
			$asset->containerID = $containerID;
			$asset->locationName = $locationName;
			$asset->typeName = $invType->typeName;
			$asset->groupID = $invType->groupID;
                        try
                        {
                            $asset->save();
                        }
                        catch (Exception $e)
                        {
                            $e->getMessage();
                        }
						
			if (count($asset->getErrors()) > 0) Yii::log(print_r($asset->getErrors(), true), "warning", "APICorpAssetList");
		}
	}
	
	public function getLocationName($locationID)
	{
		$locationName = "Space";
		
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