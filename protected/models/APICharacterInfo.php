<?php

class APICharacterInfo extends EVEXMLData
{

	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/eve/CharacterInfo.xml.aspx',
			'cacheID'=>'APICharacterInfo',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
		);
	}

}
?>