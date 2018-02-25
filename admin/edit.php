<?php


require_once("../libpastadb.php");

$yasai = array();
$nico = array();
$nicoall = array();
global $db;

if (isset($_GET['order']) || isset($_POST['ohash'])) {

        $ath9 = mysqli_query($db,"SELECT iid as id, name as name, sprice as price, 0 as cat FROM ps_items WHERE vis=1 UNION SELECT ciid as id, ciname as name, ciprice as price, cicat as cat FROM ps_constr WHERE vis=1 ORDER BY cat,name;");

        while ($lis = mysqli_fetch_array($ath9)) {
                if ($lis['cat']==0) {
                    $yasai[$lis['id']] = $lis;
                } else {
                        $nico[$lis['cat']][$lis['id']] = $lis;
                        $nicoall[$lis['id']] = $lis;
                }

        }

}


if (isset($_POST['ohash'])) {

        $ohash = $_POST['ohash'];
        $ath = mysql_query("SELECT oid FROM ps_orders WHERE ohash = '".addq1($ohash)."';");

        if (mysql_numrows($ath)<1) die( "Заказа с таким номером не существует"); else {

                $oid = mysql_result($ath,0);

                 mysql_query("UPDATE ps_orders SET sum='0' WHERE oid = '$oid';");

                if (isset($_POST['raj']))  {$raj = $_POST['raj']+1-1; mysql_query("UPDATE ps_orders SET related_raj='$raj' WHERE oid = '$oid';");}
                if (isset($_POST['tel']))  {$tel = addq1($_POST['tel']); mysql_query("UPDATE ps_orders SET tel='$tel' WHERE oid = '$oid';");}
                if (isset($_POST['adr']))  {$adr = addq1($_POST['adr']); mysql_query("UPDATE ps_orders SET adr='$adr' WHERE oid = '$oid';");}
                if (isset($_POST['comm'])) {$comm = addq1($_POST['comm']); mysql_query("UPDATE ps_orders SET comm='$comm' WHERE oid = '$oid';");}
                if (isset($_POST['kvart'])){$kvart =addq1( $_POST['kvart']); mysql_query("UPDATE ps_orders SET kvart='$kvart' WHERE oid = '$oid';");}
                if (isset($_POST['self'])) {$self = $_POST['self']-1+1; mysql_query("UPDATE ps_orders SET self='$self' WHERE oid = '$oid';");}
                if (isset($_POST['forcefreesheep'])) { mysql_query("UPDATE ps_orders SET forcefreesheep='1' WHERE oid = '$oid';");} else { mysql_query("UPDATE ps_orders SET forcefreesheep='0' WHERE oid = '$oid';");}


               $ath2 = mysql_query("SELECT * FROM ps_it2or WHERE related_order = '$oid';");

               while ($it = mysql_fetch_array($ath2)) {

                        $ioid = $it['ioid'];

                        if (isset($_POST["item".$ioid]) && $_POST["item".$ioid]>0) {

                                $cnt = $_POST["item".$ioid]+1-1;
                                mysql_query("UPDATE ps_it2or SET cnt='$cnt' WHERE ioid = '$ioid';");
                        }

                        if (isset($_POST["discount".$ioid])) {

                                $discount = $_POST["discount".$ioid]+1-1;
                                if ($discount<0) $discount=0;
                                if ($discount>100)$discount=100;
                                mysql_query("UPDATE ps_it2or SET discount = '$discount' WHERE ioid = '$ioid';");
                        }

                        if (isset($_POST["remove".$ioid])) {

                                mysql_query("DELETE FROM ps_it2or WHERE ioid = '$ioid';");
                        }

                        if (isset($_POST["replace".$ioid])) {

                                $niid = $_POST["replace".$ioid] + 1 - 1;
                                if (isset($yasai[$niid])) {
                                        mysql_query("UPDATE ps_it2or SET related_item = '$niid', price = '".$yasai[$niid]['price']."' WHERE ioid = '$ioid';");
                                }

                        }


               }

               for ($i=0;$i<999;$i++) {

                        if (isset($_POST["newitem".$i])) {
                                $niid = $_POST["newitem".$i] + 1 - 1;
                                $ncnt = $_POST["newcnt".$i] + 1 - 1;
                                        if (isset($yasai[$niid])) {

                                               mysql_query("INSERT INTO ps_it2or VALUES('0','$oid','$niid','$ncnt','".$yasai[$niid]['price']."','0');");
                                        }


                        } else break;

               }


                  $ath7 = mysql_query("SELECT * FROM ps_bl2or WHERE related_order = '$oid';");

               while ($bbl = mysql_fetch_array($ath7)) {

                        $bbid = $bbl['bid'];

                        if (isset($_POST["build".$bbid]) && $_POST["build".$bbid]>0) {

                                $cnt = $_POST["build".$bbid]+1-1;
                                mysql_query("UPDATE ps_bl2or SET bcount='$cnt' WHERE bid = '$bbid';");
                        }

                        if (isset($_POST["bdiscount".$bbid])) {

                                $bdiscount = $_POST["bdiscount".$bbid]+1-1;
                                if ($bdiscount<0) $bdiscount=0;
                                if ($bdiscount>100)$bdiscount=100;
                                mysql_query("UPDATE ps_bl2or SET discount = '$bdiscount' WHERE bid = '$bbid';");
                        }



                        if (isset($_POST["removebuild".$bbid])) {

                                mysql_query("DELETE FROM ps_bl2or WHERE bid = '$bbid';");
                        }


               }

                $ath8 = mysql_query("SELECT * FROM ps_bl2or JOIN ps_blitems ON related_build = bid WHERE related_order = '$oid';");

               while ($bbb = mysql_fetch_array($ath8)) {

                        $biid = $bbb['biid'];

                        if (isset($_POST["bitem".$biid]) && $_POST["bitem".$biid]>0) {

                                $cnt = $_POST["bitem".$biid]+1-1;
                                mysql_query("UPDATE ps_blitems SET amount='$cnt' WHERE biid = '$biid';");
                        }

                        if (isset($_POST["removebitem".$biid])) {

                                mysql_query("DELETE FROM ps_blitems WHERE biid = '$biid';");
                        }

                        if (isset($_POST["replacebuild".$biid])) {

                                $niid = $_POST["replacebuild".$biid] + 1 - 1;
                                if (isset($nicoall[$niid])) {
                                        mysql_query("UPDATE ps_blitems SET related_constr = '$niid', cur_price = '".$nicoall[$niid]['price']."' WHERE biid = '$biid';");
                                }

                        }


               }

               $build_insert = 0;

                for ($i=0;$i<999;$i++) {

                        if (isset($_POST["newbuild".$i])) {
                                $niid = $_POST["newbuild".$i] + 1 - 1;
                                $ncnt = $_POST["newbuildcnt".$i] + 1 - 1;
                                $rbuild = $_POST["newrelatedbid".$i] + 1 - 1;

                                if ($rbuild==0) {

                                        if ($build_insert==0) {
                                                mysql_query("INSERT INTO ps_bl2or VALUES('0','$oid','1','0');");
                                                $build_insert = mysql_insert_id();
                                        }

                                        $rbuild = $build_insert;
                                }
                                        if (isset($nicoall[$niid])) {

                                               mysql_query("INSERT INTO ps_blitems VALUES('0','$rbuild','$niid','$ncnt','".$nicoall[$niid]['price']."');");
                                        }


                        } else break;

               }

                if (isset($_POST['confirm_order'])) {

                        mysql_query("UPDATE ps_orders SET status='CONFIRM' WHERE oid = '$oid';");
                        header("Location: orders.php"); goto finals;

                }
                if (isset($_POST['cancel_order'])) {

                        mysql_query("UPDATE ps_orders SET status='CANCEL' WHERE oid = '$oid';");
                        header("Location: orders.php"); goto finals;
                }



                header("Location: edit.php?order=$ohash"); goto finals;

        }

        finals:

        update_sums($oid);
        exit;

      //echo "<pre>";
      //print_r($_POST);
      //
 } elseif (isset($_GET['shipped'])) {

        $ohash = addq1($_GET['shipped']);
         mysql_query("UPDATE ps_orders SET status='DONE', ftime = '".time()."' WHERE ohash = '$ohash';");
                        header("Location: orders.php"); exit;

} elseif (isset($_GET['order'])) {

        require_once("map.php");

        $ohash = $_GET['order'];
    $ath = mysqli_query($db,"SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE ohash = '".addq1($ohash)."';");

   if (mysqli_num_rows($ath)<1) die( "Заказа с таким номером не существует"); else {

        $order = mysqli_fetch_array($ath);
        $oid = $order['oid'];
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

        //echo "<pre>";print_r($builds);//

        $sum = calc_sums($items, $order['self'], $order['sheep'],$order['freesheep'],$builds,$order['forcefreesheep']);


        echo "<h1>Заказ №".$order['oid']."</h1>";
        echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">";
        echo "<input type=hidden name=ohash value=\"".$order['ohash']."\">";

        echo "<table>";


        echo "<tr><td>Дата поступления:</td><td>".date("d.m.Y H:i",$order['ctime'])."</td></tr>";
        //rajons
        $ath3 = mysqli_query($db,"SELECT * FROM ps_rajs;");

        echo "<tr><td>Район:</td><td><select name=raj>";
        while ($chan = mysqli_fetch_array($ath3)) {
            $checked = ($order['related_raj']==$chan['rid']) ? "selected" : "";

            echo "<option value=\"".$chan['rid']."\" $checked>".$chan['rname']."</option>";

        }
        echo "</select></td></tr>";
        echo "<tr><td>Адрес:</td><td>".inp($order,'adr')."</td></tr>";
        echo "<tr><td>Квартира:</td><td>".inp($order,'kvart')."</td></tr>";
        echo "<tr><td>Телефон:</td><td>".inp($order,'tel')."</td></tr>";
        echo "<tr><td>Комментарий:</td><td>".inp($order,'comm')."</td></tr>";

        $checked = " checked=\"checked\"";
        echo "<tr><td></td><td>";
        echo "<label><input type=radio name=self value=\"1\"".($order['self']==1 ? $checked : "").">Доставка</label> <label><input type=radio name=self value=\"2\"".($order['self']==2 ? $checked : "").">Самовывоз</label>";
        echo "</td></tr>";

        echo "</table><br>";
        echo "<table class=\"peertable placed\"><thead>";

                 echo "<tr>";

                 echo "<th></th>";
                 echo "<th>Наименование</th>";
                 echo "<th>Цена</th>";
                 echo "<th>Количество</th>";

                  echo "<th>Изменить количество</th>";
                  echo "<th>Скидка</th>";


                  echo "</tr></thead><tbody>";

        foreach ($items as $item) {

                 echo "<tr>";

                 echo "<td><img src=\"../".$item['img']."\" height=50 widht=50></td>";
                 echo "<td>";
                 echo "<select name=\"replace".$item['ioid']."\">";
                 echo "<option value=0 selected>".$item['name']."</option>";
                 foreach ($yasai as $ri) {
                        echo "<option value=\"".$ri['id']."\">&gt;".$ri['name']."</option>";
                 }
                 echo "</select>";
                 echo "</td>";
                 echo "<td>".$item['price']." руб</td>";
                 echo "<td>".$item['cnt']." шт</td>";

                  echo "<td><input type=text name=\"item".$item['ioid']."\" value=\"\" size=2> <label><input type=checkbox name=\"remove".$item['ioid']."\"> убрать</label></td>";
                  echo "<td><input type=text name=\"discount".$item['ioid']."\" value=\"".$item['discount']."\" size=2>% </td>";


                  echo "</tr>";


        }

         echo "<tr>";
         echo "<td colspan=6><a href=\"#\" onClick=\"additem(this);return false;\">Добавить</a>";
        echo "</td></tr>";

         echo "<tr>";
         echo "<td colspan=6><a href=\"#\" onClick=\"addbuild(this,0);return false;\">Добавить элемент коструктора</a>";
        echo "</td></tr>";
        foreach ($builds as $build) {

                $bsum = 0;
                $bout = "";
                foreach ($build['build'] as $bld) {

                        $bout.= "<tr>";
                        $bout.= "<td style=\"color: grey; text-align: right;\">".$categories[$bld['cicat']]."</td>";
                       // $bout.= "<td>&nbsp;&nbsp;&nbsp;".$bld['ciname']."</td>";

                        $bout.= "<td>&nbsp;&nbsp;&nbsp;";
                        $bout.= "<select name=\"replacebuild".$bld['biid']."\">";
                        $bout.= "<option value=0 selected>".$bld['ciname']."</option>";
                        foreach ($nico[$bld['cicat']] as $ri) {
                               $bout.= "<option value=\"".$ri['id']."\">&gt;".$ri['name']."</option>";
                        }
                        $bout.= "</select>";
                        $bout.= "</td>";
                        $bout.= "<td>".$bld['ciprice']." руб</td>";
                        $bout.= "<td>".$bld['amount']." шт</td>";

                        $bout.= "<td><input type=text name=\"bitem".$bld['biid']."\" value=\"\" size=2> <label><input type=checkbox name=\"removebitem".$bld['biid']."\"> убрать</label></td>";
                        $bout.= "<td></td>";
                         $bout.= "</tr>";
                        $bsum += $bld['ciprice']*$bld['amount'];
                }

                    echo "<tr class=\"past\">";

                 echo "<td><img src=\"../index_files/constrel.jpg\" height=50 widht=50></td>";
                 echo "<td>Конструктор</td>";
                 echo "<td>".$bsum." руб</td>";
                 echo "<td>".$build['bcount']." шт</td>";

                  echo "<td><input type=text name=\"build".$build['bid']."\" value=\"\" size=2> <label><input type=checkbox name=\"removebuild".$build['bid']."\"> убрать</label></td>";
                 echo "<td><input type=text name=\"bdiscount".$build['bid']."\" value=\"".$build['discount']."\" size=2>% </td>";

                  echo "</tr>";
                  echo $bout;

                           echo "<tr>";
                         echo "<td colspan=6><a href=\"#\" onClick=\"addbuild(this,".$build['bid'].");return false;\">Добавить в конструктор</a>";
                        echo "</td></tr>";

        }


        echo "</tbody></table><br>";


        echo "<input type=submit value=\"Сохранить\"> ";



         //         "other" => $other,
         //         "drinks" => $drinks,
         //         "rship" => $rship,
         //         "rfreeship" => $rfreeship,
         //         "ship" => $ship,
         //         "discount" => $discount,
         //         "regular" => $regular,
         //         "discounted" => $discounted,
         //         "total" => $total

        echo "<table>";
        echo "<tr><td>Еда:</td><td>".$sum['other']." руб</td></tr>";
        echo "<tr><td>Напитки:</td><td>".$sum['drinks']." руб</td></tr>";
        echo "<tr><td>Еда + напитки:</td><td>".$sum['regular']." руб</td></tr>";
        echo "<tr><td></td><td>&nbsp;</td></tr>";
        echo "<tr><td>Скидка:</td><td>".$sum['discount']." руб</td></tr>";
        echo "<tr><td>Сумма с учетом скидки:</td><td>".$sum['discounted']." руб</td></tr>";
        echo "<tr><td></td><td>&nbsp;</td></tr>";
        echo "<tr><td>Доставка по району:</td><td>".$sum['rship']." руб";
        if ($order['self']==1) echo " <label><input type=checkbox name=forcefreesheep value=\"1\"".($order['forcefreesheep'] ? $checked : "").">Не учитывать сумму доставки</label>";
        echo "</td></tr>";
        echo "<tr><td>Порог бесплатной доставки:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$sum['rfreeship']." руб</td></tr>";
        echo "<tr><td>Доставка:</td><td>".$sum['ship']." руб</td></tr>";
        echo "<tr><td></td><td>&nbsp;</td></tr>";
        echo "<tr><td>Итого:</td><td><b>".$sum['total']."</b> руб</td></tr>";

        echo "</table><br>";


        echo "<input type=submit name=\"cancel_order\" value=\"Отменить заказ\"> ";
        echo "<input type=submit value=\"Сохранить\"> ";
        if ($order['status']=='PLACED') echo "<input type=submit name=\"confirm_order\" value=\"Сохранить и утвердить\">";

        echo "</form>";


        echo "<script>";

        echo "var itemcnt = 0; var buildcnt = 0;";

        echo "function additem(sender) {";

        echo "out = '';";


        echo "out += '<tr>';";

        echo "out += '<td></td>';";
        echo "out += '<td>';";
        echo "out += '<select name=\"newitem' + itemcnt + '\">';";
        echo "out += '<option value=0 selected></option>';";
        foreach ($yasai as $ri) {
               echo "out += '<option value=\"".$ri['id']."\">&gt;".$ri['name']."</option>';";
        }
        echo "out += '</select>';";
        echo "out += '</td>';";
        echo "out += '<td></td>';";

         echo "out += '<td><input type=text name=\"newcnt' + itemcnt +'\" value=\"1\" size=2> шт</td>';";

         echo "out += '<td></td>';";
         echo "out += '<td></td>';";


         echo "out += '</tr>';";
        echo "$(sender).parent().parent().before(out);";

        echo "itemcnt++;";

        echo "}";


        echo "function addbuild(sender,bid) {";

        echo "out = '';";


        echo "out += '<tr>';";

        echo "out += '<td></td>';";
        echo "out += '<td>';";
        echo "out += '<select name=\"newbuild' + buildcnt + '\">';";
        echo "out += '<option value=0 selected></option>';";
        foreach ($categories as $category=>$catname) {
                echo "out += '<option value=\"0\" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$catname."</option>';";
                foreach ($nico[$category] as $ri) {
                       echo "out += '<option value=\"".$ri['id']."\">&gt;".$ri['name']."</option>';";
                }
        }
        echo "out += '</select>';";
        echo "out += '</td>';";
        echo "out += '<td></td>';";

         echo "out += '<td><input type=hidden name=\"newrelatedbid' + buildcnt +'\" value=\"' + bid + '\"><input type=text name=\"newbuildcnt' + buildcnt +'\" value=\"1\" size=2> шт</td>';";

         echo "out += '<td></td>';";
         echo "out += '<td></td>';";


         echo "out += '</tr>';";
        echo "$(sender).parent().parent().before(out);";

        echo "buildcnt++;";

        echo "}";




        echo "</script>";

   }



}

