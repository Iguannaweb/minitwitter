<?php define('MiniTwitter_ON', 1); ?>
<?php include("./inc/config.php"); ?>
<?php include("./inc/database.php"); ?>
<?php include("./inc/login.php"); ?>
<?php include("./inc/functions.php"); ?>

<?php //header('Content-Type: text/xml; charset=UTF-8'); ?>


<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";?>
<rss version="0.92">
<?php
$user = idfromnick($_GET["user"]);

if($_GET["user"]){
$sql2 = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses WHERE user_id='".avoid_injection($user)."' ORDER BY date_set DESC limit 15";
}else{
$sql2 = "SELECT status_id,user_id,status, DATE_FORMAT(date_set,'%M %e, %Y @ %l:%i:%s %p') AS ds FROM mt_statuses ORDER BY date_set DESC limit 15";
}
$resultado2 = mysql_query ($sql2, $connuni);

if($_GET["user"]){
echo " <channel>
    <title>miniTwitter / ".name_hide($user)."</title>
    <link>".$pth."index.php?user=".$user."</link>
    <description>miniTwitter updates from ".name_hide($user)."</description>
    <language>en-us</language>
    <ttl>15</ttl>";
}else{
echo " <channel>
    <title>miniTwitter / Public Timeline</title>
    <link>".$pth."index.php</link>
    <description>miniTwitter updates from Public Timeline</description>
    <language>en-us</language>
    <ttl>15</ttl>";
}

while ($row2 = mysql_fetch_array($resultado2)) {
echo "<item>
    <title>".name_hide($row2["user_id"]).": ".$row2["status"]."</title>
    <description>".name_hide($row2["user_id"]).": ".$row2["status"]."</description>
    <pubDate>".$row2["ds"]."</pubDate>
  </item>";
}

echo "</channel>";
echo "</rss>";
?>
  <!-- guid>http://twitter.com/crishnakh/statuses/1167074080</guid>
    <link>http://twitter.com/crishnakh/statuses/1167074080</link -->