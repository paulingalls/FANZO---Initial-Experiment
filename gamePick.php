<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Pick a game to join the conversation</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/global.css" rel="stylesheet">
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
	<h1>Hudd.ly</h1>
	<h3>Never watch the game alone</h3>
	<form class="form-vertical" style="width: 300px; padding: 10px">
		<div class="control-group">
			<label class="control-label" for="gamePicker">Pick a game to join the conversation:</label> <select id="gamePicker"
				style="width: 300px">
				<option value="none">Pick from this list</option>
				<option value="#spartans OR #msu OR #huskers">Michigan State v. Nebraska</option>
				<option value="#ku OR #kansas OR #missouri">KU v. Missouri</option>
				<option value="#syracuse OR #orange OR #uconn">Syracuse v. Connecticut</option>
				<option value="#badgers OR #osu OR #buckeyes">Wisconsin v. Ohio State</option>
				<option value="#nd OR #irish OR #hoyas OR #georgetown">Notre Dame v. Georgetown</option>
				<option value="#chelsea OR #bolton">Chelsea v. Bolton</option>
				<option value="#arsenal OR #tottenham OR #spurs">Arsenal v. Tottenham Hospurs (Spurs)</option>
				<option value="#manu OR #manchester OR #norwich">Manchester United v. Norwich</option>
				<option value="#england OR #holland">England v. Holland</option>
				<option value="#usa OR #italy">USA v. Italy</option>
			</select>
		</div>
	</form>
</body>
</html>