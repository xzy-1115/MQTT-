<?php
//1.查询SN与校验码 
//返回1:SN、设备校验码匹配且未超时
//返回2:SN、设备校验码匹配但超时
//返回3:SN、设备校验码不匹配

//当1查询SN与校验码 返回的是1时
//2.查询设备表
//返回1：设备存在，则返回设备的其他信息，
//返回0：设备不存在，则为新注册

//当2.查询设备表 返回的是1时
//3.查询设备协议表
//返回1：设备存在，且协议匹配
//返回0：设备存在，且协议不匹配

//存在的bug
//验证时间有待商榷
//用户和设备的关系的确定还没定
//


	include_once("../db/conn.php");
	$startTime;
	session_start();
	$username=$_SESSION['UserName'];
	$SN = $_POST['SN'];					//设备序列号
	$CheckCode = $_POST['CHECKCODE'];	//设备验证码
	$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
	$sql_query="SELECT * FROM dev_verify WHERE SN='".$SN."' and CheckCode ='".$CheckCode."' order by Time desc";
	$result_set=mysql_query($sql_query);

	if(mysql_num_rows($result_set)>0)
	{
		//1.查到数据
		$row=mysql_fetch_row($result_set);
		//提取发布验证码的时间和设备协议
		$DevPro = $row[2];	
		$ValidTime = $row[3];
		//echo "验证码时间".$row[3]."<br>"; 			
		if(strtotime($startTime)<strtotime($ValidTime))
		{   
			//2.验证码未超时
			//echo "正常";
/////////////////////

////////////////////			
			
			$sql_query="SELECT * FROM device WHERE SN='".$SN."'";
			$result_set=mysql_query($sql_query);
//////////////////////////////////////////////////////////////			
			if(mysql_num_rows($result_set)>0)//设备表中有这个设备
			{	
				$sql_query_user="SELECT * FROM user_device WHERE SN='".$SN."' and  UseFlag = 1 ";
				$result_set_user=mysql_query($sql_query_user);
				if(mysql_num_rows($result_set_user)>0)//用户和设备是绑定的
				{
					//1、用户名和设备绑定，表中有这个设备但是协议需要匹配
				    //2、用户名和设备绑定，表中有这个设备但是协议不需要匹配
					$row=mysql_fetch_row($result_set);
					//3=>现场名称
					//4=>现场类型
					//5=>地址
					$LocalName = $row[3];	
					$LocalType = $row[4];
					$LocalAddr = $row[5];
					$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and Protocol ='".$DevPro."' and UseFlag = 1 ";			
					$result_set=mysql_query($sql_query);
					if(mysql_num_rows($result_set)>0)
					{
						 $sql_query="SELECT * FROM device WHERE SN='".$SN."'";
						 $result_set=mysql_query($sql_query);
						 $result_row=mysql_fetch_array($result_set);
						 
						//设备存在，用户设备已绑定，协议不需要更新
						$resultJson = array("state"=>21,"LocalName"=>$result_row[LocalName],"LocalType"=>$result_row[IndustryType],"LocalAddr"=>$result_row[Address],"ProtocolUpdata"=>"0");//json格式的数组
					}
					else
					{
						 $sql_query="SELECT * FROM device WHERE SN='".$SN."'";
						 $result_set=mysql_query($sql_query);
						 $result_row=mysql_fetch_array($result_set);
						//设备存在，用户设备已绑定，协议需要更新
						$resultJson = array("state"=>22,"LocalName"=>$result_row[LocalName],"LocalType"=>$result_row[IndustryType],"LocalAddr"=>$result_row[Address],"ProtocolUpdata"=>"1");//json格式的数组
					}
				}
				else $resultJson = array("state"=>6);//json格式的数组
				/*else//用户和设备不是绑定的状态或者说用户和设备的启用标志不是1
				{
					//3、用户名和设备没有绑定，表中有这个设备但是协议需要匹配
					//4、用户名和设备没有绑定，表中有这个设备但是协议不需要匹配
					$row=mysql_fetch_row($result_set);
					//3=>现场名称
					//4=>现场类型
					//5=>地址
					$LocalName = $row[3];	
					$LocalType = $row[4];
					$LocalAddr = $row[5];
					//设备存在，有可能在这个人的名下，有可能不在这个人的名下
					$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and Protocol ='".$DevPro."' and UseFlag = 1 ";			
					$result_set=mysql_query($sql_query);
					if(mysql_num_rows($result_set)>0)
					{
						 $sql_query="SELECT * FROM device WHERE SN='".$SN."'";
						 $result_set=mysql_query($sql_query);
						 $result_row=mysql_fetch_array($result_set);
						 
						//设备存在，用户设备没有绑定，协议不需要更新
						$resultJson = array("state"=>23,"LocalName"=>$result_row[LocalName],"LocalType"=>$result_row[IndustryType],"LocalAddr"=>$result_row[Address],"ProtocolUpdata"=>"0");//json格式的数组
					}
					else
					{
						 $sql_query="SELECT * FROM device WHERE SN='".$SN."'";
						 $result_set=mysql_query($sql_query);
						 $result_row=mysql_fetch_array($result_set);
						//设备存在，用户设备没有绑定，协议需要更新
						$resultJson = array("state"=>24,"LocalName"=>$result_row[LocalName],"LocalType"=>$result_row[IndustryType],"LocalAddr"=>$result_row[Address],"ProtocolUpdata"=>"1");//json格式的数组
					}
				}*/
			}
			else//没有这个设备
			{
				$resultJson = array("state"=>1);//设备初始注册 新注册
			}		
		}
		else
		{
			//3.验证码超时
			$resultJson = array("state"=>3);//json格式的数组
		}
	}
	else
	{
		$resultJson = array("state"=>4);//json格式的数组
	}
	echo urldecode(json_encode($resultJson));//Json格式输出
?>