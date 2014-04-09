<?php

class InventionController extends Controller
{
	public function actionIndex()
	{
		if (!isset($_GET['id']))
		{
			$id = 642;
		}
		else
		{
			$id = $_GET['id'];
		}
		$this->render('index',array('typeID'=>$id));
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
	
	public function blueprintDetail($blueprintTypeID)
	{
	$sql = 'SELECT *
	FROM invBlueprintTypes
	WHERE blueprintTypeID = '.$blueprintTypeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$row = $results->read();
	$itemInfo = array("productTypeID"=>$row['productTypeID'], "productionTime"=>$row['productionTime'], "techLevel"=>$row['techLevel'], "maxProductionLimit"=>$row['maxProductionLimit'], "researchMaterialTime"=>$row['researchMaterialTime'], "researchProductivityTime"=>$row['researchProductivityTime'], "researchCopyTime"=>$row['researchCopyTime']);
	
	return $itemInfo;
	}
	
	public function findT2Blueprints($parentTypeID)
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
	
	
	public function getMaterials($bpTypeID, $typeID, $pe = 0, $me = 0, $peSkill = 5)
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
					'quantity' => round($requirement->quantity * ((1 + ($blueprint->wasteFactor / (1 + $me))) + (.25 - (.05 * $peSkill)))),
				);
			}
			
			return $adjustedRequirements;
	}
	
	public function getT2Materials($bpTypeID)
	{
	$sql = 'SELECT typeBuildReqs.*, invTypes.typeID, invTypes.typeName FROM typeBuildReqs
	JOIN invTypes ON (invTypes.typeID = typeBuildReqs.requiredTypeID)
	WHERE blueprintTypeID = '.$bpTypeID.'
	AND invTypes.groupID NOT IN (268,269,270)
	AND activityID = 1';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	
	return $results;
	}
	
	public function adjustedt2ME($quantity, $wasted)
	{
	$value = $wasted * round($quantity * (10 / 100) * ( 1 - -4 ));
	return $value + $quantity;
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
	
	public function constructionMaterials($typeID)
	{
	$sql = 'SELECT materialTypeID, quantity, invTypes.typeName, invTypes.typeID
	FROM invTypeMaterials, invTypes
	WHERE materialTypeID = invTypes.typeID
	AND invTypeMaterials.typeID = '.$typeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$materials[] = array("quantity"=>$row['quantity'], "materialTypeID"=>$row['materialTypeID'], "typeName"=>$row['typeName']);
		}
	return $materials;
	}
	
	public function constructionMaterialsCount($bpTypeID,$materialTypeID)
	{
	$sql = 'SELECT blueprintTypeID, requiredTypeID, quantity
	FROM typeBuildReqs
	WHERE blueprintTypeID = '.$bpTypeID.'
	AND activityID = 1';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();

	return $materials['quantity'];
	}
	
	public function getAdvancedMaterials()
	{
	$sql = 'SELECT typeID, typeName
	FROM invTypes
	WHERE groupID = 429';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$materials[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName']);
		}
	return $materials;
	}
	
	public function getCompositeMaterials()
	{
	$sql = 'SELECT typeID, typeName
	FROM invTypes
	WHERE groupID = 334';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	foreach ($results as $row)
		{
		$materials[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName']);
		}
	return $materials;
	}
	
	public function getProduct($bpTypeID)
	{
	$sql = 'SELECT productTypeID
	FROM invBlueprintTypes
	WHERE blueprintTypeID = '.$bpTypeID.'';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$product = $results->read();
	return $product['productTypeID'];
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
	
	public function getCompositeMaterialsTotal($bp)
	{
	$sql = 'SELECT typeBuildReqs.blueprintTypeID, typeBuildReqs.requiredTypeID, SUM((invTypeMaterials.quantity * typeBuildReqs.quantity) * 1.10) AS totalQuantity, invTypeMaterials.materialTypeId, materials.typeName
	FROM typeBuildReqs
	JOIN invTypes ON (invTypes.typeID = typeBuildReqs.requiredTypeID)
	JOIN invTypeMaterials ON (invTypes.typeID = invTypeMaterials.typeID)
	JOIN invTypes AS materials ON (materials.typeID = invTypeMaterials.materialTypeId)
	WHERE typeBuildReqs.blueprintTypeID = '.$bp.'
	AND activityID = 1
	AND invTypes.groupID = 334
	GROUP BY invTypeMaterials.materialTypeID';
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	$results = $command->query();
		foreach ($results as $row)
		{
		$materials[] = array("typeID"=>$row['materialTypeId'], "typeName"=>$row['typeName'], "quantity"=>$row['totalQuantity']);
		}
	return $materials;
	}
	
	public function getT2ShipParents()
	{
		$sql = 'SELECT parentInvType.typeID, parentInvType.typeName from invTypes
		JOIN invMetaTypes ON (invTypes.typeID = invMetaTypes.typeID)
		JOIN invGroups ON (invTypes.groupID = invGroups.groupID)
		JOIN invTypes AS parentInvType ON (parentInvType.typeID = invMetaTypes.parentTypeID)
		WHERE invGroups.categoryID = 18
		AND invMetaTypes.metaGroupID = 2
		GROUP BY parentInvType.typeID
		ORDER BY parentInvType.typeName ASC';
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
				
		$results = $command->query();
		foreach ($results as $row)
		{
			$ships[] = array("typeID"=>$row['typeID'], "typeName"=>$row['typeName']);
		}
		return $ships;
	}
}