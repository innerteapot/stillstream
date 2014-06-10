<?
	include('common/common.inc.php');
	showHeader($db, PG_ARCHIVES, -1, false, null, null, $accessible);
?>

<h1><a title="Archives RSS Feed" href="rss/archives.xml"><img src="images/rss.png" width="14" height="14" border="0" style="border: 0px; margin-right: 7px;"></a>Archives</h1>

<p>
	The following audio and video files are available for download.
	These are selected excerpts from our live shows, generally live performances,
	which we make available for your listening pleasure on behalf of
	the artists who performed.
</p>
<p>
	Please note that these files are distributed with permission of the artists and the content in them
	is copyrighted by both the artist and by StillStream.com, with all rights reserved. They are made available
	for free personal download and free personal listening, but any other use requires advance written permission
	from the artist. Please <a title="Contact Us" href="contact.php">contact us</a> if you have any questions.
</p>
<table cellspacing="5" cellpadding="5" border="0" align="center">
	<?
		$entries = getAllArchivesEntries($db);
		$lastentry = null;
		while (list($k, $entry) = each($entries))
		{
			if ($entry->date_performed != $lastentry->date_performed)
			{
				if ($lastentry != null)
				{
					?></td></tr><?
				}
				?>
					<tr>
						<td align="left" valign="top">
							<?=formatDateValue($entry->date_performed, DATE_FORMAT_FULL_ENGLISH)?>
						</td>
						<td align="left" valign="top">
							<a title="<?=formatDateValue($entry->date_performed, DATE_FORMAT_FULL_ENGLISH)?> - <?=trim($entry->title)?>" href="assets/<?=trim($entry->filename)?>"><?=trim($entry->title)?></a><br />
				<?
			}
			else
			{
				?><a title="<?=formatDateValue($entry->date_performed, DATE_FORMAT_FULL_ENGLISH)?> - <?=trim($entry->title)?>" href="assets/<?=trim($entry->filename)?>"><?=trim($entry->title)?></a><br /><?
			}
			$lastentry = $entry;
		}
		if ($lastentry != null)
		{
			?></td></tr><?
		}
	?>
</table>

<?
	showFooter($db, PG_ARCHIVES, $accessible);
?>
