<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
	?>
	<head></head>
	<body>
		<h1>Update ID3 Tags Manually</h1>
		<p><a href="index.php">( back to main menu )</a></p>
		<p>Official StillStream Time: <?=officialStillStreamTime()?></p>
		<?
			if (isDefined($msg))
			{
				?><p align="center"><font color="#ff0000"><?=trim($msg)?></font></p><?
			}
		?>
		<form action="tags-process.php" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="15" border="0">
				<tr>
					<td align="center">
						New ID3 Tag, using the following form:<br />
						<pre>Artist Name - Song Name</pre>
						Absolutely no HTML and avoid special characters!<br />
						<br />
						<input type="text" name="newtag" value="" size="80" maxlength="255" />
					</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" name="submit" value=" Update Tags "></td>
				</tr>
			</table>
		</form>
		</p>
	</body>
</html>

