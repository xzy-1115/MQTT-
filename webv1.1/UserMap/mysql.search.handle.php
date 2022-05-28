<?php
//session_start();
//查找数据库
header ( "Content-type:text/html;charset=utf-8" );
include "conn.php";
mysql_query("set names utf8");
//读取旧信息
$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
//$UserName = $_SESSION['UserName'];
$sql = "select * from use_login where UserName!='".hubu."'and Role=3";//查用户信息表里的数据
$result_set = mysql_query($sql);
//$snstr=0;
$longsStr;
$laStr;
$userNameStr;
$userDevNum=0;
$userDevNumCnt;
$userCompanyStr;
$userPhone;
$userEmail;
$userAddrStr;
$userIndusTypeStr;
$userRealNameStr;
	while($row=mysql_fetch_array($result_set)){	
		$userDevNumCnt=0; //清空上一个用户的设备数量计数
		$Usersql="select * from user_device where UserName='".$row['UserName']."'";
		$Userresult=mysql_query($Usersql);
		while ($rowUser=mysql_fetch_assoc($Userresult)) {
				$userDevNumCnt=$userDevNumCnt+1;//计算每个用户拥有的设备数量
			}	
		if($userNameStr){
		$userNameStr=$userNameStr.'_';
		$userNameStr=$userNameStr.$row['UserName'];
		$longstr=$longstr.'_';
		$longstr=$longstr.$row['Longtitude'];
		$lastr=$lastr.'_';
		$lastr=$lastr.$row['Latitude'];
		$userDevNum=$userDevNum.'_';
		$userDevNum=$userDevNum.$userDevNumCnt;
		$userCompanyStr=$userCompanyStr.'_';
		$userCompanyStr=$userCompanyStr.$row['Company'];
		$userPhone=$userPhone.'_';
		$userPhone=$userPhone.$row['Phone'];
		$userEmail=$userEmail.'_';
		$userEmail=$userEmail.$row['Email'];
		$userAddrStr=$userAddrStr.'_';
		$userAddrStr=$userAddrStr.$row['Address'];
		$userIndusTypeStr=$userIndusTypeStr.'_';
		$userIndusTypeStr=$userIndusTypeStr.$row['IndustyType'];
		$userRealNameStr=$userRealNameStr.'_';
		$userRealNameStr=$userRealNameStr.$row['Name'];
		}else{
			$userNameStr=$row['UserName'];
			$longstr=$row['Longtitude'];
			$lastr=$row['Latitude'];
			$userDevNum=$userDevNumCnt.null;
			$userCompanyStr=$userCompanyStr.$row['Company'];
			$userPhone=$userPhone.$row['Phone'];
			$userEmail=$userEmail.$row['Email'];
			$userAddrStr=$userAddrStr.$row['Address'];
			$userIndusTypeStr=$userIndusTypeStr.$row['IndustyType'];
			$userRealNameStr=$userRealNameStr.$row['Name'];
		}
	}

$resultJson = array(
					"UserName"=>$userNameStr, 
					"Long"=>$longstr,
					"La"=>$lastr,
					"UserCompany"=>$userCompanyStr,
					"UserDevNum"=>$userDevNum,
					"UserPhone"=>$userPhone,
					"UserEmail"=>$userEmail,
					"UserAddr"=>$userAddrStr,
					"UserIndusType"=>$userIndusTypeStr,
					"UserRealName"=>$userRealNameStr

					);//json格式的数组


echo urldecode(json_encode($resultJson));//Json格式输出 */


?>