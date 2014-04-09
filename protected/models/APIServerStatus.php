<?php

class APIServerStatus extends EVEXMLData
{

	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/server/ServerStatus.xml.aspx',
			'cacheID'=>'APIServerStatus',
			'primaryID'=>'characterID',
		);
	}

}
?>