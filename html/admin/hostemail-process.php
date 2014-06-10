<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	if (isDefined($msg) && isDefined($hostid))
	{
		if ($hostid == 0)
		{
			$url = 'hostemail.php?msg=Sorry+but+you+cannot+send+email+to+Wally.+He+is+a+piece+of+software.';
		}
		else if ($hostid == -1)
		{	
			notifyAllHosts($db, 'An Email Sent By One StillStream Host To All StillStream Hosts', $msg);
			$url = 'hostemail.php?msg=Email+has+been+sent.';
		}
		else
		{
			notifyHost($db, $hostid, 'An Email Sent By One StillStream Host To Another StillStream Host', $msg);
			$url = 'hostemail.php?msg=Email+has+been+sent.';
		}
	}
	else
	{
		$url = 'hostemail.php?msg=Please+specify+your+email+text.';
	}

	sendRedirect($url);
?>
