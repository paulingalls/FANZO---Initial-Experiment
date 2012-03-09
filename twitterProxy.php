<?php

require_once ('utils.php');
require_once ('sdks/twitter/tmhOAuth.php');
require_once ('sdks/twitter/tmhUtilities.php');

$here = tmhUtilities::php_self( );
$tmhOAuth = new tmhOAuth( array( 'consumer_key' => '66L5OnWNiQX8ziw0ABBnJg', 
								 'consumer_secret' => 'dSyFNwpJzBCpVOrNjT5BCJpbAU1K26xygHEac8Gscc', ) );
session_start( );


if ( isAlreadyLoggedIn( ) )
{
	$tmhOAuth->config[ 'user_token' ] = $_SESSION[ 'access_token' ][ 'oauth_token' ];
	$tmhOAuth->config[ 'user_secret' ] = $_SESSION[ 'access_token' ][ 'oauth_token_secret' ];

	switch ($_REQUEST['command'])
	{
		case 'favorite':
			$code = $tmhOAuth->request( 'POST', $tmhOAuth->url( '1/favorites/create/' .  $_REQUEST[ 'id' ] ) );
			break;

		case 'retweet':
			$code = $tmhOAuth->request( 'POST', $tmhOAuth->url( '1/statuses/retweet/' . $_REQUEST[ 'id' ] ) );
			break;

		default:
			if ($_REQUEST[ 'reply_id' ])
			{
				$postData = array('status' => $_REQUEST['data'], 'in_reply_t_status_id');
			}
			else
			{
				$postData = array( 'status' => $_REQUEST[ 'data' ] );
			}
			$code = $tmhOAuth->request( 'POST', $tmhOAuth->url( '1/statuses/update' ), $postData );
			break;
	}

	if ( $code == 200 )
	{
		$result = $tmhOAuth->response[ 'response' ];
		echo $result;
	}
	else
	{
		outputError( $tmhOAuth );
	}
}
else
{
	header( "Location: /index2.php" );
}
?>