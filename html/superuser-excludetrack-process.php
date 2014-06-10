<?
	include('common/common.inc.php');

	if (!superUserIsLoggedIn())
	{
		$url = "superuser-message.php";	
	}
	else
	{
		if (isDefined($trackid))
		{
			$track = getTrack($db, $trackid);
			if ($track)
			{
				$newvalue = ($track->exclude_from_playlist == 'yes' ? false : true);

				if (excludeTrackFromPlaylist($db, $trackid, $newvalue))
				{
					$url = "superuser-message.php?msg=Track%20has%20been%20updated.&url=recentlyplayed.php";
				}
				else
				{
					$url = "superuser-message.php?msg=Error%20Track%20could%20not%20be%20updated.&url=recentlyplayed.php";
				}
			}
			else
			{
				$url = "superuser-message.php?msg=Error%20Cannot%20load%20track%20for%20track%20id.&url=recentlyplayed.php";
			}
		}
		else
		{
			$url = "superuser-message.php?msg=Error%20Track%20ID%20is%20missing.&url=recentlyplayed.php";
		}
	}

	sendRedirect($url);
?>
