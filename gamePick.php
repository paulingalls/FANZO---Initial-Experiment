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
<title>Pick a game to join the conversation</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/gamePick.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    function checkInToGame( e )
    {
        window.location = "gameWatch.php?game=" + escape( e.target.value );
    }

    $( document ).ready( function()
    {
        $( "#gamePicker" ).change( checkInToGame );
        setTimeout( function()
        {
            window.scrollTo( 0, 1 );
        }, 100 );
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
	<h1>FANZO</h1>
	<h3>Never watch the game alone</h3>
	<h4>Welcome, <strong><?php echo he($user->name); ?></strong></h4>
	<form class="form-vertical" style="width: 300px; padding: 10px">
		<div class="control-group">
			<label class="control-label" for="gamePicker">Pick a game to join the conversation:</label> <select id="gamePicker"
				style="width: 300px">
				<option value="none">Pick from this list for 3/15</option>
				<option value="none">----South----</option>
				<option value="#NDMBB OR #goirish OR #xavier OR #muskateers">Notre Dame v. Xavier - 9:45</option>
				<option value="#DUKE OR #BlueDevils OR #Lehigh OR #mountainhawks">Duke v. Lehigh - 7:15</option>
				<option value="none">----West----</option>
				<option value="#MSU OR #spartans OR #LIU OR #blackbirds">Michigan State v. LIU Brooklyn - 9:20</option>
				<option value="#Memphis OR #Tigers OR #stlouis OR #billikens">Memphis v. St. Louis - 6:50</option>
				<option value="#Florida OR #gators OR #uva OR #virginia">Florida v. Virginia - 2:10</option>
				<option value="#Mizzou OR #missouri OR #Norfolk OR #NORF">Missouri v. Norfolk State - 4:40</option>
				<option value="none">----East----</option>
				<option value="#Cincinnati OR #bearcats OR #texas OR #longhorns">Cincinnati v. Texas - 12:15</option>
				<option value="#FSU OR #seminoles OR #bonaventure OR #bonnies">FLorida State v. St. Bonaventure - 2:45</option>
				<option value="none">----Midwest----</option>
				<option value="#UNC OR #tarheels OR #Vermont OR #UVM">North Carolina v. Vermont - 4:10</option>
				<option value="#Creighton OR #bluejays OR #Alabama OR #tide">Creighton v. Alabama - 1:40</option>
				<option value="#Temple OR #Owls OR #USF OR #bulls">Temple v. South Florida - 9:50</option>
				<option value="#Michigan OR #Wolverines OR #Ohio OR #Bobcats">Michigan v. Ohia - 7:20</option>
				<option value="#SDSU OR #aztecs OR #ncst OR #wolfpack">San Diego State v. NC State - 12:40</option>
				<option value="#Georgetown OR #hoyas OR #Belmont OR #bruins">Georgetown v. Belmont - 3:10</option>
				<option value="#stmary OR #gaels OR #Purdue OR #boilers">St. Mary v. Purdue - 7:27</option>
				<option value="#Kansas OR #Jayhawks OR #Detroit OR #Titans">Kansas v. Detroit - 9:57</option>
			</select>
		</div>
	</form>
</body>
</html>
