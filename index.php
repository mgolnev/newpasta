<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Доставка еды - адаптивный сайт</title>
	<meta name="description" content="Создание адаптивного сайта" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="libs/bootstrap/bootstrap-grid-3.3.1.min.css" />
	<link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
	<link rel="stylesheet" href="libs/countdown/jquery.countdown.css" />
	<link rel="stylesheet" href="css/fonts.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/media.css" />

	<link rel="stylesheet" type="text/css" href="cart.css">
<link href="jquery.mCustomScrollbar.css" rel="stylesheet">


</head>
<body>
  <div id="header_menu">

    </div>
<div class="flexslider">
</div>
<div class="plate-dishes-wrapper">
<?
include ("mysql.php");
include ("items.php");
?>
</div>

<script type="text/javascript" src="jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>
<script type="text/javascript" src="cart.js"></script>
<script type="text/javascript" src="jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>
