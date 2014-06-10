<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;
	
	$counter = -1;
	while (TRUE)
	{
		++$counter;
		
		$varname = 'artistid' . $counter;
		$artistid = $$varname;
		
		$varname = 'artistlevel' . $counter;
		$artistlevel = $$varname;

		if (isDefined($artistid))
		{
			if (isDefined($artistlevel))
			{
				updateArtistMaxPlaylistCount($db, $artistid, $artistlevel);
			}
		}
		else
		{
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("playlist.level.php");
	}
?>                                                                                                                                               
