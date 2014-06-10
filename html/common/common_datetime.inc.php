<?
	define("IS_DST", true);
	
	define("STILLSTREAM_TIME_ZONE_ST", "CST");
	define("STILLSTREAM_TIME_ZONE_DST", "CDT");

	define("SECONDS_STILLSTREAM_OFFICIAL_TIME_IS_BEHIND_SERVER_TIME", 0 );

	define("SECONDS_IN_24_HOURS", 86400);
	
	define("DATE_FIELD_YEAR", "year");
	define("DATE_FIELD_MONTH", "month");
	define("DATE_FIELD_DAY", "day");
	define("DATE_FIELD_HOUR", "hour");
	define("DATE_FIELD_MINUTE", "minute");
	define("DATE_FIELD_SECOND", "second");

	define("DATE_FORMAT_MONTH_YEAR", "monthyear");
	define("DATE_FORMAT_MM_DD_YYYY", "mmddyyyy");
	define("DATE_FORMAT_FULL_ENGLISH", "fullenglish");
	
	/*************************************************************************************
	 Returns a string containing the official StillStream time zone.
	 *************************************************************************************/
	function officialStillStreamTimeZone()
	{
		if (IS_DST)
		{
			return STILLSTREAM_TIME_ZONE_DST;
		}
		else
		{
			return STILLSTREAM_TIME_ZONE_ST;
		}
	}
	
	/*************************************************************************************
	 Returns a string containing the official StillStream time.
	 *************************************************************************************/
	function officialStillStreamTime()
	{
		$sstime = time() - SECONDS_STILLSTREAM_OFFICIAL_TIME_IS_BEHIND_SERVER_TIME;
		return strftime("%I:%M %p", $sstime) . ' ' . officialStillStreamTimeZone() . ' (' .
			diffOfficialStillStreamTimeFromGMT() . ')';
	}
	
	/*************************************************************************************
	 Returns a string telling how many hours behind GMT StillStream Official Time is.
	 *************************************************************************************/
	function diffOfficialStillStreamTimeFromGMT()
	{
		if (IS_DST)
		{
			return "UTC-5";
		}
		else
		{
			return "UTC-6";
		}
	}
	
	/*************************************************************************************
	 Returns the name of the month in English. 
	 *************************************************************************************/
	function getMonthName($month)
	{
		$month = $month * 1;
		switch ($month)
		{
			case 1:
				return 'January';
			case 2:
				return 'February';
			case 3:
				return 'March';
			case 4:
				return 'April';
			case 5:
				return 'May';
			case 6:
				return 'June';
			case 7:
				return 'July';
			case 8:
				return 'August';
			case 9:
				return 'September';
			case 10:
				return 'October';
			case 11:
				return 'November';
			case 12:
				return 'December';
		}
		return null;
	}
	
	/*************************************************************************************
	 Accepts a MySQL-formatted date variable and returns the specified field. 
	 *************************************************************************************/
	function parseDateValue($datevalue, $fieldconst)
	{
		$rc = NULL;
		$components = explode('-', $datevalue);
		switch ($fieldconst)
		{
			case DATE_FIELD_YEAR:
				$rc = trim($components[0]);
				break;
			case DATE_FIELD_MONTH:
				$rc = trim($components[1]);
				break;
			case DATE_FIELD_DAY:
				$rc = trim($components[2]);
				break;
		}

		// make sure the return value is a number
		$rc = $rc * 1;
		return $rc;
	}

	/*************************************************************************************
	 Accepts a MySQL-formatted time variable and returns the specified field. 
	 *************************************************************************************/
	function parseTimeValue($timevalue, $fieldconst)
	{
		$components = explode(':', trim($timevalue));
		switch ($fieldconst)
		{
			case DATE_FIELD_HOUR:
				return trim($components[0]);
			case DATE_FIELD_MINUTE:
				return trim($components[1]);
			case DATE_FIELD_SECOND:
				return trim($components[2]);
		}
		return null;
	}

	/*************************************************************************************
	 Accepts a MySQL-formatted date variable and returns it in a nice format. 
	 *************************************************************************************/
	function formatDateValue($datevalue, $formatconst)
	{
		// short circuit the 'null' date
		if ($datevalue == '0000-00-00')
		{
			return '';
		}
		
		// get the individual fields
		$xmonth = parseDateValue($datevalue, DATE_FIELD_MONTH);
		$xmonthname = getMonthName($xmonth);
		$xday = parseDateValue($datevalue, DATE_FIELD_DAY);
		$xyear = parseDateValue($datevalue, DATE_FIELD_YEAR);
		
		// now format it
		switch ($formatconst)
		{
			case DATE_FORMAT_MONTH_YEAR:
				return($xmonthname . ', ' . $xyear);
			case DATE_FORMAT_FULL_ENGLISH:
				return($xmonthname . ' ' . $xday . ', ' . $xyear);
			case DATE_FORMAT_MM_DD_YYYY:
				return($xmonth . '-' . $xday . '-' . $xyear);
		}
		return null;
	}

	/*************************************************************************************
	 Formats a MySQL-formatted datetime variable using the PHP formatting EL.
	*************************************************************************************/
	function formatDateTimeValue($dt, $fmt)
	{
		$ts = dateTimeToUnixTimestamp($dt);
		return strftime($fmt, $ts);
	}

	/*************************************************************************************
	 Converts a MySQL-formatted datetime variable into a Unix timestamp. 
	*************************************************************************************/
	function dateTimeToUnixTimestamp($dt)
	{
		// split the datetime into date and time parts
		$components = explode(' ', trim($dt));
		$datecomp = trim($components[0]);
		$timecomp = trim($components[1]);

		// now get the individual fields
		$month = parseDateValue($datecomp, DATE_FIELD_MONTH);
		$day = parseDateValue($datecomp, DATE_FIELD_DAY);
		$year = parseDateValue($datecomp, DATE_FIELD_YEAR);
		$hour = parseTimeValue($timecomp, DATE_FIELD_HOUR);
		$minute = parseTimeValue($timecomp, DATE_FIELD_MINUTE);
		$second = parseTimeValue($timecomp, DATE_FIELD_SECOND);
		
		return mktime($hour, $minute, $second, $month, $day, $year);
	}
 
	/*************************************************************************************
	 Converts a MySQL-formatted date variable into a Unix timestamp. 
	 *************************************************************************************/
	function dateToUnixTimestamp($dt)
	{
		$month = parseDateValue($dt, DATE_FIELD_MONTH);
		$day = parseDateValue($dt, DATE_FIELD_DAY);
		$year = parseDateValue($dt, DATE_FIELD_YEAR);
		return mktime(0, 0, 0, $month, $day, $year);
	}
	
	/*************************************************************************************
	 Converts a MySQL-formatted time variable into a Unix timestamp. 
	 *************************************************************************************/
	function timeToUnixTimestamp($dt, $basemonth, $baseday, $baseyear)
	{
		$hour = parseTimeValue($dt, DATE_FIELD_HOUR);
		$minute = parseTimeValue($dt, DATE_FIELD_MINUTE);
		$second = parseTimeValue($dt, DATE_FIELD_SECOND);
		return mktime($hour, $minute, $second, $basemonth, $baseday, $baseyear);
	}
	
	/*************************************************************************************
	 Converts a MySQL-formatted datetime variable into a MySQL-formatted date variable. 
	 *************************************************************************************/
	function dateTimeToDate($dt)
	{
		// is there a space in it
		$pos = strpos($dt, ' ');
		if ($pos === false)
		{
			// no conversion needed
			return $dt;
		}
		else
		{
			return trim(substr($dt, 0, $pos));
		}
	}
	
	/*************************************************************************************
	 Creates a MySQL-formatted date given the values. 
	 *************************************************************************************/
	function makeMySQLDate($timestamp = null)
	{
		if ($timestamp == null)
		{
			$da = getdate();
		}
		else
		{
			$da = getdate($timestamp);
		}
		return createMySQLDate($da['year'], $da['mon'], $da['mday']);
	}
	
	/*************************************************************************************
	Creates a MySQL-formatted date given the values.
	*************************************************************************************/
	function makeMySQLDateTime($timestamp = null)
	{
		if ($timestamp == null)
		{
			$da = getdate();
		}
		else
		{
			$da = getdate($timestamp);
		}
		
		return createMySQLDateTime($da['year'], $da['mon'], $da['mday'], $da['hours'], $da['minutes'], $da['seconds']);
	}
	
	/*************************************************************************************
	 Returns the current year. 
	 *************************************************************************************/
	function getCurrentYear($da = NULL)
	{
		if ($da == NULL)
		{
			$da = getdate();
		}
		return $da['year'];
	}
	
	/*************************************************************************************
	 Returns the current month. 
	 *************************************************************************************/
	function getCurrentMonth()
	{
		$da = getdate();
		return $da['mon'];
	}
	
	/*************************************************************************************
	 Returns the day of week represented by a Unix timestamp.
	 *************************************************************************************/
	function getDayOfWeekFromTimestamp($ts)
	{
		$da = getdate($ts);
		$wday = $da['wday'];
		switch ($wday)
		{
			case 0:
				return 'sun';
			case 1:
				return 'mon';
			case 2:
				return 'tue';
			case 3:
				return 'wed';
			case 4:
				return 'thu';
			case 5:
				return 'fri';
			case 6:
				return 'sat';
			default:
				return null;
		}
	}
	
	/*************************************************************************************
	 Returns the current day of the week. 
	 *************************************************************************************/
	function getCurrentDayOfWeek()
	{
		return getDayOfWeekFromTimestamp(time() - 60 * 60);
	}
	
	/*************************************************************************************
	 Rewinds the day of week by one, wrapping around at week's beginning.
	 *************************************************************************************/
	function rewindDayOfWeek($dow)
	{
		if ($dow == 'sun')
		{
			return 'sat';
		}
		else if ($dow == 'mon')
		{
			return 'sun';
		}
		else if ($dow == 'tue')
		{
			return 'mon';
		}
		else if ($dow == 'wed')
		{
			return 'tue';
		}
		else if ($dow == 'thu')
		{
			return 'wed';
		}
		else if ($dow == 'fri')
		{
			return 'thu';
		}
		else
		{
			return 'fri';
		}
	}
	
	/*************************************************************************************
	 Advances the day of week by one, wrapping around at week's end.
	 *************************************************************************************/
	function advanceDayOfWeek($dow)
	{
		if ($dow == 'sun')
		{
			return 'mon';
		}
		else if ($dow == 'mon')
		{
			return 'tue';
		}
		else if ($dow == 'tue')
		{
			return 'wed';
		}
		else if ($dow == 'wed')
		{
			return 'thu';
		}
		else if ($dow == 'thu')
		{
			return 'fri';
		}
		else if ($dow == 'fri')
		{
			return 'sat';
		}
		else
		{
			return 'sun';
		}
	}
	
	/*************************************************************************************
	 Returns the current month. 
	 *************************************************************************************/
	function getCurrentDayOfMonth()
	{
		$da = getdate();
		return $da['mday'];
	}
	
	/*************************************************************************************
	 Creates a MySQL-formatted date given the values. 
	 *************************************************************************************/
	function createMySQLDate($year, $month, $day)
	{
		if (strlen($year) == 2)
		{
			$year = '20' . $year;
		}
		if (strlen($month) == 1)
		{
			$month = '0' . $month;
		}
		if (strlen($day) == 1)
		{
			$day = '0' . $day;
		}
		return $year . '-' . $month . '-' . $day; 
	}
	
	/*************************************************************************************
	 Creates a MySQL-formatted time given the values. 
	 *************************************************************************************/
	function createMySQLTime($hour, $minute, $sec)
	{
		if (strlen($hour) == 1)
		{
			$hour = '0' . $hour;
		}
		if (strlen($minute) == 1)
		{
			$minute = '0' . $minute;
		}
		if (strlen($sec) == 1)
		{
			$sec = '0' . $sec;
		}
		return $hour . ':' . $minute . ':' . $sec; 
	}

	/*************************************************************************************
	Creates a MySQL-formatted datetime given the values.
	*************************************************************************************/
	function createMySQLDateTime($year, $month, $day, $hour, $minute, $sec)
	{
		return createMySQLDate($year, $month, $day) . ' ' . createMySQLTime($hour, $minute, $sec);
	}
	
	/*************************************************************************************
	 Determines if the supplied day is a valid day given the month. 
	 *************************************************************************************/
	function getNumberDaysInMonth($month, $year)
	{
		if (isValidDayForMonth(31, $month, $year))
		{
			return 31;
		}
		if (isValidDayForMonth(30, $month, $year))
		{
			return 30;
		}
		if (isValidDayForMonth(29, $month, $year))
		{
			return 29;
		}
		return 28;
	}

	/*************************************************************************************
	 Determines if the supplied day is a valid day given the month. 
	 *************************************************************************************/
	function isValidDayForMonth($day, $month, $year)
	{
		$maxdays = 0;
		switch ($month)
		{
			case 1:
				$maxdays = 31;
				break;
			case 2:
				if (($year % 4) == 0)
				{
					$maxdays = 29;
					if (($year % 100 == 0))
					{
						if (($year % 400 == 0))
						{
							$maxdays = 29;
						}
						else
						{
							$maxdays = 28;
						}
					}
				}
				else
				{
					$maxdays = 28;
				}
				break;
			case 3:
				$maxdays = 31;
				break;
			case 4:
				$maxdays = 30;
				break;
			case 5:
				$maxdays = 31;
				break;
			case 6:
				$maxdays = 30;
				break;
			case 7:
				$maxdays = 31;
				break;
			case 8:
				$maxdays = 31;
				break;
			case 9:
				$maxdays = 30;
				break;
			case 10:
				$maxdays = 31;
				break;
			case 11:
				$maxdays = 30;
				break;
			case 12:
				$maxdays = 31;
				break;
		}

		return (($day > 0) && ($day <= $maxdays));
	}
	
	/*************************************************************************************
	 Determines if the supplied time is a valid parseable MySQL time. 
	 *************************************************************************************/
	function isValidTimeValue($timevalue)
	{
		// the only valid format is HH:MM:SS so make sure the length is right
		if (strlen($timevalue) != 8)
		{
			return false;
		}

		// make sure that there are colons at the right positions
		if ((substr($timevalue, 2, 1) != ':') || (substr($timevalue, 5, 1) != ':'))
		{
			return false;
		}

		$components = explode(':', $timevalue);
		$hour = $components[0];
		$min = $components[1];
		$sec = $components[2];

		if (!is_numeric($hour) || !is_numeric($min) || !is_numeric($sec))
		{
			return false;
		}

		if (($hour < 0) || ($hour > 23) || ($min < 0) || ($min > 59) || ($sec < 0) || ($sec > 59))
		{
			return false;
		}

		return true;
	}

	/*************************************************************************************
	 Determines if the supplied date is a valid parseable MySQL date. 
	 *************************************************************************************/
	function isValidDateValue($datevalue)
	{
		// short circuit for the way MySQL does "null" dates
		if ($datevalue == '0000-00-00')
		{
			return true;
		}

		// heuristic, see if we recognize the month value; if so, it's probably correct
		$month = parseDateValue($datevalue, DATE_FIELD_MONTH);
		if (isset($month) && $month && (strlen($month) > 0))
		{
			if (getMonthName($month))
			{
				// make sure the year is numeric
				$year = parseDateValue($datevalue, DATE_FIELD_YEAR);
				if (isset($year) && $year && (strlen($year) == 4))
				{
					$year = $year * 1.0;
					if (($year > 999) && ($year < 10000))
					{
						// make sure the date is numeric
						$day = parseDateValue($datevalue, DATE_FIELD_DAY);
						if (isset($day) && $day && (strlen($day) > 0))
						{
							$day = $day * 1.0;
							if (($day > 0) && ($day < 32))
							{
								return isValidDayForMonth($day, $month, $year);
							}
						}
					}
				}				
			}
		}
		return false;
	}
	
	/*************************************************************************************
	 Determines if the supplied date is a valid parseable MySQL datetime. 
	 *************************************************************************************/
	function isValidDateTimeValue($dtvalue)
	{
		// short circuit for the way MySQL does "null" dates
		if ($dtvalue == '0000-00-00 00:00:00')
		{
			return true;
		}
		
		// split the datetime into date and time parts
		$components = explode(' ', trim($dtvalue));
		$datecomp = trim($components[0]);
		$timecomp = trim($components[1]);

		if (isValidDateValue($datecomp))
		{
			if (isValidTimeValue($timecomp))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/*************************************************************************************
	 Converts a timestamp in MySQL format into a seconds-since-midnight format.
	 *************************************************************************************/
	function timeToDailyTimestamp($t)
	{
		$hour = parseTimeValue($t, DATE_FIELD_HOUR);
		$minute = parseTimeValue($t, DATE_FIELD_MINUTE);
		$second = parseTimeValue($t, DATE_FIELD_SECOND);
		return ($second) + ($minute * 60) + ($hour * 3600);
	}
	
	/*************************************************************************************
	 Converts a timestamp in seconds-since-midnight format to MySQL format.
	 *************************************************************************************/
	function dailyTimeStampToMySQL($tzdiff)
	{
		// get the hours
		$hours = floor($tzdiff / 3600);
		$remainder = $tzdiff - ($hours * 3600);		
		
		// get the minutes
		$mins = floor($remainder / 60);
		$secs = $remainder - ($mins * 60);

		return createMySQLTime($hours, $mins, $secs);		
	}	
?>
