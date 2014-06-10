<?
	include('common/common.inc.php');
	showHeader($db, PG_RSS, -1, false, null, null, $accessible);
?>

<h1>RSS</h1>

<h2>Our RSS Feeds</h2>
<p>
	StillStream has a number of various RSS feeds to which you are free to subscribe.  This is the best way to stay up
	to date with the detailed happenings at StillStream.  If you are unfamiliar with RSS or how to use it, there are a
	number of good tutorials on the Internet, such as <a title="Information About RSS" href="http://www.palinet.org/rss/toti/tsstutorial.htm" target="_blank">this one</a>,
	or <a title="Information About RSS" href="http://loadaveragezero.com/info/what-is-RSS.php" target="_blank">this one</a>, or
	<a title="Information About RSS" href="http://directory.google.com/Top/Computers/Internet/On_the_Web/Syndication_and_Feeds/RSS/FAQs,_Help,_and_Tutorials/" target="_blank">this list of pages</a>.
</p>
<p>
	We encourage everyone interested in our content to subscribe to the feed(s) that are of interest to you.
</p>
<ul class="bullets">
	<li><a title="Comprehensive RSS Feed" href="rss/news.xml"><img src="images/rss.png" border="0">&nbsp; <b>All News</b></a> - all StillStream news, except for the playlist, are published via this feed.</li>
	<li><a title="Calendar RSS Feed" href="rss/calendar.xml"><img src="images/rss.png" border="0">&nbsp; <b>Calendar (All)</b></a> - the entire StillStream calendar of events is published via this feed.</li>
	<li><a title="Special Events RSS Feed" href="rss/specialevents.xml"><img src="images/rss.png" border="0">&nbsp; <b>Calendar (Special)</b></a> - the StillStream calendar of special events is published via this feed.</li>
	<li><a title="Feature RSS Feed" href="rss/features.xml"><img src="images/rss.png" border="0">&nbsp; <b>Features</b></a> - our featured artists, labels, and releases are published via this feed.</li>
	<li><a title="Archives RSS Feed" ref="rss/archives.xml"><img src="images/rss.png" border="0">&nbsp; <b>Archives</b></a> - additions to the StillStream archives are published via this feed.</li>
	<li><a title="Playlist RSS Feed" href="rss/playlist.xml"><img src="images/rss.png" border="0">&nbsp; <b>Playlist</b></a> - the StillStream playlist is published via this feed (note: updated OFTEN).</li>
</ul>
<br />
<p>
	Also we invite you to subscribe to our Twitter updates:
</p>
<ul class="bullets">
	<li><a title="StillStream on Twitter RSS Feed" href="http://twitter.com/statuses/user_timeline/52272272.rss"><img src="images/rss.png" border="0">&nbsp; <b>StillStream on Twitter</b></a> - all StillStream tweets.</li>
</ul>
<br />
<?
	showFooter($db, PG_RSS, $accessible);
?>
