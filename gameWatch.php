<?php

require_once('utils.php');
require_once('sdks/twitter/tmhOAuth.php');
require_once('sdks/twitter/tmhUtilities.php');

$here = tmhUtilities::php_self( );
$tmhOAuth = new tmhOAuth( array( 'consumer_key' => '66L5OnWNiQX8ziw0ABBnJg', 
								 'consumer_secret' => 'dSyFNwpJzBCpVOrNjT5BCJpbAU1K26xygHEac8Gscc', ) );
session_start( );

if (isAlreadyLoggedIn())
{
	$tmhOAuth->config[ 'user_token' ] = $_SESSION[ 'access_token' ][ 'oauth_token' ];
	$tmhOAuth->config[ 'user_secret' ] = $_SESSION[ 'access_token' ][ 'oauth_token_secret' ];

	$code = $tmhOAuth->request( 'GET', $tmhOAuth->url( '1/account/verify_credentials' ) );
	if ( $code == 200 )
	{
		$user = json_decode( $tmhOAuth->response[ 'response' ] );
	}
	else
	{
		outputError( $tmhOAuth );
	}
}
else 
{
	header("Location: /index2.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Never Watch the Game Alone</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/gameWatch.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/client.js"></script>
<script type="text/javascript">
    $( document ).ready( function()
    {
        parseQueryString(window.location.search);
        initializeButtons();
        getLatestTweetsForTerm( mySearchTerm );
        window.setInterval(function(){grabMoreTweets();}, 2000);
    } );
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18133176-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
	<div id="holder">
		<div id="buttonHolder">
			<div id="myHappyModal" class="modal hide fade" style="display: none;">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">×</a>
					<h3>Tell the world that Rocked!<br/>Pick a start:</h3>
				</div>
				<div class="modal-body">
					<a id="dunk" class="btn btn-large" href="#">Monster Dunk!</a>
					<a id="niceShot" class="btn btn-large" href="#">Swoosh!</a>
					<a id="stickIt" class="btn btn-large" href="#">In your face!</a>
					<a id="goDefense" class="btn btn-large" href="#">Defense!</a>
					<a id="goOffense" class="btn btn-large" href="#">Offense!</a>
					<a id="pretty" class="btn btn-large" href="#">So Pretty!</a>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Cancel</a>
				</div>
			</div>

			<div id="mySadModal" class="modal hide fade" style="display: none;">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">×</a>
					<h3>Tell the world that Sucked!<br/>Pick a start:</h3>
				</div>
				<div class="modal-body">
					<a id="noDefense" class="btn btn-large" href="#">What Defense?</a>
					<a id="foul" class="btn btn-large" href="#">Foul!</a>
					<a id="kiddingMe" class="btn btn-large" href="#">You kidding?</a>
					<a id="ouch" class="btn btn-large" href="#">Ouch!</a>
					<a id="noOffense" class="btn btn-large" href="#">What Offense?</a>
					<a id="blindRef" class="btn btn-large" href="#">Ref's Blind!</a>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Cancel</a>
				</div>
			</div>
					
			<div class="tweetStarterBtn">
				<a data-toggle="modal" href="#myHappyModal" id="happyButton" class="btn btn-large btn-primary">Booyah!!!</a>
			</div>
			<div class="tweetStarterBtn">
				<a data-toggle="modal" href="#mySadModal" id="sadButton" class="btn btn-large btn-danger">What?!?!</a>
			</div>
		</div>
		<div id="tweetHolder">
			<div id="tweets"></div>
		</div>
	</div>
</body>
</html>