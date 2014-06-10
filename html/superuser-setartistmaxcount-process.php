<?
	include('common/common.inc.php');

	if (!superUserIsLoggedIn())
	{
		$url = "superuser-message.php";	
	}
	else
	{
		if (isDefined($artistid) && isDefined($maxcount))
		{
			if (updateArtistMaxPlaylistCount($db, $artistid, $maxcount))
			{
				$url = "superuser-message.php?msg=Artist%20max%20count%20has%20been%20updated.&url=recentlyplayed.php";
			}
			else
			{
				$url = "superuser-message.php?msg=Artist%20max%20count%20could%20not%20be%20updated.&url=recentlyplayed.php";
			}
		}
		else
		{
			$url = "superuser-message.php?msg=Error%20Artist%20ID%20or%20Max%20Count%20is%20missing.&url=recentlyplayed.php";
		}
	}

	sendRedirect($url);
?>
