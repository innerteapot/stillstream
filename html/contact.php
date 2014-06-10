<?
	include('common/common.inc.php');
	showHeader($db, PG_CONTACT, -1, false, null, null, $accessible);
?>

<h1>Contact</h1>

<?
	if ($action == 'submit')
	{
		if (isDefined($cname) && isDefined($cemail) && isDefined($ctext))
		{
			$resp = recaptcha_check_answer($recaptcha_privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
			if ($resp->is_valid)
			{
				if (isSpam($ctext))
				{
					sleep(4);		// make it look like we contacted an smtp server
					?>
						<p>
							Thank you for contacting us; we will respond as soon as possible.
						</p>
					<?
				}
				else
				{
					$msg = "name: '$cname'\nemail: '$cemail'\ntext: '$ctext'\n";
					notifyStaff('An email has been sent from stillstream.com', $msg, $cemail);
					?>
						<p>
							Thank you for contacting us - we will respond as soon as possible.
						</p>
					<?
				}
				$cname = '';
				$cemail = '';
				$ctext = '';
			}
			else
			{
				?>
					<p>
						The security code you entered does not match.  Please
						<a title="Try Again" href="javascript:history.back()">go back</a> and try again.
					</p>
				<?
			}
		}
		else
		{
			?>
				<p>
					Did you forget to type in your name, email address, or message?  Please
					<a title="Try Again" href="javascript:history.back()">go back</a> and try again.
				</p>
			<?
		}
	}
	else
	{
		$thecode = getRandomSecurityCode($db);
		?>
			<form action="contact.php" method="post">
				<input name="action" type=hidden value="submit">
				<table width="99%" cellspacing="2" cellpadding="0" border="0">
					<tr>
						<td align="right"><label for="cname">Name:</label>&nbsp;&nbsp;</td>
						<td align="left"><input name="cname" id="cname" type="text" value="<?=$cname?>" size="80" maxlen="128"></td>
					</tr>
					<tr>
						<td align="right"><label for="cemail">Email:</label>&nbsp;&nbsp;</td>
						<td align="left"><input name="cemail" id="cemail" type="text" value="<?=$cemail?>" size="80" maxlen="255"></td>
					</tr>
					<tr>
						<td align="right"><label for="ctext">Message:</label>&nbsp;&nbsp;</td>
						<td align="left"><textarea cols="66" name="ctext" id="ctext" rows="8"><?=$gbtext?></textarea></td>
					</tr>
					<tr>
						<td align="right">Security Code:&nbsp;&nbsp;</td>
						<td align="left"><?print recaptcha_get_html($recaptcha_publickey)?></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><br><input name="submit" type="submit" value="  Contact Us  "></td>
					</tr>
				</table>
			</form>
		<?
	}
?>

<?
	showFooter($db, PG_CONTACT, $accessible);
?>
