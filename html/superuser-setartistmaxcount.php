<?
	include('common/common.inc.php');
	showHeader($db, PG_SUPERUSER, -1, false, null, null, $accessible);

	function showError($msg)
	{
		?>
			<h1>Error</h1>
			<h2 align="center"><font color="red"><?=$msg?></font></h2>
		<?
	}

	if (!superUserIsLoggedIn())
	{
		showError("You are not authorized to see this page.");
	}
	else
	{
		if (isDefined($artistid))
		{
			$artist = getArtistByID($db, $artistid);
			if ($artist)
			{
				$trackcount = getTrackCountForArtist($db, $artist->id);
				?>
					<h1>Update Artist Max Playlist Count</h1>

					<form action="superuser-setartistmaxcount-process.php" method="post">
						<p align="center">
							Max Playlist Count For <?=$artist->name?> (<?=$trackcount?> tracks): <input type="text" name="maxcount" value="<?=$artist->max_playlist_count?>"><br />
							<input type="hidden" name="artistid" value="<?=$artist->id?>"><input type="submit" name="Submit" value="Submit">
						</p>
					</form>
				<?
			}
			else
			{
				showError("Cannot find artist for artist id:[$artistid].");
			}
		}
		else
		{
			showError("Artist ID is null.");
		}
	}

	showFooter($db, PG_SUPERUSER, $accessible);
?>
