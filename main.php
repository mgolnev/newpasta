
<html>

<head>
 <title>Pasta Chief - заказ еды на дом, доставка италь€нской еды на дом в ¬олгограде, заказать еду онлайн, доставка еды на дом, заказать еду, доставка пасты на дом</title>
<link rel="shortcut icon" href="index_files/favicon.ico"type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=cyrillic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="cart.css">
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/cart.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<?php

require_once("mysql.php");

function top($title = "ѕаста"){
    
    $out = "";
    $out.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\"><html lang=\"en\">";
    $out.= "<head><meta http-equiv=\"content-type\" content=\"text/html\" charset=utf-8\">";
    $out.= "<title>$title</title>";
    $out.= "<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\"></head><body>";
    
    
    $out.= "<div id=holder><div id=content><div id=page>";
    $out.= "<img src=img/header.png><br>";
    $out.= "<img src=img/slideshow.png><br>";
    $out.= "<br>";
    $out.= "";
    $out.= "";
    $out.= "";
    
    return $out;
}

function bottom() {
    
       $out = "";
   
    $out.= "";
    $out.= "";
    $out.= "";
    $out.= "</div><div class=footer>";
    $out.= "<img src=img/footer.png>";
    $out.= "</div>";
    $out.= "</div></div>";
    $out.= "</body></html>";
    
    return $out;
}

