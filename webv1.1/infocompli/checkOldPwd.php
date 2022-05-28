<?php
header ( "Content-type:text/html;charset=utf-8");
include_once ("../connect.php");
session_start();

$oldPwd=$_POST["OLDPWD"];
$USERNAME=$_SESSION['UserName'];


$sql_oldpwd="select * from  use_login  where UserName='".$USERNAME."'"; 
$result_oldpwd=mysql_query($sql_oldpwd);
$row_oldpwd=mysql_fetch_assoc($result_oldpwd);
if($row_oldpwd['Password']==$oldPwd)
{
	$resultJson = array('state'=>200);
}else
{
	$resultJson = array('state'=>2);
}

echo urldecode(json_encode($resultJson));//Json格式输出
?>