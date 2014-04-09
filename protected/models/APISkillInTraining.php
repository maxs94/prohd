<?php

class APISkillInTraining extends EVEXMLData
{

	public function apiAttributes()
	{
		return array(
			'url'=>'http://api.eve-online.com/char/SkillInTraining.xml.aspx',
			'cacheID'=>'APISkillInTraining',
			'primaryID'=>'characterID',
			'keys'=>array('keyID','vCode','characterID'),
		);
	}

}
?>