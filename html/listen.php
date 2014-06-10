<?
	include('common/common.inc.php');
	showHeader($db, PG_LISTEN, -1, false, null, null, $accessible);
?>

<h1>How To Listen</h1>
<?
	if ($accessible)
	{
		?>
			<h2>Tune In</h2>
			<table width="95%" align="center" border="0" cellpadding="5" cellspacing="5">
				<tr>
					<td valign="top" align="left"><a title="Listen Using Our Flash Player" href="javascript:openFlashPlayerDirect();">Flash Player</a></td>
					<td valign="top" align="left">Listen using our Flash player.</td>
				</tr>
				<tr>
					<td valign="top" align="left"><a title="Listen Using Winamp" href="listen/winamp.direct.pls">Winamp</a></td>
					<td valign="top" align="left">Listen using Winamp.</td>
				</tr>
				<tr>
					<td valign="top" align="left"><a title="Listen Using iTunes" href="listen/itunes.direct.m3u">Listen Using iTunes</a></td>
					<td valign="top" align="left">Listen using iTunes.</td>
				</tr>
				<tr>
					<td valign="top" align="left"><a title="Listen Using Real Player" href="listen/realplayer.direct.ram">Listen Using Real Player</a></td>
					<td valign="top" align="left">Listen using Real Player.</td>
				</tr>
				<tr>
					<td valign="top" align="left"><a title="Listen Using Windows Media Player" href="listen/wmp.direct.asx">Listen Using Windows Media Player</a></td>
					<td valign="top" align="left">Listen using Windows Media Player.</td>
				</tr>
				<tr>
					<td valign="top" align="left"><a title="Listen Using a Different Player, Requires M3U Support" href="listen/other.direct.m3u">Listen Using a Different Media Player</a></td>
					<td valign="top" align="left">Listen using a different player.</td>
				</tr>
			</table>
		<?
	}
?>
<h2>About Players</h2>
<p>
	There are a wide variety of music players that are compatible with StillStream. The best
	one for you to use will depend on a wide variety of factors, so it is hard for us to recommend
	a particular one. Plus, it is our goal for the station to be hearable using nearly any
	standard player, so we try not to push any particular one.
</p>
<p>
	In general, though, we find that our listeners have success using the following combinations.
	Your mileage may vary, so you should choose the combination that best suits your needs:
</p>
<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
	<tr>
		<td width="32%" align="left" valign="top"><b>Winamp + Windows</b></td>
		<td width="68%" align="left" valign="top">
			If you use this combination, then you can tune in simply by
			choosing one of the Winamp options from our Listen menu.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"><b>iTunes + Mac or Windows</b></td>
		<td align="left" valign="top">
			If you use this combination, then you can again tune in by
			choosing one of the iTunes options from our Listen menu.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"><b>Real Player + Mac, Windows, or Unix</b></td>
		<td align="left" valign="top">
			If you use this combination, then you can use one of the
			Real Player options from our Listen menu.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"><b>Windows Media Player + Windows</b></td>
		<td align="left" valign="top">
			If you use this combination, then you can use one of the
			Windows Media Player options from our Listen menu.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"><b>Other Combinations</b></td>
		<td align="left" valign="top">
			There are numerous other players in the world, many of
			superb quality. To listen using these alternate players,
			we suggest you first try to use the "Different Media
			Player" options from our Listen menu. If that doesn't work,
			then we suggest you try the Winamp options to see if they
			trigger playback in your player. If that still doesn't
			work, then see below for the direct URLs to listen at.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top"><b>Our Flash Player</b></td>
		<td align="left" valign="top">
			The Flash player built into our web site is a fine piece
			of software, but we in general recommend using a native
			music player program if possible, simply because you are
			more likely to have a reliable listening experience.
			However, if you have trouble getting a native program to
			work, or if you don't want to use a native program, our
			Flash player is certainly available and should work fine
			for most users. It does require a recent version of Flash
			to work, so if you have trouble using it, please consider
			upgrading to the latest version of Flash.
		</td>
	</tr>
</table>

<?
	/*
<h2>Direct Listening versus Proxied Listening</h2>
<p>
	StillStream offers two different mechanisms for listening, one called
	"direct" and the other called "proxied".
</p>
<p>
	In general, using a direct connection is much better than using a proxied
	one. This is because the stream will be more reliable for you, plus it
	will slightly reduce the load on the StillStream servers. However, using
	a direct connection requires your computer to be able to tune into a
	so-called "high numbered port", which some corporate firewalls and routers
	disallow for security reasons unrelated to streaming.
</p>
<p>
	For this reason, StillStream offers proxied connections as well. The
	proxied connections work over the same port number as regular web page
	connections, so nearly all firewalls and routers will allow this traffic
	to pass. If you are unable to use a direct connection, then we encourage
	you to try to use a proxied one.
</p>
<p>
	Please avoid using a proxied connection, however, if a direct connection
	works for you. It will give you a more reliable listening experience and will
	also help keep the load on our servers as minimal as possible.
</p>
	*/
?>

<h2>Connecting Directly</h2>
<p>
	Sometimes a particular media player may not be completely compatible
	with the various playlist files we have set up. Nearly all players allow
	you to directly tune in to a URL, however. So, if you have trouble using
	any of the preset playlist files we have set up above, you can try using
	the direct URL:
</p>
<table align="center" cellpadding="5" cellspacing="5" border="0">
	<tr>
		<td align="left" valign="top"><b>Primary Server (Direct)</b></td>
		<td width="15">&nbsp;</td>
		<td align="left" valign="top"><a title="Primary Server Direct URL" href="<?php echo LISTEN_URL_EXTERNAL ; ?>" target="_blank"><?php echo LISTEN_URL_EXTERNAL ; ?></a></td>
	</tr>
</table>
<br/>
<p>
	Note that the proxied connection is no longer available.
</p>

<?
	showFooter($db, PG_LISTEN, $accessible);
?>
