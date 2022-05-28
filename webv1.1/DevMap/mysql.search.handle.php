<?php
session_start();
//查找数据库
include_once ("../connect.php");

//读取旧信息
$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
$UserName = $_SESSION['UserName'];
$sql = "select * from user_device where UserName='".$UserName."' and UseFlag=1";
$result_set = mysql_query($sql);
$snstr=0;
$longstr=0;
$lastr=0;
$statusstr=0;
	while($row=mysql_fetch_array($result_set)){
			$sql = "select * from device where  SN='".$row['SN']."'";
			$res = mysql_query($sql);
			$result=mysql_fetch_assoc($res);
			
		/////////////////////////在线监测/////////////////////	
		$sql_queryt="SELECT * FROM device_online_list WHERE SN='".$row['SN']."'";
		$result_sett=mysql_query($sql_queryt);
		$resultt=mysql_fetch_assoc($result_sett);
		if(mysql_num_rows($result_sett)>0)
		{	
			if(strtotime($startTime)<strtotime($resultt['Time']))
			{   
		            $runstr=1;
			}
			else $runstr=0;
		}else $runstr=0;
	///////////////////////////////////////////////////////
			
			if($snstr){
			$snstr=$snstr.'_';
			$snstr=$snstr.$row['SN'];
			$longstr=$longstr.'_';
			$longstr=$longstr.$result[Longtitude];
			$lastr=$lastr.'_';
			$lastr=$lastr.$result[Latitude];
			$statusstr=$statusstr.'_';
			$statusstr=$statusstr.$runstr;
			}else{
				$snstr=$row['SN'];
				$longstr=$result[Longtitude];
				$lastr=$result[Latitude];
				$statusstr=$runstr;
			}
	}

$resultJson = array("SNstr"=>$snstr, "Long"=>$longstr, "La"=>$lastr,"Status"=>$statusstr);//json格式的数组


echo urldecode(json_encode($resultJson));//Json格式输出 */


?>