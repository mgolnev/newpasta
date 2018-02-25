<?php


require_once("../libpastadb.php");




if (isset($_GET['order'])) {
    
        $ohash = $_GET['order'];
    
   
    echo gen_check($ohash);
    
    
    
}

?>