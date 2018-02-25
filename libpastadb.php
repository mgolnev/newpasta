<?php

require_once("mysql.php");
require_once("stdlib.php");



date_default_timezone_set('Etc/GMT-4');




$categories = array(1 =>"Паста",
		    2 =>"Соус",
		    3 =>"Начинка",
		    4 =>"Добавка",);




function get_raj_id($raj) {
	$ath = mysqli_query($db,"SELECT rid FROM ps_rajs WHERE rname = '".addq1($raj)."';");

	if (mysqli_num_rows($ath)>0) return mysqli_result($raj);

	else return $raj;

}

function get_item_id($item) {

        if (is_array($item)) {
            if (!isset($item['name'])) return 0;
            $name = $item['name'];
        } else $name = $item;


	$ath = mysqli_query($db,"SELECT iid FROM ps_items WHERE name = '".addq1($name)."';");

	if (mysqli_num_rows($ath)>0) return mysqli_result($ath,0);

        if (is_array($item) && isset($item['name'])  && isset($item['img'])  && isset($item['cat']) && isset($item['price'])) {

            mysqli_query($db,"INSERT INTO ps_items VALUES('0','".addq1($item['name'])."','".addq1($item['img'])."','".($item['price']+1-1)."','".($item['cat']+1-1)."','1');");
            $catid = mysqli_insert_id();

            return $catid;

        } else return 0;

}


function calc_sums($items,$self,$rship,$rfreeship,$builds = array(),$forcefreesheep = 0) {

    // $self = 2 - самовывоз
    // $self = 1 - доставка



     $buildsum = 0;
     $bdisc = 0;
     foreach ($builds as $build) {
		$bsum = 0;
                foreach ($build['build'] as $bld) {
                        $bsum += $bld['ciprice']*$bld['amount'];
                }
		$buildsum += $bsum*$build['bcount'];
		$bdisc += floor($bsum*$build['bcount']*($build['discount'])*0.01);

	}


    $drinks = 0;
    $other = 0;
    $subdiscounts = 0;


    foreach ($items as $item) {

        $itdisc = floor($item['price']*$item['cnt']*($item['discount'])*0.01);
	$subdiscounts += $itdisc;
        if ($item['cat']==2) $drinks += $item['price']*$item['cnt'];
        else $other += $item['price']*$item['cnt'];


    }

    $other += $buildsum;

    if ($self == 2) {

        $discount = floor($other*0.1);
        $ship = 0;


    } else {

        $discount = 0;
        if ($other<$rfreeship) $ship = $rship;
        else $ship = 0;

        if ($forcefreesheep) $ship = 0;
    }

     $discount += $subdiscounts + $bdisc;

    $regular = $drinks + $other;
    if ($regular==0) $ship = 0;
    $discounted = $regular - $discount;


    $total = $discounted + $ship;



    return array (
                  "other" => $other,
                  "drinks" => $drinks,
                  "rship" => $rship,
                  "rfreeship" => $rfreeship,
                  "ship" => $ship,
                  "discount" => $discount,
                  "regular" => $regular,
                  "discounted" => $discounted,
                  "total" => $total,
		  "buildsum" => $buildsum

                  );



}




