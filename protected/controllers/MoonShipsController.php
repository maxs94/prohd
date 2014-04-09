<?php

class MoonShipsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function getShipList()
	{
	//Get a list of Ships
		
		$sql = "SELECT invTypes.typeID, invTypes.typeName, invTypes.marketGroupID
				FROM invTypes
				JOIN (invMarketGroups as a, invMarketGroups as b, invMarketGroups as c, invMarketGroups as d, invMarketGroups as e)
				ON (invTypes.marketGroupID = a.marketGroupID
					AND a.parentGroupID = b.marketGroupID
					AND b.parentGroupID = c.marketGroupID
					AND c.parentGroupID = d.marketGroupID
					AND d.parentGroupID = e.marketGroupID)
				WHERE (d.marketGroupID = 4 OR e.marketGroupID = 4)";
		
		
		#$sql = "SELECT corpAssets.itemID, corpAssets.typeID, corpAssets.typeName, invBlueprintTypes.maxProductionLimit FROM invBlueprintTypes
		#		JOIN corpAssets ON (corpAssets.typeID = invBlueprintTypes.blueprintTypeID)
		#		WHERE (invBlueprintTypes.techLevel = 2)
		#		ORDER BY corpAssets.typeName";
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
			
		//Run the query
		$results = $command->query();
		return $results;
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