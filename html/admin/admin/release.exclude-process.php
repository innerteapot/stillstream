<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	$doredirect = TRUE;
	
	$counter = -1;
	while (TRUE)
	{
		++$counter;
		
		$varname = 'releaseid' . $counter;
		$releaseid = $$varname;
		
		$varname = 'exclude' . $counter;
		$exclude = $$varname;

		if (isDefined($releaseid))
		{
			if (isDefined($exclude))
			{
				if ($exclude == 'yes')
				{
					$sql = "UPDATE `release`
								SET exclude_from_playlist = 'yes'
								WHERE id = $releaseid
								LIMIT 1 ";
				}
				else
				{
					$sql = "UPDATE `release`
								SET exclude_from_playlist = 'no'
								WHERE id = $releaseid
								LIMIT 1 ";
				}				
				mysql_query($sql, $db);				
			}
		}
		else
		{
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("release.exclude.php");
	}
?>                                                                                                                                               
