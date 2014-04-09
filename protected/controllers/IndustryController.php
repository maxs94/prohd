<?php

class IndustryController extends Controller
{

	public function actionIndex()
	{
		$projects = $this->getProjectsDataProvider();
		$this->render('index',array(
			'projects'=>$projects
			)
		);
	}

	public function actionDeleteJob($id)
	{
		$this->render('delete');
	}

	public function actionStart()
	{
		$model=new Projects;

		// uncomment the following code to enable ajax-based validation
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='projects-start-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/

		if(isset($_POST['Projects']))
		{
			$model->attributes=$_POST['Projects'];
			$model->creationDateTime = date('Y-m-d H:i:s');
			if($model->validate())
			{
				$model->save();
				$this->redirect('industry/index');
			}
		}
		$this->render('start',array('model'=>$model));
	}

	public function actionCompleteJob($id)
	{
		$this->render('complete');
	}

	public function getProjectsDataProvider()
	{
		//Grab the characters from the db
		$members = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
		$sqlarray = '('.implode(',',$members).')';
		
		$projectsDataProvider = new CActiveDataProvider('Projects', array(
			'criteria'=>array(
				'condition'=>'characterID IN '.$sqlarray,
			)
		));
		return $projectsDataProvider;
	}
	
	public function getCharacters()
	{
		$groupMembers = TrackingGroupMembers::Model()->findAll('trackingGroupID=:trackingGroupID',array(':trackingGroupID'=>Yii::app()->user->trackingGroupID));
		foreach ($groupMembers as $member)
		{
			$character = Characters::Model()->findByPk($member->characterID);
			$charArray[$character->characterID] = $character->characterName;
		}
		return $charArray;
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
				'actions'=>array('index', 'deleteJob', 'start', 'completeJob'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

}
?>