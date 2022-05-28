<?php
$SN=$_POST['SN'];
$strTIME=$_POST['AlaTIME'];
$ProtocolStr;
include_once ("../connect.php");

	$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
    $res = mysql_query($sql_query);
    $result=mysql_fetch_assoc($res);
    $ProtocolStr=$result[Protocol];

	$SQLSTR =  "SELECT * FROM device_alarm_show where SN='".$SN."' and Protocol='".$ProtocolStr."' order by Time desc";
	$result = mysql_query($SQLSTR);
	$row;

	$index=1;
	while($row=mysql_fetch_array($result)){

		if($row['Time']==$strTIME)
		{
			$sql_query1="Update device_alarm_show set Operation = 1 , EndTime = now() where  SN = '".$SN."' and Time = '".$strTIME."' ";
			$res1 = mysql_query($sql_query1);
		}

	}

$resultJson = array("state"=>1);
echo urldecode(json_encode($resultJson));//Json格式输出
?>