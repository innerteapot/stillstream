<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	if (isDefined($id))
	{
		deleteSpecialEvent($db, $id);
		$url = 'specialevents.php?msg=Special%20event%20has%20been%20deleted.';
	}
	else
	{
		$url = 'specialevents.php?&msg=Error%20,no%20special%20event%20id%20was%20specified.';
	}

	sendRedirect($url);
?>
