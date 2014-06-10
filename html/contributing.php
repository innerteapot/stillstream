<?
	include('common/common.inc.php');
	showHeader($db, PG_CONTRIBUTING, -1, false, null, null, $accessible);

	$embedhtml = "&lt;iframe src=\"http://stillstream.com/player.embedded/\" width=\"220\" height=\"190\" border=\"0\"\nframeborder=\"0\" style=\"width:220px; height:190px; border:0px; overflow:hidden; margin:0; padding:0;\"\nscrolling=\"no\" vspace=\"0\" hspace=\"0\" valign=\"middle\" align=\"middle\"&gt;&amp;nbsp;&lt;/iframe&gt;";
	$linkhtml1 = "&lt;a href=\"http://stillstream.com\"&gt;&lt;img src=\"http://stillstream.com/images/banners/banner1.png\"&gt;&lt;/a&gt;";
	$linkhtml2 = "&lt;a href=\"http://stillstream.com\"&gt;&lt;img src=\"http://stillstream.com/images/banners/banner2.png\"&gt;&lt;/a&gt;";
	$linkhtml3 = "&lt;a href=\"http://stillstream.com\"&gt;&lt;img src=\"http://stillstream.com/images/banners/banner3.png\"&gt;&lt;/a&gt;";
	$linkhtml4 = "&lt;a href=\"http://stillstream.com\"&gt;&lt;img src=\"http://stillstream.com/images/banners/banner4.png\"&gt;&lt;/a&gt;";
?>

<h1>How You Can Help</h1>

<h2>Donations</h2>
<p>
	To preserve our non-commercial status in good faith, StillStream does not accept direct financial donations.
	However, we do accept assistance in a variety of other ways, so if you are interested in supporting us,
	please read on. If you feel strongly about donating financially, then please see our
	<a title="Financial Donations" href="donations.php">donations page</a>.
</p>

<?
/*
<h2>Volunteering</h2>
<p>
	StillStream accepts donations in the form of volunteer time,
	particularly in the area of new music scouting. If you are interested in volunteering to help us in that
	or other potential capacities, please <a title="How To Reach Us" href="contact.php">contact us</a>.
</p>

<h2>Benefit Releases</h2>
<p>
	In addition, there have been instances where musicians have voluntarily put together benefit releases for
	StillStream, which are available at <a title="Blue Water Records" href="http://bluewaterrecords.com" target="_blank">Blue Water Records</a>.
	All proceeds from sales of those releases go directly to help pay our hosting tab, so if you really really want to
	support us financially you could purchase one of those releases.
</p>
	
<h2>Host Your Own Show</h2>
<p>
	Another way you could help is to consider hosting your own show on StillStream. Hosting a show does require some work
	and does need some degree of commitment but it also is very rewarding and a lot of fun too. If you're interested
	in finding out more about hosting a program, just <a title="How To Reach Us" href="contact.php">contact us</a> and we'll be happy to answer
	your questions.
</p>
	
<h2>Host a StillStream Relay</h2>
<p>
	Do you own a server on the public internet that has a decent amount of bandwidth to spare?  Are you interested in potentially hosting
	a Shoutcast relay for StillStream?  Hosting a relay is extremely easy; in fact, the only real cost is a small amount
	of cpu for the hosting software, and of course the bandwidth that the stream consumes (admittedly, non-trivial). If you are potentially interested,
	please <a title="How To Reach Us" href="contact.php">contact us</a>; we'd love to talk to you.
</p>
*/
?>
<h2>Embed Our Player</h2>
<p>
	Would you like to embed the StillStream player in your own web site? It's actually very easy to do and it won't impact your web server's
	bandwidth at all, since the viewer's browser connects directly to StillStream. All you need to do is to drop the following HTML code into your
	web page's source code:
</p>
<pre style="margin: 0px; padding: 6px; border: 1px inset; text-align: left; overflow: auto"><?=$embedhtml?></pre>

<h2>Link To Us</h2>
<p>
	Finally, yet another way you can also support us is to proudly display one of our banners (with a link back to StillStream
	of course)!  We invite you to use any of the HTML code you see below to display the banner on your site, or
	even a simple text link from your site helps.  StillStream's marketing budget is precisely zero, so we rely
	on word of mouth.  Help us bring ambient music to a larger world!
</p>
<p>
	Here are banners you can use if you would like to:
</p>
<p>
	<img src="images/banners/banner1.png"><br />
	<pre style="margin: 0px; padding: 6px; border: 1px inset; text-align: left; overflow: auto"><?=$linkhtml1?></pre>
</p>
<p>
	<br />
	<img src="images/banners/banner2.png"><br />
	<pre style="margin: 0px; padding: 6px; border: 1px inset; text-align: left; overflow: auto"><?=$linkhtml2?></pre>
</p>
<p>
	<br />
	<img src="images/banners/banner3.png"><br />
	<pre style="margin: 0px; padding: 6px; border: 1px inset; text-align: left; overflow: auto"><?=$linkhtml3?></pre>
</p>
<p>
	<br />
	<img src="images/banners/banner4.png"><br />
	<pre style="margin: 0px; padding: 6px; border: 1px inset; text-align: left; overflow: auto"><?=$linkhtml4?></pre>
</p>
<p>
	Thank you for supporting StillStream!
</p>

<?
	showFooter($db, PG_CONTRIBUTING, $accessible);
?>
