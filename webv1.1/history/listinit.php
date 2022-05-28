<?php

include_once ("connect.php");
$SN=$_POST['SN'];

$item=0;
//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$SN."' and Time>DATE_SUB(CURDATE(), INTERVAL 3 MONTH)" ;
$result_set=mysql_query($sql_query);

$strArray=0;
$i;
$temp;

while ($row = mysql_fetch_array($result_set, MYSQL_ASSOC))
{	
	if($strArray){
		$strArray .="_";
		$strArray .=$row['Data'];
		$strArray .="_";
		$strArray .=$row['Time'];
	}
	else { 
		$strArray = $row['Data'];
		$strArray .="_";
		$strArray .=$row['Time'];
	} 
	$item="时间";

	$temp=explode("_",$row['Data']);
	for($i=0;$i<(count($temp)-2)/2;$i++)
	{
		if($item){
		$item .="_";
		$item .=$temp[$i*2+2];
		}
		else { 
			$item = $temp[$i*2+2];
		} 
	}
}



$resultJson = array("state"=>$strArray,"item"=>$item);//json格式的数组
//$resultJson = array("state"=>$SN);//json格式的数组
echo urldecode(json_encode($resultJson));//Json格式输出

?>




