<?php

class APICharacters extends EVEXMLData
{

	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/account/Characters.xml.aspx',
			'cacheID'=>'APICharacters',
			'primaryID'=>'keyID',
			'keys'=>array('keyID','vCode'),
		);
	}

}
?>