<?php
class APICharacterSheet extends EVEXMLData
{
	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/char/CharacterSheet.xml.aspx',
			'cacheID'=>'APICharacterSheet',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
			'cacheOverride'=>900,
		);
	}		private $_charSheetXML;	public static function load($characterID, $className=__CLASS__)	{		if (!(isset($characterID)))		{			return false;		}		$character = Characters::Model()->find('characterID = :characterID',array(':characterID'=>$characterID));				$sheetObject = new APICharacterSheet;		$sheetObject->_charSheetXML = $sheetObject->getEVEData($character->walletID);				if ($sheetObject->_charSheetXML != false)		{			return $sheetObject;		}		else			return false;	}		public function __get($name)	{		if (preg_match("/id[0-9]*/i",$name))		{			$fixedName = str_replace('id','',$name);			$skill = $this->_charSheetXML->xpath("//rowset[@name='skills']/row[@typeID='".$fixedName."']");		}		elseif (is_string($name))		{			$fixedName = str_replace('_',' ',$name);			$invType = Invtypes::Model()->find("typeName=:typeName",array(":typeName"=>$fixedName));			if ($invType == NULL)			{				return 0;			}			$skill = $this->_charSheetXML->xpath("//rowset[@name='skills']/row[@typeID='".$invType->typeID."']");		}						if (!(is_object($skill[0])))		{			return 0;		}		else		{			return $skill[0]->attributes()->level;		}	}	
}
?>