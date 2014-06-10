<?
	include('common/common.inc.php');
	showHeader($db, PG_RECENTLYADDED, -1, false, null, null, $accessible);
	
	function addRecentlyAddedLink($arr, $heading)
	{	
		$arraycount = count($arr);
		if ($arraycount > 0)
		{
			?>
				<h2><?=$heading?></h2>
				<table border="0" align="center" width="99%" cellpadding="0" cellspacing="0">
					<tr>
					<?
						$counter = -1;
						reset($arr);
						while (list($k, $v) = each($arr))
						{
							++$counter;
							if (($counter % 2) == 0)
							{
								if ($counter > 0)
								{
									?></tr><tr><?
								}
							}

							if ($v->displayurl)
							{
								?>
									<td width="50%" align="left" valign="middle"><a title="<?=$v->displaystring?>" href="<?=$v->displayurl?>" target="_blank"><?=$v->displaystring?></a></td>
								<?
							}
							else
							{
								?>
									<td width="50%" align="left" valign="middle"><?=$v->displaystring?><?=$thecomma?></td>
								<?
							}
						}
					?>
					</tr>
				</table>
			<?
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	?><h1>Recently Added To Our Library</h1><?
	
	$l = addRecentlyAddedLink(getRecentlyAddedLabels($db), 'Labels');
	$a = addRecentlyAddedLink(getRecentlyAddedArtists($db), 'Artists');
	$r = addRecentlyAddedLink(getRecentlyAddedAlbums($db), 'Releases');
//	$t = addRecentlyAddedLink(getRecentlyAddedTracks($db), 'Tracks');
	
	if (!$l && !$a && !$r && !$t)
	{
		?>
			<p>Nothing new seems to have been added just recently, but keep an eye out.  We update our library often!</p>
		<?
	}

	showFooter($db, PG_RECENTLYADDED, $accessible);
?>
