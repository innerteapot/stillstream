<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	if (isDefined($eventid) && isDefined($eventtitle) && isDefined($eventdate) && isDefined($eventtime) && isDefined($eventinfo) && isDefined($ultraspecial))
	{
		if (isValidDateValue($eventdate))
		{
			if (isValidTimeValue($eventtime))
			{
				updateSpecialEvent($db, $eventid, $eventdate, $eventtime, $ultraspecial, $eventtitle, $eventinfo);
				$url = 'specialevents.php?msg=Special%20event%20has%20been%20updated.';
			}
			else
			{
				$url = 'specialevents-edit.php?id=' . $eventid . '&msg=Error,%20you%20have%20specified%20an%20invalid%20time.';
			}
		}
		else
		{
			$url = 'specialevents-edit.php?id=' . $eventid . '&msg=Error,%20you%20have%20specified%20an%20invalid%20date.';
		}
	}
	else
	{
		$url = 'specialevents-edit.php?id=' . $eventid . '&msg=Error,%20missing%20required%20fields%20(all%20are%20required).';
	}

	sendRedirect($url);
?>
