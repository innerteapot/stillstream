<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
	?>
	<head></head>
	<body>
		<h1>Search For Existing Artist</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="artist.search.php" method="POST">
			<table cellpadding="2" cellspacing="0" border="0" align="center">
				<tr>
					<td>Artist Name (case is irrelevant):</td>
					<td><input type="text" name="artistname" value="" size="40"></td>
				</tr>
			</table>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
		</form>
		<?
			if (isDefined($artistname))
			{
				?><hr size="1"><?
				$foundartists = getArtistNamesByNameLike($db, $artistname);
				if (count($foundartists) > 0)
				{
					?>
						<h3>Results For "<?=$artistname?>"</h3>
					<?
					reset($foundartists);
					while (list($k, $v) = each($foundartists))
					{
						?><p>Found: "<?=$v->name?>"</p><?
					}
				}
				else
				{
					?>
						<h3>Results For "<?=$artistname?>"</h3>
						<p>No match found.</p>
					<?
				}
			}
		?>
	</body>
</html>

