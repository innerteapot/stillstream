<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');
	
	define("UPDINFO_URL", "http://localhost:8500/admin.cgi?pass=u7AGteN6&mode=updinfo&song=");

	function validateTags($newtag)
	{
        return true;
		$a = explode("-", $newtag);
		if (count($a) != 2)
		{
			return false;
		}
		else
		{
			$artist = trim($a[0]);
			$track = trim($a[1]);
			if (isDefined($artist) && isDefined($track))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	function updateTags($newtag)
	{
		$newtag = urlencode($newtag);
		$newtag = str_replace("+", "%20", $newtag);
		$url = UPDINFO_URL . $newtag;
		$cmd = "curl --user-agent \"SHOUTcast Song Status (Mozilla Compatible)\" --silent --location \"" . trim($url) . "\"";
		system($cmd);
	}

	if (!isDefined($newtag))
	{
		$url = 'tags.php?msg=Please%20specify%20the%20new%20tags.';
	}
	else
	{
		if (validateTags($newtag))
		{
			updateTags($newtag);
			$url = 'tags.php?msg=Tags%20have%20been%20updated.';
		}
		else
		{
			$url = 'tags.php?msg=Tags%20are%20in%20an%20invalid%20format,%20try%20again.';
		}
	}
	
	sendRedirect($url);
?>
