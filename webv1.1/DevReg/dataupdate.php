<?php

//存在的bug
//UserID写死
//
session_start();
	include_once("../db/conn.php");			//数据库连接
	$resultJson;
	$Offset=1;
	$SN = $_POST['SN'];		//设备协议
	$Lng = $_POST['Lng'];		
	$Lat = $_POST['Lat'];
	$Addr = $_POST['Addr'];
	$LocalName = $_POST['LocalName'];
	$LocalType=$_POST['LocalType'];
	$resultJson = array("state"=>200);
	$username=$_SESSION['UserName'];

//////////////////////////////////////////5.device;///////////////////////////////////////////////
	//6.和设备信息表交互
	//6.1 判断条件
	//6.2 插入记录
//////////////////////////////////////////
			//$sql_query = "INSERT INTO device (SN,LocalName,IndustryType,Address,Longtitude,Latitude,ThirdUsrTime)VALUES('$SN','$LocalName','$LocalType','$Addr','$Lng','$Lat',now())";
				$sql_query="update device set SN='".$SN."' , LocalName='".$LocalName."', IndustryType = '".$LocalType."'  , Address= '".$Addr."',Longtitude='".$Lng."' ,Latitude='".$Lat."' , ThirdUsrTime = now() where UserName='".$username."' "; 
				if(mysql_query($sql_query))
				{
					$resultJson = array("state"=>200);//json格式的数组
				}
				else
				{
					//设备信息表插入失败
						$resultJson = array("state"=>0);//json格式的数组
				} 
	
//////////////////////////////////////////////6.user_device;////////////////////////////////////////
	//7.和用户设备表交互
	//7.1 判断条件
	//7.2 插入记录
 	    $sql_query="SELECT * FROM user_device WHERE SN='".$SN."' and  UserName = '".$username."' ";
		$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0)
		{
			//echo "协议主表有记录";
			//若协议存在，则不作任何操作
			//$resultJson = array("state"=>1,"insert"=>"Already","SQL"=>$sql_query);//json格式的数组
			$sql_query="update user_device set UseFlag = 1,Time=now() where SN='".$SN."' and  UserName = '".$username."' ";
				mysql_query($sql_query);
		}
		else
		{
				$sql_query = "INSERT INTO user_device (SN,UserName,Time,UseFlag)VALUES
				('".$SN."','".$username."',now(),1)";
				if(mysql_query($sql_query))
				{
				
				}
				else
				{
				  
					//用户设备表插入失败
						$resultJson = array("state"=>6);//json格式的数组
				} 
		} 

	echo urldecode(json_encode($resultJson));//Json格式输出
?>