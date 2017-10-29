<?php
class APIConqStations extends EVEXMLData
{
	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/eve/ConquerableStationList.xml.aspx',
			'cacheID'=>'APIConqStations',
			'primaryID'=>'characterID',
		);
	}
	
	public function storeData()
	{
		$conqStations = $this->getEVEData(0);
		ConqStations::Model()->deleteAll('1=1');
		
		foreach ($conqStations->result->rowset->row as $station)
		{
			$apistation = new ConqStations;
			$apistation->stationID = $station->attributes()->stationID;
			$apistation->stationName = $station->attributes()->stationName;
			$apistation->stationTypeID = $station->attributes()->stationTypeID;
			$apistation->solarSystemID = $station->attributes()->solarSystemID;
			$apistation->corporationID = $station->attributes()->corporationID;
			$apistation->corporationName = $station->attributes()->corporationName;
			$apistation->save();
			
			if (count($apistation->getErrors()) > 0) Yii::log(print_r($apistation->getErrors(), true), "warning", "APIConqStations");
			
		}
	}
}