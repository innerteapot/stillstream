<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	// drop a cookie so the rest of the system knows we are a super user
	setcookie(SUPERUSER_COOKIE, "blah", 0, "/");
?>
<html>
	<head></head>
	<body>
		<h1>Admin Admin Main Menu</h1>

		<?
			if (isDefined($msg))
			{
				?><p align="center"><font color="red"><?=$msg?></font></p><?
			}
		?>

		<h2>Wally Fine Tuning</h2>
		<p>
			<a href="release.exclude.php">Exclude Releases From Playlist</a><br />
			<a href="playlist.level.php">Set Artist Max Playlist Counts</a><br />
			<a href="playlist.stats.php">See Playlist Stats Report</a><br />
		</p>

		<h2>Repository Maintenance</h2>
		<p>
			<a href="url.artist.php">Add Missing Artist URLs</a><br />
			<a href="url.release.php">Add Missing Release URLs</a><br />
			<a href="url.label.php">Add Missing Label URLs</a><br />
			<a href="loadcovers.php">Update Album Covers</a><br />
		</p>

		<h2>Artist Maintenance</h2>
		<p>
			<a href="artist.search.php">Search For Existing Artist</a><br />
		</p>

		<h2>Database Maintenance</h2>
		<p>
			<a href="http://srv3.electro-music.com/myadmin" target="_blank">phpMyAdmin</a><br />
		</p>
	</body>
</html>
