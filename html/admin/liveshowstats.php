<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	define("NUMBER_BARS_PER_GRAPH", 23);
	define("SECONDS_BETWEEN_REFRESH", 60);

	$asoftime = null;
	$listeners = getListeners($db, NUMBER_BARS_PER_GRAPH);

	$currlisteners = $listeners[0]->currlisteners;
	
	$listenerlocations = getListenerLocations($db);

	$countrycount = getListenerCountryCount($db);
?>
<html>
	<head>
		<meta http-equiv="refresh" content="<?=SECONDS_BETWEEN_REFRESH?>">
	</head>
	<body>
		<table width="800" border="0" cellpadding="0" cellspacing="15" align="center">
			<tr>
				<td align="center" valign="top">

					<?
						$gvalues1 = array();
						$glabels1 = array();
						reset($listeners);
						$peaklisteners = -1;
						$peaklistenerswhen = '?';
						$troughlisteners = 999999;
						$troughlistenerswhen = '?';
						$count = 0;
						$asoftime = null;
						while (list($k, $v) = each($listeners))
						{
							// convert from ET to StillStream time
							$ts = dateTimeToUnixTimestamp($v->daterecorded);
							$ts = $ts - 3600;
							$v->daterecorded = makeMySQLDateTime($ts);
						
							$thetime = formatDateTimeValue($v->daterecorded, "%H:%M");
							if ($asoftime == null)
							{
								$asoftime = $thetime . ' ' . officialStillStreamTimeZone();
							}

							if ($v->currlisteners > $peaklisteners)
							{
								$peaklisteners = $v->currlisteners;
								$peaklistenerswhen = $thetime . ' ' . officialStillStreamTimeZone();
							}

							if ($v->currlisteners <= $troughlisteners)
							{
								$troughlisteners = $v->currlisteners;
								$troughlistenerswhen = $thetime . ' ' . officialStillStreamTimeZone();
							}

							++$count;
							if ($count <= NUMBER_BARS_PER_GRAPH)
							{
								array_push($gvalues1, $v->currlisteners);
								array_push($glabels1, $thetime);
							}
						}

						$currplay = getCurrentPlaylistEntry($db);
						$url = '';
						if (isDefined($currplay->albumurl))
						{
							$url = $currplay->albumurl;
						}
						else if (isDefined($currplay->artisturl))
						{
							$url = $currplay->artisturl;
						}
						else if (isDefined($currplay->labelurl))
						{
							$url = $currplay->labelurl;
						}

						$revlisteners = array_reverse($listeners);
						$prevlisteners = 0;
						$biggestjump = 0;
						$biggestjumpwhen = '?';
						$biggestdrop = 0;
						$biggestdropwhen = '?';
						$jumptime = null;
						$droptime = null;
						while (list($k, $v) = each($revlisteners))
						{
							if ($prevlisteners > 0)
							{
								$thetime = formatDateTimeValue($v->daterecorded, "%H:%M");
								if (($v->currlisteners - $prevlisteners) > $biggestjump)
								{
									$biggestjump = $v->currlisteners - $prevlisteners;
									$biggestjumpwhen = $thetime . ' ' . officialStillStreamTimeZone();
									$jumptime = $v->daterecorded;
								}
								if (($prevlisteners - $v->currlisteners) > $biggestdrop)
								{
									$biggestdrop = $prevlisteners - $v->currlisteners;
									$biggestdropwhen = $thetime . ' ' . officialStillStreamTimeZone();
									$droptime = $v->daterecorded;
								}
							}
							$prevlisteners = $v->currlisteners;
						}
					?>

					<h2>Current Status</h2>
					<p>Official StillStream Time: <?=officialStillStreamTime()?></p>
					<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
						<tr>
							<td align="right" valign="top">Current Show:</td>
							<td align="left" valign="top"><b><?=$currplay->show?></b></td>
							<td width="10">&nbsp;</td>
							<td align="right" valign="top">Current Track:</td>
							<td align="left" valign="top">
								<?
									if (strlen($url) > 0)
									{
										?><a href="<?=$url?>" target="_blank"><b><?=$currplay->artist_track?></b></a><?
									}
									else
									{
										?><b><?=$currplay->artist_track?></b><?
									}
								?>
							</td>
						</tr>
						<tr>
							<td align="right" valign="top">Current Listeners:</td>
							<td align="left" valign="top"><b><?=$currlisteners?></b></td>
							<td width="10">&nbsp;</td>
							<td align="right" valign="top">Current Distinct Countries:</td>
							<td align="left" valign="top"><b><?=$countrycount?></b></td>
						</tr>
						<tr>
							<td align="right" valign="top">Peak Listeners:</td>
							<td align="left" valign="top"><b><?=$peaklisteners?> (<?=$peaklistenerswhen?>)</b></td>
							<td width="10">&nbsp;</td>
							<td align="right" valign="top">Trough Listeners:</td>
							<td align="left" valign="top"><b><?=$troughlisteners?> (<?=$troughlistenerswhen?>)</b></td>
						</tr>
						<tr>
							<td align="right" valign="top">Biggest Jump:</td>
							<td align="left" valign="top"><b><?=$biggestjump?> (<?=$biggestjumpwhen?>)</b></td>
							<td width="10">&nbsp;</td>
							<td align="right" valign="top">Biggest Drop:</td>
							<td align="left" valign="top"><b><?=$biggestdrop?> (<?=$biggestdropwhen?>)</b></td>
						</tr>
					</table>

					<h3>Concurrent Listener Count - Past Two Hours (ET)</h3>
					<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
						<tr>
							<td align="center" width="100%">
								<?=renderBarGraph($gvalues1, $glabels1, '#f5f5f5')?>
							</td>
						</tr>
					</table>

					<h3>Current Distinct Listener Locations (Approximate)</h3>
					<table cellpadding="2" cellspacing="0" border="1" align="center">
						<tr>
							<th>City</th>
							<th>Country</th>
						</tr>
						<?
							while (list($k, $v) = each($listenerlocations))
							{
								$flagurl = null;
								if (($v->country_abbrev != '') && ($v->country_abbrev != 'XX'))
								{
									$flagurl = '../images/flags/' . strtolower($v->country_abbrev) . '.png';
								}

								?>
									<tr>
										<td align="left"><?=htmlentities($v->city_name)?></td>
										<td align="left">
											<?
												if ($flagurl == null)
												{
													?><?=htmlentities($v->country_name)?><?
												}
												else
												{
													?><img src="<?=$flagurl?>" border="0"> <?=htmlentities($v->country_name)?><?
												}
											?>
										</td>
									</tr>
								<?
							}
						?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

