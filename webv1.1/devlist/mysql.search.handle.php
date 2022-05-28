<?php
//查找数据库
session_start();
require_once('../connect.php');
//////
$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));

////
//读取旧信息
$UserName = $_SESSION['UserName'];
//$device_type = $_GET['device_type'];
//$device_type = "HMI";
//echo $type;
mysql_query("set names 'utf8'");//设置编码，解决乱码问题
$query = mysql_query("select * from user_device where UserName='$UserName'");
//$data = mysql_fetch_assoc($query);//获取关联数组

$arr = array();//创建一个数组
$status = array();//创建一个数组
$i=0;
$count;
$runstr;
if($query&&mysql_num_rows($query)){
    while($row = mysql_fetch_assoc($query)){
        $data[] = $row;//数组负责
		$resultx = mysql_query("SELECT * from device where SN = '".$row['SN']."' ");
        $rowx = mysql_fetch_array($resultx, MYSQL_ASSOC);
        $count = $rowx['DevType'];
		$arr[$i]=$count;
		
		/////测是否在线/////
		$sql_queryt="SELECT * FROM device_online_list WHERE SN='".$row['SN']."'  order by Time desc limit 1";
		$result_sett=mysql_query($sql_queryt);
		$resultt=mysql_fetch_assoc($result_sett);
		if(mysql_num_rows($result_sett)>0)
		{	
			if(strtotime($startTime)<strtotime($resultt['Time']))
			{   
		            $runstr=1;
			}
			else $runstr=0;
		}else $runstr=0;
		//////////////////////
		$status[$i++]=$runstr;
    }
	
    $resultJson = array("state"=>200, "result"=>$data,"Typedev"=>$arr,"devstatus"=>$status);//json格式的数组
    echo urldecode(json_encode($resultJson));//Json格式输出
}  else {
    $resultJson = array("state"=>0);
    echo urldecode(json_encode($resultJson));
}

//while($row = mysql_fetch_array($query)) {//以数组形式返回每一行
////            echo $row['title'] . "," . $row['img']. "," . $row['content']. "," . $row['time'];
//    array_push($arr, array("title"=>urlencode($row['title']),"img"=>urlencode($row['img']),"dateline"=>urlencode($row['dateline'])));
//}
//$resultJson = array("state"=>200, "result"=>$arr);//json格式的数组
//
//echo urldecode(json_encode($resultJson));//Json格式输出

?>