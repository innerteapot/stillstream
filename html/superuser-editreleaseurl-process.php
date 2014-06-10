<?
	include('common/common.inc.php');

	if (!superUserIsLoggedIn())
	{
		$url = "superuser-message.php";	
	}
	else
	{
		if (isDefined($releaseid) && isDefined($url))
		{
			if (updateReleaseURL($db, $releaseid, $url))
			{
				$url = "superuser-message.php?msg=Release%20has%20been%20updated.&url=recentlyplayed.php";
			}
			else
			{
				$url = "superuser-message.php?msg=Release%20could%20not%20be%20updated.&url=recentlyplayed.php";
			}
		}
		else
		{
			$url = "superuser-message.php?msg=Error%20Release%20ID%20or%20URL%20is%20missing.&url=recentlyplayed.php";
		}
	}

	sendRedirect($url);
?>
