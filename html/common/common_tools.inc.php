<?
	define("RANDOM_CHARS", "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz");
	
	/*************************************************************************************/
	function removeLeadingZeros($n)
	{
		if ($n == 0)
		{
			return '0';
		}
		$sc = substr($n, 0, 1);
		while ($sc == '0')
		{
			$n = substr($n, 1);
			$sc = substr($n, 0, 1);		
		}
		return $n;
	}

	/*************************************************************************************/
	function strbeginswith($haystack, $needle)
	{
		$haystack = substr($haystack, 0, strlen($needle));
		return ($haystack == $needle);
	}

	/*************************************************************************************/
	function strendswith($s, $e)
	{
		$len = strlen($e);		
		$s1 = strtolower(substr(strrev($s), 0, $len));
		$s2 = strtolower(strrev($e));
		if ($s1 == $s2)
		{
			return true;
		}
		return false;
	}

	/*************************************************************************************/
	function urlIsValid($x)
	{
		if (strlen($x) < 5)
		{
			return false;
		}
		if (substr($x, 0, 7) == 'http://')
		{
			return true;
		}
		return false;
	}

	/*************************************************************************************/
	function phoneNumberIsValid($x)
	{
		// we arbitrarily assume all phone numbers are at least 5 digits
		if (strlen($x) < 5)
		{
			return false;
		}

		// split the string into chars and make sure each one is either a number
		// or a + or a - or a . or a space.
		$arr = str_split($x);
		while (list($k, $v) = each($arr))
		{
			if (is_numeric($v))
			{
				continue;
			}
			if (($v == '-') || ($v == '+') || ($v == '.') || ($v == ' '))
			{
				continue;
			}
			return false;
		}
		return true;
	}

	/*************************************************************************************/
	function debugprint($o)
	{
		if ($o == NULL)
		{
			?><pre>NULL</pre><?
		}
		else
		{
			?><pre><?print_r($o)?></pre><?
		}
	}
	
	/*************************************************************************************/
	function debuglog($prefix, $value)
	{
		$fh = fopen('/var/log/php/php.log', 'a');
		fwrite($fh, $prefix . ":[" . $value . "]\n");
		fclose($fh);
	}

	/*************************************************************************************/
	function fullyQualifyURL($url)
	{
		$u = parse_url($url);

		$rc = '';
		$rc .= ($u['scheme'] ? $u['scheme'] : 'http');
		$rc .= '://';
		$rc .= ($u['user'] ? ($u['user'] . ':') : '');
		$rc .= ($u['pass'] ? $u['pass'] : '');
		$rc .= $u['host'];
		$rc .= ($u['port'] ? (':' . $u['port']) : '');
		$rc .= ($u['path'] ? $u['path'] : '/');
		$rc .= ($u['query'] ? ('?' . $u['query']) : '');
		$rc .= ($u['fragment'] ? ('#' . $u['fragment']) : '');

		return $rc;
	}

	/*************************************************************************************/
	function forceLogin()
	{
		header("Location: login.php");
	}

	/*************************************************************************************/
	function testForFlash($url)
	{
		header("Location: flashcheck.php?url=" . urlencode(trim($url)));
	}

	/*************************************************************************************/
	function randomString($len)
	{
		$str = '';
		while (strlen($str) < $len)
		{
			$str .= substr(RANDOM_CHARS, (rand() % (strlen(RANDOM_CHARS))), 1);
		}
		return($str);
	}

	/*************************************************************************************/
	function formatDollars($f)
	{
		if ($f < 0.0)
		{
			$rc = sprintf("-$ %01.2f", abs($f));
		}
		else
		{
			$rc = sprintf("&nbsp;$ %01.2f", $f);
		}

		return $rc;
	}

	/*************************************************************************************/
	function formatThousands($f)
	{
		return number_format($f, 0);
	}

	/*************************************************************************************/
	function formatDollarsKagi($f)
	{
		return sprintf("%01.2f", $f);
	}

	/*************************************************************************************/
	function guid()
 	{
		return randomString(64);
 	}

	/*************************************************************************************/
	function makeURL($url)
	{
		$url = trim($url);
		if (substr($url, 0, 7) != 'http://')
			$url = "http://$url";
		if (strrev(substr(strrev($url), 0, 1)) != '/')
			$url .= '/';
		return $url;
	}

	/*************************************************************************************/
	function isPageSecured()
	{
		$parts = pathinfo($_SERVER['PHP_SELF']);
		$filename = $parts['basename'];
		
		if (substr($filename, 0, 4) == 'sec-')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*************************************************************************************/
	function isPageAdminSecured()
	{
		$parts = pathinfo($_SERVER['PHP_SELF']);
		$filename = $parts['basename'];
		
		if (substr($filename, 0, 10) == 'sec-admin-')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*************************************************************************************/
	function dumpVarIntoString($x)
	{
		ob_start();
		debugLog($x);
		$rc = ob_get_contents();
		ob_end_clean();
		return trim($rc);
	}

	/*************************************************************************************/
	function trimalpha($x)
	{
		$x = trim($x);
		return $x;
	}
	
	/*************************************************************************************/
	function isDefined($x)
	{
		if ($x == null)
		{
			return false;
		}
		if ($x)
		{
			return true;
		}	
		if (strlen($x) < 1)
		{
			return false;
		}
		return true;
	}

	/*************************************************************************************/
	function loadFilesInFolderWithExtension($folder, $extension)
	{
		// this is the array holding files that match
		$rc = array();

		// try to open the folder
		if (is_dir($folder))
		{
			if ($dh = opendir($folder))
			{
				// now spin thru it looking for files that match the extension
				while (($filename = readdir($dh)) !== false)
				{
					if (strendswith($filename, $extension))
					{
						// we disallow the temp file name
						if ($filename != 'upload.tmp.mp3')
						{
							$rc[] = trim($filename);
						}
					}
				}
				closedir($dh);
			}
		}

		return $rc;
	}

	/*************************************************************************************/
	function determineArrayDifferences($array1, $array2)
	{
		// set up our return data structure
		$rc = new stdClass;
		$rc->in1not2 = array();
		$rc->in2not1 = array();
		
		// ensure arrays are sorted
		sort($array1);
		sort($array2);
		
		// get the first element from each array
		reset($array1);
		reset($array2);
		$a1 = current($array1);  
		$a2 = current($array2);
		
		// now spin til we reach the end of both arrays
		while (true)
		{
			if (($a1 == NULL) && ($a2 == NULL))
			{
				// all done
				break;
			}
			else if (($a1 != NULL) && ($a2 == NULL))
			{
				// the element in a1 is different
				$rc->in1not2[] = $a1;
				$a1 = next($array1);
			}
			else if (($a1 == NULL) && ($a2 != NULL))
			{
				// the element in a2 is different
				$rc->in2not1[] = $a2;
				$a2 = next($array2);
			}
			else if ($a1 < $a2)
			{
				// the element in a1 is different
				$rc->in1not2[] = $a1;
				$a1 = next($array1);
			}
			else if ($a2 < $a1)
			{
				// the element in a2 is different
				$rc->in2not1[] = $a2;
				$a2 = next($array2);
			}
			else
			{
				// they are equal, just move on
				$a1 = next($array1);
				$a2 = next($array2);
			}
		}
		
		return $rc;
	}
	
	/*************************************************************************************/
	function superUserIsLoggedIn()
	{
		if ($_COOKIE[SUPERUSER_COOKIE] != '')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>
