<?php
	include_once("../connect.php");
	$SN = $_POST['SN'];					//设备序列号
	$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
    $res = mysql_query($sql_query);
    $result=mysql_fetch_assoc($res);

		$resultJson = array("protocol"=>$result['Protocol']);
	echo urldecode(json_encode($resultJson));//Json格式输出
?>