Coanda Menus
============
A menu module for CoandaCMS


Installation
============
Add 
		"adenfraser/coanda-menus": "dev-master"
to 
		composer.json


Then
		composer update


Then add
		AdenFraser\CoandaMenus\CoandaMenusServiceProvider
To the providers section of your \config\app.php file

Finally add
		AdenFraser\CoandaMenus\MenusModuleProvider
To the enabled_modules section of your CoandaCMS Config file
