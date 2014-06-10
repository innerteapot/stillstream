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
				?>
					<h1>Edit Artist URL</h1>

					<form action="superuser-editartisturl-process.php" method="post">
						<p align="center">
							Artist URL for <?=$artist->name?>: <input type="text" name="url" size="120" value="<?=$artist->url?>"><br />
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
