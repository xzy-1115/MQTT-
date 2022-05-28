<?php
	session_start();
	$_SESSION['SN']=$_POST['SN'];
    $resultJson = array("state"=>1);
echo urldecode(json_encode($resultJson));//Json格式输出
?>


