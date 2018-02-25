<?php


require_once("../libpastadb.php");

require_once("map.php");



$ath = mysqli_query($db,"SELECT * FROM ps_cats ORDER BY catsort;");


while ($cat = mysqli_fetch_array($ath)) {


        echo "<h1>".$cat['catname']."</h1>";

        $ath2 = mysqli_query($db,"SELECT * FROM ps_items2 WHERE cat = '".$cat['ctid']."' AND vis = 0 ORDER BY itsort;");


         echo "<table class=\"peertable\"><thead><tr>";
        echo "<th>Название</th>";
        echo "<th>Масса</th>";
        echo "<th>Цена</th>";
        echo "<th>Описание</th>";
        echo "<th>Флаг</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr></thead><tbody>";
        $i = 0;
        while ($ci = mysqli_fetch_array($ath2)) {


             ++$i;

                echo "<tr class=\"".($i & 1 ? "" : "past")."\">";
                echo "<td>".$ci['name']."</td>";
                echo "<td>".$ci['itmass']." г</td>";
                echo "<td>".$ci['sprice']." руб</td>";
                echo "<td>".mb_substr($ci['itdesc'],0,50,"utf-8")."...</td>";
                echo "<td>".(($ci['itflag']=='none') ? "" : $ci['itflag'])."</td>";
                echo "<td><a href=\"itemedit.php?ithash=".$ci['ithash']."\">Редактировать</a></td>";
                echo "<td><a href=\"itemedit.php?ithash=".$ci['ithash']."&delete\">Удалить</a></td>";
				echo "<td><a href=\"itemedit.php?ithash=".$ci['ithash']."&visyes\">Видим</a></td>";
                echo "</tr>";
        }


         echo "</tbody></table>";


        echo "<br><a href=\"itemedit.php?newcat=".$cat['ctid']."\">Добавить</a>";


}





?>



mysqli_query("DELETE FROM ps_items2 WHERE ithash = '".addq1($cihash)."';");
