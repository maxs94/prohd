<?php
$this->breadcrumbs=array(
	'T2 Production',
);
$group = $this->getDefaultTrackingGroup(Yii::app()->user->trackingGroupID);
?>
<script type='text/javascript'>
	$(document).ready(function()  {
	
		//Timeout ID and wait time
		var calcTimeout;
		var uiBufferTime = 500;
		var resultPaneOpen = false;
	
		//Draggable blueprint items
		$('.drag').draggable({ 
			revert: 'invalid',
			helper:	'clone',
			appendTo: 'body',
			zIndex: 9999,
			scroll: false,
			start : function() {
				this.style.visibility="hidden";
			},
			stop: function() {
				this.style.visibility="";
			}
		});
		
		//Initialize the bp items with a pointer cursor
		$('.drag').css('cursor','pointer');
		
		//Droppable right side box
		$('#dest').droppable({
		
			//On drop
			drop: function( event, ui ) {
			
				dropped = this;
				var typeIDs = [];
				
				//Slide the old list item up
				ui.draggable.slideUp('fast',function(){
				
					//Add the item to the right side list and create the remove image
					$( dropped ).append(ui.draggable);
					
					//x button
					ui.draggable.children('.drag-remove').show();
					
					//Arrows
					ui.draggable.children('.t2-production-arrows').show();
					
					//Make the item appear in the right side box and disable draggable
					ui.draggable.draggable('disable');
					ui.draggable.removeClass('ui-state-disabled ui-draggable-disabled');
					ui.draggable.children('.t2-bp-name').addClass('t2-bp-name-limit');
					ui.draggable.css('cursor','default');
					ui.draggable.slideDown('fast',function(){
						calcMaterials(dropped);
					});
					
				});
			},
		});
		
		//"x" button handler
		$('.drag-remove').click(function() {
			removedItem = $(this).parent();
			dropErase = $(this);
			origin = $('#origin');
			
			//Slide the item up and remove the "x"
			removedItem.slideUp('fast',function(){
			
				bpQueue = removedItem.parent();
				
				//Add the item back to the left list
				origin.append(removedItem);
				
				//Hide the buttons
				dropErase.hide();
				removedItem.children('.t2-production-arrows').hide();
				
				//Sort the ul again
				var listitems = origin.children('li').get();
				listitems.sort(function(a, b) {
					var compA = $(a).children('.order').text().toUpperCase();
					var compB = $(b).children('.order').text().toUpperCase();
					return compA - compB;
				})
				$.each(listitems, function(idx, itm) { origin.append(itm); });
				
				//Redisplay the item
				removedItem.children('.t2-bp-name').removeClass('t2-bp-name-limit');
				removedItem.draggable('enable');
				removedItem.css('cursor','pointer');
				removedItem.slideDown('fast');
				
				//Calc the materials
				calcMaterials(bpQueue);
			});
		});
		
		//Up arrow handler
		$('.t2-up-arrow').click(function() {
		
			//Get the amount display object
			amountObject = $(this).parent().children('.t2-amount');
			bpQueue = $(this).parent().parent().parent();
			
			//Increase the value
			amountObject.val(parseInt(amountObject.val()) + 1)
			
			//After 500ms, recalc the materials
			clearTimeout(calcTimeout);
			calcTimeout = setTimeout(function(){
				calcMaterials(bpQueue);
			},uiBufferTime);
		});
		
		//Down arrow handler
		$('.t2-down-arrow').click(function() {
		
			//Get the amount display object
			amountObject = $(this).parent().children('.t2-amount');
			amount = parseInt(amountObject.val());
			bpQueue = $(this).parent().parent().parent();
			
			if (amount < 2)
			{
				amount = 1;
			}
			else
			{
				amount -= 1;
			}
			
			//Decrease the value
			amountObject.val(amount);
			
			//After 500ms, recalc the materials
			clearTimeout(calcTimeout);
			calcTimeout = setTimeout(function(){
				calcMaterials(bpQueue);
			},uiBufferTime);
		});
		
		//Allow only numbers in our amount fields
		$(".t2-amount").keydown(function (event) {
			if ((!event.shiftKey && !event.ctrlKey && !event.altKey) && ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105))) // 0-9 or numpad 0-9, disallow shift, ctrl, and alt
			{
				// check textbox value now and tab over if necessary
			}
			else if (event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 37 && event.keyCode != 39 && event.keyCode != 9) // not esc, del, left or right
			{
				event.preventDefault();
			}
			// else the key should be handled normally
		});
		
		//On keyup, recalculate the materials and unselect the input box
		$('.t2-amount').keyup(function() {
			bpQueue = $(this).parent().parent().parent();
			clearTimeout(calcTimeout);
			caller = this;
			calcTimeout = setTimeout(function(){
				$(caller).blur();
				if (!($(caller).val()))
				{
					$(caller).val('1');
				}
				calcMaterials(bpQueue);
			},uiBufferTime);
		});
		
		//On focus, highlight the input box
		$('.t2-amount').focus(function(){
			$(this).removeClass('t2-amount-normal').addClass('t2-amount-highlight');
		});
		
		//On blur, un-highlight the input box
		$('.t2-amount').blur(function(){
			$(this).removeClass('t2-amount-highlight').addClass('t2-amount-normal');
		});
		
		function calcMaterials(bpQueue)
		{
			//Create an array of each typeID in our queue and serialize it
			var typeIDs = [];
			$(bpQueue).children('li').each(function(index) {
				typeIDs.push($(this).attr('id'));
			});
			var typeIDString = typeIDs.join(',');
			
			//Create an array of each run amount and serialize it
			var runs = [];
			$(bpQueue).children('li').each(function(index) {
				runs.push(parseInt($(this).children('.t2-production-arrows').children('.t2-amount').val()));
			});
			var runString = runs.join(',');
			
			//Send off our ajax if the production queue isn't empty
			if (typeIDString != '')
			{
				//If the result pane is not yet open hide it in preparation for the slide down animation
				if (!(resultPaneOpen))
				{
					$('.t2-production-results').hide();
				}
				//If it is open, fade it slightly
				else
				{
					$('.t2-production-results').fadeTo('fast',0.5);
				}
				
				//Load the results
				$('.t2-production-results').load("<? echo Yii::app()->createUrl('/t2Production/results'); ?>", {typeID: typeIDString, runs: runString}, function(){
					if (!(resultPaneOpen))
					{
						$('.t2-production-results').css({opacity: 1.0});
						$('.t2-production-results').slideDown('slow');
						resultPaneOpen = true;
					}
					else
					{
						$('.t2-production-results').fadeTo('fast', 1.0);
					}
				});
			}
			else
			{
				//Close the result pane
				resultPaneOpen = false;
				$('.t2-production-results').slideUp('slow', function(){
					$('.t2-production-results').html('<table><tr class="header1"><td style="text-align: left;"><div class="textCenter"><img src="images/items/icon57_12.png" width="16" height="16">Projected Requirements</div></td></tr></table>');
					$('.t2-production-results').slideDown();
				});
			}
		}
		
	});
