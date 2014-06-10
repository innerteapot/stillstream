<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');

		$hosts = getAllActiveHosts($db);
		if (!isDefined($hostid))
		{
			// doesn't matter what this value is as long as it isn't real
			$hostid = -2328089809;
		}
	?>
	<head></head>
	<body>
		<h1>Send Email To All StillStream Hosts</h1>
		<p><a href="index.php">( back to main menu )</a></p>
		<p>Official StillStream Time: <?=officialStillStreamTime()?></p>
		<?
			if (isDefined($msg))
			{
				?><p align="center"><font color="#ff0000"><?=trim($msg)?></font></p><?
			}
		?>
		<form action="hostemail-process.php" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="15" border="0">
				<tr>
					<td align="center">
						Host(s) to send to:
						<select name="hostid" size="1">
							<option value="-1">(all active hosts)</option>
							<?
								reset($hosts);
								while (list($k, $v) = each($hosts))
								{
									if ($v->id == $hostid)
									{
										?><option selected value="<?=$v->id?>"><?=$v->name?></option><?
									}
									else
									{
										?><option value="<?=$v->id?>"><?=$v->name?></option><?
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="center">
						Text of email (plain text only)<br />
						<textarea name="msg" cols="90" rows="10"></textarea>
					</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" name="submit" value=" Send Email "></td>
				</tr>
			</table>
		</form>
		</p>
	</body>
</html>

