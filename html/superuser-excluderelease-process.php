<?
	include('common/common.inc.php');

	if (!superUserIsLoggedIn())
	{
		$url = "superuser-message.php";	
	}
	else
	{
		if (isDefined($releaseid))
		{
			$release = getRelease($db, $releaseid);
			if ($release)
			{
				if ($release->exclude_from_playlist == 'yes')
				{
					$newvalue = false;
				}
				else
				{
					$newvalue = true;
				}

				if (excludeReleaseFromPlaylist($db, $releaseid, $newvalue))
				{
					$url = "superuser-message.php?msg=Release%20has%20been%20updated.&url=recentlyplayed.php";
				}
				else
				{
					$url = "superuser-message.php?msg=Error%20Release%20could%20not%20be%20updated.&url=recentlyplayed.php";
				}
			}
			else
			{
				$url = "superuser-message.php?msg=Error%20Cannot%20find%20release%20by%20release%20id.&url=recentlyplayed.php";
			}
		}
		else
		{
			$url = "superuser-message.php?msg=Error%20Release%20ID%20is%20missing.&url=recentlyplayed.php";
		}
	}

	sendRedirect($url);
?>
