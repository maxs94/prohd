<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/7_64_16.png" width="16" height="16">Top 10 Groups</div></td>
		<td style="text-align: right;">Volume</td>
		<td style="text-align: right; width: 80px;">30 Day Total</td>
		</tr>
		<?php
			$i=0;
			$topGroups = $this->getTopGroups();
			foreach ($topGroups as $item)
			{
				if ($i % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
				
				$name = $item['parentName1'];
				$profit = $item['totalProfit'];
				$volume = $item['totalVolume'];
				$marketGroupID = $item['marketGroupID'];
				
				$icon = $this->getMarketIcon($marketGroupID);
								
				echo '<td style="text-align: left;"><div class="textCenter"><img height="16" width="16" src="http://image.eveonline.com/Type/'.$icon.'">'.$name.'</div></td>';
				echo '<td style="text-align: right;">'.number_format($volume,0).'</td>';
				echo '<td style="text-align: right;"><font color="green">+'.number_format($profit,0).'</font></td>';
				echo "</tr>";
				$i++;
			}
		?>
		</table>
		</div>
		
		
		
		
		<div class="currentstats">
		<table>
		<tr class="header1">
		<td style="text-align: left;"><div class='textCenter'><img src="images/items/7_64_16.png" width="16" height="16">Top 10 Items</div></td>
		<td style="text-align: right;">Volume</td>
		<td style="text-align: right; width: 80px;">30 Day Total</td>
		</tr>
		<?php
			$i=0;
			$topItems = $this->getTopSales();
			foreach ($topItems as $item)
			{
				if ($i % 2)
					echo "<tr class='odd'>";
				else
					echo "<tr>";
				
				$name = $item['typeName'];
				$volume = $item['totalVolume'];
				$profit = $item['totalProfit'];
				$typeID = $item['typeID'];
				$icon = $this->getIcon($typeID);
				
				echo '<td><div class="textCenter"><img height="16" width="16" src="http://image.eveonline.com/Type/'.$icon.'"><a href="index.php?r=wallet/item&id='.$typeID.'">'.$name.'</a></div></td>';
				echo '<td style="text-align: right;">'.number_format($volume,0).'</td>';
				echo '<td style="text-align: right;"><font color="green">+'.number_format($profit,0).'</font></td>';
				echo "</tr>";
				$i++;
			}
		?>
		</table>
		</div>