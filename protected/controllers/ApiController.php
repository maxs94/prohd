<?php

class ApiController extends Controller
{
	public function actionOnline()
	{
		$api = new ApiStatusObject;
		if ($api->isEnabled())
		{
			if ($api->isOnline())
			{
				$result = "<font color='green'>".number_format($api->players())." Online</font>";
			}
			else
			{
				$result = "<font color='red'>".$api->statusText()."</font>";
			}
		}
		else
		{
			$result = "<font color='red'>".$api->statusText()."</font>";
		}
		$this->renderPartial('result',array('result'=>$result));
	}
	
	public function actionCheckcache($charID, $apiObject)
	{
		$api = new ApiStatusObject;
		if ($api->isOnline())
		{
			$failed = false;
			try
			{
				$api = new $apiObject;
			}
			catch (Exception $e)
			{
				$failed = true;
			}
			
			if (!$failed)
			{
				$result = '<font color="green">'.$this->minutesSeconds($api->getCacheExpiration($charID)).'</font>';
			}
			else
			{
				$result = '<font color="red">Invalid API: '.$apiobject.'</font>';
			}
		}
		else
		{
			$result = '<font color="red">'.$api->statusText().'</font>';
		}
		$this->renderPartial('result',array('result'=>$result));
	}
	
	public function actionCharbalances()
	{
		$this->renderPartial('groupbalance');
	}
	
}