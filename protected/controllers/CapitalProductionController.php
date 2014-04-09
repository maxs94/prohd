<?php

class CapitalProductionController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionIndexajax()
	{
		$this->renderPartial('_indexAjax');
	}

	public function actionGetbpcme()
	{
		$cacheKey = "BPCMECache" . Yii::app()->user->trackingGroupID;
		$results = Yii::app()->cache->get($cacheKey);
		if ($results == false)
		{
			$results = 0;
		}
		
		$this->renderPartial('_ajax',array('results'=>$results));
	}
	
	public function actionSubmitbpcme()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{	
			$cacheKey = "BPCMECache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
	
	public function actionGetcharpe()
	{
		$cacheKey = "charPECache" . Yii::app()->user->trackingGroupID;
		$results = Yii::app()->cache->get($cacheKey);
		if ($results == false)
		{
			$results = 0;
		}
		
		$this->renderPartial('_ajax',array('results'=>$results));
	}
	
	public function actionSubmitcharpe()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{
			if ($_POST['input'] > 5)
				$_POST['input'] = 5;
				
			$cacheKey = "charPECache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
		
	public function actionGetcapitals()
	{
		$invTypes = Invtypes::Model()->findAll('groupID IN (513,547,485,659,883,941)');
		
		foreach($invTypes as $row)
		{
			$listArray[] = array('val'=>$row->typeID,'display'=>$row->typeName);
		}
		
		$json = json_encode($listArray);
		$this->renderPartial('_ajax',array('results'=>$json));

	}
	
	public function actionSubmitcapital()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{		
			$cacheKey = "capitalCache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
	
	public function actionGetcurrentcap()
	{
		$cacheKey = "capitalCache" . Yii::app()->user->trackingGroupID;
		$typeID = Yii::app()->cache->get($cacheKey);
		$invType = Invtypes::Model()->findByPk($typeID);
		$results[] = array('val'=>$invType->typeID,'display'=>$invType->typeName);
		if ($results == false)
		{
			$results = 0;
		}
		$this->renderPartial('_ajax',array('results'=>json_encode($results)));
	}
	
	public function actionGetcharacters()
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		$characters = Characters::Model()->findAll('walletID IN '.$sqlarray.'',array(':accountID'=>$userid));
		
		foreach($characters as $character)
		{
			$charArray[] = array('val'=>$character->characterID,'display'=>$character->characterName);
		}
		
		$this->renderPartial('_ajax',array('results'=>json_encode($charArray)));
	}
	
	public function actionGetcurrentcharacter()
	{
		$cacheKey = "characterIDCache" . Yii::app()->user->trackingGroupID;
		$charID = Yii::app()->cache->get($cacheKey);
		
		$character = Characters::Model()->find('characterID=:characterID',array(':characterID'=>$charID));
		$results[] = array('val'=>$character->characterID,'display'=>$character->characterName);
		if ($results == false)
		{
			$results = 0;
		}
		
		$this->renderPartial('_ajax',array('results'=>json_encode($results)));
	}
	
	public function actionSubmitcharacter()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{		
			$cacheKey = "characterIDCache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
	
	public function actionGetpricesell()
	{
		$results = $this->phdGetCache("priceSellCache");
		if ($results == false)
		{
			$results = 0;
		}
		else
		{
			$results = number_format($results,0);
		}
		$this->renderPartial('_ajax',array('results'=>$results));
	}
	
	public function actionGetpricebpc()
	{
		$results = $this->phdGetCache("priceBPCCache");
		if ($results == false)
		{
			$results = 0;
		}
		else
		{
			$results = number_format($results,0);
		}
		$this->renderPartial('_ajax',array('results'=>$results));
	}
	
	public function actionGetpricecapitalparts()
	{
		$results = $this->phdGetCache("priceCapitalPartsCache");
		if ($results == false)
		{
			$results = 0;
		}
		else
		{
			$results = number_format($results,0);
		}
		$this->renderPartial('_ajax',array('results'=>$results));
	}
	
	public function actionGetpriceslot()
	{
		$results = $this->phdGetCache("priceSlotCache");
		if ($results == false)
		{
			$results = 0;
		}
		else
		{
			$results = number_format($results,0);
		}
		$this->renderPartial('_ajax',array('results'=>$results));
	}
	
	public function actionSubmitpricesell()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{	
			$cacheKey = "priceSellCache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
	
	public function actionSubmitpricebpc()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{	
			$cacheKey = "priceBPCCache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
	
	public function actionSubmitpricecapitalparts()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{	
			$cacheKey = "priceCapitalPartsCache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
	}
	
	public function actionSubmitpriceslot()
	{
		if( (isset($_POST['input'])) && (is_numeric($_POST['input'])) )
		{	
			$cacheKey = "priceSlotCache" . Yii::app()->user->trackingGroupID;
			Yii::app()->cache->set($cacheKey, $_POST['input']);
		
			$this->renderPartial('_ajax',array('results'=>$bpcMELevel));
		}
		else
		{
			throw new CHttpException(400,'Field must be numeric.');
		}
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
				'actions'=>array('index', 'getbpcme', 'submitbpcme', 'getcharpe', 'submitcharpe', 'getcurrentcharacter',
				'getcapitals', 'submitcapital', 'getcurrentcap', 'getcharacters', 'submitcharacter', 'getpricesell', 'getpricebpc', 'getpricecapitalparts', 'getpriceslot',
				'submitpricesell', 'submitpricebpc', 'submitpricecapitalparts', 'submitpriceslot'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	//
	public function getComponentCount($typeID, $stationID)
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
	
		$sql = ("SELECT SUM(quantity) AS totalitems
					FROM assets
					WHERE typeID = $typeID AND locationID = $stationID
					GROUP BY typeID");
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);		
		$results=$command->query();
		
		$total = $results->readAll();
		
		if (empty($total))
		{
			return 0;
		}
		else
		{
			return $total[0]['totalitems'];
		}
	}
	
		public function getIndustryCount($typeID, $stationID)
		{
			//Get our current group characters
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		
			$sql = ("SELECT SUM(runs) AS totalitems
						FROM industryJobs
						WHERE outputTypeID = $typeID AND completed = 0 AND outputLocationID = $stationID
						GROUP BY outputTypeID");
					
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);		
			$results=$command->query();
			
			$total = $results->readAll();
			
			if (empty($total))
			{
				return 0;
			}
			else
			{
				return $total[0]['totalitems'];
			}
		}
		
		public function getMaterials($typeID, $bpTypeID, $pe = 0, $me = 0, $peSkill = 5)
		{
			//Get the blueprint details
			$blueprint = InvBlueprintTypes::Model()->findByPk($bpTypeID);
			
			//Get the invType material base requirements
			$requirements = InvTypeMaterials::Model()->findAll('typeID=:typeID',array(':typeID'=>$typeID));
			
			//Loop through each mineral or part
			foreach ($requirements as $requirement)
			{
				//Get the invType details for each material
				$invType = Invtypes::Model()->findByPk($requirement->materialTypeID);
			
				$adjustedRequirements[] = array(
					'typeName' => $invType->typeName,
					'typeID' => $requirement->materialTypeID,
					'quantity' => round($requirement->quantity * ((1 + (($blueprint->wasteFactor / 100) / (1 + $me))) + (.25 - (.05 * $peSkill)))),
				);
			}
			
			return $adjustedRequirements;
		}
		
		public function getMineralRequirements($getMaterialsArray)
		{
			foreach ($getMaterialsArray as $part)
			{
				//Get the invType material base requirements
				$requirements = InvTypeMaterials::Model()->findAll('typeID=:typeID',array(':typeID'=>$part['typeID']));
				
				foreach ($requirements as $requirement)
				{
					//Get the invType details for each material
					$invType = Invtypes::Model()->findByPk($requirement->materialTypeID);
					$mineralName = $invType->typeName;
					
					$minerals[$mineralName]['typeID'] = $requirement->materialTypeID;
					$minerals[$mineralName]['quantity'] += ($requirement->quantity * ($part['quantity'] - $this->getComponentCount($part['typeID'],60014922)));
				}
			}
			return $minerals;
		}
		
		public function getTotalMineralRequirements($getMaterialsArray)
		{
			foreach ($getMaterialsArray as $part)
			{
				//Get the invType material base requirements
				$requirements = InvTypeMaterials::Model()->findAll('typeID=:typeID',array(':typeID'=>$part['typeID']));
				
				foreach ($requirements as $requirement)
				{
					//Get the invType details for each material
					$invType = Invtypes::Model()->findByPk($requirement->materialTypeID);
					$mineralName = $invType->typeName;
					
					$minerals[$mineralName]['typeID'] = $requirement->materialTypeID;
					$minerals[$mineralName]['quantity'] += ($requirement->quantity * $part['quantity']);
				}
			}
			return $minerals;
		}
		
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
		
		public function getStock($typeID,$stationID)
		{
			//Get our current group characters
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		
			$sql = ("SELECT itemID AS items
						FROM assets
						WHERE typeID = $typeID AND locationID = $stationID");
					
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);		
			$results=$command->query();
			
			$total = $results->readAll();
			
			if (empty($total))
			{
				return 0;
			}
			else
			{
				return $total[0]['items'];
			}
		}
		
		public function getSkillLevel($characterID, $skillTypeID)
		{
			//Get the character information
			$character = Characters::Model()->find('characterID = :characterID',array(':characterID'=>$characterID));
			
			//Get the skill sheet
			$characterAPIInterface = new APICharacterSheet;
			$characterSkillSheet = $characterAPIInterface->getEVEData($character->walletID);
			
			//Grab the specific skill data
			$skill = $characterSkillSheet->xpath("//rowset[@name='skills']/row[@typeID='".$skillTypeID."']");
			
			if (!(is_object($skill[0])))
			{
				return 0;
			}
			else
			{
				return $skill[0]->attributes()->level;
			}
		}
		
}