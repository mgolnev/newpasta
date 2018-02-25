<?php


require_once("../libpastadb.php");

require_once("map.php");




foreach ($categories as $cid => $ct) {


        echo "<h1>$ct</h1>";

        $ath = mysqli_query($db,"SELECT * FROM ps_constr WHERE cicat = '$cid' AND vis = 1;");


         echo "<table class=\"peertable\"><thead><tr>";
        echo "<th>Название</th>";
        echo "<th>Масса</th>";
        echo "<th>Цена</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr></thead><tbody>";
        $i = 0;
        while ($ci = mysqli_fetch_array($ath)) {


             ++$i;

                echo "<tr class=\"".($i & 1 ? "" : "past")."\">";
                echo "<td>".$ci['ciname']."</td>";
                echo "<td>".$ci['cimass']." г</td>";
                echo "<td>".$ci['ciprice']." руб</td>";
                echo "<td><a href=\"constredit.php?cihash=".$ci['cihash']."\">Редактировать</a></td>";
                echo "<td><a href=\"constredit.php?cihash=".$ci['cihash']."&delete\">Убрать</a></td>";
                echo "</tr>";
        }


         echo "</tbody></table>";


         echo "<br><a href=\"constredit.php?newcat=$cid\">Добавить</a>";


}





?>
