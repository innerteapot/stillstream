<?
	define("NEW_TRACK_AGE_THRESHOLD_SECS", 60 * 60 * 24 * 90);	// the last 90 days
	define("WALLY_REPOSITORY_MAX_SIZE", 30000000000);		// in bytes
	define("MAX_OPTIONAL_FILES_IN_NEW_PLAYLIST", 400);		// number of optional files we handle per batch

	/*************************************************************************************/
	function isLiveShowHappening($currplay)
	{
		$liveshow = ($currplay->show != FEED_NAME);
		return $liveshow;
	}

	/*************************************************************************************/
	function isLivePerformanceHappening($currplay)
	{
		$liveperformance = (strpos(strtolower($currplay->artist_track), LIVE_CONCERT_INDICATOR) !== false);
		return $liveperformance;
	}

	/*************************************************************************************/
	function sortWeeklyEvents($events)
	{
		// go through the list of days
		$rc = array();
		while (list($k, $v) = each($events))
		{
			// add sort keys to the day
			$temp = array();
			while (list($k1, $v1) = each($v))
			{
				$temp[$v1->starttime] = $v1;
			}
			ksort($temp);
			$rc[$k] = $temp;
		}
		return $rc;
	}

	/*************************************************************************************/
	// Returns an array keyed by day of week names (e.g. 'mon', 'tue'...), where each element
	// of the array is an array of objects that represent the events that occur on that day
	// of the week.  Returns null if there was a problem.
	function buildWeeklySchedule($db)
	{
		$allevents = getAllWeeklyEvents($db);
		if ($allevents)
		{
			// build the empty array
			$rc = array('sun' => array(), 'mon' => array(), 'tue' => array(),
							'wed' => array(), 'thu' => array(), 'fri' => array(),
							'sat' => array());

			reset($allevents);
			while (list($k, $v) = each($allevents))
			{
				// add this to the end of the array for the appropriate day of the week
				$arr = $rc[$v->dayofweek];
				$arr[] = $v;
				$rc[$v->dayofweek] = $arr;
			}

			$rc = sortWeeklyEvents($rc);

			return $rc;
		}
		else
		{
			return null;
		}
	}

	/*************************************************************************************/
	function isInDateRange($startdate, $enddate)
	{
		$now = time();
		$start = dateToUnixTimestamp($startdate);
		$end = dateToUnixTimestamp($enddate);
		if (($now >= $start) && ($now <= $end))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*************************************************************************************/
	function resolveAllTrackDetails($db, $artistname, $releasename, $trackname, $catnum, $year, $tracknum, $labelname, $dateplayed = NULL)
	{
		// clean up the artist name
		$artistname = trim(html_entity_decode($artistname));
		$artistname = trim(str_replace('&#x26;', 'and', $artistname));
		$artistname = trim(str_replace('&#x26;', 'and', $artistname));
		$artistname = trim(str_replace('&', 'and', $artistname));

		// fix the grave accent problem
		$artistname = str_replace('`', "'", $artistname);
		$trackname = str_replace('`', "'", $trackname);
		$releasename = str_replace('`', "'", $releasename);
		$labelname = str_replace('`', "'", $labelname);

		// build output object
		$rc = new stdClass();
		$rc->dateplayed = $dateplayed;
		$rc->artist_track = $artistname . ' - ' . $trackname;
		$rc->artistname = $artistname;
		$rc->trackname = $trackname;
		$rc->releasename = $releasename;
		$rc->year = $year;
		$rc->labelname = $labelname;
		$rc->catnum = $catnum;
		$rc->tracknum = $tracknum;
		$rc->artisturl = '';
		$rc->releaseurl = '';
		$rc->labelurl = '';
		$rc->trackurl = '';
		$rc->show = 'StillStream.com';
		$rc->showurl = '';
		$rc->host = '';
		$rc->hosturl = '';
		$rc->artistid = 0;
		$rc->trackid = 0;
		$rc->releaseid = 0;
		$rc->labelid = 0;
		$rc->thumbnail_image = '';
		$rc->artist_max_playlist_count = 0;
		$rc->release_excluded = false;
		$rc->track_excluded = false;

		// we prefer catnum because it is reliable
		if (isDefined($catnum))
		{
			$release = getReleaseByCatnum($db, $catnum);
			if (isDefined($release))
			{
				$artist = getArtistForReleaseAndArtistName($db, $release->catnum, $artistname);
				if ($artist)
				{
					// sanity check to ensure we found the right artist
					if (strtolower($rc->artistname) == strtolower($artist->name))
					{
						$track = getTrackByTrackNameReleaseIdAndArtistId($db, $trackname, $release->id, $artist->id);
						if ($track)
						{
							$rc->releasename = $release->title;
							$rc->releaseurl = $release->releaseurl;
							$rc->releaseid = $release->id;
							$rc->year = $release->year;
							$rc->catnum = $release->catnum;
							$rc->trackurl = $rc->releaseurl;
							$rc->thumbnail_image = $release->thumbnail_image;
							$rc->artistname = $artist->name;
							$rc->artistid = $artist->id;
							$rc->artisturl = $artist->url;
							$rc->trackname = $track->title;
							$rc->trackid = $track->id;
							$rc->tracknum = $track->seqnum;
							$rc->artist_track = $artist->name . ' - ' . $track->title;
							$rc->artist_max_playlist_count = $artist->max_playlist_count;
							$rc->release_excluded = ($release->exclude_from_playlist == 'yes' ? true : false);
							$rc->track_excluded = ($track->exclude_from_playlist == 'yes' ? true : false);

							// track the label down by name
							$label = getLabelByName($db, $labelname);
							if ($label)
							{
								$rc->labelname = $label->name;
								$rc->labelurl = $label->labelurl;
								$rc->labelid = $label->id;
							}
						}
					}
				}
			}
		}
		else
		{
			// no catnum, let's try it by name, get the artist first, by name
			$artist = getArtistByName($db, $artistname);
			if ($artist)
			{
				$release = getAlbumByAlbumName($db, $releasename, $artist->id);
				if ($release)
				{
					$track = getTrackByTrackNameReleaseIdAndArtistId($db, $trackname, $release->id, $artist->id);
					if ($track)
					{
						$rc->releasename = $release->title;
						$rc->releaseurl = $release->releaseurl;
						$rc->releaseid = $release->id;
						$rc->year = $release->year;
						$rc->catnum = $release->catnum;
						$rc->trackurl = $rc->releaseurl;
						$rc->thumbnail_image = $release->thumbnail_image;
						$rc->artistname = $artist->name;
						$rc->artistid = $artist->id;
						$rc->artisturl = $artist->url;
						$rc->trackname = $track->title;
						$rc->trackid = $track->id;
						$rc->tracknum = $track->seqnum;
						$rc->artist_track = $artist->name . ' - ' . $track->title;
						$rc->artist_max_playlist_count = $artist->max_playlist_count;
						$rc->release_excluded = ($release->exclude_from_playlist == 'yes' ? true : false);
						$rc->track_excluded = ($track->exclude_from_playlist == 'yes' ? true : false);

						// track the label down by name
						$label = getLabelByName($db, $labelname);
						if ($label)
						{
							$rc->labelname = $label->name;
							$rc->labelurl = $label->labelurl;
							$rc->labelid = $label->id;
						}
					}
				}
			}
		}

		// update current show info
		$show = getCurrentShow($db);
		if ($show)
		{
			$rc->show = $show->name;

			if ($rc->show == FEED_NAME)
			{
					$rc->host = FEED_HOST;
			}
			else
			{
				$showevent = getWeeklyEventForName($db, $rc->show);
				if ($showevent)
				{
					$rc->showurl = $showevent->url;
					$host = getHost($db, $showevent->host_id);
					if ($host)
					{
						$rc->host = $host->name;
					}
				}
			}
		}

		if ($rc->tracknum == '')
		{
			$rc->tracknum = 0;
		}

		return $rc;
	}

	/*************************************************************************************/
	function parseFilename($fn)
	{
		$rc = new StdClass;

		$f = explode(' - ', trim($fn));
		$c = count($f);
		if ($c == 1)
		{
			$fn = trim($fn);
			$pos = strpos($fn, ' ');
			if ($pos === false)
			{
				return NULL;
			}
			else
			{
				$rc->artist = trim(substr($fn, 0, $pos));
				$rc->track = trim(substr($fn, $pos));
				$rc->tracknum = 0;
				return $rc;
			}
		}
		else if ($c == 2)
		{
			$rc->artist = trim($f[0]);
			$rc->track = trim($f[1]);
			$rc->tracknum = 0;
			return $rc;
		}
		else if ($c == 6)
		{
			$rc->artist = trim($f[0]);
			$rc->album = trim($f[1]);
			$rc->label = trim($f[2]);
			$rc->catnum = trim($f[3]);
			$rc->year = trim($f[4]);
			$trackname = trim($f[5]);

			if (strlen($rc->catnum) < 1)
			{
				return NULL;
			}

			$pos = strpos($trackname, '-');
			if ($pos === false)
			{
				return NULL;
			}

			$rc->tracknum = removeLeadingZeros(trim(substr($trackname, 0, $pos)));
			$rc->track = str_replace('.mp3', '', trim(substr($trackname, $pos+1)));

			if (strlen($rc->artist) && strlen($rc->track) &&
				 strlen($rc->label) && strlen($rc->catnum) &&
				 strlen($rc->album) && strlen($rc->tracknum) &&
				 strlen($rc->year))
			{
				return $rc;
			}
			else
			{
				return NULL;
			}
		}
		else if ($c >= 2)
		{
			// not one of our canonical formats, try to guess it
			$rc->artist = trim($f[0]);
			$rc->track = trim($f[1]);
			$rc->tracknum = 0;

			$pos = strpos($rc->artist, '.');
			if ($pos === false)
			{
				return $rc;
			}
			else
			{
				$frag = trim(substr($rc->artist, 0, $pos));
				if (is_numeric($frag))
				{
					$rc->artist = trim(substr($rc->artist, $pos + 1));
				}
				return $rc;
			}
		}
		else
		{
			return NULL;
		}
	}

	/*************************************************************************************/
	function resolveAllTrackDetailsForFilename($db, $fn)
	{
		// first parse the filename into components
		$fi = parseFilename($fn);
		if ($fi == NULL)
		{
			return NULL;
		}
		else
		{
			// now fill in all the details
			return resolveAllTrackDetails($db, $fi->artist, $fi->album, $fi->track, $fi->catnum, $$fi->year, $fi->tracknum, $fi->label);
		}
	}

	/*************************************************************************************/
	function getSequenceNumberFromUpcomingTracksForRelease($db, $releaseid, $song)
	{
		// find the playlist entry wally's workin on
		$entry = getUpcomingTrackForReleaseId($db, $releaseid, $song);
		if ($entry)
		{
			return $entry->seqnum;
		}
		else
		{
			return 0;
		}
	}

	/*************************************************************************************/
	function getUpcomingTracks($db, $rlimit)
	{
		$plentry = getCurrentPlaylistEntry($db);
		if ($plentry)
		{
			$upcomingtrack = getUpcomingTrackForReleaseId($db, $plentry->releaseid, $plentry->trackname);
			if ($upcomingtrack)
			{
				$tracks = getUpcomingTracksAfterSequenceNumber($db, $upcomingtrack->seqnum, $rlimit);
				if ($tracks)
				{
					$rc = array();
					reset($tracks);
					while (list($k, $v) = each($tracks))
					{
						$details = resolveAllTrackDetails($db, $v->artist, $v->album, $v->song, $v->catnum, $v->year, $v->tracknum, $v->label, NULL);
						$rc[] = $details;
					}

					return $rc;
				}
			}
		}
		return NULL;
	}

	/*************************************************************************************/
	function processLiveShowPlaylistTracks($db, $programinstanceid, $currshow)
	{
		// get the program id we are interested in
		$programinstance = getProgramInstance($db, $programinstanceid);
		if ($programinstance)
		{
			$maxplaylisttrackid = 0;

			// get the track list so far for this program
			$tracks = getTodaysTracksForProgram($db, $currshow->id);
			if ($tracks)
			{
				// find the max playlist track id
				reset($tracks);
				while (list($k, $v) = each($tracks))
				{
					if ($v->playlisttrack_id > $maxplaylisttrackid)
					{
						$maxplaylisttrackid = $v->playlisttrack_id;
					}
				}
			}
			else
			{
				$maxplaylisttrackid = 0;
			}

			// now get the playlisttracks that have been registered recently
			$pltracks = getRecentPlaylistTracksRaw($db, 256);
			if ($pltracks)
			{
				// now add any that are beyond this id
				reset($pltracks);
				while (list($k, $v) = each($pltracks))
				{
					if ($v->program_id == $programinstance->program_id)
					{
						if ($v->id > $maxplaylisttrackid)
						{
							if ($v->album == null || strlen($v->album) < 1)
							{
								// define it
								createProgramInstanceTrack($db, $programinstanceid, $v->id, $v->listing, $v->artist, $v->song, $v->album,
										$v->label, $v->catnum, $v->year, $v->tracknum, $v->dateplayed);
							}
						}
					}
				}
			}
		}
	}

	/*************************************************************************************/
	function processLiveShowPlaylists($db)
	{
		// get info about the current show
		$currshow = getCurrentShow($db);
		if ($currshow)
		{
			// is it wally
			if ($currshow->program_id == FEED_PROGRAM_ID)
			{
				// it is wally, make sure the most recent live show instance is 'closed off'
				forceAllProgramInstancesEnded($db);
			}
			else
			{
				// it's a live show, ensure this instance of this show is defined in the db
				$instanceid = defineProgramInstance($db, $currshow->program_id);
				if ($instanceid)
				{
					processLiveShowPlaylistTracks($db, $instanceid, $currshow);
				}
			}
		}
	}

	/*************************************************************************************/
	function updateRepository_DefineArtist($db, $artistname)
	{
		$artistname = trim($artistname);
		$dbartistname = calculateMetaphone($artistname);
		$artistname = addslashes($artistname);
		$sql = "SELECT artist.*, artist.id as artistid
					FROM `artist`
					WHERE (LOWER(artist.name) = LOWER('$artistname'))
					LIMIT 1 ";
 		$result = mysql_query($sql, $db);
		$row = mysql_fetch_object($result);
		if ($row)
		{
			return $row->artistid;
		}
		else
		{
			$sql = "INSERT INTO `artist` (url, name, name_metaphone, date_added)
				VALUES ('', '$artistname', '$dbartistname', NOW()) ";
			mysql_query($sql, $db);
			return mysql_insert_id($db);
		}
	}

	/*************************************************************************************/
	function updateRepository_DefineLabel($db, $name)
	{
		$name = trim($name);
		$dblabelname = calculateMetaphone($name);
		$name = addslashes($name);
		$sql = "SELECT *, label.id as labelid
					FROM `label`
					WHERE (LOWER(label.name) = LOWER('$name'))
					LIMIT 1 ";
 		$result = mysql_query($sql, $db);
		$row = mysql_fetch_object($result);
		if ($row)
		{
			return $row->labelid;
		}
		else
		{
			$sql = "INSERT INTO `label` (name, name_metaphone, labelurl, date_added)
						VALUES ('$name', '$dblabelname', '', NOW()) ";
			mysql_query($sql, $db);
			return mysql_insert_id($db);
		}
 	}

	/*************************************************************************************/
	function updateRepository_DefineAlbum($db, $title, $year, $catnum, $artistid, $filename)
	{
		$rc = NULL;

		if (strlen($catnum) < 1)
		{
			print "OOPS\n";
			die();
		}

		$dbtitle = calculateMetaphone($title);
		$title = addslashes($title);
		$filename = addslashes($filename);
		$sql = "SELECT *, release.id as releaseid
					FROM `release`
					WHERE (catnum = '$catnum')
					LIMIT 1 ";
 		$result = mysql_query($sql, $db);
		$row = mysql_fetch_object($result);
		if ($row)
		{
			$sql = "UPDATE `release`
						SET catnum = '$catnum',
						title = '$title',
						mp3file = '$filename',
						year = $year
						WHERE id = " . $row->releaseid . "
						LIMIT 1 ";
			mysql_query($sql, $db);
			$rc = $row->releaseid;
		}
		else
		{
			$sql = "INSERT INTO `release` (title, title_metaphone, year, catnum, mp3file, date_added)
						VALUES ('$title', '$dbtitle', $year, '$catnum', '$filename', NOW()) ";
			mysql_query($sql, $db);
			$rc = mysql_insert_id($db);
		}

		$sql = "SELECT *
					FROM `artist_release`
					WHERE (catnum = '$catnum')
					AND (artist_id = $artistid)
					LIMIT 1 ";
 		$result = mysql_query($sql, $db);
		$row = mysql_fetch_object($result);
		if (!$row)
		{
			// make sure the artist is linked to it
			$sql = "INSERT INTO `artist_release` (artist_id, catnum)
						VALUES ($artistid, '$catnum') ";
			mysql_query($sql, $db);
		}

		return $rc;
 	}

	/*************************************************************************************/
	function updateRepository_DefineTrack($db, $title, $seqnum, $artistid, $catnum, $filename, $filesize)
	{
		$release = getReleaseByCatnum($db, $catnum);
		if (!$release)
		{
			print "error: could not locate album for catnum [$catnum]\n";
			die();
		}

		$filename = addslashes(trim($filename));
		$dbtitle = calculateMetaphone($title);
		$title = addslashes($title);
		$sql = "SELECT t.id as trackid
			FROM `track` t
			JOIN `release` r ON (t.release_id = r.id)
			WHERE (t.title = '$title')
			AND (r.catnum = '$catnum')
			LIMIT 1 ";
 		$result = mysql_query($sql, $db);
		$row = mysql_fetch_object($result);
		if ($row)
		{
			$sql = "UPDATE `track`
				SET title = '$title',
				title_metaphone = '$dbtitle',
				seqnum = $seqnum,
				mp3file_name = '$filename',
				mp3file_size = $filesize,
				record_modification = NOW()
				WHERE id = $row->trackid
				LIMIT 1 ";
			mysql_query($sql, $db);
			if (mysql_affected_rows($db) != 1)
			{
				print "error: could not update track info using sql [$sql]\n";
				die();
			}
			return $row->trackid;
		}
		else
		{
			$sql = "INSERT INTO `track` (release_id, artist_id, title, title_metaphone, seqnum, date_added, mp3file_name, mp3file_size)
						VALUES ($release->releaseid, $artistid, '$title', '$dbtitle', $seqnum, NOW(), '$filename', $filesize) ";
			mysql_query($sql, $db);
			if (mysql_affected_rows($db) != 1)
			{
				print "error: could not update track info using sql [$sql]\n";
				die();
			}
			return mysql_insert_id($db);
		}
	}


	/*************************************************************************************/
	function updateRepository_ProcessRepositoryTrack($db, $artist, $album, $label, $track, $tracknum, $catnum, $year, $filename, $filesize)
	{
		if (strlen($artist))
		{
			$artistid = updateRepository_DefineArtist($db, $artist);
			if (strlen($album))
			{
				$albumid = updateRepository_DefineAlbum($db, $album, $year, $catnum, $artistid, $filename);
				if (strlen($track))
				{
					$trackid = updateRepository_DefineTrack($db, $track, $tracknum, $artistid, $catnum, $filename, $filesize);
				}
				else
				{
					print "error: cannot determine track name for [$filename]\n";
					return FALSE;
				}
			}
			else
			{
				print "error: cannot determine release name for [$filename]\n";
				return FALSE;
			}
		}
		else
		{
			print "error: cannot determine artist name for [$filename]\n";
			return FALSE;
		}

		if (strlen($label))
		{
			$labelid = updateRepository_DefineLabel($db, $label, '');
		}

		return TRUE;
	}

	/*************************************************************************************/
	function updateRepository_DoTrackMetaphones($db)
	{
		$allofthem = getResultSetForSQL($db, "SELECT * FROM track");
		while (list($k1, $oneofthem) = each($allofthem))
		{
			// calculate metaphone
			$id = $oneofthem->id;
			$metaname = calculateMetaphone($oneofthem->title);

			// print "Updating metaphone for track [" . $oneofthem->title . "] to [" . $metaname . "] ...\n";

			$sql = "UPDATE `track`
				SET title_metaphone = '$metaname'
				WHERE id = $id
				LIMIT 1";
			mysql_query($sql, $db);
		}
	}

	/*************************************************************************************/
	function updateRepository_DoReleaseMetaphones($db)
	{
		$allofthem = getResultSetForSQL($db, "SELECT * FROM release");
		while (list($k1, $oneofthem) = each($allofthem))
		{
			// calculate metaphone
			$id = $oneofthem->id;
			$metaname = calculateMetaphone($oneofthem->title);

			// print "Updating metaphone for release [" . $oneofthem->title . "] to [" . $metaname . "] ...\n";

			$sql = "UPDATE `release`
				SET title_metaphone = '$metaname'
				WHERE id = $id
				LIMIT 1";
			mysql_query($sql, $db);
		}
	}

	/*************************************************************************************/
	function updateRepository_DoLabelMetaphones($db)
	{
		$allofthem = getResultSetForSQL($db, "SELECT * FROM label");
		while (list($k1, $oneofthem) = each($allofthem))
		{
			// calculate metaphone
			$id = $oneofthem->id;
			$metaname = calculateMetaphone($oneofthem->name);

			// print "Updating metaphone for label [" . $oneofthem->name . "] to [" . $metaname . "] ...\n";

			$sql = "UPDATE `label`
				SET name_metaphone = '$metaname'
				WHERE id = $id
				LIMIT 1";
			mysql_query($sql, $db);
		}
	}

	/*************************************************************************************/
	function updateRepository_DoArtistMetaphones($db)
	{
		// get all artists
		$allartists = getResultSetForSQL($db, "SELECT id as artistid, name as name FROM artist ORDER BY 1");
		while (list($k1, $artist) = each($allartists))
		{
			// calculate metaphone for artist name
			$artistid = $artist->artistid;
			$metaname = calculateMetaphone($artist->name);

			// print "Updating metaphone for artist [" . $artist->name . "] to [" . $metaname . "] ...\n";

			$sql = "UPDATE `artist`
				SET name_metaphone = '$metaname'
				WHERE id = $artistid
				LIMIT 1";
			mysql_query($sql, $db);
		}
	}

	/*************************************************************************************/
	function updateRepository_ProcessMetaphones($db)
	{
		updateRepository_DoArtistMetaphones($db);
		updateRepository_DoLabelMetaphones($db);
		updateRepository_DoReleaseMetaphones($db);
		updateRepository_DoTrackMetaphones($db);
	}

	/*************************************************************************************/
	function getAPICurrentlyPlaying($db)
	{
		// get info about what is currently playing
		$currplay = getCurrentPlaylistEntry($db);
		
		// get the webcam url if there is one
		$webcamurl = null;
		if ($currplay->program_id)
		{
			$currprogram = getProgram($db, $currplay->program_id);
			$webcamurl = $currprogram->webcam_url;
		}
		
		// get the album cover url
		if ($currplay->thumbnail_image)
		{
			$albumcover = 'http://stillstream.com/images/releases/' . $currplay->thumbnail_image;
		}
		else
		{
			$albumcover = 'http://stillstream.com/images/releases/missing_album_cover.jpg';
		}
		

		// build the return object
		$rc = new stdClass();
		$rc->trackname = $currplay->trackname;
		$rc->trackurl = $currplay->trackurl;
		$rc->releasename = $currplay->releasename;
		$rc->releaseurl = $currplay->releaseurl;
		$rc->releasecover = $albumcover;
		$rc->artistname = $currplay->artistname;
		$rc->artisturl = $currplay->artisturl;
		$rc->year = $currplay->year;
		$rc->labelname = $currplay->labelname;
		$rc->labelurl = $currplay->labelurl;
		$rc->tracknum = $currplay->tracknum;
		$rc->catnum = $currplay->catnum;
		$rc->showname = $currplay->show;
		$rc->showurl = $currplay->showurl;
		$rc->showwebcamurl = $webcamurl;
		$rc->showislive = isLiveShowHappening($currplay);
		$rc->concertunderway = isLivePerformanceHappening($currplay);
		$rc->hostname = $currplay->host;
		$rc->hosturl = $currplay->hosturl;
		$rc->listeners = getNumberCurrentListeners($db);
		$rc->listenercountries = getListenerCountryCount($db);
		return $rc;
	}
	/*************************************************************************************/
	function getAPIStreamURL($db)
	{
		// get the stream URL(s)
		$streamurl = 'http://stillstream.com:8500/';
		
		// build the return object
		$rc = new stdClass();
		$rc->streamurl = $streamurl;
		return $rc;
	}
?>
