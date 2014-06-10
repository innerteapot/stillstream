<?
	include('/home/stillstream/stillstream.com/html/common/common.inc.php');

	function unfoobar($s)
	{
		$s = str_replace(' ', '', $s);
		$s = str_replace('.', '', $s);
		$s = str_replace('+', '', $s);
		$s = str_replace('-', '', $s);
		$s = str_replace('(', '', $s);
		$s = str_replace(')', '', $s);
		$s = str_replace('/', '', $s);
		$s = str_replace('\x5C', '', $s);
		$s = str_replace('[', '', $s);
		$s = str_replace(']', '', $s);
		$s = str_replace('=', '', $s);
		$s = str_replace(':', '', $s);
		$s = str_replace('\'', '', $s);
		$s = str_replace('"', '', $s);
		$s = str_replace('#', '', $s);
		return $s;
	}


	$doredirect = TRUE;
	$showall = trim($showall);
	
	$counter = 0;
	while (TRUE)
	{
		++$counter;
		
		$varname = 'releaseid' . $counter;
		$releaseid = $$varname;
		
		$varname = 'imgfile' . $counter;
		$imgfile = $$varname;

		$varname = 'artist' . $counter;
		$artist = urldecode($$varname);

		$varname = 'release' . $counter;
		$release = urldecode($$varname);

		if (isDefined($releaseid))
		{
			// ignore any for which an img file is not specified
			if (isDefined($imgfile))
			{
				// create a filename
				$fn = unfoobar($artist) . '-' . unfoobar($release) . '.jpg';
				//print "[$fn]";

				// get the last 4 chars of the file name
				$fext = trim(strtolower(strrev(substr(strrev($imgfile), 0, 4))));

				// what kind of image is it
				if ($fext == '.gif')
				{
					$getscript = 'loadimage-gif';
				}
				else if ($fext == '.png')
				{
					$getscript = 'loadimage-png';
				}
				else
				{
					$getscript = 'loadimage-jpg';
				}

				$cmd = '/home/stillstream/stillstream.com/scripts/' . $getscript . ' "' . $imgfile . '" "' . $fn . '"';
				//print "[$cmd]";
				system($cmd);

				// make sure the file got created
				if (file_exists('/home/stillstream/stillstream.com/html/images/releases/' . $fn))
				{
					if (!updateReleaseThumbnail($db, $releaseid, $fn))
					{
						print "ERROR: could not update thumbnail to [$imgfile] for release id [$releaseid]<br />";
						$doredirect = FALSE;
						break;
					}
				}
				else
				{
						print "ERROR: filename [$fn] was not created!<br />"; 
						$doredirect = FALSE;
						break;
				}
			}
		}
		else
		{
			break;
		}
	}
	
	if ($doredirect)
	{
		sendRedirect("loadcovers.php?showall=$showall");
	}
?>                                                                                                                                               
