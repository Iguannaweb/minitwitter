<?php
if(!defined('MiniTwitter_ON')){

     die('Hacking attempt');
}

//#################//
//ESTA FUNCIÓN SE VA A OCUPAR DE PROTEGERNOS CONTRA LAS INYECCIONES.
function avoid_injection($string){
if(get_magic_quotes_gpc()){	
$string=stripslashes($string);   
}
$secure_string=mysql_real_escape_string($string);  
//$secure_string=addslashes($string);
return $secure_string;
}
//Es muy básica tu la puedes hacer más "pro", realizando una comprobación de versiones de PHP para usar addslashes/mysql_real_escape_string
//Esta función la incorporamos en todas las llamadas a la base de datos, yo lo voy a hacer en este fichero pero creo
//que hay llamadas fuera de aquí también, en realidad, sólo es importante donde leamos datos de entrada del usuario.
//By y3nh4cker xD
//#################//

function name($id){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, nick FROM mt_users WHERE id_usr='".avoid_injection($id)."'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
echo $row["nick"];
} 

}

function tag_cloud(){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT status FROM mt_statuses WHERE status LIKE '%#%'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
$num=mysql_num_rows($result);
while($row = mysql_fetch_assoc($result)){
$twp = sacar($row["status"]," #"," ");
//$t=$t+1;
if($twp==""){}else{echo $twp.", ";}
}

//echo $num;
}

function idfromnick($nick){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, nick FROM mt_users WHERE nick='".avoid_injection($nick)."'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
return $row["id_usr"];
} 

}

function follow($followto,$userid){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, nick, follow FROM mt_users WHERE id_usr='".avoid_injection($userid)."' LIMIT 1";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);

while($row = mysql_fetch_assoc($result)){

	if($row["follow"]==""){
	$follow=$followto.",";
	//echo $follow;
	
	$query_follow  = "UPDATE mt_users SET follow = '".avoid_injection($follow)."' WHERE id_usr='".avoid_injection($userid)."'";
	mysql_query($query_follow,$connuni) or die(mysql_error().': '.$query);
	
	echo "Now, you are following user: <b>";
	name($followto);
	echo "</b>";
	}else{
	
		if(strstr($row["follow"], $followto)==true){
		echo "You are following already user: <b>";
		name($followto);
		echo "</b>";
		
		}else{
		$follow=$row["follow"]."".$followto.",";
		$query_follow  = "UPDATE mt_users SET follow = '".avoid_injection($follow)."' WHERE id_usr='".avoid_injection($userid)."'";
		mysql_query($query_follow,$connuni) or die(mysql_error().': '.$query);
		
		echo "Now, you are following user <b>";
		name($followto);
		echo "</b>";
		}
	
	}

}


}

function unfollow($unfollowto,$userid){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, nick, follow FROM mt_users WHERE id_usr='".avoid_injection($userid)."' LIMIT 1";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);

while($row = mysql_fetch_assoc($result)){

	if($row["follow"]==""){
	echo "You are a bad follower. <b>Currently you are not following anybody</b>";
	
	}else{
	
		if(strstr($row["follow"], $unfollowto)==true){
		
		$unfollowtocom=$unfollowto.",";
		
		$unfollow = ereg_replace($unfollowtocom,"", $row["follow"]);
		
		$query_follow  = "UPDATE mt_users SET follow = '".avoid_injection($unfollow)."' WHERE id_usr='".avoid_injection($userid)."'";
		mysql_query($query_follow,$connuni) or die(mysql_error().': '.$query);

		echo "Now, You are <b>not</b> following user: <b>";
		name($unfollowto);
		echo "</b>";
		
		}else{

		echo "Are you sure you were following user <b>";
		name($unfollowto);
		echo "</b>? Sorry but you can unfollow people you are not following!";
		}
	
	}

}


}

function last($id){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT status_id,status, user_id FROM mt_statuses WHERE user_id='".avoid_injection($id)."' ORDER BY status_id DESC LIMIT 1";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
return $row["status"];
} 

}

