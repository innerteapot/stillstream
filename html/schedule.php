<?
	include('common/common.inc.php');

	showHeader($db, PG_SCHEDULE, -1, false, null, null, $accessible);

	// construct our array of weekdays and daily events
	$weeksched = buildWeeklySchedule($db, $tzl);
	$numweeklyrows = calculatenumweeklyrows($weeksched);
	
	if (!isDefined($lh))
	{
		$lh = 60;
	}
	
	// get all special events
	$specialsched = getAllCurrentSpecialEvents($db, $lh);

	function calculatenumweeklyrows($weeksched)
	{
		$rc = -1;
		reset($weeksched);						
		while (list($k, $v) = each($weeksched))
		{
			$rowcount = count($v);
			if ($rowcount > $rc)
			{
				$rc = $rowcount;
			}
		}
		return $rc;
	}

	function showweeklyevent($weeksched, $dayofweek, $rownum)
	{
		if (array_key_exists($dayofweek, $weeksched))
		{
			$dowevents = $weeksched[$dayofweek];
			$doweventslist = array_values($dowevents);
			$event = $doweventslist[$rownum];
			if ($event)
			{
				$timedisplay = strftime("%I:%M %p", timeToUnixTimestamp($event->starttime, 10, 22, 1999));
				if (strlen($event->url) > 0)
				{
					?>
						<div style="min-height: 8.5em;">
							<a title="<?=trim($event->eventname)?>" href="<?=trim($event->url)?>" target="_blank"><b><?=trim($event->eventname)?></b></a>
							with <?=trim($event->host)?><br />
							<?=trim($timedisplay)?> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)<br />
							<?
								if ($event->duration > 1)
								{
									?>Lasts <?=trim($event->duration)?> Hours<br /><?
								}
								else
								{
									?>Lasts <?=trim($event->duration)?> Hour<br /><?
								}
							?>
							<br />
							<br />
						</div>
					<?
				}
				else
				{
					?>
						<div style="min-height: 8.5em;">
							<b><?=trim($event->eventname)?></b>
							with <?=trim($event->host)?><br />
							<?=trim($timedisplay)?> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)<br />
							<?
								if ($event->duration > 1)
								{
									?>Lasts	<?=trim($event->duration)?> Hours<br /><?
								}
								else
								{
									?>Lasts <?=trim($event->duration)?> Hour<br /><?
								}
							?>
							<br />
							<br />
						</div>
					<?
				}
			}
			else
			{
				?>&nbsp;<?
			}
		}
	}
?>

<h1>Schedule</h1>

<h2><a title="Calendar RSS Feed" href="rss/calendar.xml"><img src="images/rss.png" width="14" height="14" border="0" style="border: 0px; margin-right: 7px;"></a>Upcoming Special Events</h2>
<p>
	<?
		if ($lh == 7)
		{
			?>Next Seven Days<?
		}
		else
		{
			?><a title="Show Schedule For Next Seven Days" href="schedule.php?lh=7">Next Seven Days</a><?
		}
		?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
		if ($lh == 14)
		{
			?>Next Fourteen Days<?
		}
		else
		{
			?><a title="Show Schedule For Next Fourteen Days" href="schedule.php?lh=14">Next Fourteen Days</a><?
		}
		?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
		if ($lh == 30)
		{
			?>Next Thirty Days<?
		}
		else
		{
			?><a title="Show Schedule For Next Thirty Days" href="schedule.php?lh=30">Next Thirty Days</a><?
		}
		?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
		if ($lh == 60)
		{
			?>Next Sixty Days<?
		}
		else
		{
			?><a title="Show Schedule For Next Sixty Days" href="schedule.php?lh=60">Next Sixty Days</a><?
		}
		?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
		if ($lh == 90)
		{
			?>Next Ninety Days<?
		}
		else
		{
			?><a title="Show Schedule For Next Ninety Days" href="schedule.php?lh=90">Next Ninety Days</a><?
		}
		?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
		if ($lh == 999999)
		{
			?>All Dates<?
		}
		else
		{
			?><a title="Show Entire Schedule" href="schedule.php?lh=999999">All Dates</a><?
		}
	?>
</p>
<?
	if (count($specialsched) > 0)
	{
		?>
			<table border="0" cellspacing="2" cellpadding="6" width="840" id="schedule" align="center">
				<tr>
					<th>Date / Time</th>
					<th>Event</th>
				</tr>
				<?
					reset($specialsched);						
					while (list($k, $v) = each($specialsched))
					{
						$datedisplay = strftime("%B %d, %Y", dateToUnixTimestamp($v->eventdate));
						$timedisplay = strftime("%I:%M %p", timeToUnixTimestamp($v->starttime, 10, 22, 1999));
						?>						
							<tr class="darker">
								<td width="260" valign="top" align="center" class="darker">
									<?=trim($datedisplay)?> <?=trim($timedisplay)?> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
								<td valign="top" align="left" class="darker"><?=trim($v->info)?></td>
							</tr>
						<?
					}
				?>
			</table>
			<p align="center">(All times StillStream Official Time <?=diffOfficialStillStreamTimeFromGMT()?>)</p>
			<p>&nbsp;</p>
		<?
	}
?>
<h2><a title="Calendar RSS Feed" href="rss/calendar.xml"><img src="images/rss.png" width="14" height="14" border="0" style="border: 0px; margin-right: 7px;"></a>Live Programs</h2>
<table border="0" cellspacing="2" cellpadding="5" width="100%" id="schedule">
	<tr>
		<th>Sunday</th>
		<th>Monday</th>
		<th>Tuesday</th>
		<th>Wednesday</th>
		<th>Thursday</th>
		<th>Friday</th>
		<th>Saturday</th>
	</tr>
	<?
		for ($i = 0; $i < $numweeklyrows; ++$i)
		{
			?>
				<tr>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'sun', $i)?></td>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'mon', $i)?></td>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'tue', $i)?></td>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'wed', $i)?></td>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'thu', $i)?></td>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'fri', $i)?></td>
					<td align="center" valign="top" class="darker" width="14%"><?showweeklyevent($weeksched, 'sat', $i)?></td>
				</tr>
			<?
		}
	?>
</table>
<p align="center">(All times StillStream Official Time <?=diffOfficialStillStreamTimeFromGMT()?>)</p>
<p>&nbsp;</p>

<p>
	IMPORTANT: note that in between live shows, we also offer <b><?=FEED_NAME?></b>, a tasty and always changing
	selection of outstanding ambient music from <a title="Artists Listing" href="artists.php">our favorite artists</a>.  StillStream is
	on the air 24x7.
</p>
<p>
	Be sure to check out our <a title="Age Appropriateness Policy" href="legal.php#ageappropriate">age appropriateness policy</a> if you are
	under the age of 18 or are a parent seeking information about our content.
</p>
<?
	showFooter($db, PG_SCHEDULE, $accessible);
?>
