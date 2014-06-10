<?
	include('common/common.inc.php');
	showHeader($db, PG_SUBMISSIONS, -1, false, null, null, $accessible);
?>

<h1>Submissions</h1>

<h2>How We Select Music</h2>
<p>
	StillStream provides a free, non-commercial radio stream for its listeners, as a way to promote
	interest in ambient music as well as provide exposure for ambient artists.
</p>
<p>
	We support all ambient artists, regardless of fame, but like everyone else we have
	only 24 hours in a day. Thus, we cannot possibly play all music we would like to and are
	forced to choose which music will receive airplay and which will not. We base our music selection criteria
	solely on the quality of the music, the quality of the recording and production, and our
	own subjective impressions of the music - as well as the nature and number of tracks we currently
	have programmed. Further, each individual host chooses their own music for their shows.
	Please note that because of this we cannot guarantee that every track submitted will see airplay.
</p>
<p>
	We receive many new albums to consider every week, and because we audition
	every track (a monumental task), there is always a backlog of new music to be considered.
	Sometimes this backlog is larger than at other times, and the order in which we audition music
	out of the pool is substantially random. Therefore, it is impossible to estimate how long it will take for
	us to review a particular track or how long it will be until it sees airplay, and in some cases
	it may be weeks or months. We can guarantee, though, that we will eventually listen to every
	track submitted. Your patience is appreciated.
</p>
<p>
	If we do not play a particular track or tracks on our station, please do not be discouraged
	or assume it means we didn't think the track was any good - it could simply be that it didn't match
	the format of our station or that there simply wasn't room enough for all the tracks
	we wanted to play. However, please do bear in mind that all decisions regarding what
	tracks we will play are in our sole discretion and are final.
</p>

<h2>How We Handle Music Licensing</h2>
<p>
	Under US copyright law, radio stations must generally pay license fees for the privilege of broadcasting music to
	listeners. StillStream is, however, a non-commercial, zero-revenue station. This means we do
	not run advertising nor do we receive any regular revenue stream. In fact, our only cost relief
	comes from the sales of benefit albums that certain artists have donated to StillStream's cause.
	We consistently lose money every month, because the cost of hosting a radio station
	(particularly the bandwidth required) is quite expensive. But we do this because we love
	ambient music and as long as we keep the expense managed it is a sustainable endeavor.
</p>
<p>
	But because we have no revenue stream, we very simply cannot afford to pay commercial license fees.
</p>
<p>
	Therefore, StillStream does not pay license fees or royalties of any kind. For example, we do
	not license music from ASCAP, BMI, SESAC or SoundExchange, or any related entities. Consequently,
	we can legally play music only in the following two scenarios:
</p>
<ol>
	<li>The music is released under the <a title="Creative Commons" href="http://creativecommons.org/" target="_blank">Creative Commons</a> license; or ...<br/>&nbsp;<br/></li>
	<li>StillStream has a license fee waiver on file from the artist/rightsholder of the music</li>
</ol>
<p>
	We strongly support ambient artists and their right to profit by their music, but there is simply
	no way that StillStream could afford to pay commercial license fees. Plus, for the ambient genre
	at least, we believe that radio exposure has meaningful value and so broadcasting music without fee
	is a fair trade, particularly given our zero-revenue, non-commercial nature.
</p>
<p>
	Therefore, if you are an artist seeking to submit music to StillStream for airplay,
	we welcome you, but before we play your music we must ask for either a documented waiver
	of all licensing fees for your music, or some kind of notice that shows the music is
	available under <a title="Creative Commons" href="http://www.creativecommons.org" target="_blank">Creative Commons</a>.
</p>
<p align="center">
	<a title="Submit Creative Commons Music" href="submitmusic-cc.php"><img src="images/submit-cc.png" border="0" width="226" height="66"
		alt="Click here to submit Creative Commons music to StillStream" title="Click here to submit Creative Commons music to StillStream"></a>
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a title="Submit Non Creative Commons Music" href="submitmusic-step1.php"><img src="images/submit-cm.png" border="0" width="226" height="66"
		alt="Click here to submit non Creative Commons music to StillStream" title="Click here to submit non Creative Commons music to StillStream"></a>
</p>
<p>
	If you are unsure which option to choose, click the "Non Creative Commons" link, since that
	gives us proper permission to air your music regardless of your license.
</p>
<?
	showFooter($db, PG_SUBMISSIONS, $accessible);
?>
