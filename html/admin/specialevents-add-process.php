<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	if (isDefined($eventdate) && isDefined($eventtitle) && isDefined($eventtime) && isDefined($eventinfo) && isDefined($ultraspecial))
	{
		if (isValidDateValue($eventdate))
		{
			if (isValidTimeValue($eventtime))
			{
				createSpecialEvent($db, $eventdate, $eventtime, $ultraspecial, $eventtitle, $eventinfo);
				$url = 'specialevents.php?msg=Special%20event%20has%20been%20created.';
			}
			else
			{
				$url = 'specialevents-add.php?&msg=Error,%20you%20have%20specified%20an%20invalid%20time.';
			}
		}
		else
		{
			$url = 'specialevents-add.php?&msg=Error,%20you%20have%20specified%20an%20invalid%20date.';
		}
	}
	else
	{
		$url = 'specialevents-add.php?&msg=Error,%20missing%20required%20fields%20(all%20are%20required).';
	}

	sendRedirect($url);
?>
