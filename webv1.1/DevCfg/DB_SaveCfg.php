<?php
$strSN = $_GET['SN'];
//$SN="123";
$strProtocolVer;
//$strProtocolVer="1243";
$json_string=$_POST['rowdata_send'];
$de_json = json_decode($json_string,TRUE);
$count_json = count($de_json);
//"[{"Offset":"1","ItemName":"PH","Visible":"是","Alarmable":"是"},{"Offset":"2","ItemName":"氮氯","Visible":"否","Alarmable":"否"},{"Offset":"3","ItemName":"ORP","Visible":"是","Alarmable":"是"}]"
include_once ("../connect.php");

$sql_query="SELECT * FROM device_protocol WHERE SN='".$strSN."' and UseFlag = 1 ";
$result_set=mysql_query($sql_query);
$result=mysql_fetch_assoc($result_set);
$strProtocolVer= $result[Protocol];

for($i=0;$i<$count_json;$i++)
{
	if($de_json[$i]['Visible']==1){$Vis='0';}else $Vis='1';
	if($de_json[$i]['Alarmable']==1){$ALa='0';}$ALa='1';
	
	$Viss.=$Vis;
    $ALaa.=$ALa;
}
$SQL = "Update realtime_rules set VMask ='$Viss',AMask='$ALaa' where Protocol='$strProtocolVer' and SN ='$strSN'"; 
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
$resultJson = array("state"=>200,"sqL"=>$SQL,"RESULT"=>$result);//json格式的数组
 echo urldecode(json_encode($resultJson));//Json格式输出

?>

