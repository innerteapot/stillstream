<?
	include('common/common.inc.php');
	showHeader($db, PG_SEARCH, -1, false, null, null, $accessible);

	define("ROWS_PER_PAGE", 100);
	
	$msg1 = '';
	$msg2 = '';

	$shownextlink = false;
	$showprevlink = false;
	$matches = array();
	$matchcount = 0;

	if (isDefined($q))
	{
		$startrow = 0;
		if (isDefined($r))
		{
			$startrow = $r * ROWS_PER_PAGE;
		}

		$matches = textSearchPlaylist($db, $q, $startrow, $startrow + ROWS_PER_PAGE + 1);
		$matchcount = count($matches);

		if ($startrow > 0)
		{
			$showprevlink = true;
		}
		if ($matchcount > ROWS_PER_PAGE)
		{
			$shownextlink = true;
		}
	}
	else if (isDefined($d1) && isDefined($d2))
	{
		if (isValidDateTimeValue($d1) && isValidDateTimeValue($d2))
		{
			$startrow = 0;
			if (isDefined($r))
			{
				$startrow = $r * ROWS_PER_PAGE;
			}
	
			$matches = dateSearchPlaylist($db, $d1, $d2, $startrow, $startrow + ROWS_PER_PAGE + 1);
			$matchcount = count($matches);
	
			if ($startrow > 0)
			{
				$showprevlink = true;
			}
			if ($matchcount > ROWS_PER_PAGE)
			{
				$shownextlink = true;
			}
		}
		else
		{
			$msg2 = 'Invalid date format for start or end date; please try again.';
		}
	}
?>

<h1><a title="Playlist RSS Feed" href="rss/playlist.xml"><img src="images/rss.png" width="14" height="14" border="0" style="border: 0px; margin-right: 7px;"></a>Search For Music Plays</h1>
<br />
<table width="99%" border="0" cellpadding="6" cellspacing="2">
	<tr>
		<th>Text Search</th>
		<th>Date Search</th>
	</tr>
	<tr>
		<td width="50%" align="center" valign="middle" bgcolor="#dddddd">
			<form action="search.php" method="post">
					Artist, Track, Release, or Label Name:
					<input name="q" type="text" value="<?=$q?>" size="24" maxlen="128">
					<br />
					<br />
					<input name="submit" type="submit" value="Search">
			</form>
		</td>	
		<td width="50%" align="center" valign="middle" bgcolor="#dddddd">
			<?
				if (isDefined($msg2))
				{
					?><p align="center"><font color="red"><?=$msg2?></font></p><?
				}
			?>
			<form action="search.php" method="post">
				<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td align="right" bgcolor="#dddddd">
							Start Date (YYYY-MM-DD HH:MM:SS):
						</td>
						<td align="left" bgcolor="#dddddd">
							<input name="d1" type="text" value="<?=$d1?>" size="20" maxlen="128"> <?=officialStillStreamTimeZone()?>
						</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#dddddd">
							End Date (YYYY-MM-DD HH:MM:SS):
						</td>
						<td align="left" bgcolor="#dddddd">
							<input name="d2" type="text" value="<?=$d2?>" size="20" maxlen="128"> <?=officialStillStreamTimeZone()?>
						</td>
					</tr>
				</table>
				<br />
				<input name="submit" type="submit" value="Search">
			</form>
		</td>
	</tr>
