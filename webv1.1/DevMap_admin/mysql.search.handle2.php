<?php
//查找数据库
header ( "Content-type:text/html;charset=utf-8" );
include "conn.php";
mysql_query("set names utf8");
//读取旧信息
$startTime = date("Y-m-d H:i:s", strtotime('-300 minutes', time()));
$snstr;
$longstr;
$lastr;
$statusstr;
$runstr;
$sql = "select * from device";
$resultDev = mysql_query($sql);
while ($rowDev=mysql_fetch_assoc($resultDev)) {
	$sqlSta="select * from device_online_list where SN='".$rowDev['SN']."'";
	$resultSta=mysql_query($sqlSta);
	$rowSta=mysql_fetch_assoc($resultSta);
	if($rowSta)
	{	
		if(strtotime($startTime)<strtotime($rowSta['Time']))
		{   
	            $runstr=1;
		}
		else $runstr=0;
	}else $runstr=0;//设备状态

	if ($snstr) {
	 		$snstr = $snstr.'_';
	 		$snstr = $snstr.$rowDev['SN'];
	 		$longstr = $longstr.'_';
	 		$longstr = $longstr.$rowDev['Longtitude'];
	 		$lastr = $lastr.'_';
	 		$lastr = $lastr.$rowDev['Latitude'];
	 		$statusstr=$statusstr.'_';
			$statusstr=$statusstr.$runstr;
	 	} else{
	 		$snstr = $rowDev['SN'];
	 		$longstr = $rowDev['Longtitude'];
	 		$lastr = $rowDev['Latitude'];
	 		$statusstr=$statusstr.$runstr;
	 	}
}

$resultJson = array(
					"SNstr"=>$snstr,
					"Long"=>$longstr, 
					"La"=>$lastr,
					"Status"=>$statusstr
				);
 echo urldecode(json_encode($resultJson));

?>