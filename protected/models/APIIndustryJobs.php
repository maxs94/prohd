<?php
class APIIndustryJobs extends EVEXMLData
{
	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/char/IndustryJobs.xml.aspx',
			'cacheID'=>'APIIndustryJobs',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
			'storageTable'=>'industryJobs',
		);
	}
	public function storeData($walletID)
	{
		$attributes = $this->apiAttributes();	
		//Retrieve the XML dataset
		$industryJobs = $this->getEVEData($walletID);	
		$character = Characters::Model()->findByPk($walletID);
		if(!(isset($industryJobs->error)))
		{
			foreach ($industryJobs->result->rowset->row as $row)
			{		
				$exist = IndustryJobs::Model()->exists('jobID=:jobID',array(':jobID'=>$row->attributes()->jobID));								// If this job doesn't exist yet, create a new one and populate it
				if (!$exist)
				{
						$jobRow = new IndustryJobs;
						$jobRow->jobID = $row->attributes()->jobID;
						$jobRow->assemblyLineID = $row->attributes()->assemblyLineID;
						$jobRow->containerID = $row->attributes()->containerID;
						$jobRow->installedItemID = $row->attributes()->installedItemID;
						$jobRow->installedItemLocationID = $row->attributes()->installedItemLocationID;
						$jobRow->installedItemQuantity = $row->attributes()->installedItemQuantity;
						$jobRow->installedItemProductivityLevel = $row->attributes()->installedItemProductivityLevel;
						$jobRow->installedItemMaterialLevel = $row->attributes()->installedItemMaterialLevel;
						$jobRow->installedItemLicensedProductionRunsRemaining = $row->attributes()->installedItemLicensedProductionRunsRemaining;
						$jobRow->outputLocationID = $row->attributes()->outputLocationID;
						$jobRow->installerID = $row->attributes()->installerID;						$jobRow->runs = $row->attributes()->runs;						$jobRow->licensedProductionRuns = $row->attributes()->licensedProductionRuns;						$jobRow->installedInSolarSystemID = $row->attributes()->	installedInSolarSystemID;						$jobRow->containerLocationID = $row->attributes()->containerLocationID;						$jobRow->materialMultiplier = $row->attributes()->materialMultiplier;						$jobRow->charMaterialMultiplier = $row->attributes()->charMaterialMultiplier;						$jobRow->timeMultiplier = $row->attributes()->timeMultiplier;						$jobRow->charTimeMultiplier = $row->attributes()->charTimeMultiplier;						$jobRow->installedItemTypeID = $row->attributes()->installedItemTypeID;						$jobRow->outputTypeID = $row->attributes()->outputTypeID;						$jobRow->containerTypeID = $row->attributes()->containerTypeID;						$jobRow->installedItemCopy = $row->attributes()->installedItemCopy;						$jobRow->completed = $row->attributes()->completed;						$jobRow->completedSuccessfully = $row->attributes()->completedSuccessfully;						$jobRow->installedItemFlag = $row->attributes()->installedItemFlag;						$jobRow->activityID = $row->attributes()->activityID;						$jobRow->completedStatus = $row->attributes()->completedStatus;						$jobRow->installTime = $row->attributes()->installTime;						$jobRow->outputFlag = $row->attributes()->outputFlag;						$jobRow->beginProductionTime = $row->attributes()->beginProductionTime;						$jobRow->endProductionTime = $row->attributes()->endProductionTime;						$jobRow->pauseProductionTime = $row->attributes()->pauseProductionTime;				
						$jobRow->save();						// print_r ($jobRow->getErrors());
				}				else				{						// Retrieve the job						$jobRow = IndustryJobs::Model()->findByPk($row->attributes()->jobID);												// Do we need to move this job to assets?						if (($jobRow->completed == 0) && ($row->attributes()->completed == 1))						{							//Get the typeID details							$typeID = Invtypes::Model()->findByPk($row->attributes()->outputTypeID);														//Create a new asset							$asset = new Assets;							$asset->characterID = $character->characterID;							$asset->locationID = $row->attributes()->installedItemLocationID;							$asset->typeID = $row->attributes()->outputTypeID;							$asset->quantity = $row->attributes()->runs;							$asset->flag = 4;							$asset->singleton = 0;							$asset->containerID = 0;							$asset->locationName = $this->getLocationName($row->attributes()->installedItemLocationID);							$asset->typeName = $typeID->typeName;							$asset->groupID = $typeID->groupID;							$asset->save();						}												// Update the job row with the new data from CCP						$jobRow->jobID = $row->attributes()->jobID;						$jobRow->assemblyLineID = $row->attributes()->assemblyLineID;						$jobRow->containerID = $row->attributes()->containerID;						$jobRow->installedItemID = $row->attributes()->installedItemID;						$jobRow->installedItemLocationID = $row->attributes()->installedItemLocationID;						$jobRow->installedItemQuantity = $row->attributes()->installedItemQuantity;						$jobRow->installedItemProductivityLevel = $row->attributes()->installedItemProductivityLevel;						$jobRow->installedItemMaterialLevel = $row->attributes()->installedItemMaterialLevel;						$jobRow->installedItemLicensedProductionRunsRemaining = $row->attributes()->installedItemLicensedProductionRunsRemaining;						$jobRow->outputLocationID = $row->attributes()->outputLocationID;						$jobRow->installerID = $row->attributes()->installerID;						$jobRow->runs = $row->attributes()->runs;						$jobRow->licensedProductionRuns = $row->attributes()->licensedProductionRuns;						$jobRow->installedInSolarSystemID = $row->attributes()->	installedInSolarSystemID;						$jobRow->containerLocationID = $row->attributes()->containerLocationID;						$jobRow->materialMultiplier = $row->attributes()->materialMultiplier;						$jobRow->charMaterialMultiplier = $row->attributes()->charMaterialMultiplier;						$jobRow->timeMultiplier = $row->attributes()->timeMultiplier;						$jobRow->charTimeMultiplier = $row->attributes()->charTimeMultiplier;						$jobRow->installedItemTypeID = $row->attributes()->installedItemTypeID;						$jobRow->outputTypeID = $row->attributes()->outputTypeID;						$jobRow->containerTypeID = $row->attributes()->containerTypeID;						$jobRow->installedItemCopy = $row->attributes()->installedItemCopy;						$jobRow->completed = $row->attributes()->completed;						$jobRow->completedSuccessfully = $row->attributes()->completedSuccessfully;						$jobRow->installedItemFlag = $row->attributes()->installedItemFlag;						$jobRow->activityID = $row->attributes()->activityID;						$jobRow->completedStatus = $row->attributes()->completedStatus;						$jobRow->installTime = $row->attributes()->installTime;						$jobRow->outputFlag = $row->attributes()->outputFlag;						$jobRow->beginProductionTime = $row->attributes()->beginProductionTime;						$jobRow->endProductionTime = $row->attributes()->endProductionTime;						$jobRow->pauseProductionTime = $row->attributes()->pauseProductionTime;										$jobRow->save();				}
			}
		}
	}	
	public function getMembersAsArray($groupID)
	{
		$members = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		foreach ($members as $member)
		{
			$memberArray[] = $member->characterID;
		}
		
		return $memberArray;
	}		public function getLocationName($locationID)	{		$locationName = "Space";				switch ($locationID)		{					case ((66000000 < $locationID) && ($locationID < 66014933)):				$stationID = $locationID - 6000001;				$station = StaStations::Model()->findByPk($stationID);				$locationName = $station->stationName;				break;						case ((66014934 < $locationID) && ($locationID < 67999999)):				$stationID = $locationID - 6000000;				$station = ConqStations::Model()->findByPk($stationID);				$locationName = $station->stationName;				break;							case ((60014861 < $locationID) && ($locationID < 60014928)):				$stationID = $locationID;				$station = ConqStations::Model()->findByPk($stationID);				$locationName = $station->stationName;				break;							case ((60000000 < $locationID) && ($locationID < 61000000)):				$stationID = $locationID;				$station = StaStations::Model()->findByPk($stationID);				$locationName = $station->stationName;				break;							case ($locationID >= 61000000):				$stationID = $locationID;				$station = ConqStations::Model()->findByPk($stationID);				$locationName = $station->stationName;				break;						default:				$map = MapDenormalize::Model()->findByPk($locationID);				$locationName = $map->itemName;				break;		}		return $locationName;	}
}
?>