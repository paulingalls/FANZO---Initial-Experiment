<?php

require_once('utils.php');
require_once('AppInfo.php');
require_once('sdks/twitter/tmhOAuth.php');
require_once('sdks/twitter/tmhUtilities.php');

$here = tmhUtilities::php_self( );
$tmhOAuth = new tmhOAuth( array( 'consumer_key' => AppInfo::twitterConsumerKey(), 
								 'consumer_secret' => AppInfo::twitterConsumerSecret(), ) );
session_start( );

if (isAlreadyLoggedIn())
{
	header("Location: /gamePick.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Fanzo - Never Watch the Game Alone</title>
<link rel="stylesheet" href="css/base.css" />
<style>
	body
	{
		position: relative;
		width: 100%;
	}
	#content
	{
		text-align: center;
		margin: 40px auto; 
		width: 750px;
	}
	#content > h1
	{
		font-size: x-large;
		font-weight: bold;
	}
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29647923-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
    <div id="content">
    	<a href="authTwitter.php"><img src="img/twitterSignIn.png" width="450" height="72"/></a>    	
    </div>
</body>
</html>
