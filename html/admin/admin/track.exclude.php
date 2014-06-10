<html>
	<?
		include('/home/stillstream/stillstream.com/html/common/common.inc.php');
	?>
	<head></head>
	<body>
		<h1>Track Exclusions</h1>
		<p>[ <a href="index.php"> back to menu ... </a> ]</p>
		<p>
			<a href="?fl=A">A</a>&nbsp;
			<a href="?fl=B">B</a>&nbsp;
			<a href="?fl=C">C</a>&nbsp;
			<a href="?fl=D">D</a>&nbsp;
			<a href="?fl=E">E</a>&nbsp;
			<a href="?fl=F">F</a>&nbsp;
			<a href="?fl=G">G</a>&nbsp;
			<a href="?fl=H">H</a>&nbsp;
			<a href="?fl=I">I</a>&nbsp;
			<a href="?fl=J">J</a>&nbsp;
			<a href="?fl=K">K</a>&nbsp;
			<a href="?fl=L">L</a>&nbsp;
			<a href="?fl=M">M</a>&nbsp;
			<a href="?fl=N">N</a>&nbsp;
			<a href="?fl=O">O</a>&nbsp;
			<a href="?fl=P">P</a>&nbsp;
			<a href="?fl=Q">Q</a>&nbsp;
			<a href="?fl=R">R</a>&nbsp;
			<a href="?fl=S">S</a>&nbsp;
			<a href="?fl=T">T</a>&nbsp;
			<a href="?fl=U">U</a>&nbsp;
			<a href="?fl=V">V</a>&nbsp;
			<a href="?fl=W">W</a>&nbsp;
			<a href="?fl=X">X</a>&nbsp;
			<a href="?fl=Y">Y</a>&nbsp;
			<a href="?fl=Z">Z</a>&nbsp;
			<a href="?fl=0">0</a>&nbsp;
			<a href="?fl=1">1</a>&nbsp;
			<a href="?fl=2">2</a>&nbsp;
			<a href="?fl=3">3</a>&nbsp;
			<a href="?fl=4">4</a>&nbsp;
			<a href="?fl=5">5</a>&nbsp;
			<a href="?fl=6">6</a>&nbsp;
			<a href="?fl=7">7</a>&nbsp;
			<a href="?fl=8">8</a>&nbsp;
			<a href="?fl=9">9</a>&nbsp;
			<a href="?fl=%21">!</a>&nbsp;
			<a href="?fl=%23">#</a>&nbsp;
			<a href="?fl=%24">$</a>&nbsp;
			<a href="?fl=%25">%</a>&nbsp;
			<a href="?fl=%26">&</a>&nbsp;
			<a href="?fl=%2A">*</a>&nbsp;
			<a href="?fl=%2B">+</a>&nbsp;
			<a href="?fl=%2D">-</a>&nbsp;
			<a href="?fl=%2F">/</a>&nbsp;
			<a href="?fl=%3A">:</a>&nbsp;
			<a href="?fl=%3B">;</a>&nbsp;
			<a href="?fl=%3F">?</a>&nbsp;
			<a href="?fl=%40">@</a>&nbsp;
			<a href="?fl=%3C">&lt;</a>&nbsp;
			<a href="?fl=%28">(</a>&nbsp;
			<a href="?fl=%5B">[</a>&nbsp;
			<a href="?fl=%5F">_</a>&nbsp;
		</p>
		
		<?
			if (isDefined($fl))
			{
				$fl = trim(strtolower($fl));
				$tra = getAllTracksReleasesAndArtistsForArtistInitial($db, $fl);

				?>				
					<h3>Tracks For Artist Names Starting With '<?=strtoupper($fl)?>'</h3>
					<form action="track.exclude-process.php" method="POST">
						<table width="55%" cellpadding="2" cellspacing="0" border="1" align="center">
							<tr>
								<th>Artist</th>
								<th>Release</th>
								<th>Track</th>
								<th>Excluded</th>
							</tr>
							<?
								reset($tra);
								$counter = -1;
								while (list($k, $r) = each($tra))
								{
									++$counter;
									?>
										<tr>
											<td align="center" valign="top"><?=$r->artistname?></td>
											<td align="center" valign="top"><?=$r->releasetitle?></td>
											<td align="center" valign="top"><?=$r->tracktitle?></td>
											<td align="center" valign="top">
												<input type="hidden" name="trackid<?=$counter?>" value="<?=$r->trackid?>">
												<select name="exclude<?=$counter?>">
													<?
														if ($r->trackexclude == 'yes')
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
				<?
			}
			else
			{
				?><p>Please specify a first letter for the artist name.</p><?
			}
		?>
	</body>
</html>

