Authors
 
    Original Author: Blake (k126space.com)
	Fixes, updates and this fork: Markus (Eve char: Adrenalin Auscent)

Disclaimer

	Code is provided as is.

	If you want to try to setup your own instance, I would advice that you have an understanding of PHP, MySQL, and general code architecture. 
	Getting this to run is not a beginner project.
	I cannot provide any commitment for bugs corrections, adding features, or providing support.
	There are many, many non-sanitized input points that are major security issues as noted in this post. I would not use this as a public-facing site.
	There are unfinished pages, hacked together solutions, code in the view, display code in the controllers, etc. Don't expect clean, production quality code.

Prerequisites

    MySQL, PHP5+
    phpMyAdmin or an easy way to modify tables

Installation

1. Download the latest code from https://github.com/maxs94/prohd

2. Unzip in your Webroot in a separate directory like /industry 

2. Edit protected/config/main.php.changeme
        Line 29 contains IP limitations for working with Gii. Enter your WAN IP address here if you want to work with this module.
        Line 57/58 contain your database connection information.
        Rename to main.php

3. Edit protected/config/console.php.changeme
        Line 22 contains the database name. My project was named after my holding corporation PROHD so the database name is .prohd..
        Line 24/25 contain the user/password to login to the application.
        Rename to console.php

4. Create database structure with prohd.sql

5. Import the Eve static data tables from https://www.fuzzwork.co.uk/dump/

5.1 use latest dump: https://www.fuzzwork.co.uk/dump/mysql-latest.tar.bz2

6. Generate the following table for typeBuildReqs for Tech 2 items. 
	for MySQL: /build_t2.sql 
	for MS SQL Server: (http://pastebin.com/6hypXsrS) 
	
7. Point your browser to the install location - it should come up with a page telling you that it has created a new username.

7.1 Refresh the page and login with username "admin" and password "password".

7.2 Go to "Admin" in the top menu and change the admin's account password!

7.3 Modify the your API-Key in the Character's section, leave the Character ID at "1"!

8. Done. 