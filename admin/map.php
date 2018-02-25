<?php



header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-type: text/html; charset=utf-8");




echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<head>
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=9\">
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">		<title>Паста - Администратор</title>
		
		<style>
		.links {
		    
		    background: #eeeeee;
		    border-top: dotted black 1px;
		    border-bottom: dotted black 1px;
		    padding: 5px;
		    
		}
		
		.links span {
		    
		    padding: 10px;
		    padding-left: 40px;
		    font-size: 16px;
		    font-family: sans-serif;
		}
		
		.links a {
		    
		    color: black;
		    text-decoration: none;
		}
		.links a:hover {
		    
		    color: blue;
		    
		}
		
table.peertable span {
	padding: 0;
	margin: 0;
	
}


table.peertable {
	
	border-collapse: collapse;
	border-spacing: 2px;
	font-family: sans-serif;
	font-size: 15.5px;
	
	
}


table.peertable tr {
	
	
	empty-cells: show;
	height: 25px;
}

table.peertable tr:hover {
	
	background: #FCFCCB;
}

table.peertable th { 
	background-color: #E3F0FD;
	border: 1px solid #B1D0EF;
	padding: 0px 4px;
}

table.shipped th { 
	background-color: #E3F0F0;
	border: 1px solid #B1D0D0;
	padding: 0px 4px;
}

table.placed th { 
	background-color: #F3E5F5;
	border: 1px solid #D0B0D0;
	padding: 0px 4px;
}

table.peertable td {
	
	
	border: 1px solid #D0D0D0;
	padding: 0px 6px;
	
	
}

table.peertable td a {
	
	
	color: black;
	text-decoration:none;
	
}

table.peertable tr.past {
	
	
	background: #f5f5f5;
}
table.peertable tr.past:hover {
	
	background: #FCFCCB;
}

td select {
    
    font-size: 15px;
    font-family: sans-serif;
}
.hidden {
    
    display: none;
}

		
		</style>
                <script type=\"text/javascript\" src=\"../index_files/js/jquery-1.9.0.min.js\"></script>
		
			</head>
<body lang=\"en\">
";

$links = array(
    "orders.php"     =>    "Заказы",
    "stat.php"       =>    "Статистика",
    "../index.php"   =>    "Сайт",
    "history.php"       =>    "История",
    "constructor.php"       =>    "Конструктор",
    "items.php"       =>    "Блюда",
	"archive.php"       =>    "Невидимые блюда",

);

  echo "<img src=\"logo.png\">";

echo "<div class=\"links\">
		";



foreach ($links as $a=>$b) {

	if (substr($a,0,1)=="#") {

		if (!$admin) continue;
		$a = substr($a,1,999999);
	}
	
	echo "<span><a href=\"$a\">$b</a></span>";

}

echo "</div>";





function addate($time) {
    
    	$lang2 = array(       "lang" => "rus",
                         "minuta" => " минуту",
                         "minuts" => " минуты",
                         "minut" => " минут",
                         "hour" => " час",
                         "hours" => " часа",
                         "hoursov" => " часов",
                         "day" => " день",
                         "days" => " дня",
                         "days2" => " дней",
                         );
	
    
    if (time() - $time < 3600) return ago(time() - $time,"",$lang2);
    if (time() - $time < 24*3600 && date("d",$time) == date("d",time())) return "сегодня в ".date("H:i",$time);
    if (time() - $time < 48*3600 && date("d",$time) == (date("d",time())-1)) return "вчера в ".date("H:i",$time);
    
    
    return date("d.m.Y H:i",$time);
    
    
}

function ago($dtime,$style,$lang) {
    
    
        $agod = abs($dtime);
        
        if ($agod<=3600) { $c = floor($agod/60); $ago =$c.minutes($c,$lang); }
        elseif ($agod<=3600*24){ $c = floor($agod/3600); $ago = $c.hours($c,$lang); }
        else { $c =floor($agod/3600/24); $ago = $c.days($c,$lang); }
        
        if ($dtime>0) return "<span style=\"$style\">$ago</span> назад"; else return "<span style=\"$style\">$ago</span>";
    
}

function minutes($min,$lang) {
    
    if ($lang['lang']=='rus' || $lang['lang']=='rus2') {
        $min = $min % 100;
        $min = ($min > 20) ? $min % 10 : $min % 20;
    
        if ($min==1) return $lang['minuta'];
        if ($min>1 && $min<5) return $lang['minuts'];
        return $lang['minut'];
    } else {
         if ($min==1) return $lang['minuta'];
         return $lang['minuts'];
    }
    
}

function hours($min,$lang) {
    
    if ($lang['lang']=='rus' || $lang['lang']=='rus2') {
        $min = $min % 100;
        $min = ($min > 20) ? $min % 10 : $min % 20;

        if ($min==1) return $lang['hour'];
        if ($min>1 && $min<5) return $lang['hours'];
        return $lang['hoursov'];
    } else {
        if ($min==1) return $lang['hour'];
        return $lang['hours'];
    }
    
}

function days($min,$lang) {
    
    if ($lang['lang']=='rus' || $lang['lang']=='rus2') {
        $min = $min % 100;
        $min = ($min > 20) ? $min % 10 : $min % 20;

        if ($min==1) return $lang['day'];
        if ($min>1 && $min<5) return $lang['days'];
        return $lang['days2'];
    } else {
        if ($min==1) return $lang['day'];
        return $lang['days'];
    }
    
}
?>