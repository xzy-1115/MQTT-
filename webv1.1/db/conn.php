<?php
//定义常量参数
define('DB_HOST','118.31.17.203');
define('DB_USER','root');
define('DB_PWD','ghost');//密码
define('DB_NAME','device');

$connect = mysql_connect(
   DB_HOST, 
   DB_USER, 
   DB_PWD
)or die('数据库连接失败:'.mysql_error());

mysql_select_db(DB_NAME,$connect) or die('数据库连接错误，错误信息：'.mysql_error());
mysql_query("set names utf8");
?>