</table>
<?
	if (isDefined($matches) && ($matchcount > 0))
	{
		?>
			<?
				if ($shownextlink || $showprevlink)
				{
					?>
						<table width="99%" align="center" cellspacing="0" cellpadding="2" border="0">
							<tr>
								<td align="left" valign="top">
									<?
										if ($showprevlink)
										{
											if (isDefined($r) && ($r > 0))
											{
												$therow = $r - 1;
												$url = 'search.php?q=' . $q . '&d1=' . $d1 . '&d2=' . $d2 . '&r=' . $therow;
											}
											else
											{
												$url = 'search.php?q=' . $q . '&d1=' . $d1 . '&d2=' . $d2 . '&r=0';
											}
											?><a title="Previous" href="<?=$url?>">&laquo; Previous</a><?
										}
										else
										{
											?>&laquo; Previous<?
										}
									?>
								</td>
								<td align="right" valign="top">
									<?
										if ($shownextlink)
										{
											if (isDefined($r))
											{
												$therow = $r + 1;
												$url = 'search.php?q=' . $q . '&d1=' . $d1 . '&d2=' . $d2 . '&r=' . $therow;
											}
											else
											{
												$url = 'search.php?q=' . $q . '&d1=' . $d1 . '&d2=' . $d2 . '&r=1';
											}
											?><a title="Next" href="<?=$url?>">Next &raquo;</a><?
										}
										else
										{
											?>Next &raquo;<?
										}
									?>
								</td>
							</tr>
						</table>
					<?
				}
			?>
			<table width="99%" align="center" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<th width="150">Played</th>
					<th width="5">&nbsp;</th>
					<th width="160">Artist</th>
					<th width="2">&nbsp;</th>
					<th width="170">Track</th>
					<th width="2">&nbsp;</th>
					<th width="170">Release</th>
					<th width="3">&nbsp;</th>
					<th width="75">Catalog</th>
					<th width="3">&nbsp;</th>
					<th width="110">Label</th>
				</tr>

				<?
					reset($matches);
					$counter = 0;
					while (list($k, $v) = each($matches))
					{
						++$counter;
						if ($counter > ROWS_PER_PAGE)
						{
							break;
						}

						$dp = strftime("%d-%b-%y %I:%M:%S %p", dateTimeToUnixTimestamp($v->dateplayed));


						?>
							<tr>
								<td align="left" valign="top"><?=$dp?> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
								<td>&nbsp;</td>

								<?
									if (isset($v->artisturl) && (strlen($v->artisturl) > 0))
									{
										?><td align="left" valign="top"><a title="<?=$v->artistname?>" href="<?=$v->artisturl?>" target="_blank"><?=$v->artistname?></a>&nbsp;</td><?
									}
									else
									{
										?><td align="left" valign="top"><?=$v->artistname?></td>&nbsp;<?
									}
								?>
								<td>&nbsp;</td>
								<?
									if (isset($v->releaseurl) && (strlen($v->releaseurl) > 0))
									{
										?>
											<td align="left" valign="top"><a title="<?=$v->trackname?>" href="<?=$v->releaseurl?>" target="_blank"><?=$v->trackname?></a>&nbsp;</td>
											<td>&nbsp;</td>
											<td align="left" valign="top"><a title="<?=$v->releasename?>" href="<?=$v->releaseurl?>" target="_blank"><?=$v->releasename?></a>&nbsp;</td>
										<?
									}
									else
									{
										?>
											<td align="left" valign="top"><?=$v->trackname?>&nbsp;</td>
											<td>&nbsp;</td>
											<td align="left" valign="top"><?=$v->releasename?>&nbsp;</td>
										<?
									}
								?>
								<td>&nbsp;</td>
								<td align="left" valign="top"><?=$v->catnum?></td>
								<td>&nbsp;</td>
								<?
									if (isset($v->labelurl) && (strlen($v->labelurl) > 0))
									{
										?><td align="left" valign="top"><a title="<?=$v->labelname?>" href="<?=$v->labelurl?>" target="_blank"><?=$v->labelname?></a></td><?
									}
									else
									{
										?><td align="left" valign="top"><?=$v->labelname?></td><?
									}
								?>
							</tr>
						<?
					}
				?>
			</table>
		<?
	}
	else
	{
		if (isDefined($q))
		{
			?><p align="center">(Sorry, no matches found).</p><?
		}
	}
?>
<?
	showFooter($db, PG_SEARCH, $accessible);
?>
