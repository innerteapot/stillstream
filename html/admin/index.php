<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$artists = getArtistsWhoHaveSignedAgreement($db);
	?>
	<head></head>
	<body>
		<h1>Admin Main Menu</h1>

		<h2>Host Functions</h2>
		<p>
			<a href="http://stillstream.com/repository">Download From Master Repository</a> - username/password same as for this page</a><br />
			<a href="assets/empty.mp3">Download Big Empty MP3 File For Voiceovers (approx 55 MB)</a><br />
			<a href="artists.php">Show Commercial Artists Who Have Signed Online Waiver</a><br />
		</p>

		<h2>On Air Functions</h2>
		<p>
			<a href="tags.php">Update ID3 Tags Manually</a><br />
			<a href="liveshowstats.php" target="_blank">See Number Of Listeners Graph (near-realtime)</a><br />
		</p>

		<h2>Email Functions</h2>
		<p>
			<a href="hostemail.php">Send Email To StillStream Hosts</a><br />
		</p>

		<h2>Archives Functions</h2>
		<p>
			<a href="archives-entry.php">Upload New File To Archives</a><br />
			<a href="archives-errorlog.php">View Archives Upload Error Log</a><br />
		</p>

		<h2>News Functions</h2>
		<p>
			<a href="specialevents.php">Add/Update/Delete Special Events</a><br />
			<a href="news.php">Update News Crawler</a>
		</p>
	</body>
</html>

