<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$labels = getLabelsMissingURLs($db);
	?>
	<head></head>
	<body>
		<h1>Label URLs</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="url.label-process.php" method="POST">
			<table width="99%" cellpadding="2" cellspacing="0" border="1" align="center">
				<tr>
					<th width="40%">Label</th>
					<th width="60%">URL</th>
				</tr>
				<?
					reset($labels);
					$counter = -1;
					while (list($k, $l) = each($labels))
					{
						++$counter;
						?>
							<tr>
							<td align="center" valign="top"><?=$l->name?></td>
							<td align="center" valign="top">
								<input type="hidden" name="labelid<?=$counter?>" value="<?=$l->id?>">
								<input type="text" name="labelurl<?=$counter?>" value="" size="60">
							</td>
							</tr>
						<?
					}
				?>
			</table>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
		</form>
	</body>
</html>

