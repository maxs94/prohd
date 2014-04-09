<?php

class PiController extends Controller
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
	
	public function getMoonDetail()
	{
	$sql = 'SELECT * FROM pi ORDER BY moonID ASC';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$moon[] = array("characterID"=>$row['characterID'], "moonID"=>$row['moonID'],"typeID"=>$row['typeID'],"processorTypeID"=>$row['processorTypeID'],"processorCount"=>$row['processorCount'],"averageOutput"=>$row['averageOutput']);
		}
	return $moon;
	}
	
	public function getName($typeID)
	{
	$sql = 'SELECT typeName FROM invTypes WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['typeName'];
	}
	
	public function getPlanet($itemID)
	{
	$sql = 'SELECT itemName FROM mapDenormalize WHERE itemID = '.$itemID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['itemName'];
	}
	
	public function getCharacter($characterID)
	{
	$sql = 'SELECT characterName FROM characters WHERE characterID = '.$characterID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['characterName'];
	}
	
	public function getSchematic($typeID)
	{
	$sql = 'SELECT schematicID from planetSchematicsTypeMap WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	$schematicID = $itemValue['schematicID'];
		
	$sql = 'SELECT planetSchematicsTypeMap.typeID, planetSchematicsTypeMap.quantity, invTypes.typeName FROM planetSchematicsTypeMap,invTypes WHERE planetSchematicsTypeMap.typeID = invTypes.typeID AND planetSchematicsTypeMap.schematicID = '.$schematicID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$schematicResult = $command->query();
	foreach ($schematicResult as $row)
		{
		$item[] = array("typeID"=>$row['typeID'], "quantity"=>$row['quantity'], "typeName"=>$row['typeName']);
		}
	return $item;
	}
	
	public function getPlanetType($planetID)
	{
	$sql = 'SELECT invTypes.typeName
	FROM invTypes, mapDenormalize
	WHERE invTypes.typeID = mapDenormalize.typeID
	AND mapDenormalize.itemID = '.$planetID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['typeName'];
	}
	
	public function getPlanetIcon($planetID)
	{
	$sql = 'SELECT mapDenormalize.typeID
	FROM invTypes, mapDenormalize
	WHERE invTypes.typeID = mapDenormalize.typeID
	AND mapDenormalize.itemID = '.$planetID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['typeID'];
	}
	
	public function getPlanetaryMaterials()
	{
	$sql = 'SELECT typeID, typeName, volume FROM invTypes WHERE marketGroupID = 1333';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$schematicResult = $command->query();
	foreach ($schematicResult as $row)
		{
		$item[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName'], "volume"=>$row['volume']);
		}
	return $item;
	}
	
	public function getPlanetary2Materials()
	{
	$sql = 'SELECT planetSchematicsTypeMap.*, invTypes.typeName FROM planetSchematicsTypeMap
			JOIN invTypes ON (planetSchematicsTypeMap.typeID = invTypes.typeID)
			WHERE planetSchematicsTypeMap.isInput = 0
			AND invTypes.marketGroupID = 1335
			ORDER BY invTypes.typeName';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$schematicResult = $command->query();
	foreach ($schematicResult as $row)
		{
		$item[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName'], "quantity"=>$row['quantity'], "schematicID"=>$row['schematicID']);
		}
	return $item;
	}
	
	public function getPlanetary3Materials()
	{
	$sql = 'SELECT planetSchematicsTypeMap.*, invTypes.typeName FROM planetSchematicsTypeMap
			JOIN invTypes ON (planetSchematicsTypeMap.typeID = invTypes.typeID)
			WHERE planetSchematicsTypeMap.isInput = 0
			AND invTypes.marketGroupID = 1336
			ORDER BY invTypes.typeName';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$schematicResult = $command->query();
	foreach ($schematicResult as $row)
		{
		$item[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName'], "quantity"=>$row['quantity'], "schematicID"=>$row['schematicID']);
		}
	return $item;
	}
	
	public function harvestingCheck($typeID)
	{
	$sql = 'SELECT moonID FROM pi WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	if ($itemValue != false)
	return "<img src='./images/tick.png' style='height: 12px; width: 12px;'>";
	else
	return "<img src='./images/cross.png' style='height: 12px; width: 12px;''>";
	}
	
	public function assetValue($typeID)
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
	
	public function assetQuantity($typeID)
	{
	$sql = 'SELECT SUM(quantity)
	FROM corpAssets
	WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	
	return $itemValue['SUM(quantity)'];
	}
	
	public function getSchematicInput($schematicID)
	{
	$sql = 'SELECT planetSchematicsTypeMap.*, invTypes.typeName 
	FROM planetSchematicsTypeMap, invTypes
	WHERE planetSchematicsTypeMap.typeID = invTypes.typeID
	AND schematicID = '.$schematicID.'
	AND isInput = 1';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$schematicResult = $command->query();
	foreach ($schematicResult as $row)
		{
		$item[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName'], "quantity"=>$row['quantity'], "schematicID"=>$row['schematicID']);
		}
	return $item;
	}
	
	public function getSchematicProduct($schematicID)
	{
	$sql = 'SELECT planetSchematicsTypeMap.*, invTypes.typeName 
	FROM planetSchematicsTypeMap, invTypes
	WHERE planetSchematicsTypeMap.typeID = invTypes.typeID
	AND schematicID = '.$schematicID.'
	AND isInput = 0';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$schematicResult = $command->query();
	foreach ($schematicResult as $row)
		{
		$item[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName'], "quantity"=>$row['quantity'], "schematicID"=>$row['schematicID']);
		}
	return $item;
	}
	
	public function haveItemInStock($typeID)
	{
	$sql = 'SELECT quantity FROM corpAssets WHERE typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$itemValue = $results->read();
	if ($itemValue != false)
	return "<img src='./images/tick.png' style='height: 12px; width: 12px;'>";
	else
	return "<img src='./images/cross.png' style='height: 12px; width: 12px;'>";
	}
	
	
}