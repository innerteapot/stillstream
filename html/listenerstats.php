<?
	include('common/common.inc.php');
	showHeader($db, PG_LISTENERSTATS, -1, false, null, null, $accessible);

	$llocs = getListenerCountries($db);
	$glocs = getGeoIPCacheLocations($db);

	$numlisteners = number_format(getNumberCurrentListeners($db), 0);
	$numlistenersmonth = number_format(getGeoIPCacheCount($db), 0);

	?>
		<h1>Listenership</h1>

		<h2>Number of Listeners</h2>
		<p>
			<?=$numlisteners?> different people listening right now<br />
			<?=$numlistenersmonth?> different people in the past week
		</p>

		<h2>Countries Listening Right Now</h2>
		<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
			<tr>
				<?
					$counter = -1;
					$countriesshown = '';
					reset($llocs);
					while (list($k, $v) = each($llocs))
					{
						if (strlen($v->country_name) > 0)
						{
							if (strtolower($v->country_name) != '(unknown)')
							{
								if (strpos($countriesshown, $v->country_name) === false)
								{
									++$counter;
									if (($counter % 4) == 0)
									{
										if ($counter > 0)
										{
											?></tr><tr><?
										}
									}

									$flagurl = null;
									if (($v->country_abbrev != '') && ($v->country_abbrev != 'XX'))
									{
										$flagurl = 'images/flags/' . trim(strtolower($v->country_abbrev)) . '.png';
									}

									if ($flagurl == null)
									{
										?><td width="25%"><?=$v->country_name?></td><?
									}
									else
									{
										?><td width="25%"><img src="<?=$flagurl?>" border="0"> <?=$v->country_name?></td><?
									}

									$countriesshown = $countriesshown . '[' . $v->country_name . ']';
								}
							}
						}
					}
				?>
			</tr>
		</table>

		<h2>Countries Listening In The Past Week</h2>
		<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
			<tr>
				<?
					$counter = -1;
					$countriesshown = '';
					reset($llocs);
					while (list($k, $v) = each($glocs))
					{
						if (strlen($v->country_name) > 0)
						{
							if (strtolower($v->country_name) != '(unknown)')
							{
								if (strpos($countriesshown, $v->country_name) === false)
								{
									++$counter;
									if (($counter % 4) == 0)
									{
										if ($counter > 0)
										{
											?></tr><tr><?
										}
									}

									$flagurl = null;
									if (($v->country_abbrev != '') && ($v->country_abbrev != 'XX'))
									{
										$flagurl = 'images/flags/' . trim(strtolower($v->country_abbrev)) . '.png';
									}

									if ($flagurl == null)
									{
										?><td width="25%"><?=$v->country_name?></td><?
									}
									else
									{
										?><td width="25%"><img src="<?=$flagurl?>" border="0"> <?=$v->country_name?></td><?
									}

									$countriesshown = $countriesshown . '[' . $v->country_name . ']';
								}
							}
						}
					}
				?>
			</tr>
		</table>
		<br />
		<table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td align="center" valign="middle" class="fineprint">
					Please note that results are approximate. We cannot and do not identify individual people other
					than by IP address,
					which is only a rough measure of individual listeners. Further,
					we employ geo IP lookup to determine location of listeners, which is also only
					approximate. Geo IP services courtesy of <a title="hostip.info" href="http://www.hostip.info/" target="_blank">hostip.info</a>.
				</td>
			</tr>
		</table>
	<?

	showFooter($db, PG_RECENTLYADDED, $accessible);
?>