function name_hide($id){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, nick FROM mt_users WHERE id_usr='".avoid_injection($id)."'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
//echo "<a href=\"#\" onclick=\"insertAtCaret('status','@".$row["nick"]."');\">".$row["nick"]."</a>";
return $row["nick"];
} 

}

function gravatar($id){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, nick, gravatar FROM mt_users WHERE id_usr='".avoid_injection($id)."'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
return $row["gravatar"];
} 

}

function correo($id){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT id_usr, correo FROM mt_users WHERE id_usr='".avoid_injection($id)."'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
while($row = mysql_fetch_assoc($result)){
return $row["correo"];
} 

}

function remove($id_status){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "DELETE FROM mt_statuses WHERE status_id='".avoid_injection($id_status)."'";
mysql_query($query,$connuni) or die(mysql_error().': '.$query);
echo "Status n. ".$id_status." deleted!";

}


function getGravatarUrl($email, $defImg, $size, $rating) {
$defImg="monsterid";
  return "http://www.gravatar.com/avatar.php?gravatar_id=".md5($email).
      "&r=".$rating."&s=".$size."&d=".urlencode($defImg);
}


function emoticons($texto){
$texto = ereg_replace(";)","<img src=\"./inc/emoticons/wink.gif\" border=0>", $texto);
$texto = ereg_replace("ò_ó","<img src=\"./inc/emoticons/angry.gif\" border=0>", $texto);
$texto = ereg_replace("\:\_\(","<img src=\"./inc/emoticons/crying.gif\" border=0>", $texto);
$texto = ereg_replace("xD","<img src=\"./inc/emoticons/laughing.gif\" border=0>", $texto);
$texto = ereg_replace("XD","<img src=\"./inc/emoticons/laughing.gif\" border=0>", $texto);
$texto = ereg_replace("\:\(","<img src=\"./inc/emoticons/sad.gif\" border=0>", $texto);
$texto = ereg_replace(":)","<img src=\"./inc/emoticons/smile.gif\" border=0>", $texto);
$texto = ereg_replace(":P","<img src=\"./inc/emoticons/tongue.gif\" border=0>", $texto);
$texto = ereg_replace(":O","<img src=\"./inc/emoticons/wassat.gif\" border=0>", $texto);


return $texto;
}

function replies($texto){
$texto = ereg_replace("(@[[:alnum:]]*)","<a style=\"color: orange;\" href='#' onclick=\"insertAtCaret('status','\\1');\">\\1</a>", $texto);

return $texto;
}

function channels($texto){
$texto = ereg_replace("(#[[:alnum:]]*)","<a style=\"color: red;\" href='#' onclick=\"insertAtCaret('status','\\1');\">\\1</a>", $texto);

return $texto;
}



function replace_urls($string){
    $host = "([a-z\d][-a-z\d]*[a-z\d]\.)+[a-z][-a-z\d]*[a-z]";
    $port = "(:\d{1,})?";
    $path = "(\/[^?<>\#\"\s]+)?";
    $query = "(\?[^<>\#\"\s]+)?";
    //return preg_replace("#((ht|f)tps?:\/\/{$host}{$port}{$path}{$query})#i", "<a href='$1'>$1</a>", $string);
    return preg_replace("#((ht|f)tps?:\/\/{$host}{$port}{$path}{$query})#i", "<a href='$1'>$1</a>", $string);
}
function sacar($TheStr, $sLeft, $sRight){
        $pleft = strpos($TheStr, $sLeft, 0);
        if ($pleft !== false){
                $pright = strpos($TheStr, $sRight, $pleft + strlen($sLeft));
                If ($pright !== false) {
                        return (substr($TheStr, $pleft + strlen($sLeft), ($pright - ($pleft + strlen($sLeft)))));
                }
        }
        return '';
}

function replace_unu($string){
    $host = "u\.nu";
    $port = "(:\d{1,})?";
    $path = "(\/[^?<>\#\"\s]+)?";
    $query = "(\?[^<>\#\"\s]+)?";
    //return preg_replace("#((ht|f)tps?:\/\/{$host}{$port}{$path}{$query})#i", "<a href='$1'>$1</a>", $string);
    return preg_replace("#((ht|f)tps?:\/\/{$host}{$port}{$path}{$query})#i", "<a href='$1'>$1</a>", $string);
}


