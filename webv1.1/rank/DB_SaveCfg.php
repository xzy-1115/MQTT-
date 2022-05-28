<?php
$strSN = $_GET['SN'];
$strProtocolVer = $_GET['ProtocolVer'];
$json_string=$_POST['rowdata_send'];
$de_json = json_decode($json_string,TRUE);
$count_json = count($de_json);

$json_string1=$_POST['rowdata1_send'];
$de_json1= json_decode($json_string1,TRUE);
$count_json1 = count($de_json1);

include('dbconfig.php');
$db = mysql_connect($dbhost, $dbuser, $dbpassword)
or die("Connection Error: " . mysql_error());
mysql_select_db($database) or die("Error conecting to db.");
mysql_query("set names 'utf8'");

for($i=0;$i<$count_json;$i++)
{
	$ALa = $de_json[$i]['Alarmable'];
	$ALaa.=$ALa;
}
$SQL = "Update realtime_rules set AMask ='".$ALaa."' where  Protocol='".$strProtocolVer."' and SN ='".$strSN."' "; 
//echo $SQL ;
if( mysql_query( $SQL ) )
{$resultJson = array("state"=>200);}else $resultJson = array("state"=>100);//json格式的数组

$SQLSTR =  "SELECT COUNT(*) AS count FROM protocol_detail where  Protocol='".$strProtocolVer."' ";
//echo $SQLSTR;
$result = mysql_query($SQLSTR);
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];
//echo $count;

$num=0;
$num1=0;
$i=0;
$j=0;
$sum=0;

for($i=0;$i<$count;$i++)
{
	$num++;
	$sql3="SELECT COUNT(*) AS count FROM  device_alarm_detail where SN ='".$strSN."' and Protocol='".$strProtocolVer."' and Offset='".$num."' "; 
    $res3 = mysql_query($sql3);
	$row1 = mysql_fetch_array($res3,MYSQL_ASSOC);
	$count1 = $row1['count'];
    
	for($j=0;$j<$count1;$j++)
	{
		$num1=$j+1;
		$ALa_min = $de_json1[$sum]['ALAMIN'];
	    $ALa_max = $de_json1[$sum]['ALAMAX'];
	    $ALa_type = $de_json1[$sum]['ALATYPE'];
		$sum++;
		$SQL = "Update device_alarm_detail set  Min ='".$ALa_min."' , Max ='".$ALa_max."' , AlaCode ='".$ALa_type."' where  Protocol='".$strProtocolVer."' and SN ='".$strSN."' and Offset = '".$num."' and AlaOffset= '".$num1."' "; 
		if( mysql_query( $SQL ) )
		{$resultJson = array("state"=>200);}else $resultJson = array("state"=>400);//json格式的数组
	}
}

echo urldecode(json_encode($resultJson));//Json格式输出
 
?>

