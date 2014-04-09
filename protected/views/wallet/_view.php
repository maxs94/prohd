<?php
	
	//Total price/sale
	$total = $data->price * $data->quantity;
	
	//Select a color for buy or sell
	if ($data->transactionType == "sell")
	{
		$color = "#ecf5fa";
	}
	else
	{
		$color = "#fff5eb";
	}
	
	$icon = $this->getIcon($data->typeID);
	
	//Personal?
	if ($data->personal)
	{
		$folderImage = "images/folder-bookmark.png";
	}
	else
	{
		$folderImage = "images/folder.png";
	}
	
	$pages = $widget->dataProvider->getPagination();
	$currentPage = $pages->getCurrentPage() + 1;
	
	//$metaOverlay = $this->getMetaOverlay($data->typeID);
	
	//if (!($metaOverlay == '0'))
	//{
		//$metaIconPath = "./images/meta/" . $metaOverlay;
	//}
	//else
	//{
		//$metaIconPath = "";
	//}
	
?>

<div class="view">
	<table style="background-color: <?php echo $color; ?>; border-collapse:collapse;">
		<col width="20">
		<col width="380">
		<col width="160">
		<col width="130">
		<col width="20">
		<tr>
			<td><a href="index.php?r=wallet/view&id=<?php echo $data->transactionID; ?>">
			<img style="height: 32px; width: 32px;" src="http://image.eveonline.com/Type/<?php echo $icon; ?>">
			</a></td>
			
			<td style="text-align: left;">
			<?php echo CHtml::encode(number_format($data->quantity)); ?> x <?php echo CHtml::link(CHtml::encode($data->typeName), array('item', 'id'=>$data->typeID)); ?> at <?php $dateTime = date('m-d H:i',strtotime($data->transactionDateTime)); echo $dateTime; ?>
			<BR>
			<?php echo CHtml::link(CHtml::encode($data->stationName), array('station', 'id'=>$data->stationID)); ?>
			</td>
			
			<td style="text-align: right;">
			<b>Price </b><?php echo number_format($data->price,2); ?>
			<BR>
			<b>Total </b><?php echo number_format($total,2);?></font>
			</td>
			
			<td style="text-align: right;">
			<?php echo $data->clientName; ?>
			<BR>
			<font color="<?php echo $this->numToColor($data->profit);?>">+<?php echo number_format($data->profit,2);?></font>
			</td>
			
			<td>
			<a href="index.php?r=wallet/personal&page=<?php echo $currentPage; ?>&id=<?php echo $data->transactionID; ?>"><img src="<?php echo $folderImage ?>"></a>
			</td>
			
		</tr>
	</table>
</div>