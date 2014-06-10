<?
	include('common/common.inc.php');
	showHeader($db, PG_NONE, -1, false, null, null, $accessible);
?>

<h1>Chat</h1>

<h2>Why Does StillStream Have A Chat Room?</h2>
<p>
	StillStream offers a live real-time chatroom for several reasons.  One is to help foster a sense of
	community amongst listeners. Another is to help connect ambient artists and fans, so that fans
	can converse with their favorite artists, and so artists can interact directly with the people
	who listen to their music. Finally, the chat room is just plain fun, so why not?
</p>


<h2>How Can I Join The Chat?</h2>
<p>
	To make our chat room as easy to access as possible but also allow for the most possible flexibility, we have several ways you can use to access the chat:
	
	<ol>
		<li>
			You can use our web-browser based chat. In order to use this, all you need is a reasonably modern browser with JavaScript support.
			The downside to the web-browser based chat is that it is a hosted application provided by a third party (mibbit.com), and so they
			will show you banner ads as you chat.<br />
			<br />
		</li>
		<li>
			Or, you can use our Java chat. In order to use this, all that is required is that your browser must have the latest Java web browser plugin installed.
			Also note that you'll need to say "Yes" to allowing the signed applet to install. Otherwise, it will not be able to connect to our IRC server.<br />
			<br />
		</li>
		<li>
			Finally, if you know how to use IRC and have your own IRC client, you can simply connect to irc.kacked.com using that client and join
			the #stillstream room.
		</li>
	</ol>
</p>


<h2>When Can I Chat?</h2>
<p>
	Our chat room is always available, so you can chat anytime you feel like it. Traditionally
	people can be found in the chatroom only during our live shows; however, you should feel free
	to join the chat at any time.  For information about when live shows are on the air, you can
	visit our <a title="Program and Special Events Schedule" href="schedule.php">schedule page</a>.
</p>


<h2>What Can I Talk About In The Chat Room?</h2>
<p>
	Generally speaking, StillStream places few restrictions on what folks can do or say within our
	chat room.  With that said, we should also point out that the chat room is moderated by our
	live show hosts, and if a particular person abuses the room or anyone within the room, they may
	be asked to take it outside.  With very rare exceptions, this has proven to be unnecessary, as
	nearly everyone who visits the chat interacts in a cordial and courteous manner, even when
	disagreeing.  However, our hosts retain the ability to kick or ban users, as necessary to
	keep the experience a positive one for all concerned.
</p>
<p>
	In short, you can discuss just about anything you like, so long as the air of community is
	preserved and so long as the atmosphere remains a positive one.
</p>


	<h2>Can I Criticize The Music?</h2>
	<p>
		The short answer is:  yes, but it does depend on how you do it.
	</p>
	<p>
		Again, we generally do not want to put any sort of limitations on free speech or upon what
		folks can do or say in our chat room, so we do not want to categorically say that people
		cannot critique what they are hearing on StillStream.
	</p>
	<p>
		However, it is also important to remember the mission of StillStream, which is to promote
		ambient music as a genre, and also to promote the music of each ambient artist we play.
		To that end, it would be contrary to the whole purpose of StillStream if our chat room should
		become a place where the music is dissected and ripped to pieces.
	</p>
	<p>
		Therefore, we ask that all chat room participants remember a few facts before posting a negative
		comment about a track to the room.
	</p>
	<ol>
		<li>
			StillStream is an ambient station, and plays music from <b>all</b> the various subgenres that
			make up ambient music, including dark ambient, abstract ambient, experimental ambient,
			tribal ambient, light ambient, textural ambient, ambient noise, and even music that 
			some might describe as "musical wallpaper".  Therefore, it is important to remember that
			because ambient is a very broad genre, it is
			inevitable we will sometimes play music that doesn't appeal to some folks.  But StillStream
			cannot focus on just one part of ambient; we must cover all parts of the genre.  We
			would be doing a disservice to the ambient community if we did not.<br />
			<br />
		</li>
		<li>
			Additionally, it is quite common for an artist to actually be present in the chat room
			while one of their pieces is being played.  Sometimes folks may critique the music but
			not realize the artist his/herself is present.  Further, chat room discussions are public
			and so there is nothing keeping someone from copy/pasting a chat room dialogue and emailing
			it or posting it to a different web site. Thus it is a good idea to assume that
			the artist will directly read your comments, and so you shouldn't say anything that you
			would not be comfortable saying directly to the artist's face.<br />
			<br />
		</li>
		<li>
			At the end of the day, if you find you are not enjoying the music of StillStream, then it probably
			means you shouldn't listen to StillStream.  We don't pretend to have the single penultimate
			collection of ambient music, and so if our collection doesn't match your tastes then there
			really is no other solution.  We'd rather you stayed a listener, of course, but we have
			to balance the tastes of individuals against the collective good of the genre and the
			community, and so sometimes the needs of the individual are trumped.
		</li>
			
	</ol>



	<h2>Are There Any Other Tips?</h2>
	<p>
		The number one tip is for you to download and use a real IRC chat client instead of the Java-based
		client built into our web site.  The reason is that the Java client has technological limitations
		that true standalone IRC clients do not have, which will make for a more enjoyable chatting experience.
		The downside is that one must learn to use the IRC client, which is really not that difficult but
		does require a bit of learning curve.  There are many superb IRC clients freely available, so you can
		download and install a great client without spending anything but a bit of your time.  This is, of course,
		totally optional since the Java client does exist and does (mostly) work, but if you are a regular
		visitor to the chat, then you really should investigate a real IRC client.
	</p>
	<p>
		Another tip is to register your nick.  Our chat room is based upon the Kacked.com IRC network, which allows
		and encourages users to register their own private nick.  The advantage to this is you will associate
		a password with your nick, which ensures that nobody else can ever use your nick and impersonate you
		in the chat.  Again, this is purely optional but will help maintain a good chatting experience.
	</p>
	<p>
		You may find it useful to learn a few basic IRC commands, such as '/nick' and '/me'.  A full reference
		of IRC commands <a title="IRC Commands on Wikipedia" href="http://en.wikipedia.org/wiki/List_of_Internet_Relay_Chat_commands" target="_blank">can
		be found here</a>.
	</p>
	<p>
		Finally, remember to be active and have fun!
	</p>
</div>

<?
	showFooter($db, PG_NONE, $accessible);
?>
