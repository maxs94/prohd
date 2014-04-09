<?php

class AdminController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionEdituser($id)
	{
		$model = Accounts::Model()->findByPk($id);
		$oldPass = $model->password;
		$model->password = '******';

		// uncomment the following code to enable ajax-based validation
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounts-edituser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/

		if(isset($_POST['Accounts']))
		{
			$model->attributes=$_POST['Accounts'];
			if($model->validate())
			{
				if ($model->password == '******')
				{
					$model->password = $oldPass;
				}
				else
				{
					$newSalt = $this->generateSalt(10);
					$newPass = md5($newSalt.$model->password);
					$model->salt = $newSalt;
					$model->password = $newPass;
				}
				$model->save();
				$this->redirect(array('index'));
			}
		}
		$this->render('edituser',array('model'=>$model));
	}
	
	public function actionAdduser()
	{
		$model = new Accounts;

		// uncomment the following code to enable ajax-based validation
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='accounts-edituser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		*/

		if(isset($_POST['Accounts']))
		{
			$model->attributes=$_POST['Accounts'];
			if($model->validate())
			{
				$newSalt = $this->generateSalt(10);
				$newPass = md5($newSalt.$model->password);
				$model->salt = $newSalt;
				$model->password = $newPass;
				$model->save();
				$this->redirect(array('index'));
			}
		}
		$this->render('adduser',array('model'=>$model));
	}
	
	public function actionDeleteuser($id)
	{
		$account = Accounts::Model()->findByPk($id);
		$account->delete();
		
		$this->renderPartial('deleteuser');
	}
	
	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // Enable access authentication control for this page
		);
	}
	
	public function actionFlushCache()
	{
		Yii::app()->cache->flush();
		$this->redirect(array('index'));
	}
	
	public function actionUpdateCharacter($id)
	{
		$model = Characters::Model()->find('characterID=:characterID',array(':characterID'=>$id));
		
		// Generate the accounts dropdown list
		$accounts = Accounts::Model()->findAll();
		foreach ($accounts as $account)
		{
			$accountsArray[$account->accountID] = $account->fullName;
		}


		if(isset($_POST['ajax']) && $_POST['ajax']==='characters-updateCharacter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Characters']))
		{
			$model->attributes=$_POST['Characters'];
			if($model->validate())
			{
				$model->save();
				$this->redirect(array('index'));
			}
		}
		$this->render('updateCharacter',array('model'=>$model,'accountsArray'=>$accountsArray));
	}
	
	public function actionCreateCharacter()
	{
		$model = new Characters;
		
		// Generate the accounts dropdown list
		$accounts = Accounts::Model()->findAll();
		foreach ($accounts as $account)
		{
			$accountsArray[$account->accountID] = $account->fullName;
		}


		if(isset($_POST['ajax']) && $_POST['ajax']==='characters-createCharacter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Characters']))
		{
			$model->attributes=$_POST['Characters'];
			if($model->validate())
			{
				$model->save();
				$this->redirect(array('index'));
			}
		}
		$this->render('createCharacter',array('model'=>$model,'accountsArray'=>$accountsArray));
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user only
				'actions'=>array('index','edituser'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('allow', // allow admin user only
				'actions'=>array('adduser','deleteuser','flushCache','updateCharacter','createCharacter'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel == 1',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function getUsers()
	{
		if (Yii::app()->user->userLevel == 1)
		{
			return Accounts::Model()->findAll();
		}
		else
		{
			return Accounts::Model()->findByPk(Yii::app()->user->id);
		}
	}
	
	public function getCharacters()
	{
		if (Yii::app()->user->userLevel == 1)
		{
			$charactersDataProvider = new CActiveDataProvider('Characters', array(
				'criteria'=>array('order'=>'characterName'),
				)
			);
			return $charactersDataProvider;
		}
		else
		{
			$charactersDataProvider = new CActiveDataProvider('Characters', array(
				'criteria'=>array(
					'condition'=>'accountID=:accountID',
					'params'=>array(':accountID'=>Yii::app()->user->id),
					'order'=>'characterName',
				)
			));
			return $charactersDataProvider;
		}
	}
	
	public function getFilteringGroups()
	{
		if (Yii::app()->user->userLevel == 1)
		{
			return TrackingGroups::Model()->findAll();
		}
		else
		{
			return TrackingGroups::Model()->findAll('accountID=:accountID',array(':accountID'=>Yii::app()->user->id));
		}
	}
	
	/**
	 * This function generates an alpha-numeric password salt (with a default of 32 characters)
	 * @param $max integer The number of characters in the string
	 * @author Jayesh Sheth <js_scripts@fastmail.fm>
	 * Inspired by: http://code.activestate.com/recipes/576894-generate-a-salt/?in=lang-php
	 */
	function generateSalt($max = 32) 
	{
		$baseStr = time() . rand(0, 1000000) . rand(0, 1000000);
		$md5Hash = md5($baseStr);
		if($max < 32){
			$md5Hash = substr($md5Hash, 0, $max);
		}
		return $md5Hash;
	}

}