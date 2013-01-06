<?php
if(!defined('MiniTwitter_ON')){

     die('Hacking attempt');
}

if($_POST["enviado"]=="yes"){
if($logged_in && ($id_usr=="1")){

$grup = "INSERT INTO mt_users (nick, password, correo) VALUES ('".avoid_injection($_POST["nick"])."', '".avoid_injection(md5($_POST["pass"]))."', '".avoid_injection($_POST["email"])."')";
mysql_query($grup, $connuni) or die(mysql_error());
echo "El usuario se ha insertado <b>correctamente</b><br>";

echo "<br><a id=\"nuevo\" href=\"index.php\">".$indexphp_goback2."</a><br><br>";
}
}
?>
<h1>Register a new User</h1>
<form method="post" action="" name="register">
<br>
<b>Nick</b><br>
<input name="nick" type="text" class="inputbig"><br>

<b>Password</b><br>
<input type="text" name="pass" class="inputbig"><br>

<b>email</b><br>
<input  type="text" name="email" class="inputbig"><br>

<input type="hidden" name="enviado" value="yes">
<input type="submit" value="Send">
</form>