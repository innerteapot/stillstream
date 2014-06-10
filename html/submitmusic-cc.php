<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);
?>	

<h1>Submissions - Creative Commons</h1>
<p>
	Thank you for releasing your music under a
	<a title="Creative Commons" href="http://creativecommons.org" target="_blank">Creative Commons</a>
	license. To have your music considered for airplay, please use the following
	guidelines. We receive many submissions every week, so if you don't follow
	these guidelines, then we probably won't be able to consider your music for airplay.
</p>
<p>
	Unless we have made prior arrangements with you, StillStream cannot accept
	submissions via download. There is just no way we can keep up with the huge
	and accelerating number of new music downloads available. Therefore, if you
	would like to submit your Creative Commons music to us, you will need to snail
	mail in one or more discs containing the music.
</p>
<p>
	However, please note that we do not require your submission to be retail-ready, nor is there
	any advantage to sending us retail-ready product. Hand-scrawled discs are perfectly
	fine with us, so long as we can clearly make out the artist name, release name, label
	name, release date, and all of the track names. Of course, if you want to send in a
	retail-ready product, that is perfectly fine as well. We're not picky.
</p>
<p>
	Please include a note with your discs that makes clear which Creative Commons license the music
	is being made available under.
</p>
<p>
	The discs you send in can either be standard redbook audio CDs (meaning they play in an
	old-school car stereo), or can be data CDs or data DVDs with the audio files on them,
	whichever you prefer.
</p>
<p>
	The audio on the discs needs to be in a lossless format. Redbook audio CDs are already lossless,
	so we're really talking about data discs. Please do not send us MP3 files; when we transcode
	them to our streaming format, the quality of the audio will suffer substantially. Instead,
	please ensure the audio is in WAV, AIFF, FLAC, APE, or a similar lossless format.
</p>
<p>
	Please mail your CDs to the following address:<br />
	<br />
	<img src="images/stillstream-address.png" width="181" height="81" border="0">
</p>
<p>
	If you have any questions about how to submit music to us, please use our <a title="How To Reach Us" href="contact.php">contact page</a>.
</p>
<p>
	Thanks again for supporting StillStream!
</p>

<?
	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
