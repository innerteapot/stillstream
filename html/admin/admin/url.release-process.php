<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;
	
	$counter = -1;
	while (TRUE)
	{
		++$counter;
		
		$varname = 'releaseid' . $counter;
		$releaseid = $$varname;
		
		$varname = 'releaseurl' . $counter;
		$releaseurl = $$varname;

		if (isDefined($releaseid))
		{
			if (isDefined($releaseurl))
			{
				$releaseurl = urldecode($releaseurl);
				updateReleaseURL($db, $releaseid, $releaseurl);
			}
		}
		else
		{
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("url.release.php");
	}
?>                                                                                                                                               
