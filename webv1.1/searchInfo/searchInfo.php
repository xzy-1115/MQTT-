<?php
header("Content-Type:text/html;charset=utf-8");
include "conn.php";
mysql_query("set names utf8");
$searchType=$_POST["choose"];
//$searchType=1;
//$searchType=2;
$keyWord=$_POST["value"];
//$keyWord="123";
//设备信息
$Devstr;//设备名称
$DevLongstr;//设备经度
$DevLastr;//设备纬度
$DevLocalNamestr;//设备现场名称
$DevIndusTypestr;//设备工业类型
$DevAddrstr;//设备地址
$DevTypestr;//设备型号
//用户信息
$Userstr;//用户名称
$UserLong;//用户经度
$UserLa;//用户纬度
$UserRole;//用户角色
$UserCompanystr;//用户所属公司
$UserPhone;//用户电话
$UserEmail;//用户邮箱
$UserAddrstr;//用户地址
$UserIndusTypestr;//用户工业类型
$UserRealNamestr;//用户真实姓名
$resultJson;//json数据
if($searchType==1)
{
	if($keyWord==NULL)
	{
		$Devsql="select * from device";//从设备表中查设备信息
		$Devresult=mysql_query($Devsql);
		//$rowDev=mysql_fetch_assoc($Devresult);
		while ($rowDev=mysql_fetch_assoc($Devresult)) 
		{
			if($Devstr)
			{
				$Devstr=$Devstr.'_';
				$Devstr=$Devstr.$rowDev['SN'];
				$DevLongstr=$DevLongstr.'_';
				$DevLongstr=$DevLongstr.$rowDev['Longtitude'];
				$DevLastr=$DevLastr.'_';
				$DevLastr=$DevLastr.$rowDev['Latitude'];

				$DevLocalNamestr=$DevLocalNamestr.'_';
				$DevLocalNamestr=$DevLocalNamestr.$rowDev['LocalName'];
				$DevIndusTypestr=$DevIndusTypestr.'_';
				$DevIndusTypestr=$DevIndusTypestr.$rowDev['IndustryType'];
				$DevAddrstr=$DevAddrstr.'_';
				$DevAddrstr=$DevAddrstr.$rowDev['Address'];
				$DevTypestr=$DevTypestr.'_';
				$DevTypestr=$DevTypestr.$rowDev['DevType'];
			}else
			{
				$Devstr=$Devstr.$rowDev['SN'];
				$DevLongstr=$DevLongstr.$rowDev['Longtitude'];
				$DevLastr=$DevLastr.$rowDev['Latitude'];
				$DevLocalNamestr=$DevLocalNamestr.$rowDev['LocalName'];
				$DevIndusTypestr=$DevIndusTypestr.$rowDev['IndustryType'];
				$DevAddrstr=$DevAddrstr.$rowDev['Address'];
				$DevTypestr=$DevTypestr.$rowDev['DevType'];
			}
		}		
	}else{
		$Devsql="select * from device where SN=$keyWord";//从设备表中查设备信息
		$Devresult=mysql_query($Devsql);
		$rowDev=mysql_fetch_assoc($Devresult);
		$Devstr=$Devstr.$rowDev['SN'];
		if($Devstr){
			$DevLongstr=$DevLongstr.$rowDev['Longtitude'];
			$DevLastr=$DevLastr.$rowDev['Latitude'];
			$DevLocalNamestr=$DevLocalNamestr.$rowDev['LocalName'];
			$DevIndusTypestr=$DevIndusTypestr.$rowDev['IndustryType'];
			$DevAddrstr=$DevAddrstr.$rowDev['Address'];
			$DevTypestr=$DevTypestr.$rowDev['DevType'];
		}else{
			$Devstr="error";//如果数据库中无与输入的关键字相匹配的内容，则返回error给前台
		}		
	}
	$resultJson=array(
		"Devstr"=>$Devstr,
		"DevLong"=>$DevLongstr,
		"DevLa"=>$DevLastr,
		"DevLocalName"=>$DevLocalNamestr,
		"DevIndusType"=>$DevIndusTypestr,
		"DevAddr"=>$DevAddrstr,
		"DevType"=>$DevTypestr		
	);
	echo urldecode(json_encode($resultJson));
}
else if($searchType==2)
{
	if($keyWord== NULL)
	{
		$Usersql="select * from use_login";//从用户表中查二级用户信息
		$Userresult=mysql_query($Usersql);
		while ($rowUser=mysql_fetch_assoc($Userresult)) 
		{
			if($Userstr)
			{
				$Userstr=$Userstr.'_';
				$Userstr=$Userstr.$rowUser['UserName'];
				$UserLong=$UserLong.'_';
				$UserLong=$UserLong.$rowUser['Longtitude'];
				$UserLa=$UserLa.'_';
				$UserLa=$UserLa.$rowUser['Latitude'];
				$UserRole=$UserRole.'_';
				$UserRole=$UserRole.$rowUser['Role'];//用户角色
				$UserCompanystr=$UserCompanystr.'_';
				$UserCompanystr=$UserCompanystr.$rowUser['Company'];//用户所属公司
				$UserPhone=$UserPhone.'_';
				$UserPhone=$UserPhone.$rowUser['Phone'];//用户电话
				$UserEmail=$UserEmail.'_';
				$UserEmail=$UserEmail.$rowUser['Email'];//用户邮箱
				$UserAddrstr=$UserAddrstr.'_';
				$UserAddrstr=$UserAddrstr.$rowUser['Address'];//用户地址
				$UserIndusTypestr=$UserIndusTypestr.'_';	
				$UserIndusTypestr=$UserIndusTypestr.$rowUser['IndustyType'];//用户工业类型
				$UserRealNamestr=$UserRealNamestr.'_';
				$UserRealNamestr=$UserRealNamestr.$rowUser['Name'];//用户真实姓名

			}else
			{
				$Userstr=$Userstr.$rowUser['UserName'];
				$UserLong=$UserLong.$rowUser['Longtitude'];
				$UserLa=$UserLa.$rowUser['Latitude'];
				$UserRole=$UserRole.$rowUser['Role'];//用户角色
				$UserCompanystr=$UserCompanystr.$rowUser['Company'];//用户所属公司
				$UserPhone=$UserPhone.$rowUser['Phone'];//用户电话
				$UserEmail=$UserEmail.$rowUser['Email'];//用户邮箱
				$UserAddrstr=$UserAddrstr.$rowUser['Address'];//用户地址
				$UserIndusTypestr=$UserIndusTypestr.$rowUser['IndustyType'];//用户工业类型
				$UserRealNamestr=$UserRealNamestr.$rowUser['Name'];//用户真实姓名
			}
		}
	}
	 else
	{	
		$Usersql="select * from use_login where UserName='".$keyWord."'";//从用户表中查二级用户信息
		$Userresult=mysql_query($Usersql);
		$rowUser=mysql_fetch_assoc($Userresult);
		$Userstr=$Userstr.$rowUser['UserName'];
		if($Userstr)
		{
			$UserLong=$UserLong.$rowUser['Longtitude'];
			$UserLa=$UserLa.$rowUser['Latitude'];
			$UserRole=$UserRole.$rowUser['Role'];//用户角色
			$UserCompanystr=$UserCompanystr.$rowUser['Company'];//用户所属公司
			$UserPhone=$UserPhone.$rowUser['Phone'];//用户电话
			$UserEmail=$UserEmail.$rowUser['Email'];//用户邮箱
			$UserAddrstr=$UserAddrstr.$rowUser['Address'];//用户地址
			$UserIndusTypestr=$UserIndusTypestr.$rowUser['IndustyType'];//用户工业类型
			$UserRealNamestr=$UserRealNamestr.$rowUser['Name'];//用户真实姓名
		}else
		{
			$Userstr="error";
			$UserLong="error";
			$UserLa="error";
		}
	}	
	$resultJson=array(
		"Userstr"=>$Userstr,
		"UserLong"=>$UserLong,
		"UserLa"=>$UserLa,
		"UserRole"=>$UserRole,
		"UserCompany"=>$UserCompanystr,
		"UserPhone"=>$UserPhone,
		"UserEmail"=>$UserEmail,
		"UserAddr"=>$UserAddrstr,
		"UserIndusType"=>$UserIndusTypestr,
		"UserRealName"=>$UserRealNamestr
	);
	echo urldecode(json_encode($resultJson));
}


//$resultJson=array("SNstr"=>12,"Userstr"=>9);
//$resultJson = array("SNstr"=>3333333, "Userstr"=>33);
//echo urldecode(json_encode($resultJson));
//echo urldecode(json_encode($resultJson));//json格式输出
?>