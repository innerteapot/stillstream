<?
	include('../common/common.inc.php');
 
	// get the current status object
	$currentStatus = getAPICurrentlyPlaying($db);
	
	// convert the output to json
	// echo json_encode($currentStatus);

	$json = new Services_JSON();
	echo $json->encode($currentStatus);
?>
