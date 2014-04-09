<?php
$transInterface = new APITransactions;
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);
foreach ($groupMembers as $member)
{
	$orders = $transInterface->getEveData($member->characterID);
	$character = Characters::Model()->findByPk($member->characterID);
	if ($character->walletEnabled)
	{
		$transInterface->storeData($member->characterID);
	}
}
echo "API Updated. Please refresh your page.";
?>