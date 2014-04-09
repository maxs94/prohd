<?php
$this->breadcrumbs=array(
	'Preferences',
);?>
<h1>Account Preferences</h1>

<div class='prefs-main'>
	<h1 class='prefs-header'>Main</h1>
	
	<div class='prefs-main-account'>
		<h1>Account</h1>
		<div class='prefs-content'>
			<div class='prefs-main-account-changename'>Change Display Name</div>
			<div class='prefs-main-account-changepass'>Change Password</div>
		</div>
	</div>
	
	<div class='prefs-main-characters'>
		<h1>Characters</h1>
		<div class='prefs-content'>
			<ul>
				<li class='prefs-main-characters-list'>
					<img class='character-icon' src='http://image.eveonline.com/Character/1842575932_32.jpg'>Test Character
					<img src='./images/cross.png' class='prefs-character-remove'>
					<img src='./images/card--pencil.png' class='prefs-edit-button' alt='Edit Character & Preferences'>
				</li>
			</ul>
			<div class='add-button'>
				<img src='./images/plus-circle.png'>Add New Character
			</div>
		</div>
	</div>
	
</div>

<div class='prefs-group'>
	<h1 class='prefs-header'>Group Configuration</h1>
	
	<div class='prefs-group-characters'>
		<ul>
			<li class='prefs-group-draggable'>
				Test Character
				<div class='drag-remove'>x</div>
			</li>
		</ul>
	</div>
	
	<div class='prefs-group-groups'>
		<input class='prefs-group-groupname' value='Test Group'>
		<div class='prefs-group-delete'>x</div>
		<div class='prefs-group-groups-charlist'>
			<ul>
				<li class='prefs-group-draggable'>
					Test Character
					<div class='drag-remove'>x</div>
				</li>
			</ul>
		<div class='prefs-group-systemlist'>
			<ul>
				<li class='prefs-group-system'>
					Test System
					<div class='system-remove'>x</div>
				</li>
			</ul>
			<input class='prefs-group-system-search' value='Add System'>
		</div>
	</div>
</div>
<div style='clear: both;'></div>
				