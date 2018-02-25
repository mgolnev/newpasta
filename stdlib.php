<?php



function addq1($str) {
    
    $str = str_replace("\\","\\\\",$str);
    $str = str_replace("'","\\'",$str);
    return $str;
}


function addq2($str) {
    
    $str = str_replace("\\","\\\\",$str);
    $str = str_replace("\"","\\\"",$str);
    $str = str_replace("`","\\`",$str);
    return $str;
}

function get_mid($src,$c1,$c2) {
    
    $first = mb_strpos($src,$c1,0,"utf-8");
    
    if ($first!==false) {
	
	$first +=  mb_strlen($c1,"utf-8");
	$last = mb_strpos($src,$c2,$first,"utf-8");

	if ($last!==false) {
	    
	    return mb_substr($src,$first,$last - $first,"utf-8");
	}
	
    }
    
    return NULL;
    
}

function get_midr($src,$c1,$c2) {
    
    $first = mb_strpos($src,$c1,0,"utf-8");
    
    if ($first!==false) {
	
	$first +=  mb_strlen($c1,"utf-8");
	$last = mb_strrpos($src,$c2,$first,"utf-8");

	if ($last!==false) {
	    
	    return mb_substr($src,$first,$last - $first,"utf-8");
	}
	
    }
    
    return NULL;
    
}

function get_right($src,$c1) {
    
    $first = mb_strpos($src,$c1,0,"utf-8");
    
    if ($first!==false) {
    
	    $first +=  mb_strlen($c1,"utf-8");
	    return mb_substr($src,$first,9999999999,"utf-8");
	
    }
    
    return NULL;
    
}

function get_rightr($src,$c1) {
    
    $first = mb_strrpos($src,$c1,0,"utf-8");
    
    if ($first!==false) {
    
	    $first +=  mb_strlen($c1,"utf-8");
	    return mb_substr($src,$first,9999999999,"utf-8");
	
    }
    
    return NULL;
    
}

function get_left($src,$c1) {
    
    $first = mb_strpos($src,$c1,0,"utf-8");
    
    if ($first!==false) {
    
	    
	    return mb_substr($src,0,$first,"utf-8");
	
    }
    
    return NULL;
    
}





?>