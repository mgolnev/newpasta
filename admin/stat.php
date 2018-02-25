<?php


require_once("../libpastadb.php");



        require_once("map.php");
        $y1 = date("Y"); $y2 = $y1;
        $m1 = date("m"); $m2 = $m1;
        $d1 = 1; $d2 = date("t");
        $cntx = 1;


         $month_names=array("","январь","февраль","март","апрель","май","июнь",
  "июль","август","сентябрь","октябрь","ноябрь","декабрь");
         $month_names2=array("","января","февраля","марта","апреля","мая","июня",
  "июля","августа","сентября","октября","ноября","декабря");
         $month_names3=array("","январе","феврале","марте","апреле","мае","июне",
  "июле","августе","сентябре","октябре","ноябре","декабре");

        if (isset($_GET['date'])){
                $date = $_GET['date'];
                preg_match("/^([0-9]+)\.([0-9]+)\.([0-9]+)$/",$date,$regs);
                if (isset($regs[0])) {
                        $y1 = $regs[3]; $y2 = $y1;
                        $m1 = $regs[2]; $m2 = $m1;
                        $d1 = $regs[1]; $d2 = date("t", mktime(0,0,0,$m2,1,$y2));


                        $cntx = 2;
                } else {
                        preg_match("/^([0-9]+)\.([0-9]+)$/",$date,$regs);
                        if (isset($regs[0])) {
                                $y1 = $regs[2]; $y2 = $y1;
                                $m1 = $regs[1]; $m2 = $m1;
                                $d1 = 1; $d2 = date("t", mktime(0,0,0,$m2,1,$y2));


                                $cntx = 3;
                        }
                }
        }

        if (isset($_GET['date2'])){
                $date = $_GET['date2'];
                preg_match("/^([0-9]+)\.([0-9]+)\.([0-9]+)$/",$date,$regs);
                if (isset($regs[0])) {
                        $y2 = $regs[3];
                        $m2 = $regs[2];
                        $d2 = $regs[1];


                        $cntx = 2;
                } else {
                        preg_match("/^([0-9]+)\.([0-9]+)$/",$date,$regs);
                        if (isset($regs[0])) {
                                $y2 = $regs[2];
                                $m2 = $regs[1];
                                $d2 = date("t", mktime(0,0,0,$m2,1,$y2));


                        $cntx = 4;
                        }
                }
        }

        $begin = mktime(0,0,0,$m1,$d1,$y1);
        $end = mktime(23,59,59,$m2,$d2,$y2);

        if (($begin===false) || ($end===false)) die("Некорректная дата");

        $d1 = sprintf("%02d",date("d",$begin));
        $m1 = sprintf("%02d",date("m",$begin));
        $y1 = sprintf("%04d",date("Y",$begin));

        $d2 = sprintf("%02d",date("d",$end));
        $m2 = sprintf("%02d",date("m",$end));
        $y2 = sprintf("%04d",date("Y",$end));

        if ($cntx == 1) $context = "в этом месяце";
        if ($cntx == 2) $context = "с $d1 ".$month_names2[$m1+1-1]." $y1 по $d2 ".$month_names2[$m2+1-1]." $y2";
        if ($cntx == 3) $context = "в ".$month_names3[$m1+1-1]." $y1";
        if ($cntx == 4) $context = "с ".$month_names2[$m1+1-1]." $y1 по ".$month_names2[$m2+1-1]." $y2";

         $m4=$m1; $y4=$y1;
        $m3=$m1; $y3=$y1;

        $m4++;
        if ($m4>12) { $m4=1; $y4++;}

        $m3--;
        if ($m3<1) { $m3=12; $y3--;}


        $navi = "<br><table class=\"navi\" width=\"100%\"><tr>";
        $navi.= "<td align=left><a href=\"stat.php?date=$m3.$y3\">&lt; ".$month_names[$m3]." $y3</a></td>";
        $navi.= "<td align=center><form action=stat.php><input type=text name=date value=\"$d1.$m1.$y1\"> - <input type=text name=date2 value=\"$d2.$m2.$y2\"><input type=submit value=\"Показать\"></form></td>";
        $navi.= "<td align=right><a href=\"stat.php?date=$m4.$y4\">".$month_names[$m4]." $y4 &gt;</a></td>";
        $navi.= "</tr></table>";

         echo "<style>


            .navi td a {
                color: black;
                text-decoration: none;

            }
           .navi td a:hover {
                color: blue;


            }
            .navi td {

                font-size: 25px;
            }

        </style>";

        echo $navi;
    //echo date("d.m.Y H:i:s",$end);
    //$ath = mysql_query("SELECT *,SUM(cnt) as zcnt FROM ps_it2or LEFT JOIN ps_items ON related_item = iid WHERE related_order IN (SELECT oid FROM ps_orders WHERE ctime>'$begin' AND ctime<'$end' AND status = 'DONE') GROUP BY related_item ORDER BY zcnt DESC;");

    //$ath = mysql_query("SELECT img,name,price,SUM(cnt) as zcnt FROM ps_it2or LEFT JOIN ps_items ON related_item = iid WHERE related_order IN (SELECT oid FROM ps_orders WHERE ctime>'$begin' AND ctime<'$end' AND status = 'DONE') GROUP BY related_item ORDER BY zcnt DESC;");

        $ath = mysqli_query($db,"SELECT img,name,price,SUM(cnt) as zcnt FROM ps_it2or LEFT JOIN ps_items ON related_item = iid WHERE related_order IN (SELECT oid FROM ps_orders WHERE ctime>'$begin' AND ctime<'$end' AND status = 'DONE') GROUP BY related_item UNION SELECT ciimage as img, ciname as name, ciprice as price, SUM(bcount) as zcnt FROM ps_blitems JOIN ps_constr ON ciid = related_constr JOIN ps_bl2or ON related_build = bid WHERE related_order IN (SELECT oid FROM ps_orders WHERE ctime>'$begin' AND ctime<'$end' AND status = 'DONE') GROUP BY related_constr ORDER BY zcnt DESC;");

   if (mysqli_num_rows($ath)<1) die("Нет статистики за этот период"); else {

        $items = array();
        while ($item = mysqli_fetch_array($ath)) $items[] = $item;

        echo "<h1>Самые популярные товары $context</h1>";

        echo "<table>";

                 echo "<tr>";

                 echo "<td></td>";
                 echo "<td>Наименование</td>";
                 echo "<td style=\"padding-left: 20px;\">Цена</td>";
                 echo "<td style=\"padding-left: 20px;\">Количество заказов</td>";




                  echo "</tr>";

        foreach ($items as $item) {

                 echo "<tr>";

                 echo "<td>";
                 if ($item['img']=='') $item['img'] = "index_files/constrel.jpg";
                 echo "<img src=\"../".$item['img']."\" height=50 widht=50>";
                 echo "</td>";
                 echo "<td> ".$item['name']." </td>";
                 echo "<td style=\"padding-left: 20px;\"> ".$item['price']."  </td>";
                 echo "<td style=\"padding-left: 20px;\"> ".$item['zcnt']."  </td>";


                  echo "</tr>";


        }


        echo "</table><br>";
   }
?>
