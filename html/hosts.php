<?
	include('common/common.inc.php');
	showHeader($db, PG_HOSTS, -1, false, null, null, $accessible);
	$hosts = getAllHosts($db, $orderbyname = "yes");
?>

<h1>Our Hosts</h1>

<p>Some people call them 'deejays', others call them 'radio personalities', but we just call them cool folks.  Here are the people
who host our live programs, to whom we are very grateful.</p>


<table border="0" cellpadding="5" cellspacing="5" align="center">
	<?					
		reset($hosts);
		while (list($k, $v) = each($hosts))
		{
			if ($v->host_status == 'live')
			{
				?>
					<tr>
						<?
							?>
								<td valign="top" align="center">
									<?
										if (isDefined($v->hosturl))
										{
											?><a title="<?=$v->name?>" href="<?=$v->hosturl?>" target="_blank"><img class="imgborder" src="images/hosts/<?=$v->thumbnail_image?>" border="0"></a><?
										}
										else if (isDefined($v->big_image))
										{
											?><a title="<?=$v->name?>" href="images/hosts/<?=$v->big_image?>" target="_blank"><img class="imgborder" src="images/hosts/<?=$v->thumbnail_image?>" border="0"></a><?
										}
										else
										{
											?><img class="imgborder" src="images/hosts/<?=$v->thumbnail_image?>" border="0"><?
										}
									?>
								</td>
									
								<td valign="top" align="left">
									<?
										if (isDefined($v->hosturl))
										{						
											?><a title="<?=$v->name?>" href="<?=$v->hosturl?>" target="_blank"><h3><?=$v->name?></h3></a><?
										}
										else
										{
											?><h3><?=$v->name?></h3><?
										}
										
										if (isDefined($v->blogurl))
										{
											?>
												<a title="Blog for <?=$v->name?>" href="<?=$v->blogurl?>" target="_blank">Visit This Host's Blog</a><br />
												<br />
											<?
										}
									?>
									<?=$v->desc?><br />
									<br />
									<br />
								</td>
							<?
						?>
					</tr>
				<?
			}
		}
	?>
</table>
<?
	showFooter($db, PG_HOSTS, $accessible);
?>
