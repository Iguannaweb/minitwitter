<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Script to install minitwitter</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="../inc/css/css.css">
	</head>
	<body>

<div class="cabecera"><img align="left" border="0" src="../inc/minitwitter.png" alt="minitwitter" width="300" height="67"/>
</div>
<?php
function avoid_injection($string){
if(get_magic_quotes_gpc()){	
$string=stripslashes($string);   
}
$secure_string=mysql_real_escape_string($string);  
//$secure_string=addslashes($string);
return $secure_string;
}
?>
<div id="contentall">
<div class="contenidonormalb">
<div class="bri">
<h2>1. Connecting to the database...</h2>
<?php
if($_POST["install"]){
//echo "Upss, still in development<br>";
$host = $_POST["host"];
$dbname = $_POST["dbname"];
$dbuser = $_POST["dbuser"];
$dbpass = $_POST["dbpass"];

$lang = $_POST["language"];

$installpth = $_POST["installpath"];
$captcha_publickey = $_POST["captcha_publickey"];
$captcha_privatekey = $_POST["captcha_privatekey"];
$numero = $_POST["numero"];


$nick = $_POST["adminuser"];
$adminpass = $_POST["adminpass"];
$adminpass2 = $_POST["adminpass2"];
$adminemail = $_POST["adminemail"];

if($adminpass==$adminpass2){

$connuni = mysql_connect($host, $dbuser, $dbpass) or die(mysql_error());
$conexion = mysql_select_db($dbname, $connuni) or die(mysql_error());
if($conexion==true){
echo "<h3>We have stablished a connection to the database with your provided data, know we are going to proceed to create tables in yout db.</h3>";

echo "<ul>";
	$tabla1sql="CREATE TABLE IF NOT EXISTS `mt_channel` (
  `id_channel` int(6) NOT NULL auto_increment,
  `channel` varchar(150) NOT NULL,
  `channel_desc` varchar(255) NOT NULL,
  `admin_id` int(6) NOT NULL,
  `members` text NOT NULL,
  PRIMARY KEY  (`id_channel`),
  UNIQUE KEY `channel` (`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	$tabla1=mysql_query($tabla1sql);
	if($tabla1){
		echo "<li>Hemos creado las tabla <strong>mt_channel</strong> en la base de datos...</li>";
	}
	
		$tabla2sql="CREATE TABLE IF NOT EXISTS `mt_group` (
  `id_group` int(6) unsigned NOT NULL auto_increment,
  `group_name` varchar(150) default NULL,
  `group_desc` varchar(255) default NULL,
  `admin_id` int(6) NOT NULL,
  `members` tinytext,
  `members_twitter` text,
  PRIMARY KEY  (`id_group`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
	$tabla2=mysql_query($tabla2sql);
	if($tabla2){
		echo "<li>Hemos creado las tabla <strong>mt_group</strong> en la base de datos...</li>";
	}
	
		$tabla3sql="CREATE TABLE IF NOT EXISTS `mt_statuses` (
  `status_id` mediumint(10) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) NOT NULL,
  `status` varchar(150) collate utf8_spanish_ci NOT NULL,
  `date_set` datetime NOT NULL,
  PRIMARY KEY  (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1;";
	$tabla3=mysql_query($tabla3sql);
	if($tabla3){
		echo "<li>Hemos creado las tabla <strong>mt_statuses</strong> en la base de datos...</li>";
	}
	
		$tabla4sql="CREATE TABLE IF NOT EXISTS `mt_users` (
  `id_usr` int(6) unsigned NOT NULL auto_increment,
  `nombre` char(255) character set utf8 collate utf8_unicode_ci default NULL,
  `apellidos` char(255) character set utf8 collate utf8_unicode_ci default NULL,
  `nick` char(255) character set utf8 collate utf8_unicode_ci default NULL,
  `password` char(55) character set utf8 collate utf8_unicode_ci default NULL,
  `correo` char(255) character set utf8 collate utf8_unicode_ci default NULL,
  `dia` int(2) NOT NULL,
  `mes` int(2) NOT NULL,
  `anio` int(4) NOT NULL,
  `country` varchar(255) collate utf8_bin NOT NULL,
  `state` varchar(255) collate utf8_bin NOT NULL,
  `sex` varchar(15) collate utf8_bin NOT NULL,
  `bio` varchar(255) collate utf8_bin NOT NULL,
  `gravatar` varchar(3) character set utf8 collate utf8_unicode_ci NOT NULL,
  `timeline` varchar(3) collate utf8_bin NOT NULL,
  `twitter` varchar(3) collate utf8_bin NOT NULL,
  `accounts` varchar(255) collate utf8_bin NOT NULL,
  `follow` text collate utf8_bin NOT NULL,
  `showing` varchar(160) collate utf8_bin NOT NULL,
  `rol` varchar(1) NOT NULL,
  `admin` int(1) NOT NULL,
  PRIMARY KEY  (`id_usr`),
  UNIQUE KEY `nick` (`nick`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;";
	$tabla4=mysql_query($tabla4sql);
	if($tabla4){
		echo "<li>Hemos creado las tabla <strong>mt_users</strong> en la base de datos...</li>";
	}
	
	$insert_admin = "INSERT INTO mt_users (id_usr, nick, password,correo,admin) VALUES ('1','".avoid_injection($nick)."','".avoid_injection(md5($adminpass))."','".avoid_injection($adminemail)."','1')";
	$ok = mysql_query($insert_admin); 
	if($ok){
		echo "<li>Hemos insertado el primer registro en la base de datos.</li>";
	
	}else{
		echo "<li>Ups, parece que hubo un error al insertar los datos del administrador.</li>";
	}
	
	$configdata = '<?php 
	/*mysql data connect*/
	$host = "'.$host.'";
	$user = "'.$dbuser.'";
	$pass = "'.$dbpass.'";
	$db = "'.$dbname.'";
	
	/*Url MT folder*/
	$pth = "'.$installpth.'";
	
	/*Url default img avatar*/
	$defImg = "'.$installpth.'avatar/default.jpg";
	
	/*Define lang ex: en*/
	$deflang="'.$lang.'";
	
	/*Recaptcha config*/
	$captcha_publickey="'.$captcha_publickey.'";
	$captcha_privatekey = "'.$captcha_privatekey.'";
	
	/*Configurar un Twitter común*/
	$twitterpublicusername="";
	$twitterpublicpass="";
	$twitterpubliccheck="no";//yes or no
	
	$numero_caracteres = "'.$numero.'";
	?>';

	
	$name = "../inc/config.php";
	$content = $configdata;
	$o = fopen ($name, "w+");
	fwrite ($o, $content);
	fclose($o);
	
	echo "<li>Se ha escrito el <strong>Archivo de configuración</strong></li>";

echo "</ul>";
}


}
}else{

?>
<p>We need some config before use minitwitter!</p>

<h3>a. Database info</h3>
<p>If you are trying to use minitwitter you almost need a mysql database with this data.</p>
<form method="post" name="install" action="">
<table cellspacing="5" cellpadding="5">

<tr>
<td><label><strong>Host (<em>Not always</em> is localhost)</strong></label></td>
<td><input type="text" name="host"></td>
</tr>

<tr>
<td><label><strong>Database name</strong></label></td>
<td><input type="text" name="dbname"></td>
</tr>

<tr>
<td><label><strong>Database User</strong></label></td>
<td><input type="text" name="dbuser"></td>
</tr>

<tr>
<td><label><strong>Database Password</strong></label></td>
<td><input type="password" name="dbpass"></td>
</tr>

<tr>
<td><label><strong>Url a donde se encuentra el script</strong></label></td>
<td><input type="text" name="installpath" value="http://www.example.com/"><small>(<strong>with</strong> final dash)</small></td>
</tr>

<tr>
<td><label><strong>Captcha publickey</strong></label></td>
<td><input type="text" name="captcha_publickey"></td>
</tr>

<tr>
<td><label><strong>Captcha privatekey</strong></label></td>
<td><input type="text" name="captcha_privatekey"></td>
</tr>

<tr>
<td><label><strong>Number of character</strong></label></td>
<td><input type="text" name="numero" value="200"></td>
</tr>

</table>
<span style="float: right;">&darr;</span> &darr; 
<h3>b. Setup minitwitter's admin user</h3>
<p>This is for future, make this user, the first one as admin of all other user registered on minitwitter and have some new features to menage minitwitter from a control panel.</p>
<table cellspacing="5" cellpadding="5">

<tr>
<td><label><strong>Admin user</strong></label></td>
<td><input type="text" name="adminuser"></td>
</tr>

<tr>
<td><label><strong>Admin Password</strong></label></td>
<td><input type="password" name="adminpass"></td>
</tr>

<tr>
<td><label><strong>Admin Password (repeat)</strong></label></td>
<td><input type="password" name="adminpass2"></td>
</tr>

<tr>
<td><label><strong>Admin email</strong></label></td>
<td><input type="text" name="adminemail"></td>
</tr>

<tr>
<td><label><strong>Language</strong></label></td>
<td><select name="language">
<option value="en">English</option>
<option value="es">Español</option>
</select></td>
</tr>

</table>

<?php
/*<h3>c. Choose Addons</h3>
<p>Now you can choose addons activated by default or disabled, for example you may not need to show timeline, or use gravatar, or twitpic integration... or maybe yes ;)</p>
<table cellspacing="5" cellpadding="5">

<tr>
<td><label><strong>Timeline</strong></label></td>
<td><input type="radio" name="timeline" value="tmoff">Off
<input type="radio" name="timeline" value="tmon">On  
<input type="radio" name="timeline" value="tmdsb">Disabled </td>
</tr>

<tr>
<td><label><strong>Twitpic</strong></label></td>
<td><input type="radio" name="twitpic" value="tpoff">Off 
<input type="radio" name="twitpic" value="tpon">On  
<input type="radio" name="twitpic" value="tpdsb">Disabled </td>
</tr>

<tr>
<td><label><strong>Gravatar</strong></label></td>
<td><input type="radio" name="gravatar" value="gvenb">Enabled  
<input type="radio" name="gravatar" value="gvdsb">Disabled </td>
</tr>

<tr>
<td><label><strong>Twitter</strong></label></td>
<td><input type="radio" name="twitter" value="ttenb">Enable  
<select name="ttnb">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select> accounts
<input type="radio" name="twitter" value="ttdsb">Disabled </td>
</tr>

<tr>
<td><label><strong>Short urls</strong></label></td>
<td>
<input type="checkbox" name="short" value="tiny">Tinyurl  
<input type="checkbox" name="short" value="isgb">Is.gd 
<input type="checkbox" name="short" value="zuma">Zuma </td>
</tr>

</table>

<h3>d. Choose Widgets</h3>
<p>This widgets are shown in the sidebar</p>
<table cellspacing="5" cellpadding="5">

<tr>
<td><label><strong>Twitpic Pics</strong></label></td>
<td><input type="radio" value="tpwoff">Off 
<input type="radio" value="tpwon">On </td>
</tr>

<tr>
<td><label><strong>Tag cloud</strong></label></td>
<td><input type="radio" value="tcwoff">Off 
<input type="radio" value="tcwon">On <td>
</tr>
*/?>
</table>

<input id="submit" type="submit" name="install" value="Step 2 &raquo;">
<br><br>
</form>
<br>
<?php
}
?>
</div>
</div>
</div>
	</body>
</html>
 