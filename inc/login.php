<?php
if(!defined('MiniTwitter_ON')){

     die('Hacking attempt');
}

/**
 * Checks whether or not the given username is in the
 * database, if so it checks if the given password is
 * the same password in the database for that user.
 * If the user doesn't exist or if the passwords don't
 * match up, it returns an error code (1 or 2). 
 * On success it returns 0.
 */
function confirmUser($username, $password){
   global $connuni;
   /* Add slashes if necessary (for query) */
   if(!get_magic_quotes_gpc()) {
	$username = addslashes($username);
   }

   /* Verify that user is in database */
   $q = "SELECT password FROM mt_users WHERE nick = '$username'";
   $result = mysql_query($q,$connuni);
   if(!$result || (mysql_numrows($result) < 1)){
      return 1; //Indicates username failure
   }

   /* Retrieve password from result, strip slashes */
   $dbarray = mysql_fetch_array($result);
   $dbarray['password']  = stripslashes($dbarray['password']);
   $password = stripslashes($password);

   /* Validate that password is correct */
   if($password == $dbarray['password']){
      return 0; //Success! Username and password confirmed
   }
   else{
      return 2; //Indicates password failure
   }
}

/**
 * checkLogin - Checks if the user has already previously
 * logged in, and a session with the user has already been
 * established. Also checks to see if user has been remembered.
 * If so, the database is queried to make sure of the user's 
 * authenticity. Returns true if the user has logged in.
 */
function checkLogin(){
   /* Check if user has been remembered */
   if(isset($_COOKIE['cooknameuniversal']) && isset($_COOKIE['cookpassuniversal'])){
      $_SESSION['usernameuniversal'] = $_COOKIE['cooknameuniversal'];
      $_SESSION['passworduniversal'] = $_COOKIE['cookpassuniversal'];
   }

   /* Username and password have been set */
   if(isset($_SESSION['usernameuniversal']) && isset($_SESSION['passworduniversal'])){
      /* Confirm that username and password are valid */
      if(confirmUser($_SESSION['usernameuniversal'], $_SESSION['passworduniversal']) != 0){
         /* Variables are incorrect, user not logged in */
         unset($_SESSION['usernameuniversal']);
         unset($_SESSION['passworduniversal']);
         return false;
      }
      return true;
   }
   /* User not logged in */
   else{
      return false;
   }
}

/**
 * Determines whether or not to display the login
 * form or to show the user that he is logged in
 * based on if the session variables are set.
 */
function displayLogin(){
   include("./inc/lang/en.php");
   global $logged_in;
   if($logged_in){
   
   include('./inc/config.php');
		$connuni = @mysql_connect($host, $user, $pass);
		@mysql_select_db($db, $connuni);
	?>
		
		
<?php include("./inc/login/loginhead.php"); ?>
<?php include("./inc/login/insertcode.php"); ?>
<?php include("./inc/login/tinyform.php"); ?>
<span id="remaining"><?php echo $numero_caracteres; ?></span> <span style="display: none" id="wordcount">0</span>

<form action="index.php" method="post" style="width: 445px; margin-top: 25px; *margin-top:0px;" enctype="multipart/form-data">	
<div style="clear: both;"></div>
<textarea name="status" id="status" onkeyup="check_length();" onchange="check_length();" onmouseout="check_length();"><?php echo $url; ?></textarea> 
		
		<!-- Twitter -->
		<?php 
		$query  = "SELECT id_usr, nombre, apellidos, nick, twitter, accounts FROM mt_users Where nick='$_SESSION[usernameuniversal]' LIMIT 1";
		$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
		
		while($row = mysql_fetch_assoc($result)){
		
		if($row["twitter"]=="yes"){
		$account = explode("@@@", $row["accounts"]);
		$account1 = explode("||", $account[0]);
		$account2 = explode("||", $account[1]);
		$account3 = explode("||", $account[2]);
		
		echo "<table style=\"float: left;\" border=\"0\">";
		
		echo "<tr><td valign=\"top\"><b>TwitPic</b> <img src=\"".$pth."/inc/icons/pictures.png\" alt=\"TwitPic\"/> <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"4500000\"> <input name=\"media\" type=\"file\"><small> (.jpg)</small></td>";


		echo "<tr>
		<td>";
		echo "<b>Twitter</b> ";
		if($account1[0]!=""){
		echo "<input type=\"checkbox\" value=\"yes\" name=\"twitter_update_acc1\" ";
		if($account1[2]=="yes"){echo "checked";} echo "/>";
		echo "<b><a target=\"_blank\" href=\"http://twitter.com/".$account1[0]."\">".$account1[0]."</a></b>";
		echo "&nbsp; <input type=\"hidden\" name=\"twitter_username1\" value=\"".$account1[0]."\" id=\"twitter_username1\"/> 
		&nbsp; <input type=\"hidden\" name=\"twitter_psw1\" value=\"".$account1[1]."\" id=\"twitter_psw1\"/>";
		}
		
		if($account2[0]!=""){
		echo "<input type=\"checkbox\" value=\"yes\" name=\"twitter_update_acc2\" ";
		if($account2[2]=="yes"){echo "checked";} echo "/>";
		echo "<b><a target=\"_blank\" href=\"http://twitter.com/".$account2[0]."\">".$account2[0]."</a></b>";
		echo "&nbsp; <input type=\"hidden\" name=\"twitter_username2\" value=\"".$account2[0]."\" id=\"twitter_username2\"/> 
		&nbsp; <input type=\"hidden\" name=\"twitter_psw2\" value=\"".$account2[1]."\" id=\"twitter_psw2\"/>";
		}
		
		if($account3[0]!=""){
		echo "<input type=\"checkbox\" value=\"yes\" name=\"twitter_update_acc3\" ";
		if($account3[2]=="yes"){echo "checked";} echo "/>";;
		echo "<b><a target=\"_blank\" href=\"http://twitter.com/".$account3[0]."\">".$account3[0]."</a></b>";
		echo "&nbsp; <input type=\"hidden\" name=\"twitter_username3\" value=\"".$account3[0]."\" id=\"twitter_username3\"/> 
		&nbsp; <input type=\"hidden\" name=\"twitter_psw3\" value=\"".$account3[1]."\" id=\"twitter_psw3\"/>";
		}
		
		echo "</td></tr>";
		}

		}
		?>
		</tr>
		</table>
		<!-- End Twitter -->
		&nbsp; <input style="float: right; margin-right: -7px; margin-top: 0px; margin-botton: 5px; *margin-botton: 0px; *margin-top: -15px;" type="submit" value="Update" id="submit" />
	
	</form>
	<div class="clear"><br></div>
</div>
<div class="clear"><br></div>

<?php
      }else{  
      echo "<div class=\"contenidonormalb\">";
      require_once('./inc/captcha/recaptchalib.php');
      include('./inc/config.php'); 
?>

	<div class="bri">
	<h3>Login</h3>
	<form action="index.php" name="sublogin" id="sublogin" method="post">
	<table border="0" cellspacing="3" cellpadding="3">
	
	
	<tr>
	<td>Nick:</td>
	<td><input type="text" name="user" maxlength="20" class="inputbig"></td>
	<td rowspan="2">
	<?php echo recaptcha_get_html($captcha_publickey, $error_captcha); ?>
	<b><em><small>If you check "I'm a new user" please fill the catpcha!</small></em></b></td>
	</tr>
	
	<tr>
	<td>Password:</td>
	<td><input type="password" name="pass" maxlength="20" class="inputbig2"></td>
	</tr>
	
	<tr>
	<td colspan="2" align="left"><input type="checkbox" name="registro" value="registro">I'm a new user!</td>
	</tr>
	
	<tr>
	<td colspan="3" align="left"> <input type="hidden" name="remember" checked>
	<input type="submit" name="sublogin" id="sublogin"  class="submitbig2" value="Enter"></td>
	</tr>
	
	</table>
	</form>
	</div>
<?php
   }
}


