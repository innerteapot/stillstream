<?
	include('common/common.inc.php');
	showHeader($db, PG_NONE, -1, false, null, null, $accessible);

	if (!isDefined($rev))
	{
		$rev = CURRENT_ARTIST_AGREEMENT_VERION;
	}

	?>
		<h1>Our Artist Agreement</h1>
		<div class="blockDistinct">
			<p>
				The following is the most recent version of the StillStream Artist Agreemeent.
				We use this agreement when an artist desires airplay on our station, but the
				artist's music is not released under Creative Commons.
			</p>
			<table width="90%" align="center" cellspacing="0" cellpadding="10" border="0">
				<tr bgcolor="white">
					<td align="left" valign="top">
						<?
							include('docs/artistagreement-v' . $rev . '.inc');
						?>
					</td>
				</tr>
			</table>
			<p>&nbsp;</p>
		</div>
	<?

	showFooter($db, PG_NONE, $accessible);
?>
