<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;

	if ($releaseid)
	{
		if (!updateReleaseThumbnail($db, $releaseid, 'confirmed_missing_album_cover.jpg'))
		{
			print "ERROR: could not update thumbnail to [$imgfile] for release id [$releaseid]<br />";
			$doredirect = FALSE;
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("loadcovers.php");
	}
?>                                                                                                                                               
