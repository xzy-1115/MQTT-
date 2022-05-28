<?php
$SN=$_POST['SN'];

include_once ("../connect.php");

	$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
    $res = mysql_query($sql_query);
    $result=mysql_fetch_assoc($res);
    $ProtocolStr=$result[Protocol];//获得协议

			$sql_query1="Update device_alarm_show set Operation = 1 ,EndTime=now() where  SN = '".$SN."' and  Protocol='".$ProtocolStr."' ";
			$res1 = mysql_query($sql_query1);
			$resultJson = array("state"=>1);
echo urldecode(json_encode($resultJson));//Json格式输出
?>