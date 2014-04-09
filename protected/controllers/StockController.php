<?php

class StockController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/**
	* Specifies the stock groups as
	* @return array stock groups
	*/	
	public function stockGroups()
	{
		return array(
				'Ammo'=>array(
					'12773', //Barrage M
					'191',//Fusion M
					'193',// EMP M
					'21896', //Republic Fleet EMP M
					'12818',//Scorch L
					'238',//Antimatter L
					'231',//Iron L
					'230',//Antimatter M
					'199',//Fusion L
					'12765',//Tremor L
					'197',//Depleted Uranium L
					'201',//EMP L
					'21894',//Republic Fleet EMP L
					'21902',//Republic Fleet Fusion L
					'2629', //Scourge Fury Heavy Missile
					'27441',//Caldari Navy Trauma Heavy Missile
					'27345',//Caldari Navy Scourge Torpedo
					'30488',//Sisters Core Scanner Probe
					'27912',//Concussion Bomb
					'27920',//Electron Bomb
					'27916',//Scorch Bomb
					'27918',//Shrapnel Bomb
					'27924',//Void Bomb
					),
				'Drones'=>array(
					'2456',//Hobgoblin II
					'2185',//Hammerhead II
					'2488',//Warrior II
					'21640',//Valkyrie II
					'2444',//Ogre I
					'2446',//Ogre II
					),
				'Modules'=>array(
					'2048',//Damage Control II
					'3244',//Warp Disruptor II
					'448',//Warp Scrambler II
					'527',//Stasis Webifier II
					'3841',//Large Shield Extender II
					'2281',//Invulnerability Field II
					'1447',//Capacitor Power Relay II
					'2032',//Cap Recharger II
					'1999',//Tracking Enhancer II
					'519',//Gyrostabilizer II
					'10190',//Magnetic Field Stabilizer II
					'22291',//Ballistic Control System II
					'2605',//Nanofiber Internal Structure II
					'19806',//Target Painter II
					'13001',//Small Nosferatu II
					'16479',//Heavy Unstable Power Fluctuator I
					'1952',//Sensor Booster II
					'11577',//Improved Cloaking Device II
					'11578',//Covert Ops Cloaking Device II
					'17938',//Core Probe Launcher I
					'4258',//Core Probe Launcher II
					'22782',//Interdiction Sphere Launcher I
					'21096',//Cynosural Field Generator I
					'1319',//Expanded Cargohold II
					'4393',//Drone Damage Amplifier I
					'4405',//Drone Damage Amplifier II
					'4403',//Reactive Armor Hardener
					),
					
				'High Meta'=>array(
					'17559',//Federation Navy Stasis Webifier
					'15766',//Federation Navy 10MN Afterburner
					'31944',//Republic Fleet Target Painter
					'15681',//Caldari Navy Ballistic Control System
					'14059',//Shadow Serpentis Armor EM Hardener
					'14061',//Shadow Serpentis Armor Explosive Hardener
					'14063',//Shadow Serpentis Armor Kinetic Hardener
					'14065',//Shadow Serpentis Armor Thermic Hardener
					),	
					
				'Logistics Mods'=>array(
					'3608',//Large Shield Transporter II
					'8641',//Large S95a Partial Shield Transporter
					'16487',//Large 'Regard' Power Projector
					'16447',//Medium 'Solace' Remote Bulwark Reconstruction
					'26914',//Large Remote Armor Repair System II
					),
					
				'Guns'=>array(
					'2410', //Heavy Missile Launcher II
					'3057', //Mega Pulse Laser II
					'2913',//425mm AutoCannon II
					'2889',//200mm AutoCannon II
					'2897',//220mm Vulcan AutoCannon II
					'2929',//800mm Repeating Artillery II
					'2865',//1200mm Artillery Cannon II
					'2961',//1400mm Howitzer Artillery II
					),
				'POS Fuel'=>array(
					'16273', //Liquid Ozone
					'17887', //Oxygen Isotopes
					'16274', //Helium Isotopes
					'17889', //Hydrogen Isotopes
					'17888',//Nitrogen Isotopes
					'16272',//Heavy Water
					'16275',//Strontium Clathrates
					'44', //Enriched Uranium
					'3683', //Oxygen
					'3689', //Mechanical Parts
					'9832', //Coolant
					'9848', //Robotics
					),
				'Implant'=>array(
					'9943', //Cybernetic Subprocessor - Basic
					'9899', //Ocular Filter - Basic
					'9941', //Memory Augmentation - Basic
					'9942', //Neural Boost - Basic
					'9956', //Social Adaptation Chip - Basic
					'10221', //Cybernetic Subprocessor - Standard
					'10216', //Ocular Filter - Standard
					'10208', //Memory Augmentation - Standard
					'10212', //Neural Boost - Standard
					'10225', //Social Adaptation Chip - Standard
					'13237',//Hardwiring - Eifyr and Co. 'Rogue' CY-1
					'13240',//Hardwiring - Eifyr and Co. 'Rogue' AY-1
					),
				'BC'=>array(
					'24696', //Harbinger
					'24698', //Drake
					'16229', //Brutix
					'16231', //Cyclone
					'24702', //Hurricane
					),
				'BC Tier3'=>array(
					'4302', //Oracle
					'4308', //Talos
					'4306', //Naga
					'4310', //Tornado
					),						
				'HAC'=>array(
					'12003', //Zealot
					'12005', //Ishtar
					'11993', //Cerberus
					'11999', //Vagabond
					'12015'//Muninn
					),
				'Logistics'=>array(
					'11987', //Guardian
					'11985', //Basilisk
					'11978', //Scimitar
					'11989', //Oneiros
					),	
				'Recon'=>array(
					'11959', //Rook
					'11957', //Falcon
					'20125', //Curse
					'11965', //Pilgrim
					),	
				'Covert Ops'=>array(
					'11192', //Buzzard
					'12032', //Manticore						
					'11188', //Anathema
					'12038', //Purifier
					'11182', //Cheetah
					'12034', //Hound
					'11172', //Helios
					'11377', //Nemesis
					),
				'Blockade Runner'=>array(
					'12743', //Viator
					'12729', //Crane
					'12733', //Prorator
					'12735', //Prowler
					),
				'Deep Space Transport'=>array(
					'12745', //Occator
					'12731', //Bustard
					'12747', //Mastodon
					'12753', //Impel
					),
				'Tech1 Industrial'=>array(	
					'657',//Iteron Mark V
					'649',//Badger Mark II
					'652',//Mammoth
					'1944',//Bestower
					'2998',//Noctis
					'17480',//Procurer
					'17478',//Retriever
					'17476',//Covetor
					),
				'Tech2 Industrial'=>array(	
					'22546',//Skiff
					'22548',//Mackinaw
					'22544',//Hulk
					),										
				'AF'=>array(
					'11393',//Retribution
					'11365',//Vengeance
					'11400',//Jaguar
					'11371',//Wolf
					'11381',//Harpy
					'11379',//Hawk
					'12044',//Enyo
					'12042',//Ishkur
					),
				'Command'=>array(
					'22448',//Absolution
					'22470',//Nighthawk
					'22444',//Sleipnir
					),					
				'Interceptor'=>array(
					'11184',//Crusador
					'11186',//Malediction
					'11176',//Crow
					'11178',//Raptor
					'11202',//Ares
					'11200',//Taranis
					'11196',//Claw
					'11198',//Stiletto
					),
				'Pirate'=>array(
					'17932', //Dramiel
					'17928',//Daredevil
					'17720', //Cynabal
					'17738', //Machariel
					'17926',//Cruor
					'17922',//Ashimmu
					),
				'Rig'=>array(
					'25894', //Large Trimark Armor Pump I
					'25948', //Large Capacitor Control Circuit I
					'26088',//Large Core Defence Field Extender I
					'31055',//Medium Trimark Armor Pump I
					'31372',//Medium Capacitor Control Circuit I
					'31790',//Medium Core Defence Field Extender I
					'31360',//Medium Ancillary Current Router I
					'31119', //Medium Cargohold Optimization I
					'31155', //Medium Low Friction Nozzle Joints I
					'31153', //Small Low Friction Nozzle Joints I
					'31213',//Small Gravity Capacitor Upgrade I
					),
				'PVP Armor'=>array(
					'11269', //Energized Adaptive Nano Membrane II
					'11642', //Armor EM Hardener II
					'11646', //Armor Explosive Hardener II
					'11644', //Armor Kinetic Hardener II
					'11648', //Armor Thermic Hardener II
					),
				'Propulsion'=>array(
					'5975', //Y-T8 Overcharged Hydrocarbon I Microwarpdrive
					'6005', //Y-S8 Hydrocarbon I Afterburners
					'12076', //10MN MicroWarpdrive II
					'440', //1MN MicroWarpdrive II
					'12058', //10MN Afterburner II
					'438', //1MN Afterburner II
					),
				'Capital'=>array(
					'3616', //Capital Shield Transporter I
					'24569', //Capital Remote Armor Repair System I
					'12219', //Capital Energy Transfer Array I
					'20701',//Capital Armor Repairer I
					'20703',//Capital Shield Booster I
					'27951',//Triage Module I
					'20280',//Siege Module I
					),
				'BS'=>array(
					'24692', //Abaddon
					'642', //Apocalypse
					'643', //Armageddon
					'638', //Raven
					'24688', //Rokh
					'640', //Scorpion
					'645', //Dominix
					'24690', //Hyperion
					'641', //Megathron
					'24694', //Maelstrom
					'639', //Tempest
					'644', //Typhoon
					),
				'Heavy Interdictors'=>array(
					'12017', //Devoter
					'11995', //Onyx
					'12021', //Phobos
					'12013', //Broadsword
					),
				'Interdictors'=>array(
					'22452', //Heretic
					'22464', //Flycatcher
					'22460', //Eris
					'22456', //Sabre
					),
				'Cerriers'=>array(
					'23757', //Archon
					'23915', //Chimera
					'23911', //Thanatos
					'24483', //Nid
					),	
					
				'Tech3 Hulls'=>array(
					'29984', //Tengu
					'29990', //Loki
					'29988', //Proteus
					'29986', //Legion
					),	
				'Tech3 Subsystems'=>array(	
					'29964',
					'29965',
					'29966',
					'29967',
					'29969',
					'29970',
					'29971',
					'29972',
					'29974',
					'29975',
					'29976',
					'29977',
					'29979',
					'29980',
					'29981',
					'29982',
					'30036',
					'30038',
					'30040',
					'30042',
					'30046',
					'30048',
					'30050',
					'30052',
					'30056',
					'30058',
					'30060',
					'30062',
					'30066',
					'30068',
					'30070',
					'30072',
					'30117',
					'30118',
					'30119',
					'30120',
					'30122',
					'30123',
					'30124',
					'30125',
					'30127',
					'30128',
					'30129',
					'30130',
					'30132',
					'30133',
					'30134',
					'30135',
					'30076',
					'30078',
					'30080',
					'30082',
					'30086',
					'30088',
					'30090',
					'30092',
					'30096',
					'30098',
					'30100',
					'30102',
					'30106',
					'30108',
					'30110',
					'30112',
					'30139',
					'30141',
					'30143',
					'30145',
					'30149',
					'30151',
					'30153',
					'30155',
					'30159',
					'30161',
					'30163',
					'30165',
					'30169',
					'30171',
					'30173',
					'30175',
					),	
				'Skillbooks'=>array(
					'3339', //Amarr Battleship
					'3338', //Caldari Battleship
					'3336',//Gallente Battleship
					'3337',//Minmatar Battleship
					'3335',//Amarr Cruiser
					'3334',//Caldari Cruiser
					'3332',//Gallente Cruiser
					'3333',//Minmatar Cruiser
					'3343',//Amarr Industrial
					'3342',//Caldari Industrial
					'3340',//Gallente Industrial
					'3341',//Minmatar Industrial
					'12099',//Battlecruisers
					'20211',//Heavy Missile Specialization
					'3422',//Shield Emission Systems
					'2403',//Advanced Planetology
					'2495',//Interplanetary Consolidation
					'2406',//Planetology
					'13279',//Remote Sensing
					'28073',//Bomb Deployment
					),					
		);
	}
	
	public function getProfitDetails($typeID)
	{
		$eveDate = $this->getEveTimeSql();
		
		$sql = ('SELECT typeID, typeName, sum( profit ) AS totalProfit, sum( quantity ) AS totalVolume
				FROM wallet
				WHERE DATE( transactionDateTime ) > DATE_SUB( DATE( :eveDate ), INTERVAL 600
				DAY )
				AND personal = 0
				AND transactionType = "sell"
				AND typeID = :typeID
				GROUP BY typeID
				ORDER BY totalProfit DESC
				LIMIT 500');
				
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":eveDate",$eveDate,PDO::PARAM_STR);
		$command->bindParam(":typeID",$typeID,PDO::PARAM_STR);
		
		$results=$command->query();

		return $results;
		
		/*
		SELECT typeID, typeName, sum( profit ) AS totalProfit, sum(quantity) as totalVolume
		FROM `wallet`
		WHERE DATE( transactionDateTime ) > DATE_SUB( '2010-12-07', INTERVAL 30
		DAY )
		AND personal =0
		AND transactionType = "sell"
		GROUP BY typeID
		ORDER BY totalProfit DESC
		LIMIT 0 , 30
		*/
	}
	
	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->userLevel > 0',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function getStock()
	{
	
		$criteria = new CDbCriteria;
		$criteria->condition = ('transactionType = "buy" AND characterID = 0 AND stationID = 60003760');
		$criteria->order = 'typeName ASC';
		
		$purchases = Wallet::Model()->findAll($criteria);
		
		foreach ($purchases as $purchase)
		{
			$boughtStock[$purchase->typeID] = $boughtStock[$purchase->typeID] + $purchase->quantity;
		}
		
		$criteria->condition = ('transactionType = "sell" AND ( characterID = 1 OR characterID = 2 )');
		$sales = Wallet::Model()->findAll($criteria);
		
		foreach ($sales as $sale)
		{
			$boughtStock[$sale->typeID] = $boughtStock[$sale->typeID] - $sale->quantity;
		}
		
		return $boughtStock;
	}
	
	public function lastJitaPrice($typeID)
	{
		//Get the last Jita buy price
		$criteria = new CDbCriteria;
		$criteria->condition = ('typeID=:typeID AND characterID = 0 AND stationID = 60003760 AND transactionType = "buy"');
		$criteria->params = array(':typeID'=>$typeID);
		$criteria->order = 'transactionDateTime DESC';
		
		//Run the query
		$lastJita = Wallet::Model()->find($criteria);
		
		return $lastJita->price;
	}
	
	public function lastSalePrice($typeID)
	{
		//Get the last sale price
		$criteria = new CDbCriteria;
		$criteria->condition = ('typeID=:typeID AND transactionType = "sell"');
		$criteria->params = array(':typeID'=>$typeID);
		$criteria->order = 'transactionDateTime DESC';
	
		//Run query
		$lastSale = Wallet::Model()->find($criteria);
		
		return $lastSale->price;
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}