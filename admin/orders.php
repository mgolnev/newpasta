<?php


require_once("../libpastadb.php");
require_once("map.php");




    echo "<h2>Поступившие заказы</h2>";

    $ath = mysqli_query($db,"SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE status = 'PLACED' ORDER BY ctime DESC;");


    $i = 0;
        echo "<table class=\"peertable placed\"><thead><tr>";
    echo "<th>№</th>";
    echo "<th>Дата поступления</th>";
    echo "<th>Район</th>";
    echo "<th>Адрес</th>";
    echo "<th>Сумма</th>";
    echo "<th></th>";
    echo "<th></th>";
    //echo "<th></th>";
    echo "</tr></thead><tbody>";
    while( $o = mysqli_fetch_array($ath)) {

        ++$i;

        echo "<tr class=\"".($i & 1 ? "" : "past")."\">";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['oid']."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".addate($o['ctime'])."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['rname']."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['adr']." ".$o['kvart']."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['sum']." руб.</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">Просм./Редакт.</a></td>";
        echo "<td><a href=\"check.php?order=".$o['ohash']."\" style=\"color: darkblue;\">Чек</a></td>";
       // echo "<td><a href=\"edit.php?cancel=".$o['ohash']."\" style=\"color: darkred;\">Отменить</a></td>";
        echo "</tr>";

       }

       echo "</tbody></table>";

           echo "<h2>Утвержденные заказы</h2>";

    $ath = mysqli_query($db,"SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE status = 'CONFIRM' ORDER BY ctime DESC;");


    $i = 0;
        echo "<table class=\"peertable\"><thead><tr>";
    echo "<th>№</th>";
    echo "<th>Дата поступления</th>";
    echo "<th>Район</th>";
    echo "<th>Адрес</th>";
    echo "<th>Сумма</th>";
    echo "<th></th>";
    echo "<th></th>";
    ///echo "<th></th>";
    echo "</tr></thead><tbody>";
    while( $o = mysqli_fetch_array($ath)) {

        ++$i;

        echo "<tr class=\"".($i & 1 ? "" : "past")."\">";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['oid']."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".addate($o['ctime'])."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['rname']."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['adr']." ".$o['kvart']."</a></td>";
        echo "<td><a href=\"edit.php?order=".$o['ohash']."\">".$o['sum']." руб.</a></td>";
        echo "<td><a href=\"edit.php?shipped=".$o['ohash']."\" style=\"color: green;\">Отметить выполненным</a></td>";
        echo "<td><a href=\"check.php?order=".$o['ohash']."\" style=\"color: darkblue;\">Чек</a></td>";
        //echo "<td><a href=\"edit.php?cancel=".$o['ohash']."\" style=\"color: darkred;\">Отменить</a></td>";
        echo "</tr>";

       }

       echo "</tbody></table>";

           echo "<h2>Недавно выполненные заказы</h2>";

    $ath = mysqli_query($db,"SELECT * FROM ps_orders LEFT JOIN ps_rajs ON rid = related_raj WHERE status = 'DONE' AND (ctime>UNIX_TIMESTAMP()-48*3600 OR ftime>UNIX_TIMESTAMP()-48*3600) ORDER BY ctime DESC;");


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
    while( $o = mysqli_fetch_array($ath)) {

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


        echo "<br><a href=\"history.php\">Больше...</a>";









?>