function replace_images($string){
	
	$string = ereg_replace("twitpic.com/([[:alnum:]]*)", "twitpic.com/show/thumb/\\1.jpg", $string);
    //echo $string;

    $twp = sacar($string,"http://twitpic.com/show/thumb/",".jpg");
    if($twp!=""){
    echo "<a style='margin: 2px;' target='_blank' href='http://twitpic.com/".$twp."/full'><img width='120' height='80' src='http://twitpic.com/show/thumb/".$twp.".jpg'></a>";
    }
    
    $gif = sacar($string,"http://",".gif");
    if($gif!=""){
    echo "<a style='margin: 2px;' target='_blank' href='http://".$gif.".gif'><img width='120' height='80' src='http://".$gif.".gif'></a>";
    }
    
    $png = sacar($string,"http://",".png");
    if($png!=""){
    echo "<a style='margin: 2px;' target='_blank' href='http://".$png.".png'><img width='120' height='80' src='http://".$png.".png'></a>";}
    
    
    $jpg = sacar($string,"http://",".jpg");
    if(($jpg!="") && (strstr($jpg,"twitpic")==false)){
    echo "<a style='margin: 2px;' target='_blank' href='http://".$jpg.".jpg'><img width='120' height='80' src='http://".$jpg.".jpg'></a>";}
}

/*I know it's just a silly action but if you don't know php you wont know password encoded of twitter*/
function encode($originalStr)
{
    $encodedStr = $originalStr;
    $num = mt_rand(1,6);
    for($i=1;$i<=$num;$i++)
    {
    $encodedStr = base64_encode($encodedStr);
    }
    $seed_array = array('S','H','A','F','I','Q');
    $encodedStr = $encodedStr . "+" . $seed_array[$num];
    $encodedStr = base64_encode($encodedStr);
    return $encodedStr;
}

function decode($decodedStr)
{
    $seed_array = array('S','H','A','F','I','Q');
    $decoded =  base64_decode($decodedStr);
    list($decoded,$letter) =  split("\+",$decoded);
    for($i=0;$i<count($seed_array);$i++)
    {
      if($seed_array[$i] == $letter)
      break;
    }
    for($j=1;$j<=$i;$j++)
    {
     $decoded = base64_decode($decoded);
    }
    return $decoded;
} 

function total_udates($id)
{
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$query  = "SELECT status_id,user_id FROM mt_statuses WHERE user_id='".avoid_injection($id)."'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
echo mysql_num_rows($result);

}

function total_replies($id)
{
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$nombre = name_hide($id);
$query  = "SELECT status_id,user_id FROM mt_statuses WHERE status like '%@".avoid_injection($nombre)."%'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
echo mysql_num_rows($result);

}

function followers($id)
{
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
$nombre = name_hide($id);
$query  = "SELECT follow FROM mt_users WHERE follow like '%".avoid_injection($id).",%'";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
echo mysql_num_rows($result);

}

function get_followers($id)
{
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);
//$nombre = name_hide($id);
$query  = "SELECT id_usr,nick,follow FROM mt_users WHERE id_usr='".avoid_injection($id)."' LIMIT 1";
$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);

while($row = mysql_fetch_assoc($result)){
return $row["follow"];
}

}

function str_makerand ($minlength, $maxlength, $useupper, $usespecial, $usenumbers)
{
/*
Author: Peter Mugane Kionga-Kamau
http://www.pmkmedia.com

Description: string str_makerand(int $minlength, int $maxlength, bool $useupper, bool $usespecial, bool $usenumbers)
returns a randomly generated string of length between $minlength and $maxlength inclusively.

Notes:
- If $useupper is true uppercase characters will be used; if false they will be excluded.
- If $usespecial is true special characters will be used; if false they will be excluded.
- If $usenumbers is true numerical characters will be used; if false they will be excluded.
- If $minlength is equal to $maxlength a string of length $maxlength will be returned.
- Not all special characters are included since they could cause parse errors with queries.

Modify at will.
*/
$charset = "abcdefghijklmnopqrstuvwxyz";
if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
if ($usenumbers) $charset .= "0123456789";
if ($usespecial) $charset .= "~@#$%^*()_+-={}|]["; // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";
if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
else $length = mt_rand ($minlength, $maxlength);
for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
return $key;
}

