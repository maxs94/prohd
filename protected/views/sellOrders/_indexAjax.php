<?php

//Check on our cache value
$orderInterface = new APIOrders;

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);

foreach ($groupMembers as $member)
{
	$orderInterface->getEveData($member->characterID);
	$character = Characters::Model()->findByPk($member->characterID);
	if ($character->ordersEnabled)
	{
		$orderInterface->storeData($member->characterID);
	}

}

echo "API Updated. Please refresh your page.";

?>