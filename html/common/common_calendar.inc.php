<?
class VisualCalendar
{
	var $month = 1;
	var $year = 2008;
	var $urltarget = '';
	var $monthattrname = 'month';
	var $yearattrname = 'year';
	var $extrauriparm = '';
	var $dayonetimestamp = 0;
	var $dayonedayofweek = 'sun';
	var $blankleadindays = 0;
	var $daysinmonth = 31;
	var $daylinks = array();

	function VisualCalendar($month, $year, $urltarget, $monthattrname, $yearattrname, $extrauriparm)
	{
		// input parameters
		$this->month = $month;
		$this->year = $year;
		$this->urltarget = $urltarget;
		$this->monthattrname = $monthattrname;
		$this->yearattrname = $yearattrname;
		$this->extrauriparm = $extrauriparm;

		// calculated stuff
		$this->daysinmonth = getNumberDaysInMonth($this->month, $this->year);
		$this->dayonetimestamp = mktime(1, 1, 1, $this->month, 1, $this->year);
		$this->dayonedayofweek = getDayOfWeekFromTimestamp($this->dayonetimestamp);
		switch ($this->dayonedayofweek)
		{
			case 'sun':
				$this->blankleadindays = 0;
				break;
			case 'mon':
				$this->blankleadindays = 1;
				break;
			case 'tue':
				$this->blankleadindays = 2;
				break;
			case 'wed':
				$this->blankleadindays = 3;
				break;
			case 'thu':
				$this->blankleadindays = 4;
				break;
			case 'fri':
				$this->blankleadindays = 5;
				break;
			case 'sat':
				$this->blankleadindays = 6;
				break;
		}
	}

	function addLinkToDay($dayofmonth, $url, $linktext)
	{
		// make an object for the entry
		$dl = new stdClass;
		$dl->url = $url;
		$dl->linktext = $linktext;

		// get the entry for the day
		$entry = $this->daylinks[$dayofmonth];
		if (!$entry)
		{
			$entry = array();
		}

		// add the link to the entry and put the entry back
		$entry[] = $dl;
		$this->daylinks[$dayofmonth] = $entry;
	}

	function showHTML()
	{
		$prevmonth = $this->month - 1;
		$prevyear = $this->year;
		$nextmonth = $this->month + 1;
		$nextyear = $this->year;
		if ($prevmonth < 1)
		{
			$prevmonth = 12;
			$prevyear = $prevyear - 1;
		}
		if ($nextmonth > 12)
		{
			$nextmonth = 1;
			$nextyear = $nextyear + 1;
		}
		$prevurl = $this->urltarget . '?' . $this->monthattrname . '=' . $prevmonth . '&' . $this->yearattrname . '=' . $prevyear . '&' .  $this->extrauriparm;
		$nexturl = $this->urltarget . '?' . $this->monthattrname . '=' . $nextmonth . '&' . $this->yearattrname . '=' . $nextyear . '&' .  $this->extrauriparm;

		?>
			<table cellpadding="0" cellspacing="0" valign="top">
				<tr>
					<td valign="top">
						<table cellpadding="5" cellspacing="0" align="center" valign="top" width="570">
							<tr>
								<td align="center">
									<a title="Previous Month" href="<?=$prevurl?>">&laquo; Previous Month</a>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<font size="+2"><b><?=getMonthName($this->month)?>, <?=$this->year?></b></font>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<a title="Next Month" href="<?=$nexturl?>">Next Month &raquo;</a>
								</td>
							</tr>
						</table>
						<table cellpadding="3" cellspacing="0" align="center" class="calendar" width="570">
							<tr class="calendar">
								<th width="92" align="center" class="calendar">Sunday</th>
								<th width="92" align="center" class="calendar">Monday</th>
								<th width="92" align="center" class="calendar">Tuesday</th>
								<th width="92" align="center" class="calendar">Wednesday</th>
								<th width="92" align="center" class="calendar">Thursday</th>
								<th width="92" align="center" class="calendar">Friday</th>
								<th width="92" align="center" class="calendar">Saturday</th>
							</tr>
							<tr class="calendar">
								<?
									$currentcol = 0;

									// lead in blank days
									for ($i = 0; $i < $this->blankleadindays; ++$i)
									{
										?><td class="calendargrey">&nbsp;</td><?
										++$currentcol;
										if ($currentcol > 6)
										{
											?></tr><tr class="calendar"><?
											$currentcol = 0;
										}
									}

									// days of month
									for ($i = 0; $i < $this->daysinmonth; ++$i)
									{
										?><td class="calendar"><?=($i+1)?><?

										$daylinks = $this->daylinks[$i+1];
										if ($daylinks)
										{
											reset($daylinks);
											while (list($k, $v) = each($daylinks))
											{
												?><br />&nbsp;<br /><a title="<?=$v->linktext?>" href="<?=$v->url?>"><?=$v->linktext?></a><?
											}
										}
										else
										{
											?>
												<br />
												<br />
												<br />
											<?
										}

										?></td><?

										++$currentcol;
										if ($currentcol > 6)
										{
											?></tr><tr class="calendar"><?
											$currentcol = 0;
										}
									}

									// lead out blank days
									if ($currentcol > 0)
									{
										for ($i = $currentcol; $i < 7; ++$i)
										{
											?><td class="calendargrey">&nbsp;</td><?
										}
									}	
								?>
							</tr>
						<table>
					</td>
				</tr>
			</table>
		<?





		return $rc;
	}
}
?>
