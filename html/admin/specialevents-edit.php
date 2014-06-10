<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
	?>
	<head></head>
	<body>
		<?
			if (isDefined($id))
			{
				$event = getSpecialEvent($db, $id);
				if ($event)
				{
					?>
						<h1>Edit Special Event</h1>
					  <p><a href="index.php">( back to main menu )</a> &nbsp; &nbsp; &nbsp; &nbsp; <a href="specialevents.php">( back to special events )</a></p>
						<p>Official StillStream Time: <?=officialStillStreamTime()?></p>

						<?
							if (isDefined($msg))
							{
								?><p align="center"><font color="#ff0000"><?=trim($msg)?></font></p><?
							}
						?>
						<form action="specialevents-edit-process.php" method="post">
							<input type="hidden" name="eventid" value="<?=$event->id?>">
							<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
								<tr>
									<td align="right">UTC Date of Event (YYYY-MM-DD format):</td>
									<td align="left"><input type="text" name="eventdate" value="<?=$event->eventdate?>"> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
								</tr>
								<tr>
									<td align="right">UTC Time Event Starts (HH:MM:SS format):</td>
									<td align="left"><input type="text" name="eventtime" value="<?=$event->starttime?>"> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
								</tr>
								<tr>
									<td align="right">Event is "ultraspecial":</td>
									<td align="left">
										<select name="ultraspecial" size="1">
											<?
												showOptionTag('yes', 'Yes', $event->ultra_special);
												showOptionTag('no', 'No', $event->ultra_special);
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right">Event Title For RSS Feed (No HTML allowed):</td>
									<td align="left"><input type="text" name="eventtitle" value="<?=$event->title?>" size="50"></td>
								</tr>
								<tr>
									<td align="right">Event Description (NO HTML):</td>
									<td align="left"><textarea name="eventinfo" cols="60" rows="10"><?=$event->info?></textarea></td>
								</tr>
								<tr>
									<td colspan="2" align="center"><input type="submit" name="submit" value=" Update Special Event "></td>
								</tr>
							</table>
						</form>
					<?
				}
				else
				{
					?>
						<p>Sorry, could not locate that event.</p>
					<?
				}
			}
			else
			{
				?>
					<p>Sorry, you must specify the special event id.</p>
				<?
			}
		?>
	</body>
</html>

