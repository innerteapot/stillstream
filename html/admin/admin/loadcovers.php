<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
		
		$all = FALSE;
		if (isDefined($showall))
		{
			if ($showall == 'all')
			{
				$all = TRUE;
			}
		}
		$releases = getReleasesMissingAlbumCovers($db, 500000, $all);
	?>
	<head></head>
	<body>
		<h1>Load Album Covers</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="loadcovers-process.php" method="POST">
			<p align="center">
				[<a href="loadcovers-cleanup-process.php">Perform Clean Up</a>]
			</p>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
			<p align="center">
				<select name="showall" size="1">
					<option selected value="new">Albums With No Covers</option>
					<option value="all">All Albums</option>
				</select>
			</p>
			<table width="99%" cellpadding="2" cellspacing="0" border="1" align="center">
				<tr>
					<th>Artist</th>
					<th>Release</th>
					<th>Release URL</th>
					<th>Cover</th>
					<th>URL To Remote Image</th>
					<th width="20%"></th>
				</tr>
				<?
					reset($releases);
					$counter = 0;
					while (list($k, $r) = each($releases))
					{
						// get the artist id for the catnum
						$artist = getArtistForCatnum($db, $r->catnum);
						if ($artist)
						{
							++$counter;
							if ($r->releaseurl)
							{
								?>
									<tr>
										<td align="left" valign="top"><?=$artist->name?></td>				
										<td align="left" valign="top"><?=$r->title?></td>				
										<td align="center" valign="top"><a href="<?=$r->releaseurl?>" target="_blank">Click</a></td>				
										<td align="center" valign="top">
											<?
												if ($r->thumbnail_image)
												{
													?>
														<img src="../../images/releases/<?=$r->thumbnail_image?>" border="0"/><br />
														[<a href="loadcovers-clear-process.php?releaseid=<?=$r->id?>">Clear</a>]
													<?
												}
												else
												{
													?>(no image)<?
												}
											?>
										</td>
										<td align="center" valign="top">
											<input type="hidden" name="artist<?=$counter?>" value="<?=urlencode($artist->name)?>">
											<input type="hidden" name="release<?=$counter?>" value="<?=urlencode($r->title)?>">
											<input type="hidden" name="releaseid<?=$counter?>" value="<?=$r->id?>">
											<input type="text" name="imgfile<?=$counter?>" value="">
										</td>
										<td align="center" valign="top">
											[<a href="loadcovers-noimage-process.php?releaseid=<?=$r->id?>">No Image Now</a>]<br />
											<br />
											[<a href="loadcovers-definitelynoimage-process.php?releaseid=<?=$r->id?>">No Image Ever</a>]<br />
											<br />
											[<a href="loadcovers-archiveorg-process.php?releaseid=<?=$r->id?>">Archive.org Image</a>]
										</td>
									</tr>
								<?
							}
							else
							{
								?>
									<tr>
										<td align="left" valign="top"><?=$artist->name?></td>				
										<td align="left" valign="top"><?=$r->title?></td>				
										<td align="left" valign="top">NO URL</td>				
				                                                          <td align="center" valign="top">
				                                                                  <?
				                                                                          if ($r->thumbnail_image)
				                                                                          {
				                                                                                  ?>
				                                                                                          <img src="/images/releases/<?=$r->thumbnail_image?>" border="0"/><br />
				                                                                                          [<a href="loadcovers-clear-process.php?releaseid=<?=$r->id?>">Clear</a>]
				                                                                                  <?
				                                                                          }
				                                                                          else
				                                                                          {
				                                                                                  ?>(no image)<?
				                                                                          }
				                                                                  ?>
				                                                          </td>
										<td align="left" valign="top">
											<input type="hidden" name="artist<?=$counter?>" value="<?=urlencode($artist->name)?>">
											<input type="hidden" name="release<?=$counter?>" value="<?=urlencode($r->title)?>">
											<input type="hidden" name="releaseid<?=$counter?>" value="<?=$r->id?>">
											<input type="text" name="imgfile<?=$counter?>" value="">
										</td>				
										<td align="left" valign="top">
											[<a href="loadcovers-noimage-process.php?releaseid=<?=$r->id?>">No Image Now</a>]<br />
											<br />
											[<a href="loadcovers-definitelynoimage-process.php?releaseid=<?=$r->id?>">No Image Ever</a>]<br />
											<br />
											[<a href="loadcovers-archiveorg-process.php?releaseid=<?=$r->id?>">Archive.org Image</a>]
										</td>
									</tr>
								<?
							}
						}
					}
				?>
			</table>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
		</form>
	</body>
</html>

