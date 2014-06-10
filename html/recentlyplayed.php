<?
	define("MAX_NUMBER_PLAYLIST_ENTRIES", "60");
	include('common/common.inc.php');
	showHeader($db, PG_RECENTLYPLAYED, -1, false, null, null, $accessible);
?>

<h1><a title="Playlist RSS Feed" href="rss/playlist.xml"><img src="images/rss.png" border="0" width="14" height="14" style="border: 0px; margin-right: 7px;"></a>Recently Played</h1>

<p><a title="Playlist Search" href="search.php">Search For Music Plays</a></p>

<?
	$tracks = getRecentPlaylistTracks($db, MAX_NUMBER_PLAYLIST_ENTRIES);
	if (count($tracks) > 0)
	{
		?>
			<table width="100%" align="center" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<th width="160">&nbsp;</th>
					<th width="5">&nbsp;</th>
					<th>Artist</th>
					<th width="5">&nbsp;</th>
					<th>Track</th>
					<th width="5">&nbsp;</th>
					<th>Release</th>
					<th width="5">&nbsp;</th>
					<th>Label</th>
					<?
						if (superUserIsLoggedIn())
						{
							?>
								<th width="5">&nbsp;</th>
								<th>&nbsp;</th>
							<?
						}
					?>
				</tr>
		<?

		$lastlisting = '';
		reset($tracks);
		while (list($key, $track) = each($tracks))
		{
			$dp = strftime("%I:%M:%S %p", dateTimeToUnixTimestamp($track->dateplayed) - SECONDS_STILLSTREAM_OFFICIAL_TIME_IS_BEHIND_SERVER_TIME);
			if ($track->artist_track != $lastlisting)
			{
				$dl = $track->artistname . ' - ' . $track->trackname . ' - ' . $track->releasename . ' (' . $track->labelname . '/' . $track->catnum . '/' . $track->year . ')';
				?>
					<tr>
						<td align="left" valign="top"><?=$dp?> <?=officialStillStreamTimeZone()?> (<?=diffOfficialStillStreamTimeFromGMT()?>)</td>
						<td>&nbsp;</td>
						<?
							if (isset($track->artisturl) && (strlen($track->artisturl) > 0))
							{
								?><td align="left" valign="top"><a title="<?=$track->artistname?>" href="<?=$track->artisturl?>" target="_blank"><?=$track->artistname?></a></td><?
							}
							else
							{
								?><td align="left" valign="top"><?=$track->artistname?></td><?
							}
						?>
						<td>&nbsp;</td>
						<?
							if (isset($track->releaseurl) && (strlen($track->releaseurl) > 0))
							{
								?>
									<td align="left" valign="top"><a title="<?=$track->trackname?>" href="<?=$track->releaseurl?>" target="_blank"><?=$track->trackname?></a></td>
									<td>&nbsp;</td>
									<td align="left" valign="top"><a title="<?=$track->releasename?>" href="<?=$track->releaseurl?>" target="_blank"><?=$track->releasename?></a></td>
								<?
							}
							else
							{
								?>
									<td align="left" valign="top"><?=$track->trackname?></td>
									<td>&nbsp;</td>
									<td align="left" valign="top"><?=$track->releasename?></td>
								<?
							}
						?>
						<td>&nbsp;</td>
						<?
							if (isset($track->labelurl) && (strlen($track->labelurl) > 0))
							{
								?><td align="left" valign="top"><a title="<?=$track->labelname?>" href="<?=$track->labelurl?>" target="_blank"><?=$track->labelname?></a></td><?
							}
							else
							{
								?><td align="left" valign="top"><?=$track->labelname?></td><?
							}

							if (superUserIsLoggedIn())
							{
								$releaseexcludelabel = ($track->release_excluded ? 'Include Release' : 'Exclude Release');
								$trackexcludelabel = ($track->track_excluded ? 'Include Track' : 'Exclude Track');

								?>
									<td>&nbsp;</td>
									<td width="155" align="left" valign="top">
										[<a title="Super Users Only" href="superuser-setartistmaxcount.php?artistid=<?=$track->artistid?>">Set Max Count (<?=$track->artist_max_playlist_count?>)</a>]<br />
										<br />
										[<a title="Super Users Only" href="superuser-excluderelease-process.php?releaseid=<?=$track->releaseid?>"><?=$releaseexcludelabel?></a>]<br />
										[<a title="Super Users Only" href="superuser-excludetrack-process.php?trackid=<?=$track->trackid?>"><?=$trackexcludelabel?></a>]<br />
										<br />
										[<a title="Super Users Only" href="superuser-editartisturl.php?artistid=<?=$track->artistid?>">Edit Artist URL</a>]<br />
										[<a title="Super Users Only" href="superuser-editreleaseurl.php?releaseid=<?=$track->releaseid?>">Edit Release URL</a>]<br />
										[<a title="Super Users Only" href="superuser-editlabelurl.php?labelid=<?=$track->labelid?>">Edit Label URL</a>]<br />
									</td>
								<?
							}
						?>
					</tr>
					<?
						if (superUserIsLoggedIn())
						{
							?><tr><td>&nbsp;</td></tr><?
						}
					?>
				<?
				$lastlisting = $track->artist_track;
			}
		}
		?></table><?
	}
	else
	{
		?><p align="center"><i>There are no tracks to show at this time; please check back later.</i></p><?
	}
?>
<?
	showFooter($db, PG_RECENTLYPLAYED, $accessible);
?>
