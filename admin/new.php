<?php

require_once("../libpastadb.php");
require_once("map.php");
echo "<h2>Пробник</h2>";
echo "<table border=\"1\" width=\"100%\" bgcolor=\"#FFFFE1\">";


 
// SQL-запрос:
$q = mysql_query ("SELECT name FROM ps_items2");

echo '<select name="name" size="1">';
while ($row=mysql_fetch_array($q)) {
    echo '
        <option value="'.$row['id'].'">'.$row['name'].'</option>
    ';
}
echo '</select>';
//echo 'На
?>