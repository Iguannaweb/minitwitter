<?php
if(!defined('MiniTwitter_ON')){

     die('Hacking attempt');
}

    /*== FUNCTIONS ==*/

    function getFileExtension($str) {

        $i = strrpos($str,".");
        if (!$i) { return ""; }

        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);

        return $ext;

    }
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){

//$id_usr = addslashes($_POST["id_usr"]);

$id_usr = $_SESSION['user_id'];

          if($_FILES['new_image']['name']==""){}else{
              $imagename = $_FILES['new_image']['name'];
              $pext = getFileExtension($imagename);
              $source = $_FILES['new_image']['tmp_name'];
              $target = "avatar/".$imagename;
              move_uploaded_file($source, $target);
 
              $imagepath = $imagename;
              $save = "avatar/ori/".$id_usr.".".$pext; //This is the new file you saving
              $file = "avatar/" . $imagepath; //This is the original file
 
              list($width, $height) = getimagesize($file) ; 
 
              $modwidth = 250; 
 
              $diff = $width / $modwidth;
 
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 
              $image = imagecreatefromjpeg($file) ; 
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
 
              imagejpeg($tn, $save, 100) ; 
 
              $save = "avatar/" . $id_usr.".".$pext; //This is the new file you saving
              $file = "avatar/" . $imagepath; //This is the original file
 
              list($width, $height) = getimagesize($file) ; 
 
              $modwidth = 40; 
 
              $diff = $width / $modwidth;
 
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 
              $image = imagecreatefromjpeg($file) ; 
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
 
              imagejpeg($tn, $save, 100) ; 
              unlink("avatar/".$imagename);
            //echo "<img src='avatar/ori/".$id_usr.".jpg'>"; 
            //echo "<img src='avatar/".$id_usr.".jpg'>"; 
 
          }



//}
//------------------------------------------------------//


$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$dia = $_POST["fechadia"];
$mes = $_POST["fechames"];
$anio = $_POST["fechaanio"];
$correo = $_POST["correo"];
$bio = $_POST["bio"];
$gravatar = $_POST["gravatar"];
$timeline = $_POST["timeline"];
$country = $_POST["country"];
$state = $_POST["state"];
$sex = $_POST["sex"];
$show = $_POST["showing"];

/*Twitter*/
$twitter = $_POST["twitter"];


if($twitter=="yes"){

/*if(($twitterpublicusername!="") && ($twitterpublicpass!="")){
$twitterP1 = encode($twitterpublicpass);
$account1= $twitterpublicusername."||".$twitterP1."||".$twitterpubliccheck."@@@";


}else{*/

$twitterU1 = $_POST["twitterU1"];

if($_POST["twitterP1"]==""){
$account1 = $twitterU1."||||@@@";
}else{
$twitterP1 = encode($_POST["twitterP1"]);
$checktwitter1 = $_POST["checktwitter1"];
$account1= $twitterU1."||".$twitterP1."||".$checktwitter1."@@@";
}

//}

$twitterU2 = $_POST["twitterU2"];
if($_POST["twitterP2"]==""){
$account2 = $twitterU2."||||@@@";
}else{
$twitterP2 = encode($_POST["twitterP2"]);
$checktwitter2 = $_POST["checktwitter2"];
$account2= $twitterU2."||".$twitterP2."||".$checktwitter2."@@@";
}

$twitterU3 = $_POST["twitterU3"];
if($_POST["twitterP3"]==""){
$account3 = $twitterU3."||||@@@";
}else{
$twitterP3 = encode($_POST["twitterP3"]);
$checktwitter3 = $_POST["checktwitter3"];
$account3= $twitterU3."||".$twitterP3."||".$checktwitter3."@@@";
}

$twitteraccounts = $account1."".$account2."".$account3."";
//echo $twitter;
}else{
$twitteraccounts = "";
}

/*Password*/
$pass1 = $_POST["pass1"];
$pass2 = $_POST["pass2"];

	

if($pass1!=$pass2){
echo "Passwords are differents! Please <a href=\"javascript:history.go(-1)\">go back</a> and make sure you type correctly the same in both fields.";

}elseif(($pass1=="") or ($pass2=="")){
$optquery  = "UPDATE mt_users SET nombre = '".avoid_injection(strip_tags($nombre))."', apellidos = '".avoid_injection(strip_tags($apellidos))."', country = '".avoid_injection(strip_tags($country))."', state='".avoid_injection(strip_tags($state))."', sex='".avoid_injection(strip_tags($sex))."', correo = '".avoid_injection(strip_tags($correo))."', dia = '".avoid_injection(strip_tags($dia))."', mes = '".avoid_injection(strip_tags($mes))."', anio = '".avoid_injection(strip_tags($anio))."', bio = '".avoid_injection(strip_tags($bio))."', gravatar = '".avoid_injection(strip_tags($gravatar))."' , timeline = '".avoid_injection(strip_tags($timeline))."', showing = '".avoid_injection(strip_tags($show))."', twitter = '".avoid_injection(strip_tags($twitter))."', accounts = '".avoid_injection(strip_tags($twitteraccounts))."' WHERE id_usr = '".avoid_injection(strip_tags($id_usr))."'";

mysql_query($optquery,$connuni) or die(mysql_error().': '.$optquery);

echo "<b>Changes has been saved!</b>.";

}elseif(($pass1!="") or ($pass2!="") && ($pass1==$pass2)){
$password = md5($pass1);
$optquery  = "UPDATE mt_users SET nombre = '".avoid_injection(strip_tags($nombre))."', apellidos = '".avoid_injection(strip_tags($apellidos))."', country = '".avoid_injection(strip_tags($country))."', state='".avoid_injection(strip_tags($state))."', sex='".avoid_injection(strip_tags($sex))."', password = '".avoid_injection(strip_tags($password))."', correo = '".avoid_injection(strip_tags($correo))."', dia = '".avoid_injection(strip_tags($dia))."', mes = '".avoid_injection(strip_tags($mes))."', anio = '".avoid_injection(strip_tags($anio))."', bio = '".avoid_injection(strip_tags($bio))."', gravatar = '".avoid_injection(strip_tags($gravatar))."' , timeline = '".avoid_injection(strip_tags($timeline))."', showing = '".avoid_injection(strip_tags($show))."', twitter = '".avoid_injection(strip_tags($twitter))."', accounts = '".avoid_injection(strip_tags($twitteraccounts))."'  WHERE id_usr = '".avoid_injection(strip_tags($id_usr))."'";

mysql_query($optquery,$connuni) or die(mysql_error().': '.$optquery);

echo "<b>Changes saved and password changed!</b>.";

} else {
$optquery  = "UPDATE mt_users SET nombre = '".avoid_injection(strip_tags($nombre))."', apellidos = '".avoid_injection(strip_tags($apellidos))."', apellidos = '".avoid_injection(strip_tags($apellidos))."', country = '".avoid_injection(strip_tags($country))."', sex='".avoid_injection(strip_tags($sex))."', state='".avoid_injection(strip_tags($state))."', correo = '".avoid_injection(strip_tags($correo))."', dia = '".avoid_injection(strip_tags($dia))."', mes = '".avoid_injection(strip_tags($mes))."', anio = '".avoid_injection(strip_tags($anio))."' , bio = '".avoid_injection(strip_tags($bio))."', gravatar = '".avoid_injection(strip_tags($gravatar))."', showing = '".avoid_injection(strip_tags($show))."', timeline = '".avoid_injection(strip_tags($timeline))."', twitter = '".avoid_injection(strip_tags($twitter))."', accounts = '".avoid_injection(strip_tags($twitteraccounts))."' WHERE id_usr = '".avoid_injection(strip_tags($id_usr))."'";

mysql_query($optquery,$connuni) or die(mysql_error().': '.$optquery);

echo "<b>Changes has been saved correctly</b>.";
}


}

