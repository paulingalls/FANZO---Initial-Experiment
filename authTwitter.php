<?php

require 'sdks/twitter/tmhOAuth.php';
require 'sdks/twitter/tmhUtilities.php';

$here = tmhUtilities::php_self( );
$tmhOAuth = new tmhOAuth( array( 'consumer_key' => '66L5OnWNiQX8ziw0ABBnJg', 
								 'consumer_secret' => 'dSyFNwpJzBCpVOrNjT5BCJpbAU1K26xygHEac8Gscc', ) );

session_start( );

function outputError( $tmhOAuth )
{
	echo 'Error: ' . $tmhOAuth->response[ 'response' ] . PHP_EOL;
	tmhUtilities::pr( $tmhOAuth );
}

function isLogout()
{
	return isset( $_REQUEST[ 'wipe' ] );
}

function isAlreadyLoggedIn()
{
	return isset( $_SESSION[ 'access_token' ] );
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
	$tmhOAuth->config[ 'user_token' ] = $_SESSION[ 'access_token' ][ 'oauth_token' ];
	$tmhOAuth->config[ 'user_secret' ] = $_SESSION[ 'access_token' ][ 'oauth_token_secret' ];

	$code = $tmhOAuth->request( 'GET', $tmhOAuth->url( '1/account/verify_credentials' ) );
	if ( $code == 200 )
	{
		$resp = json_decode( $tmhOAuth->response[ 'response' ] );
		echo $resp->screen_name;
	}
	else
	{
		outputError( $tmhOAuth );
	}
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