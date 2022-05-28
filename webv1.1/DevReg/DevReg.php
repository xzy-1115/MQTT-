<?php

//存在的bug
//UserID写死
//
session_start();
	include_once("../db/conn.php");			//数据库连接
	//$PROTOCOLInfo ="ywV1.0_温度_℃_0_100_湿度_%_0_100_PH值_PH_0_10" ;
	//$Addr = "湖北省, 武汉市, 洪山区, 徐东二路, ";
	//$Lng = "114.356563";
	//$Lat = "30.596354";
	//$LocalName ="222" ;
	//$SN = "123";
	//$UserId = $_POST['USER'];		//设备协议
	$resultJson;
    $Offset;
	
	//data: {"PROTOCOL":payload,"SN":strSN,"Lng":strLng,"Lat":strLat,"Addr":strAddr,"LocalName":strLocalName},
	
	$PROTOCOLInfo = $_POST['PROTOCOL'];		//设备协议
	$SN = $_POST['SN'];		//设备协议
	$Lng = $_POST['Lng'];		
	$Lat = $_POST['Lat'];
	$Addr = $_POST['Addr'];
	$LocalName = $_POST['LocalName'];
	$LocalType=$_POST['LocalType'];
	$resultJson = array("state"=>200);
	$username=$_SESSION['UserName'];
	
		$strArray = explode('_',$PROTOCOLInfo); 
	//2.和协议表交互，若有则更新时间，若无则插入数据
	$Prot = $strArray[0];
	$DevType=$strArray[1];

//////////////////////////////////////////////1.user_device;////////////////////////////////////////
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
				$sql_query = "INSERT INTO user_device (SN,UserName,Time,UseFlag) VALUES ('".$SN."','".$username."',now(),1)";
				if(mysql_query($sql_query))
				{
				
				}
				else
				{
				  
					//用户设备表插入失败
						$resultJson = array("state"=>6);//json格式的数组
				} 
		} 
		
////////////////////////////////////////2.device_protocol;///////////////////////////////////////////
	//4.和设备协议表交互
	//echo "设备协议表插入记录";
	$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
	$result_set=mysql_query($sql_query);
	if(mysql_num_rows($result_set)>0)
	{
		//有记录
		$row=mysql_fetch_row($result_set);
		//该SN使用的协议版本号
		$DevPro = $row[1];	
		if($DevPro!=$Prot)
		{
			$sql_query="delete from device_protocol where SN = '".$SN."' and Protocol ='".$DevPro."'";
	        $result_set=mysql_query($sql_query);
			$sql_query = "INSERT INTO device_protocol (SN,Protocol,UseFlag,Updatetime) VALUES('$SN','$Prot',1,now())";
			$result_set=mysql_query($sql_query);
		}
		else {}
	}
	else {
		$sql_query = "INSERT INTO device_protocol (SN,Protocol,UseFlag,Updatetime) VALUES('$SN','$Prot',1,now())";
		if(mysql_query($sql_query))
		{
		//	$resultJson = array("state"=>1,"insert"=>"ok","SQL"=>$sql_query);//json格式的数组
		}
		else
		{
			//设备协议表插入失败
			$resultJson = array("state"=>3);//json格式的数组
		} 
	}
/////////////////////////////////3.protocol_master;/////////////////////////////////////	
	//1解析json的数据
	//格式为 版本号_item1_单位_类型1_可读_可写_下限_上限_.......
	//约定好，若无单位这发送“无”

	//注意协议$Prot的长度不能超过128字节
	//2.1 先查询协议主表，若协议存在，则不操作
	$sql_query="SELECT * FROM protocol_master WHERE Protocol='".$Prot."'";
	$result_set=mysql_query($sql_query);
	if(mysql_num_rows($result_set)>0)
	{
		//echo "协议主表有记录";
		//若协议存在，则不作任何操作
		//$resultJson = array("state"=>1,"insert"=>"Already","SQL"=>$sql_query);//json格式的数组
	}
	else
	{
			//echo "协议主表插入记录";
			//若协议不存在，则插入记录
			$sql_query = "INSERT INTO protocol_master (Protocol,Note,Time) VALUES('$Prot','$PROTOCOLInfo',now())";
			if(mysql_query($sql_query))
			{
			//	$resultJson = array("state"=>1,"insert"=>"ok","SQL"=>$sql_query);//json格式的数组
			}
			else
			{
			   //协议主表插入失败
				$resultJson = array("state"=>1);//json格式的数组
			} 
	}		
