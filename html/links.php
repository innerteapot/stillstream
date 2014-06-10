<?
	include('common/common.inc.php');
	showHeader($db, PG_LINKS, -1, false, null, null, $accessible);
?>
<h1>Links</h1>
<table width="60%" cellpadding="6" cellspacing="2" border="0" align="center">
	<tr>
		<th width="50%">Recommended Stations</th>
		<th width="50%">Recommended Links</th>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="Star's End" href="http://www.starsend.org/" target="_blank">Star's End</a></td>
		<td align="left" bgcolor="#dddddd"><a title="City Skies" href="http://www.cityskies.com" target="_blank">City Skies</a></td>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="Hearts of Space" href="http://www.hos.com/" target="_blank">Hearts of Space</a></td>
		<td align="left" bgcolor="#dddddd"><a title="Longplayer" href="http://longplayer.org/" target="_blank">Longplayer</a></td>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="SomaFM" href="http://www.somafm.com/" target="_blank">SomaFM</a></td>
		<td align="left" bgcolor="#dddddd"><a title="Different Skies" href="http://www.differentskies.com" target="_blank">Different Skies</a></td>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="Secret Music" href="http://secretmusicwvkr.blogspot.com" target="_blank">Secret Music</a></td>
		<td align="left" bgcolor="#dddddd"><a title="The Gatherings" href="http://www.thegatherings.org/" target="_blank">The Gatherings</a></td>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="M.O.P.S." href="http://www.mops-radio.org/" target="_blank">M.O.P.S.</a></td>
		<td align="left" bgcolor="#dddddd"><a title="The Ambient Ping" href="http://www.theambientping.com/" target="_blank">The Ambient Ping</a></td>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="Sleepbot" href="	http://www.sleepbot.com/" target="_blank">Sleepbot</a></td>
		<td align="left" bgcolor="#dddddd"><a title="Solar Culture" href="http://www.solarculture.org" target="_blank">Solar Culture</a></td>
	</tr>
	<tr>
		<td align="left" bgcolor="#dddddd"><a title="Galactic Travels" href="http://www.wdiyfm.org/programs/gt/" target="_blank">Galactic Travels</a></td>
		<td align="left" bgcolor="#dddddd"></td>
	</tr>
</table>
<br />
<?
	showFooter($db, PG_LINKS, $accessible);
?>
