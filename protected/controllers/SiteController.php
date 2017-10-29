<?php

class SiteController extends Controller
{
	
	/*
	** maxs94: check database for tables and eve static 
	*/
	public function check_db() {
		
	//	print_r(Yii::app()->db->schema->getTables());
		
		// check for prohd tables 
		$exists = Yii::app()->db->schema->getTable('accounts', true);
		
		if ($exists == null) die("(database) please import prohd.sql database dump into your database.");
		
		// check for eve static tables 
		$exists = Yii::app()->db->schema->getTable('invTypes', true);
		if ($exists == null) {
			echo "(database) Please import EVE's static database dump into your database.<br>";
			echo "You can grab a copy from Fuzzwork (<a href=\"https://www.fuzzwork.co.uk/dump/mysql-latest.tar.bz2\" target=\"_blank\">here</a>)";
			die();
		}
		
		// check if an account is set up 
		$q = "SELECT * FROM accounts";
		$results = Yii::app()->db->createCommand($q)->queryAll();
		
		if (count($results) == 0) {
			// initial setup 
			
			$qs[] = "DELETE FROM accounts";
			$qs[] = "DELETE FROM apiStatus";
			$qs[] = "DELETE FROM trackingGroups";
			$qs[] = "DELETE FROM characters";
			$qs[] = "DELETE FROM trackingGroupMembers";
			
			$qs[] = "INSERT INTO accounts VALUES (1, 'admin', md5('password'), '', 1, 1, 'Admin')";
			$qs[] = "INSERT INTO apiStatus VALUES (1,1)";
			$qs[] = "INSERT INTO trackingGroups VALUES ('Main Group', 1, 1)";
			$qs[] = "INSERT INTO trackingGroupMembers VALUES (1, 1, 1)";
			$qs[] = "INSERT INTO characters VALUES (1, 1, 'Please change', 0, 'API vcode - please change', 1, 0, NOW(), 1, 1, 1, 1, 1, 0)";
			
			
			foreach ($qs as $q) {
					Yii::app()->db->createCommand($q)->query();
			}
			
			
			
			
			
			echo '<H1>Setup complete</H1>';
			echo 'Created user "admin" with password "password". Please refresh this page to login.<br>';
			echo 'After logging in, please make sure to change the password of the admin user and to add your admin keys.';
			die();
		}
		
		
	}
	
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page 
	 * maxs94: checks the database structure
	 */
	public function actionLogin()
	{
		
		$this->check_db();
		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}