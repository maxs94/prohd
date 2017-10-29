<?php
/**
 * EVEXMLData class file.
 *
 * @author Matt Nischan <nishmaster@gmail.com>
 * @copyright Copyright &copy; 2010 Matt Nischan
 */

abstract class EVEXMLData extends CModel
{
	
	//Overload this function to set the individual model attributes
	public function apiAttributes()
	{
	}
	
	public function getEVEData($characterID)
	{
		//Get the API model attributes
		$attributes = $this->apiAttributes();
		//Get the character information from the db
		$character = Characters::model()->findByPk($characterID);

		//Create the full cacheID and check the cache
		$fullCacheID = $attributes['cacheID'] . $character->getAttribute($attributes['primaryID']);
		$data = null; //Yii::app()->cache->get($fullCacheID);
		
		//If the cache is empty or has expired, get it from the EVE server
		if (empty($data))
		{
			//Generate the full URL
			$fullUrl = $attributes['url'] . "?";
			$getKeys = $attributes['keys'];
			
			//If the keys are empty, assume no keys are necessary in the URL
			if (empty($attributes['keys']))
			{
				$fullUrl = $attributes['url'];
			}
			else
			{
				foreach ($getKeys as $APIkey)
				{
					$fullUrl = $fullUrl . "$APIkey=" . $character->getAttribute($APIkey) . "&";
				}
			}
				
				//Get the data and turn it into a SimpleXML object
				$dataFromHttp = @file_get_contents($fullUrl);
				try
				{
					$EVExml = new SimpleXMLElement($dataFromHttp);
				}
				catch (Exception $e)
				{
					return 0;
				}
				
				//Retrieve the cache timer
				$cacheTimer = strtotime($EVExml->cachedUntil) - strtotime($EVExml->currentTime) + 5;
				if(!(empty($attributes['cacheOverride'])))
				{
					$cacheTimer = $attributes['cacheOverride'];
				}
				
				if ($EVExml->error)
				{
					$cacheTimer = strtotime($EVExml->cachedUntil) - strtotime($EVExml->currentTime) + 5;
                                        //print_r($EVExml);
				}
				//Store the data in the cache
				$data = Yii::app()->cache->set($fullCacheID, $dataFromHttp, $cacheTimer);
		}
		
		$cachedData = Yii::app()->cache->get($fullCacheID);
		$XMLObject = new SimpleXMLElement($cachedData);
		return $XMLObject;
	}
	
	public function attributeNames()
	{
	}
	
	//Returns the number of seconds remaining on the cache timer
	public function getCacheExpiration($characterID)
	{
		
		if (empty($characterID)) echo "getCacheExpiration: No characterID defined";
		
		//Get the API model attributes
		$attributes = $this->apiAttributes();
		
		//Get the character information from the db
		$character = Characters::model()->findByPk($characterID);
		
		
		//Create the full cacheID and check the cache
		$fullCacheID = $attributes['cacheID'] . $character->getAttribute($attributes['primaryID']);
		$expire = Yii::app()->cache->expiration($fullCacheID);
		
		if (empty($expire))
			return 0;
		else
		{
			$timeLeft = $expire - time();
			if ($timeLeft <= 0)
			{
				return 0;
			}
			else
			{
				return $timeLeft;
			}
		}

		/*
		if (empty($data))
		{
			return 0;
		}
		else
		{
			$EVExml = new SimpleXMLElement($data);
			$remain = strtotime($EVExml->cachedUntil) - strtotime("+5 hour") + 5 + $attributes['cacheOffset'];
			
			if ($EVExml->error)
			{
				echo "ERROR: $EVExml->error CHARACTER: $characterID <br>";
			}
			
			if ($remain <= 0)
			{
				return 0;
			}
			else
			{
				return $remain;
			}
		}
		*/
		
	}
	
	
	function xmlToArray($xml, $root = true) {
		if (!$xml->children()) {
			return (string)$xml;
		}
	 
		$array = array();
		foreach ($xml->children() as $element => $node) {
			$totalElement = count($xml->{$element});
	 
			if (!isset($array[$element])) {
				$array[$element] = "";
			}
	 
			// Has attributes
			if ($attributes = $node->attributes()) {
				$data = array(
					'attributes' => array(),
				);
				if (!count($node->children())){
					$data['value'] = (string)$node;
				} else {
					$data = array_merge($data, xmlToArray($node, false));
				}
				foreach ($attributes as $attr => $value) {
					$data['attributes'][$attr] = (string)$value;
				}
	 
				if ($totalElement > 1) {
					$array[$element][] = $data;
				} else {
					$array[$element] = $data;
				}
			// Just a value
			} else {
				if ($totalElement > 1) {
					$array[$element][] = xmlToArray($node, false);
				} else {
					$array[$element] = xmlToArray($node, false);
				}
			}
		}
	 
		if ($root) {
			return array($xml->getName() => $array);
		} else {
			return $array;
		}
	}		
}