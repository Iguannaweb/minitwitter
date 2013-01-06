<?php
if($logged_in){
//Query to Know id login
	$queryv  = "SELECT id_usr, correo, gravatar, timeline, follow, showing, rol FROM mt_users WHERE nick='".avoid_injection($_SESSION[usernameuniversal])."' LIMIT 1";
	$resultv = mysql_query($queryv,$connuni) or die(mysql_error().': '.$queryv);
	while($rowv = mysql_fetch_assoc($resultv)){
	$id_usr = $rowv['id_usr'];
	$grav= $rowv['gravatar'];
	$correo_gra = $rowv['correo'];
	$timeline = $rowv['timeline'];
	$twitter = $rowv['twitter'];
	$follow = $rowv['follow'];
	$show = $rowv['showing'];
	$rol = $rowv['rol'];
	}
	
	//Set user session id = $id_usr
	$_SESSION['user_id'] = $id_usr;
	
}
?>
