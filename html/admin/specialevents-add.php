<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
	?>
	<head></head>
	<body>
		<h1>Add New Special Event</h1>
		<p><a href="index.php">( back to main menu )</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href="specialevents.php">( back to special events )</a></p>
		<p>Official StillStream Time: <?=officialStillStreamTime()?></p>

		<?
			if (isDefined($msg))
			{
				?><p align="center"><font color="#ff0000"><?=trim($msg)?></font></p><?
			}
		?>
		
		<form action="specialevents-add-process.php" method="post">
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
				<tr>
					<td align="right">Date of Event (YYYY-MM-DD format):</td>
					<td align="left"><input type="text" name="eventdate" value="YYYY-MM-DD"> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
				</tr>
				<tr>
					<td align="right">Time Event Starts (HH:MM:SS format):</td>
					<td align="left"><input type="text" name="eventtime" value="HH:MM:SS"> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
				</tr>
				<tr>
					<td align="right">Event is "ultraspecial":</td>
					<td align="left">
						<select name="ultraspecial" size="1">
							<?
								showOptionTag('yes', 'Yes', 'no');
								showOptionTag('no', 'No', 'no');
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Event Title For RSS Feed (No HTML allowed):</td>
					<td align="left"><input type="text" name="eventtitle" value="" size="50"></td>
				</tr>
				<tr>
					<td align="right">Event Description (HTML allowed):</td>
					<td align="left"><textarea name="eventinfo" cols="60" rows="10">Description goes here...</textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="submit" value=" Add Special Event "></td>
				</tr>
			</table>
		</form>
	</body>
</html>

