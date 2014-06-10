<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');

		function makeListenerEntry($nextli)
		{
			$rc = new stdClass();
			$rc->entry_type = "li";
			$rc->daterecorded = $nextli->daterecorded;
			$rc->currlisteners = $nextli->currlisteners;
			return $rc;
		}

		function makePlaylistEntry($nextpl)
		{
			$rc = new stdClass();
			$rc->entry_type = "pl";
			$rc->dateplayed = $nextpl->dateplayed;
			$rc->releasename = $nextpl->releasename;
			$rc->artistname = $nextpl->artistname;
			$rc->labelname = $nextpl->labelname;
			$rc->trackname = $nextpl->trackname;
			$rc->artistid = $nextpl->artistid;
			$rc->releaseid = $nextpl->releaseid;
			$rc->trackid = $nextpl->trackid;
			$rc->release_excluded = $nextpl->release_excluded;
			$rc->track_excluded = $nextpl->track_excluded;
			return $rc;
		}

		function mergePlaylistAndListeners($pl, $li)
		{
			$rc = array();
			$nextpl = array_shift($pl);
			$nextli = array_shift($li);
			while (true)
			{
				// are we done
				if ($nextpl == null && $nextli == null)
				{
					return $rc;
				}
				else if ($nextpl == null && $nextli != null)
				{
					$rc[] = makeListenerEntry($nextli);
					$nextli = array_shift($li);					
				}
				else if ($nextpl != null && $nextli == null)
				{
					$rc[] = makePlaylistEntry($nextpl);
					$nextpl = array_shift($pl);
				}
				else
				{
					$pldt = dateTimeToUnixTimestamp($nextpl->dateplayed);
					$lidt = dateTimeToUnixTimestamp($nextli->daterecorded);
					if ($pldt < $lidt)
					{	
						$rc[] = makeListenerEntry($nextli);
						$nextli = array_shift($li);											
					}
					else if ($pldt > $lidt)
					{
						$rc[] = makePlaylistEntry($nextpl);
						$nextpl = array_shift($pl);
					}
					else
					{
						$rc[] = makeListenerEntry($nextli);
						$nextli = array_shift($li);											
						$rc[] = makePlaylistEntry($nextpl);
						$nextpl = array_shift($pl);
					}				
				}
			}
		}

		function showReleaseExcludedLink($pl)
		{
			if ($pl->release_excluded)
			{
				?><a href="../../superuser-excluderelease-process.php?releaseid=<?=$pl->releaseid?>" target="_blank">Include Release</a><?
			}
			else
			{
				?><a href="../../superuser-excluderelease-process.php?releaseid=<?=$pl->releaseid?>" target="_blank">Exclude Release</a><?
			}
		}
		
		function showTrackExcludedLink($pl)
		{
			if ($pl->track_excluded)
			{
				?><a href="../../superuser-excludetrack-process.php?trackid=<?=$pl->trackid?>" target="_blank">Include Track</a><?
			}
			else
			{
				?><a href="../../superuser-excludetrack-process.php?trackid=<?=$pl->trackid?>" target="_blank">Exclude Track</a><?
			}
		}
		
		function displayResults($db, $startdate, $enddate, $negthreshold, $posthreshold)
		{
			// get playlist results and listener results, both sorted in descending date order
			$pl = getRecentPlaylistTracksWithDateRange($db, 65535, $startdate, $enddate);
			$li = getListenersWithDateRange($db, 65535, $startdate, $enddate);
			
			// merge them into one list
			$mrg = mergePlaylistAndListeners($pl, $li);

			// reverse the order of the list so we show oldest first
			$mrg = array_reverse($mrg);

			// now display the results
			?>
				<table cellpadding="1" cellspacing="1" border="0" align="center">
					<tr>
						<th align="center">Date/Time</th>
						<th align="center" width="15">&nbsp;</th>
						<th align="center">Event</th>
						<th align="center" width="5">&nbsp;</th>
						<th align="center">Action</th>
					</tr>
					<?
						$lastlisteners = null;
						$listenersatstart = null;
						$lastpl = null;
						reset($mrg);
						while (list($k, $v) = each($mrg))
						{
							if ($v->entry_type == 'li')
							{
								$lastlisteners = $v->currlisteners;
							}
							else
							{
								if ($lastpl != null)
								{
									if ($listenersatstart != null)
									{
										$negthreshold = $negthreshold * -1;
										if (($posthreshold > 0) && ($negthreshold < 0))
										{
											$netgain = $lastlisteners - $listenersatstart;
											$percentchange = ($netgain / $listenersatstart) * 100;

											$detail = $lastpl->artistname . ' - ' . $lastpl->releasename . ' - ' . $lastpl->trackname . " (" . $netgain . ")";
											$fontcolor = "#000000";
											if ($percentchange >= $posthreshold)
											{
												?>
													<tr>
														<td align="center"><?=$lastpl->dateplayed?></td>
														<td>&nbsp;</td>
														<td align="left"><font color="#00aa00"><?=$detail?></font></td>
														<td>&nbsp;</td>
														<td align="center">
															<?
																if ($lastpl->releaseid > 0 && $lastpl->trackid > 0)
																{
																	showReleaseExcludedLink($lastpl);
																	?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
																	showTrackExcludedLink($lastpl);
																}
															?>
														</td>
													</tr>
												<?
											}
											else if ($percentchange <= $negthreshold)
											{
												?>
													<tr>
														<td align="center"><?=$lastpl->dateplayed?></td>
														<td>&nbsp;</td>
														<td align="left"><font color="#ff0000"><?=$detail?></font></td>
														<td>&nbsp;</td>
														<td align="center">
															<?
																if ($lastpl->releaseid > 0 && $lastpl->trackid > 0)
																{
																	showReleaseExcludedLink($lastpl);
																	?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
																	showTrackExcludedLink($lastpl);
																}
															?>
														</td>
													</tr>
												<?
											}
										}
									}
								}
								$listenersatstart = $lastlisteners;
								$lastpl = $v;
							}
						}			
					?>
				</table>
			<?
		}
		
		$getresults = true;
		if (!isDefined($startdate))
		{
			$getresults = false;
			$startdate = makeMySQLDate();
		}
		if (!isDefined($enddate))
		{
			$getresults = false;
			$enddate = makeMySQLDate();
		}
		if (!isDefined($negthreshold))
		{
			$negthreshold = 10;
		}
		if (!isDefined($posthreshold))
		{
			$posthreshold = 100;
		}
	?>
	<head></head>
	<body>
		<h1>Playlist Stats Report</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="playlist.stats.php" method="POST">
			<table cellpadding="2" cellspacing="0" border="0" align="center">
				<tr>
					<td>Start Date (YYYY-MM-DD):</td>
					<td><input type="text" name="startdate" value="<?=$startdate?>" size="40"></td>
				</tr>
				<tr>
					<td>End Date (YYYY-MM-DD):</td>
					<td><input type="text" name="enddate" value="<?=$enddate?>" size="40"></td>
				</tr>
				<tr>
					<td>Negative Threshold (%):</td>
					<td><input type="text" name="negthreshold" value="<?=$negthreshold?>" size="40"></td>
				</tr>
				<tr>
					<td>Positive Threshold (%):</td>
					<td><input type="text" name="posthreshold" value="<?=$posthreshold?>" size="40"></td>
				</tr>
			</table>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
		</form>
		<?
			if ($getresults)
			{
				?><hr size="1"><?
				displayResults($db, $startdate, $enddate, $negthreshold, $posthreshold);
			}
		?>
	</body>
</html>

