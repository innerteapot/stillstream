<?
	include('common/common.inc.php');
	
	if (isDefined($fullname))
	{
		$url = "submitmusic-step3.php?fn=" . urlencode($fullname);
	}
	else
	{
		$url = "submitmusic-step2.php?msg=Sorry+but+we+need+your+full+legal+name+to+continue.+Please+try+again.";
	}

	sendRedirect($url);
?>
