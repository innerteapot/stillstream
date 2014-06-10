<?
	include('common/common.inc.php');
	showHeader($db, PG_SUPERUSER, -1, false, null, null, $accessible);

	if (!superUserIsLoggedIn())
	{
		?>
			<h1>Error</h1>
			<p>You are not authorized to see this page.</p>
		<?
	}
	else
	{
		if (stripos($msg, "error") === false)
		{
			?>
				<h1>Super User Action</h1>
				<h2 align="center"><?=$msg?></h2>
				<h2 align="center">[<a title="Continue" href="<?=$url?>">Continue</a>]</h2>
			<?
		}
		else
		{
			?>
				<h1>Super User Action</h1>
				<h2 align="center"><font color="red"><?=$msg?></font></h2>
				<h2 align="center">[<a title="Continue" href="<?=$url?>">Continue</a>]</h2>
			<?
		}
	}

	showFooter($db, PG_SUPERUSER, $accessible);
?>
