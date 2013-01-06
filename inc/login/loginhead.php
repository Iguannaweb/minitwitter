		<?php
    echo "<div class=\"contenidonormal_login\">";
    echo "<a title=\"Salir\" href=\"index.php?go=salir\"><img align=\"right\" style=\"border: 0px;\" src=\"".$pth."/inc/icons/action_stop.gif\" alt=\"Logout\"></a>";
	echo "<a title=\"Options\" href=\"index.php?go=opt\"><img align=\"right\" style=\"border: 0px;\" src=\"".$pth."/inc/icons/icon_settings.gif\" alt=\"Options\"></a>";	
	echo "<a href=\"#\" onmouseover=\"Tip('<b>MiniTwitter Commands </b><br><b>TODO</b> <em>something to do</em> - Add something to do, to a todo list<br><b>DONE</b> <em>_number_</em> </b> Delete task nº number<br><b>FOLLOW _</b>username<b>_</b> - Follow username<br><b>UNFOLLOW _</b>username<b>_</b> - Unfollow username<br>', BALLOON, true, ABOVE, true, OFFSETX, -17, PADDING, 8)\" onmouseout=\"UnTip()\"><img style=\"border: 0px;\" align=\"right\" src=\"".$pth."/inc/icons/help.gif\" alt=\"help\"></a>";


   	echo "What are you working, <strong>$_SESSION[usernameuniversal]</strong>?";
   	
	?>