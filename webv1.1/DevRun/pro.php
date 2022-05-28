<?php
include_once("../db/conn.php");			//数据库连接
$SN = $_POST['SN'];
$sql_query2="SELECT * from device_protocol where SN = '".$SN."' ";
$res2=mysql_query($sql_query2);
$row1=mysql_fetch_assoc($res2);
$oldprot=$row1[Protocol];
$resultJson = array("information"=>$oldprot);//json格式的数组
        echo urldecode(json_encode($resultJson));//Json格式输出
?>