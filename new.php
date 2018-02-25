<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="admin" />

	<title>Untitled 2</title>
</head>

<body>


<?php
$acces_token = "808167532edd3f3fee7edbde30a15e0cbfdff109872b389aad2a234839c17748921812788e953fd25894e";
$wall = 'https://api.vk.com/method/wall.get?owner_id=2086847&access_token="=$acces_token"';  
print_r ($wall);
$wall = json_decode($wall); // Преобразуем JSON-строку в массив
  $wall = $wall->response->items; // Получаем массив комментариев
  for ($i = 0; $i < count($wall); $i++) {
    echo "<p><b>".($i + 1)."</b>. <i>".$wall[$i]->text."</i><br /><span>".date("Y-m-d H:i:s", $wall[$i]->date)."</span></p>"; // Выводим записи
  }
?>
</body>
</html>