/////////////////////////////////4.protocol_detail;/////////////////////////////////////			
        $sql_query="SELECT * FROM protocol_detail WHERE Protocol='".$Prot."'";
		$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0)
		{
			//echo "协议主表有记录";
			//若协议存在，则不作任何操作
			//$resultJson = array("state"=>1,"insert"=>"Already","SQL"=>$sql_query);//json格式的数组
			$Offset=1;
			for($index=2;$index<count($strArray);) 
			{ 
				//3.1先做判断
				//3.2插入数据
				//echo $hello[$index];echo "</br>"; 
				$ItemName= $strArray[$index++];
				$ItemUnit= $strArray[$index++];
				$ItemType= $strArray[$index++];
				$ItemReadable= $strArray[$index++];
				$ItemWritable= $strArray[$index++];
				$ItemMin= $strArray[$index++];
				$ItemMax= $strArray[$index++];
				
				
				$Offset++;
			} 
		}
		else
		{
			//echo "协议明细插入记录";
			//3.和协议明细表交互
			$Offset=1;
			for($index=2;$index<count($strArray);) 
			{ 
				//3.1先做判断
				//3.2插入数据
				//echo $hello[$index];echo "</br>"; 
				$ItemName= $strArray[$index++];
				$ItemUnit= $strArray[$index++];
				$ItemType= $strArray[$index++];
				$ItemReadable= $strArray[$index++];
				$ItemWritable= $strArray[$index++];
				$ItemMin= $strArray[$index++];
				$ItemMax= $strArray[$index++];
				
				$sql_query = "INSERT INTO protocol_detail (Protocol,Offset,ItemName,Max,Min,Unit,Type,Readable,Writable) VALUES('$Prot',$Offset,'$ItemName','$ItemMax','$ItemMin','$ItemUnit','$ItemType','$ItemReadable','$ItemWritable')";
				if(mysql_query($sql_query))
				{
					//$resultJson = array("state"=>1,"insert"=>"ok","SQL"=>$sql_query);//json格式的数组
				}
				else
				{
					//协议明细插入失败
					$resultJson = array("state"=>2);//json格式的数组
				} 
				$Offset++;
			} 
	    }




//////////////////////////////////////5.realtime_rules;/////////////////////////////////////////////////////
	
	//5.和查看规则报警规则表交互
	//echo "查看规则报警规则表插入记录";
		$sql_query="SELECT * FROM realtime_rules WHERE SN='".$SN."' and Protocol = '".$Prot."' ";
		$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0)
		{
			//echo "协议主表有记录";
			//若协议存在，则不作任何操作
			//$resultJson = array("state"=>1,"insert"=>"Already","SQL"=>$sql_query);//json格式的数组
			$VMask = str_repeat("1",$Offset-1);
			$AMask = str_repeat("1",$Offset-1);
			$sql_query = "UPDATE realtime_rules SET Protocol = '".$Prot."', VMask='$VMask' , Time = now(), AMask= '$AMask'  WHERE SN = '".$SN."' ";
			mysql_query($sql_query);
		}
		else
		{
				$VMask = str_repeat("1",$Offset-1);
				$AMask = str_repeat("1",$Offset-1);
				$sql_query = "INSERT INTO realtime_rules (SN,Protocol,VMask,Time,AMask) VALUES('$SN','$Prot','".$VMask."',now(),'".$AMask."')";
				if(mysql_query($sql_query))
				{
				//	$resultJson = array("state"=>1,"insert"=>"ok","SQL"=>$sql_query);//json格式的数组
				}
				else
				{
				//规则表插入失败
						$resultJson = array("state"=>4);//json格式的数组
				} 
		}
	
	
//////////////////////////////////////////6.device;///////////////////////////////////////////////
	//6.和设备信息表交互
	//6.1 判断条件
	//6.2 插入记录
//////////////////////////////////////////
	//echo "设备信息表记录";
		$sql_query="SELECT * FROM device WHERE SN='".$SN."' ";
		$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0)
		{
			//echo "协议主表有记录";
			//若协议存在，则不作任何操作
			//$resultJson = array("state"=>1,"insert"=>"Already","SQL"=>$sql_query);//json格式的数组
		}
		else
		{
				$sql_query = "INSERT INTO device (SN,LocalName,IndustryType,Address,Longtitude,Latitude,ThirdUsrTime,DevType)VALUES('$SN','$LocalName','$LocalType','$Addr','$Lng','$Lat',now(),'$DevType')";
				
				if(mysql_query($sql_query))
				{
				//ECHO "OK";
				//	$resultJson = array("state"=>1,"insert"=>"ok","SQL"=>$sql_query);//json格式的数组
				}
				else
				{
					//设备信息表插入失败
						$resultJson = array("state"=>5);//json格式的数组
				} 
		}

 ///////////////////////////////////////////7.device_verify////////////////////////////////////////////
		$sql_query="SELECT * FROM device_verify WHERE SN='".$SN."'  ";
		$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0)
		{
				$sql_query = "UPDATE  device_verify SET Protocol = '".$Prot."' WHERE SN = '".$SN."' ";
				if(mysql_query($sql_query))
				{
					
				}
				else {
					$resultJson = array("state"=>7);//json格式的数组
					
				}
		} 
		
 /////////////////////////////////////////////////////////////////////////////////////////////////////
	echo urldecode(json_encode($resultJson));//Json格式输出
?>