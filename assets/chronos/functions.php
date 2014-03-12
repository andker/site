<?php

include 'config.php';

// Let's calculate how many seconds until launch
$targetdate = $year ."-". $month ."-". $day ." ". $hour .":". $minute .":". $second;
$startdate = date("Y-m-d H:i:s");
$seconds = strtotime($targetdate) - strtotime($startdate);


// Get latest twitter feed
$feed = "http://search.twitter.com/search.atom?q=from:" . $twitter_username . "&rpp=1";
function parse_feed($feed) {
$stepOne = explode("<content type=\"html\">", $feed);
$stepTwo = explode("</content>", $stepOne[1]);
$tweet = $stepTwo[0];
$tweet = str_replace("&lt;", "<", $tweet);
$tweet = str_replace("&gt;", ">", $tweet);
$tweet = str_replace("&quot;", "\"", $tweet);
$tweet = str_replace("&amp;apos;", "'", $tweet);
return $tweet;
}
$twitterFeed = file_get_contents($feed);
$twitterFeed = stripslashes($prefix) . parse_feed($twitterFeed) . stripslashes($suffix);

// Insert an email to the database
function mysqlcheck($emailTo) {
	include 'config.php';
	if ($useSQL == "yes") {
		$currentDate = date('j F Y, H:i:s');
		$remoteIP = $_SERVER["REMOTE_ADDR"];
		$conn = mysql_connect($db_host, $db_username, $db_password) or die ('Error connecting to mysql');
		mysql_select_db($db_name);
		mysql_query("CREATE TABLE IF NOT EXISTS chronos_db (email VARCHAR(256), ip VARCHAR(24), date VARCHAR(128))") or die("Create Table Error: ".mysql_error());
			if(!(mysql_num_rows(mysql_query("SELECT email FROM chronos_db WHERE email = '$emailTo'")))){
				mysql_query("INSERT INTO chronos_db VALUES ('$emailTo', '$remoteIP', '$currentDate') ") or die("Insert Error: ".mysql_error());
			} 
		mysql_close($conn);
	}
}

// Add email to XML file
function filecheck($emailTo) {
	include 'config.php';
	if ($useXML == "yes") {
		$currentDate = date('j F Y, H:i:s');
		$remoteIP = $_SERVER["REMOTE_ADDR"];
		$xmlfile = "emails.xml";
		$XMLcontent = file_get_contents($xmlfile);
		$pos = strpos($XMLcontent, $emailTo);
		if ($pos === false) {
			$fh = fopen($xmlfile, 'a') or die("Can't open file - check read/write permissions or if the file exists.");
			$stringData = "<contact>\n<email>$emailTo</email>\n<ip>$remoteIP</ip>\n<date>$currentDate</date>\n</contact>\n";
			fwrite($fh, $stringData);
			fclose($fh);
		}
		
	}
}


?>