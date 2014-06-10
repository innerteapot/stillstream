<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$artists = getArtistsWhoHaveSignedAgreement($db);
	?>
	<head></head>
	<body>
		<h1>Artists</h1>
		<p><a href="index.php">( back to main menu )</a></p>
		<p>Official StillStream Time: <?=officialStillStreamTime()?></p>
		<p>
			The following artists have given StillStream blanket permission to play their music
			freely on StillStream:
		</p>
		<p>
			<?
				reset($artists);
				while (list($k, $artist) = each($artists))
				{
					?>
						<a href="<?=$artist->url?>" target="_blank"><?=$artist->name?></a><br />
					<?
				}
			?>
		</p>
	</body>
</html>

