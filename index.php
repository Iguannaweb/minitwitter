<?php																													
/*This works in local, if you have problems like me on servers just remove line 3*/
session_start(); 
//Variable antikacking
define('MiniTwitter_ON', 1);
if(file_exists("./install/index.php")==true){
header("Location: ./install/index.php"); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<!-- Well let me do the includes, database config, login and some little functions-->
<?php include("./inc/config.php"); ?>
<?php include("./inc/database.php"); ?>
<?php include("./inc/login.php"); ?>
<?php include("./inc/functions.php"); ?>
<?php include("./inc/lang/".$deflang.".php"); ?>
<?php require_once('./inc/captcha/recaptchalib.php'); ?>
<?php include("./inc/logged_in.php"); ?>

<!-- Metas & css -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $pth;?>inc/css/css.css">
<link rel="stylesheet" type="text/css" href="<?php echo $pth;?>inc/css/tabcontent.css" />
<title><?php echo $indexphp_title; ?></title>

<!-- javascripts -->
<?php include("./inc/js/hidejs.php"); ?>
<?php include("./inc/js/tiny.php"); ?>
<script type="text/javascript" src="<?php echo $pth;?>inc/js/tabcontent.js"></script>
<?php include("./inc/js/wordcount.php"); ?>
<script type="text/javascript" src="./inc/notimoo/mootools-1.2-core.js"></script>
<script type="text/javascript" src="./inc/notimoo/notimoo-1.0.js"></script> 
<link rel="stylesheet" type="text/css" href="./inc/notimoo/notimoo-1.0.css" />
</head>

<!-- BODY START -->
<body onload="check_length();">


<!-- Bubble tooltips -->
<script type="text/javascript" src="<?php echo $pth;?>inc/js/wz_tooltip.js"></script>
<script type="text/javascript" src="<?php echo $pth;?>inc/js/tip_balloon.js"></script>


<!-- Head -->
<div class="cabecera"><a href="<?php echo $pth; ?>index.php"><img align="left" border="0" src="./inc/minitwitter.png" alt="minitwitter" width="300" height="67"/></a>

<div style="float: right; margin-top: 30px; width: 450px;"><small style="color: red"><?php echo $indexphp_subhead; ?></small></div>

</div>


<div id="contentall">

<!-- BARRITAS -->
<?php if($logged_in && (!$_GET["go"])){ ?>
<div class="barrita1"></div>

<div class="barrita2"></div>
<?php } ?>

<?php if($logged_in){ ?>

<!-- Si muestra opciones, no muestres sidebar -->
<?php if(($_GET["go"]=="opt") or ($_GET["go"]=="salir") or ($_POST["groupform"]) or ($_POST["groupform_t"]) or ($_POST["delete_group_id"]) or ($_GET["go"]=="new_user")){}else{ ?>

<!-- Sidebar-->
<div class="sidebar">
<?php include("./inc/sidebar.php"); ?>
</div>
<?php
}
//Fin sidebar
}
//fin logged in
?>

<!-- contents Includes -->

<!-- OPTIONS PAGE -->
<?php 
if($_GET["go"]=="opt"){

if($logged_in){
echo "<div class=\"contenidonormalb\"><div class=\"bri\">"; 
include('./inc/opt.php'); 
echo "</div><br>";

}else{
?>
<h3><?php echo $indexphp_optdirect1; ?></h3>

<div class="bri"> 
<p><?php echo $indexphp_optdirect2; ?></p> 
<a id="nuevo" href="index.php"><?php echo $indexphp_goback; ?></a><br><br> 
</div>

<?php
}

/*CREA USUARIOS*/
}elseif(($_GET["go"]=="new_user") && $id_usr=="1"){

if($logged_in){
echo "<div class=\"contenidonormalb\"><div class=\"bri\">"; 
include('./inc/new_user.php'); 
echo "</div><br>";
}

//LOGOUT
}elseif($_GET["go"] == "salir"){ 
echo "<div class=\"contenidonormalb\">";
echo "<div class=\"bri\">"; 
include('./inc/logout.php');  
echo "</div><br>";


//CREATE INTERNAL GROUP 
}elseif($_POST["groupform"]){
echo "<div class=\"contenidonormalb\">";
echo "<div class=\"bri\">";

echo "<h3>".$indexphp_crg." ".$_POST["group_name"]." ".$indexphp_crg2."</h3>\n";
$group_name = $_POST["group_name"];
$group_desc = $_POST["group_desc"];
$members = $_POST["follow"];

	if($members!=""){
		foreach ($members as $key=>$val) {
		$memberus .= $val.",";
		}
	}
	
	if($group_name==""){
	echo $indexphp_crg3;

	}else{
	$tmemberus="";
	$grup = "INSERT INTO mt_group (id_group, group_name, group_desc,admin_id,members, members_twitter) VALUES ('','".avoid_injection($group_name)."','".avoid_injection($group_desc)."','".avoid_injection($id_usr)."','".avoid_injection($memberus)."','".avoid_injection($tmemberus)."')";
	mysql_query($grup, $connuni) or die(mysql_error());
	echo $indexphp_crg4." <b>$group_name</b> ".$indexphp_crg5."<br>
	<br>";
	}
   
echo "<br><a id=\"nuevo\" href=\"index.php\">".$indexphp_goback2."</a><br><br>";
echo "</div><br>";


//DELETE INTERNAL GROUP
}elseif($_POST["delete_group_id"]){
	echo "<div class=\"contenidonormalb\">";
	echo "<div class=\"bri\">";
	 
	$grup_id = $_POST["delete_group_id"];
	$grup = "DELETE FROM mt_group WHERE id_group='".avoid_injection($grup_id)."'";
	mysql_query($grup, $connuni) or die(mysql_error());
	  	
	echo "<h3>".$indexphp_crg11." ".$grup_id." ".$indexphp_crg12."</h3>\n";
	echo "<br><br><a id=\"nuevo\" href=\"index.php\">".$indexphp_goback2."</a><br><br>";
	
	echo "</div><br>";
}else{

displayLogin();

#######################
##  SIDEBAR PEOPLE   ##
#######################
?>

<!-- People sidebar -->
<?php  if(!$logged_in){  ?>
<div class="bri">

<?php
$query  = "SELECT id_usr, nombre, apellidos, nick, password, correo, dia, mes, anio, gravatar FROM mt_users ORDER BY RAND()";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
?>

<h3><?php echo $indexphp_pp; ?> (<?php echo mysql_num_rows($result);?>)</h3>
<br>

<?php
$i=0;
$x=0;
while($row = mysql_fetch_assoc($result)){

if($row["gravatar"]=="yes"){

echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\"  onmouseover=\"Tip('";
echo "<b>".$row["nick"].": </b>";
echo last($row["id_usr"]);
echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">";
echo "<img width=\"48\" border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"";
$grav_correo = $row["correo"];
echo getGravatarUrl($grav_correo, $defImg,  "80", "G");
echo "\" alt=\"Gravatar\"></a>";
$x=$x+1;
}else{

if(file_exists("./avatar/".$row["id_usr"].".jpg")==true){ 

echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\"  onmouseover=\"Tip('";
echo "<b>".$row["nick"].": </b>";
echo last($row["id_usr"]);
echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">
<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."avatar/".$row["id_usr"].".jpg\" width=\"48\" height=\"48\"></a>";

$x=$x+1;
}else {
//echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\"><img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."avatar/default.jpg\" width=\"48\" height=\"48\"></a>";

$sn=$sn+1;
} 

//$x=$x+1;	
}
$resto = $x%12;

if (($resto==0) && ($x!=0)) {
echo "<div style=\"clear: both;\"></div>";
}


}
echo "<div style=\"clear: both;\"></div>";
echo "<small><b>".$sn."</b> ".$indexphp_av."</small>";
?>
</div>

<?php  }  ?>

<?php

#######################
##  DELETE           ##
#######################
if($_POST["status_id"]){
echo "<div id=\"message_error\">";
remove($_POST["status_id"]);
echo "</div>";
}

####FOLLOWING####
if($_POST["status_id_mas"]){
echo "<div id=\"message\">";
follow($_POST["status_id_mas"],$_SESSION['user_id']);
echo "</div>";
}

####UN_FOLLOWING###
if($_POST["status_id_menos"]){
echo "<div id=\"message_error\">";
unfollow($_POST["status_id_menos"],$_SESSION['user_id']);
echo "</div>";
}


#######################
##  UPDATES          ##
#######################


/* form submission post */
if(isset($_POST['status']) && $_SESSION['user_id'] && !$_POST['tiny']){

if(($_POST['status']=="") && (!$HTTP_POST_FILES['media']['tmp_name'])){
echo "<div id=\"message_error\">".$indexphp_empty."</div>"; 
}else{
	
#######################
##  TWITTER          ##
#######################

if(($_POST['twitter_no_trust']=="yes") && (!$HTTP_POST_FILES['media']['tmp_name'])){
/* ---------------------------------------- */
// Trozo para postear a Twitter 
// con el usuario y password que proporciones
/* ---------------------------------------- */
$twitter_username	= $_POST['twitter_username'];
$twitter_psw		= $_POST['twitter_psw'];
/* ---------------------------------------- */

/* Don't change the code belove
/* ---------------------------------------- */
require('./inc/twitterAPI.php');
if(isset($_POST['status'])){
	$twitter_message=mysql_escape_string(strip_tags($_POST['status']));
	if(strlen($twitter_message)<1){
	$error=1;
	} else {
	$twitter_status=postToTwitter($twitter_username, $twitter_psw, $twitter_message);
	//echo "No trust no pic";
	}
}
/* ---------------------------------------- */


/* ---------------------------------------- */
// Trozo para subir foto a twitpic con usuario y pass de twitter
/* ---------------------------------------- */
}elseif(($_POST['twitter_no_trust']=="yes") && ($HTTP_POST_FILES['media']['tmp_name'])){

$twitter_username	= $_POST['twitter_username'];
$twitter_psw		= $_POST['twitter_psw'];

move_uploaded_file($HTTP_POST_FILES['media']['tmp_name'], "./temp/temp.jpg");
	$uploadfile="./temp/temp.jpg"; 
	$ch = curl_init("http://twitpic.com/api/uploadAndPost");  
	curl_setopt($ch, CURLOPT_POSTFIELDS,
       array('username'=>$twitter_username,
       'password'=>$twitter_psw,
       'message'=>mysql_escape_string(strip_tags($_POST['status'])),
       'media'=>"@$uploadfile"));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$postResult = curl_exec($ch);
	curl_close($ch);
	
	preg_match_all("/(<([\w]+)[^>]*>)(.*)(<\/\\2>)/", $postResult, $codigos, PREG_SET_ORDER);
foreach($codigos as $val) {
if(strstr($val[3],"http")==true){$twitpicurl = $val[3];}
}
	unlink("./temp/temp.jpg");
	//echo "No trust, pic";
/* ---------------------------------------- */
	
	
	
}elseif ($_POST['twitter_no_trust']!="yes"){

require('./inc/twitterAPI.php');

if(($_POST['twitter_update_acc1']=="yes") && (!$HTTP_POST_FILES['media']['tmp_name'])){
/* ---------------------------------------- */
// Trozo para postear a Twitter cuenta 1
/* ---------------------------------------- */
$twitter_username1	= $_POST['twitter_username1'];
$twitter_psw1	= decode($_POST['twitter_psw1']);
/* ---------------------------------------- */

/* Don't change the code belove
/* ---------------------------------------- */

if(isset($_POST['status'])){
	$twitter_message=mysql_escape_string(strip_tags($_POST['status']));
	if(strlen($twitter_message)<1){
	$error=1;
	} else {
	$twitter_status=postToTwitter($twitter_username1, $twitter_psw1, $twitter_message);
	//echo "Trust account 1 no pic";
	}
}
/* ---------------------------------------- */


/* ---------------------------------------- */
// Cuenta 1 twitter e imagen a twitpic
/* ---------------------------------------- */	
}elseif(($_POST['twitter_update_acc1']=="yes") && ($HTTP_POST_FILES['media']['tmp_name'])){

$twitter_username1	= $_POST['twitter_username1'];
$twitter_psw1	= decode($_POST['twitter_psw1']);

move_uploaded_file($HTTP_POST_FILES['media']['tmp_name'], "./temp/temp.jpg");
$uploadfile="./temp/temp.jpg"; 
$ch = curl_init("http://twitpic.com/api/uploadAndPost");  
curl_setopt($ch, CURLOPT_POSTFIELDS,
   array('username'=>$twitter_username1,
   'password'=>$twitter_psw1,
   'message'=>mysql_escape_string(strip_tags($_POST['status'])),
   'media'=>"@$uploadfile"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$postResult = curl_exec($ch);
curl_close($ch);

preg_match_all("/(<([\w]+)[^>]*>)(.*)(<\/\\2>)/", $postResult, $codigos, PREG_SET_ORDER);
foreach($codigos as $val) {
if(strstr($val[3],"http")==true){$twitpicurl = $val[3];}
}
unlink("./temp/temp.jpg");
//echo "Trust account 1, pic";
}


	
if(($_POST['twitter_update_acc2']=="yes") && (!$HTTP_POST_FILES['media']['tmp_name'])){
/* ---------------------------------------- */
// Trozo para postear a Twitter cuenta 2
/* ---------------------------------------- */
$twitter_username2	= $_POST['twitter_username2'];
$twitter_psw2	= decode($_POST['twitter_psw2']);
/* ---------------------------------------- */

/* Don't change the code belove
/* ---------------------------------------- */
//require('./inc/twitterAPI.php');
if(isset($_POST['status'])){
	$twitter_message=mysql_escape_string(strip_tags($_POST['status']));
	if(strlen($twitter_message)<1){
	$error=1;
	} else {
	$twitter_status=postToTwitter($twitter_username2, $twitter_psw2, $twitter_message);
	}
}
/* ---------------------------------------- */
	
}elseif(($_POST['twitter_update_acc2']=="yes") && ($HTTP_POST_FILES['media']['tmp_name'])){
/* ---------------------------------------- */
// Trozo para postear a Twitter 2 con twitpic
/* ---------------------------------------- */
$twitter_username2	= $_POST['twitter_username2'];
$twitter_psw2	= decode($_POST['twitter_psw2']);

move_uploaded_file($HTTP_POST_FILES['media']['tmp_name'], "./temp/temp2.jpg");
	$uploadfile="./temp/temp2.jpg"; 
	$ch = curl_init("http://twitpic.com/api/uploadAndPost");  
	curl_setopt($ch, CURLOPT_POSTFIELDS,
       array('username'=>$twitter_username2,
       'password'=>$twitter_psw2,
       'message'=>mysql_escape_string(strip_tags($_POST['status'])),
       'media'=>"@$uploadfile"));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$postResult = curl_exec($ch);
	curl_close($ch);
	
	preg_match_all("/(<([\w]+)[^>]*>)(.*)(<\/\\2>)/", $postResult, $codigos, PREG_SET_ORDER);
foreach($codigos as $val) {
if(strstr($val[3],"http")==true){$twitpicurl = $val[3];}
}
	unlink("./temp/temp2.jpg");

}
	
	
if(($_POST['twitter_update_acc3']=="yes") && (!$HTTP_POST_FILES['media']['tmp_name'])){
/* ---------------------------------------- */
// Trozo para postear a Twitter cuenta 3
/* ---------------------------------------- */

$twitter_username3	= $_POST['twitter_username3'];
$twitter_psw3		= decode($_POST['twitter_psw3']);
/* ---------------------------------------- */

/* Don't change the code belove
/* ---------------------------------------- */
//require('./inc/twitterAPI.php');
if(isset($_POST['status'])){
$twitter_message=mysql_escape_string(strip_tags($_POST['status']));
if(strlen($twitter_message)<1){
$error=1;
} else {
$twitter_status=postToTwitter($twitter_username3, $twitter_psw3, $twitter_message);
}
}
/* ---------------------------------------- */
	
	
}elseif(($_POST['twitter_update_acc3']=="yes") && ($HTTP_POST_FILES['media']['tmp_name'])){
/* ---------------------------------------- */
// Trozo para postear a Twitpic cuenta 3 de twitter
/* ---------------------------------------- */
$twitter_username3	= $_POST['twitter_username3'];
$twitter_psw3	= decode($_POST['twitter_psw3']);

move_uploaded_file($HTTP_POST_FILES['media']['tmp_name'], "./temp/temp3.jpg");
	$uploadfile="./temp/temp3.jpg"; 
	$ch = curl_init("http://twitpic.com/api/uploadAndPost");  
	curl_setopt($ch, CURLOPT_POSTFIELDS,
       array('username'=>$twitter_username3,
       'password'=>$twitter_psw3,
       'message'=>mysql_escape_string(strip_tags($_POST['status'])),
       'media'=>"@$uploadfile"));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$postResult = curl_exec($ch);
	curl_close($ch);
	
	preg_match_all("/(<([\w]+)[^>]*>)(.*)(<\/\\2>)/", $postResult, $codigos, PREG_SET_ORDER);
foreach($codigos as $val) {
if(strstr($val[3],"http")==true){$twitpicurl = $val[3];}
}
	unlink("./temp/temp3.jpg");

}

}

//TODO LIST COMMAND	
if(eregi("^TODO ",$_POST['status'])==true){

$_POST['status'] = ereg_replace("^TODO ","", $_POST['status']);
$_POST['status'] = mysql_escape_string(strip_tags($_POST['status']));
$fecha = time ();  
$n_td_l = md5($_SESSION['user_id']."_todo_list");
$contenido = $fecha."|".$_SESSION['user_id']."|".$_POST['status']."\n";
$stat_archivo = fopen("./todo/".$n_td_l.".txt", "a+");
/*Escribimos los archivos*/
fwrite($stat_archivo, $contenido);
/*Cerramos*/
fclose($stat_archivo);
//volcamos por pantalla y cerramos el output buffer
ob_end_flush();

 echo "<div id=\"message\"><b>".$indexphp_todo." <b>".$_POST['status']."</b> ".$indexphp_todo2."</div>";
	 	
	
//FOLLOW COMMAND
}elseif(eregi("^FOLLOW _",$_POST['status'])==true){

echo "<div id=\"message\">";
$getnick = sacar($_POST["status"],"_","_");
$nicktofollow=idfromnick($getnick);
follow($nicktofollow,$_SESSION['user_id']);
echo "</div>";

//UNFOLLOW COMMAND	
}elseif(eregi("^UNFOLLOW _",$_POST['status'])==true){

echo "<div id=\"message\">";
$getnick = sacar($_POST["status"],"_","_");
$nicktofollow=idfromnick($getnick);
unfollow($nicktofollow,$_SESSION['user_id']);
echo "</div>";

//DELETE TODO LIST COMMAND
}elseif(eregi("^DONE _",$_POST['status'])==true){

$n_td_l = md5($_SESSION['user_id']."_todo_list");
$name = "./todo/".$n_td_l.".txt";
$line = sacar($_POST["status"],"_","_");
$line = $line-1;
$file = file($name);

$file[$line] = "";

$file = implode("", $file);


$o = fopen ($name, "w+");
fwrite ($o, $file);
fclose($o);

echo "<div id=\"message\">".$indexphp_todo3."<b>".($line+1)."</b>.</div>";
	
//ENVÍA EL TWITT	
}else{
$connuni = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db, $connuni) or die(mysql_error());

$_POST['status'] = substr($_POST['status'],0,$numero_caracteres);
if($twitpicurl){$_POST['status'] =$twitpicurl." - ".$_POST['status'];}
//record the occurence 
// I comment this part of the code from NETTUTS.mysql_escape_string(htmlentities(strip_tags($_POST['status']))). htmlentities( NOW I UNDERSTAND WHY I SHOULD NOT BAN THIS xD
$query = 'INSERT INTO mt_statuses (user_id, status, date_set) VALUES ('.$_SESSION['user_id'].',\''.mysql_escape_string(strip_tags($_POST['status'])).'\',NOW())';
$result = @mysql_query($query,$connuni);

//die if this was done via ajax...
if($_POST['ajax']) { die(); } else { 
//$message = '<div id="message">'.$indexphp_updated.'</div>'; 
$message = '<script type="text/javascript">
<!--
var notManager1 = new Notimoo();
   notManager1.show({
      title: \'<span class="correcto">Notification</span>\',
      message: \'<span class="correcto"><img border=0 align="left" src="./inc/icons/email.png">&nbsp; &nbsp;'.$indexphp_updated.'</span>\'
   });

// -->
</script>';
}
}
}	
}
	


#######################
##  SMS UPDATED      ##
#######################
?>

<!-- SMS send gren or red-->

<?php echo $message; ?>
<?php
if(($_POST['twitter_no_trust']=="yes") or ($_POST['twitter_update_acc1']=="yes") or ($_POST['twitter_update_acc2']=="yes") or ($_POST['twitter_update_acc3']=="yes")){

if($twitpicurl){
echo "<div id=\"message_twitpic\">".$indexphp_tpupdated."</div>";
}else{

if(isset($_POST['status']) && !isset($error)){ 
echo $twitter_status; 
}elseif(isset($error)){
echo "<div id=\"message_error\">".$indexphp_errort."</div>"; 

}

}

}

//Uncomment this line to hide global timeline
if($logged_in){ 
##############################################

?>
<div class="contenidonormal">
<!-- Tab menus http://www.dynamicdrive.com/dynamicindex17/tabcontent.htm -->
<ul id="countrytabs" class="shadetabs">
<li><a href="#" rel="country1" class="selected">
<?php 
if($_GET["user"]){ 
name(addslashes($_GET["user"]));

}else{
if($show=="following"){
echo $indexphp_fl;
}else{
echo $indexphp_pt;
}}
?>
</a></li>


<?php $todofile = md5($_SESSION['user_id']."_todo_list");
if(file_exists("./todo/".$todofile.".txt")==false){
}else{
if(filesize("./todo/".$todofile.".txt")<="0"){

}else{
if(file_exists("./todo/".$todofile.".txt")==true){
echo "<li><a href=\"#\" rel=\"country2\">".$indexphp_tdl."</a></li>";} 
}
}
?>

<?php
$query  = "SELECT group_name ,members_twitter FROM mt_group WHERE admin_id='$id_usr'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
$gh=3;
if(mysql_num_rows($result)<=3){


while($row = mysql_fetch_assoc($result)){
echo "<li><a href=\"#\" rel=\"country".$gh."\">".$row["group_name"]." "; 
if($row["members_twitter"]!=""){ echo "(t)";}
echo "</a></li>";
$gh=$gh+1;
}

}elseif(mysql_num_rows($result)>3){

echo "<li><a href=\"javascript:countries.cycleit('prev')\">
<!-- img src=\"".$pth."inc/icons/buttom-left.png\" border=0 alt=\"buttom-left\"/ -->
<strong>≪</strong>
</a></li>";
$ghb="1";

while($row = mysql_fetch_assoc($result)){
echo "<li><a href=\"javascript: countries.expandit(".$gh.")\" rel=\"country".$gh."\">".$ghb." ";
if($row["members_twitter"]!=""){ echo "(t)";}
echo "</a></li>";
$gh=$gh+1;
$ghb=$ghb+1;
}

echo "<li><a href=\"javascript:countries.cycleit('next')\">
<!-- img src=\"".$pth."inc/icons/buttom-right.png\" border=0 alt=\"buttom-right\"/ -->
<strong>≫</strong></a></li>";
}
?>
</ul>


<?php 
if($_GET["user"]){
$userloop = $_GET["user"];
loop($id_usr,"User",$userloop,$follow,"1","");
}elseif((!$_GET["user"])&&($show=="following")){
loop($id_usr,"Following","",$follow."".$id_usr.",","1","");
}else{
loop($id_usr,"Public timeline","",$follow,"1",""); 
}

$query  = "SELECT id_group, group_name,group_desc, members, members_twitter FROM mt_group WHERE admin_id='$id_usr'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
$gh=3;

while($row = mysql_fetch_assoc($result)){
if($row["members_twitter"]!=""){

echo "<div id=\"country".$gh."\" class=\"tabcontent\"><div id=\"statuses\">";
echo "<table width=\"445\"><thead>
	
	<tr>
	<td>";
	echo "<form style=\"float: left; margin-top: 3px; margin-left: 3px; position: absolute;\" action=\"\" name=\"delete_group\" method=\"post\">";	
	echo "<input type=\"image\" src=\"".$pth."inc/icons/gr_dl.png\" name=\"delete_group_id\" value=\"".$row["id_group"]."\">";
	echo "</form>";
	echo "<div style=\"margin-left: 25px;\">";
	echo utf8_encode($row["group_desc"]);
	
	$members_message= explode(",",$row["members_twitter"]);
	$b=0;
	while($members_message[$b]){
	$group_replie .= "@".$members_message[$b]." ";
	$b = $b+1;
	}
	
	echo " <a href=\"#\" style=\"border: 0px;\" onclick=\"insertAtCaret('status','".$group_replie."');\">".$indexphp_smsgr."</a>"; 
	echo "</div>";
	
	echo "</td>
	</tr>
	</thead><tbody>";
	


echo "</table>";
echo "</div>
</div>";

}else{
echo loop($id_usr,"Following","",$row["members"],$gh,$row["id_group"]);
}
$gh=$gh+1;
}

//echo loop($id_usr, "Following","","3,14,","3");
?>


<?php
$todofile = md5($_SESSION['user_id']."_todo_list");
if(file_exists("./todo/".$todofile.".txt")==true){
echo "<div id=\"country2\" class=\"tabcontent\">";
echo "<div id=\"statuses\">";
echo "<h3><a href=\"#\" title=\"Nueva nota\" style=\"border: 0px;\" onclick=\"insertAtCaret('status','TODO ');\"><img border=0 align=\"left\" src=\"".$pth."/inc/icons/tdl.png\" alt=\"tdl\" /></a>";
name($_SESSION['user_id']);
echo $indexphp_tdlm."</h3>";

echo "<ul>";
$todo = file_get_contents($pth.'/todo/'.$todofile.'.txt');
$num=1;
foreach (explode("\n",$todo) as $Linea){
list($tempo,$id_usr_tdo_list,$todo_term,) = explode('|', $Linea);
if($todo_term==""){}else{ 

echo "<li><a href=\"#\" title=\"Borrar Nota\" style=\"border: 0px;\" onclick=\"insertAtCaret('status','DONE _".$num."_');\"><img border=0 src=\"./inc/icons/action_stop.gif\"></a> "; 
echo "<big><b>".$num.".</big> ". ucfirst($todo_term)."</b></li>";}
$num=$num+1;
}
echo "</ul>";

echo "</div><br>";
echo "</div>";
echo "<div style=\"clear: both;\"></div>";

}

?>
<!-- END TAB 2 -->
<?php
##############################################
//Uncomment this line to hide global timeline
}else{
//echo "<h3>".$indexphp_pvtl."</h3>";
}

}
?>



</div>
</div>

<!-- TAB JAVASCRIPT -->
<script type="text/javascript">
var countries=new ddtabcontent("countrytabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()
</script>


<div style="clear: both;"></div>

<!- Fooooooooter Please do not remove this line -->
<div class="piedepagina"><?php echo $indexphp_foot; ?>
<br><a href="http://sourceforge.net/donate/index.php?group_id=246255"><img src="http://images.sourceforge.net/images/project-support.jpg" width="88" height="32" border="0" alt="Support This Project" /></a></div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-589888-15");
pageTracker._trackPageview();
</script>
</body>
</html>