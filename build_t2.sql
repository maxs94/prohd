DROP TABLE IF EXISTS typeBuildReqs;

CREATE TABLE typeBuildReqs
(
typeID smallint,
activityID tinyint,
requiredTypeID smallint,
quantity int,
damagePerJob float,
wasted	 tinyint,
CONSTRAINT typetypeBuildReqs_PK PRIMARY KEY CLUSTERED 
(typeID, activityID, requiredTypeID, wasted)
);

INSERT INTO typeBuildReqs (typeID, activityID, requiredTypeID, quantity,
damagePerJob,wasted)

(SELECT itm1.typeID, 1 AS activityID, itm1.requiredTypeID, (itm1.quantity-ifnull(itm2.quantity,0)) as quantity, 1 AS damagePerJob, 1 AS wasted

FROM
(SELECT invBlueprintTypes.blueprintTypeID as typeID, 1 AS
activityID, invTypeMaterials.materialTypeID AS requiredTypeID, 
invTypeMaterials.quantity, 1 AS damagePerJob, 1 AS wasted 
FROM invTypeMaterials

INNER JOIN invBlueprintTypes 
ON invTypeMaterials.typeID =
invBlueprintTypes.productTypeID) as itm1

LEFT OUTER JOIN	

(SELECT typeID, activityID, requiredTypeID , 
sum(quantity) as quantity, damagePerJob, wasted
FROM
(SELECT t.typeID, 1 AS activityID, itm.materialTypeID
as requiredTypeID , (itm.quantity * t.quantity) 
AS quantity, 1 AS damagePerJob, 1 AS wasted

FROM	
(SELECT DISTINCT rtr.typeID, rtr.requiredTypeID,
rtr.quantity
FROM ramTypeRequirements AS rtr

INNER JOIN	invTypes AS iT 
ON rtr.requiredTypeID = iT.typeID 

INNER JOIN	invGroups AS iG 
ON iT.groupID = iG.groupID

WHERE ((rtr.activityID = 1) AND (rtr.recycle = 1) 
AND (iG.categoryID <> 4) 
AND (iG.categoryID <> 17))) AS t

INNER JOIN invTypeMaterials AS itm 
ON t.requiredTypeID = itm.typeID) as itm3
Group by typeID, activityID, requiredTypeID , damagePerJob, wasted)
as itm2 

on itm2.typeID = itm1.typeID and 
itm2.activityID = itm1.activityID and
itm2.requiredTypeID = itm1.requiredTypeID

WHERE (itm1.quantity-ifnull(itm2.quantity,0)) > 0) 

UNION

(SELECT rtr2.typeID, rtr2.activityID, rtr2.requiredTypeID, rtr2.quantity,
rtr2.damagePerJob, 0 AS wasted
FROM ramTypeRequirements AS rtr2 

INNER JOIN	invTypes AS types 
ON rtr2.requiredTypeID = types.typeID 

INNER JOIN	invBlueprintTypes AS bps 
ON rtr2.typeID = bps.blueprintTypeID

INNER JOIN	invGroups AS groups 
ON types.groupID = groups.groupID 

LEFT OUTER JOIN (SELECT typeID, materialTypeID, quantity 
FROM invTypeMaterials) AS itm 
ON (bps.productTypeID = itm.typeID AND 
rtr2.requiredTypeID = itm.materialTypeID AND 
(rtr2.quantity <= itm.quantity OR 
rtr2.quantity > itm.quantity OR itm.quantity is null))

WHERE ((groups.categoryID <> 16) AND (rtr2.activityID = 1) AND
(rtr2.quantity > 0)));