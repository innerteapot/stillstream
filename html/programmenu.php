<?
	include('common/common.inc.php');
	showHeader($db, PG_PROGRAMS, -1, false, null, null, $accessible);
?>

<h1>Programs</h1>

<table border="0" cellpadding="5" cellspacing="5" align="center">
	<tr>
		<td valign="top" align="center"><a title="Program and Special Events Schedule" href="schedule.php">Schedule</a></td>
		<td valign="top" align="left">Check out our weekly programs and upcoming special events.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Program Listing" href="programs.php">Our Shows</a></td>
		<td valign="top" align="left">A listing of each of our weekly shows, including a description and links.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Hosts Listing" href="hosts.php">Our Hosts</a></td>
		<td valign="top" align="left">The people who host our live shows.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Playlists" href="playlists.php">Playlists</a></td>
		<td valign="top" align="left">See what has been played on past live shows.</td>
	</tr>
</table>
<?
	showFooter($db, PG_PROGRAMS, $accessible);
?>
