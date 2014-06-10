<?
	include('common/common.inc.php');
	showHeader($db, PG_MUSIC, -1, false, null, null, $accessible);
?>

<h1>Music</h1>

<table border="0" cellpadding="5" cellspacing="5" align="center">
	<tr>
		<td valign="top" align="center"><a title="Featured Artists, Releases, and Labels" href="features.php">Features</a></td>
		<td valign="top" align="left">Browse our featured artists, releases, and labels.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Charts" href="charts.php">Charts</a></td>
		<td valign="top" align="left">See what tracks, albums, and artists we have been playing the most of.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Artist Listings" href="artists.php">Artists</a></td>
		<td valign="top" align="left">A comprehensive listing of all artists in our vast repository.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Archives" href="archives.php">Archives</a></td>
		<td valign="top" align="left">Downloadable excerpts from some of the live performances we have broadcast.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Playlist Search" href="search.php">Search</a></td>
		<td valign="top" align="left">Search our playlist for artists, tracks, labels, or by date range.</td>
	</tr>
</table>

<?
	showFooter($db, PG_MUSIC, $accessible);
?>
