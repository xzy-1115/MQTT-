<?php
$host = "118.31.17.203";
$db_user = "root";
$db_pass = "ghost";
$db_name = "device";
$timezone = "Asia/Shanghai";

$link = mysql_connect($host, $db_user, $db_pass);
mysql_select_db($db_name, $link);
mysql_query("SET names UTF8");
header("Content-Type: text/html; charset=utf-8");

?>