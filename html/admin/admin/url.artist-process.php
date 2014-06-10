<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;
	
	$counter = -1;
	while (TRUE)
	{
		++$counter;
		
		$varname = 'artistid' . $counter;
		$artistid = $$varname;
		
		$varname = 'artisturl' . $counter;
		$artisturl = $$varname;

		if (isDefined($artistid))
		{
			if (isDefined($artisturl))
			{
				$artisturl = urldecode($artisturl);
				updateArtistURL($db, $artistid, $artisturl);
			}
		}
		else
		{
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("url.artist.php");
	}
?>                                                                                                                                               
