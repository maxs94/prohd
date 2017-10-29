<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function getEveTime()
	{
		return strtotime("+5 hour");
	}
	
	public function getEveTimeSql()
	{
		$time = strtotime("+5 hour");
		$datetime = date( 'Y-m-d H:i:s', $time );

		return $datetime;
	}
	
	public function numToColor($num)
	{
		if ($num <= 0)
		{
			return "red";
		}
		elseif ($num > 0)
		{
			return "green";
		}
		else
		{
			return 0;
		}
	}
	
	public function getIcon($typeID)
	{
		//Find our icons - CCP sucks
		
		//OLD METHOD
		/*
		$types = Invtypes::Model()->findByPk($typeID);
		$categories = Invgroups::Model()->findByPk($types->groupID);
		if (($categories->categoryID == 6) || ($categories->categoryID == 18) || ($categories->categoryID == 9) || ($categories->categoryID == 41))
		{
			$icon = $typeID . ".png";
		}
		else
		{
			$graphics = EveIcons::Model()->findByPk($types->iconID);
			$icon = 'icon'.$graphics->iconFile.".png";
		}
		return $icon;
		*/
		return $typeID . "_32.png";
	}
	
	public function getMarketIcon($marketGroupID)
	{
		//Find our icons - CCP sucks
		$marketGroup = InvMarketGroups::Model()->findByPk($marketGroupID);
		$iconRow = EveIcons::Model()->findByPk($marketGroup->iconID);
		
		//$icon = 'icon'.$iconRow->iconFile.".png";
		$icon = $iconRow->iconFile.".png";
		return $icon;
	}
	
	public function getDefaultTrackingGroup()
	{
			
		$group = TrackingGroups::Model()->findByPk(Yii::app()->user->trackingGroupID);
		
		return $group;
	}
	
	public function getTrackingGroupMembers($groupID)
	{
	
		$groupMembers = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		return $groupMembers;
	}
	
	public function getAllTrackingGroups()
	{
		
		$groups = TrackingGroups::Model()->findAll();
		return $groups;
	}
	
	public function getMembersAsArray($groupID)
	{
		
		$members = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		foreach ($members as $member)
		{
			$memberArray[] = $member->characterID;
		}
		
		return $memberArray;
	}
	
		public function getMembersAsCharIDArray($groupID)
	{
		
		$members = TrackingGroupMembers::Model()->findAll('trackingGroupID=:groupID',array(':groupID'=>$groupID));
		foreach ($members as $member)
		{
			$character = Characters::Model()->findByPk($member->characterID);
			$memberArray[] = $character->characterID;
		}
		
		return $memberArray;
	}

	public function init()
	{
		if (isset($_GET['tgid']))
		{
			Yii::app()->user->setState('trackingGroupID', $_GET['tgid']);
		}
	}
	
	public function minutesSeconds($seconds)
	{
		if ($seconds == 0)
		{
			return "Ready";
		}
		return floor($seconds/60) . " minutes, " . $seconds % 60 . " seconds";
	}
	
	public function getBalance($character)
	{
		$characterInterface = new APICharacterSheet;
		$character = $characterInterface->getEveData($character);
		
		return $character->result->balance[0][0];
	}
	
	/**
	* Converts an array to a highcharts series
	*/
	function arrayToHighchart($array)
	{
		$series = '[';
		$count = count($array);
		foreach ($array as $row)
		{
			$series = $series . '['.$row[0].','.$row[1].']';
			$i++;
			if (!($i == $count))
			{
				$series = $series . ",";
			}
		}
		$series = $series . "]";
		return $series;
	}
	
	function humanTime($totalSeconds)
	{
		$second = 1;
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		
		$days = floor($totalSeconds/$day);
		$hours = floor(($totalSeconds % $day) / $hour);
		$minutes = floor(($totalSeconds % $hour) / $minute);
		$seconds = ($totalSeconds % $minute);
		
		if ($days > 0)
		{
			$timeString .= $days . "d ";
			$diplayedDays = true;
		}
		if (($hours > 0) || ($displayedDays) )
		{
			$timeString .= $hours . "h ";
			$displayedHours = true;
		}
		if (($minutes > 0) || ($displayedHours) )
		{
			$timeString .= $minutes. "m ";
			$displayedMinutes = true;
		}
		$timeString .= $seconds. "s";
		
		return $timeString;
	}
	
	function phdGetCache($cacheKey)
	{
		$cacheKey .= Yii::app()->user->trackingGroupID;
		return Yii::app()->cache->get($cacheKey);
	}
	
	function phdSetCache($cacheKey, $value)
	{
		$cacheKey .= Yii::app()->user->trackingGroupID;
		return Yii::app()->cache->set($cacheKey, $value);
	}
	
	function storeAssetValues($groupID)
	{
		$members = $this->getMembersAsCharIDArray($groupID);
		$sqlarray = '('.implode(',',$members).')';
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'characterID IN '.$sqlarray;
		$criteria->group = 'typeID';
		$assetTypes = Assets::Model()->findAll($criteria);
		$i = 0;
		foreach ($assetTypes as $assetType)
		{
			$fullUrl = "http://api.eve-central.com/api/marketstat?typeid=".$assetType->typeID."&regionlimit=10000002";
			
			
			//Get the data and turn it into a SimpleXML object
			$dataFromHttp = @file_get_contents($fullUrl);
			try
			{
				$xml = new SimpleXMLElement($dataFromHttp);
			}
			catch (Exception $e)
			{
				return 0;
			}
			
			$assetValue = $xml->xpath('/evec_api/marketstat/type/sell/min');
			
			$exists = AssetValues::Model()->exists('typeID=:typeID',array(':typeID'=>$assetType->typeID));
			if ($exists)
			{
				$valueTableRow = AssetValues::Model()->findByPk($assetType->typeID);
				$valueTableRow->value = (float)$assetValue[0];
				$valueTableRow->save();
			}
			else
			{			
				$valueTableRow = new AssetValues;
				$valueTableRow->typeID = $assetType->typeID;
				$valueTableRow->value = (float)$assetValue[0];
				$valueTableRow->save();
			}
		}
	}
	
	function storeSingleAssetValue($typeID)
	{
		$exists = AssetValues::Model()->exists('typeID=:typeID',array(':typeID'=>$typeID));
		if ($exists)
		{
			$valueTableRow = AssetValues::Model()->findByPk($typeID);
			$expiration = strtotime('+1 day', strtotime($valueTableRow->lastUpdated));
			if ($this->getEveTime() > $expiration)
			{
				$fullUrl = "http://api.eve-central.com/api/marketstat?typeid=".$typeID."&regionlimit=10000002";
		
				//Get the data and turn it into a SimpleXML object
				$dataFromHttp = @file_get_contents($fullUrl);
				try
				{
					$xml = new SimpleXMLElement($dataFromHttp);
				}
				catch (Exception $e)
				{
					return 0;
				}
		
				$assetValue = $xml->xpath('/evec_api/marketstat/type/sell/min');
				
				$valueTableRow->value = (float)$assetValue[0];
				$valueTableRow->lastUpdated = $this->getEveTimeSql();
				$valueTableRow->save();
				return (float)$assetValue[0];
			}
		}
		else
		{
			$fullUrl = "http://api.eve-central.com/api/marketstat?typeid=".$typeID."&regionlimit=10000002";
		
			//Get the data and turn it into a SimpleXML object
			$dataFromHttp = @file_get_contents($fullUrl);
			try
			{
				$xml = new SimpleXMLElement($dataFromHttp);
			}
			catch (Exception $e)
			{
				return 0;
			}
	
			$assetValue = $xml->xpath('/evec_api/marketstat/type/sell/min');
			
			$valueTableRow = new AssetValues;
			$valueTableRow->typeID = $typeID;
			$valueTableRow->value = (float)$assetValue[0];
			$valueTableRow->lastUpdated = $this->getEveTimeSql();
			$valueTableRow->save();
			return (float)$assetValue[0];
		}
	}
			
}