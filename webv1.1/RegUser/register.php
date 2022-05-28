<?php
include_once("../db/conn.php");			//数据库连接
$USERNAME = $_POST['USERNAME'];					//用户名
$PASSWD = $_POST['PASSWD'];	                         
$PASSWDV=$_POST['PASSWDV'];
$USERTYPE =2;					
$EMAIL = $_POST['EMAIL'];	                        
$ADDRESS=$_POST['ADDRESS'];
$PHONE = $_POST['PHONE'];				
$INDUSTRYTYPE = $_POST['INDUSTRYTYPE'];	                     

$sql_query="SELECT * FROM use_login WHERE UserName='".$USERNAME."'  ";
$result_set=mysql_query($sql_query);

if(mysql_num_rows($result_set)>0)
{
	$resultJson = array("state"=>0);//这个用户名已经被使用过
}
else{
	if($PASSWD!=$PASSWDV)
	{
		$resultJson = array("state"=>1);//您两次输入的密码不相同
	}
	else{
		 $sql_query="INSERT INTO  use_login (UserName, Password , Role, Company , Phone , Email, IndustyType) 
		 VALUES ('".$USERNAME."','".$PASSWD."','".$USERTYPE."','".$ADDRESS."','".$PHONE."','".$EMAIL."','".$INDUSTRYTYPE."')";
		  if(mysql_query($sql_query)){
             $resultJson = array("state"=>200);
		  }
		  else $resultJson = array("state"=>2);
				/* if(mysql_query($sql_query))
				{            $resultJson = array("state"=>200);
					
							 if($USERTYPE==2){
									$sql_query="INSERT INTO  user2_info (UserName,Company,Phone,Email,IndustyType) VALUES ('".$USERNAME."','".$ADDRESS."','".$PHONE."','".$EMAIL."','".$INDUSTRYTYPE."')";
									if(mysql_query($sql_query))
									{
										$resultJson = array("state"=>200);
									}
									else $resultJson = array("state"=>2);
							 } 
							 else if($USERTYPE==3){
									$sql_query="INSERT INTO  user3_info (UserName,Company,Phone,Email,IndustyType) VALUES ('".$USERNAME."','".$ADDRESS."','".$PHONE."','".$EMAIL."','".$INDUSTRYTYPE."')";
									if(mysql_query($sql_query))
									{
										$resultJson = array("state"=>200);
									}
									else $resultJson = array("state"=>2);
							 }
					 }
				else $resultJson = array("state"=>2); */
	}
}
echo urldecode(json_encode($resultJson));//Json格式输出
?>