<?php
$db = mysqli_connect("localhost", "mysql", "mysql");
mysql_select_db('pasta');
mysql_query("SET NAMES utf8");

session_start();
