<?
	define("PG_NONE", -1);
	define("PG_HOME", 0);
	define("PG_SCHEDULE", 1);
	define("PG_LISTEN", 2);
	define("PG_CHAT", 3);
	define("PG_PLAYLISTS", 4);
	define("PG_ARTISTS", 5);
	define("PG_LINKS", 6);
	define("PG_SUBSCRIBE", 7);
	define("PG_SUBMISSIONS", 8);
	define("PG_CONTACT", 9);
	define("PG_PRIVACY", 10);
	define("PG_LEGAL", 11);
	define("PG_BLOG", 12);
	define("PG_ARCHIVES", 13);
	define("PG_ABOUT", 14);
	define("PG_PROGRAMS", 15);
	define("PG_HOSTS", 16);
	define("PG_RECENTLYPLAYED", 17);
	define("PG_CHARTS", 18);
	define("PG_FEATURES", 19);
	define("PG_RECENTLYADDED", 20);
	define("PG_SOONTOBEPLAYED", 21);
	define("PG_PLAYLIST", 22);
	define("PG_CONTRIBUTING", 23);
	define("PG_ADMIN", 24);
	define("PG_SEARCH", 25);
	define("PG_RSS", 26);
	define("PG_LISTENERSTATS", 26);
	define("PG_PLAYSTATS", 27);
	define("PG_SUPERUSER", 28);
	define("PG_DONATIONS", 29);
	define("PG_MUSIC", 30);
	define("PG_GOODIES", 31);
	define("PG_COMPANY", 32);

	define("MAX_RECENT_TRACKS_STRING", 40);
	define("MAX_NOW_PLAYING_STRING", 32);
	define("MAX_TO_BE_PLAYED_STRING", 40);	

	/*************************************************************************************/
	function browserHasFlash()
	{
		@$flashcookie = $_COOKIE[FLASH_COOKIE];
		if (($flashcookie == null) || ($flashcookie == ''))
		{
			return false;
		}
		if ($flashcookie == HAS_FLASH)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*************************************************************************************/
	function showHeader($db, $thepage, $refreshperiod = -1, $minimal = false, $jsfile = null, $onload = null, $accessible = false)
	{
		// set up an array of background colors for the nav bar
		$bgcolors = array();
		$bgcolors[PG_HOME] = $bgcolors[PG_ARTISTS] = $bgcolors[PG_SUBSCRIBE] =
		$bgcolors[PG_CONTACT] = '#6C6C85';
		$bgcolors[$thepage] = '#9F9FAC';

		// get info about what is currently playing
		$currplay = getCurrentPlaylistEntry($db);
		$specialeventcount = count(getAllCurrentSpecialEvents($db));
		$webcamurl = null;
		if ($currplay->program_id)
		{
			$currprogram = getProgram($db, $currplay->program_id);
			$webcamurl = $currprogram->webcam_url;
		}

		// figure out if we have a live performance and/or live show going on
		$liveshow = isLiveShowHappening($currplay);
		$liveperformance = isLivePerformanceHappening($currplay);		

		if ($onload == null)
		{
			$bodytag = "<body>";
		}
		else
		{
			$bodytag = "<body onload=\"$onload\">";
		}
		
		?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
				<head>
					<title>StillStream.com - your place of solace</title>
			
					<meta http-equiv="content-type" content="text/html;charset=iso-8859-2" />
					<meta http-equiv="cache-control" content="no-cache">
					<meta http-equiv="pragma" content="no-cache">
					<meta name="author" content="Darrell Burgan (www.stillstream.com)" />
					<meta name="description" content="Ambient radio on the internet, free and available all the time.">
					<meta name="keywords" content="ambient music, ambient radio, ambient net radio, ambient internet radio, ambient broadcast, ambient listening, ambient streaming, live ambient, live music, ambient, streaming, radio, net radio, mp3, shoutcast">
					<?
						if ($refreshperiod > 0)
						{
							?><meta http-equiv="refresh" content="<?=$refreshperiod?>"><?
						}
					?>
					
					<link rel="stylesheet" href="default.css" type="text/css" />
					<link rel="shortcut icon" href="favicon.ico" />
					
					<script Language="JavaScript">
					<!--
						function popup(url, name, width, height)
						{
							settings = "toolbar=no,location=no,directories=no,"+
										  "status=no,menubar=no,scrollbars=no,"+
										  "resizable=no,width="+width+",height="+height;
					
							myNewWindow = window.open(url,name,settings);
						}

						function openFlashPlayerDirect()
						{
							// 2012-01-01 : Blue Hell fixed flash player again, this may need to be changed back later
							// window.open('player.direct', 'StillStreamPlayer',
							window.open('http://stillstream.com/~janpunter/_stillstream_player/', 'StillStreamPlayer',
								'width=210,height=180,toolbar=0,resizable=0,location=0,directories=0,status=0,scrollbars=0');
						}

						function openJavaChat()
						{
							window.open('irc', 'StillStreamJavaChat',
								'width=800,height=600,toolbar=0,resizable=1,location=0,directories=0,status=0,scrollbars=1');
						}

						function openMibbitChat()
						{
							window.open('http://embed.mibbit.com/?server=irc.kacked.com&channel=%23stillstream&settings=aed30108d2b3b9326c0fa3e12ad6728f&nick=StillStream????', 'StillStreamWebChat', 'toolbar=0,resizable=1,location=0,directories=0,status=0,scrollbars=1');
						}

						function openWSIRCChat()
						{
							window.open('http://www.wsirc.com/?username=stillstream*****&server=irc.starchat.net%3A6667&channel=%23stillstream&autojoin=true&color=%23C0C0C0&dark=false&auth=A', 'StillStreamWebChat', 'toolbar=0,resizable=1,location=0,directories=0,status=0,scrollbars=1');
						}

						var timeout	= 500;
						var closetimer	= 0;
						var ddmenuitem	= 0;

						function mopen(id)
						{	
							// cancel close timer
							mcancelclosetime();

							// close old layer
							if (ddmenuitem)
							{
								ddmenuitem.style.visibility = 'hidden';
							}

							// get new layer and show it
							ddmenuitem = document.getElementById(id);
							ddmenuitem.style.visibility = 'visible';
						}

						function mclose()
						{
							if (ddmenuitem)
							{
								ddmenuitem.style.visibility = 'hidden';
							}
						}

						function mclosetime()
						{
							closetimer = window.setTimeout(mclose, timeout);
						}

						function mcancelclosetime()
						{
							if (closetimer)
							{
								window.clearTimeout(closetimer);
								closetimer = null;
							}
						}

						document.onclick = mclose;
					//-->
					</script>
					<?
						if ($jsfile != null)
						{
							?>
								<script type="text/javascript" src="<?=$jsfile?>"></script>
							<?
						}
					?>

				<script type="text/javascript">

					var _gaq = _gaq || [];
					_gaq.push(['_setAccount', 'UA-30403414-1']);
					_gaq.push(['_trackPageview']);

					(function() {
						var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
						ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
					})();

				</script>
				</head>
				<?=$bodytag?>
					<div class="content">
						<?
							showLogo($liveperformance, $liveshow, $webcamurl);
						?>
						<div class="main_menu">
							<table width="860" border="0" cellpadding="0" cellspacing="0" align="left">
								<tr>
									<td align="left">
										<ul id="sddm">
											<?
												if ($accessible)
												{
													?>
														<li><a title="Home Page" href="index.php">Home</a></li>
														<li><a title="How To Listen" href="listen.php">Listen</a></li>
														<li><a title="How To Chat" href="chat.php">Chat</a></li>
														<li><a title="About Our Schedule, Programs, and Hosts" href="programmenu.php">Programs</a></li>
														<li><a title="Information About The Music We Play" href="music.php">Music</a></li>
														<li><a title="Miscellaneous Stuff We Think You'll Like" href="goodies.php">More</a></li>
														<li><a title="About Us and Our Policies" href="company.php">About</a></li>
													<?
												}
												else
												{
													?>
														<li>
															<a title="Home Page" href="index.php">Home</a>
														</li>
														<li>
															<a title="Options For Listening" href="#" onmouseover="mopen('m1')" onmouseout="mclosetime()">Listen</a>
															<div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
																<a title="Help With Listening" href="listen.php">Listening Instructions</a>
																<a title="Listen Using Tunein (iPhone/Android)" href="http://tunein.com/radio/Still-Stream-s67028/" target="_blank">Listen Using Tunein (iPhone/Android)</a>
																<a title="Listen Using Our iPhone App" href="http://itunes.apple.com/app/stillstream-radio/id432275832?mt=8" target="_blank">Listen Using Our iPhone App</a>
																<a title="Listen Using Our Flash Player" href="javascript:openFlashPlayerDirect();">Listen Using Our Flash Player</a>
																<a title="Listen Using Winamp" href="listen/winamp.direct.pls">Listen Using Winamp</a>
																<a title="Listen Using iTunes" href="listen/itunes.direct.m3u">Listen Using iTunes</a>
																<a title="Listen Using Real Player" href="listen/realplayer.direct.ram">Listen Using Real Player</a>
																<a title="Listen Using Windows Media Player" href="listen/wmp.direct.asx">Listen Using Windows Media Player</a>
																<a title="Listen Using a Different Player, Requires M3U Support" href="listen/other.direct.m3u">Listen Using a Different Media Player</a>
															</div>
														</li>
														<li>
															<a title="Options For Chatting" href="#" onmouseover="mopen('m2')" onmouseout="mclosetime()">Chat</a>
															<div id="m2" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
																<a title="Chat Using Web Client (Uses Web 2.0, Requires No Java)" href="javascript:openMibbitChat();">Chat Using Web Client</a>
																<a title="Chat Using Java Client (Requires Java)" href="javascript:openJavaChat();">Chat Using Java Client</a>
																<a title="Chat Using Your Client" href="irc.php">Chat Using Your Client</a>
															</div>
														</li>
														<li>
															<a title="Information About Our Schedule, Programs, and Hosts" href="schedule.php" onmouseover="mopen('m3')" onmouseout="mclosetime()">Programs</a>
															<div id="m3" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
																<a title="Special Events and Weekly Program Listings" href="schedule.php">Schedule</a>
																<a title="Details About Our Weekly Programs" href="programs.php">Our Shows</a>
																<a title="Information About Our Hosts" href="hosts.php">Our Hosts</a>
																<a title="Playlists From Our Live Programs" href="playlists.php">Playlists</a>
															</div>
														</li>
														<li>
															<a title="Information About The Music We Play" href="features.php" onmouseover="mopen('m4')" onmouseout="mclosetime()">Music</a>
															<div id="m4" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
																<a title="Featured Artists, Albums, and Releases" href="features.php">Features</a>
																<a title="Listings of The Most-Played Albums" href="charts.php">Charts</a>
																<a title="Listing of All Artists We Play" href="artists.php">Artists</a>
																<a title="Archived Live Performances, All Free Music Downloads" href="archives.php">Archives</a>
																<a title="Search Our Past Playlists By Artist or Track Name" href="search.php">Search</a>
															</div>
														</li>
														<li>
															<a title="Miscellaneous Stuff We Think You'll Like" href="goodies.php" onmouseover="mopen('m6')" onmouseout="mclosetime()">More</a>
															<div id="m6" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
																<a title="StillStream on last.fm" href="http://www.last.fm/user/stillstream" target="_blank">StillStream on last.fm</a>
																<a title="StillStream on Twitter" href="http://twitter.com/stillstreamnews" target="_blank">StillStream on Twitter</a>
																<a title="StillStream on FaceBook" href="http://www.facebook.com/stillstream" target="_blank">StillStream on FaceBook</a>
																<a title="Links" href="links.php">Links</a>
																<a title="Subscribe To Our RSS Feeds" href="rss.php">RSS</a>
															</div>
														</li>
														<li>
															<a title="About Us and Our Policies" href="about.php" onmouseover="mopen('m7')" onmouseout="mclosetime()">About</a>
															<div id="m7" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
																<a title="Our Story" href="about.php">About StillStream</a>
																<a title="How To Reach Us" href="contact.php">Contact Us</a>
																<a title="How To Submit Music For Consideration" href="submissions.php">Submitting Your Music</a>
																<a title="How You Can Support Us" href="contributing.php">Contributing To Us</a>
																<a title="Financial Donations" href="donations.php">Donations</a>
																<a title="Our Privacy Policy" href="privacy.php">Privacy</a>
																<a title="Our Legal Terms and Conditions" href="legal.php">Terms and Conditions</a>
															</div>
														</li>
													<?
												}
											?>
										</ul></td>
									<td align="right"><b>Official StillStream Time:</b> <?=officialStillStreamTime()?></td>
								</tr>
							</table>
							<div style="clear:both"></div>
						</div>
						<?
							if ($accessible)
							{
								// show the current stats section (quite complex)
								showCurrentStats($db, $thepage, $refreshperiod, $currplay, $liveshow);
						
								// show news crawler, if we have any
								$news = getNews($db);
								if ($news !== FALSE)
								{
									?>	
										<div class="news_crawler"><b>News Flash:</b> <?=$news?></div>
									<?
								}
							}
							else if ($minimal)
							{
								?><p>&nbsp;</p><?
							}
							else
							{
								// show the current stats section (quite complex)
								showCurrentStats($db, $thepage, $refreshperiod, $currplay, $liveshow);
						
								// show news crawler, if we have any
								$news = getNews($db);
								if ($news !== FALSE)
								{
									?>	
										<div class="news_crawler"><marquee direction="left" scrollamount="4" width="99%"><b>News Flash:</b> <?=$news?></marquee></div>
									<?
								}
							}
						?>
						
						<div class="user_content_area">
		<?
	}

	/*************************************************************************************/
	function enforceMaxLength($s, $max) 
	{
		if (strlen($s) > $max)
		{
			$s = substr($s, 0, $max - 4) . ' ...';
		}
		return $s;
	}
	
	/*************************************************************************************/
	function showLogo($liveperformance, $liveshow, $webcamurl, $basefolder = null)
	{
		if ($basefolder == null)
		{
			$basefolder = '';
		}
		else
		{
			$basefolder = $basefolder . '/';
		}
		?>
			<div class="logo">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="left" valign="bottom" width="380"><a title="Home Page" href="index.php"><img src="<?=$basefolder?>images/logo.jpg" width="283" height="40" border="0"></a></td>
						<td align="left" valign="bottom">
							<?
								if ($liveperformance)
								{
									if ($webcamurl)
									{
										?>
											<a title="Live Performance Web Cam"
												href="<?=$webcamurl?>" target="_blank"><img src="<?=$basefolder?>images/liveperformancecam.gif" width="148" height="34" border="0"></a>
										<?
									}
									else
									{
										?>
											<img src="<?=$basefolder?>images/liveperformance.gif" width="117" height="34" border="0">
										<?
									}
								}
								else if ($liveshow)
								{
									if ($webcamurl)
									{
										?>
											<a title="Live Show Web Cam"
												href="<?=$webcamurl?>" target="_blank"><img src="<?=$basefolder?>images/liveshowcam.gif" width="149" height="34" border="0"></a>
										<?
									}
									else
									{
										?>
											<img src="<?=$basefolder?>images/liveshow2.gif" width="117" height="34" border="0">
										<?
									}
								}
							?>
						</td>
					</tr>
				</table>
			</div>
		<?
	}
	
	/*************************************************************************************/
	function showCurrentStatsLink($desc, $url, $title, $popupname = '') 
	{
		if (strlen($title) <= 0)
		{
			$title = $desc;
		}

		if (strlen($desc) > 0)
		{
			if (strlen($url) > 0)
			{
				if (strlen($popupname) > 0)
				{
					?><a title="<?=$title?>" href="<?=$url?>" target="<?=$popupname?>"><?=$desc?></a><?
				}
				else
				{
					?><a title="<?=$title?>" href="<?=$url?>"><?=$desc?></a><?
				}
			}
			else
			{
				?><?=$desc?><?
			}
		}
	}
	
	
	/*************************************************************************************/
	function showCurrentStatsLinkBold($desc, $url, $title, $popupname = '') 
	{
		if (strlen($title) <= 0)
		{
			$title = $desc;
		}

		if (strlen($desc) > 0)
		{
			if (strlen($url) > 0)
			{
				if (strlen($popupname) > 0)
				{
					?><a title="<?=$title?>" href="<?=$url?>" target="<?=$popupname?>"><b><?=$desc?></b></a><?
				}
				else
				{
					?><a title="<?=$title?>" href="<?=$url?>"><b><?=$desc?></b></a><?
				}
			}
			else
			{
				?><?=$desc?><?
			}
		}
	}
	
	
	/*************************************************************************************/
	function showCurrentStats($db, $thepage, $refreshperiod, $currplay, $liveshow)
	{
		$seqnum = getSequenceNumberFromUpcomingTracksForRelease($db, $currplay->releaseid, $currplay->trackname);
		if ($seqnum)
		{
			$upcoming = getUpcomingTracksAfterSequenceNumber($db, $seqnum, 4);
		}

		// calculate some stuff
		$tracks = getRecentPlaylistTracks($db, 7);
		$listenerstring = getNumberCurrentListeners($db) . ' people in ' . getListenerCountryCount($db) . ' countries';
		$repositoryinfo = getRepositoryInfo($db);
		$diskused = getTotalTrackMP3FileSize($db) / 1000 / 1000;
		$hoursinrepository = floor(($diskused * SECONDS_PER_MEGABYTE) / 60 / 60);
		$totaltracks = getTableSize($db, 'track');

		?>
			<div class="current_stats">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="155" align="left" valign="middle">
							<?
								if ($currplay && $currplay->thumbnail_image)
								{
									if ($currplay->releaseurl)
									{
										?><a title="<?=stripslashes($currplay->artistname)?> - <?=stripslashes($currplay->releasename)?>"
											href="<?=$currplay->releaseurl?>" target="_blank"><img src="images/releases/<?=$currplay->thumbnail_image?>" width="140" height="140" border="0"></a><?
									}
									else
									{
										?><img src="images/releases/<?=$currplay->thumbnail_image?>" width="140" height="140"><?
									}
								}
								else
								{
									?><img src="images/missing_album_cover.jpg" width="140" height="140"><?
								}
							?>
						</td>
						<td width="283" align="left" valign="top" class="nowplaying">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="middle" align="left" colspan="3" class="nowplaying"><span class="bigtext"><a title="Playlist RSS Feed"
										href="rss/playlist.xml"><img src="images/rss-small.png" border="0" width="10" height="10"
										style="border: 0px; margin-right: 5px;"/></a>On The Air</span><a title="Tracks Recently Played"
										href="recentlyplayed.php"><img src="images/details.png" border="0" width="32" height="11"
										style="border: 0px; margin-left: 6px; vertical-align: middle;"></a></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Program:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($currplay->show), MAX_NOW_PLAYING_STRING), $currplay->showurl, stripslashes($currplay->show), '_blank')?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Host:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($currplay->host), MAX_NOW_PLAYING_STRING), stripslashes($currplay->hosturl), $currplay->host)?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Listeners:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($listenerstring), MAX_NOW_PLAYING_STRING), 'listenerstats.php', stripslashes($listenerstring))?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Artist:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($currplay->artistname), MAX_NOW_PLAYING_STRING), $currplay->artisturl, stripslashes($currplay->artistname), '_blank')?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Track:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($currplay->trackname), MAX_NOW_PLAYING_STRING), $currplay->releaseurl, stripslashes($currplay->trackname), '_blank')?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Album:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($currplay->releasename), MAX_NOW_PLAYING_STRING), $currplay->releaseurl, stripslashes($currplay->releasename), '_blank')?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Released:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?=enforceMaxLength(stripslashes($currplay->year), MAX_NOW_PLAYING_STRING)?></td>
								</tr>
								<tr>
									<td valign="middle" align="left" class="bigger"><b>Label:</b></td>
									<td valign="middle" align="center" class="nowplaying" width="5px">&nbsp;</td>
									<td valign="middle" align="left" class="nowplaying"><?showCurrentStatsLink(enforceMaxLength(stripslashes($currplay->labelname), MAX_NOW_PLAYING_STRING), $currplay->labelurl, stripslashes($currplay->labelname), '_blank')?></td>
								</tr>
							</table>
						</td>
						<td width="5" align="center" valign="middle">&nbsp;</td>
						<td width="230" align="left" valign="top">
							<table border="0" cellspacing="0" cellpadding="0" class="playlist">
								<tr>
									<td valign="top" align="left" class="playlist"><div class="bigtext"><a title="Playlist RSS Feed" 
										href="rss/playlist.xml"><img src="images/rss-small.png" border="0" width="10" height="10"
										style="border: 0px; margin-right: 5px;"></a>Recent Tracks</div><a title="Tracks Recently Played" 
										href="recentlyplayed.php"><img src="images/details.png" border="0" width="32" height="11"
										style="border: 0px; margin-left: 6px; vertical-align: middle;"></a></td>
								</tr>
								
								<?
									if (count($tracks) > 0)
									{
										reset($tracks);
										$counter = 0;
										while (list($k, $track) = each($tracks))
										{
											++$counter;
											if ($counter > 1)
											{
												$dp = strftime("%I:%M %p", dateTimeToUnixTimestamp($track->dateplayed)) . ' ' . officialStillStreamTimeZone();
												
												$thedesc = $dp . ' - ' . $track->artistname . ' - ' . $track->trackname;
												$fulldesc = $thedesc;
												if (strlen($thedesc) >= MAX_RECENT_TRACKS_STRING)
												{
													$thedesc = substr($thedesc, 0, MAX_RECENT_TRACKS_STRING - 4) . ' ...';
												}
												
												$theurl = $track->releaseurl;
												if (strlen($theurl) < 1)
												{
													$theurl = $track->artisturl;
													if (strlen($theurl) < 1)
													{
														$theurl = null;
													}
												}
												
												?>
													<tr>
														<td valign="top" align="left" class="playlist"><?showCurrentStatsLink(stripslashes($thedesc), $theurl, stripslashes($fulldesc), '_blank')?></td> 
													</tr>
												<?
											}
										}										
									}
								?>
								
								<tr>
									<td valign="top" align="left" class="playlist">&nbsp;</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="playlist"><div class="bigtext"><a title="Playlist RSS Feed" 
										href="rss/playlist.xml"><img src="images/rss-small.png" border="0" width="10" height="10"
										style="border: 0px; margin-right: 5px;"/></a>Next Up</div><a title="Tracks Soon To Be Played"
										href="soontobeplayed.php"><img src="images/details.png" border="0" width="32" height="11"
										style="border: 0px; margin-left: 6px; vertical-align: middle;"></a></td>
								</tr>
								
								<?
									if ($seqnum && (count($upcoming) > 0))
									{
										reset($upcoming);
										while (list($k, $track) = each($upcoming))
										{
											$thedesc = $track->artist . ' - ' . $track->song;
											$fulldesc = $thedesc;
											if (strlen($thedesc) >= MAX_TO_BE_PLAYED_STRING)
											{
												$thedesc = substr($thedesc, 0, MAX_TO_BE_PLAYED_STRING - 4) . ' ...';
											}
											
											$theurl = null;
											$release = null;
											if (property_exists($track, "release_id"))
											{
												$release = getAlbum($db, $track->release_id);
											}
											if ($release)
											{
												$theurl = $release->releaseurl;
											}
											else
											{
												$artist = null;
												if (property_exists($track, "artist_id"))
												{
													$artist = getArtistByID($db, $track->artist_id);
												}
												if ($artist)
												{
													$theurl = $artist->url;
												}
											}
											
											?>
												<tr>
													<td valign="top" align="left" class="playlist"><?showCurrentStatsLink(stripslashes($thedesc), $theurl, stripslashes($fulldesc), '_blank')?></td> 
												</tr>
											<?
										}
									}
									else
									{
										?>
											<tr>
												<td valign="top" align="left" class="playlist">(sorry, our time machine is in the shop)</td>
											</tr>
										<?
									}
								?>
							</table>
						</td>
						<td width="10" align="center" valign="middle">&nbsp;</td>
						<td width="160" align="left" valign="top">
							<table border="0" cellspacing="0" cellpadding="0" class="ourlibrary">
								<tr>
									<td valign="top" align="left" class="ourlibrary"><div class="bigtext">Our Library</div><a title="Artists Listing"
										href="artists.php"><img src="images/details.png" border="0" width="32" height="11"
										style="border: 0px; margin-left: 6px; vertical-align: middle;"></a></td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands(getTableSize($db, 'label'))?> labels</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands(getTableSize($db, 'artist'))?> artists</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands(getTableSize($db, 'release'))?> releases</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($totaltracks)?> tracks</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($hoursinrepository)?> hours elapsed</td>
								</tr>								
								
								<?
									$cnewlabels = getRecentlyAddedLabelCount($db);
									$cnewartists = getRecentlyAddedArtistCount($db);
									$cnewalbums = getRecentlyAddedAlbumCount($db);
									$cnewtracks = getRecentlyAddedTrackCount($db);
									
									$chourspertrack = $hoursinrepository / $totaltracks;
									$cnewhours = floor($cnewtracks * $chourspertrack);
								?>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><br /><div class="bigtext">Recently New</div><a title="Music Recently Added"
										href="recentlyadded.php"><img src="images/details.png" border="0" width="32" height="11"
										style="border: 0px; margin-left: 6px; vertical-align: middle;"></a></td>
								</tr>					
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($cnewlabels)?> labels</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($cnewartists)?> artists</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($cnewalbums)?> releases</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($cnewtracks)?> tracks</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="ourlibrary"><?=formatThousands($cnewhours)?> hours elapsed</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		<?			
	}
	
	/*************************************************************************************/
	function showFooter($db, $thepage, $accessible = false)
	{
		$dt = getdate();
		$year = $dt['year'];
		
		if ($accessible)
		{
			$accessibleimg = 'images/accessible.off.png';
			$accessibleurl = 'index.php?accessible=0';
			$accessibletitle = 'Make StillStream Fully Functional For Sighted Users';
		}
		else
		{
			$accessibleimg = 'images/accessible.on.png';
			$accessibleurl = 'index.php?accessible=1';
			$accessibletitle = 'Make StillStream More Accessible To Screen Readers';
		}

		?></div><?
		
		?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="250" class="footer" valign="middle" align="left"><a title="StillStream on Twitter" href="http://twitter.com/stillstreamnews"
						target="_blank"><img src="images/twitter.png" width="81" height="16" border="0" style="margin-right: 7px; margin-bottom: 2px;"></a><a
							title="StillStream on last.fm" href="http://www.last.fm/user/stillstream" target="_blank"><img
								src="images/last.fm.png" width="57" height="20" border="0" style="margin-right: 10px;"></a><a title="StillStream on FaceBook"
									href="http://www.facebook.com/stillstream" target="_blank"><img src="images/facebook.png"
										width="76" height="20" border="0"></a></td>
					<td class="footer" align="center" valign="middle">Copyright &copy; 2005-<?=$year?> StillStream.com. All Rights Reserved.</td>
					<td width="250" class="footer" align="right" valign="middle"><a
						title="<?=$accessibletitle?>" href="<?=$accessibleurl?>"><img src="<?=$accessibleimg?>" border="0" width="77" height="20" /></a>	&nbsp;&nbsp;
						<a href="http://www.addthis.com/bookmark.php?v=250&pub=xa-4a4aa57970dad6cc"
							onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')"
								onmouseout="addthis_close()" onclick="return addthis_sendto()"><img
									src="images/addthis.png" width="83" height="16" alt="Bookmark and Share"
										style="border:0; margin-bottom:2px;"/></a><script type="text/javascript"
											src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a4aa57970dad6cc"></script></td>
				</tr>
			</table>
		</div>
	</body>
</html>
		<?

		// disconnect from database
		@mysql_close($db);
	}

	/*************************************************************************************
	 Shows an option tag, correctly setting the selected as needed.
	*************************************************************************************/
	function showOptionTag($val, $tag, $defaultval = "lk2439080sd9ksdsgdj")
	{
		if ($defaulval == BOGUS_VALUE)
		{
			?>
				<option value="<?=$val?>"><?=$tag?></option>
			<?
		}
		else
		{
			?>
				<option <?=(($defaultval == $val) ? 'selected' : '')?> value="<?=$val?>"><?=$tag?></option>
			<?
		}
	}
	
	/*************************************************************************************
	Sends a redirect header to the browser with the specified url.
	*************************************************************************************/
	function sendRedirect($url)
	{
		$server = trimalpha($_SERVER['HTTP_HOST']);
		$dirname = dirname($_SERVER['PHP_SELF']);
		$dirname = str_replace("\x5C", "/", $dirname);
		$targ =  $server . $dirname;
		
		if (substr(strrev($targ), 0, 1) == '/')
		{
			$targ = $targ . $url;
		}
		else
		{
			$targ = $targ . '/' . $url;
		}
	
		header("Location: http://" . $targ);
	}
?>