function mailto_add($to,$follower){
//$to = "recipient@example.com";
$subject = "Ey! ".$follower." is now following you!";
$body = "Hi,\n\nHow are you?\n\nThis message is sent to you just to allow you to know who people is now following you! Visit ".$follower.", and if you like him/her updates, just follow back hime/her ;)";
//$headers = "From: no-reply@example.com\r\n" .
   // "X-Mailer: php";
if (mail($to, $subject, $body)) {
  echo("<p>Message sent to the user you want to follow</p>");
 } else {
  echo("<p>Message delivery failed, uhmm...</p>");
 }
}

function mailto_less($to,$follower){
//$to = "recipient@example.com";
$subject = "Ey! ".$follower." is now un-following you!";
$body = "Hi,\n\nHow are you?\n\nThis message is sent to you just to allow you to Know who people is now un-following you! Sorry, but maybe you are not so interesting as you think...";
//$headers = "From: no-reply@example.com\r\n" .
   // "X-Mailer: php";
if (mail($to, $subject, $body)) {
  echo("<p>Message sent to the user you want to un-follow</p>");
 } else {
  echo("<p>Message delivery failed, uhmm...</p>");
 }
}

//PARSEAR XML
function CargarXML($ruta_fichero) {
if(@fopen($ruta_fichero,"r")==false){
echo "<small>Rate limit exceeded. Clients may not make more than 100 requests per hour.</small>";
}else{
$contenido = "";
if($da = fopen($ruta_fichero,"r")){

while ($aux= fgets($da,1024)){
$contenido.=$aux;
}

fclose($da);

}else{
echo "Error: can't read <strong>$ruta_fichero</strong>";
}

$contenido=ereg_replace("á","a",$contenido);
$contenido=ereg_replace("é","e",$contenido);
$contenido=ereg_replace("í","i",$contenido);
$contenido=ereg_replace("ó","o",$contenido);
$contenido=ereg_replace("ú","u",$contenido);
$contenido=ereg_replace("Á","A",$contenido);
$contenido=ereg_replace("É","E",$contenido);
$contenido=ereg_replace("Í","I",$contenido);
$contenido=ereg_replace("Ó","O",$contenido);
$contenido=ereg_replace("Ú","U",$contenido);
$contenido=ereg_replace("Ñ","NI",$contenido);
$contenido=ereg_replace("ñ","ni",$contenido);

$tagnames = array ("created_at","id","screen_name","profile_image_url","text","error");

if (!$xml = domxml_open_mem($contenido)){
echo "Error processing<br>";
exit;
}else{
$raiz = $xml->document_element();

$tam=sizeof($tagnames);

for($i=0; $i<$tam; $i++) {
$nodo = $raiz->get_elements_by_tagname($tagnames[$i]);
$j=0;
foreach ($nodo as $etiqueta)
{
$matriz[$j][$tagnames[$i]]=$etiqueta->get_content();
$j++;
}
}

return $matriz;
} 
}
}


//BIG FUNCTION LOOP

	
function loop($id_usr, $type,$userloop,$follow,$tabnumber, $id_group){
include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);

echo "<!-- START TAB ".$tabnumber." -->";
echo "<div id=\"country".$tabnumber."\" class=\"tabcontent\">
	<div id=\"statuses\">";
	
//Choose type!
if($type == "Public timeline"){

$sql0  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses ORDER BY date_set DESC";

}elseif($type == "Following"){

$long = strlen($follow);
//echo $long;
$long_m = $long-1;
//echo $long_m;
$follow_m = substr($follow,-$long,$long_m);
//echo $follow_m;
$sql0  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses WHERE user_id IN (".avoid_injection($follow_m).") ORDER BY date_set DESC";
//This is to show user updates with following option to show  OR user_id='$id_usr' 

}elseif($type == "User"){

$usern = name_hide($userloop);
$sql0  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses WHERE user_id='".avoid_injection($userloop)."' OR status LIKE '%@".avoid_injection($usern)."%' ORDER BY date_set DESC";

}