</script>

<div class='t2-production-leftcolumn'>
	<div class='currentstats'>
		<table>
			<tr class="header1">
				<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="16" height="16">Current Inventory</div></td>
			</tr>
		</table>
		<ul class='t2-production-container' id='origin'>
			<?
			foreach ($bps as $bp)
			{
				$i++;
				?>
				<li class='drag' id='<? echo $bp['typeID']; ?>'>
					<img src='http://image.eveonline.com/Type/<? echo $bp['typeID']; ?>_32.png' class='drag-icon'>
					<span class='order' style='display: none'><? echo $i; ?></span>
					<div class='t2-bp-name'>
						<? echo $bp['typeName'] ?>
					</div>
					<img src="./images/cross.png" class="drag-remove">
					<div class="t2-production-arrows">
						<img src="./images/up.png" class="t2-up-arrow">
						<img src="./images/down.png" class="t2-down-arrow">
						<input class="t2-amount t2-amount-normal" value="1">
					</div>
				</li>
				<?
			}
			?>
		</ul>
	</div>
</div>
<div class='t2-production-middleimage'>
	<!-- <img src='./images/fwd-icon.png'><br> -->
</div>
<div class='t2-production-rightcolumn'>
	<div class='currentstats'>
		<table>
			<tr class="header1">
				<td style="text-align: left;"><div class='textCenter'><img src="images/items/33_128_2.png" width="16" height="16">Production Queue</div></td>
			</tr>
		</table>
		<ul class='t2-production-container' id='dest'>
		</ul>
	</div>
</div>
<div style='clear: both;'>
<div class='t2-production-results currentstats'>
	<table>
		<tr class="header1">
			<td style="text-align: left;"><div class='textCenter'><img src="images/items/57_64_12.png" width="16" height="16">Projected Requirements</div></td>
		</tr>
	</table>
</div>

<?
//Create the delete user dialog
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogload',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'autoOpen'=>false,
    ),
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>