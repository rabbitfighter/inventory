---------
INVENTORY
---------


NOTE:

This is a small web app for tracking IT inventory. I am writing it for use at the school where I work. It is partially functional but not ready for use yet. 

This app uses Bootstrap3 and FontAwesome.
 -- http://getbootstrap.com/
 -- http://fortawesome.github.io/Font-Awesome/


INSTALLATION:

  * You will need a *nix web server running recent versions of Apache, PHP5, and mySQL (LAMP)
  * phpmyadmin is useful too: http://www.phpmyadmin.net/
  * create a new mySQL database called 'inventory' 
  * Use the inc/create_table.sql file to create the items table
  * download the source files and copy them to a directory off you web root or just clone the repository
  * create a new file called config.php in the inc folder (inc/config.php)
  * paste the following into the config.php file:
  
<?php

// Vars
$site_admin = "admin";
$site_admin_password = "a_password_for_the_admin_user";
$mysql_host = "localhost";
$mysql_user = "your_mysql_username";
$mysql_password = "your_mysql_password";
$mysql_db = "inventory";

?>

  * edit this to make it correct for your environment. At minimum, you will need to set the mySQL user and password.
  * you should now be able to load the index.php page and log in using the site admin username/password you set in the config file.
  * to populate the items table you can create a CSV file and upload via phpmyadmin
  
