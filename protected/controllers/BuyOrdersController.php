<?php

class BuyOrdersController extends Controller
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
	
	public function getOrdersDataProvider($walletID)
	{
		//Get the character information from the db
		$character = Characters::model()->findByPk($walletID);
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'charID=:characterID AND orderState=0 AND bid=1';
		$criteria->params = array(':characterID'=>$character->characterID);
		$criteria->order = 'typeName';
		$criteria->with = 'invtypes';
		
		$orders = new CActiveDataProvider('Orders', array(
        'pagination'=>array(
            'pageSize'=>20,
        ),
        'criteria'=>$criteria,
		));
		
		return $orders;
	}
	
	 function getHumanTime($unix) {

	//--------------------------------------------------
	// Maths

	$sec = $unix % 60;
	$unix -= $sec;

	$minSeconds = $unix % 3600;
	$unix -= $minSeconds;
	$min = ($minSeconds / 60);

	$hourSeconds = $unix % 86400;
	$unix -= $hourSeconds;
	$hour = ($hourSeconds / 3600);

	$daySeconds = floor($unix / 86400);
	//$unix -= $daySeconds;
	$day = ($daySeconds / 86400);

	//$week = ($unix / 604800);

	//--------------------------------------------------
	// Text

	$output = '';

	//if ($week > 0) $output .= ', ' . $week . ' week' . ($week != 1 ? 's' : '');
	if ($daySeconds > 0) $output .= ', ' . $daySeconds . 'd ';
	if ($hour > 0) $output .= $hour . 'h ';
	if ($min > 0) $output .= $min . 'm ';

	if ($sec > 0 || $output == '') {
	$output .= $sec . 's ';
	}

	//--------------------------------------------------
	// Grammar

	$output = substr($output, 2);
	//$output = preg_replace('/, ([^,]+)$/', ' and $1', $output);

	//--------------------------------------------------
	// Return the output

	return $output;

	} 
	
	public function getOrderTotal($characterID)
	{
		//Get the character information from the db
		$character = Characters::model()->findByPk($characterID);
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'charID=:characterID AND orderState=0 AND bid=1';
		$criteria->params = array(':characterID'=>$character->characterID);
		
		$orders = Orders::Model()->findAll($criteria);
		foreach ($orders as $order)
		{
			$orderTotal = $orderTotal + ($order->price * $order->volRemaining);
		}
		
		return $orderTotal;
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