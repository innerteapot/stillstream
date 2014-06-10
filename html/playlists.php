<?
	include('common/common.inc.php');
	showHeader($db, PG_PLAYLISTS, -1, false, null, null, $accessible);
	
	// figure out what month to show data for
	if (!isDefined($year))
	{
		$year = getCurrentYear();
	}
	if (!isDefined($month))
	{
		$month = getCurrentMonth();
	}
	
	// get all the shows for that year
	$instances = getAllProgramInstancesForMonthAndYear($db, $month, $year);
	
	// are we looking at one show in particular
	$currentinstance = NULL;
	$currentprogram = NULL;
	$currenttracks = NULL;
	if (isDefined($programinstanceid))
	{
		$currentinstance = getProgramInstance($db, $programinstanceid);
		if ($currentinstance)
		{
			$currentprogram = getProgram($db, $currentinstance->program_id);
			if ($currentprogram)
			{
				$currenttracks = getAllProgramInstanceTracksForInstance($db, $currentinstance->id);
				if (!$currenttracks)
				{
					$currentinstance = NULL;
					$currentprogram = NULL;
					$currenttracks = NULL;
				}
			}
			else
			{
				$currentinstance = NULL;
				$currentprogram = NULL;
				$currenttracks = NULL;
			}
		}
		else
		{
			$currentinstance = NULL;
			$currentprogram = NULL;
			$currenttracks = NULL;
		}
	}
?>

<h1><a title="Playlist RSS Feed" href="rss/playlist.xml"><img src="images/rss.png" width="14" height="14" border="0" style="border: 0px; margin-right: 7px;"></a>Playlists From Previous Shows</h1>

<p><a title="Playlist Search" href="search.php">Search For Music Plays</a></p>

<table width="99%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="top">
			<?
				$extraparms = '';
				if ($currentinstance != NULL)
				{
					$extraparms = 'programinstanceid=' . $currentinstance->id;
				}

				$cal = new VisualCalendar($month, $year, 'playlists.php', 'month', 'year', $extraparms);
				if (count($instances) > 0)
				{
					reset($instances);
					while (list($k, $v) = each($instances))
					{
						$dayofmonth = parseDateValue(dateTimeToDate($v->starttime), DATE_FIELD_DAY);
						$program = getProgram($db, $v->program_id);
						if ($program)
						{
							$url = 'playlists.php?month=' . $month . '&year=' . $year . '&programinstanceid='. $v->instanceid;
							$cal->addLinkToDay($dayofmonth, $url, $program->name);
						}
					}
				}

				$cal->showHTML();
			?>
		</td>
		<?
			if (($currentinstance != NULL) && ($currentprogram != NULL) && ($currenttracks != NULL))
			{
				?>
					<td width="25" align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">
						<h2><?=$currentprogram->name?></h2>
						<h3><?=formatDateTimeValue($currentinstance->starttime, "%A, %B %e, %Y")?></h3>
						<table border="1" cellpadding="4" cellspacing="0" align="center">
							<?
								reset($currenttracks);
								$counter = 0;
								while (list($k, $v) = each($currenttracks))
								{
									++$counter;

									?><tr><?
									
									// resolve all the details about this track
									$o = resolveAllTrackDetails($db, cleanArtistNameString($v->artist), $v->album, $v->song, $v->catnum, $v->year, $v->tracknum, $v->label, $v->dateplayed);
									$o->releasename = stripslashes($o->releasename);
									$o->artistname = stripslashes($o->artistname);
									$o->labelname = stripslashes($o->labelname);
									if (property_exists($o, "listing"))
									{
										$o->listing = stripslashes($o->listing);
									}
									else
									{
										$o->listing = null;
									}
									$o->trackname = stripslashes($o->trackname);
									$dp = strftime("%I:%M:%S %p", dateTimeToUnixTimestamp($o->dateplayed));
									$dl = $o->artistname . ' - ' . $o->trackname . ' - ' . $o->releasename . ' (' . $o->labelname . '/' . $o->catnum . '/' . $o->year . ')';
									
									if (isset($o->artisturl) && (strlen($o->artisturl) > 0))
									{
										?>
											<td align="left" valign="top">
												<a title="<?=$o->artistname?> - <?=$o->trackname?>" href="<?=$o->artisturl?>" target="_blank"><?=$counter?>. <?=$o->artistname?> - <?=$o->trackname?></a>
											</td>
										<?
									}
									else
									{
										?><td align="left" valign="top" bgcolor="#dddddd"><?=$counter?>. <?=$o->artistname?> - <?=$o->trackname?></td><?
									}
									
									?></tr><?
								}
							?>
						</table>
					</td>
				<?
			}
		?>
	</tr>
</table>
<br />
<?
	showFooter($db, PG_PLAYLISTS, $accessible);
?>
