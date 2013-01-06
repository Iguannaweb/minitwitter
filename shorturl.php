<?php 
function tiny($url_larga,$type){

if($type=="tinyurl"){
$tiny = "http://tinyurl.com/api-create.php?url=".$url_larga;
$sesion = curl_init();
curl_setopt ( $sesion, CURLOPT_URL, $tiny );
curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
$url_tiny = curl_exec ( $sesion );
curl_close( $sesion );

}elseif($type=="isgd"){
$isgd = "http://is.gd/api.php?longurl=".$url_larga;
$sesion = curl_init();
curl_setopt ( $sesion, CURLOPT_URL, $isgd );
curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
$url_tiny = curl_exec ( $sesion );
curl_close( $sesion );

}elseif($type=="unu"){
$unu = "http://u.nu/unu-api-simple?url=".$url_larga;
$sesion = curl_init();
curl_setopt ( $sesion, CURLOPT_URL, $unu );
curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
$url_tiny = curl_exec ( $sesion );
curl_close( $sesion );

}elseif($type=="zima"){
$zima = "http://zi.ma/?module=ShortURL&file=Add&mode=API&url=".$url_larga;
$sesion = curl_init();
curl_setopt ( $sesion, CURLOPT_URL, $zima );
curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
$url_tiny = curl_exec ( $sesion );
curl_close( $sesion );

}
$url_tiny = $url_tiny." ";

return $url_tiny;
}

if(($_GET["url"]) && ($_GET["service"])){
echo tiny($_GET["url"],$_GET["service"]);
}
?>