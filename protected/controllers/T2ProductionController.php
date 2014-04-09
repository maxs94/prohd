<?php

class T2ProductionController extends Controller
{
	public function actionIndex()
	{
		$groupMembersArray = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
		$groupMembersString = "(".implode(",",$groupMembersArray).")";
		
		//Get a list of T2 BPs
		$sql = "SELECT assets.itemID, assets.typeID, assets.typeName, invBlueprintTypes.maxProductionLimit FROM invBlueprintTypes
				JOIN assets ON (assets.typeID = invBlueprintTypes.blueprintTypeID)
				WHERE (invBlueprintTypes.techLevel = 2) AND characterID IN ".$groupMembersString."
				ORDER BY assets.typeName";
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
			
		//Run the query
		$results = $command->query();
		
		$this->render('index',array('bps'=>$results));
	}
	
	public function actionResults()
	{
		$typeIDs = explode(',',$_POST['typeID']);
		$runs = explode(',',$_POST['runs']);
		
		$i = 0;
		
		foreach ($typeIDs as $typeID)
		{
			$sql = "SELECT typeBuildReqs.*, invTypes.typeName, invGroups.categoryID, invTypes.groupID, 
					invBlueprintTypes.wasteFactor, typeBuildReqs.wasted, {$runs[$i]} as runs, typeBuildReqs.damagePerJob
					FROM typeBuildReqs
					JOIN invTypes ON (typeBuildReqs.requiredTypeID = invTypes.typeID)
					JOIN invGroups ON (invTypes.groupID = invGroups.groupID)
					JOIN invBlueprintTypes ON (typeBuildReqs.blueprintTypeID = invBlueprintTypes.blueprintTypeID)
					WHERE typeBuildReqs.blueprintTypeID = {$typeID}
					AND activityID = 1";
					
			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
				
			//Run the query
			$results[] = $command->query();
			
			$i++;
		}
		
		$this->renderPartial('results',array('results'=>$results));
	}
	
	public function lastJitaPrice($typeID)
	{
            $value = AssetValues::model()->find('typeID=:typeID AND lastUpdated > DATE_SUB(CURDATE(), INTERVAL 1 day)',array(':typeID'=>$typeID));
            
            if ($value == null)
            {
                return $this->storeSingleAssetValue($typeID);
            }
            else
            {
                return $value->value;
            }
	}
	
	public function getStock($typeID)
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
	
		$sql = ("SELECT quantity AS items
					FROM assets
					WHERE typeID = $typeID AND locationID = 60006619");
				
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
}