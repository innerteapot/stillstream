<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);
?>	

<h1>Submissions - Completed</h1>
<p>
	Thank you so much for giving StillStream permission to freely play your music. Here's what the next steps are.
</p>
<p>
	First, we will look through our library and see if we already have music from you
	that we can consider for airplay. Any music we already have will automatically be queued up for airplay
	consideration.
</p>
<p>
	Second, we also encourage you to send in music to us, since it is very likely there is music you have released
	that we do not already have. If you want to know what music we already have, if any, please
	<a title="How To Reach Us" href="contact.php">contact us</a>.
</p>

<p>
	For folks who have signed our agreement, we accept submissions either by download or by snail mail. Either
	way works fine for us, as long as the audio is encoded properly (see below). If you would like to submit via
	download, please just send us the URL to download from and we'll take it from there. Free download services
	like yousendit.com and sendspace.com are acceptable, as long as we are not required to establish an account
	in order to download.
</p>
<p>
	If you send in one or more discs, please note that we do not require your submission to be retail-ready, nor is there any advantage to
	sending us retail-ready product. Hand-scrawled discs are perfectly fine with us, so long as we can clearly make
	out the artist name, release name, label name, release date, and all of the track names. Of course, if you want
	to send in a retail-ready product, that is perfectly fine as well. We're not picky. 
	The discs you send in can either be standard redbook audio CDs (meaning they play in an old-school car stereo),
	or can be data CDs or data DVDs with the audio files on them, whichever you prefer. 
</p>
<p>
	Please note that the audio you send to us needs to be in a lossless format if at all possible, which means
	audio CD, WAV, AIFF, FLAC or APE format.
	Please avoid sending us MP3; when we transcode to our streaming format, the
	quality of the audio will suffer substantially.
</p>
<p>
	Please mail any discs to the following address:<br />
	<br />
	<img src="images/stillstream-address.png" width="181" height="81" border="0">
</p>
<p>
	If you have any questions about how to submit music to us, please use our <a title="How To Reach Us" href="contact.php">contact</a> page. 
</p>
<p>
	Thanks again for supporting StillStream!
</p>

<?
	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
