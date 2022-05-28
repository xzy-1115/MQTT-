<?php
include_once ("../connect.php");
$username = $_POST['username'];
$sql_query="SELECT * FROM use_login WHERE   UserName = '".$username."' ";
$result_set=mysql_query($sql_query);
		if(mysql_num_rows($result_set)>0){
			
			$resultJson = array("state"=>6);//json格式的数组
		}
		else $resultJson = array("state"=>200);//json格式的数组
		echo urldecode(json_encode($resultJson));//Json格式输出
			

?>