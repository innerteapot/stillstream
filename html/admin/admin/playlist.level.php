<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$artists = getArtistsOrderedByMaxPlaylistCount($db);
	?>
	<head></head>
	<body>
		<h1>Artist Playlist Levels</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="playlist.level-process.php" method="POST">
			<table width="50%" cellpadding="2" cellspacing="0" border="1" align="center">
				<tr>
					<th width="50%">Artist</th>
					<th width="25%">Track Count</th>
					<th width="25%">Max Playlist Count</th>
				</tr>
				<?
					reset($artists);
					$counter = -1;
					while (list($k, $a) = each($artists))
					{
						++$counter;
						
						$trackcount = getTrackCountForArtist($db, $a->id);
						$artistlevel = $a->max_playlist_count;

						$bgcolor = "#ffffff";
						if ($trackcount < 1)
						{
							$bgcolor = "#0000ff";
						}
						else if ($artistlevel < 0)
						{
							$bgcolor = "#ff0000";
						}
						else if ($artistlevel == 0)
						{
							$bgcolor = "#ffffff";
						}
						else if ($artistlevel < 5)
						{
							$bgcolor = "#ffff00";
						}
						else if ($artistlevel < 25)
						{
							$bgcolor = "#99ff99";
						}
						else
						{
							$bgcolor = "#00ff00";
						}

						$warningcolor = "#ffffff";
						if ($trackcount > $artistlevel)
						{
							$warningcolor = "e0e0ff";
						}
						
						?>
							<tr>
								<td align="center" valign="top"><?=$a->name?></td>
								<td align="center" valign="top" bgcolor="<?=$warningcolor?>"><?=$trackcount?></td>
								<td align="center" valign="top" bgcolor="<?=$bgcolor?>">
									<input type="hidden" name="artistid<?=$counter?>" value="<?=$a->id?>">									
									<input type="text" name="artistlevel<?=$counter?>" value="<?=$artistlevel?>">
								</td>
							</tr>
						<?
					}
				?>
			</table>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
		</form>
	</body>
</html>

