<?php

class CorpAssetsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionGetAssetsJson()
	{
		$groupMembersArray = $this->getMembersAsCharIDArray(Yii::app()->user->trackingGroupID);
		$groupMembersString = "(".implode(",",$groupMembersArray).")";
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'characterID in '.$groupMembersString;
		$criteria->group = 'typeID';
		$criteria->order = 'typeName';
		
		$assets = CorpAssets::Model()->findAll($criteria);
		
		foreach ($assets as $asset)
		{
			$assetArray[] = array($asset->itemID,$asset->typeName);
		}
		
		$json = json_encode($assetArray);
		
		$this->renderPartial('getAssetsJson',array('json'=>$json));
	}
	
	public function actionStoreValue()
	{
		$id = $_GET['id'];
		
		$asset = CorpAssets::Model()->findByPk($id);
		
		$this->storeSingleAssetValue($asset->typeID);
		
		$this->renderPartial('storeValue');
	}
	
        public function getCorpKeys($trackingGroupID)
        {
            $sql = 'SELECT characters.*, trackingGroupMembers.trackingGroupID 
                    FROM `characters`
                    LEFT JOIN trackingGroupMembers ON (characters.walletID = trackingGroupMembers.characterID)
                    WHERE characters.isCorpKey = 1
                    AND trackingGroupID = :trackingGroupID';
            
            return Yii::app()->db->createCommand($sql)->queryAll(true, array(':trackingGroupID'=>$trackingGroupID));
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