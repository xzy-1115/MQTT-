<?php
include_once ("../connect.php");
session_start();

$SN=$_POST['SN'];
$siteName=$_POST['SiteName'];
$indusType=$_POST['IndusType'];
$devAddr=$_POST['DevAddr'];

$info_sql="update device set LocalName='".$siteName."' , IndustryType='".$indusType."', Address = '".$devAddr."'  where SN='".$SN."' ";

if(mysql_query($info_sql))
{
	$resultJson = array("state"=>200);
} else
{
	$resultJson = array("state"=>2);
}
// $resultJson = array(
// 	'SiteName' => $siteName,
// 	'IndusType' => $indusType,
// 	'DevAddr' => $devAddr,
//    );

 echo urldecode(json_encode($resultJson));//Json格式输出

?>