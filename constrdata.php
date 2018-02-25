<?php


require_once("libpastadb.php");

 $ath = mysqli_query($db,"SELECT  `cihash` , `ciname` , `ciimage` , `cidesc` , `ciprice` , `cimass` , `cicat` FROM ps_constr WHERE vis = 1;");

 $constr = array();
 while ($c = mysqli_fetch_array($ath,MYSQL_ASSOC)) {

    $constr[$c['cicat']][] = $c;

 }

 echo json_encode(array("constr"=>$constr))

?>
