<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;

	$releases = getAllReleases($db);
	while (list($k, $v) = each($releases))
	{
		$clearimage = FALSE;
		
		$ti = $v->thumbnail_image;
		if ($ti)
		{
			$fn = '/home/stillstream/stillstream.com/html/images/releases/' . trim($ti);
			
			if (file_exists($fn))
			{
				$st = stat($fn);
				if ($st['size'] > 500)
				{
					$clearimage = FALSE;
				}
				else
				{
					$clearimage = TRUE;
				}
			}
			else
			{
				$clearimage = TRUE;
			}
		}
		
		if ($clearimage)
		{
			// print "[" . $v->id . "][" . $v->title . "]<br />";
			updateReleaseThumbnail($db, $v->id, NULL);
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("loadcovers.php");
	}
?>                                                                                                                                               