$nick = $_SESSION["usernameuniversal"];
/*include('./inc/config.php');
$connuni = @mysql_connect($host, $user, $pass);
@mysql_select_db($db, $connuni);*/
$optquery  = "SELECT id_usr, nombre, apellidos, nick, password, country, state, correo, dia, mes, anio, sex, bio, gravatar, timeline, showing, twitter, accounts FROM mt_users WHERE nick='".avoid_injection($nick)."' LIMIT 1";
$optresult = mysql_query($optquery,$connuni) or die(mysql_error().': '.$optquery);
while($rowopt = mysql_fetch_assoc($optresult)){
?>
<h3>User options</h3>

<table border="0" cellpadding="5" cellspacing="0">
<form method="post" enctype="multipart/form-data" name="usr_uni" action="index.php?go=opt">
<input type="hidden" name="id_usr" value="<?php echo $rowopt["id_usr"]; ?>">

<tr>
<td><b>Name</b></td>
<td><input type="text" name="nombre" value="<?php echo $rowopt["nombre"]; ?>"></td>

<td><b><input type="checkbox" name="twitter" value="yes" 
<?php 
if($rowopt["twitter"]=="yes"){echo "checked";}
/*elseif(($twitterpublicusername!="") && ($twitterpublicpass!="")){
echo "checked";
}*/
?>> Twitter accounts*</b><br>
<small>MiniTwitter is not responsible of twitter accounts stolen, but your password will be saved encoded. Anyway, you must Know It is not a secure action.</small>
</td>
<td>
Account 1<br>
<?php
if($rowopt["twitter"]=="yes"){
$account = explode("@@@", $rowopt["accounts"]);
$account1 = explode("||", $account[0]);
}
//if(($twitterpublicusername!="") && ($twitterpublicpass!="")){
//echo "Public Twitter: <b>".$twitterpublicusername."</b>";

//}else{
?>
<input type="text" name="twitterU1" value="<?php echo $account1[0]; ?>"><br>
<input type="password" name="twitterP1" value="<?php echo decode($account1[1]); ?>"><br>
<small><input type="checkbox" name="checktwitter1" value="yes" <?php if($account1[2]=="yes"){echo "checked";}?>> Checked by default</small>
<?php 
//} 
?>
</td>
</tr>

<tr>
<td><b>Surname</b></td>
<td><input type="text" name="apellidos" value="<?php echo $rowopt["apellidos"]; ?>"></td>

<td>Account 2<br>
<?php
if($rowopt["twitter"]=="yes"){
$account2 = explode("||", $account[1]);
}
?>
<input type="text" name="twitterU2" value="<?php echo $account2[0]; ?>"><br>
<input type="password" name="twitterP2" value="<?php echo decode($account2[1]); ?>"><br>
<small><input type="checkbox" name="checktwitter2" value="yes" <?php if($account2[2]=="yes"){echo "checked";}?>> Checked by default</small></td>
<td>Account 3<br>
<?php
if($rowopt["twitter"]=="yes"){
$account3 = explode("||", $account[2]);
}
?>
<input type="text" name="twitterU3" value="<?php echo $account3[0]; ?>"><br>
<input type="password" name="twitterP3" value="<?php echo decode($account3[1]); ?>"><br>
<small><input type="checkbox" name="checktwitter3" value="yes" <?php if($account3[2]=="yes"){echo "checked";}?>> Checked by default</small></td>
</tr>

<tr>
<td><b>Born</b></td>
<td><input type="text" name="fechadia" size="2" value="<?php echo $rowopt["dia"]; ?>">/
<input type="text" name="fechames" size="2" value="<?php echo $rowopt["mes"]; ?>">/
<input type="text" name="fechaanio" size="4" value="<?php echo $rowopt["anio"]; ?>"><br>
<small>10/10/1985</small></td>

<td><b>Country</b></td>
<td><input type="text" name="country" value="<?php echo $rowopt["country"]; ?>"</td>
</tr>

<tr>
<td><b>e-mail</b></td>
<td><input type="text" name="correo" value="<?php echo $rowopt["correo"]; ?>"><br>
<small>ejemplo@ejemplo.com</small></td>

<td><b>State</b></td>
<td><input type="text" name="state" value="<?php echo $rowopt["state"]; ?>"</td>
</tr>

<tr>
<td><b>Show timeline?</b></td>
<td>
<input type="checkbox" name="timeline" value="yes" <?php if($rowopt["timeline"]=="yes"){echo "checked";}?>> Yes
</td>

<td><b>Gender</b></td>
<td><select name="sex" id="sex"> 
<option value="0" <?php if($rowopt["sex"]=="0"){ echo "selected=\"selected\""; }?>>Select One</option>
<option value="3" <?php if($rowopt["sex"]=="3"){ echo "selected=\"selected\""; }?>>Guy</option>
<option value="4" <?php if($rowopt["sex"]=="4"){ echo "selected=\"selected\""; }?>>Girl</option>
<option value="7" <?php if($rowopt["sex"]=="7"){ echo "selected=\"selected\""; }?>>Dude</option>
<option value="8" <?php if($rowopt["sex"]=="8"){ echo "selected=\"selected\""; }?>>Chicky-poo</option>
<option value="5" <?php if($rowopt["sex"]=="5"){ echo "selected=\"selected\""; }?>>Bloke</option>

<option value="11" <?php if($rowopt["sex"]=="11"){ echo "selected=\"selected\""; }?>>Bird</option>
<option value="6" <?php if($rowopt["sex"]=="6"){ echo "selected=\"selected\""; }?>>Lady</option>
<option value="10" <?php if($rowopt["sex"]=="10"){ echo "selected=\"selected\""; }?>>Gentleman</option>
<option value="1" <?php if($rowopt["sex"]=="1"){ echo "selected=\"selected\""; }?>>Male</option>
<option value="2" <?php if($rowopt["sex"]=="2"){ echo "selected=\"selected\""; }?>>Female</option>
<option value="12" <?php if($rowopt["sex"]=="12"){ echo "selected=\"selected\""; }?>>Transgender</option>
<option value="13" <?php if($rowopt["sex"]=="13"){ echo "selected=\"selected\""; }?>>Monkey</option>
<option value="14" <?php if($rowopt["sex"]=="14"){ echo "selected=\"selected\""; }?>>Bot</option>
<option value="9" <?php if($rowopt["sex"]=="9"){ echo "selected=\"selected\""; }?>>None of the Above</option>
</select>
</td>
</tr>

<input type="hidden" name="MAX_FILE_SIZE" value="2400000">
<tr>
<td colspan="2" style="width: 50%;">
<b>Avatar <small>Hosted by the server</small></b><br>
<?php
if(file_exists("./avatar/".$rowopt["id_usr"].".jpg") == true){ echo "<img border=\"1\" align=\"left\" hspace=\"4\" src=\"./avatar/".$rowopt["id_usr"].".jpg\">";} 
else {echo "<img border=\"1\" align=\"left\" hspace=\"4\" src=\"".$defImg."\" width=\"48\" height=\"48\">";} 
?>
<!-- input type="file" name="imgfile" -->
<input name="new_image" id="new_image" size="30" type="file" class="fileUpload" />
</td>

<td colspan="2">
<b>Gravatar</b><br>
<?php
echo "<img width=\"48\" border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"";
		echo getGravatarUrl($rowopt["correo"], $defImg,  "80", "G");
		echo "\" alt=\"Gravatar\">";
?>		
<input type="checkbox" name="gravatar" value="yes" <?php if($rowopt["gravatar"]=="yes"){echo "checked";}?>> ¿Do you want to use your avatar from gravatar.com?
</td>
</tr>

<tr>
<td colspan="4">
<b>One line Bio</b><br>
<input type="text" name="bio" style="width: 95%;" value="<?php echo $rowopt["bio"]; ?>">
</td>
</tr>


<tr>
<td><b>Password <br>
change</b></td>
<td><input type="password" name="pass1"><br>
<input type="password" name="pass2"><br>
<small>Fill to change</small></td>

<td><b>What you want to show on index page.</b></td>
<td><select name="showing" id="showing"> 
<option value="" <?php if($rowopt["showing"]==""){ echo "selected=\"selected\""; }?>>Choose something</option>
<option value="public_timeline" <?php if($rowopt["showing"]=="public_timeline"){ echo "selected=\"selected\""; }?>>Public timeline</option>
<option value="following" <?php if($rowopt["showing"]=="following"){ echo "selected=\"selected\""; }?>>Following</option>
</select></td>
<td></td>
</tr>

</table>


<br>
<input id="nuevo" style="margin-right: 5px;" type="submit" name="usr_uni" value="Save"> 

</form>

<?php
}
?>
<!-- br -->
<a id="nuevo" href="index.php">go back</a>
<br><br>
<b>Random key generator, just test:</b> <?php echo md5(str_makerand(8,16,true,true,true)); ?>
<div style="clear: both;"></div>