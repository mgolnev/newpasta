<?php


require_once("../libpastadb.php");




if (isset($_POST['ithash'])) {


        $hash = $_POST['ithash'];

        if ($hash=="") $hash = md5(time() + microtime());


        if (mysqli_query($db,"INSERT INTO ps_items2 VALUES('0','".addq1($hash)."','".addq1($_POST['name'])."','".addq1($_POST['itdesc'])."','".addq1($_POST['img'])."','".addq1($_POST['sprice'])."','".addq1($_POST['cat'])."','".addq1($_POST['itflag'])."','".addq1($_POST['itmass'])."','".addq1($_POST['itsort'])."','1')".
                    " ON DUPLICATE KEY UPDATE name = '".addq1($_POST['name'])."', img = '".addq1($_POST['img'])."', itdesc = '".addq1($_POST['itdesc'])."', sprice = '".addq1($_POST['sprice'])."', cat = '".addq1($_POST['cat'])."', itflag = '".addq1($_POST['itflag'])."', itmass = '".addq1($_POST['itmass'])."', itsort = '".addq1($_POST['itsort'])."';"))


         Header("Location: items.php"); else echo mysqli_error();

         exit;

} elseif (isset($_GET['ithash'])) {

        $cihash = $_GET['ithash'];

        $ath = mysqli_query($db,"SELECT * FROM ps_items2 WHERE ithash = '".addq1($cihash)."';");

        if ($it = mysqli_fetch_array($ath)) {

                if (isset($_GET['visno'])) {

                        mysqli_query($db,"UPDATE ps_items2 SET vis = 0 WHERE ithash = '".addq1($cihash)."';");
                        Header("Location: items.php"); exit;
                }
                elseif (isset($_GET['delete'])) {

                       mysqli_query($db,"DELETE FROM ps_items2 WHERE ithash = '".addq1($cihash)."';");
                        Header("Location: items.php"); exit;
                }

				elseif (isset($_GET['visyes'])) {

                        mysqli_query($db,"UPDATE ps_items2 SET vis = 1 WHERE ithash = '".addq1($cihash)."';");
                        Header("Location: items.php"); exit;

        }} else exit("несуществующий предмет");


}		elseif ($_GET['newcat']) {

      $cat = $_GET['newcat']+1-1;
      $it['cat'] = $cat;
        $it['ithash']= "";
        $it['name'] = "";
		$it['img'] = "";
		$it['itdesc'] = "";
		$it['itmass'] = 0;
		$it['sprice'] = 0;
        $it['itsort'] = 0;
		$it['itflag'] = 0;


} else {


        Header("Location: items.php");
}


  require_once("map.php");

  if (!isset($it)) exit("it is not set");

  if ($it['ithash']=="") echo "<h1>Добавить новый элемент</h1>";
  else echo "<h1>Редактировать</h1>";

  echo "<form method=post>";
  echo "<input type=hidden name=ithash value=\"".$it['ithash']."\">";
  echo "Название: <input type=text name=name value=\"".htmlspecialchars($it['name'])."\"><br>";
  echo "Адрес изображения: <input type=text name=img value=\"".htmlspecialchars($it['img'])."\"><br>";

   $ath2 = mysqli_query($db,"SELECT * FROM ps_cats ORDER BY catsort;");


        while ($chan = mysqli_fetch_array($ath2)) {
            $checked = ($it['cat']==$chan['ctid']) ? "checked=\"checked\"" : "";
            $ch = $chan['catname'];
            echo "<label><input type=radio name=cat value=\"".$chan['ctid']."\" $checked>$ch</label>";
        }
        echo "<br>";

  echo "Описание:<br> <textarea cols=50 rows=6 name=itdesc>".htmlspecialchars($it['itdesc'])."</textarea><br>";
  echo "Масса: <input type=text name=itmass value=\"".htmlspecialchars($it['itmass'])."\"> г<br>";
  echo "Цена: <input type=text name=sprice value=\"".htmlspecialchars($it['sprice'])."\"> руб<br>";
  echo "Порядок: <input type=text name=itsort value=\"".htmlspecialchars($it['itsort'])."\"><br>";
  echo "Флаг: ";
  echo radio('itflag',$it['itflag'],'itflag');
  echo "<input type=submit></form>";



function radio($name,$value,$column) {
global $db;
        $sql = "SHOW COLUMNS FROM ps_items2 LIKE '$column';";
        $values = array($value);
    if ($result = mysqli_query($db,$sql)) { // If the query's successful

        $enum = mysqli_fetch_object($result);
        preg_match_all("/'([\w ]*)'/", $enum->Type, $regs);
        $values = $regs[1];

    }
    $out = "";
    foreach ($values as $val) {
        $checked = $val == $value ? "checked=\"checked\"" : "";
        $out.= "<label><input type=radio name=$name value=\"$val\" $checked>$val</label>";

    }

    $out.="<br>";
    return $out;

}

?>
