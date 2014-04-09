<?php

class WalletController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','admin','delete','create','update','item','station','personal','updateajax','search'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdateajax()
	{
		$this->renderPartial('_updateAjax');
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionSearch($term)
	{
	
		$criteria = new CDbCriteria;
		$criteria->condition = 'typeName = :searchString';
		$criteria->params = array(':searchString'=>$term);

		$results = Invtypes::Model()->find($criteria);
		if (empty($results))
		{
			$criteria = new CDbCriteria;
			$criteria->condition = 'typeName like :searchString';
			$criteria->params = array(':searchString'=>'%'.$term.'%');
			$criteria->limit = 10;
			
			$results = Invtypes::Model()->findAll($criteria);
			foreach ($results as $row)
			{
				$resultArray[] = array('id'=>$row->typeID,'value'=>$row->typeName);
			}
		}
		else
		{
			$resultArray[] = array('id'=>$results->typeID,'value'=>$results->typeName);
		}
		
		$this->renderPartial('_ac',array(
			'result'=>json_encode($resultArray)
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Wallet;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wallet']))
		{
			$model->attributes=$_POST['Wallet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->transactionID));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wallet']))
		{
			$model->attributes=$_POST['Wallet'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->transactionID));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

			
		//create a criteria to display by date order
		$criteria=new CDbCriteria;
		$criteria->condition = 'characterID IN '.$sqlarray;
        $criteria->order = 'transactionDateTime DESC';
    
		$dataProvider=new CActiveDataProvider('Wallet', array(
        'pagination'=>array(
            'pageSize'=>25,
        ),
        'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionItem($id)
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		//Fetch the sales of the item
		$criteria1 = new CDbCriteria;
		$criteria1->condition = 'typeID=:typeID AND transactionType = "sell" AND characterID IN '.$sqlarray.'';
		$criteria1->params = array(':typeID'=>$id);
		$criteria1->order = 'transactionDateTime DESC';
		
		//Grab the sales as a data provider
		$salesTransactions = new CActiveDataProvider('Wallet', array(
        'pagination'=>array(
            'pageSize'=>5,
        ),
        'criteria'=>$criteria1,
		));
		
		//Change to purchases
		$criteria2 = new CDbCriteria;
		$criteria2->condition = 'typeID=:typeID AND transactionType = "buy" AND characterID IN '.$sqlarray.'';
		$criteria2->params = array(':typeID'=>$id);
		$criteria2->order = 'transactionDateTime DESC';
		
		//Grab the purchases as a data provider
		$purchaseTransactions = new CActiveDataProvider('Wallet', array(
        'pagination'=>array(
            'pageSize'=>5,
        ),
        'criteria'=>$criteria2,
		));
		
		//Load the item details
		$item = Invtypes::Model()->findByPk($id);
		
		//Render the item view and pass along both data sets and item details
		$this->render('item',array(
			'salesTransactions'=>$salesTransactions,
			'purchaseTransactions'=>$purchaseTransactions,
			'item'=>$item,
		));
		
		
	}
	
	public function actionStation($id)
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		//Fetch the sales of the item
		$criteria = new CDbCriteria;
		$criteria->condition = 'stationID=:stationID AND characterID IN '.$sqlarray.'';
		$criteria->params = array(':stationID'=>$id);
		$criteria->order = 'transactionDateTime DESC';
		
		//Grab the transactions as a data provider
		$stationTransactions = new CActiveDataProvider('Wallet', array(
        'pagination'=>array(
            'pageSize'=>30,
        ),
        'criteria'=>$criteria,
		));
		
		//Load the station details
		$statCriteria = new CDbCriteria;
		$statCriteria->condition = 'stationID=:stationID';
		$statCriteria->params = array(':stationID'=>$id);
		$statCriteria->order = 'transactionDateTime DESC';
		
		$station = Wallet::Model()->find($statCriteria);
		
		//Render the item view and pass along the data set and station details
		$this->render('station',array(
			'stationTransactions'=>$stationTransactions,
			'station'=>$station,
		));
		
		
	}
	
	public function actionPersonal($page,$id)
	{
		//Fetch the sale
		$criteria = new CDbCriteria;
		$criteria->condition = 'transactionID=:transactionID';
		$criteria->params = array(':transactionID'=>$id);

		$transaction = Wallet::Model()->find($criteria);
		$stock = Inventory::Model()->findByPk($id);
		
		if ($transaction->personal)
		{
			$transaction->personal = 0;
			$transaction->save();
			if ($stock != NULL)
			{
				$stock->personal = 0;
				$stock->save();
			}
		}
		else
		{
			$transaction->personal = 1;
			$transaction->save();
			if ($stock != NULL)
			{
				$stock->personal = 1;
				$stock->save();
			}
		}
		
		$this->redirect("index.php?r=wallet/index&Wallet_page=$page");
	}
		
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Wallet('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Wallet']))
			$model->attributes=$_GET['Wallet'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Wallet::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='wallet-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function lastJitaPrice($typeID)
	{
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		//Get the last Jita buy price
		$criteria = new CDbCriteria;
		$criteria->condition = ('typeID=:typeID AND (characterID IN '.$sqlarray.') AND stationID = 60003760 AND transactionType = "buy"');
		$criteria->params = array(':typeID'=>$typeID);
		$criteria->order = 'transactionDateTime DESC';
		
		//Run the query
		$lastJita = Wallet::Model()->find($criteria);
		
		return $lastJita->price;
	}
	
	public function lastNullPrice($typeID)
	{
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
			$sqlarray = '('.implode(',',$members).')';
			
			//Get the last Null sell price
			$criteria = new CDbCriteria;
			$criteria->condition = ('typeID=:typeID AND (characterID IN '.$sqlarray.') AND transactionType = "sell"');
			$criteria->params = array(':typeID'=>$typeID);
			$criteria->order = 'transactionDateTime DESC';
			
			//Run the query
			$lastNull = Wallet::Model()->find($criteria);
			
			return $lastNull->price;
	}
	
	public function getSalesDataByStation($stationID, $numDays)
	{
		//Get all sales for the station
		$criteria = new CDbCriteria;
		$criteria->condition = 'stationID=:stationID AND transactionType = "sell" AND transactionDateTime > (DATE_SUB(CURDATE(), INTERVAL :numDays DAY))';
		$criteria->params = array(':stationID'=>$stationID,':numDays'=>$numDays);
		
		//Fetch the data
		$salesData = Wallet::Model()->findAll($criteria);
		
		//Compile the sales totals against estimated cost
		foreach ($salesData as $sale)
		{
			//Add all sales
			$runningTotal = $runningTotal + ($sale->price * $sale->quantity);
			
			//Subtract all purchases
			$runningTotal = $runningTotal - ($this->lastJitaPrice($sale->typeID) * $sale->quantity);
		}
	
		return $runningTotal;
		
	}
		
	public function getMetaOverlay($typeID)
	{
	
		//Find our item's tech level
		$criteria = new CDbCriteria;
		$criteria->condition = 'typeID=:typeID AND attributeID = 422';
		$criteria->params = array(':typeID'=>$typeID);
		
		$techLevel = DgmTypeAttributes::Model()->find($criteria);
		
		if (($techLevel->valueInt == 3) || ($techLevel->valueFloat == 3))
			return "icon73_243.png";
		
		if (($techLevel->valueInt == 2) || ($techLevel->valueFloat == 2))
			return "icon73_242.png";
			
		if (($techLevel->valueInt == 1) || ($techLevel->valueFloat == 1))
		{
		
			$criteria->condition = 'typeID=:typeID AND attributeID = 1692';
			$criteria->params = array(':typeID'=>$typeID);
			
			$metaGroup = DgmTypeAttributes::Model()->find($criteria);
			
			if (($metaGroup->valueInt == 3) || ($metaGroup->valueFloat == 3))
				return "icon73_245.png";
				
			if (($metaGroup->valueInt == 4) || ($metaGroup->valueFloat == 4))
				return "icon73_246.png";
				
			if (($metaGroup->valueInt == 5) || ($metaGroup->valueFloat == 5))
				return "icon73_248.png";
				
			if ($metaGroup->valueInt == 6)
				return "icon73_247.png";
				
		}
		
		return 0;
		
	}
	
	public function getItemHistoricalData($typeID, $sell='sell')
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		$criteria = new CdbCriteria;
		$criteria->condition = 'typeID=:typeID AND transactionType = :sell AND personal = 0 AND characterID IN '.$sqlarray.'';
		$criteria->params = array(':typeID'=>$typeID, ':sell'=>$sell);
		$criteria->order = 'transactionDateTime';
		
		$history = Wallet::Model()->findAll($criteria);
		$graphArray = '[';
		foreach ($history as $transaction)
		{
			$date = (strtotime($transaction->transactionDateTime) - (5*60*60)) * 1000;
			$graphArray = $graphArray . '['.$date.','.$transaction->price.'],';
		}
		$graphArray = $graphArray . ']';
		return $graphArray;
	}
	
	public function getItemAvgData($typeID, $sell='sell')
	{
		//Grab the characters from the db
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		$criteria = new CdbCriteria;
		$criteria->condition = 'typeID=:typeID AND transactionType = :sell AND personal = 0 AND characterID IN '.$sqlarray.'';
		$criteria->params = array(':typeID'=>$typeID, ':sell'=>$sell);
		$criteria->order = 'transactionDateTime';
		
		$history = Wallet::Model()->findAll($criteria);

		foreach ($history as $transaction)
		{
			$date = (strtotime($transaction->transactionDateTime) - (5*60*60)) * 1000;
			$graphArray[] = array($date,$transaction->price);
		}
		return $graphArray;
	}
	
	public function calcMovingAverage($profitArray,$days)
	{
		foreach ($profitArray as $row)
		{
			if ((count($fiveDays)) < ($days - 1))
			{
				$fiveDays[] = $row[1];
			}
			else
			{
				$fiveDays[] = $row[1];
				$total = 0;
				foreach ($fiveDays as $day)
				{
					$total = $total + $day;
				}
				$average = $total / $days;
				$fiveDayArray[] = array($row[0],$average);
				array_shift($fiveDays);
			}
		}
		return $fiveDayArray;
	}
	
	public function soldTotal($typeID)
	{
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
			$sqlarray = '('.implode(',',$members).')';
		
			// Count number of items sold in null
			$sql = ("SELECT SUM(quantity) FROM wallet WHERE typeID = $typeID AND transactionType = 'sell' AND characterID IN $sqlarray");
					
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
				return $total[0]['SUM(quantity)'];
			}
	
	}
	
	public function profitTotal($typeID)
	{
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
			$sqlarray = '('.implode(',',$members).')';
		
			// Count number of items sold in null
			$sql = ("SELECT SUM(profit) FROM wallet WHERE typeID = $typeID AND transactionType = 'sell' AND characterID IN $sqlarray");
					
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
				return $total[0]['SUM(profit)'];
			}
	
	}
	
	public function soldCount($typeID,$dateRange)
	{
			$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
			$sqlarray = '('.implode(',',$members).')';
			
			// Count number of items sold in null
			$sql = ("SELECT SUM(quantity) FROM wallet WHERE typeID = $typeID AND transactionType = 'sell' AND DATE(transactionDateTime) > DATE(DATE_SUB(CURDATE(),INTERVAL $dateRange DAY)) AND characterID IN $sqlarray");
					
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
				return $total[0]['SUM(quantity)'];
			}
	
	}
	
	public function itemVolume($typeID)
	{
			$sql = ("SELECT volume FROM invTypes WHERE typeID = $typeID");
					
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
				return $total[0]['volume'];
			}
	
	}
	
	public function getMovementData($stationID,$type)
	{
		//Get our current group characters
		$members = $this->getMembersAsArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';

		$eveDate = $this->getEveTimeSql();
		
		$sql = ('SELECT DATE( transactionDateTime ) AS date1, COUNT(transactionDateTime) AS totalVolume
					FROM wallet
					WHERE personal =0
					AND characterID IN '.$sqlarray.'
					AND transactionType = "'.$type.'"
					AND stationID = '.$stationID.'
					GROUP BY date1
					ORDER BY date1');
		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		
		$profitResults=$command->query();
		foreach ($profitResults as $row)
		{
			$date = (strtotime($row['date1']) - (5*60*60)) * 1000;
			$profitData[] = array($date,$row['totalVolume']);
		}
		return $profitData;
	}

}
