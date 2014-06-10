<?
	include('common/common.inc.php');

	if (!superUserIsLoggedIn())
	{
		$url = "superuser-message.php";	
	}
	else
	{
		if (isDefined($artistid) && isDefined($url))
		{
			if (updateArtistURL($db, $artistid, $url))
			{
				$url = "superuser-message.php?msg=Artist%20has%20been%20updated.&url=recentlyplayed.php";
			}
			else
			{
				$url = "superuser-message.php?msg=Artist%20could%20not%20be%20updated.&url=recentlyplayed.php";
			}
		}
		else
		{
			$url = "superuser-message.php?msg=Error%20Artist%20ID%20or%20URL%20is%20missing.&url=recentlyplayed.php";
		}
	}

	sendRedirect($url);
?>
