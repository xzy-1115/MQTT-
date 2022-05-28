<?php
///和oa系统相关，根据用户查下属设备
session_start();
include_once ("connect.php");
$test=$_POST['test'];
	$result = mysql_query("SELECT * FROM use_login WHERE UserName ='".$_SESSION['UserName']."'  ");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$count = $row['Role'];
	
$sql_query="SELECT * FROM user_device WHERE UserName='".$_SESSION['UserName']."' ";
$result_set=mysql_query($sql_query);	
$strArray;
while ($row = mysql_fetch_array($result_set, MYSQL_ASSOC))
{	
		if($strArray){
				$strArray .="_";
				$strArray .=$row['SN'];
			}
			else { 
				$strArray = $row['SN'];
			} 
}
$resultJson = array("sn"=>$strArray,"role"=>$count);//json格式的数组
//$resultJson = array("state"=>$SN);//json格式的数组
echo urldecode(json_encode($resultJson));//Json格式输出
?>