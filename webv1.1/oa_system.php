<?php
session_start();
include_once ("connect.php");
$SNstr=$_POST['SN'];
$Message=$_POST['Message'];
$sql_queryy="insert into oa_list(UserName,Time,SN,Message) values('".$_SESSION['UserName']."',now(),'".$SNstr."', '".$Message."' ) ";
			   if(mysql_query($sql_queryy))$resultJson = array("state"=>200);//json格式的数组
			   else $resultJson = array("state"=>1);//json格式的数组

echo urldecode(json_encode($resultJson));//Json格式输出



?>