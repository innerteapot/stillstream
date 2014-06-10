<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$artists = getArtistsMissingURLs($db);
	?>
	<head></head>
	<body>
		<h1>Artist URLs</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="url.artist-process.php" method="POST">
			<table width="99%" cellpadding="2" cellspacing="0" border="1" align="center">
				<tr>
					<th width="40%">Artist</th>
					<th width="60%">URL</th>
				</tr>
				<?
					reset($artists);
					$counter = -1;
					while (list($k, $a) = each($artists))
					{
						++$counter;
						?>
							<tr>
								<td align="center" valign="top"><?=$a->name?></td>
								<td align="center" valign="top">
									<input type="hidden" name="artistid<?=$counter?>" value="<?=$a->id?>">
									<input type="text" name="artisturl<?=$counter?>" value="" size="60">
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

