<?php
if(!defined('MiniTwitter_ON')){

     die('Hacking attempt');
}

/**
 * Connect to the mysql database.
 */

$connuni = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db, $connuni) or die(mysql_error());

//connect to the db
//$link = @mysql_connect($host, $user, $pass);
//@mysql_select_db($db, $link);

?>