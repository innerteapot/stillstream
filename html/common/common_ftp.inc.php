<?
	// -----------------------------------------------------------------------------------
	function ftpGetConnection($servername, $username, $pwd)
	{
		// connect to server
		$ftph = ftp_connect($servername);
		if ($ftph)
		{
			// login
			sleep(5);
			$login = ftp_login($ftph, $username, $pwd);
			if ($login)
			{
				// ensure passive mode is ON
				sleep(4);
				ftp_pasv($ftph, true);
				sleep(1);
				return $ftph;
			}
			else
			{
				print "error: unable to login to ftp server:[$servername]\n";
				return null;
			}
		}
		else
		{
			print "error: unable to connect to ftp server:[$servername]\n";
			return null;
		}
	}

	// -----------------------------------------------------------------------------------
	function ftpCloseConnection($ftph)
	{
		sleep(1);
		ftp_close($ftph);
	}

	// -----------------------------------------------------------------------------------
	function ftpDeleteFile($ftph, $filename)
	{
		sleep(1);
		return ftp_delete($ftph, $filename);
	}

	// -----------------------------------------------------------------------------------
	function ftpGetFolderListingWithExtension($folder, $ext, $servername, $username, $pwd)
	{
		$rc = false;

		// connect to server
		$ftph = ftpGetConnection($servername, $username, $pwd);
		if ($ftph)
		{
			// change to the directory
			ftp_chdir($ftph, $folder);

			// get the directory listing
			$nlist = ftp_nlist($ftph, ".");
			if ($nlist === false)
			{
				print "error: unable to retrieve ftp directory listing on server:[$servername] for folder:[$folder]\n";
				$rc = false;
			}
			else
			{
				$rc = array();
				while (list($k, $v) = each($nlist))
				{
					if (strendswith($v, $ext))
					{
						$pos = strrpos($v, '/');
						if ($pos !== false)
						{
							$v = trim(substr($v, $pos + 1));
						}
						$rc[] = $v;
					}
				}
			}
			ftpCloseConnection($ftph);
		}
		else
		{
			$rc = false;
		}

		return $rc;
	}

	// -----------------------------------------------------------------------------------
	function ftpFileToServer($sourcefile, $targetfile, $servername, $username, $pwd,
									 $skipchmod = false, $usetmpfile = false, $tmpfile = null)
	{
		$rc = false;

		// connect to server
		$ftph = ftp_connect($servername);
		if ($ftph)
		{
			// login
			sleep(5);
			$login = ftp_login($ftph, $username, $pwd);
			if ($login)
			{
				// ensure passive mode is ON then send the file
				sleep(4);
				ftp_pasv($ftph, true);
				sleep(1);
				if ($usetmpfile)
				{
					$upload = ftp_put($ftph, $tmpfile, $sourcefile, FTP_BINARY);
				}
				else
				{
					$upload = ftp_put($ftph, $targetfile, $sourcefile, FTP_BINARY);
				}
				if ($upload)
				{
					if ($usetmpfile)
					{
						sleep(1);
						ftp_rename($ftph, $tmpfile, $targetfile);
					}

					if ($skipchmod)
					{
						$rc = true;
					}
					else
					{
						// ensure file permissions are correct
						sleep(3);
						if (!ftp_chmod($ftph, 0666, $targetfile))
						{
							print "error: failure updating file permission for:[$targetfilename]\n";
							$rc = false;
						}
						else
						{
							$rc = true;
						}
					}
				}
				else
				{
					print "error: failure transferring file:[$sourcefile][$targetfile]\n";
					$rc = false;
				}
			}
			else
			{
				print "error: unable to login to ftp server:[$servername]\n";
				$rc = false;
			}

			sleep(1);
			ftp_close($ftph);
		}
		else
		{
			print "error: unable to connect to ftp server:[$servername]\n";
			$rc = false;
		}

		return $rc;
	}

	// -----------------------------------------------------------------------------------
	function ftpFileToServerWithRetries($retries, $sourcefile, $targetfile, $servername, $username, $pwd,
					$skipchmod = false, $usetmpfile = false, $tmpfile = null)
	{
		$trycount = 0;
		while (true)
		{
			++$trycount;
			if ($trycount >= $retries)
			{
				return false;
			}
			else
			{
				$rc = ftpFileToServer($sourcefile, $targetfile, $servername, $username, $pwd,
							$skipchmod, $usetmpfile, $tmpfile);
				if ($rc)
				{
					return $rc;
				}
				else
				{
					print "--- ack, an ftp error, try it again ...\n";
				}
			}
		}
	}

	// -----------------------------------------------------------------------------------
	function uploadMP3ToRepository($fullpathtoupload)
	{
		// sanity check
		if (!file_exists($fullpathtoupload))
		{
			print "error: file to upload cannot be located:[$fullpathtoupload]\n";
			return false;
		}

		// split out the filename and get the file size
		$filename = basename($fullpathtoupload);
		$filesize = filesize($fullpathtoupload);

		// sftp the file up to the /tmp folder
		if (ftpFileToServerWithRetries(3, $fullpathtoupload, '/tmp/' . $filename,
					SERVER_NAME, SERVER_FTP_USER_NAME, SERVER_FTP_PASSWORD))
		{
			// finally, register the upload with the database
			return callRepoReceiveUpload($filename, $filesize);
		}
		else
		{
			return false;
		}
	}
?>
