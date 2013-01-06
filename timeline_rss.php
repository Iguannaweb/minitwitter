<?php																													
/*This works in local, if you have problems like me on servers just remove line 3*/
//session_start(); 
//Variable antikacking
define('MiniTwitter_ON', 1);
?>
<?php																													header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
?>
<data>
<?php include("./inc/config.php"); ?>
<?php include("./inc/database.php"); ?>
<?php include("./inc/login.php"); ?>
<?php include("./inc/functions.php"); ?>

<?php
$query  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%b %d %Y %H:%i:%s') AS ds FROM mt_statuses ORDER BY date_set DESC LIMIT 50";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
echo "<event
		start=\"".$row['ds']." GMT\"
		title=\"";

		echo name($row['user_id']);

		echo "\"  
		image=\"";

if(gravatar($row['user_id'])=="yes"){

	$grav_correo = correo($row["user_id"]);
	echo getGravatarUrl($grav_correo, $defImg,  "80", "G");

	}else{
	if(file_exists("./avatar/".$row['user_id'].".jpg")==true){ 
	echo $pth.'/avatar/',$row['user_id'],'.jpg';}
	else {
	echo $defImg;}
	
	}
	
echo "\"
>";
echo $row['status'];
echo "</event>";
}
?>
</data>
