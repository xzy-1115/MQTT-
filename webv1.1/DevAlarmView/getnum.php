<?php
include_once ("../connect.php");
$SN=$_POST['SOS'];
$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
    $res = mysql_query($sql_query);
    $result=mysql_fetch_assoc($res);
    $ProtocolStr=$result[Protocol];

$sql_query="SELECT COUNT(*) AS count FROM device_alarm_show WHERE SN='".$SN."' and Protocol = '".$ProtocolStr."'";
$result_set=mysql_query($sql_query);
$rowx = mysql_fetch_array($result_set,MYSQL_ASSOC);
$count = $rowx['count'];


 $resultJson = array("state"=>$count);

echo urldecode(json_encode($resultJson));//Json格式输出
?>