var mySearchTerm;
var myHashTags;
var myRefreshUrl;

var SEARCH_URL = "http://search.twitter.com/search.json";

var myTweetHash = {
    "blindRef" : [
            "Damn, that ref is blind as a bat",
            "Open your eyes ref, or do you have any?",
            "How can you not see that foul? There is so much blood it looks like a bomb went off in the paint!"
    ],
    "foul" : [
            "That is what you call a foul ref! Have you forgotten what that is?",
            "Damn, that had to hurt.  Call the foul ref!",
            "I'll show you a charge, with my semi!"
    ],
    "kiddingMe" : [
            "You have got to be kidding me ref, are you just making this up as you go?",
            "The game is called basketball ref, perhaps you should study up a bit!",
            "Seriously?  You have got to be kidding me!  Did I really just see that, or did the world just go crazy?"
    ],
    "noDefense" : [
            "You call that defense? You're supposed to keep the ball out of the basket, not help it in!",
            "My grandma can play better defense than this, in combat boots!",
            "Why don't you just sit down and WATCH the game, cuz you can't seem to PLAY it"
    ],
    "noOffense" : [
            "Put the rock in the hole! How hard is that?",
            "That boy can't hit the broadside of a barn! That brick must have weighed a ton, it almost put a hole in the floor!",
            "Shoot the ball, don't snuggle it!"
    ],
    "ouch" : [
            "That had to hurt!",
            "I gotta close my eyes, tell me when the real team shows up.",
            "Ouch, hope that dude is ok.  I think he just lost his shorts!"
    ],
    "dunk" : [
            "Did you see that dunk?!?  You could hear that thing in Brooklyn!",
            "Dude, he just stuffed that down with a two hand jam!",
            "Sweet!  Throw that bad boy down!"
    ],
    "niceShot" : [
            "Nothing but net, baby!",
            "Swoosh! That was a thing of beauty!",
            "You gotta love a money shot like that!"
    ],
    "stickIt" : [
            "You think you're gonna come in to our house? I  D O N ' T  T H I N K  S O !!!",
            "Get that outta here, this is MY paint!",
            "Booyah baby!"
    ],
    "goDefense" : [
            "Shut it down!  They got N O T H I N G!",
            "Now that is defense, baby.  Bring the stop!",
            "That zone is as tight!"
    ],
    "goOffense" : [
            "Shoot that!  You know you feeling it!",
            "Come on, let's move the ball around. Look for the open man!",
            "Bring the rain!"
    ],
    "pretty" : [
            "Nothing but N E T, baby!",
            "Did you see that move?!?!",
            "Damn, but that looked good!"
    ]
};

function parseQueryString( aSearchString )
{
    mySearchTerm = unescape( aSearchString.split( "=" )[1] );
    myHashTags = mySearchTerm;
    myHashTags = myHashTags.replace( /OR/gi, "" );
}

function getLatestTweetsForTerm( aSearchTerm )
{
    var theQueryString = "?lang=en&callback=?&q=" + escape( aSearchTerm );
    $.getJSON( SEARCH_URL + theQueryString, onSearchComplete );
}

function grabMoreTweets()
{
    $.getJSON( SEARCH_URL + myRefreshUrl + "&callback=?", onSearchComplete );
}

function onSearchComplete( aJSON )
{
    if ( aJSON )
    {
        $.each( aJSON.results, addTweet );
        if ( !myRefreshUrl )
        {
            window.scrollTo( 0, 1 );
        }
        myRefreshUrl = aJSON.refresh_url;
    }
    else
    {
        $( "#tweets" ).html( "<p>There was an error retreiving tweets</p>" );
    }
}

function addTweet( i, aTweet )
{
	var theNewDivSelector = "#" + aTweet.id_str;
    if ( myRefreshUrl )
    {
        $( "#tweets" ).prepend( getTweetMarkup( aTweet ) );
        $(theNewDivSelector).slideDown( 600, onAddComplete );
    }
    else
    {
        $( "#tweets" ).append( getTweetMarkup( aTweet ) );
        $(theNewDivSelector).slideDown(200);
    }
}

function getTweetMarkup( aTweet )
{
    var theTweetDate = new Date( aTweet.created_at );

    return "<div id='" + aTweet.id_str + "' class='tweet well' style='display:none'><img src='"
           + aTweet.profile_image_url
           + "' style='float:left' width='48px' height='48px'></img> <strong>"
           + aTweet.from_user
           + ": </strong>"
           + aTweet.text
           + "<div class='tweetMenu'><div class='timestamp'>"
           + theTweetDate.toDateString()
           + " "
           + theTweetDate.toLocaleTimeString()
           + "</div><a href=\"javascript:replyTo('"
           + aTweet.id_str
           + "')\"><img src='img/reply.png'></img>Reply</a>"
           + "| <a href=\"javascript:retweet('"
           + aTweet.id_str
           + "')\"><img src='img/retweet.png'></img>Retweet</a>"
           + "| <a href=\"javascript:favorite('"
           + aTweet.id_str
           + "')\"><img src='img/favorite.png'></img>Favorite</a>"
           + "</div><div class='alert alert-error fade in' style='display:none'>"
           + "<a class='close' data-dismiss='alert' href='#'>×</a><p id='" 
           + aTweet.id_str 
           + "_alertText'><strong>Success!</strong></p></div></div>";
}

function onAddComplete()
{
    $(".tweet:last").remove();
}

function initializeButtons()
{
    $( ".modal-body a" ).each( addTweetClick );
}

function getTweetUrl( aDefaultText )
{
    return "https://twitter.com/intent/tweet?text="
           + escape( aDefaultText + " " + myHashTags );
}

function addTweetClick( i, anAnchorElement )
{
    var theTweetText = myTweetHash[anAnchorElement.id][0];
    anAnchorElement.href = "#";
    $( anAnchorElement ).click( tweetClick );
}

function tweetClick( e )
{
    var theRandomIndex = Math.floor( Math.random()
                                     * myTweetHash[e.target.id].length );
    var theTweetText = myTweetHash[e.target.id][theRandomIndex] + " " + myHashTags;
	//$.post("twitterProxy.php", {command:"tweet", data : theTweetText }, onTweetComplete, "json");	
}

function replyTo( aTweetId )
{
//	$.post("twitterProxy.php", {command:"tweet", id : aTweetId }, onReplyTo, "json");	
	console.log("replyTo:" + aTweetId);
}

function retweet( aTweetId )
{
	//$.post("twitterProxy.php", {command:"retweet", id : aTweetId }, onRetweetComplete, "json");	
	onRetweetComplete({retweeted_status:{id_str: aTweetId}});
}

function favorite( aTweetId )
{
	//$.post("twitterProxy.php", {command:"favorite", id : aTweetId }, onFavoriteComplete, "json");	
	onFavoriteComplete({id_str: aTweetId});
}

function showAlertWithHtml( anId, anHtml)
{
	var theAlertSelector = "#" + anId + " div.alert";
	$(theAlertSelector).slideDown(600);
	setTimeout(function(){$(theAlertSelector).slideUp(600);}, 5000);
	
	var theTextSelector = "#" + anId + "_alertText";
	$(theTextSelector).html( anHtml );
}

function onRetweetComplete(aResponse)
{
	if (aResponse)
	{
		showAlertWithHtml( aResponse.retweeted_status.id_str, "<strong>Success!</strong><br/>Your retweet succeeded");
	}
}

function onFavoriteComplete( aResponse )
{
	if (aResponse)
	{
		showAlertWithHtml( aResponse.id_str, "<strong>Success!</strong><br/>You added a Favorite");
	}
}

