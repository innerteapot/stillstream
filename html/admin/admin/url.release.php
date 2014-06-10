<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$releases = getReleasesMissingURLs($db);
	?>
	<head></head>
	<body>
		<h1>Release URLs</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="url.release-process.php" method="POST">
			<table width="99%" cellpadding="2" cellspacing="0" border="1" align="center">
				<tr>
					<th width="20%">Artist</th>
					<th width="20%">Title</th>
					<th width="20%">Catnum</th>
					<th width="40%">URL</th>
				</tr>
				<?
					reset($releases);
					$counter = -1;
					while (list($k, $r) = each($releases))
					{
						++$counter;

						$googleurl = 'http://google.com/search?q=' . urlencode($r->artist_name . ' ' . $r->title . ' ' . $r->catnum);

						?>
							<tr>
							<td align="center" valign="top">
								<?
									if (isDefined($r->artist_url))
									{
										?><a href="<?=$r->artist_url?>" target="_blank"><?=$r->artist_name?></a><?
									}
									else
									{
										?><?=$r->artist_name?><?
									}
								?>
							</td>
							<td align="center" valign="top"><a href="<?=$googleurl?>" target="_blank"><?=$r->title?></a></td>
							<td align="center" valign="top"><a href="<?=$googleurl?>" target="_blank"><?=$r->catnum?></a></td>
							<td align="center" valign="top">
								<input type="hidden" name="releaseid<?=$counter?>" value="<?=$r->release_id?>">
								<input type="text" name="releaseurl<?=$counter?>" value="" size="60">
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

