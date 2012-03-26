<?php

require_once('AppInfo.php');
require_once('utils.php');
require_once('sdks/twitter/tmhOAuth.php');
require_once('sdks/twitter/tmhUtilities.php');

$here = tmhUtilities::php_self( );
$tmhOAuth = new tmhOAuth( array( 'consumer_key' => AppInfo::twitterConsumerKey(), 
								 'consumer_secret' => AppInfo::twitterConsumerSecret(), ) );

session_start( );

function isLogout()
{
	return isset( $_REQUEST[ 'wipe' ] );
}
function isTwitterCallback()
{
	return isset( $_REQUEST[ 'oauth_verifier' ] );
}

if ( isLogout() )
{
	session_destroy( );
	header( "Location: /" );
}
elseif ( isAlreadyLoggedIn() )
{
	header("Location: gamePick.php");
}
elseif ( isTwitterCallback() )
{
	$tmhOAuth->config[ 'user_token' ] = $_SESSION[ 'oauth' ][ 'oauth_token' ];
	$tmhOAuth->config[ 'user_secret' ] = $_SESSION[ 'oauth' ][ 'oauth_token_secret' ];

	$code = $tmhOAuth->request( 'POST', 
								$tmhOAuth->url( 'oauth/access_token', '' ), 
								array( 'oauth_verifier' => $_REQUEST[ 'oauth_verifier' ] ) );

	if ( $code == 200 )
	{
		$_SESSION[ 'access_token' ] = $tmhOAuth->extract_params( $tmhOAuth->response[ 'response' ] );
		unset( $_SESSION[ 'oauth' ] );
		header( "Location: {$here}" );
	}
	else
	{
		outputError( $tmhOAuth );
	}
}
else
{
	$params = array( 'oauth_callback' => $here );

	$code = $tmhOAuth->request( 'POST', $tmhOAuth->url( 'oauth/request_token', '' ), $params );

	if ( $code == 200 )
	{
		$_SESSION[ 'oauth' ] = $tmhOAuth->extract_params( $tmhOAuth->response[ 'response' ] );
		$authurl = $tmhOAuth->url( "oauth/authorize", '' ) . "?oauth_token={$_SESSION['oauth']['oauth_token']}";
		header("Location: {$authurl}");
	}
	else
	{
		outputError( $tmhOAuth );
	}
}
?>