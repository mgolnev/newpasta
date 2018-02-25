<?
$ath = mysqli_query($db,"SELECT * FROM ps_cats WHERE catvis = 1 ORDER BY catsort;");


while ($cat = mysqli_fetch_array($ath)) {
    if ($cat['catimage']!="") echo "<div id=\"" .$cat['ctid']. "\"><img src=\"".$cat['catimage']."\"></div>";
    else echo "<h2>".$cat['catname']."</h2>";
    gen_list($cat['ctid'],$cat['catcolor']);

}

function gen_list($ctid,$color) {
global $db;
        $i = 0;
        $ath = mysqli_query($db,"SELECT * FROM ps_items2 WHERE cat = '$ctid' AND vis = 1 ORDER BY itsort;");
        $items = array();

    while ($it = mysqli_fetch_array($ath) ) $items[] = $it;
    for ($g=0;$g<sizeof($items);$g+=3) {

        $hiddentext = "";
        for ($i=0;$i+$g<sizeof($items) && $i<3;++$i) $hiddentext.="<div class=itemhiddentext><div class=itemtext>".$items[$i+$g]['itdesc']."</div></div>";

    for ($i=0;$i+$g<sizeof($items) && $i<3;++$i)
        {

            $it = $items[$g + $i];

                      echo 	"<div class=\"plate-dishes-item".($i % 3 == 2 ? " pastaitemright" : "")."\">";
                       if (isset($it['itflag'])&& $it['itflag'] !== "none" ){
echo "<div id =\"flag\"><img src=\"img/" .$it['itflag'].".png\"></div>";}
else {echo "";}
echo "<div class=\"plate-dishes-item-wrapper\">";
		   echo "<div class=\"plate-dishes-frame\"><img src=\"". $it['img']. "\"></div>";

            echo "<dl class=\"plate-dishes-specs\"><dt class=\"plate-dishes-specs-title\">" . $it['name'] . "</dt>";
 echo "<dd class=\"plate-dishes-specs-composition\">" . $it['itdesc']. "</dd></dl>";




           echo "<table class=\"plate-dishes-options\" cellspacing=\"0\"><tr><td class=\"plate-dishes-options-main\">
 <small>" .$it['itmass']. "г</small></td>
 <td class=\"plate-dishes-options-buy\">
 <div class=\"plate-dishes-buy\">"
   .$it['sprice']. "&nbsp; руб.</div></td>
  </tr>
  </table></div>

  </div>";

        }
    }

}

?>
