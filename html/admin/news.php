<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		
		$news = getNews($db);
		if ($news === FALSE)
		{
			$news = '';
		}
	?>
	<head></head>
	<body>
		<h1>Update News Crawler</h1>
		<p><a href="index.php">( back to main menu )</a></p>
		<p>Official StillStream Time: <?=officialStillStreamTime()?></p>
		<?
			if (isDefined($msg))
			{
				?><p align="center"><font color="#ff0000"><?=trim($msg)?></font></p><?
			}
		?>
		<form action="news-process.php" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="15" border="0">
				<tr>
					<td align="center">
						Edit News Crawler (NO LINE BREAKS, blank out the field to remove crawler)<br />
						<textarea name="news" cols="90" rows="7"><?=trim($news)?></textarea>
					</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" name="submit" value=" Update News "></td>
				</tr>
			</table>
		</form>
		</p>
	</body>
</html>

