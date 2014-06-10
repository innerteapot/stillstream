<?
	include('common/common.inc.php');
	showHeader($db, PG_GOODIES, -1, false, null, null, $accessible);
?>

<h1>Goodies</h1>

<table border="0" cellpadding="5" cellspacing="5" align="center">
	<tr>
		<td valign="top" align="center"><a title="StillStream Community" href="http://relaxedmachinery.ning.com/" target="_blank">Community</a></td>
		<td valign="top" align="left">Our community, a part of the Relaxed Machinery community on Ning.com.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="StillStream on last.fm" href="http://www.last.fm/user/stillstream" target="_blank">StillStream on last.fm</a></td>
		<td valign="top" align="left">Our page on last.fm.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="StillStream on Twitter" href="http://twitter.com/stillstreamnews" target="_blank">StillStream on Twitter</a></td>
		<td valign="top" align="left">Our official Twitter feed.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="StillStream on FaceBook" href="http://www.facebook.com/group.php?gid=51865027929" target="_blank">StillStream on FaceBook</a></td>
		<td valign="top" align="left">Our official page on FaceBook.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Links" href="links.php">Links</a></td>
		<td valign="top" align="left">Other sites we recommend.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Subscribe To Our RSS Feeds" href="rss.php">RSS</a></td>
		<td valign="top" align="left">Learn about our various RSS feeds, so you can keep up with StillStream happenings.</td>
	</tr>
</table>

<?
	showFooter($db, PG_GOODIES, $accessible);
?>
