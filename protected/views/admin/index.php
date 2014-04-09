<?php
$this->breadcrumbs=array(
	'Admin',
);
//Create the delete user dialog
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'deleteuserdialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Really delete user?',
        'autoOpen'=>false,
		'draggable'=>false,
		'resizable'=>false,
		'modal'=>true,
		'buttons'=>array(
			'Confirm'=>'js:
				function()
				{
					$.ajax({
						type: "GET",
						url: "index.php?r=admin/deleteuser",
						data: {id: id},
						success: function()
						{
							location.reload();
						}
					});
				}',
			'Cancel'=>'js:function(){$(this).dialog("close");}',
			),
    ),
));
echo 'Are you sure you wish to delete this user object?';
$this->endWidget('zii.widgets.jui.CJuiDialog');
/*
$.ajax({
  url: 'ajax/test.html',
  success: function(data) {
    $('.result').html(data);
    alert('Load was performed.');
  }
});
*/
?>
<script type="text/javascript">
jQuery(function($)
{
	jQuery('.deleteuser').click( function()
	{
		id = this.id;
		$("#deleteuserdialog").dialog('open');
	});
});
</script>
<h1>Administration</h1>
<hr>
<div class="mainLeft">
	<div class="mcenter"><img src="images/icon57_12.png">Users</div>
	<div class="currentstats">
		<table>
			<tr>
				<td>Full Name</td>
				<td>Username</td>
				<td>Userlevel</td>
				<td>Default Group</td>
				<td></td>
				<td></td>
			</tr>
			<?php
			//Get the users and loop through the rows
			$users = $this->getUsers();
			foreach ($users as $user)
			{
				$i++;
				if ($i % 2)
					echo '<tr class="odd">';
				else
					echo '<tr>';
					
				echo '
					<td>'.$user->fullName.'</td>
					<td>'.$user->userName.'</td>
					<td>'.$user->userLevel.'</td>
					<td>'.$user->trackingGroupID.'</td>
					<td><a href="index.php?r=admin/edituser&id='.$user->accountID.'"><img src="images/user--pencil.png"></a>
					<td>'.CHtml::link('<img src="images/user--minus.png">', '#', array(
							'class'=>'deleteuser',
							'id'=>$user->accountID,
							)).'
				</tr>';
			}
			echo '
				<tr>
					<td><a href="index.php?r=admin/adduser"><img src="images/user--plus.png"></a></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<tr>';
			?>
		</table>
	</div>
	<div class="mcenter"><img src="images/icon57_12.png">Characters</div>
	<div class="currentstats">
	<?
	// Create the update and delete buttons
	$charButtons = array(
		'class'=>'CButtonColumn',
		'template'=>'{update}{delete}',
		'buttons'=>array(
			'delete'=>array(
				'url'=>'Yii::app()->createUrl("admin/deleteCharacter", array("id"=>$data->characterID))',
			),
			'update'=>array(
				'url'=>'Yii::app()->createUrl("admin/updateCharacter", array("id"=>$data->characterID))',
			)
		)
	);
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$this->getCharacters(),
		'selectableRows'=>0,
		'columns'=>array(
			'characterName',
			'characterID',
			'account.fullName',
			$charButtons,
		),
		'template'=>'{items}{pager}'
	));
	?>
	<a href="index.php?r=admin/createCharacter"><img src="images/user--plus.png"></a>
	</div>
	<div class="mcenter"><img src="images/icon57_12.png">Groups</div>
	<div class="currentstats">
		# Top level admin: Create/edit/delete stock groups <img src="images/category.png"><BR>
		<BR>
		# Users: Create/edit/delete your own filtering groups<BR>
		Create <img src="images/card--plus.png">
		Edit <img src="images/card--pencil.png">
		Delete <img src="images/card--minus.png">
	</div>
</div>
<div class="mainRight">
	<div class="mcenter"><img src="images/icon57_12.png">API</div>
	<div class="currentstats">
		# Top level admin: Pause API updates: [PAUSE ICON] <img src="images/hourglass--exclamation.png"> / [RESUME ICON] <img src="images/hourglass--arrow.png"><BR>
		# Top level admin: Manually refresh API: [REFRESH ICON] <img src="images/hourglass-select-remain.png"<BR>
		# Top level admin: Flush API cache: [FLUSH ICON] <img src="images/hourglass--minus.png">
	</div>
</div>
