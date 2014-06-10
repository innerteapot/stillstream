<?
	include('common/common.inc.php');
	showHeader($db, PG_FEATURES, -1, false, null, null, $accessible);
	
	$albumfeatures = getAllAlbumFeatures($db);
	$artistfeatures = getAllArtistFeatures($db);
	$labelfeatures = getAllLabelFeatures($db);
	$otherfeatures = getAllOtherFeatures($db);
	
	function showFeatures($features, $title)
	{
		if (count($features) > 0)
		{
			?>
				<h2><?=$title?></h2>
				
				<table border="0" cellpadding="5" cellspacing="2" align="center">
					<?					
						reset($features);
						while (list($k, $v) = each($features))
						{
							$datedisplay = strftime("%B %d, %Y", dateToUnixTimestamp($v->date_added));
							?>
								<tr>
									<?
										if ($v->featureurl)
										{
											?>
												<td valign="top" align="center">
													<a title="<?=$v->title?>" href="<?=$v->featureurl?>" target="_blank"><img class="imgborder" src="images/features/<?=$v->thumbnail_image?>" border="0"></a></td>
												<td valign="top" align="left">
													<a title="<?=$v->title?>" href="<?=$v->featureurl?>" target="_blank"><h3><?=$v->title?></h3></a>
													<b><?=$v->byline?></b><br />
													(<?=$datedisplay?>) - <?=$v->content?></td>
											<?
										}
										else
										{
											?>
												<td valign="top" align="center"><img src="images/features/<?=$v->thumbnail_image?>" border="0"></td>
												<td valign="top" align="left"><h3 class="greenlink"><?=$v->title?></h3><b><?=$v->byline?></b><br />
												(<?=$datedisplay?>) - <?=$v->content?></td>
											<?
										}
									?>
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
							<?
						}
					?>
				</table>
			<?
		}
	}
	
?>

<h1><a title="Features RSS Feed" href="rss/features.xml"><img src="images/rss.png" border="0" width="14" height="14" style="border: 0px; margin-right: 7px;"></a>Features</h1>

<h3 align="center">
	<a title="Featured Artists" href="features.php?ft=artist">Featured Artists</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a title="Featured Releases" href="features.php?ft=release">Featured Releases</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a title="Featured Labels" href="features.php?ft=label">Featured Labels</a>
</h3>

<?
	if ($ft == 'label')
	{
		showFeatures($labelfeatures, 'Featured Labels');
	}
	else if ($ft == 'artist')
	{
		showFeatures($artistfeatures, 'Featured Artists');
	}
	else if ($ft == 'release')
	{
		showFeatures($albumfeatures, 'Featured Releases');
	}
	else
	{
		$r = rand(0, 100);
		if ($r < 33)
		{
			showFeatures($artistfeatures, 'Featured Artists');
		}
		else if ($r < 66)
		{
			showFeatures($albumfeatures, 'Featured Releases');
		}
		else
		{
			showFeatures($labelfeatures, 'Featured Labels');
		}
	}

	showFooter($db, PG_FEATURES, $accessible);
?>
