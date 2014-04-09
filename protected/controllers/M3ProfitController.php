<?php

class m3ProfitController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
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
				'actions'=>array('index'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	//Gets all the character sheets using data in the characters table

	public function getm3Profit()
	{
		$eveDate = $this->getEveTimeSql();
		
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		
		/*$sql = ('SELECT SUM(wallet.quantity) as totalQuantity, SUM(wallet.profit) as totalProfit, wallet.typeName, wallet.typeID, invTypes.volume,  SUM(wallet.profit) / (SUM(wallet.quantity) * invTypes.volume) as profitPerM3
				FROM wallet
				JOIN invTypes ON (wallet.typeID = invTypes.typeID)
				WHERE wallet.transactionDateTime > DATE_SUB(CURDATE(), INTERVAL 90 DAY)
				AND transactionType = "sell"
				AND personal = 0
				AND characterID IN ('.implode(',',$members).')
				GROUP BY wallet.typeID
				ORDER BY profitPerM3 DESC');
		*/


		$sql = ('SELECT SUM(wallet.quantity) as totalQuantity, invTypes.volume, wallet.typeName, wallet.typeID,
			(SUM(wallet.profit) / 100000000) +
			(AVG(wallet.profit) / 100000000) + 
			((SUM(wallet.profit) / SUM(wallet.quantity)) / 40000000) +
			((SUM(wallet.profit) / (SUM(wallet.quantity) * invTypes.volume)) / 1000000) -
			(((SUM(wallet.price) - SUM(wallet.profit)) / SUM(wallet.quantity)) / 500000000) 
			as ticketWeight
			FROM wallet
			JOIN invTypes ON (wallet.typeID = invTypes.typeID)
			WHERE wallet.transactionDateTime > DATE_SUB(CURDATE(), INTERVAL 120 DAY)
			AND wallet.stationID NOT LIKE 60003760
			AND invTypes.groupID NOT LIKE 1044
			AND transactionType = "sell"
			AND personal = 0
			AND characterID IN ('.implode(',',$members).')
			GROUP BY wallet.typeID
			ORDER BY ticketWeight DESC');
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$results=$command->query();

		return $results;

	}
	
}