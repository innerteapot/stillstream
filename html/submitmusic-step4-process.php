<?
	include('common/common.inc.php');

    function doSaveSubmission($db, $fullname, $artistname, $url, $addr1, $addr2, $city, $stateprov, $zip, $country, $email, $phone)
	{
        $fullname = addslashes($fullname);
        $artistname = addslashes($artistname);
        $url = addslashes($url);
        $addr1 = addslashes($addr1);
        $addr2 = addslashes($addr2);
        $city = addslashes($city);
        $stateprov = addslashes($stateprov);
        $zip = addslashes($zip);
        $country = addslashes($country);
        $email = addslashes($email);
        $phone = addslashes($phone);

		$sql = "INSERT INTO `submissions` (full_name,  artist_name,  url,  address1,  address2,  city,  
                                           state_prov,  zip,  country,  email,  phone)
				  VALUES ('$fullname', '$artistname', '$url', '$addr1', '$addr2', '$city', '$stateprov', 
                          '$zip', '$country', '$email', '$phone')";
		mysql_query($sql, $db);
		if (mysql_affected_rows($db) == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	function doEmailNotify($fullname, $artistname, $url, $addr1, $addr2, $city, $stateprov, $zip, $country, $email, $phone)
	{
		$msg = "An artist has digitally signed the StillStream agreement.\n\n" .
			"Full Name: [$fullname]\n" .
			"Artist Name: [$artistname]\n" .
			"URL: [$url]\n" .
			"Addr1: [$addr1]\n" .
			"Addr2: [$addr2]\n" .
			"City: [$city]\n" .
			"State: [$stateprov]\n" .
			"Zip: [$zip]\n" .
			"Country: [$country]\n" .
			"Email: [$email]\n" .
			"Phone: [$phone]\n" .
			"Agreement Version: [" . CURRENT_ARTIST_AGREEMENT_VERION . "]\n\n" .
			"REMEMBER - artist is not in the database automatically any more - you must add them BY HAND.";
		notifyStaff("An artist has signed the StillStream agreement", $msg);
	}
	
	if (isDefined($fullname) && isDefined($artistname) && isDefined($addr1) && isDefined($city) && isDefined($stateprov) &&
	    isDefined($zip) && isDefined($country) && isDefined($email) && isDefined($phone) && isDefined($url))
	{
		// make sure the url is full
		$url = fullyQualifyURL($url);

		// make sure the addr2 has a value
		if (!isDefined($addr2))
		{
			$addr2 = '';
		}

		// notify the artist
		$msg = "Thank you for signing the StillStream artist agreement.  You signed version " .
			CURRENT_ARTIST_AGREEMENT_VERION . " of the agreement, which can be viewed at any" .
			"time at the following URL:\n\n" .
			"http://stillstream.com/artistagreement.php?rev=" . CURRENT_ARTIST_AGREEMENT_VERION . "\n\n" .
			"If you would ever like to terminate this agreement, you can do so simply by " .
			"contacting us through the contact form on our web site.\n\n" .
			"Here's what the next steps are.\n\n" .
			"First, we will look through our library and see if we already have music from you that we can " .
			"consider for airplay. Any music we already have will automatically be queued up for airplay " .
			"consideration.\n\n" .
			"Second, we also encourage you to send in music to us, since it is very likely there is music you " .
			"have released that we do not already have. There are several ways you can send music in, either " .
			"electronically or via snail mail.\n\n" .
			"If you would like to mail one or more CDs in to us, please send them to:\n\n" .
			"Joe McMahon\n" .
			"StillStream.com\n" .
			"108 Shorebird Circle\n" .
			"Redwood Shores, CA 75035\n" .
			"USA\n\n" .
			"Hand-scrawled CDRs are fine with us, so long as we can make out the artist name, release name, " .
			"label name, release date, and all of the track names. Of course, retail-ready CDs are also " .
			"acceptable, we're not picky.\n\n" .
			"If you would prefer we download music rather than send in a CD or CDR, please use our contact " .
			"form to email us the URL(s) from which you want us to download. Please be sure to mention you just " .
			"signed our agreement and so you are a new artist. Also please bear in mind that we prefer high " .
			"resolution audio over lower resolution, so the ideal download formats are lossless audio (WAV, " .
			"AIFF, FLAC, APE, etc.). If you want us to download MP3 or OGG or similar lossless audio, that is " .
			"acceptable, but it needs to be in the highest resolution you have available, preferably 256Kbps " .
			"or above.\n\n" .
			"If you want to send us audio files electronically, please do not email them to us directly, as our " .
			"mail server will reject large attachments. Instead, we would suggest using any one of the many free " .
			"file transfer services such as You Send It, SendSpace, or similar sites. Please note we must be able " .
			"to download your submission without having to establish an account, or we will not be able to download " .
			"it. Please send such submissions to the following email address:\n\n" .
			"joe.mcmahon@gmail.com\n\n" .
                        "A note: at present we are dealing with an ongoing lack of space on our server. We are working on making " .
                        "sure that new music makes it into rotation as soon as possible, but it now takes longer because we have " .
                        "to manually rotate new music in. We will listen to and get your music into play as soon as we can.\n\n" .
			"Again, thank you for supporting StillStream!\n\n" .
			"Joe McMahon\n" .
			"StillStream.com";
		emailTo($email, "Thank you for signing the StillStream Artist Agreement", $msg);
					
		// notify me
		doEmailNotify($fullname, $artistname, $url, $addr1, $addr2, $city, $stateprov, $zip, $country, $email, $phone);
    	doSaveSubmission($db, $fullname, $artistname, $url, $addr1, $addr2, $city, $stateprov, $zip, $country, $email, $phone);
        $url = "submitmusic-step5.php";
	}
	else
	{
		$url = "submitmusic-step4.php?fn=$fullname&msg=Sorry+but+you+are+missing+one+or+more+required+fields.+Please+try+again.";
	}

	sendRedirect($url);
?>
