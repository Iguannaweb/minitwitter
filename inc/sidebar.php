		<?php
		include('./inc/config.php');
		$connuni = @mysql_connect($host, $user, $pass);
		@mysql_select_db($db, $connuni);
		
		if(!$user){ $user = $HTTP_GET_VARS['user'];}
		//Si usuario determinado
		if($_GET["user"]){
		$user = $_GET["user"];
		$usern = name_hide($user);
		$query  = "SELECT id_usr, nombre, apellidos, nick, password, country, state, correo, dia, mes, anio,bio, gravatar, follow FROM mt_users WHERE nick = '".avoid_injection($usern)."' LIMIT 1";
		
		//Si no coge el usuario logueado
		}else{
		$query  = "SELECT id_usr, nombre, apellidos, nick, password, country, state, correo, dia, mes, anio,bio, gravatar, follow FROM mt_users WHERE nick = '$_SESSION[usernameuniversal]' LIMIT 1";
		}
		$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
		while($row = mysql_fetch_assoc($result)){
		?>
		<?php
		
		//Usando gravatar?
		if($row["gravatar"]=="yes"){
		echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\">";
		echo "<img width=\"48\" height=\"48\" border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"";
		$grav_correo = $row["correo"];
		echo getGravatarUrl($grav_correo, $defImg,  "80", "G");
		echo "\" alt=\"Gravatar\"></a>";
		
		//avatar propio?
		}else{
		if(file_exists("./avatar/".$row["id_usr"].".jpg")){ 
		echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\">
		<img border=\"1\" width=\"48\" height=\"48\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/".$row["id_usr"].".jpg\"></a>";} 
		else {echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/default.jpg\" width=\"48\" height=\"48\"></a>";}
		}
		
		//Datos personales y ministats
		?>
		<h3><?php echo $row["nick"]; ?></h3>
		<small><a href="mailto:<?php echo $row["correo"]; ?>"><?php echo $row["nombre"]; ?> <?php echo $row["apellidos"]; ?></a> - <?php echo $row["dia"]; ?>/<?php echo $row["mes"]; ?>/<?php echo $row["anio"]; ?> from <?php echo $row["state"]; ?> (<?php echo $row["country"]; ?>)</small>
		
		<p><em><?php echo $row["bio"]; ?></em></p>
		<small>
		<table border="0" cellpadding="5" cellspacing="0" style="text-align: center; font-size: 9px;" align="center">
		
		<tr>
		<td><b><?php echo $loginphp_est1;?></b></td>
		<td><b><?php echo $loginphp_est2;?></b></td>
		<td><b><?php echo $loginphp_est3;?></b></td>
		<td><b><?php echo $loginphp_est4;?></b></td>
		</tr>
		
		<tr>
		<td><?php total_udates($row["id_usr"]); ?></td>
		<td><?php total_replies($row["id_usr"]); ?></td>
		<td><?php followers($row["id_usr"]); ?></td>
		<td><?php echo count(explode(",",$row["follow"]))-1; ?></td>
		</tr>
		
		</table>
		</small>
		
		<a href="#" style="float: right;" onmouseover="toggleBlock('sidebar_hide');return false;toggleBlock('sidebar_hide');return false;">↓↑</a>
		
		<div id="sidebar_hide">
	<?php
	//Botones para seguir o dejar de seguir
	if($_GET["user"]){
	//if(strstr($row["follow"],($_GET["user"])==true)){}else{
	$user = $_GET["user"];
	echo "<form style=\"float: right;\" action=\"\" method=\"post\">";	
	echo "<input type=\"image\" src=\"".$pth."inc/icons/+.png\" name=\"status_id_mas\" value=\"".$user."\"> <small>".$loginphp_fl."</small> ";
	echo "</form>";
	/*}

	if(strstr($row["follow"],($_GET["user"])==true)){*/
	//$user = $_GET["user"];
	echo "<form style=\"float: right;\" action=\"\" method=\"post\">";	
	echo " <input type=\"image\" src=\"".$pth."inc/icons/-.png\" name=\"status_id_menos\" value=\"".$user."\"> <small>".$loginphp_ufl."</small> ";
	echo "</form>";
	//}else{}
	
	}
	?>
	<br>
		<?php 
		//Si es usuario muestra a quien sigue
		if($_GET["user"]){
		echo "<h3>";
		name($_GET["user"]);
		echo " is following to...</h3>";
		$flw = get_followers($_GET["user"]);
		if($flw==""){echo "nobody!";}else{
		$following=explode(",",$flw); 
		$i=0;
		$t=0;
		while($following[$i]==true){
		
	
		$queryw  = "SELECT id_usr,nick,correo, gravatar FROM mt_users Where id_usr = '".avoid_injection($following[$i])."' LIMIT 1";
		$resultw = mysql_query($queryw,$connuni) or die(mysql_error().': '.$queryw);
		while($ruw = mysql_fetch_assoc($resultw)){
		
		if($ruw["gravatar"]=="yes"){
		echo "<a href=\"index.php?user=".$ruw["id_usr"]."\" title=\"".$ruw["nick"]."\" onmouseover=\"Tip('";
		echo "<b>".$ruw["nick"].": </b>";
		echo last($ruw["id_usr"]);
		echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">";
		echo "<img width=\"48\" height=\"48\" border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"";
		$grav_correow = $ruw["correo"];
		echo getGravatarUrl($grav_correow, $defImg,  "80", "G");
		echo "\" alt=\"Gravatar\"></a>";
		 
		
		}else{

		if(file_exists("./avatar/".$following[$i].".jpg")==true){ 
		echo "<a title=\"";
		name($following[$i]);
		echo "\"  href=\"index.php?user=".$following[$i]."\" onmouseover=\"Tip('";
		echo "<b>";
		name($following[$i]);
		echo ": </b>";
		echo last($following[$i]);
		echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/".$following[$i].".jpg\" width=\"48\" height=\"48\"></a>";}
		else {echo "<a title=\"";
		name($following[$i]);
		echo "\" href=\"index.php?user=".$following[$i]."\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."avatar/default.jpg\" width=\"48\" height=\"48\"></a>";} 
		
		}
		$i=$i+1;
		}
		$restog = $t%4;
  		 if (($restog==0) && ($t!=0)) {
        	echo "<div style=\"clear: both;\"></div>";
   		}
		
		}
		
		}
		
		//Muestra formulario para crear grupos y tus seguidos
		}else{ ?>
		<h3><?php echo $loginphp_foll; ?></h3>
		<small><a href="#" onclick="toggleBlock('group');return false;toggleBlock('group2');return false;"><?php echo $loginphp_grfl; ?></small>
		
		<div id="group" style="display: none;">
		<small>
		<form action="" method="post" name="groupform">
		<strong><?php echo $loginphp_minigr; ?></strong> <br>
		<input name="group_name" type="text" style="width: 215px;"><br>
		<strong><?php echo $loginphp_mgrdes;?></strong>
		<textarea name="group_desc" style="width: 215px; height: 100px;"></textarea><br>
		<strong>Choose users:</strong><br>
		<?php 
		$followingGroup=explode(",",$row["follow"]); 
		$i=0;$y=0;
		while($followingGroup[$i]==true){
		
	 	
		$queryw  = "SELECT id_usr,nick,correo, gravatar FROM mt_users Where id_usr = '$followingGroup[$i]' LIMIT 1";
		$resultw = mysql_query($queryw,$connuni) or die(mysql_error().': '.$queryw);
		while($ruw = mysql_fetch_assoc($resultw)){
		
		echo "<div style=\"float: left; width: 100px;\"><input type=\"checkbox\" name=\"follow[]\" value=\"".$ruw["id_usr"]."\">".$ruw["nick"]."</div>"; 

		
		}
		/*$resto = $i%4;
  		 if (($resto==0) && ($i!=0)) {
        	echo "<div style=\"clear: both;\"></div>";
   		}*/
		$i=$i+1;
		}
		?>
		<br>
		<div style="clear: both;"></div>
		<input type="submit" name="groupform" value="Group it!">
		</form>
		</small>
		</div>
		<!-- fin de formulario-->
	
		<div style="clear: both;"></div>
		<?php 
		$following=explode(",",$row["follow"]); 
		$i=0;
		$p=0;
		while($following[$i]==true){
		//Mis seguidos
	
		$queryw  = "SELECT id_usr,nick,correo, gravatar FROM mt_users Where id_usr = '".avoid_injection($following[$i])."' LIMIT 1";
		$resultw = mysql_query($queryw,$connuni) or die(mysql_error().': '.$queryw);
		while($ruw = mysql_fetch_assoc($resultw)){
		$array_names_minitwitter = name_hide($following[$i]);
		$compare_w_t .= $array_names_minitwitter."|";
		
		if($p<=11){
		if($ruw["gravatar"]=="yes"){
		echo "<a href=\"index.php?user=".$ruw["id_usr"]."\" title=\"".$ruw["nick"]."\" onmouseover=\"Tip('";
		echo "<b>".$ruw["nick"].": </b>";
		echo last($ruw["id_usr"]);
		echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">";
		echo "<img width=\"48\" border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"";
		$grav_correow = $ruw["correo"];
		echo getGravatarUrl($grav_correow, $defImg,  "80", "G");
		echo "\" alt=\"Gravatar\"></a>"; 
		
		}else{

		if(file_exists("./avatar/".$following[$i].".jpg")==true){ 
		echo "<a title=\"";
		name($following[$i]);
		echo "\"  href=\"index.php?user=".$following[$i]."\" onmouseover=\"Tip('";
		echo "<b>";
		name($following[$i]);
		echo ": </b>";
		echo last($following[$i]);
		echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/".$following[$i].".jpg\" width=\"48\" height=\"48\"></a>";}
		else {echo "<a title=\"";
		name($following[$i]);
		echo "\" href=\"index.php?user=".$following[$i]."\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/default.jpg\" width=\"48\" height=\"48\"></a>";} 
		
		echo "<div id=\"group\" style=\"display: none; width: 48; margin: 3px;\"><input type=\"checkbox\" name=\"".$ruw["id_usr"]."\"></div>"; 
		
		
		}
		}else{}
		$p=$p+1;
		}
		$restop = $p%4;
  		 if (($restop==0) && ($p!=0)) {
        	echo "<div style=\"clear: both;\"></div>";
   		}
		$i=$i+1;
		
		}
		}
		echo "<div style=\"clear: both;\"></div>";
		?>
		
		<h3>My groups:</h3><br>
		<?php
		//Mis grupos
		$admin_id=idfromnick($_SESSION["usernameuniversal"]);
		$query  = "SELECT group_name, group_desc, members_twitter FROM mt_group WHERE admin_id='$admin_id'";
		$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
		$gh=2;

		while($row = mysql_fetch_assoc($result)){
		echo "<div class=\"grupos\"><a title=\"".$row["group_desc"]."\" href=\"javascript:countries.expandit(".$gh.")\" rel=\"country".$gh."\">".$row["group_name"]."</a></div>";
		$gh=$gh+1;
		}
		
		?>
		<?php
		}
		$query  = "SELECT id_usr, nombre, apellidos, nick, password, correo, dia, mes, anio, gravatar FROM mt_users Where nick <> '$_SESSION[usernameuniversal]' ORDER BY id_usr DESC LIMIT 49";
		//RAND() 
		$result = mysql_query($query,$connuni) or die(mysql_error().': '.$query);
		?>
		<div style="clear: both;"></div>
		<h3>The people</h3>
		<br>
		<?php
		$i=0;
		$sn=0;
		while($row = mysql_fetch_assoc($result)){
		//El resto de la gente dentro de la empresa
		if($row["gravatar"]=="yes"){
		echo "<a href=\"index.php?user=".$row["id_usr"]."\" title=\"".$row["nick"]."\" onmouseover=\"Tip('";
		echo "<b>".$row["nick"].": </b>";
		echo last($row["id_usr"]);
		echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">";
		echo "<img width=\"24\" height=\"24\" border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"";
		$grav_correo = $row["correo"];
		echo getGravatarUrl($grav_correo, $defImg,  "80", "G");
		echo "\" alt=\"Gravatar\"></a>";
		
		$i=$i+1;
	
		}else{

		if(file_exists("./avatar/".$row["id_usr"].".jpg")==true){ 
		echo "<a title=\"".$row["nick"]."\"  href=\"index.php?user=".$row["id_usr"]."\" onmouseover=\"Tip('";
		echo "<b>".$row["nick"].": </b>";
		echo last($row["id_usr"]);
		echo "', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/".$row["id_usr"].".jpg\" width=\"24\" height=\"24\"></a>";
		
		
		}else {
		echo "<a title=\"".$row["nick"]."\" href=\"index.php?user=".$row["id_usr"]."\">
		<img border=\"1\" align=\"left\" style=\"margin: 3px;\" src=\"".$pth."/avatar/default.jpg\" width=\"24\" height=\"24\"></a>";
		$sn=$sn+1;
		} 
		
		$i=$i+1;
		}
		
		$resto = $i%7;
  		 if (($resto==0) && ($i!=0)) {
        	echo "<div style=\"clear: both;\"></div>";
   		}
		
		}
		echo "<div style=\"clear: both;\"></div>";
		echo "<small><b>".$sn."</b> without avatar</small>";
		?>
		</div>