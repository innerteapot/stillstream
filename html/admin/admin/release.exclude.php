<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');

		function cmp($a1, $a2)
		{
			$aname1 = $a1->artistname;
			$aname2 = $a2->artistname;
			$rname1 = $a1->releasetitle;
			$rname2 = $a2->releasetitle;

			if ($aname1 < $aname2)
			{
				return -1;
			}
			else if ($aname1 > $aname2)
			{
				return 1;
			}
			else
			{
				if ($rname1 < $rname2)
				{
					return -1;
				}
				else if ($rname1 > $rname2)
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
		}

		$rr = getReleasesAndArtists($db);
		
		// get list down to just releases and multiple artists
		$releases = array();
		$lastreleaseid = null;
		reset($rr);
		while (list($k, $r) = each($rr))
		{
			if ($r->releaseid != $lastreleaseid)
			{
				$o = new stdClass;
				$o->releaseid = $r->releaseid;
				$o->releasetitle = $r->releasetitle;
				$o->exclude = $r->exclude;
				$o->artistname = $r->artistname;
				$o->maxcount = $r->maxcount;
				$releases[$o->releaseid] = $o;
				$lastreleaseid = $r->releaseid;
			}
			else
			{
				$o = $releases[$r->releaseid];
				$o->artistname = $o->artistname . ', ' . $r->artistname;
				$o->maxcount = $o->maxcount + $r->maxcount;
				$releases[$o->releaseid] = $o;
			}
		}

		// now sort the array by artist name and release name
		usort($releases, "cmp");
	?>
	<head></head>
	<body>
		<h1>Release Exclusions</h1>

		<p>[ <a href="index.php"> back to menu ... </a> ]</p>

		<form action="release.exclude-process.php" method="POST">
			<table width="55%" cellpadding="2" cellspacing="0" border="1" align="center">
				<tr>
					<th width="40%">Artist(s)</th>
					<th width="40%">Release</th>
					<th width="20%">Excluded</th>
				</tr>
				<?
					reset($releases);
					$counter = -1;

					while (list($k, $r) = each($releases))
					{
						++$counter;

						$bgcolor = "#ffffff";
						if ($r->exclude == 'yes')
						{
							$bgcolor = "#ff0000";
						}

						$artistbgcolor = "#ffffff";
						if ($r->maxcount <= 0)
						{
							$artistbgcolor = "#ff0000";
						}
						
						?>
							<tr>
								<td align="center" valign="top" bgcolor="<?=$artistbgcolor?>"><?=$r->artistname?></td>
								<td align="center" valign="top" bgcolor="<?=$artistbgcolor?>"><?=$r->releasetitle?></td>
								<td align="center" valign="top" bgcolor="<?=$bgcolor?>">
									<input type="hidden" name="releaseid<?=$counter?>" value="<?=$r->releaseid?>">
									<select name="exclude<?=$counter?>">
										<?
											if ($r->exclude == 'yes')
											{
												?>
													<option selected>yes</option>
													<option>no</option>
												<?
											}
											else
											{
												?>
													<option>yes</option>
													<option selected>no</option>
												<?
											}
										?>
									</select>
								</td>
							</tr>
						<?
					}
				?>
			</table>
			<p align="center">
				<input type="submit" value="Submit" name="submit">
			</p>
		</form>
	</body>
</html>

