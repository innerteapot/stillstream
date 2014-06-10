<?
        include('../common/common.inc.php');
 
        // get the current status object
        $currentStatus = getAPIStreamURL($db);
        
        $json = new Services_JSON();
        echo $json->encode($currentStatus);
?>
