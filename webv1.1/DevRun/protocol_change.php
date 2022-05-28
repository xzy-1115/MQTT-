<?php
//实时数据协议变动时用到的文件
session_start();
include_once("../connect.php");			//数据库连接
$PROTOCOLInfo = $_POST['PROTOCOL'];		//设备协议
$SN = $_POST['SN'];		//设备协议
$strArray = explode('_',$PROTOCOLInfo); 
$Prot = $strArray[0];
$DevType=$strArray[1];
$oldprot;
///////1.查老协议，有用就只是解绑，没用就全删
////1查protocol
$sql_query2="SELECT * from device_protocol where SN = '".$SN."' ";
$res2=mysql_query($sql_query2);
$row1=mysql_fetch_assoc($res2);
$oldprot=$row1[Protocol];
//2.删除行
$sql_query2="delete from device_protocol where SN = '".$SN."' ";
mysql_query($sql_query2);
//3.protocol查有没有
$sql_query2="SELECT * from device_protocol where Protocol = '".$oldprot."' ";
$res3=mysql_query($sql_query2);
if(mysql_num_rows($res3)>0)
{	

}
else {
			$sql_querydel="delete from protocol_master where Protocol = '".$oldprot."' ";
			mysql_query($sql_querydel);
			$sql_querydel="delete from protocol_detail where Protocol = '".$oldprot."' ";
			mysql_query($sql_querydel);
}

//删除rule
$sql_querydel="delete from realtime_rules where SN = '".$SN."' ";
		mysql_query($sql_querydel);
$Offset=1;
//////2.查新协议，要是有，就只是绑定，要是没有的话就插入
$sql_query2="SELECT * from protocol_detail where Protocol = '".$Prot."' ";
$resx=mysql_query($sql_query2);
if(mysql_num_rows($resx)>0)
{
	$sql_query = "INSERT INTO device_protocol (SN,Protocol,UseFlag,Updatetime) VALUES ('".$SN."','".$Prot."',1,now())";
			mysql_query($sql_query);
			for($index=2;$index<count($strArray);) 
			{ 
				$ItemName= $strArray[$index++];
				$ItemUnit= $strArray[$index++];
				$ItemType= $strArray[$index++];
				$ItemReadable= $strArray[$index++];
				$ItemWritable= $strArray[$index++];
				$ItemMin= $strArray[$index++];
				$ItemMax= $strArray[$index++];
			$Offset++;
			}
			$VMask = str_repeat("1",$Offset-1);
			$AMask = str_repeat("1",$Offset-1);
			$sql_query = "INSERT INTO realtime_rules (SN,Protocol,VMask,Time,AMask) VALUES('$SN','$Prot','".$VMask."',now(),'".$AMask."')";
				mysql_query($sql_query);
}
else {

		$sql_query = "INSERT INTO device_protocol (SN,Protocol,UseFlag,Updatetime) VALUES ('".$SN."','".$Prot."',1,now())";
			mysql_query($sql_query);
		$sql_query = "INSERT INTO protocol_master (Protocol,Note,Time) VALUES('$Prot','$PROTOCOLInfo',now())";
			mysql_query($sql_query);
		
			for($index=2;$index<count($strArray);) 
			{ 
				$ItemName= $strArray[$index++];
				$ItemUnit= $strArray[$index++];
				$ItemType= $strArray[$index++];
				$ItemReadable= $strArray[$index++];
				$ItemWritable= $strArray[$index++];
				$ItemMin= $strArray[$index++];
				$ItemMax= $strArray[$index++];
				$sql_query = "INSERT INTO protocol_detail (Protocol,Offset,ItemName,Max,Min,Unit,Type,Readable,Writable) VALUES('$Prot',$Offset,'$ItemName','$ItemMax','$ItemMin','$ItemUnit','$ItemType','$ItemReadable','$ItemWritable')";
			mysql_query($sql_query);	
			$Offset++;
			}
			$VMask = str_repeat("1",$Offset-1);
			$AMask = str_repeat("1",$Offset-1);
			$sql_query = "INSERT INTO realtime_rules (SN,Protocol,VMask,Time,AMask) VALUES('$SN','$Prot','".$VMask."',now(),'".$AMask."')";
				mysql_query($sql_query);
}
//加rule
			
////////////3.不管协议怎样，历史数据是不能留的/////
$sql_querydel="delete from device_data_save where SN = '".$SN."' ";
		mysql_query($sql_querydel);
////////////4.工作完成准备退出/////////////////
$resultJson = array("state"=>200,"pro"=>$Prot);//json格式的数组
echo urldecode(json_encode($resultJson));//Json格式输出
?>