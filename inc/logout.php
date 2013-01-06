<?php
if(!defined('MiniTwitter_ON')){

     die('Hacking attempt');
}

if(!$logged_in){
   echo "<h3>Error</h3>\n";
   echo "You are not logged in, them, you can't close your session.<br><br>
   <a id=\"nuevo\" href=\"index.php\">Go back</a><br><br>";
}
else{
   /* Kill session variables */
   unset($_SESSION['usernameuniversal']);
   unset($_SESSION['passworduniversal']);
   $_SESSION = array(); // reset session array
   //session_destroy();   // destroy session.

   echo "<h3>Your session has been closed</h3>\n";
   echo "The session has been closed <b>successfully</b>.<br><br>
   <a id=\"nuevo\" href=\"index.php\">Go back</a><br><br>";
}
?>
<?php
if(isset($_COOKIE['cooknameuniversal']) && isset($_COOKIE['cookpassuniversal'])){
   setcookie("cooknameuniversal", "", time()-60*60*24*10, "/");
   setcookie("cookpassuniversal", "", time()-60*60*24*10, "/");
}
?>