-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2012 at 07:04 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prohd`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `accountID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` char(255) CHARACTER SET latin1 NOT NULL,
  `password` char(255) CHARACTER SET latin1 NOT NULL,
  `salt` char(10) CHARACTER SET latin1 NOT NULL,
  `userLevel` int(11) NOT NULL DEFAULT '0',
  `trackingGroupID` int(11) NOT NULL DEFAULT '0',
  `fullName` char(255) NOT NULL,
  PRIMARY KEY (`accountID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `apiStatus`
--

CREATE TABLE IF NOT EXISTS `apiStatus` (
  `apiID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`apiID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `characterID` int(11) NOT NULL,
  `itemID` double NOT NULL AUTO_INCREMENT,
  `locationID` bigint(20) DEFAULT '0',
  `typeID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `flag` int(11) DEFAULT '0',
  `singleton` tinyint(1) NOT NULL,
  `containerID` bigint(20) DEFAULT '0',
  `locationName` char(255) DEFAULT NULL,
  `typeName` char(255) DEFAULT NULL,
  `groupID` int(11) NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `locationID` (`locationID`),
  KEY `typeID` (`typeID`),
  KEY `characterID` (`characterID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1008107064483 ;

-- --------------------------------------------------------

--
-- Table structure for table `assetValues`
--

CREATE TABLE IF NOT EXISTS `assetValues` (
  `typeID` int(11) NOT NULL,
  `value` double NOT NULL,
  `lastUpdated` datetime NOT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE IF NOT EXISTS `balances` (
  `balanceID` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `balanceDateTime` datetime NOT NULL,
  `balance` double NOT NULL,
  PRIMARY KEY (`balanceID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=137181 ;

-- --------------------------------------------------------

--
-- Table structure for table `blueprints`
--

CREATE TABLE IF NOT EXISTS `blueprints` (
  `primaryID` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` double NOT NULL,
  `blueprintID` int(11) NOT NULL,
  `typeID` int(11) NOT NULL,
  `meLevel` int(11) NOT NULL,
  `peLevel` int(11) NOT NULL,
  `characterID` int(11) NOT NULL,
  `solarSystemID` bigint(20) NOT NULL,
  `npcPrice` bigint(20) NOT NULL,
  `value` bigint(20) NOT NULL,
  PRIMARY KEY (`primaryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=698 ;

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `walletID` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `characterName` char(255) CHARACTER SET latin1 NOT NULL,
  `keyID` int(11) NOT NULL,
  `vCode` char(64) CHARACTER SET latin1 NOT NULL,
  `accountID` int(11) NOT NULL,
  `limitUpdate` tinyint(1) NOT NULL DEFAULT '0',
  `limitDate` date DEFAULT NULL,
  `displayBalance` tinyint(1) NOT NULL DEFAULT '0',
  `walletEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `journalEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `ordersEnabled` tinyint(1) NOT NULL DEFAULT '0',
  `displayOrders` tinyint(1) NOT NULL DEFAULT '0',
  `isCorpKey` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`walletID`),
  KEY `characterID` (`characterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `conqStations`
--

CREATE TABLE IF NOT EXISTS `conqStations` (
  `stationID` bigint(20) NOT NULL,
  `stationName` char(255) NOT NULL,
  `stationTypeID` int(11) NOT NULL,
  `solarSystemID` int(11) NOT NULL,
  `corporationID` bigint(20) NOT NULL,
  `corporationName` char(255) NOT NULL,
  PRIMARY KEY (`stationID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `corpAssets`
--

CREATE TABLE IF NOT EXISTS `corpAssets` (
  `characterID` int(11) NOT NULL,
  `itemID` bigint(20) NOT NULL AUTO_INCREMENT,
  `locationID` bigint(20) DEFAULT '0',
  `typeID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `flag` int(11) DEFAULT '0',
  `singleton` tinyint(1) NOT NULL,
  `containerID` bigint(20) DEFAULT '0',
  `locationName` char(255) DEFAULT NULL,
  `typeName` char(255) DEFAULT NULL,
  `groupID` int(11) NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `locationID` (`locationID`),
  KEY `typeID` (`typeID`),
  KEY `characterID` (`characterID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1008130572031 ;

-- --------------------------------------------------------

--
-- Table structure for table `dgmAttributeTypes`
--

CREATE TABLE IF NOT EXISTS `dgmAttributeTypes` (
  `attributeID` smallint(6) NOT NULL,
  `attributeName` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `iconID` smallint(6) DEFAULT NULL,
  `defaultValue` double DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `displayName` varchar(100) DEFAULT NULL,
  `unitID` tinyint(3) unsigned DEFAULT NULL,
  `stackable` tinyint(1) DEFAULT NULL,
  `highIsGood` tinyint(1) DEFAULT NULL,
  `categoryID` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`attributeID`),
  KEY `categoryID` (`categoryID`),
  KEY `unitID` (`unitID`),
  KEY `iconID` (`iconID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dgmTypeAttributes`
--

CREATE TABLE IF NOT EXISTS `dgmTypeAttributes` (
  `typeID` int(11) NOT NULL,
  `attributeID` smallint(6) NOT NULL,
  `valueInt` int(11) DEFAULT NULL,
  `valueFloat` double DEFAULT NULL,
  PRIMARY KEY (`typeID`,`attributeID`),
  KEY `attributeID` (`attributeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eveGraphics`
--

CREATE TABLE IF NOT EXISTS `eveGraphics` (
  `graphicID` smallint(6) NOT NULL DEFAULT '0',
  `graphicFile` varchar(500) NOT NULL,
  `description` varchar(16000) NOT NULL,
  `obsolete` tinyint(1) NOT NULL,
  `graphicType` varchar(100) DEFAULT NULL,
  `collidable` tinyint(1) DEFAULT NULL,
  `explosionID` smallint(6) DEFAULT NULL,
  `directoryID` int(11) DEFAULT NULL,
  `graphicName` varchar(64) NOT NULL,
  PRIMARY KEY (`graphicID`),
  KEY `explosionID` (`explosionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eveIcons`
--

CREATE TABLE IF NOT EXISTS `eveIcons` (
  `iconID` smallint(6) NOT NULL DEFAULT '0',
  `iconFile` varchar(500) NOT NULL,
  `description` varchar(16000) NOT NULL,
  PRIMARY KEY (`iconID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eveUnits`
--

CREATE TABLE IF NOT EXISTS `eveUnits` (
  `unitID` tinyint(3) unsigned NOT NULL,
  `unitName` varchar(100) DEFAULT NULL,
  `displayName` varchar(20) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`unitID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `industryJobs`
--

CREATE TABLE IF NOT EXISTS `industryJobs` (
  `jobID` int(11) NOT NULL,
  `assemblyLineID` int(11) NOT NULL,
  `containerID` int(11) NOT NULL,
  `installedItemID` bigint(20) NOT NULL,
  `installedItemLocationID` int(11) NOT NULL,
  `installedItemQuantity` int(11) NOT NULL,
  `installedItemProductivityLevel` int(11) NOT NULL,
  `installedItemMaterialLevel` int(11) NOT NULL,
  `installedItemLicensedProductionRunsRemaining` int(11) NOT NULL,
  `outputLocationID` int(11) NOT NULL,
  `installerID` int(11) NOT NULL,
  `runs` int(11) NOT NULL,
  `licensedProductionRuns` int(11) NOT NULL,
  `installedInSolarSystemID` int(11) NOT NULL,
  `containerLocationID` int(11) NOT NULL,
  `materialMultiplier` float NOT NULL,
  `charMaterialMultiplier` float NOT NULL,
  `timeMultiplier` float NOT NULL,
  `charTimeMultiplier` float NOT NULL,
  `installedItemTypeID` int(11) NOT NULL,
  `outputTypeID` int(11) NOT NULL,
  `containerTypeID` int(11) NOT NULL,
  `installedItemCopy` int(11) NOT NULL,
  `completed` int(11) NOT NULL,
  `completedSuccessfully` int(11) NOT NULL,
  `installedItemFlag` int(11) NOT NULL,
  `activityID` int(11) NOT NULL,
  `completedStatus` int(11) NOT NULL,
  `installTime` datetime NOT NULL,
  `outputFlag` int(11) NOT NULL,
  `beginProductionTime` datetime NOT NULL,
  `endProductionTime` datetime NOT NULL,
  `pauseProductionTime` datetime NOT NULL,
  PRIMARY KEY (`jobID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invBlueprintTypes`
--

CREATE TABLE IF NOT EXISTS `invBlueprintTypes` (
  `blueprintTypeID` int(11) NOT NULL,
  `parentBlueprintTypeID` int(11) DEFAULT NULL,
  `productTypeID` int(11) DEFAULT NULL,
  `productionTime` int(11) DEFAULT NULL,
  `techLevel` smallint(6) DEFAULT NULL,
  `researchProductivityTime` int(11) DEFAULT NULL,
  `researchMaterialTime` int(11) DEFAULT NULL,
  `researchCopyTime` int(11) DEFAULT NULL,
  `researchTechTime` int(11) DEFAULT NULL,
  `productivityModifier` int(11) DEFAULT NULL,
  `materialModifier` smallint(6) DEFAULT NULL,
  `wasteFactor` smallint(6) DEFAULT NULL,
  `maxProductionLimit` int(11) DEFAULT NULL,
  PRIMARY KEY (`blueprintTypeID`),
  KEY `parentBlueprintTypeID` (`parentBlueprintTypeID`),
  KEY `productTypeID` (`productTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invCategories`
--

CREATE TABLE IF NOT EXISTS `invCategories` (
  `categoryID` tinyint(3) unsigned NOT NULL,
  `categoryName` varchar(100) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `iconID` smallint(6) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`categoryID`),
  KEY `iconID` (`iconID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `transactionDateTime` datetime NOT NULL,
  `transactionID` bigint(20) unsigned NOT NULL,
  `quantity` bigint(20) unsigned NOT NULL,
  `remaining` bigint(20) NOT NULL,
  `typeName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `typeID` int(11) NOT NULL,
  `price` double unsigned NOT NULL,
  `clientID` bigint(20) unsigned NOT NULL,
  `clientName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `characterID` int(11) NOT NULL,
  `stationID` bigint(20) unsigned NOT NULL,
  `stationName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `personal` tinyint(1) NOT NULL,
  PRIMARY KEY (`transactionID`),
  KEY `characterID` (`characterID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventoryLog`
--

CREATE TABLE IF NOT EXISTS `inventoryLog` (
  `logID` bigint(20) NOT NULL AUTO_INCREMENT,
  `sourceTransactionID` bigint(20) NOT NULL,
  `targetTransactionID` bigint(20) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  PRIMARY KEY (`logID`),
  KEY `sourceTransactionID` (`sourceTransactionID`,`targetTransactionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31520 ;

-- --------------------------------------------------------

--
-- Table structure for table `invGroups`
--

CREATE TABLE IF NOT EXISTS `invGroups` (
  `groupID` smallint(6) NOT NULL,
  `categoryID` tinyint(3) unsigned DEFAULT NULL,
  `groupName` varchar(100) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `iconID` smallint(6) DEFAULT NULL,
  `useBasePrice` tinyint(1) DEFAULT NULL,
  `allowManufacture` tinyint(1) DEFAULT NULL,
  `allowRecycler` tinyint(1) DEFAULT NULL,
  `anchored` tinyint(1) DEFAULT NULL,
  `anchorable` tinyint(1) DEFAULT NULL,
  `fittableNonSingleton` tinyint(1) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`groupID`),
  KEY `invGroups_IX_category` (`categoryID`),
  KEY `iconID` (`iconID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invMarketGroups`
--

CREATE TABLE IF NOT EXISTS `invMarketGroups` (
  `marketGroupID` int(11) NOT NULL,
  `parentGroupID` int(11) DEFAULT NULL,
  `marketGroupName` varchar(100) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `iconID` smallint(6) DEFAULT NULL,
  `hasTypes` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`marketGroupID`),
  KEY `parentGroupID` (`parentGroupID`),
  KEY `iconID` (`iconID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invMetaGroups`
--

CREATE TABLE IF NOT EXISTS `invMetaGroups` (
  `metaGroupID` smallint(6) NOT NULL,
  `metaGroupName` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `iconID` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`metaGroupID`),
  KEY `iconID` (`iconID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invMetaTypes`
--

CREATE TABLE IF NOT EXISTS `invMetaTypes` (
  `typeID` int(10) NOT NULL,
  `parentTypeID` int(10) DEFAULT NULL,
  `metaGroupID` smallint(5) DEFAULT NULL,
  PRIMARY KEY (`typeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invNames`
--

CREATE TABLE IF NOT EXISTS `invNames` (
  `itemID` bigint(19) NOT NULL,
  `itemName` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invTypeMaterials`
--

CREATE TABLE IF NOT EXISTS `invTypeMaterials` (
  `typeID` int(11) NOT NULL,
  `materialTypeID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`typeID`,`materialTypeID`),
  KEY `materialTypeID` (`materialTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invTypes`
--

CREATE TABLE IF NOT EXISTS `invTypes` (
  `typeID` int(10) NOT NULL,
  `groupID` int(10) DEFAULT NULL,
  `typeName` varchar(100) DEFAULT NULL,
  `description` varchar(3000) DEFAULT NULL,
  `mass` double DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `capacity` double DEFAULT NULL,
  `portionSize` int(10) DEFAULT NULL,
  `raceID` int(11) DEFAULT NULL,
  `basePrice` decimal(19,4) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `marketGroupID` int(10) DEFAULT NULL,
  `chanceOfDuplicating` double DEFAULT NULL,
  `iconID` int(10) DEFAULT NULL,
  PRIMARY KEY (`typeID`),
  KEY `invTypes_IX_Group` (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `date` datetime NOT NULL,
  `refID` bigint(20) unsigned NOT NULL,
  `refTypeID` int(10) unsigned NOT NULL,
  `ownerName1` varchar(255) NOT NULL,
  `ownerID1` int(10) unsigned NOT NULL,
  `ownerName2` varchar(255) NOT NULL,
  `ownerID2` int(10) unsigned NOT NULL,
  `argName1` varchar(255) NOT NULL,
  `argID1` int(10) unsigned NOT NULL,
  `characterID` int(11) NOT NULL,
  `amount` double NOT NULL,
  `balance` double NOT NULL,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`date`,`refID`),
  KEY `characterID` (`characterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapDenormalize`
--

CREATE TABLE IF NOT EXISTS `mapDenormalize` (
  `itemID` int(11) NOT NULL,
  `typeID` int(11) DEFAULT NULL,
  `groupID` smallint(6) DEFAULT NULL,
  `solarSystemID` int(11) DEFAULT NULL,
  `constellationID` int(11) DEFAULT NULL,
  `regionID` int(11) DEFAULT NULL,
  `orbitID` int(11) DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `radius` double DEFAULT NULL,
  `itemName` varchar(100) DEFAULT NULL,
  `security` double DEFAULT NULL,
  `celestialIndex` tinyint(4) DEFAULT NULL,
  `orbitIndex` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  KEY `mapDenormalize_IX_constellation` (`constellationID`),
  KEY `mapDenormalize_IX_groupConstellation` (`groupID`,`constellationID`),
  KEY `mapDenormalize_IX_groupRegion` (`groupID`,`regionID`),
  KEY `mapDenormalize_IX_groupSystem` (`groupID`,`solarSystemID`),
  KEY `mapDenormalize_IX_orbit` (`orbitID`),
  KEY `mapDenormalize_IX_region` (`regionID`),
  KEY `mapDenormalize_IX_system` (`solarSystemID`),
  KEY `typeID` (`typeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mapRegions`
--

CREATE TABLE IF NOT EXISTS `mapRegions` (
  `regionID` int(11) NOT NULL,
  `regionName` varchar(100) DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `xMin` double DEFAULT NULL,
  `xMax` double DEFAULT NULL,
  `yMin` double DEFAULT NULL,
  `yMax` double DEFAULT NULL,
  `zMin` double DEFAULT NULL,
  `zMax` double DEFAULT NULL,
  `factionID` int(11) DEFAULT NULL,
  `radius` double DEFAULT NULL,
  PRIMARY KEY (`regionID`),
  KEY `factionID` (`factionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mapSolarSystems`
--

CREATE TABLE IF NOT EXISTS `mapSolarSystems` (
  `regionID` int(11) DEFAULT NULL,
  `constellationID` int(11) DEFAULT NULL,
  `solarSystemID` int(11) NOT NULL,
  `solarSystemName` varchar(100) DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `xMin` double DEFAULT NULL,
  `xMax` double DEFAULT NULL,
  `yMin` double DEFAULT NULL,
  `yMax` double DEFAULT NULL,
  `zMin` double DEFAULT NULL,
  `zMax` double DEFAULT NULL,
  `luminosity` double DEFAULT NULL,
  `border` tinyint(1) DEFAULT NULL,
  `fringe` tinyint(1) DEFAULT NULL,
  `corridor` tinyint(1) DEFAULT NULL,
  `hub` tinyint(1) DEFAULT NULL,
  `international` tinyint(1) DEFAULT NULL,
  `regional` tinyint(1) DEFAULT NULL,
  `constellation` tinyint(1) DEFAULT NULL,
  `security` double DEFAULT NULL,
  `factionID` int(11) DEFAULT NULL,
  `radius` double DEFAULT NULL,
  `sunTypeID` int(11) DEFAULT NULL,
  `securityClass` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`solarSystemID`),
  UNIQUE KEY `solarSystemID` (`solarSystemID`,`constellationID`,`regionID`),
  KEY `mapSolarSystems_IX_constellation` (`constellationID`),
  KEY `mapSolarSystems_IX_region` (`regionID`),
  KEY `mapSolarSystems_IX_security` (`security`),
  KEY `factionID` (`factionID`),
  KEY `sunTypeID` (`sunTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `marketlogs`
--

CREATE TABLE IF NOT EXISTS `marketlogs` (
  `price` double NOT NULL,
  `volremaining` int(11) NOT NULL,
  `typeID` int(11) NOT NULL,
  `range` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `volEntered` int(11) NOT NULL,
  `minVolume` int(11) NOT NULL,
  `bid` tinyint(1) NOT NULL,
  `issued` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `stationID` int(11) NOT NULL,
  `regionID` int(11) NOT NULL,
  `solarSystemID` int(11) NOT NULL,
  `jumps` int(11) NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `typeID` (`typeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderID` double NOT NULL,
  `charID` int(11) NOT NULL,
  `stationID` int(11) NOT NULL,
  `volEntered` int(11) NOT NULL,
  `volRemaining` int(11) NOT NULL,
  `minVolume` int(11) NOT NULL,
  `orderState` int(11) NOT NULL,
  `typeID` smallint(6) NOT NULL,
  `range` int(11) NOT NULL,
  `accountKey` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `escrow` decimal(10,0) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `bid` tinyint(1) NOT NULL,
  `issued` datetime NOT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pi`
--

CREATE TABLE IF NOT EXISTS `pi` (
  `characterID` int(11) NOT NULL,
  `moonID` int(11) NOT NULL,
  `typeID` int(11) NOT NULL,
  `processorTypeID` int(11) NOT NULL,
  `processorCount` int(11) NOT NULL,
  `averageOutput` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `planetSchematicsTypeMap`
--

CREATE TABLE IF NOT EXISTS `planetSchematicsTypeMap` (
  `schematicID` smallint(5) NOT NULL,
  `typeID` int(10) NOT NULL,
  `quantity` smallint(5) DEFAULT NULL,
  `isInput` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`schematicID`,`typeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `productionSystems`
--

CREATE TABLE IF NOT EXISTS `productionSystems` (
  `productionSystemID` int(11) NOT NULL AUTO_INCREMENT,
  `trackingGroupID` int(11) NOT NULL,
  `solarSystemID` int(11) NOT NULL,
  PRIMARY KEY (`productionSystemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projectMaterials`
--

CREATE TABLE IF NOT EXISTS `projectMaterials` (
  `materialID` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) NOT NULL,
  `typeID` int(11) NOT NULL,
  `required` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `isMineral` tinyint(1) NOT NULL,
  PRIMARY KEY (`materialID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `typeID` int(11) NOT NULL,
  `stationID` int(11) NOT NULL,
  `characterID` int(11) NOT NULL,
  `projectName` char(255) NOT NULL,
  `creationDateTime` datetime NOT NULL,
  PRIMARY KEY (`projectID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ramTypeRequirements`
--

CREATE TABLE IF NOT EXISTS `ramTypeRequirements` (
  `typeID` int(10) NOT NULL,
  `activityID` tinyint(3) NOT NULL,
  `requiredTypeID` int(10) NOT NULL,
  `quantity` int(10) DEFAULT NULL,
  `damagePerJob` double DEFAULT NULL,
  `recycle` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`typeID`,`activityID`,`requiredTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staStations`
--

CREATE TABLE IF NOT EXISTS `staStations` (
  `stationID` int(11) NOT NULL,
  `security` smallint(6) DEFAULT NULL,
  `dockingCostPerVolume` double DEFAULT NULL,
  `maxShipVolumeDockable` double DEFAULT NULL,
  `officeRentalCost` int(11) DEFAULT NULL,
  `operationID` tinyint(3) unsigned DEFAULT NULL,
  `stationTypeID` int(11) DEFAULT NULL,
  `corporationID` int(11) DEFAULT NULL,
  `solarSystemID` int(11) DEFAULT NULL,
  `constellationID` int(11) DEFAULT NULL,
  `regionID` int(11) DEFAULT NULL,
  `stationName` varchar(100) DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `reprocessingEfficiency` double DEFAULT NULL,
  `reprocessingStationsTake` double DEFAULT NULL,
  `reprocessingHangarFlag` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`stationID`),
  KEY `staStations_IX_constellation` (`constellationID`),
  KEY `staStations_IX_corporation` (`corporationID`),
  KEY `staStations_IX_operation` (`operationID`),
  KEY `staStations_IX_region` (`regionID`),
  KEY `staStations_IX_system` (`solarSystemID`),
  KEY `staStations_IX_type` (`stationTypeID`),
  KEY `solarSystemID` (`solarSystemID`,`constellationID`,`regionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trackingGroupMembers`
--

CREATE TABLE IF NOT EXISTS `trackingGroupMembers` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `trackingGroupID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `trackingGroups`
--

CREATE TABLE IF NOT EXISTS `trackingGroups` (
  `name` char(255) NOT NULL,
  `trackingGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  PRIMARY KEY (`trackingGroupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `trackingStations`
--

CREATE TABLE IF NOT EXISTS `trackingStations` (
  `trackingGroupID` int(11) NOT NULL,
  `stationID` int(11) NOT NULL,
  `solarSystemName` char(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `typeBuildReqs`
--

CREATE TABLE IF NOT EXISTS `typeBuildReqs` (
  `blueprintTypeID` smallint(6) NOT NULL DEFAULT '0',
  `activityID` tinyint(3) unsigned NOT NULL,
  `requiredTypeID` smallint(6) NOT NULL DEFAULT '0',
  `quantity` int(11) DEFAULT NULL,
  `damagePerJob` double DEFAULT NULL,
  `wasted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blueprintTypeID`,`activityID`,`requiredTypeID`,`wasted`),
  KEY `requiredTypeID` (`requiredTypeID`),
  KEY `activityID` (`activityID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE IF NOT EXISTS `wallet` (
  `transactionDateTime` datetime NOT NULL,
  `transactionID` bigint(20) unsigned NOT NULL,
  `quantity` bigint(20) unsigned NOT NULL,
  `typeName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `typeID` int(11) NOT NULL,
  `price` double unsigned NOT NULL,
  `clientID` bigint(20) unsigned NOT NULL,
  `clientName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `characterID` int(11) NOT NULL,
  `stationID` bigint(20) unsigned NOT NULL,
  `stationName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `transactionType` varchar(4) CHARACTER SET latin1 NOT NULL,
  `personal` tinyint(1) NOT NULL DEFAULT '0',
  `profit` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactionID`),
  KEY `characterID` (`characterID`),
  KEY `transactionDateTime` (`transactionDateTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `YiiSession`
--

CREATE TABLE IF NOT EXISTS `YiiSession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
