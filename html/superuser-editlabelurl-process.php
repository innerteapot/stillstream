<?
	include('common/common.inc.php');

	if (!superUserIsLoggedIn())
	{
		$url = "superuser-message.php";	
	}
	else
	{
		if (isDefined($labelid) && isDefined($url))
		{
			if (updateLabelURL($db, $labelid, $url))
			{
				$url = "superuser-message.php?msg=Label%20has%20been%20updated.&url=recentlyplayed.php";
			}
			else
			{
				$url = "superuser-message.php?msg=Label%20could%20not%20be%20updated.&url=recentlyplayed.php";
			}
		}
		else
		{
			$url = "superuser-message.php?msg=Error%20Label%20ID%20or%20URL%20is%20missing.&url=recentlyplayed.php";
		}
	}

	sendRedirect($url);
?>
