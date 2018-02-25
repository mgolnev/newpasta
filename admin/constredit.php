<?php


require_once("../libpastadb.php");




if (isset($_POST['cihash'])) {
        
        
        $hash = $_POST['cihash'];
        
        if ($hash=="") $hash = md5(time() + microtime());
        
        
        if (mysql_query("INSERT INTO ps_constr VALUES('0','".addq1($hash)."','".addq1($_POST['ciname'])."','".addq1($_POST['ciimage'])."','".addq1($_POST['cidesc'])."','".addq1($_POST['ciprice'])."','".addq1($_POST['cimass'])."','".addq1($_POST['cicat'])."','1')".
                    " ON DUPLICATE KEY UPDATE ciname = '".addq1($_POST['ciname'])."', ciimage = '".addq1($_POST['ciimage'])."', cidesc = '".addq1($_POST['cidesc'])."', ciprice = '".addq1($_POST['ciprice'])."', cimass = '".addq1($_POST['cimass'])."';"))
        
        
         Header("Location: constructor.php"); else echo mysql_error();
         
         exit;
        
} elseif (isset($_GET['cihash'])) {
        
        $cihash = $_GET['cihash'];
        
        $ath = mysql_query("SELECT * FROM ps_constr WHERE cihash = '".addq1($cihash)."';");
        
        if ($ci = mysql_fetch_array($ath)) {
                
                if (isset($_GET['delete'])) {
                        
                        mysql_query("UPDATE ps_constr SET vis = 0 WHERE cihash = '".addq1($cihash)."';");
                        Header("Location: constructor.php"); exit;
                }
                
        } else exit("несуществующий предмет");
        
        
        
        
} elseif ($_GET['newcat']) {
        
      $cat = $_GET['newcat']+1-1;
      
      $ci['cihash'] = "";
        $ci['cicat'] = $cat;
        $ci['ciname'] = "";
        $ci['cidesc'] = "";
        $ci['ciimage'] = "";
        $ci['cimass'] = 0;
        $ci['ciprice'] = 0;
        
        
} else {
        
        
        Header("Location: constructor.php");
}


  require_once("map.php");
  
  if (!isset($ci)) exit("ci is not set");
  
  if ($ci['cihash']=="") echo "<h1>Добавить новый элемент</h1>";
  else echo "<h1>Редактировать</h1>";
  
  echo "<form method=post>";
  echo "<input type=hidden name=cihash value=\"".$ci['cihash']."\">";
  echo "<input type=hidden name=cicat value=\"".$ci['cicat']."\">";
  echo "Название: <input type=text name=ciname value=\"".htmlspecialchars($ci['ciname'])."\"><br>";
  echo "Адрес изображения: <input type=text name=ciimage value=\"".htmlspecialchars($ci['ciimage'])."\"><br>";
  echo "Описание:<br> <textarea cols=50 rows=6 name=cidesc>".htmlspecialchars($ci['cidesc'])."</textarea><br>";
  echo "Масса: <input type=text name=cimass value=\"".htmlspecialchars($ci['cimass'])."\"> г<br>";
  echo "Цена: <input type=text name=ciprice value=\"".htmlspecialchars($ci['ciprice'])."\"> руб<br>";
  echo "<input type=submit></form>";



?>