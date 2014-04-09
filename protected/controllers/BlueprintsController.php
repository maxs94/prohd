<?php

class BlueprintsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionIndexajax()
	{
		$this->renderPartial('_indexAjax');
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
				'actions'=>array('index','indexajax'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	// Moved to Invention Controller
	
	/*public function findT2Blueprints($parentTypeID)
	{
	$sql = 'SELECT blueprintTypeID, productTypeID, invTypes.typeName FROM invMetaTypes
	LEFT JOIN invBlueprintTypes ON invBlueprintTypes.productTypeID=invMetaTypes.typeID
	LEFT JOIN invTypes ON invTypes.typeID=invBlueprintTypes.blueprintTypeID
	WHERE parentTypeID='.$parentTypeID.'
	AND metaGroupID=2';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$blueprintIDs[] = array("blueprintTypeID"=>$row['blueprintTypeID'], "typeName"=>$row['typeName'], "typeID"=>$row['productTypeID']);
		}

	return $blueprintIDs;
	}
	
	public function itemNameFromBlueprint($blueprintTypeID)
	{
	$sql = 'SELECT blueprintTypeID, productTypeID, invTypes.typeID, invTypes.typeName
	FROM invBlueprintTypes, invTypes
	WHERE blueprintTypeID = '.$blueprintTypeID.'
	AND productTypeID = invTypes.typeID';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$row = $results->read();
	$itemInfo = array("typeName"=>$row['typeName'], "typeID"=>$row['typeID']);
	
	return $itemInfo;
	}
	*/
	
	public function usageCheck($installedItemID)
	{
		//Grab an industry job for this installedItemID if one exists
		$job = IndustryJobs::Model()->find('installedItemID=:installedItemID AND completed = 0',array(':installedItemID'=>$installedItemID));
		
		if ($job != NULL)
		{
			return "<img src='./images/tick.png' style='height: 12px; width: 12px;'>";
		}
	}
	
}