/*For all*/
/*get page*/
$registros = 15;
$pagina = $_GET["pagina"];

if (!$pagina) { $inicio = 0; $pagina = 1;
}else { $inicio = ($pagina - 1) * $registros;}
/*end get page*/



$r0=mysql_query($sql0, $connuni) or die('La consulta fall&oacute;:' .mysql_error($enlace));
$total_registros = mysql_num_rows($r0);

if($type == "User"){

$usern = name_hide($userloop);
$query  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses WHERE user_id='".avoid_injection($userloop)."' OR status LIKE '%@".avoid_injection($usern)."%' ORDER BY date_set DESC LIMIT $inicio, $registros";

}elseif($type == "Following"){

$long = strlen($follow);
//echo $long;
$long_m = $long-1;
//echo $long_m;
$follow_m = substr($follow,-$long,$long_m);
//echo $follow_m;
$query  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses WHERE user_id IN (".avoid_injection($follow_m).") ORDER BY date_set DESC LIMIT $inicio, $registros";
//This is to show user updates with following option to show  OR user_id='$id_usr' 


}elseif($type == "Public timeline"){

$query  = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses ORDER BY date_set DESC LIMIT $inicio, $registros";

}


$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
$total_paginas = ceil($total_registros / $registros);

//This table was for pagination but I changed it for another one without js	

//Page links an title
	echo "<table width=\"445\"><thead>
	
	<tr>
	<td>";
	if($id_group!=""){
	echo "<form style=\"float: right;margin-top: 3px; margin-right: 3px; position: absolute;\" action=\"\" name=\"delete_group\" method=\"post\">";	
	echo "<input type=\"image\"  src=\"".$pth."inc/icons/gr_dl.png\" name=\"delete_group_id\" value=\"".$id_group."\">";
	echo "</form>";
	$des  = "SELECT group_desc, members FROM mt_group WHERE id_group='".avoid_injection($id_group)."'";
	$resultdes = mysql_query($des,$connuni) or die(mysql_error().': '.$query);
	
	while($row = mysql_fetch_assoc($resultdes)){
	echo "<div style=\"margin-left: 25px;\">";
	echo $row["group_desc"];
	$members_message= explode(",",$row["members"]);
	$b=0;
	while($members_message[$b]){
	$namem = name_hide($members_message[$b]);
	$group_replie .= "@".$namem." ";
	$b = $b+1;
	}
	
	echo " <a href=\"#\" style=\"border: 0px;float: right;\" onclick=\"insertAtCaret('status','".$group_replie."');\"><img border=0 src=\"./inc/icons/group_go.png\"></a>"; 
	echo "</div>";
	}
	}	
	
	echo "</td></tr></thead><tbody>";
	

