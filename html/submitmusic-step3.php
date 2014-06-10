<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);

	?>
		<h1>Submissions - Step 3</h1>
		<?
			if (isDefined($msg))
			{
				?><h3 align="center"><?=trim($msg)?></h3><?
			}
		?>
 		<p>
			Following is the waiver agreement we need you to sign so that we can play
			your music. Here's a plain-English summary of the agreement:
		</p>
		<ol>
			<li>
				You give StillStream permission to freely play all your music on StillStream,
				waiving all royalties and license fees, so long as we remain non-commercial.<br />
				<br />
			</li>
			<li>
				This agreement does not in any way imply a transfer of ownership of any
				of your rights as an artist and copyright holder.  You are simply
				granting us permission to play your music on our stream without cost.<br />
				<br />
			<li>
				StillStream promises to attribute the music to you and to link back to your
				web site whenever we play your music.<br />
				<br />
			</li>
			<li>
				You promise that if you are or become a member of any Performing Rights Organization,
				such as ASCAP, BMI, etc., that you will file all necessary documentation with
				them establishing your waiver with us.<br />
				<br />
			</li>
			<li>
				You promise that if we play your music on StillStream, no one is going to
				come to StillStream at a later date demanding royalties or license fees.<br />
				<br />
			</li>
			<li>
				The agreement can be terminated at any time simply by notifying us. We do
				ask for 30 days notice so we have time to remove your music from our library.
				There is no cost for termination.
			</li>
		</ol>
		<p>
			Please note that we dislike legalism as much as anyone, but unfortunately there
			no choice but to clearly document permission, given the legal climate in which
			the music industry operates today. Thus, <em>it is very important that you understand this agreement before you sign it, so please read carefully.</em>
		</p>
		<table width="90%" align="center" cellspacing="0" cellpadding="10" border="0">
			<tr bgcolor="lightgrey">
				<td align="left" valign="top">
					<?
						include('docs/artistagreement-v' . CURRENT_ARTIST_AGREEMENT_VERION . '.inc');
					?>
				</td>
			</tr>
		</table>
		<p>&nbsp;</p>
		<p>
			If you are comfortable with the terms of this agreement, please sign below.
			<b>This is a legal and binding agreement, so do not sign until you are certain you
			have met all requirements and are comfortable with the terms of the agreement!</b>
		</p>
		<?
			if (isDefined($msg))
			{
				?><h3 align="center"><?=trim($msg)?></h3><?
			}
		?>
		<form action="submitmusic-step3-process.php" method="post">
			<table width="90%" align="center" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td valign="top" align="center">
						<h3>DIGITAL SIGNATURE</h3>
						By signing below, you agree to the terms of and to be bound by
						this agreement.<br />
						<br />
						Please re-enter your full legal name, as signature: <input type="text" name="fullname">
						<input type="hidden" name="fn" value="<?=$fn?>">
						<input type="submit" name="submit" value=" Continue ">
					</td>
				</tr>
			</table>
		</form>
	<?

	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
