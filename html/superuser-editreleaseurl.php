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
		if (isDefined($releaseid))
		{
			$release = getRelease($db, $releaseid);
			if ($release)
			{
				?>
					<h1>Edit Release URL</h1>

					<form action="superuser-editreleaseurl-process.php" method="post">
						<p align="center">
							Release URL for <?=$release->title?>: <input type="text" name="url" size="80" value="<?=$release->releaseurl?>"><br />
							<input type="hidden" name="releaseid" value="<?=$release->id?>"><input type="submit" name="Submit" value="Submit">
						</p>
					</form>
				<?
			}
			else
			{
				showError("Cannot find release for release id:[$releaseid].");
			}
		}
		else
		{
			showError("Release ID is null.");
		}
	}

	showFooter($db, PG_SUPERUSER, $accessible);
?>
