<?php


require_once("libpastadb.php");

set_error_handler('my_error_handler');

$errorlog = array();
$warrnings = array();
$errorstatus = 'DEBUG';
$goid = 0;


if (isset($_POST['cartcontent']) && isset($_POST['ohash'])) {

    $cart = $_POST['cartcontent'];
    $oh2 = $_POST['ohash'];
    $raj = ""; if (isset($_POST['raj'])) $raj = $_POST['raj'];
    $tel = ""; if (isset($_POST['tel'])) $tel = $_POST['tel'];
    $adr = ""; if (isset($_POST['adr'])) $adr = $_POST['adr'];
    $com = ""; if (isset($_POST['comm'])) $com = $_POST['comm'];
    $sum = ""; if (isset($_POST['sum'])) $sum = $_POST['sum'];
    $self = ""; if (isset($_POST['self'])) $self = $_POST['self'];
    $oh = md5(print_r($cart,true));
    $ohash = md5('saltsalt'.$oh.$oh2);
    $rajid = get_raj_id($raj);
    $errorlog[] = "***********************************************";
    $errorlog[] = "*      ".date("d.m.Y_H-i-s")." ".$ohash;
    $errorlog[] = "***********************************************";
    $errorlog[] = "";
    $errorlog[] = print_r($_POST,true);
    if ($rajid<1) fatal_error("Неизвестный район");
    $kvart = "";
    $etaj = "";
    $aht0 = mysqli_query($db,"SELECT * FROM ps_orders WHERE ohash = '$ohash';");
    if (mysqli_num_rows($aht0)>0) {

         echo json_encode(array("status"=>"succes"));
         warrning("Повторный заказ $ohash");
        write_log();
        exit;
    }

    if (preg_match("/^(.*[0-9]+[^0-9]+)([0-9]+.*)$/",$adr,$regs)) {

        $adr = $regs[1];
        $kvart = $regs[2];
    }

    $sum = $sum+1-1;
    $self = ($self==1 ? 1 : 2);

    $query = "INSERT INTO ps_orders VALUES('0','$ohash','".(time())."','0','$rajid','".addq1($adr)."','".addq1($kvart)."','".addq1($etaj)."','".addq1($tel)."','".addq1($com)."','$sum','$self','0','PLACED');";

    if (!mysqli_query($db,$query)) fatal_error("Ошибка БД",mysqli_error());

    $oid = mysqli_insert_id();
    $goid = $oid;

    if ($oid <1) fatal_error("Не удалось добавить заказ",mysqli_error());

    mysqli_query($db,"INSERT INTO ps_mail VALUES('0','$oid','0','WAIT');");


    foreach ($cart as $item) {

        $cnt = $item['cnt']+1-1;
        $price = $item['price']+1-1;
        $type = $item['type']+1-1;

        if ($cnt>0) {

            if ($type==2) {

                $query = "INSERT INTO ps_bl2or VALUES('0','$oid','$cnt','0');";
                if (!mysqli_query($db,$query)) fatal_error("Ошибка БД",mysqli_error());
                $bid = mysqli_insert_id();

                $cprice = 0;

                foreach ($item['build'] as $build) {

                    $ath2 = mysqli_query($db,"SELECT * FROM ps_constr WHERE cihash = '".addq1($build['id'])."';");
                    if (mysqli_num_rows($ath2)!=1) fatal_error("Ошибка БД","Хеш не найден: ".$build['id']);

                    $citem = mysqli_fetch_array($ath2);
                    $amount = $build['amount']+1-1;
                    if ($amount<1) {warrning("Неверное количесво $amount на ".$citem['ciname'].""); $amount=1;}
                    $cur_price = $build['price']+1-1;
                    if ($cur_price<0) {warrning("Неверная цена  $cur_price на ".$citem['ciname'].""); $cur_price=$citem['ciprice'];}

                    if ($cur_price!=$citem['ciprice']) warrning("Цена на ".$citem['ciname']." не соответствует действительной",print_r($build,true)."\n".print_r($citem,true));

                    mysqli_query($db,"INSERT INTO ps_blitems VALUES('0','$bid','".$citem['ciid']."','$amount','$cur_price');");

                    $cprice += $cur_price*$amount;

                }

                if ($cprice!=$price) warrning("Цена на билд  неправильно посчитана",print_r($item['build'],true));

            } else {

                $iid = get_item_id($item);
                mysqli_query($db,"INSERT INTO ps_it2or VALUES('0','$oid','$iid','$cnt','$price','0');");
            }
        }

    }




       echo json_encode(array("status"=>"succes"));
        write_log();


} else {


    echo json_encode(array("status"=>"error","message"=>"Ошибка"));
}

function fatal_error($message,$dmesg = "") {

    global $errorlog,$errorstatus;

    $errorstatus = 'ERROR';

    $errorlog[] = "Exit with message: ".$message;
    $errorlog[] = $dmesg;


    echo json_encode(array("status"=>"error","message"=>$message));

    write_log();
    exit;
}

function warrning($message,$dmesg = "") {

    global $errorlog,$warrnings,$errorstatus;

    $errorstatus = 'WARN';

    $errorlog[] = "WARNING: ".$message;
    $errorlog[] = $dmesg;
    $warrnings[] = $message;

}

function my_error_handler($code, $msg, $file, $line) {

   global $errorlog,$warrnings,$errorstatus;

    $errorstatus = 'WARN';
     $warrnings[] = "PHP error $code";
    $errorlog[] ="Произошла ошибка \"$msg ($code)\" в файле $file (строка $line)";

}

function write_log() {

    global $goid,$errorlog,$warrnings,$errorstatus;

    $e = mysqli_real_escape_string(implode("\n",$errorlog));
    $w = mysqli_real_escape_string(implode("\n",$warrnings));

    mysqli_query($db,"INSERT INTO ps_log VALUES('0','$goid','$w','$e','".time()."','$errorstatus');");


}

/*


 ALTER TABLE `ps_orders` ADD `forcefreesheep` INT( 2 ) NOT NULL AFTER `self` ;
 ALTER TABLE `ps_it2or` ADD `discount` FLOAT NOT NULL ;

*/

?>
