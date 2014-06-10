<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	if (!isDefined($news))
	{
		$news = '';
	}

	updateNews($db, $news);

	$url = 'news.php?msg=News%20crawler%20has%20been%20updated.';
	sendRedirect($url);
?>
