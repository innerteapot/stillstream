<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);
	
	if ($action == 'oops')
	{
		?>
			<h1>Submissions - Cannot Continue</h1>
			<p align="center">
				We're very sorry, but you can only grant StillStream permission to broadcast your music
				if you own the exclusive rights to the music, free and clear.
			</p>
		<?
	}
	else
	{
		?>
			<h1>Submissions - Step 1</h1>
			<p>
				Are you the copyright holder of the music you will be submitting?
			</p>
			<p align="center">
				<a title="Yes, I (or we) own the rights to the music free and clear ..." href="submitmusic-step2.php">Yes, I (or we) own the rights to the music free and clear ...</a>
			</p>
			<p align="center">
				<a title="No, one or more third parties also have some rights to the music ..." href="<?=PHPSELF?>?action=oops">No, one or more third parties also have some rights to the music ...</a>
			</p>
			<p>
				NOTE:  if you are not the only person who has rights to the music
				(for example you are in a band), then you must get permission from all
				those people before clicking 'Yes' above. You must not proceed
				with granting us permission to play the music unless you are certain
				you are authorized to speak on behalf of all other parties.
			</p>
		<?
	}

	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
