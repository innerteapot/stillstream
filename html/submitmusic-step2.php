<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);

	?>
		<h1>Submissions - Step 2</h1>
		<p>
			Now we must ask you to 
			sign the StillStream artist agreement (on the next page) for us to be able to play your
			music. This is a simple process and will only take a moment of your time.
		</p>
		<?
			if (isDefined($msg))
			{
				?><h3 align="center"><?=trim($msg)?></h3><?
			}
		?>
		<form action="submitmusic-step2-process.php" method="post">
			<table width="90%" align="center" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td valign="top" align="center">
						First, please give us your full legal name: <input type="text" name="fullname">
						<input type="submit" name="submit" value=" Continue ">
					</td>
				</tr>
			</table>
		</form>
	<?

	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
