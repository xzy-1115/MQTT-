<?php session_start();?>
<?php
//用户登录

include_once("./db/conn.php");			//数据库连接
$USERNAME = $_POST['USERNAME'];					//用户名
$PASSWD = $_POST['PASSWD'];	                          //密码
$Role;
$sql_query="SELECT * FROM use_login WHERE UserName='".$USERNAME."' and Password='".$PASSWD."' ";

$result_set=mysql_query($sql_query);
 $result=mysql_fetch_assoc($result_set);
 $Role= $result[Role];
if(mysql_num_rows($result_set)>0)
{
	$_SESSION['UserName']=$USERNAME;
	$sql_queryx = "INSERT INTO log (UserName,Operate,Time) VALUES ('".$USERNAME."','登录',now())";
    mysql_query($sql_queryx);
	$resultJson = array("state"=>200,"role"=>$Role);
}
else $resultJson = array("state"=>1,"role"=>$Role);
//$Role=$result[Role];
//$resultJson = array("role"=>$Role);
echo urldecode(json_encode($resultJson));//Json格式输出
?>