function inp($order,$name) {


    return "<input type=text name=\"$name\" value=\"".htmlspecialchars($order[$name])."\" size=60>";



}

function update_sums($oid) {

        $ath = mysql_query("SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE oid = '$oid';");

        $order = mysql_fetch_array($ath);

        $ath2 = mysql_query("SELECT * FROM ps_it2or LEFT JOIN ps_items ON iid = related_item WHERE related_order = '".$oid."';");
        $items = array();
        while ($item = mysql_fetch_array($ath2)) $items[] = $item;

        $ath4 = mysql_query("SELECT * FROM ps_bl2or WHERE related_order = '".$oid."';");
        $builds = array();
        while ($bld = mysql_fetch_array($ath4)) $builds[] = $bld;

        for ($i = 0;$i<sizeof($builds);$i++) {

                $ath5 = mysql_query("SELECT * FROM ps_blitems JOIN ps_constr ON related_constr = ciid WHERE related_build = '".$builds[$i]['bid']."' ORDER BY cicat;");
                $build = array();
                while ($bl = mysql_fetch_array($ath5)) $build[] = $bl;
                $builds[$i]['build'] = $build;
        }


        $sum = calc_sums($items, $order['self'], $order['sheep'],$order['freesheep'],$builds,$order['forcefreesheep']);

        mysql_query("UPDATE ps_orders SET sum='".$sum['total']."' WHERE oid = '$oid';");

}


?>
