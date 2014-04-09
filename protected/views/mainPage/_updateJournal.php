<?php

$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
$groupMembers = $this->getTrackingGroupMembers($group->trackingGroupID);

$journalInterface = new APIJournal;

foreach ($groupMembers as $member)
{
	$character = Characters::Model()->findByPk($member->characterID);
	if ($character->journalEnabled)
	{
		$journalInterface->storeData($member->characterID);
	}
}
?>