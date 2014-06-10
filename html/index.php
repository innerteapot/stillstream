<?
	// uncomment these to force redirection to a special index page
	//header("Location: index_special.php");
	//die();

	define("MAX_SPECIAL_EVENTS_ON_HOMEPAGE", 3);
	include('common/common.inc.php');

	$refreshperiod = 60;
	if ($accessible)
	{
		$refreshperiod = -1;
	}

	showHeader($db, PG_HOME, $refreshperiod, false, null, null, $accessible);

	$albumfeature = getMostRecentAlbumFeature($db);
	$artistfeature = getMostRecentArtistFeature($db);
	$labelfeature = getMostRecentLabelFeature($db);
	$inlinefeature = getInlineFeature($db);

	$weeklysched = buildWeeklySchedule($db);
	$specialsched = getAllCurrentSpecialEvents($db, 60);
	$dayofweek = getCurrentDayOfWeek();
	// to test other days of week, override this variable with the value you want
	// $dayofweek = 'sun';

	function dayKeyToDayName($k)
	{
		switch($k)
		{
			case 'sun':
				return 'Sunday';
			case 'mon':
				return 'Monday';
			case 'tue':
				return 'Tuesday';
			case 'wed':
				return 'Wednesday';
			case 'thu':
				return 'Thursday';
			case 'fri':
				return 'Friday';
			case 'sat':
				return 'Saturday';
		}
		return 'Unknown';
	}

	function showArtistsBlurb()
	{
		?>
			<div class="today_on_stillstream">
				<h2><a title="Artists Listing" href="artists.php">Browse Our Artists</a></h2>
				<a title="Artists Listing" href="artists.php"><img src="images/artists.jpg" border="1"></a>
				<p>
					Looking for the home page for a particular ambient artist? Odds are our
					<a title="Artists Listing" href="artists.php">artists</a> page has a link to who you're
					looking for.
				</p>
			</div>
		<?
	}

	function showListenerStatsBlurb()
	{
		?>
			<div class="today_on_stillstream">
				<h2><a title="Listener Statistics" href="listenerstats.php">View Listenership</a></h2>
				<a title="Listener Statistics" href="listenerstats.php"><img src="images/listenerstats.jpg" border="0"></a>
				<p>
					StillStream has listeners from all around the world. Visit our
					<a title="Listener Statistics" href="listenerstats.php">listenership</a> page
					to see what countries are listening right now.
				</p>
			</div>
		<?
	}

	function showSearchBlurb()
	{
		?>
			<div class="today_on_stillstream">
				<h2><a title="Search Playlist" href="search.php">Search Our Playlist</a></h2>
				<a title="Search Playlist" href="search.php"><img src="images/search.jpg" border="0"></a>
				<p>
					Interested in seeing the last time a particular artist was played
					on StillStream? Have a look at our
					<a title="Search Playlist" href="search.php">search</a> page, which allows you to search our massive
					playlist both by the name and by date range.
				</p>
			</div>
		<?
	}

	function showChartsBlurb()
	{
		?>
			<div class="today_on_stillstream">
				<h2><a title="Browse Charts" href="charts.php">Browse The Charts</a></h2>
				<a title="Browse Charts" href="charts.php"><img src="images/charts.jpg" border="0"></a>
				<p>
					Curious about the most popular music on StillStream? Have a look at our
					<a title="Browse Charts" href="charts.php">charts</a>, which show which artists, albums,
					collections, and tracks have been played the most often in the past week
					month, quarter, or year.
				</p>
			</div>
		<?
	}

	function showArchivesBlurb()
	{
		?>
			<div class="today_on_stillstream">
				<h2><a title="Archives" href="archives.php">Visit The Archives</a></h2>
				<a title="Archives" href="archives.php"><img src="images/archives.jpg" border="0"></a>
				<p>
					We invite you to drop by our <a title="Archives" href="archives.php">archives</a>,
					which contain a variety of live performances from
					our various broadcasts.
				</p>
			</div>
		<?
	}

	function showThisWeekScheduleBlurb($weeklysched)
	{
		?>
			<div class="today_on_stillstream">
				<h2><a title="Program and Special Events Schedule" href="schedule.php">This Week on StillStream</a></h2>
				<table width="99%" border="0" cellpadding="0" cellspacing="2" align="center">
				<?
					reset($weeklysched);
					while (list($k, $e) = each($weeklysched))
					{
						if (count($e) > 0)
						{
							?>
								<tr>
									<td align="left" valign="top" class="thisweek">
										<?=dayKeyToDayName($k)?>
									</td>
									<td align="left" valign="top" class="thisweek">
										&nbsp;
									</td>
									<td align="left" valign="top" class="thisweek">
										<?
											reset($e);
											while (list($k2, $e2) = each($e))
											{
												$timedisplay = strftime("%I:%M %p", timeToUnixTimestamp($e2->starttime, 10, 22, 1999));
												$shortname = $e2->name;
												if (strlen($shortname) > 18)
												{
													$shortname = substr($shortname, 0, 14) . " ...";
												}
												?>
													<?=$timedisplay?> - <a title="<?=$e2->name?>" href="schedule.php"><?=$shortname?></a><br />
												<?
											}
										?>
									</td>
								</tr>
							<?
						}
					}
				?>
				</table>
				<br />
				<p>(All times StillStream Official Time <?=diffOfficialStillStreamTimeFromGMT()?>)</p>
			</div>
		<?
	}
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<!-- begin left bar -->
		<td valign="top" align="left" width="280">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td align="center">
						<?
							$specialcount = count($specialsched);
							if ($specialcount > 0)
							{
								?>
									<!-- begin special events -->
									<div class="today_on_stillstream">
										<h2><a title="Playlist RSS Feed" href="rss/playlist.xml"><img src="images/rss.png" border="0" width="14" height="14"
											style="float:none; margin-right: 5px; border: 0px; vertical-align: middle;"></a><a title="Program and Special Events Schedule"
											href="schedule.php">Special Events</a></h2>
										<?
											reset($specialsched);
											$counter = 0;
											while (list($k, $v) = each($specialsched))
											{
												++$counter;
												$datedisplay = strftime("%b %d, %Y", dateToUnixTimestamp($v->eventdate));
												$timedisplay = strftime("%I:%M %p", timeToUnixTimestamp($v->starttime, 10, 22, 1999));
												?>
													<p>
														<div>
															<a title="Program and Special Events Schedule" href="schedule.php"><b><?=trim($datedisplay)?> <?=trim($timedisplay)?> <?=officialStillStreamTimeZone()?>
																(<?=diffOfficialStillStreamTimeFromGMT()?>)</b></a></div>
														<div><?=trim($v->info)?></div>
													</p>
												<?
												if ($counter >= MAX_SPECIAL_EVENTS_ON_HOMEPAGE)
												{
													break;
												}
												else
												{
													?><br /><?
												}
											}
										?>
									</div>
								<?
							}

							$dowevents = $weeklysched[$dayofweek];
							while (list($k, $event) = each($dowevents))
							{
								$blogurl = NULL;
								$hosturl = NULL;
								$program = getProgram($db, $event->program_id);
								if ($program)
								{
									$host = getHost($db, $program->host_id);
									if ($host)
									{
										$blogurl = $host->blogurl;
										$hosturl = $host->hosturl;
									}
								}

								$theurl = (isDefined($event->url) ? $event->url : 'programs.php');
								?>
									<!-- end special events -->
									<div class="today_on_stillstream">
									<h2>On Today: <?showCurrentStatsLinkBold(stripslashes($event->eventname), $theurl, stripslashes($event->eventname), '_blank')?></h2>
										<?
											if ($event->thumbnail_image)
											{
												showCurrentStatsLink('<img class="solidborder" border="1" src="images/shows/' . $event->thumbnail_image . '">', $theurl, stripslashes($event->eventname), '_blank');
											}
										?>
										<p>
											<?
												if (isDefined($blogurl))
												{
													?><b>Host:</b> <a title="<?=$event->host?>" href="<?=$blogurl?>" target="_blank"><?=$event->host?></a><br /><?
												}
												else if (isDefined($hosturl))
												{
													?><b>Host:</b> <a title="<?=$event->host?>" href="<?=$hosturl?>" target="_blank"><?=$event->host?></a><br /><?
												}
												else
												{
													?><b>Host:</b> <a title="Hosts Listing" href="hosts.php" target="_blank"><?=$event->host?></a><br /><?
												}
											?>

											<b>Starts:</b> <?=$event->starttime?><br />
											<b>Lasts:</b> <?=$event->duration?> hours
										</p>
										<p>&nbsp;</p>
										<p><?=trim($event->desc)?></p>
									</div>
								<?
							}
						?>
						<?
							/*
								<div class="today_on_stillstream">
									<h2>StillStream All Ambient</h2>
									<img src="images/shows/allambient.jpg" border="1">
									<p>
										<b>Host:</b> <a title="Hosts Listing" href="hosts.php">Wally</a><br />
										<b>Starts:</b> 24x7<br />
										<b>Lasts:</b> 24x7
									</p>
									<p>&nbsp;</p>
									<p>
										We invite you to listen to our 24x7 stream, which features a broad selection of tasty tracks from one of the largest
										libraries of independent ambient music on the planet.
									</p>
								</div>
							*/
						?>
						<?
							if ($specialcount < 1)
							{
								if (count($dowevents) < 1)
								{
									showThisWeekScheduleBlurb($weeklysched);
									showArchivesBlurb();
									showArtistsBlurb();
									showChartsBlurb();
									showSearchBlurb();
								}
								else if (count($dowevents) < 2)
								{
									showArchivesBlurb();
									showSearchBlurb();
									showArtistsBlurb();
									showChartsBlurb();
								}
								else if (count($dowevents) < 3)
								{
									showListenerStatsBlurb();
									showSearchBlurb();
									showArtistsBlurb();
								}
								else
								{
									showSearchBlurb();
								}
							}
							else if ($specialcount < 2)
							{
								if (count($dowevents) < 1)
								{
									showThisWeekScheduleBlurb($weeklysched);
									showArtistsBlurb();
								}
								else if (count($dowevents) < 2)
								{
									showChartsBlurb();
									showListenerStatsBlurb();
								}
								else if (count($dowevents) < 3)
								{
									showListenerStatsBlurb();
								}
								else
								{
									// do nothing
								}
							}
							else
							{
								if (count($dowevents) < 1)
								{
									showThisWeekScheduleBlurb($weeklysched);
									// showListenerStatsBlurb();
								}
								else if (count($dowevents) < 2)
								{
									showSearchBlurb();
								}
								else if (count($dowevents) < 3)
								{
									// do nothing
								}
								else
								{
									// do nothing
								}
							}
						?>
					</td>
				</tr>
			</table>
		</td>
		<!-- end left bar -->

		<!-- begin content area -->
		<td valign="top" align="left">
			<?
				if ($inlinefeature)
				{
					?>
						<div class="inline_feature_story">
							<h2><a title="<?=$inlinefeature->title?>" href="<?=$inlinefeature->url?>" target="_blank"><img src="images/inlinefeatures/<?=$inlinefeature->thumbnail_image?>" 
								border="0"/></a><a title="<?=$inlinefeature->title?>" href="<?=$inlinefeature->url?>" target="_blank"><?=$inlinefeature->title?></a></h2>
							<p><?=$inlinefeature->feature?></p>
						</div>
						<br />
					<?
				}
			?>
			<h1>Welcome to StillStream</h1>
			<p>
				We are a <a title="About StillStream" href="about.php">non-commercial ambient radio station</a> that is on the air
				24 hours a day, 365 days a year. In addition to our automated radio feed, we
				also focus on <a title="Program and Special Events Schedule" href="schedule.php">live radio programs</a>,
				with <a title="Hosts Listing" href="hosts.php">real live hosts</a> who share their passion for deep
				music with you.
			</p>
			<?
				if (!$inlinefeature)
				{
					?>
						<p>
							We subscribe to the
							<a title="Wikipedia Ambient Music Article" href="http://en.wikipedia.org/wiki/Ambient_music" target="_blank">Wikipedia definition</a>
							of ambient music, and love all forms of it, not just one subgenre or another.
							This means we play all sorts of music, such as:
						</p>
						<p>
							- Soothing light ambient<br />
							- Ambient mood music<br />
							- Impenetrable dark ambient<br />
							- Berlin-school electronic ambient<br />
							- Challenging experimental ambient<br />
							- Futuristic ambient noise<br />
							- Powerful tribal ambient<br />
							- Cinematic symphonic ambient<br />
							- Expansive space music<br />
							- Textural abstract ambient<br />
							- Exotic world ambient<br />
							- Uplifiting new age ambient<br />
							- And much more
						</p>
					<?
				}
			?>
			<p>
				Our stream is very diverse, and is suitable for many types of listening.
				We exist solely to promote
				interest in ambient music and to give ambient artists a community.
				Everything we do we make available for no cost and with no commercials.
			</p>
			<p>
				StillStream is free for everyone to enjoy, completely anonymously, as often as desired, so why
				not tune in today?
			</p>
		</td>
		<!-- end content area -->
		<!-- begin right bar -->
		<?
			// add the section stuff
			$albumfeature->sectionurl = 'features.php?ft=release';
			$albumfeature->sectionheader = 'Featured Release';
			$artistfeature->sectionurl = 'features.php?ft=artist';
			$artistfeature->sectionheader = 'Featured Artist';
			$labelfeature->sectionurl = 'features.php?ft=label';
			$labelfeature->sectionheader = 'Featured Label';

			// save the base titles
			$albumfeature->basetitle = $albumfeature->title;
			$artistfeature->basetitle = $artistfeature->title;
			$labelfeature->basetitle = $labelfeature->title;

			// italicize the album name
			$albumfeature->title = '<i>' . $albumfeature->title . '</i>';

			// juggle the order
			$randnum = rand(0, 3000);
			if ($randnum < 1000)
			{
				$feature1 = $albumfeature;
				$feature2 = $artistfeature;
				$feature3 = $labelfeature;
			}
			else if ($randnum < 2000)
			{
				$feature2 = $albumfeature;
				$feature3 = $artistfeature;
				$feature1 = $labelfeature;
			}
			else
			{
				$feature3 = $albumfeature;
				$feature1 = $artistfeature;
				$feature2 = $labelfeature;
			}
		?>
		<td valign="top" align="left" width="280">
			<div class="feature_story">
				<h2><a title="Features RSS Feed" href="rss/features.xml"><img src="images/rss.png" border="0" width="14" height="14" style="border: 0px; margin-right:3px; vertical-align: middle; float:none;"></a>
				<a title="<?=$feature1->sectionheader?>" href="<?=$feature1->sectionurl?>"><?=$feature1->sectionheader?></a>: <a title="<?=trim($feature1->basetitle)?>" href="<?=trim($feature1->featureurl)?>" target="_blank"><?=trim($feature1->title)?></a></h2>
				<a title="<?=trim($feature1->basetitle)?>" href="<?=trim($feature1->featureurl)?>" target="_blank"><img src="images/features/<?=trim($feature1->thumbnail_image)?>" border="0"/></a>
				<p><b><?=trim($feature1->byline)?></b></p>
				<p>&nbsp;</p>
				<p><?=trim($feature1->content)?></p>
			</div>
			<div class="feature_story">
				<h2><a title="Features RSS Feed" href="rss/features.xml"><img src="images/rss.png" border="0" width="14" height="14" style="border: 0px; margin-right:3px; vertical-align: middle; float:none;"></a>
				<a title="<?=$feature2->sectionheader?>" href="<?=$feature2->sectionurl?>"><?=$feature2->sectionheader?></a>: <a title="<?=trim($feature2->basetitle)?>" href="<?=trim($feature2->featureurl)?>" target="_blank"><?=trim($feature2->title)?></a></h2>
				<a title="<?=trim($feature2->basetitle)?>" href="<?=trim($feature2->featureurl)?>" target="_blank"><img src="images/features/<?=trim($feature2->thumbnail_image)?>" border="0"/></a>
				<p><b><?=trim($feature2->byline)?></b></p>
				<p>&nbsp;</p>
				<p><?=trim($feature2->content)?></p>
			</div>
			<div class="feature_story">
				<h2><a title="Features RSS Feed" href="rss/features.xml"><img src="images/rss.png" border="0" width="14" height="14" style="border: 0px; margin-right:3px; vertical-align: middle; float:none;"></a>
				<a title="<?=$feature3->sectionheader?>" href="<?=$feature3->sectionurl?>"><?=$feature3->sectionheader?></a>: <a title="<?=trim($feature3->basetitle)?>" href="<?=trim($feature3->featureurl)?>" target="_blank"><?=trim($feature3->title)?></a></h2>
				<a title="<?=trim($feature2->basetitle)?>" href="<?=trim($feature3->featureurl)?>" target="_blank"><img src="images/features/<?=trim($feature3->thumbnail_image)?>" border="0"/></a>
				<p><b><?=trim($feature3->byline)?></b></p>
				<p>&nbsp;</p>
				<p><?=trim($feature3->content)?></p>
			</div>
		</td>
		<!-- end right bar -->
	</tr>
</table>

<?
	showFooter($db, PG_HOME, $accessible);
?>
