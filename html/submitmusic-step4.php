<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);

	?>
		<h1>Submissions - Step 4</h1>
		<p>
			Okay, we're almost done.  We just need a bit more information about you
			for our legal records. Bold fields are required.
		</p>
		<p>
			All information you submit is covered by our <a title="Privacy Policy" href="privacy.php" target="_blank">Privacy
			Policy</a>, and will not be shared with anyone for any reason unless required by law.
			Don't worry, we'll treat your data with the same respect we'd want you to
			treat ours with.
		</p>
		<?
			if (isDefined($msg))
			{
				?><h2 align="center"><font color="red"><b><br /><?=trim($msg)?><br />&nbsp;<br /></b></font></h2><?
			}
		?>
		<form action="submitmusic-step4-process.php" method="post">
			<input type="hidden" name="fullname" value="<?=$fn?>">
			<table width="99%" align="center" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="25%" align="right" valign="top"><b>Artist Name:</b></td>
					<td valign="top"><input type="text" name="artistname" size="60"></td>
				</tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>Artist Web Page:</b></td>
					<td valign="top"><input type="text" name="url" size="60"></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>Address 1:</b></td>
					<td valign="top"><input type="text" name="addr1" size="60"></td>
				</tr>
				<tr>
					<td width="25%" align="right" valign="top">Address 2:</td>
					<td valign="top"><input type="text" name="addr2" size="60"></td>
				</tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>City:</b></td>
					<td valign="top"><input type="text" name="city" size="60"></td>
				</tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>State or Province:</b></td>
					<td valign="top"><input type="text" name="stateprov" size="60"></td>
				</tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>Postal Code:</b></td>
					<td valign="top"><input type="text" name="zip" size="60"></td>
				</tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>Country:</b></td>
					<td valign="top"><input type="text" name="country" size="60"></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td width="25%" align="right" valign="top"><b>Email:</b></td>
					<td valign="top"><input type="text" name="email" size="60"> *</td>
				</tr>
				<tr>
					<td width="25	%" align="right" valign="top"><b>Daytime Phone:</b></td>
					<td valign="top"><input type="text" name="phone" size="60"> *</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td align="center" valign="top" colspan="2">
						<i>* Note we may need to contact you to verify your
						information, so please enter these fields carefully.</i>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td align="left" valign="top" colspan="2">
						<p>
							Please review this information carefully.  Once you submit it,
							you can edit it only by <a title="How To Reach Us" href="contact.php" target="_blank">contacting
							us</a>, so please ensure all of the information is correct!
						</p>
					</td>
				</tr>
				<tr>
					<td align="center" valign="top" colspan="2"><input type="submit" name="submit" value=" Finish "></td>
				</tr>
			</table>
		</form>
	<?

	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
