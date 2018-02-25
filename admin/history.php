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
        $navi.= "<td align=left><a href=\"history.php?date=$m3.$y3\">&lt; ".$month_names[$m3]." $y3</a></td>";
        $navi.= "<td align=center><form action=history.php><input type=text name=date value=\"$d1.$m1.$y1\"> - <input type=text name=date2 value=\"$d2.$m2.$y2\"><input type=submit value=\"Показать\"></form></td>";
        $navi.= "<td align=right><a href=\"history.php?date=$m4.$y4\">".$month_names[$m4]." $y4 &gt;</a></td>";
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
    $ath = mysql_query("SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE status = 'DONE' AND ctime>'$begin' AND ctime<'$end' ORDER BY ctime DESC;");
    

   if (mysql_numrows($ath)<1) die("Нет заказов за этот период"); else {
        
        
        echo "<h1>Заказы $context</h1>";
       
        $i = 0;
        echo "<table class=\"peertable shipped\"><thead><tr>";
    echo "<th>№</th>";
    echo "<th>Дата поступления</th>";
    echo "<th>Дата выполнения</th>";
    echo "<th>Район</th>";
    echo "<th>Адрес</th>";
    echo "<th>Сумма</th>";
    echo "<th></th>";
    echo "</tr></thead><tbody>";
    while( $o = mysql_fetch_array($ath)) {
        
        ++$i;
        
        echo "<tr class=\"".($i & 1 ? "" : "past")."\">";
        echo "<td>".$o['oid']."</td>";
        echo "<td>".addate($o['ctime'])."</td>";
        echo "<td>".addate($o['ftime'])."</td>";
        echo "<td>".$o['rname']."</td>";
        echo "<td>".$o['adr']." ".$o['kvart']."</td>";
        echo "<td>".$o['sum']." руб.</td>";
        echo "<td><a href=\"check.php?order=".$o['ohash']."\" style=\"color: darkblue;\">Чек</a></td>";
        echo "</tr>";
       
       }
       
       echo "</tbody></table>";
        

        
   }
    
    




?>