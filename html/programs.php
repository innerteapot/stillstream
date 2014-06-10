<?
	include('common/common.inc.php');
	showHeader($db, PG_PROGRAMS, -1, false, null, null, $accessible);
	$programs = getAllPrograms($db);
?>

<h1>Our Programs</h1>
<p>These are the shows that make StillStream what it is.  See the <a title="Program and Special Events Schedule" href="schedule.php">schedule page</a> for information about days and times.</p>
<table border="0" cellpadding="5" cellspacing="5" align="center">
	<?					
		reset($programs);
		while (list($k, $v) = each($programs))
		{
			if ($v->program_status == 'live')
			{
				$host = getHost($db, $v->host_id);
				?>
					<tr>
						<td valign="top" align="center">
							<?
								if (isDefined($v->url))
								{
									?><a title="<?=$v->name?>" href="<?=$v->url?>" target="_blank"><img class="imgborder" src="images/shows/<?=$v->thumbnail_image?>" border="0"></a><?
								}
								else
								{
									?><img class="imgborder" src="images/shows/<?=$v->thumbnail_image?>" border="0"><?
								}
							?>
						</td>
							
						<td valign="top" align="left" height="100">
							<?
								if (isDefined($v->url))
								{						
									?><a title="<?=$v->name?>" href="<?=$v->url?>" target="_blank"><h3><?=$v->name?></h3></a><?
								}
								else
								{
									?><h3><?=$v->name?></h3><?
								}
							?>
							(Hosted by <?=$host->name?>) - <?=$v->desc?>
							<?
								if (isDefined($v->blurb))
								{
									?>
										<br />
										<br />
										<?=$v->blurb?><br />
										<br />
									<?
								}
							?>
						</td>
					</tr>
				<?
			}
		}
	?>
</table>
<?
	showFooter($db, PG_PROGRAMS, $accessible);
?>
