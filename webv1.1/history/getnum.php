<?php
include_once ("connect.php");
$SN=$_POST['SOS'];

$sql_query="SELECT COUNT(*) AS count FROM device_data_save WHERE SN='".$SN."' ";
$result_set=mysql_query($sql_query);
$rowx = mysql_fetch_array($result_set,MYSQL_ASSOC);
$count = $rowx['count'];


 $resultJson = array("state"=>$count);

echo urldecode(json_encode($resultJson));//Json格式输出
?>