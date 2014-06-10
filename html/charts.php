<?
	include('common/common.inc.php');
	showHeader($db, PG_PLAYSTATS, -1, false, null, null, $accessible);
	
	function showFinePrint($o)
	{
		?>
			<br />	
			<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td align="center" valign="middle" class="fineprint">
						Please note that results are recalculated daily, by summing up the number of times each <?=$o?> is played on
						StillStream according to our records. While largely accurate, these charts should be considered approximate and have not been
						independently confirmed.
					</td>
				</tr>
			</table>
		<?
	}

	function showSubheader($title)
	{
		?>
			<h1>Charts</h1>
			
			<table width="83%" border="0" cellpadding="1" cellspacing="0" align="center">
				<tr>
					<td align="right" valign="middle"><b>Show Artist Charts For:&nbsp;&nbsp;&nbsp;</b></td>
					<td align="center" valign="middle"><b><a title="Artist Charts For The Past Week" href="<?=PHPSELF?>?ct=weekartist">Last Week</a></b></td>
					<td align="center" valign="middle"><b><a title="Artist Charts For The Past Month" href="<?=PHPSELF?>?ct=monthartist">Last Month</a></b></td>
					<td align="center" valign="middle"><b><a title="Artist Charts For The Past Quarter" href="<?=PHPSELF?>?ct=quarterartist">Last Quarter</a></b></td>
					<td align="center" valign="middle"><b><a title="Artist Charts For The Past Year" href="<?=PHPSELF?>?ct=yearartist">Last Year</a></b></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><b>Show Release Charts For:&nbsp;&nbsp;&nbsp;</b></td>
					<td align="center" valign="middle"><b><a title="Release Charts For The Past Week" href="<?=PHPSELF?>?ct=week">Last Week</a></b></td>
					<td align="center" valign="middle"><b><a title="Release Charts For The Past Month" href="<?=PHPSELF?>?ct=month">Last Month</a></b></td>
					<td align="center" valign="middle"><b><a title="Release Charts For The Past Quarter" href="<?=PHPSELF?>?ct=quarter">Last Quarter</a></b></td>
					<td align="center" valign="middle"><b><a title="Release Charts For The Past Year" href="<?=PHPSELF?>?ct=year">Last Year</a></b></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><b>Show Collection Charts For:&nbsp;&nbsp;&nbsp;</b></td>
					<td align="center" valign="middle"><b><a title="Collection Charts For The Past Week" href="<?=PHPSELF?>?ct=weekunreleased">Last Week</a></b></td>
					<td align="center" valign="middle"><b><a title="Collection Charts For The Past Month" href="<?=PHPSELF?>?ct=monthunreleased">Last Month</a></b></td>
					<td align="center" valign="middle"><b><a title="Collection Charts For The Past Quarter" href="<?=PHPSELF?>?ct=quarterunreleased">Last Quarter</a></b></td>
					<td align="center" valign="middle"><b><a title="Collection Charts For The Past Year" href="<?=PHPSELF?>?ct=yearunreleased">Last Year</a></b></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><b>Show Track Charts For:&nbsp;&nbsp;&nbsp;</b></td>
					<td align="center" valign="middle"><b><a title="Track Charts For The Past Week" href="<?=PHPSELF?>?ct=weektrack">Last Week</a></b></td>
					<td align="center" valign="middle"><b><a title="Track Charts For The Past Month" href="<?=PHPSELF?>?ct=monthtrack">Last Month</a></b></td>
					<td align="center" valign="middle"><b><a title="Track Charts For The Past Quarter" href="<?=PHPSELF?>?ct=quartertrack">Last Quarter</a></b></td>
					<td align="center" valign="middle"><b><a title="Track Charts For The Past Year" href="<?=PHPSELF?>?ct=yeartrack">Last Year</a></b></td>
				</tr>
			</table>

			<br />
			
			<h2><?=$title?></h2>
			<p>As calculated from the StillStream playlist; updated once per day.</p>
		<?
	}
	
	function showAlbumChartsTop30($top30, $title, $showcounts)
	{
		showSubheader($title);
		?>
			<table width="99%" border="0" cellpadding="5" cellspacing="25" align="center">
				<tr>
					<?					
						$counter = -1;
						reset($top30);
						while (list($k, $v) = each($top30))
						{
							++$counter;
							if (($counter % 3) == 0)
							{
								if ($counter > 0)
								{
									?></tr><tr><?
								}
							}
							
							?>
								<td width="33%" align="center" valign="top">
									<?
										if ($v->thumbnail_image)
										{
											$thumbnail = $v->thumbnail_image; 
										}
										else
										{
											$thumbnail = 'missing_album_cover.jpg';
										}

										$countstr = '';
										if ($showcounts)
										{
											$countstr = " (" . $v->playcount . ")";
										}
										
										if ($v->release_url)
										{
											?>
												<a title="<?=$v->artist_names?> - <?=$v->release_name?>" href="<?=$v->release_url?>" target="_blank"><img class="imgborder" src="images/releases/<?=$thumbnail?>" border="0"></a><br />
												<a title="<?=$v->artist_names?> - <?=$v->release_name?>" href="<?=$v->release_url?>" target="_blank">#<?=$counter+1?> - <?=$v->artist_names?> - <?=$v->release_name?><?=$countstr?></a>  
											<?
										}
										else
										{
											?>
												<img class="imgborder" src="images/releases/<?=$thumbnail?>" border="0"><br />
												#<?=$counter+1?> - <?=$v->artist_names?> - <?=$v->release_name?><?=$countstr?>  
											<?
										}
									?>
								</td>
							<?
						}
					?>
				</tr>
			</table>
		<?
	}
	
	function showArtistChartsTop30($top30, $title, $showcounts)
	{
		showSubheader($title);
		?>
			<table width="99%" border="0" cellpadding="1" cellspacing="2" align="center">
				<?					
					$counter = 0;
					reset($top30);
					while (list($k, $v) = each($top30))
					{
						++$counter;

						$countstr = '';
						if ($showcounts)
						{
							$countstr = " (" . $v->playcount . ")";
						}

						?>
							<tr>
								<td align="left" valign="top">
									<?
										if ($v->artist_url)
										{
											?>
												<a title="<?=$v->artist_name?>" href="<?=$v->artist_url?>" target="_blank">#<?=$counter?> - <?=$v->artist_name?><?=$countstr?></a>  
											<?
										}
										else
										{
											?>
												#<?=$counter?> - <?=$v->artist_name?><?=$countstr?> 
											<?
										}
									?>
								</td>
							</tr>
						<?
					}
				?>
			</table>
		<?
	}

	function showTrackChartsTop30($top30, $title, $showcounts)
	{
		showSubheader($title);
		?>
			<table width="99%" border="0" cellpadding="5" cellspacing="25" align="center">
				<tr>
					<?					
						$counter = -1;
						reset($top30);
						while (list($k, $v) = each($top30))
						{
							++$counter;
							if (($counter % 3) == 0)
							{
								if ($counter > 0)
								{
									?></tr><tr><?
								}
							}
							
							?>
								<td width="33%" align="center" valign="top">
									<?
										if ($v->thumbnail_image)
										{
											$thumbnail = $v->thumbnail_image; 
										}
										else
										{
											$thumbnail = 'missing_album_cover.jpg';
										}

										$countstr = '';
										if ($showcounts)
										{
											$countstr = " (" . $v->playcount . ")";
										}
										
										if ($v->release_url)
										{
											?>
												<a title="<?=$v->artist_names?> - <?=$v->release_name?> - <?=$v->track_name?>" href="<?=$v->release_url?>" target="_blank"><img class="imgborder" src="images/releases/<?=$thumbnail?>" border="0"></a><br />
												<a title="<?=$v->artist_names?> - <?=$v->release_name?> - <?=$v->track_name?>" href="<?=$v->release_url?>" target="_blank">#<?=$counter+1?> - <?=$v->artist_names?> - <?=$v->release_name?> - <?=$v->track_name?><?=$countstr?></a>  
											<?
										}
										else
										{
											?>
												<img class="imgborder" src="images/releases/<?=$thumbnail?>" border="0"><br />
												#<?=$counter+1?> - <?=$v->artist_names?> - <?=$v->release_name?> - <?=$v->track_name?><?=$countstr?>  
											<?
										}
									?>
								</td>
							<?
						}
					?>
				</tr>
			</table>
		<?
	}
	
	$showcounts = false;
	if (superUserIsLoggedIn())
	{
		$showcounts = true;
	}
	
	if ($ct == 'week')
	{
		$title = 'Top Thirty Releases In Past Week';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('release');
	}
	else if ($ct == 'weekunreleased')
	{
		$title = 'Top Thirty Collections In Past Week';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('collection');
	}
	else if ($ct == 'month')
	{
		$title = 'Top Thirty Releases In Past Month';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('release');
	}
	else if ($ct == 'monthunreleased')
	{
		$title = 'Top Thirty Collections In Past Month';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('collection');
	}
	else if ($ct == 'quarter')
	{
		$title = 'Top Thirty Releases In Past Quarter';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('release');
	}
	else if ($ct == 'quarterunreleased')
	{
		$title = 'Top Thirty Collections In Past Quarter';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('collection');
	}
	else if ($ct == 'year')
	{
		$title = 'Top Thirty Releases In Past Year';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('release');
	}
	else if ($ct == 'yearunreleased')
	{
		$title = 'Top Thirty Collections In Past Year';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('collection');
	}
	else if ($ct == 'weekartist')
	{
		$title = 'Top Thirty Artists In Past Week';
		$top30 = getChartArtist($db, 'week');
		showArtistChartsTop30($top30, $title, $showcounts);
		showFinePrint('artist');
	}
	else if ($ct == 'monthartist')
	{
		$title = 'Top Thirty Artists In Past Month';
		$top30 = getChartArtist($db, 'month');
		showArtistChartsTop30($top30, $title, $showcounts);
		showFinePrint('artist');
	}
	else if ($ct == 'quarterartist')
	{
		$title = 'Top Thirty Artists In Past Quarter';
		$top30 = getChartArtist($db, 'quarter');
		showArtistChartsTop30($top30, $title, $showcounts);
		showFinePrint('artist');
	}
	else if ($ct == 'yearartist')
	{
		$title = 'Top Thirty Artists In Past Year';
		$top30 = getChartArtist($db, 'year');
		showArtistChartsTop30($top30, $title, $showcounts);
		showFinePrint('artist');
	}
	else if ($ct == 'weektrack')
	{
		$title = 'Top Thirty Tracks In Past Week';
		$top30 = getChartTrack($db, 'week');
		showTrackChartsTop30($top30, $title, $showcounts);
		showFinePrint('track');
	}
	else if ($ct == 'monthtrack')
	{
		$title = 'Top Thirty Tracks In Past Month';
		$top30 = getChartTrack($db, 'month');
		showTrackChartsTop30($top30, $title, $showcounts);
		showFinePrint('track');
	}
	else if ($ct == 'quartertrack')
	{
		$title = 'Top Thirty Tracks In Past Quarter';
		$top30 = getChartTrack($db, 'quarter');
		showTrackChartsTop30($top30, $title, $showcounts);
		showFinePrint('track');
	}
	else if ($ct == 'yeartrack')
	{
		$title = 'Top Thirty Tracks In Past Year';
		$top30 = getChartTrack($db, 'year');
		showTrackChartsTop30($top30, $title, $showcounts);
		showFinePrint('track');
	}
	else
	{
		$ct = 'week';
		$title = 'Top Thirty Releases In Past Week';
		$top30 = getChart($db, $ct);
		showAlbumChartsTop30($top30, $title, $showcounts);
		showFinePrint('release');
	}

	showFooter($db, PG_PLAYSTATS, $accessible);
?>

