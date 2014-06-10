<?
	include('common/common.inc.php');
	showHeader($db, PG_ARTISTS, -1, false, null, null, $accessible);
?>

<h1>Artists We Play</h1>

<table cellspacing="5" cellpadding="0" border="0" width="100%">
	<tr>
		<td align="center" valign="top">
			<a title="Artists Starting With The Letter A" href="<?=PHPSELF?>?s=a">A</a> &nbsp;
			<a title="Artists Starting With The Letter B" href="<?=PHPSELF?>?s=b">B</a> &nbsp;
			<a title="Artists Starting With The Letter C" href="<?=PHPSELF?>?s=c">C</a> &nbsp;
			<a title="Artists Starting With The Letter D" href="<?=PHPSELF?>?s=d">D</a> &nbsp;
			<a title="Artists Starting With The Letter E" href="<?=PHPSELF?>?s=e">E</a> &nbsp;
			<a title="Artists Starting With The Letter F" href="<?=PHPSELF?>?s=f">F</a> &nbsp;
			<a title="Artists Starting With The Letter G" href="<?=PHPSELF?>?s=g">G</a> &nbsp;
			<a title="Artists Starting With The Letter H" href="<?=PHPSELF?>?s=h">H</a> &nbsp;
			<a title="Artists Starting With The Letter I" href="<?=PHPSELF?>?s=i">I</a> &nbsp;
			<a title="Artists Starting With The Letter J" href="<?=PHPSELF?>?s=j">J</a> &nbsp;
			<a title="Artists Starting With The Letter K" href="<?=PHPSELF?>?s=k">K</a> &nbsp;
			<a title="Artists Starting With The Letter L" href="<?=PHPSELF?>?s=l">L</a> &nbsp;
			<a title="Artists Starting With The Letter M" href="<?=PHPSELF?>?s=m">M</a> &nbsp;
			<a title="Artists Starting With The Letter N" href="<?=PHPSELF?>?s=n">N</a> &nbsp;
			<a title="Artists Starting With The Letter O" href="<?=PHPSELF?>?s=o">O</a> &nbsp;
			<a title="Artists Starting With The Letter P" href="<?=PHPSELF?>?s=p">P</a> &nbsp;
			<a title="Artists Starting With The Letter Q" href="<?=PHPSELF?>?s=q">Q</a> &nbsp;
			<a title="Artists Starting With The Letter R" href="<?=PHPSELF?>?s=r">R</a> &nbsp;
			<a title="Artists Starting With The Letter S" href="<?=PHPSELF?>?s=s">S</a> &nbsp;
			<a title="Artists Starting With The Letter T" href="<?=PHPSELF?>?s=t">T</a> &nbsp;
			<a title="Artists Starting With The Letter U" href="<?=PHPSELF?>?s=u">U</a> &nbsp;
			<a title="Artists Starting With The Letter V" href="<?=PHPSELF?>?s=v">V</a> &nbsp;
			<a title="Artists Starting With The Letter W" href="<?=PHPSELF?>?s=w">W</a> &nbsp;
			<a title="Artists Starting With The Letter X" href="<?=PHPSELF?>?s=x">X</a> &nbsp;
			<a title="Artists Starting With The Letter Y" href="<?=PHPSELF?>?s=y">Y</a> &nbsp;
			<a title="Artists Starting With The Letter Z" href="<?=PHPSELF?>?s=z">Z</a>
		</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td align="center" valign="top">
			<?
				if (!isset($s) || (strlen($s) < 1))
				{
					$s = 'a';
				}
				$subhdr = "Artists Starting With '" . strtoupper($s) . "'";
			?>
			<h2><?=$subhdr?></h2>
			<table cellspacing="2" cellpadding="0" border="0" align="center" width="80%">
				<tr>
					<?
						$artists = getArtistsByFirstLetter($db, $s);
						if (count($artists) > 0)
						{
							$ac = -1;
							reset($artists);
							while (list($key1, $ar) = each($artists))
							{
								++$ac;

								if (($ac % 2) == 0)
								{
									if ($ac > 0)
									{
										?></tr></tr><?
									}
								}
							
								if ((strlen($ar->url) > 0) && ($ar->url != 'http:///'))
								{
									?>
										<td width="50%" align="left" valign="top">
											<a title="<?=trim($ar->name)?>" href="<?=$ar->url?>" target="_blank"><?=trim($ar->name)?></a>
										</td>
									<?
								}
								else
								{
									?>
										<td width="50%" align="left" valign="top">
											<?=$ar->name?>
										</td>
									<?
								}
							}
						}
						else
						{
							?>
								<tr>
									<td align="center" valign="middle">
										[ no artists found ]
									</td>
								</tr>
							<?
						}
					?>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?
	showFooter($db, PG_ARTISTS, $accessible);
?>

