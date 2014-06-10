<?
	define("MAX_NUMBER_PLAYLIST_ENTRIES", "10");
	include('common/common.inc.php');
	showHeader($db, PG_SOONTOBEPLAYED, -1, false, null, null, $accessible);
?>

<h1><a title="Playlist RSS Feed" href="rss/playlist.xml"><img src="images/rss.png" border="0" width="14" height="14" style="border: 0px; margin-right: 7px;"></a>Upcoming Tracks Scheduled To Be Played</h1>

<p><a title="Playlist Search" href="search.php">Search For Music Plays</a></p>

<?
	$tracks = getUpcomingTracks($db, MAX_NUMBER_PLAYLIST_ENTRIES);
	if (count($tracks) > 0)
	{
		?>
			<table width="100%" align="center" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<th>Artist</th>
					<th width="5"></th>
					<th>Track</th>
					<th width="5"></th>
					<th>Release</th>
					<th width="5"></th>
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
				if ($track->artist_track != $lastlisting)
				{
					?>
						<tr>
							<?
								if (isset($track->artisturl) && (strlen($track->artisturl) > 0))
								{
									?><td align="left" valign="top"><a title="<?=$track->artistname?>" href="<?=$track->artisturl?>" target="_blank"><?=$track->artistname?></a>&nbsp;</td><?
								}
								else
								{
									?><td align="left" valign="top"><?=$track->artistname?></td>&nbsp;<?
								}
							?>
							<td></td>
							<?
								if (isset($track->releaseurl) && (strlen($track->releaseurl) > 0))
								{
									?>
										<td align="left" valign="top"><a title="<?=$track->trackname?>" href="<?=$track->releaseurl?>" target="_blank"><?=$track->trackname?></a>&nbsp;</td>
										<td></td>
										<td align="left" valign="top"><a title="<?=$track->releasename?>" href="<?=$track->releaseurl?>" target="_blank"><?=$track->releasename?></a>&nbsp;</td>
									<?
								}
								else
								{
									?>
										<td align="left" valign="top"><?=$track->trackname?>&nbsp;</td>
										<td></td>
										<td align="left" valign="top"><?=$track->releasename?>&nbsp;</td>
									<?
								}
							?>
							<td></td>
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
									?>
										<td>&nbsp;</td>
										<td width="155" align="left" valign="top">
											[<a title="Super Users Only" href="superuser-setartistmaxcount.php?artistid=<?=$track->artistid?>">Set Max Count (<?=$track->artist_max_playlist_count?>)</a>]<br />
											[<a title="Super Users Only" href="superuser-excludetrack-process.php?trackid=<?=$track->trackid?>">Exclude Track</a>]<br />
											[<a title="Super Users Only" href="superuser-excluderelease-process.php?releaseid=<?=$track->releaseid?>">Exclude Release</a>]
										</td>
									<?
								}
							?>
						</tr>
					<?
					$lastlisting = $track->artist_track;
				}
			}
			?></table><?
			?><p>&nbsp;</p><?
			?><p align="center">(and many more ...)</p><?
		}
		else
		{
			?><p align="center"><i>There are no tracks to show at this time; please check back later.</i></p><?
		}
?>
<?
	showFooter($db, PG_SOONTOBEPLAYED, $accessible);
?>