/**
 * Checks to see if the user has submitted his
 * username and password through the login form,
 * if so, checks authenticity in database and
 * creates session.
 */
if(isset($_POST['sublogin'])){



if($_POST["registro"]=="registro"){
require_once('./inc/captcha/recaptchalib.php');
//$captcha_publickey="6Lf8EwQAAAAAAPHf0LDAlrZ6C2o3Z0nW3iSNPVaC";
//$captcha_privatekey = "6Lf8EwQAAAAAAPz3M678j9ON844yU95C3syMrD2h";
$error_captcha="Por favor rellena bien el catcha!";

$captcha_respuesta = recaptcha_check_answer ($captcha_privatekey,
$_SERVER["REMOTE_ADDR"],
$_POST["recaptcha_challenge_field"],
$_POST["recaptcha_response_field"]);
if ($captcha_respuesta->is_valid) {

$user = $_POST["user"];
$pass = md5($_POST["pass"]);
$sql="insert into mt_users (id_usr, nick, password) values ('NULL','$user','$pass')";
mysql_query($sql,$connuni) or die('What happen?: ' . mysql_error());
echo "<b style=\"color: white;\">New user has been created!</b>";

}else{
   //El código de validación de la imagen está mal escrito.
   $error_captcha_e = $captcha_respuesta->error;
   echo "<span style=\"color: red;\">".$error_captcha.": error: <em>".$error_captcha_e."</em></span>";
}

}elseif($_POST["registro"]==""){

   /* Check that all fields were typed in */
   if(!$_POST['user'] || !$_POST['pass']){
      die('<b style=\"color: red;\">Fill all the fields, please.</b>');
   }
   /* Spruce up username, check length */
   $_POST['user'] = trim($_POST['user']);
   if(strlen($_POST['user']) > 30){
      die("<b style=\"color: red;\">Uhm, your nick is tooooooooooo looooooooooong baby!.</b>");
   }

   /* Checks that username is in database and password is correct */
   $md5pass = md5($_POST['pass']);
   $result = confirmUser($_POST['user'], $md5pass);

   /* Check error codes */
   if($result == 1){
      die('<b style=\"color: red;\">Noup, uhm, maybe next time, you cant try again, please insert coin!.</b>');
   }
   else if($result == 2){
      die('<b style=\"color: red;\">Ey, hope you still know your password because we dont have recovery tool yet xD.</b>');
   }

   /* Username and password correct, register session variables */
   $_POST['user'] = stripslashes($_POST['user']);
   $_SESSION['usernameuniversal'] = $_POST['user'];
   $_SESSION['passworduniversal'] = $md5pass;

   /**
    * This is the cool part: the user has requested that we remember that
    * he's logged in, so we set two cookies. One to hold his username,
    * and one to hold his md5 encrypted password. We set them both to
    * expire in 100 days. Now, next time he comes to our site, we will
    * log him in automatically.
    
    *Nota, lo he cambiado a 10 días maximo
    */
   if(isset($_POST['remember'])){
      setcookie("cooknameuniversal", $_SESSION['usernameuniversal'], time()+60*60*24*10, "/");
      setcookie("cookpassuniversal", $_SESSION['passworduniversal'], time()+60*60*24*10, "/");
   }

   /* Quick self-redirect to avoid resending data on refresh */
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=$HTTP_SERVER_VARS[PHP_SELF]\">";
   return;
}
}



/* Sets the value of the logged_in variable, which can be used in your code */
$logged_in = checkLogin();

?>