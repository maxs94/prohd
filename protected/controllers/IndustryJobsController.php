<?php

class IndustryJobsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionIndexajax()
	{
		$this->renderPartial('_indexAjax');
	}
        
        public function actionGetCalendar()
        {
            $this->renderPartial('_results',array('results'=>json_encode($this->getCapitalJobs()->readAll())));
        }
        
        public function actionCaltest()
        {
            $this->render('caltest');
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
				'actions'=>array('index','indexajax','caltest','getCalendar'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function getCharacters($accountID)
	{
	$accountID = 1;
	$sql = 'SELECT * FROM characters WHERE accountID = '.$accountID.'';
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$characters = $command->query();
	foreach ($characters as $row)
		{
		$charInfo[] = array("characterName"=>$row['characterName'], "characterID"=>$row['characterID']);
		}
	return $charInfo;
	}
	
	public function getMaxJobs()
	{
	return 9;
	}
	
	public function getJobResearchCount($charID)
	{
	$sql = 'SELECT COUNT(*)FROM industryJobs WHERE installerID = '.$charID.' 
	AND completed = 0
	AND activityID NOT IN (1)';
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
			
	//Run the query
	$results = $command->query();
	$row = $results->read();
	return $row['COUNT(*)'];
	}
        
        /**
         * Gets an array of capital jobs
         * @return array An array of capital jobs currently in progess
         */
        public function getCapitalJobs()
        {
            $sql = 'SELECT industryJobs.jobID, industryJobs.outputTypeID, industryJobs.installerID, industryJobs.beginProductionTime, industryJobs.endProductionTime, invTypes.typeName 
                    FROM industryJobs
                    JOIN invTypes ON (industryJobs.outputTypeID = invTypes.typeID)
                    WHERE completed = 0 AND activityID = 1 AND (NOW() < industryJobs.endProductionTime) AND invTypes.groupID IN (513,547,485,659,883,941,902,28,27,419)
                    ORDER BY invTypes.typeID'; 
            
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            
            $results = $command->query();
            return $results;
        }
	
}