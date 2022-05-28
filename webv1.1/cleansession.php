<?php
$clean="退出登录";//$_POST['clean'];
include_once("connect.php");			//数据库连接
session_start();
$username=$_SESSION['UserName'];//"wld";//
$sql_query = "INSERT INTO log (UserName,Operate,Time) VALUES ('".$username."','".$clean."',now())";
mysql_query($sql_query);

				//2、清空session信息
				$_SESSION = array();
				   
				//3、清除sessionID
				/*if(isset($_COOKIE[session_name()]))
				{
				  setCookie(session_name(),'',time()-3600,'/');
				}*/
				//4、彻底销毁session
				session_destroy();
			
$resultJson = array("state"=>200);//json格式的数组
echo urldecode(json_encode($resultJson));//Json格式输出
?>