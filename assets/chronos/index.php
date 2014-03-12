<?php

include 'config.php';
include 'functions.php';

//If the form is submitted
if(isset($_POST['submit'])) {

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = $_POST['email']; //Put your own email address here

		$headers = 'From: '.$name.' <'.$siteemail.'>' . "\r\n" . 'Reply-To: ' . $siteemail;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $sitetitle ?></title>
<link rel="stylesheet" href="css/chronos.css" type="text/css" />
<!-- CHROME -->
<link href="css/chrome.css" rel="stylesheet" type="text/css" />
<!-- SAFARI -->
<link href="css/safari.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<link href="css/ie7.css" rel="stylesheet" type="text/css" />
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<!--[if IE 8]>
<link href="css/ie8.css" rel="stylesheet" type="text/css" />
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<script type="text/javascript" src="js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="js/chronos.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
    $("#contactform").validate({
        errorPlacement: function(error, element) {
            var errorClone = error.clone();
                        container.append(errorClone);
                        error.insertAfter(element).bind("hide", function(){
                                errorClone.hide();
                        });
        }
    });
});

//]]>
</script>
<script language="javascript" type="text/javascript">
//<![CDATA[
    var secondsStr = "<?php echo $seconds; ?>";
	var threeDig = "<?php echo $threedigitday ?>";
//]]>
</script>
</head>

<body class="<?php echo $theme ?>">

<div id="wrapper" class="<?php echo $threedigitday ?>">

	<!-- BEGIN HEADER -->
	<h1 class="sitetitle"><img src="<?php echo $logofile ?>" alt="<?php echo $logo_alttag ?>" /></h1>
    <div class="brief">
    	<h2><?php echo $contentheader ?></h2>
    	<p><?php echo $content ?></p>
    </div>
    <!-- END HEADER -->

    <!-- BEGIN COUNTDOWN -->
	<div id="countdown" class="<?php echo $threedigitday ?>"></div>
    <div class="countdown_description"><img src="img/cd_desc.png" alt="Countdown to launch" /></div>
    <!-- END COUNTDOWN -->

    <!-- BEGIN BOTTOM LEFT SIDE -->
    <div class="sideleft">
    	<div class="progress_legend"><img src="img/prog_leg.png" alt="Completed in:" /></div>
        <div class="progress_bar">
			<div class="progress pos<?php echo $percent ?>"></div>
        </div><!-- end progress_bar -->
        <div class="progress_description"><img src="img/prog_desc.png" alt="Progress" /></div>

        <div class="twitter">
            <div class="twitter-outer"><!-- vertically aligning the text -->
                <div class="twitter-inner">
                        <p><?php echo $twitterFeed; ?></p>
                </div>
            </div><!-- end twitter-outer -->
        </div><!-- end twitter -->
        <div class="twitter_desc"><img src="img/twitter_desc.png" alt="Twitter feed" /></div>
    </div><!-- end sideleft -->
    <!-- END BOTTOM LEFT SIDE -->

    <!-- BEGIN BOTTOM RIGHT SIDE -->
    <div class="sideright">
    	<div class="signup_description"><img src="img/signup_desc.png" alt="Stay Informed" /></div>
        <div class="signup_form">

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">
                <input type="text" class="email" name="email" id="email" value="enter your email address" onclick="this.value='';" />
                <input type="submit" value="" name="submit" class="submit" />
            </form>

        </div><!-- end signup_form -->
        
        <div class="form_msg">
			<?php if(isset($hasError)) { //If errors are found ?>
                <img src="img/error.png" border="0" alt="Error" />
            <?php } ?>
            <?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
                <img src="img/success.png" border="0" alt="Success" />
            <?php
			mysqlcheck($emailTo);
			filecheck($emailTo);
			 } ?>
        </div><!-- end form_msg -->

        <ul class="social">
        	<li><a class="t" href="<?php echo $twitter_link ?>"></a></li>
        	<li><a class="f" href="<?php echo $facebook_link ?>"></a></li>
        	<li><a class="r" href="<?php echo $rss_link ?>"></a></li>
        	<li class="last"><a class="e" href="mailto:<?php echo $email_address ?>"></a></li>
        </ul><!-- end social -->
        <div class="social_desc"><img src="img/social_desc.png" alt="Social Media" /></div>
    </div><!-- end sideright -->
    <!-- END BOTTOM RIGHT SIDE -->

</div><!-- end wrapper -->
</body>
</html>