//loop
	while($row = mysql_fetch_assoc($result)){
	
	echo '<tr><td>
	<div class="status-box">
	<div style="float: left; width: 430px;">';
	
	echo "<form style=\"float: right;\" action=\"\" method=\"post\">";	
	if($id_usr == $row['user_id']){
	echo "<input type=\"image\" src=\"".$pth."inc/icons/dl.png\" name=\"status_id\" value=\"".$row["status_id"]."\">";
	}
	echo "</form>";
	
	echo "<form style=\"float: right;\" action=\"\" method=\"post\">";	
	if($id_usr != $row['user_id']){
	if(strstr($follow,$row['user_id'])==true){
	}else{
	echo "<input type=\"image\" src=\"".$pth."inc/icons/+.png\" name=\"status_id_mas\" value=\"".$row["user_id"]."\">";
	}
	}
	echo "</form>";
	
	echo "<form style=\"float: right; ";
	
	if(strstr($follow,$row['user_id'])==true){}else{echo "margin-top: 12px;  margin-right: -9px;";}
	
	echo "\" action=\"\" method=\"post\">";	
	if($id_usr != $row['user_id']){
	if(strstr($follow,$row['user_id'])==true){
	echo "<input type=\"image\" src=\"".$pth."inc/icons/-.png\" name=\"status_id_menos\" value=\"".$row["user_id"]."\">";
	}else{}
	}
	echo "</form>";
	
//avatar
	if(gravatar($row['user_id'])=="yes"){
	$grav_correo = correo($row["user_id"]);
	echo "<a class=\"avatar\" href=\"index.php?user=".$row["user_id"]."\">";
	echo "<img width=\"48\" height=\"48\" align=\"left\" style=\"margin-right: 5px;\" border=\"1\" src=\"";
	echo getGravatarUrl($grav_correo, $defImg,  "80", "G");
	echo "\" alt=\"Gravatar\"></a>"; 
	

	}else{
	if(file_exists("./avatar/".$row['user_id'].".jpg")==true){ 
	echo "<a class=\"avatar\" href=\"index.php?user=".$row["user_id"]."\">";
	echo '<img align="left" width="48" height="48" style="margin-right: 5px;" border=\"1\" 
	src="'.$pth.'avatar/',$row['user_id'],'.jpg"></a>';}
	else {
	echo "<a class=\"avatar\" href=\"index.php?user=".$row["user_id"]."\">";
	echo '<img align="left" width="48" height="48" style="margin-right: 5px;" border=\"1\" 
	src="'.$defImg.'"></a>';}
	
	}
	
//user
	echo "<b>";
	echo "<a href=\"#\" onclick=\"insertAtCaret('status','@";
	name($row['user_id']);
	echo " ');\">";
	name($row['user_id']);
	echo "</a>";
	echo " </b>";
//sms
	//echo replies(emoticons(replace_urls(stripslashes($row['status']))))
	
	$status = replace_urls(stripslashes($row['status']));
	$status = replace_unu($status);
	$status = emoticons($status);
	$status = channels($status);
	echo replies($status);
	
	echo '</div><span class="time">',$row['ds'],'</span>';
	echo " <a href=\"index.php?user=".$row['user_id']."\" style=\"border: 0px;\">
	<img style=\"border: 0px;\" src=\"".$pth."inc/icons/u.png\" alt=\"u\"/></a> 
	<a href=\"#\" style=\"border: 0px;\" onclick=\"insertAtCaret('status','@";
	name($row['user_id']);
	echo " ');\">
	<img style=\"border: 0px;\" src=\"".$pth."inc/icons/r.png\" alt=\"r\"/></a>"; 
	//echo "<img src=\"inc/icons/d.png\" alt=\"d\"/> 
	//<img src=\"inc/icons/f.png\" alt=\"f\"/> ";
	
	echo "</div></td></tr>";
	
	}

?>

<!-- foot table with link pages buttoms-->
	</tbody>
		<tfoot>
		<td>
			<center>
	<?php
	if(($pagina - 1) > 0) {

		if($type == "User"){
			echo "<a id=\"nuevo\" href=\"index.php?user=".$userloop."&pagina=".($pagina-1)."\">&nbsp;Newer&nbsp;</a>";
		
		}else{
		echo "<a id=\"nuevo\" href=\"index.php?pagina=".($pagina-1)."\">&nbsp;Newer&nbsp;</a>";
		}
	
	}else{
		if($type == "User"){
		echo "<a id=\"nuevorss\" href=\"rss.php?user=".name_hide($userloop)."\">&nbsp;Rss&nbsp;</a>";
		}else{
		echo "<a id=\"nuevorss\" href=\"rss.php\">&nbsp;Rss&nbsp;</a>";
		}
	
	}
	
	if(($pagina + 1)<=$total_paginas) {
	
	if($type == "User"){
		echo "<a id=\"viejo\" href=\"index.php?user=".$userloop."&pagina=".($pagina+1)."\">&nbsp;Older&nbsp;</a>";
	
	}else{
	
		echo "<a id=\"viejo\" href=\"index.php?pagina=".($pagina+1)."\">&nbsp;Older&nbsp;</a>";
	
	}
	}else{ }

	
	?>
			</center>
		</td>
		</tfoot>
	</table>
	</div>
<br><br>
<div style="clear: both;"></div>
<!-- END TAB <?php echo $tabnumber; ?> -->
</div>

<?php
}
?>
