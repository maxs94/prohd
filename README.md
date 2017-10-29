Disclaimer

	Code is provided as is.

	If you want to try to setup your own instance, I would advice that you have an understanding of PHP, MySQL, and general code architecture. 

	Getting this to run is not a beginner project.

	I cannot provide any commitment for bugs corrections, adding features, or providing support.

	There are many, many non-sanitized input points that are major security issues as noted in this post. I would not use this as a public-facing site.

	There are unfinished pages, hacked together solutions, code in the view, display code in the controllers, etc. Don't expect clean, production quality code.

	Be prepared to edit the database table to enter your users and API keys. The .admin. section is only partially completed.

Prerequisites

    MySQL, PHP5+
    Yii Framework
    phpMyAdmin or an easy way to modify tables

Installation

1. Download the latest code from https://github.com/brentnowak/prohd

2. Edit protected/config/main.php.changeme
        Line 29 contains IP limitations for working with Gii. Enter your WAN IP address here if you want to work with this module.
        Line 57/58 contain your database connection information.
        Rename to main.php

3. Edit protected/config/console.php.changeme
        Line 22 contains the database name. My project was named after my holding corporation PROHD so the database name is .prohd..
        Line 24/25 contain the user/password to login to the application.
        Rename to console.php

4. Modify Yii path in index.php
        Change the path to your Yii framework location $yii=./usr/local/lib/yii/yii.php.;

5. Replace /usr/local/lib/yii/caching/CDbCache.php with the one in the zip.

6. Create database structure with prohd.sql

7. Create a login in the 'accounts' table. The default userLevel is 1

8. Enable the API feed by adding a 1,1 row to the apiStatus table

9. Define a group in trackingGroups table

10. Add your character information in the .characters.  table.

11. Import the Eve static data tables from http://zofu.no-ip.de/

12. Generate the following table for typeBuildReqs for Tech 2 items. You can use my query (http://pastebin.com/6hypXsrS)

Recommendations

If you are intimated by the scope of the setup procedure, I would recommend that you use the DRK Industry Tracker for your construction projects as my partner Raath is actively developing this project.

