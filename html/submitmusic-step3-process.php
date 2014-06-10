<?
	include('common/common.inc.php');
	
	if (isDefined($fullname) && isDefined($fn))
	{
		$fullname = urlencode($fullname);
		$fn = urlencode($fn);
		if ($fullname == $fn)
		{
			$url = "submitmusic-step4.php?fn=$fn";
		}
		else
		{
			$url = "submitmusic-step3.php?fn=$fn&msg=Sorry,+but+your+full+name+does+not+match+what+you+typed+before.+Please+try+again.";
		}
	}
	else
	{
		$url = "submitmusic-step3.php?fn=$fn&msg=Sorry+but+we+need+your+full+legal+name+to+continue.+Please+try+again.";
	}

	sendRedirect($url);
?>
