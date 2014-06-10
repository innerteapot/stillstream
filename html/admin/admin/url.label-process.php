<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;
	
	$counter = -1;
	while (TRUE)
	{
		++$counter;
		
		$varname = 'labelid' . $counter;
		$labelid = $$varname;
		
		$varname = 'labelurl' . $counter;
		$labelurl = $$varname;

		if (isDefined($labelid))
		{
			if (isDefined($labelurl))
			{
				$labelurl = urldecode($labelurl);
				updateLabelURL($db, $labelid, $labelurl);
			}
		}
		else
		{
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("url.label.php");
	}
?>                                                                                                                                               
