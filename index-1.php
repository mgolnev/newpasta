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
    
  
</head>
<body>
	<header class="top_header">
		<div class="header_topline">
			<div class="container">
				<div class="col-md-12">
					<div class="row">
						
						
						<div class="soc_buttons">
                        <button class="auth_buttons"><i class="fa fa-user"></i></button>
							<a href="//webdesign-master.ru" target="_blank"><i class="fa fa-vk"></i></a>
							<a href="//webdesign-master.ru" target="_blank"><i class="fa fa-facebook-square"></i></a>
							<a href="//webdesign-master.ru" target="_blank"><i class="fa fa-twitter"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="col-md-12">
				<div class="row">
                					<nav class="maian_mnu clearfix">
						<button class="main_mnu_button hidden-md hidden-lg"><i class="fa fa-bars"></i></button>
						<ul>
							<li class="active"><a href="//webdesign-master.ru" target="_blank">Главная</a></li>
							<li><a href="//webdesign-master.ru" target="_blank">Приложения</a></li>
							<li><a href="//webdesign-master.ru" target="_blank">Портфолио</a></li>
							<li><a href="//webdesign-master.ru" target="_blank">Отзывы</a></li>
						</ul>
						<div class="top_contacts"><i class="fa fa-mobile"></i> 8-800-200-600</div>
					</nav>
                                                           
					<h1> <img src= "img/logo.png" class="logo"/> Доставка итальянской еды</h1>
					<div class="sider_container">
						<div class="next_button"><i class="fa fa-angle-right"></i></div>
						<div class="prev_button"><i class="fa fa-angle-left"></i></div>
						<div class="carousel">
							<div class="slide_item"><a class="fancybox" data-fancybox-group="group" href="img/mo.jpg"><img src="img/mo.jpg" alt="alt" /></a></div>
							<div class="slide_item"><a class="fancybox" data-fancybox-group="group" href="img/ds.jpg"><img src="img/ds.jpg" alt="alt" /></a></div>
							<div class="slide_item"><a class="fancybox" data-fancybox-group="group" href="img/12.jpg"><img src="img/mo.jpg" alt="alt" /></a></div>
							<div class="slide_item"><a class="fancybox" data-fancybox-group="group" href="img/13.jpg"><img src="img/ds.jpg" alt="alt" /></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section class="main_content">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="content-text">
					
<?
include ("mysql.php");
include ("items.php");
              ?>      
                    
                    
				</div>

			</div>
		</div>
	</section>
	<div class="hidden">
		<form id="callback" class="pop_form">
			<h3>Заказать разработку</h3>
			<input type="text" name="name" placeholder="Ваше имя..." required />
			<input type="text" name="phone" placeholder="Ваше телефон..." required />
			<button class="button" type="submit">Заказать</button>
		</form>
	</div>
	<!--[if lt IE 9]>
	<script src="libs/html5shiv/es5-shim.min.js"></script>
	<script src="libs/html5shiv/html5shiv.min.js"></script>
	<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="libs/respond/respond.min.js"></script>
	<![endif]-->
	<script src="libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
	<script src="libs/fancybox/jquery.fancybox.pack.js"></script>
	<script src="libs/waypoints/waypoints-1.6.2.min.js"></script>
	<script src="libs/scrollto/jquery.scrollTo.min.js"></script>
	<script src="libs/owl-carousel/owl.carousel.min.js"></script>
	<script src="libs/countdown/jquery.plugin.js"></script>
	<script src="libs/countdown/jquery.countdown.min.js"></script>
	<script src="libs/countdown/jquery.countdown-ru.js"></script>
	<script src="libs/landing-nav/navigation.js"></script>
	<script src="js/common.js"></script>
	<!-- Yandex.Metrika counter --><!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter25346996 = new Ya.Metrika({id:25346996, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/25346996" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
	<!-- Google Analytics counter --><!-- /Google Analytics counter -->
</body>
</html>