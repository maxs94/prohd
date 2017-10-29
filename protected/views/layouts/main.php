<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="shortcut icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico">
	
	<? Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/prohd.base.js'); ?>
	<? Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.gritter.js'); ?>
        <? Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/raphael-min.js'); ?>
        <? Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Arial_400.font.js'); ?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.gritter.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
		
<div class="container" id="page">

	<div id="header">
	<!-- header image code removed here -->
	</div><!-- header -->
	<div class="topmenu">
		<?php 
		
			//Get current controller and action for url
			$curpage = Yii::app()->getController()->getAction()->controller->id;
			$curpage .= '/'.Yii::app()->getController()->getAction()->controller->action->id;

			//Get tracking groups
			$groups = TrackingGroups::Model()->findAll();
			foreach($groups as $group)
			{
				$filterMenu[] = array(
					'label'=>$group->name,
					'url'=>array($curpage . "&tgid=" . $group->trackingGroupID),
				);
			}
			
			$filterMenu1 = array(
				array(
					'label'=>'transactions',
					'url'=>array('wallet/index'),
					),
				array(
					'label'=>'sell orders',
					'url'=>array('sellOrders/index'),
					),	
				array(
					'label'=>'buy orders',
					'url'=>array('buyOrders/index'),
					),				
				array(
					'label'=>'stock',
					'url'=>array('stock/index'),
					),
				array(
					'label'=>'movers',
					'url'=>array('movers/index'),
					),
				array(
					'label'=>'m3 profit',
					'url'=>array('m3Profit/index'),
					),
				array(	
					'label'=>'assets',
					'url'=>array('assets/index'),
					),
				array(	
					'label'=>'characters',
					'url'=>array('characters/index'),
					),
				array(	
					'label'=>'blueprints',
					'url'=>array('blueprints/index'),
					),
				);
	
			$filterMenu2 = array(
				array(
					'label'=>'transactions',
					'url'=>array('corpWallet/index'),
					),
				array(	
					'label'=>'jobs',
					'url'=>array('industryJobs/index'),
					),
				array(	
					'label'=>'pi',
					'url'=>array('pi/index'),
					),
				array(	
					'label'=>'assets',
					'url'=>array('corpAssets/index'),
					),
				array(	
					'label'=>'pos',
					'url'=>array('pos/index'),
					),
				array(	
					'label'=>'bpc stock',
					'url'=>array('bpcStock/index'),
					),				
				);
			$filterMenu3 = array(
				array(	
					'label'=>'capital',
					'url'=>array('capitalProduction/index'),
					),
				array(	
					'label'=>'subcapital',
					'url'=>array('subcapitalProduction/index'),
					),
				array(	
					'label'=>'t2',
					'url'=>array('t2Production/index'),
					),
				array(	
					'label'=>'invention',
					'url'=>array('invention/index'),
					),
				array(	
					'label'=>'invention stats',
					'url'=>array('inventionStats/index'),
					),
				array(	
					'label'=>'minerals',
					'url'=>array('minerals/index'),
					),
				array(	
					'label'=>'moon ships',
					'url'=>array('moonShips/index'),
					),					
				);	
			
			$this->widget('application.extensions.CDropDownMenu',array(
			'items'=>array(
				array('label'=>'overview', 'url'=>array('mainPage/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'personal', 'url'=>array('#'), 'visible'=>!Yii::app()->user->isGuest, 'items'=>$filterMenu1),
				array('label'=>'corp', 'url'=>array('#'), 'visible'=>!Yii::app()->user->isGuest, 'items'=>$filterMenu2),
				array('label'=>'production', 'url'=>array('#'), 'visible'=>!Yii::app()->user->isGuest, 'items'=>$filterMenu3),
				array('label'=>'reports', 'url'=>array('reports/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'switch group', 'url'=>array('#'), 'visible'=>!Yii::app()->user->isGuest, 'items'=>$filterMenu),
				array('label'=>'admin', 'url'=>array('admin/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
			),
		));
		echo "<div class='evetime'>".date('H:i n/j', strtotime("+4 hour")).' EVE</div>';
		?>
		</div>
		<div style="clear: both;"></div>
		<!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> PROHD. All Rights Reserved. Fork by <a href="https://github.com/maxs94/prohd/" target="_blank">maxs94</a>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>