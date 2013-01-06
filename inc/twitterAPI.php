<?php

// A simple function using Curl to post (GET) to Twitter
// Kosso : March 14 2007

function postToTwitter($username,$password,$message){


    $host = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($message)));
	//$useragent = "Minitwitter";
	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); 
    //curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $result = curl_exec($ch);
    // Look at the returned header
    //$resultArray = curl_getinfo($ch);
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    //if($resultArray['http_code'] == "200"){
    if( $http_status == "200" ) {
         $twitter_status='<div id="message">¡Posted to Twitter too!</div>';
    }elseif( $http_status == "304"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Not Modified: there was no new data to return.</div>";
    }elseif( $http_status == "400"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Bad Request: your request is invalid, and we'll return an error message that tells you why. This is the status code returned if you've exceeded the rate limit (see below).</div>";
    }elseif( $http_status == "401"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Not Authorized: either you need to provide authentication credentials, or the credentials provided aren't valid.</div>";
    }elseif( $http_status == "403"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Forbidden: we understand your request, but are refusing to fulfill it.  An accompanying error message should explain why.</div>";
    }elseif( $http_status == "404"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Not Found: either you're requesting an invalid URI or the resource in question doesn't exist (ex: no such user).</div>";
    }elseif( $http_status == "500"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Internal Server Error: we did something wrong.  Please post to the group about it and the Twitter team will investigate.</div>";
    }elseif( $http_status == "502"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Bad Gateway: returned if Twitter is down or being upgraded.</div>";
    }elseif( $http_status == "503"){
    $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
    <b>http code:</b> ".$http_status." - Service Unavailable: the Twitter servers are up, but are overloaded with requests.  Try again later.</div>";
    }else {
         $twitter_status="<div id=\"message_error\">Oops something goes wrong with twitter, please try later.<br>
         <b>http code:</b> ".$http_status."</div>";
    }
	return $twitter_status;
}
?>