function gen_check($ohash) {

    global $categories;

     $out =  "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
	<head>
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=9\">
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">		<title></title>
	</head>
<body><style>

    table {

        font-family: Calibri,sans-serif;
        font-size: 10pt;
    }

    body {

        margin: 0;
        padding: 0;

        border: 0;
    }




    </style>";



    $ath = mysqli_query($db,"SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE ohash = '".addq1($ohash)."';");

    if (mysqli_numrows($ath)<1) return "Заказа с таким номером не существует"; else {


        $order = mysqli_fetch_array($ath);

        $ath2 = mysqli_query($db,"SELECT * FROM ps_it2or LEFT JOIN ps_items ON iid = related_item WHERE related_order = '".$order['oid']."';");

        $items = array();

        while ($item = mysqli_fetch_array($ath2)) $items[] = $item;



        $ath4 = mysqli_query($db,"SELECT * FROM ps_bl2or WHERE related_order = '".$order['oid']."';");
        $builds = array();
        while ($bld = mysqli_fetch_array($ath4)) $builds[] = $bld;

        for ($i = 0;$i<sizeof($builds);$i++) {

                $ath5 = mysqli_query($db,"SELECT * FROM ps_blitems JOIN ps_constr ON related_constr = ciid WHERE related_build = '".$builds[$i]['bid']."' ORDER BY cicat;");
                $build = array();
                while ($bl = mysqli_fetch_array($ath5)) $build[] = $bl;
                $builds[$i]['build'] = $build;
        }


        $sum = calc_sums($items, $order['self'], $order['sheep'],$order['freesheep'],$builds,$order['forcefreesheep']);

        $gon = $sum['rship'];

        $round500 = floor($sum['total']/500 + 1)*500;

        $sda = $round500 - $sum['total'];


        $out .=  "<table><tr><td style=\"vertical-align: top; border-bottom: solid 1px black;\">";
        ///////////Левый чек
        $out .=  "<div style=\"width: 305px; text-align: center; margin: 10px;\">";
        $out .=  "<img src=\"http://pastachief.ru/admin/logo.jpg\" width=220></div>";

        $out .=  "<table>";

        $out .=  "<tr><td><b>Номер заказа:</b></td><td><span style=\"color: red;\">".$order['oid']."</span></td><td></td></tr>";
        $out .=  "<tr><td><b>Дата:</b></td><td>".date("d.m.Y",$order['ctime'])."</td><td></td></tr>";
        $out .=  "<tr><td><b>Время:</b></td><td>".date("H:i",$order['ctime'])."</td><td></td></tr>";

        $out .=  "<tr><td></td><td>&nbsp;</td><td></td></tr>";

        $out .=  "<tr><td colspan=3 style=\"font-size: 9pt; padding-left: 80px;\"><b>Контактные данные:</b></td></tr>";
        $out .=  "<tr><td><b>Район:</b></td><td><span style=\"color: red;\">".$order['rname']."</span></td><td></td></tr>";
        $out .=  "<tr><td><b>Улица:</b></td><td><div style=\"max-width: 200px;\"><span style=\"color: red;\">".$order['adr']."</span></div></td><td></td></tr>";
        $out .=  "<tr><td><b>Квартира/офис:</b></td><td><div style=\"max-width: 200px;\"><span style=\"color: red;\">".$order['kvart']."</span></div></td><td></td></tr>";
        $out .=  "<tr><td><b>Телефон:</b></td><td><div style=\"max-width: 200px;\"><span style=\"color: red;\">".$order['tel']."</span></div></td><td></td></tr>";


        $out .=  "<tr><td>&nbsp;</td><td></td><td></td></tr>";
        $out .=  "</table>";

        $out .=  "<table width=\"100%\">";

        $out .=  "<tr><td colspan=5 style=\"font-size: 9pt; padding-left: 80px;\"><b>Вы заказали:</b></td></tr>";
        ///Список

        foreach ($items as $item) {

            $out .=  "<tr><td><div style=\"overflow: hidden; max-width: 200px;\"><nobr>".$item['name']."</nobr></div></td><td style=\"text-align: right;\">".$item['price']."</td><td> руб.</td><td style=\"text-align: right;\">".$item['cnt']."</td><td> шт.</td></tr>";
        }

	 foreach ($builds as $build) {
                 foreach ($build['build'] as $bld) {

                         $out .=  "<tr><td><div style=\"overflow: hidden; max-width: 200px;\"><nobr>".$bld['ciname']."</nobr></div></td><td style=\"text-align: right;\">".$bld['ciprice']."</td><td> руб.</td>";
			 $out .= "<td style=\"text-align: right;\">".($bld['amount']*$build['bcount'])."</td><td> шт.</td></tr>";

                }



        }


        $out .=  "<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>";

        $out .=  "<tr><td colspan=5 style=\"font-size: 9pt; padding-left: 80px;\"><b>Оплата:</b></td></tr>";

        $out .=  "<tr><td><b>Доставка:</b></td><td style=\"text-align: right;\">".$sum['ship']."</td><td>руб.</td><td></td><td></td></tr>";
        $out .=  "<tr><td><b>Сумма заказа:</b></td><td style=\"text-align: right;\">".$sum['other']."</td><td>руб.</td><td></td><td></td></tr>";
        $out .=  "<tr><td><b>Напитки:</b></td><td style=\"text-align: right;\">".$sum['drinks']."</td><td>руб.</td><td></td><td></td></tr>";
        if ($sum['discount']>0) $out .=  "<tr><td><b>Скидка:</b></td><td style=\"text-align: right;\">".$sum['discount']."</td><td>руб.</td><td></td><td></td></tr>";
        $out .=  "<tr><td><b>ИТОГО к оплате:</b></td><td style=\"text-align: right;\"><b>".$sum['total']."</b></td><td>руб.</td><td></td><td></td></tr>";


        $out .=  "</table>";


        $out .=  "<br><div style=\"text-align: center;\">";
        $out .=  "<strong style=\"font-size: 14pt;\">PASTA CHIEF</strong><br>";
        $out .=  "<i style=\"font-size: 9pt;\">Доставка домашней итальянской пасты</i><br>";
        $out .=  "<i style=\"font-size: 9pt;\">Спасибо за Ваш заказ!</i><br>";
        $out .=  "<span style=\"font-size: 14pt;\">60-18-19</span><br>";
        $out .=  "<span style=\"font-size: 14pt;\">www.pastachief.ru</span><br>";
        $out .=  "</div><br>";




        $out .=  "</td><td style=\"border-left: solid 1px black; border-bottom: solid 1px black; vertical-align: top;\">";
        //Правый чек
        //Курьеру
        if ($order['self']!=2) {
        $out .=  "<div style=\"width: 335px; padding: 5px; border-bottom: solid 1px black;\">";

                $out .=  "<br><div style=\"text-align: center; padding-bottom: 7px;\">";
            $out .=  "<strong>МАРШРУТНЫЙ ЛИСТ КУРЬЕРУ:</strong>";
            $out .=  "</div>";

            $out .=  "<table>";
            $out .=  "<tr><td>Курьер: ______________________________________</td></tr>";
            $out .=  "<tr><td>Номер заказа: ".$order['oid']."</td></tr>";
            $out .=  "<tr><td>Дата/время: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".date("d.m.Y H:i",$order['ctime'])."</td></tr>";

            $out .=  "</table>";
            $out .=  "<table>";

            $out .=  "<tr><td>Район:</td><td>".$order['rname']."</td><td></td></tr>";
            $out .=  "<tr><td>Улица:</td><td><div style=\"max-width: 240px;\">".$order['adr']."</div></td><td></td></tr>";
            $out .=  "<tr><td>Квартира/офис:</td><td><div style=\"max-width: 240px;\">".$order['kvart']."</div></td><td></td></tr>";
            $out .=  "<tr><td>Телефон:</td><td><div style=\"max-width: 240px;\">".$order['tel']."</div></td><td></td></tr>";

            $out .=  "<tr><td>Сумма заказа:</td><td>".$sum['total']."</td><td></td></tr>";
            $out .=  "<tr><td>Гонорар:</td><td><span style=\"color: red;\">".$gon."</span></td><td></td></tr>";
            $out .=  "<tr><td>Сдача:</td><td>".$sda."</td><td></td></tr>";


        $out .=  "</table>";
        $out .=  "</div>";
        }
        $mounths = array("янв","фев","мар","апр","май","июн","июл","авг","сен","окт","ноя","дек");

        //На кухню
            $out .=  "<br><div style=\"text-align: center;\">";
            $out .=  "<strong>ЧЕК НА КУХНЮ:</strong>";
            $out .=  "</div>";

            $out .=  "<table>";

            $out .=  "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Номер заказа:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td><td> ".$order['oid']."</td></tr>";
            $out .=  "<tr><td></td><td>Дата: </td><td>".date("d",$order['ctime'])." ".$mounths[date("m",$order['ctime'])-1]."</td></tr>";
            $out .=  "<tr><td></td><td>Время: </td><td>".date("H:i",$order['ctime'])."</td></tr>";

            $out .=  "</table><br>";

                    ///Список
            $out .=  "<table>";
            foreach ($items as $item) {

                $out .=  "<tr><td><div style=\"overflow: hidden; max-width: 320px; font-size: 14pt;\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;".$item['cnt']." x ".$item['name']."</nobr></div></td></tr>";
            }
	    foreach ($builds as $build) {
		$out .=  "<tr><td></td></tr>";
                 foreach ($build['build'] as $bld) {


			  $out .=  "<tr><td><div style=\"overflow: hidden; max-width: 320px; font-size: 14pt;\"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;".($bld['amount']*$build['bcount'])." x ".$bld['ciname']."&nbsp;<span style=\"font-size: 14px;\">(".$categories[$bld['cicat']].")</span></nobr></div></td></tr>";


                }



        }
            $out .=  "</table>";

        $out .=  "</td></tr></table>";

        //
        //$out .=  "<pre>";
        //
        //print_r($order);
        //print_r($items);





    }


    return $out;
}



?>
