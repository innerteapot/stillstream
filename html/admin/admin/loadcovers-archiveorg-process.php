<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;

	if ($releaseid)
	{
		if (!updateReleaseThumbnail($db, $releaseid, 'archive.org.jpg'))
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
