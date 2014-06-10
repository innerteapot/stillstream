<?
	include('common/common.inc.php');
	showHeader($db, PG_SUPERUSER, -1, false, null, null, $accessible);

	function showError($msg)
	{
		?>
			<h1>Error</h1>
			<h2 align="center"><font color="red"><?=$msg?></font></h2>
		<?
	}

	if (!superUserIsLoggedIn())
	{
		showError("You are not authorized to see this page.");
	}
	else
	{
		if (isDefined($labelid))
		{
			$label = getLabel($db, $labelid);
			if ($label)
			{
				?>
					<h1>Edit Label URL</h1>

					<form action="superuser-editlabelurl-process.php" method="post">
						<p align="center">
							Label URL for <?=$label->name?>: <input type="text" name="url" size="80" value="<?=$label->labelurl?>"><br />
							<input type="hidden" name="labelid" value="<?=$label->id?>"><input type="submit" name="Submit" value="Submit">
						</p>
					</form>
				<?
			}
			else
			{
				showError("Cannot find label for label id:[$labelid].");
			}
		}
		else
		{
			showError("Label ID is null.");
		}
	}

	showFooter($db, PG_SUPERUSER, $accessible);
?>
