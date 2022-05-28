<?php
//用户日志
include_once("connect.php");			//数据库连接
session_start();
$username=$_SESSION['UserName'];//"wld";//
$op=$_POST['op'];		//"登录";//

$sql_query = "INSERT INTO log (UserName,Operate,Time) VALUES ('".$username."','".$op."',now())";
mysql_query($sql_query);
$resultJson = array("state"=>200);//json格式的数组
echo urldecode(json_encode($resultJson));//Json格式输出
?>