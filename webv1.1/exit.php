<?php
//1开启session
include_once("connect.php");			//数据库连接
session_start();
$username=$_SESSION['UserName'];//"wld";//
$op="退出登录";		//"登录";//
$sql_query = "INSERT INTO log (UserName,Operate,Time) VALUES ('".$username."','".$op."',now())";
mysql_query($sql_query);
//2、清空session信息
$_SESSION = array();
   
//3、清除sessionID
if(isset($_COOKIE[session_name()]))
{
  setCookie(session_name(),'',time()-3600,'/');
}
//4、彻底销毁session
session_destroy();
header('Refresh:1;url=./index.html');
?>