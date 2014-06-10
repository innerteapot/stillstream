<?
	include('common/common.inc.php');
	showHeader($db, PG_CHAT, -1, false, null, null, $accessible);
?>

<h1>Chat</h1>

<table border="0" cellpadding="5" cellspacing="5" align="center">
	<tr>
		<td valign="top" align="center"><a title="Chat Using Web Client" href="javascript:openMibbitChat();">Chat Using Web Client</a></td>
		<td valign="top" align="left">Join our chat room using our Web 2.0 client. Requires only a reasonably modern web brower.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Chat Using Java Client" href="javascript:openJavaChat();">Chat Using Java Client</a></td>
		<td valign="top" align="left">Join our chat room using our Java client. Requires the Java plugin to be installed in your browser.</td>
	</tr>
	<tr>
		<td valign="top" align="center"><a title="Chat Using Your Client" href="irc.php">Chat Using Your Client</a></td>
		<td valign="top" align="left">Join our chat room using a native IRC client. Instructions can be found on the following page.</td>
	</tr>
</table>

<?
	showFooter($db, PG_CHAT, $accessible);
?>
