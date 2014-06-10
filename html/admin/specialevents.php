<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		$events = getAllSpecialEvents($db);
	?>
	<head></head>
	<body>
		<h1>Special Events</h1>
		<p><a href="index.php">( back to main menu )</a></p>
		<p>Official StillStream Time: <?=officialStillStreamTime()?></p>

		<?
			if (isDefined($msg))
			{
				?>
					<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
						<tr>
							<td align="center">
								<b><?=urldecode($msg)?></b></td>
						</tr>
					</table>
					<br />
				<?
			}
		?>

		<p align="center">[<a href="specialevents-add.php">Add A New Special Event</a>]</p>
		<table width="830" cellspacing="0" cellpadding="5" border="0" align="center">
			<tr>
				<th width="80">&nbsp;</th>
				<th width="100">Event Date</th>
				<th width="150">Start Time</th>
				<th width="80">Ultra Special</th>
				<th width="420">Event</th>
			</tr>

			<?
				reset($events);
				while (list($k, $e) = each($events))
				{
					?>
						<tr>
							<td align="center" valign="top">
								<a href="specialevents-edit.php?id=<?=$e->id?>">Edit</a>&nbsp;
								<a href="specialevents-delete-process.php?id=<?=$e->id?>"
									 onclick="return confirm('Are you sure you want to delete this record?');">Delete</a></td>
							<td align="center" valign="top"><?=$e->eventdate?></td>
							<td align="center" valign="top"><?=$e->starttime?> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
							<td align="center" valign="top"><?=$e->ultra_special?></td>
							<td align="left" valign="top"><?=trim(nl2br($e->info))?></td>
						</tr>
					<?
				}
			?>
		</table>
	</body>
</html>

